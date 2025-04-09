<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Devis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommissionRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

class CommissionController extends Controller
{
    const COMMISSION_LEVELS = [
        'Bronze' => ['min_contracts' => 1, 'max_contracts' => 10, 'fixed_amount' => 500],
        'Silver' => ['min_contracts' => 11, 'max_contracts' => 20, 'fixed_amount' => 1000],
        'Gold' => ['min_contracts' => 21, 'max_contracts' => 30, 'fixed_amount' => 1500],
        'Platinum' => ['min_contracts' => 31, 'fixed_amount' => 2000]
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Freelancer', ['only' => ['create', 'store', 'show', 'requestPayment', 'requestAllPayments']]);
        $this->middleware('role:Account Manager|Admin', ['only' => ['approve', 'clearCommission']]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 10);

        $query = Commission::with('devis', 'freelancer');

        if ($user->hasRole('Freelancer')) {
            $query->where('freelancer_id', $user->id);
            $query->orderBy('created_at', 'desc');
        } elseif ($user->hasRole('Account Manager')) {
            $query->orderByRaw('demande_paiement DESC, created_at DESC');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        if ($request->has('status')) {
            $query->where('statut', $request->status);
        }

        $contractCount = DB::table('commissions')
            ->where('freelancer_id', $user->id)
            ->where('statut', 'en attente')
            ->count();

        $sold = 0;
        $level = 'Bronze';

        if ($contractCount >= 1 && $contractCount <= 10) {
            $sold = $contractCount * 500;
            $level = 'Bronze';
        } elseif ($contractCount >= 11 && $contractCount <= 20) {
            $sold = $contractCount * 1000;
            $level = 'Argent';
        } elseif ($contractCount >= 21 && $contractCount <= 30) {
            $sold = $contractCount * 1500;
            $level = 'Or';
        } elseif ($contractCount >= 31) {
            $sold = $contractCount * 2000;
            $level = 'Platine';
        }

        $commissions = $query->paginate($perPage);
        $stats = $this->getCommissionStats($commissions);

        // Add freelancers for Account Manager
        $freelancers = $user->hasRole('Account Manager') ? User::role('Freelancer')->get() : [];

        return view('commissions.index', compact('commissions', 'stats', 'sold', 'level', 'contractCount', 'freelancers'));
    }

    public function requestAllPayments(Request $request)
    {
        $user = auth()->user();

        $commissions = Commission::where('freelancer_id', $user->id)
            ->where('statut', 'En Attente')
            ->get();

        if ($commissions->isEmpty()) {
            return redirect()->back()->with('warning', 'No pending commissions found.');
        }

        foreach ($commissions as $commission) {
            $commission->update([
                'demande_paiement' => true,
            ]);
        }

        return redirect()->back()->with('success', 'Toutes les commissions en attente ont été demandées pour paiement.');
    }

    public function approve_payment(Commission $commission)
    {
        if (!auth()->user()->hasRole(['Account Manager', 'Admin', 'Super Admin'])) {
            abort(403, 'Unauthorized access.');
        }

        if ($commission->statut !== 'en attente' || !$commission->demande_paiement) {
            return redirect()->back()->with('error', 'This commission cannot be approved.');
        }

        $commission->update([
            'statut' => 'payé',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        Log::channel('commissions')->notice('Commission approved', [
            'id' => $commission->id,
            'approver' => auth()->user()->name,
            'amount' => $commission->montant,
        ]);

        return redirect()->back()->with('success', 'Payment approved successfully.');
    }

    // Include approveAllPayments if you want bulk approval
    public function approveAllPayments(Request $request)
    {
        if (!auth()->user()->hasRole(['Account Manager', 'Admin', 'Super Admin'])) {
            abort(403, 'Unauthorized access.');
        }

        $commissions = Commission::where('demande_paiement', true)
            ->where('statut', 'En Attente')
            ->get();

        if ($commissions->isEmpty()) {
            return redirect()->back()->with('warning', 'No commissions requested for payment found.');
        }

        $approver = auth()->user();

        foreach ($commissions as $commission) {
            $commission->update([
                'statut' => 'payé',
                'approved_by' => $approver->id,
                'approved_at' => now(),
            ]);

            Log::channel('commissions')->notice('Commission approved', [
                'id' => $commission->id,
                'approver' => $approver->name,
                'amount' => $commission->montant,
            ]);
        }

        return redirect()->back()->with('success', 'All payment requests have been approved successfully.');
    }


    public function create()
    {
        $freelancerId = Auth::id();
        $contractCount = $this->getValidContractCount();
        $currentLevel = $this->getCommissionLevel($contractCount);
        $totalEarnings = Commission::where('freelancer_id', $freelancerId)->where('statut', 'Payé')->sum('montant');

        return view('commissions.create', compact('contractCount', 'currentLevel', 'totalEarnings'));
    }

    public function store(Request $request)
    {
        $freelancerId = Auth::id();
        $contractCount = $this->getValidContractCount();
        $commissionLevel = $this->getCommissionLevel($contractCount);

        if (!$commissionLevel) {
            return back()->with('error', 'Conditions non remplies pour demander une commission.');
        }

        $commission = Commission::create([
            'freelancer_id' => $freelancerId,
            'montant' => $commissionLevel['fixed_amount'] * $contractCount,
            'description' => "Commission {$commissionLevel['name']} - {$contractCount} contrats",
            'statut' => 'En Attente',
            'niveau' => $commissionLevel['name'],
            'nombre_contrats' => $contractCount,
            'month' => Carbon::now()->format('Y-m'),
        ]);

        Log::channel('commissions')->info('Nouvelle commission créée', [
            'id' => $commission->id,
            'freelancer' => Auth::user()->name,
            'montant' => $commission->montant,
            'contrats' => $contractCount,
        ]);

        return redirect()->route('commissions.index')
            ->with('success', 'Demande de commission enregistrée avec succès.');
    }
    public function requestPayment(Commission $commission)
    {
        if (!Auth::user()->hasRole('Freelancer') || $commission->freelancer_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($commission->statut !== 'En Attente') {
            return back()->with('error', 'This commission cannot be requested for payment.');
        }

        $accountManagers = User::role('Account Manager')->get();
        if ($accountManagers->isEmpty()) {
            return back()->with('error', 'No account managers found.');
        }

        // Generate PDF invoice
        $pdf = PDF::loadView('commissions.payment_request_pdf', [
            'commission' => $commission,
            'user' => Auth::user()
        ]);

        $pdfPath = storage_path("app/public/payment_requests/commission_{$commission->id}.pdf");
        $pdf->save($pdfPath);

        // Update commission status to "Payment Requested"
        $commission->update([
            'statut' => 'Payment Requested',
            'payment_requested_at' => now(),
            'payment_request_pdf' => "payment_requests/commission_{$commission->id}.pdf"
        ]);

        // Send email to all account managers
        foreach ($accountManagers as $manager) {
            Mail::to($manager->email)->send(new CommissionPaymentRequest($commission, Auth::user(), $pdfPath));
        }

        Log::channel('commissions')->info('Payment requested', [
            'commission_id' => $commission->id,
            'freelancer' => Auth::user()->name,
            'managers_notified' => $accountManagers->count()
        ]);

        return redirect()->route('commissions.index')
            ->with('success', 'Payment request sent successfully to account managers.');
    }

    public function processPayment(Request $request, Commission $commission)
    {
        if (!Auth::user()->hasRole(['Account Manager', 'Admin'])) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate([
            'payment_date' => 'required|date|after_or_equal:today',
            'payment_method' => 'required|string|in:Bank Transfer,Check,Online Payment',
            'payment_proof' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        // Store payment proof
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update commission status
        $commission->update([
            'statut' => 'Payé',
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'payment_proof_path' => $proofPath,
            'payment_notes' => $request->notes,
            'processed_by' => Auth::id(),
            'processed_at' => now()
        ]);

        // Generate payment confirmation PDF
        $confirmationPdf = PDF::loadView('commissions.payment_confirmation_pdf', [
            'commission' => $commission,
            'processor' => Auth::user()
        ]);

        $confirmationPath = storage_path("app/public/payment_confirmations/commission_{$commission->id}.pdf");
        $confirmationPdf->save($confirmationPath);

        // Send confirmation to freelancer
        Mail::to($commission->freelancer->email)->send(
            new \App\Mail\CommissionPaymentConfirmation($commission, $confirmationPath)
        );

        Log::channel('commissions')->notice('Commission paid', [
            'commission_id' => $commission->id,
            'amount' => $commission->montant,
            'processed_by' => Auth::user()->name
        ]);

        return redirect()->route('commissions.index')
            ->with('success', 'Payment processed successfully and confirmation sent to freelancer.');
    }



    public function approve(Request $request, Commission $commission)
    {
        if (!Auth::user()->hasRole(['Account Manager', 'Admin', 'Super Admin'])) {
            abort(403, 'Accès non autorisé.');
        }

        $request->validate([
            'payment_date' => 'required|date|after_or_equal:now',
            'proof' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($request->hasFile('proof')) {
            $filename = \Str::uuid() . '.' . $request->file('proof')->extension();
            $path = $request->file('proof')->storeAs('payment_proofs', $filename, 'public');
            $commission->update(['payment_proof_path' => $path]);
        }

        $commission->update([
            'statut' => 'Payé',
            'payment_date' => $request->payment_date,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        Log::channel('commissions')->notice('Commission approuvée', [
            'id' => $commission->id,
            'approbateur' => Auth::user()->name,
            'montant' => $commission->montant,
        ]);

        return redirect()->route('commissions.index')
            ->with('success', 'Paiement confirmé avec succès.');
    }

    public function clearCommission(Commission $commission)
    {
        if (!Auth::user()->hasRole(['Account Manager', 'Admin'])) {
            abort(403, 'Accès non autorisé.');
        }

        if ($commission->statut !== 'Payé') {
            return back()->with('error', 'Seule une commission payée peut être effacée.');
        }

        $commission->delete();

        return redirect()->route('commissions.index')
            ->with('success', 'Commission effacée et ligne supprimée avec succès.');
    }

    public function show(Commission $commission)
    {
        if (!Auth::user()->hasRole('Freelancer') || $commission->freelancer_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        return view('commissions.show', compact('commission'));
    }

    private function getCommissionStats($commissions)
    {
        $currentLevel = null;
        $totalEarnings = 0;
        $totalContracts = $commissions->sum('nombre_contrats');

        if (Auth::user()->hasRole('Freelancer')) {
            $contractCount = $this->getValidContractCount();
            $currentLevel = $this->getCommissionLevel($contractCount);
            $totalEarnings = Commission::where('freelancer_id', Auth::id())->where('statut', 'Payé')->sum('montant');
        } else {
            $totalEarnings = $commissions->where('statut', 'Payé')->sum('montant');
        }

        return [
            'total_amount' => $commissions->sum('montant'),
            'pending' => $commissions->where('statut', 'En Attente')->count(),
            'paid' => $commissions->where('statut', 'Payé')->count(),
            'average_amount' => $commissions->avg('montant'),
            'total_contracts' => $totalContracts,
            'current_level' => $currentLevel ? $currentLevel['name'] : 'N/A',
            'total_earnings' => $totalEarnings,
        ];
    }

    private function getValidContractCount(): int
    {
        return Devis::where('freelancer_id', Auth::id())
            ->whereIn('statut', ['validé', 'Accepté'])
            ->where('compte_pour_commission', true)
            ->count();
    }

    private function getCommissionLevel(int $contractCount): ?array
    {
        foreach (self::COMMISSION_LEVELS as $name => $level) {
            $minCondition = $contractCount >= $level['min_contracts'];
            $maxCondition = !isset($level['max_contracts']) || $contractCount <= $level['max_contracts'];

            if ($minCondition && $maxCondition) {
                return ['name' => $name] + $level;
            }
        }
        return null;
    }


    private function getValidContractCountForFreelancer($freelancerId): int
    {
        return Devis::where('freelancer_id', $freelancerId)
            ->whereIn('statut', ['validé', 'Accepté'])
            ->where('compte_pour_commission', true)
            ->count();
    }
    public function showFreelancerPayments(Request $request, $freelancerId)
    {
        if (!Auth::user()->hasRole(['Account Manager'])) {
            abort(403, 'Unauthorized access.');
        }

        $freelancer = User::findOrFail($freelancerId);
        $perPage = $request->input('per_page', 10);

        $query = Commission::with('devis', 'freelancer')
            ->where('freelancer_id', $freelancerId)
            ->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('statut', $request->status);
        }

        $commissions = $query->paginate($perPage);
        $stats = $this->getCommissionStats($commissions);

        // Calculate total earnings for display
        $sold = Commission::where('freelancer_id', $freelancerId)
            ->where('statut', 'Payé')
            ->sum('montant');

        // Level calculation could be reused from getCommissionLevel if needed
        $contractCount = Devis::where('freelancer_id', $freelancerId)
            ->whereIn('statut', ['validé', 'Accepté'])
            ->where('compte_pour_commission', true)
            ->count();

        $level = $this->getCommissionLevel($contractCount)['name'] ?? 'Bronze';

        return view('commissions.freelancer_payments', compact('commissions', 'stats', 'sold', 'level', 'freelancer'));
    }
}
