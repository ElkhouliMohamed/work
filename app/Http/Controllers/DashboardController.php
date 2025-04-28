<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Rdv;
use App\Models\Devis;
use App\Models\Plan;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensures only authenticated users can access
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 10); // For pagination if needed

        // Initialize variables
        $data = [];
        $recentActivities = [];
        $systemStatus = [];
        $commissions = [];
        $stats = [];
        $sold = 0;
        $level = 'Bronze';
        $contractCount = 0;
        $freelancers = [];
        $abonnements = [];
        $plans = Plan::all();

        // Commission Query
        $commissionQuery = Commission::with('devis', 'freelancer');

        // Role-based filtering for commissions
        if ($user->hasRole('Freelancer')) {
            $commissionQuery->where('freelancer_id', $user->id);
            $commissionQuery->orderBy('created_at', 'desc');
        } elseif ($user->hasRole('Account Manager')) {
            $commissionQuery->orderByRaw('demande_paiement DESC, created_at DESC');
        } else { // Admin or Super Admin
            $commissionQuery->orderBy('created_at', 'desc');
        }

        // Filter by status if provided
        if ($request->has('status')) {
            $commissionQuery->where('statut', $request->status);
        }

        // Calculate contract count for commissions (only for Freelancers or relevant roles)
        $contractCount = DB::table('commissions')
            ->where('freelancer_id', $user->id)
            ->where('statut', 'en attente')
            ->count();

        // Calculate sold and level based on contract count
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

        // Paginate commissions
        $commissions = $commissionQuery->paginate($perPage);
        $stats = $this->getCommissionStats($commissions);

        // Add freelancers for Account Manager
        $freelancers = $user->hasRole('Account Manager') ? User::role('Freelancer')->get() : [];

        // Gather dashboard data based on user role
        if ($user->hasRole('Freelancer')) {
            $data['contacts'] = Contact::where('freelancer_id', $user->id)->count();
            $data['rdvs'] = Rdv::where('freelancer_id', $user->id)
                ->whereIn('statut', ['planifié', 'confirmé'])
                ->count();
            $data['devis'] = Devis::where('freelancer_id', $user->id)->count();
            $data['draft_devis'] = Devis::where('freelancer_id', $user->id)
                ->where('statut', 'Brouillon')
                ->count();
            $data['sent_devis'] = Devis::where('freelancer_id', $user->id)
                ->whereIn('statut', ['Envoyé', 'Accepté'])
                ->count();
            $data['total_commissions'] = Commission::where('freelancer_id', $user->id)->sum('montant');
            $data['pending_commissions'] = $contractCount;
            $data['approved_commissions'] = Commission::where('freelancer_id', $user->id)
                ->whereIn('statut', ['validé', 'payé'])
                ->count();

            // Recent Activities for Freelancer
            $recentActivities = [
                [
                    'title' => 'Nouveau contact ajouté',
                    'description' => 'Un nouveau contact a été ajouté.',
                    'time' => Carbon::now()->subHours(2)->format('d/m/Y H:i'),
                    'icon' => 'fas fa-address-book',
                    'action' => 'Voir',
                    'action_url' => route('contacts.index'),
                ],
                [
                    'title' => 'Rendez-vous planifié',
                    'description' => 'Un rendez-vous a été planifié.',
                    'time' => Carbon::now()->subHours(1)->format('d/m/Y H:i'),
                    'icon' => 'fas fa-calendar-check',
                    'action' => 'Détails',
                    'action_url' => route('rdvs.index'),
                ],
                [
                    'title' => 'Commission en attente',
                    'description' => "Vous avez {$contractCount} commissions en attente.",
                    'time' => Carbon::now()->format('d/m/Y H:i'),
                    'icon' => 'fas fa-money-bill-wave',
                    'action' => 'Vérifier',
                    'action_url' => route('commissions.index'),
                ],
            ];
        } elseif ($user->hasRole('Account Manager')) {
            $data['rdvs'] = Rdv::where('manager_id', $user->id)->count();
            $data['devis'] = Devis::whereIn('rdv_id', Rdv::where('manager_id', $user->id)->pluck('id'))->count();
            $data['pending_devis'] = Devis::whereIn('rdv_id', Rdv::where('manager_id', $user->id)->pluck('id'))
                ->where('statut', 'Brouillon')
                ->count();
            $data['converted_devis'] = Devis::whereIn('rdv_id', Rdv::where('manager_id', $user->id)->pluck('id'))
                ->where('statut', 'Accepté')
                ->count();
            $data['pending_commissions'] = Commission::where('statut', 'en attente')->count();

            // Recent Activities for Account Manager
            $recentActivities = [
                [
                    'title' => 'Nouveau devis en attente',
                    'description' => 'Un devis nécessite votre approbation.',
                    'time' => Carbon::now()->subHours(3)->format('d/m/Y H:i'),
                    'icon' => 'fas fa-file-alt',
                    'action' => 'Approuver',
                    'action_url' => route('devis.index'),
                ],
                [
                    'title' => 'Rendez-vous confirmé',
                    'description' => 'Un rendez-vous a été confirmé.',
                    'time' => Carbon::now()->subHours(2)->format('d/m/Y H:i'),
                    'icon' => 'fas fa-calendar-check',
                    'action' => 'Voir',
                    'action_url' => route('rdvs.index'),
                ],
                [
                    'title' => 'Commissions à approuver',
                    'description' => "Vous avez {$data['pending_commissions']} commissions en attente.",
                    'time' => Carbon::now()->format('d/m/Y H:i'),
                    'icon' => 'fas fa-hand-holding-usd',
                    'action' => 'Approuver',
                    'action_url' => route('commissions.index'),
                ],
            ];
        } else { // Admin or Super Admin
            $data['users'] = User::count();
            $data['contacts'] = Contact::count();
            $data['rdvs'] = Rdv::count();
            $data['devis'] = Devis::count();
            $data['total_commissions'] = Commission::sum('montant');
            $data['pending_commissions'] = Commission::where('statut', 'en attente')->count();
            $data['approved_commissions'] = Commission::whereIn('statut', ['validé', 'payé'])->count();

            // Recent Activities for Admin
            $recentActivities = [
                [
                    'title' => 'Nouvel utilisateur inscrit',
                    'description' => 'Un nouvel utilisateur s’est inscrit.',
                    'time' => Carbon::now()->subHours(4)->format('d/m/Y H:i'),
                    'icon' => 'fas fa-user-plus',
                    'action' => 'Gérer',
                    'action_url' => route('users.index'),
                ],
                [
                    'title' => 'Devis accepté',
                    'description' => 'Un devis a été accepté.',
                    'time' => Carbon::now()->subHours(3)->format('d/m/Y H:i'),
                    'icon' => 'fas fa-file-signature',
                    'action' => 'Détails',
                    'action_url' => route('devis.index'),
                ],
                [
                    'title' => 'Commissions en attente',
                    'description' => "Il y a {$data['pending_commissions']} commissions en attente.",
                    'time' => Carbon::now()->format('d/m/Y H:i'),
                    'icon' => 'fas fa-money-check-alt',
                    'action' => 'Vérifier',
                    'action_url' => route('commissions.index'),
                ],
            ];
        }

        // System Status (mock data; replace with real values if needed)
        $systemStatus = [
            'disk_used' => '50GB',
            'disk_total' => '200GB',
            'disk_percent' => 25,
            'memory_used' => '4GB',
            'memory_total' => '16GB',
            'memory_percent' => 25,
            'cpu_load' => 30,
            'last_backup' => Carbon::now()->subDays(1)->format('d/m/Y H:i'),
        ];

        // Pass all variables to the dashboard view
        return view('dashboard', compact(
            'data',
            'recentActivities',
            'systemStatus',
            'commissions',
            'stats',
            'sold',
            'level',
            'contractCount',
            'freelancers',
            'plans'
        ));
    }

    private function getCommissionStats($commissions)
    {
        return [
            'total' => $commissions->total(),
            'pending' => $commissions->where('statut', 'en attente')->count(),
            'approved' => $commissions->whereIn('statut', ['validé', 'payé'])->count(),
            'rejected' => $commissions->where('statut', 'rejeté')->count(),
        ];
    }
}
