<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Devis;
use App\Models\Plan;
use App\Models\Rdv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuperadminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:Super Admin']);
    }

    public function index()
    {
        $rdvCount = Rdv::count();
        $contactCount = Contact::count();
        $devisCount = Devis::count();

        $latestRdvs = Rdv::latest()->paginate(5, ['*'], 'rdvs_page');
        $latestContacts = Contact::latest()->paginate(5, ['*'], 'contacts_page');
        $latestDevis = Devis::latest()->paginate(5, ['*'], 'devis_page');

        // Example calculations (adjust based on your logic)
        $activeUsersCount = User::where('is_active', true)->count();
        $conversionRate = Devis::where('statut', 'accepted')->count() / max($devisCount, 1) * 100;
        $avgResponseTime = Rdv::whereNotNull('updated_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)) as avg_time'))
            ->value('avg_time') ?? 0;
        $satisfactionRate = 85; // Placeholder, replace with actual logic

        return view('admin.index', compact(
            'rdvCount',
            'contactCount',
            'devisCount',
            'latestRdvs',
            'latestContacts',
            'latestDevis',
            'activeUsersCount',
            'conversionRate',
            'avgResponseTime',
            'satisfactionRate'
        ));
    }
}
