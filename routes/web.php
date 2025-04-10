<?php

use App\Http\Controllers\SuperadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RdvController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlanController;
use App\Models\Plan;

// 🌍 Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

/**
 * 🔐 Authentication Routes
 * Routes accessible to guests only (unauthenticated users).
 */
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

/**
 * 💳 Public Plans Page
 * Display available subscription plans to all users.
 */
Route::get('/abonnements/plans', function () {
    $plans = Plan::all();
    return view('Abonnements.plans', compact('plans'));
})->name('abonnements.plans');

/**
 * ✅ Authenticated User Routes
 * Routes accessible only to authenticated users.
 */
Route::middleware(['auth'])->group(function () {
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    // Request payment for all commissions
    Route::get('/commissions/request-all-payments', [CommissionController::class, 'requestAllPayments'])->name('commissions.request_all_payments');

    Route::get('/commissions/approve-all-payments', [CommissionController::class, 'approveAllPayments'])->name('commissions.approve_all_payments');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Common Dashboard Route (requires email verification)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('verified');

    /**
     * ✅ Everyone can access RDVs and Contacts
     */
    Route::resource('rdvs', RdvController::class)->middleware('can:manage rdvs');
    Route::resource('contacts', ContactController::class)->except(['destroy']);
    Route::put('/contacts/restore/{contact}', [ContactController::class, 'restore'])->name('contacts.restore')->middleware('can:restore,contact');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy')->middleware('can:delete,contact');

    /**
     * 👤 Freelancer-only Routes
     */
    Route::middleware(['role:Freelancer'])->group(function () {
        Route::get('/freelancer/dashboard', [DashboardController::class, 'index'])->name('freelancer.dashboard');
        Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
        Route::get('/commissions/create', [CommissionController::class, 'create'])->name('commissions.create');
        Route::post('/commissions', [CommissionController::class, 'store'])->name('commissions.store');
        Route::get('/commissions/{commission}', [CommissionController::class, 'show'])->name('commissions.show');
        Route::post('/commissions/{commission}/request-payment', [CommissionController::class, 'requestPayment'])->name('commissions.requestPayment');
    });

    /**
     * 👤 Account Manager Routes
     */
    Route::middleware(['role:Account Manager'])->group(function () {
        Route::get('/account-manager/dashboard', [DashboardController::class, 'index'])->name('account_manager.dashboard');
        Route::get('/freelancers/{freelancerId}/payments', [CommissionController::class, 'showFreelancerPayments'])->name('commissions.freelancer_payments');
        Route::resource('devis', DevisController::class, ['parameters' => ['devis' => 'devis']])->except(['create', 'show']);
        Route::get('/devis/create/{rdvId}', [DevisController::class, 'create'])->name('devis.create');
        Route::get('/devis/{devis}', [DevisController::class, 'show'])->name('devis.show');
        Route::put('/devis/{devis}/validate', [DevisController::class, 'validateDevis'])->name('devis.validate');
    });



    /**
     * 👤 Account Manager and Admin Routes for Commission Management
     */
    Route::middleware(['role:Account Manager|Admin'])->group(function () {
        Route::prefix('commissions')->group(function () {
            Route::post('/{commission}/approve', [CommissionController::class, 'approve'])->name('commissions.approve');
            Route::post('/{commission}/clear', [CommissionController::class, 'clearCommission'])->name('commissions.clearCommission');
            Route::post('/{commission}/approve-payment', [CommissionController::class, 'approve_payment'])->name('commissions.approve_payment');
        });
    });

    /**
     * 👑 Super Admin Routes
     */
    Route::middleware(['role:Super Admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/data', [SuperadminController::class, 'index'])->name('admin.data');
        Route::resource('abonnements', AbonnementController::class);
        Route::get('/abonnements/active', [AbonnementController::class, 'active'])->name('abonnements.active');
        Route::put('/abonnements/{abonnement}/reset-commission', [AbonnementController::class, 'resetCommission'])->name('abonnements.reset-commission');
        Route::resource('users', UserController::class);
        Route::resource('plans', PlanController::class);
    });

    // General Commission Index Route
    Route::get('/commissions', [CommissionController::class, 'index'])->name('commissions.index');
});

require __DIR__ . '/auth.php';
