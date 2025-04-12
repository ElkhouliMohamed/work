<?php

namespace App\Http\Controllers;

use App\Models\Rdv;
use App\Models\Plan;
use App\Models\Contact;
use App\Models\Devis;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\AssignedToRdv;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RdvUpdated;
use App\Notifications\RdvCancelled;
use App\Notifications\RdvConfirmed;
use App\Notifications\RdvCompleted;

class RdvController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Freelancer|Account Manager|Admin|Super Admin');
    }

    /**
     * Display a listing of the RDVs for the authenticated user.
     */
    public function index()
    {
        $status = request('status', 'all');
        $type = request('type', '');
        $search = request('search', '');

        $query = Rdv::query()
            ->with(['contact', 'freelancer', 'manager', 'devis'])
            ->when($status !== 'all', function ($q) use ($status) {
                return $q->where('statut', $status);
            })
            ->when($type, function ($q) use ($type) {
                return $q->where('type', $type);
            })
            ->when($search, function ($q) use ($search) {
                return $q->where(function ($query) use ($search) {
                    $query->where('notes', 'like', "%{$search}%")
                        ->orWhereHas('contact', function ($q) use ($search) {
                            $q->where('prenom', 'like', "%{$search}%")
                                ->orWhere('nom', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when(auth()->user()->hasRole('Freelancer'), function ($q) {
                return $q->where('freelancer_id', auth()->id());
            })
            ->when(auth()->user()->hasRole('Account Manager'), function ($q) {
                return $q->where('manager_id', auth()->id());
            })
            ->orderBy('date', 'desc');

        $rdvs = $query->paginate(10);

        $totalCount = Rdv::count();
        $upcomingCount = Rdv::where('date', '>', now())->count();
        $confirmedCount = Rdv::where('statut', Rdv::STATUS_CONFIRMED)->count();
        $completedCount = Rdv::where('statut', Rdv::STATUS_COMPLETED)->count();
        $cancelledCount = Rdv::where('statut', Rdv::STATUS_CANCELLED)->count();

        // Pass status and type options to the view
        $statusOptions = Rdv::getStatusOptions();
        $typeOptions = Rdv::getTypeOptions();

        return view('rdvs.index', compact('rdvs', 'totalCount', 'upcomingCount', 'confirmedCount', 'completedCount', 'cancelledCount', 'status', 'type', 'search', 'statusOptions', 'typeOptions'));
    }
    /**
     * Show the form for creating a new RDV.
     */
    public function create()
    {
        $plans = Plan::all();
        $contacts = Contact::where('freelancer_id', auth()->id())
            ->active()
            ->get();

        return view('rdvs.create', [
            'contacts' => $contacts,
            'rdvTypes' => Rdv::getTypeOptions(), // Make sure this returns key=>value pairs
            'minDate' => now()->addDay()->format('Y-m-d'),
            'maxDate' => now()->addMonths(3)->format('Y-m-d'),
            'plans' => $plans,
        ]);
    }

    /**
     * Store a newly created RDV in storage.
     */
    public function store(Request $request)
    {
        $validTypes = Rdv::getTypeOptions();
        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'date' => 'required|date|after:now',
            'type' => 'required|string|in:' . implode(',', array_keys($validTypes)), // Validate against keys
            'notes' => 'nullable|string|max:500',
            'plans' => 'required|array|min:1',
            'plans.*' => 'exists:plans,id',
        ]);

        try {
            // Find available manager
            $manager = User::role('Account Manager')
                ->inRandomOrder()
                ->firstOrFail();

            // Create RDV
            $rdv = Rdv::create([
                'contact_id' => $validated['contact_id'],
                'freelancer_id' => auth()->id(),
                'manager_id' => $manager->id,
                'date' => $validated['date'],
                'type' => $validated['type'],
                'notes' => $validated['notes'] ?? null,
                'statut' => Rdv::STATUS_PLANNED,
            ]);

            // Attach plans
            $rdv->plans()->attach($validated['plans']);

            // Send notification (queued)
            $manager->notify((new AssignedToRdv($rdv))->delay(now()->addSeconds(5)));

            return response()->json([
                'success' => true,
                'redirect' => route('rdvs.index')
            ]);
        } catch (\Exception $e) {
            Log::error('RDV creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Display the specified RDV.
     */
    public function show(Rdv $rdv)
    {
        return view('rdvs.show', [
            'rdv' => $rdv->load(['contact', 'freelancer', 'manager', 'devis']),
        ]);
    }

    /**
     * Show the form for editing the specified RDV.
     */
    public function edit(Rdv $rdv)
    {
        Gate::authorize('update', $rdv);

        $contacts = Contact::where('freelancer_id', auth()->id())
            ->active()
            ->get();

        $plans = Plan::all();

        return view('rdvs.edit', [
            'rdv' => $rdv,
            'contacts' => $contacts,
            'rdvTypes' => Rdv::getTypeOptions(),
            'statusOptions' => Rdv::getStatusOptions(),
            'minDate' => now()->addDay()->format('Y-m-d'),
            'maxDate' => now()->addMonths(3)->format('Y-m-d'),
            'plans' => $plans,
        ]);
    }

    /**
     * Update the specified RDV in storage.
     */
    public function update(Request $request, Rdv $rdv)
    {
        Gate::authorize('update', $rdv);

        $validated = $request->validate([
            'contact_id' => 'required|exists:contacts,id,freelancer_id,' . auth()->id(),
            'date' => 'required|date|after:now|before:' . now()->addMonths(3),
            'type' => 'required|in:' . implode(',', Rdv::getTypeOptions()),
            'statut' => 'required|in:' . implode(',', Rdv::getStatusOptions()),
            'notes' => 'nullable|string|max:500',
            'location' => 'required_if:type,' . Rdv::TYPE_PHYSICAL . '|string|max:255',
        ]);

        $originalStatus = $rdv->statut;
        $rdv->update($validated);

        if ($originalStatus !== $rdv->statut) {
            $this->handleStatusChangeNotification($rdv, $originalStatus);
        } else {
            Notification::send([$rdv->manager, $rdv->freelancer], new RdvUpdated($rdv));
        }

        return redirect()->route('rdvs.index')
            ->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    /**
     * Cancel the specified RDV.
     */
    public function cancel(Rdv $rdv)
    {
        Gate::authorize('update', $rdv);

        if (!$rdv->canBeCancelled()) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $rdv->update(['statut' => Rdv::STATUS_CANCELLED]);

        Notification::send([$rdv->manager, $rdv->contact], new RdvCancelled($rdv));

        return redirect()->route('rdvs.index')
            ->with('success', 'Appointment cancelled successfully.');
    }

    /**
     * Remove the specified RDV from storage.
     */
    public function destroy(Rdv $rdv)
    {
        Gate::authorize('delete', $rdv);

        Log::info('Deleting RDV', ['rdv_id' => $rdv->id]);

        $rdv->delete();

        $remainingDevis = Devis::where('rdv_id', $rdv->id)->count();
        Log::info('Devis remaining after RDV deletion', ['count' => $remainingDevis]);

        return redirect()->route('rdvs.index')
            ->with('success', 'Rendez-vous supprimé avec succès.');
    }

    /**
     * Handle notifications for RDV status changes.
     */
    protected function handleStatusChangeNotification(Rdv $rdv, string $originalStatus): void
    {
        switch ($rdv->statut) {
            case Rdv::STATUS_CANCELLED:
                Notification::send([$rdv->manager, $rdv->contact], new RdvCancelled($rdv));
                break;

            case Rdv::STATUS_CONFIRMED:
                Notification::send([$rdv->freelancer, $rdv->manager], new RdvConfirmed($rdv));
                break;

            case Rdv::STATUS_COMPLETED:
                Notification::send([$rdv->manager], new RdvCompleted($rdv));
                break;

            default:
                Notification::send([$rdv->manager, $rdv->freelancer], new RdvUpdated($rdv));
        }
    }
}
