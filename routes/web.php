<?php

use App\Http\Controllers\{
    SuperadminController,
    Auth\AuthenticatedSessionController,
    Auth\RegisteredUserController,
    ContactController,
    RdvController,
    DevisController,
    CommissionController,
    AbonnementController,
    DashboardController,
    UserController,
    PlanController
};
use App\Models\Plan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store');
    });

    Route::controller(RegisteredUserController::class)->group(function () {
        Route::get('register', 'create')->name('register');
        Route::post('register', 'store');
    });
});

// Public Plans Page
Route::get('/plans', function () {
    return view('plans.index', [
        'plans' => Plan::with('features')->visible()->get()
    ]);
})->name('plans.index');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Common Logout Route
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Dashboard (role-specific views handled in controller)
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('commissions/{freelancerId}/payments', [CommissionController::class, 'showFreelancerPayments'])->name('commissions.freelancer_payments');

    /*
    |--------------------------------------------------------------------------
    | Resource Routes
    |--------------------------------------------------------------------------
    */

    // RDVs with explicit middleware
    Route::resource('rdvs', RdvController::class)
        ->middleware('can:viewAny,App\Models\Rdv');

    // Contacts with soft delete handling
    Route::resource('contacts', ContactController::class)
        ->except(['destroy']);

    Route::prefix('contacts')->group(function () {
        Route::delete('{contact}', [ContactController::class, 'destroy'])
            ->name('contacts.destroy')
            ->middleware('can:delete,contact');

        Route::put('{contact}/restore', [ContactController::class, 'restore'])
            ->name('contacts.restore')
            ->middleware('can:restore,contact');
    });

    // Revert to older Commission routes
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::get('/commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
    Route::post('/commissions', [CommissionController::class, 'store'])->name('commissions.store');
    Route::get('/commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');
    Route::post('/commissions/{commission}/request-payment', [CommissionController::class, 'requestPayment'])->name('commissions.requestPayment');
    Route::get('/commissions/request-all-payments', [CommissionController::class, 'requestAllPayments'])->name('commissions.request_all_payments');
    Route::get('/commissions/approve-all-payments', [CommissionController::class, 'approveAllPayments'])->name('commissions.approve_all_payments');

    // Freelancer-specific Commission routes
    Route::middleware(['role:Freelancer'])->group(function () {
        Route::get('/freelancer/dashboard', [DashboardController::class, 'index'])->name('freelancer.dashboard');
    });

    // Account Manager and Admin Routes for Commission Management
    Route::middleware(['role:Account Manager|Admin'])->group(function () {
        Route::prefix('commissions')->group(function () {
            Route::post('/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');
            Route::post('/{commission}/clear', [CommissionController::class, 'clearCommission'])->name('commissions.clearCommission');
            Route::post('/{commission}/approve-payment', [CommissionController::class, 'approve_payment'])->name('commissions.approve_payment');
        });
    });

    // Add this after the resource route for RDVs


    /*
    |--------------------------------------------------------------------------
    | Role-Specific Routes
    |--------------------------------------------------------------------------
    */

    // Account Manager Routes
    Route::middleware('role:Account Manager')->group(function () {
        // Devis routes with explicit parameter binding
        Route::resource('devis', DevisController::class)
            ->except(['create', 'show'])
            ->parameters(['devis' => 'devis:id']); // Example of route model binding

        Route::get('devis/create/{rdv}', [DevisController::class, 'create'])
            ->name('devis.create')
            ->middleware('can:create,App\Models\Devis');

        Route::put('devis/{devis}/validate', [DevisController::class, 'validateDevis'])
            ->name('devis.validate')
            ->middleware('can:validate,devis');
    });

    // Admin & Super Admin Routes
    Route::middleware('role:Admin|Super Admin')->group(function () {
        Route::resource('users', UserController::class)
            ->except(['show'])
            ->middleware('password.confirm'); // Sensitive operation

        Route::resource('plans', PlanController::class)
            ->middleware('can:manage,App\Models\Plan');
    });

    // Super Admin Exclusive Routes
    Route::middleware('role:Super Admin')->prefix('admin')->group(function () {
        Route::get('data', [SuperadminController::class, 'index'])
            ->name('admin.data');

        Route::resource('abonnements', AbonnementController::class)
            ->withTrashed(['show']);

        Route::put(
            'abonnements/{abonnement}/reset-commission',
            [AbonnementController::class, 'resetCommission']
        )
            ->name('abonnements.reset-commission');
    });
    //! jadid
    Route::patch('rdvs/{rdv}/cancel', [RdvController::class, 'cancel'])->name('rdvs.cancel')
        ->middleware('can:cancel,rdv');
    Route::patch('rdvs/{rdv}/complete', [RdvController::class, 'complete'])->name('rdvs.complete')
        ->middleware('can:complete,rdv');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Email verification, password reset, etc.)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
