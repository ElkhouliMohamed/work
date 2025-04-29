@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tableau de Bord</h1>
            <p class="text-gray-600 mt-2">Bienvenue, <span class="font-medium text-gray-800">{{ Auth::user()->name
                    }}</span>! Voici votre aperçu.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 shadow-sm">
                <i class="fas fa-user-shield mr-2"></i>
                {{ ucfirst(Auth::user()->roles->first()->name) }}
            </span>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @if (Auth::user()->hasRole('Freelancer'))
        <!-- Freelancer Cards -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600 shadow-inner">
                    <i class="fas fa-address-book text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Contacts</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['contacts'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1 tracking-wide">Contacts actifs</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('contacts.index') }}"
                    class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center">
                    Voir tous <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-green-50 text-green-600 shadow-inner">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Rendez-vous</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['rdvs'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1 tracking-wide">
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full">{{
                            $data['upcoming_rdvs'] ?? 0 }} à venir</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('rdvs.index') }}"
                    class="text-xs font-medium text-green-600 hover:text-green-800 flex items-center">
                    Voir agenda <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-amber-50 text-amber-600 shadow-inner">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Devis</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['devis'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1 space-x-1">
                        <span class="inline-block bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">{{
                            $data['draft_devis'] ?? 0 }} brouillons</span>
                        <span class="inline-block bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full">{{
                            $data['sent_devis'] ?? 0 }} envoyés</span>
                    </div>
                </div>
            </div>

        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-red-50 text-red-600 shadow-inner">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Commissions</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($data['total_commissions'] ?? 0, 2) }}
                        MAD</p>
                    <div class="text-xs text-gray-500 mt-1 space-x-1">
                        <span class="inline-block bg-red-100 text-red-800 px-2 py-0.5 rounded-full">{{
                            $data['pending_commissions'] ?? 0 }} en attente</span>
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full">{{
                            $data['approved_commissions'] ?? 0 }} validées</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('commissions.index') }}"
                    class="text-xs font-medium text-red-600 hover:text-red-800 flex items-center">
                    Voir détails <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-purple-50 text-purple-600 shadow-inner">
                    <i class="fas fa-file-contract text-xl"></i>
                </div>

            </div>
        </div>

        @elseif (Auth::user()->hasRole('Account Manager'))
        <!-- Account Manager Cards -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-green-50 text-green-600 shadow-inner">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Rendez-vous</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['rdvs'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full">{{
                            $data['today_rdvs'] ?? 0 }} aujourd'hui</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('rdvs.index') }}"
                    class="text-xs font-medium text-green-600 hover:text-green-800 flex items-center">
                    Voir agenda <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-amber-50 text-amber-600 shadow-inner">
                    <i class="fas fa-file-invoice-dollar text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Devis</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['devis'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1 space-x-1">
                        <span class="inline-block bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">{{
                            $data['pending_devis'] ?? 0 }} en attente</span>
                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">{{
                            $data['converted_devis'] ?? 0 }} convertis</span>
                    </div>
                </div>
            </div>

        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-red-50 text-red-600 shadow-inner">
                    <i class="fas fa-hand-holding-usd text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Commissions</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['pending_commissions'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1 tracking-wide">En attente d'approbation</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('commissions.index') }}"
                    class="text-xs font-medium text-red-600 hover:text-red-800 flex items-center">
                    Approuver <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        @else
        <!-- Admin/Super Admin Cards -->
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600 shadow-inner">
                    <i class="fas fa-users-cog text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Utilisateurs</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['users'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1 space-x-1">
                        <span class="inline-block bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full">{{
                            $data['active_users'] ?? 0 }} actifs</span>
                        <span class="inline-block bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full">{{
                            $data['new_users'] ?? 0 }} nouveaux</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('users.index') }}"
                    class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                    Gérer les utilisateurs <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600 shadow-inner">
                    <i class="fas fa-address-book text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Contacts</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['contacts'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1 tracking-wide">Contacts enregistrés</p>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('contacts.index') }}"
                    class="text-xs font-medium text-blue-600 hover:text-blue-800 flex items-center">
                    Voir tous <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-green-50 text-green-600 shadow-inner">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Rendez-vous</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['rdvs'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1">
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full">{{
                            $data['completed_rdvs'] ?? 0 }} complétés</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('rdvs.index') }}"
                    class="text-xs font-medium text-green-600 hover:text-green-800 flex items-center">
                    Voir agenda <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-amber-50 text-amber-600 shadow-inner">
                    <i class="fas fa-file-signature text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Devis</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ $data['devis'] ?? 0 }}</p>
                    <div class="text-xs text-gray-500 mt-1 space-x-1">
                        <span class="inline-block bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">{{
                            $data['pending_devis'] ?? 0 }} en attente</span>
                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">{{
                            $data['converted_devis'] ?? 0 }} convertis</span>
                    </div>
                </div>
            </div>

        </div>

        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-red-50 text-red-600 shadow-inner">
                    <i class="fas fa-money-check-alt text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">Commissions</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($data['total_commissions'] ?? 0, 2) }}
                        MAD</p>
                    <div class="text-xs text-gray-500 mt-1 space-x-1">
                        <span class="inline-block bg-red-100 text-red-800 px-2 py-0.5 rounded-full">{{
                            $data['pending_commissions'] ?? 0 }} en attente</span>
                        <span class="inline-block bg-green-100 text-green-800 px-2 py-0.5 rounded-full">{{
                            $data['approved_commissions'] ?? 0 }} payées</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100">
                <a href="{{ route('commissions.index') }}"
                    class="text-xs font-medium text-red-600 hover:text-red-800 flex items-center">
                    Voir détails <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>


        @endif
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Activité Récente</h2>
                <div class="relative">
                    <select
                        class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-1 px-3 pr-8 rounded-full text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <option>7 derniers jours</option>
                        <option>30 derniers jours</option>
                        <option>90 derniers jours</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="activityChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Répartition</h2>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800 hover:bg-indigo-200 transition-colors">
                        Par catégorie
                    </button>
                    <button
                        class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                        Par statut
                    </button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="distributionChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Activités Récentes</h2>
            <div class="space-y-4">
                @foreach($recentActivities as $activity)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-1">
                        <div class="h-8 w-8 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <i class="{{ $activity['icon'] }} text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                        <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                    </div>
                    @if(isset($activity['action']))
                    <div class="flex-shrink-0">
                        <a href="{{ $activity['action_url'] }}"
                            class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                            {{ $activity['action'] }}
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 inline-flex items-center">
                    Voir toutes les activités <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Statut du Système</h2>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Espace disque</span>
                        <span class="text-gray-500">{{ $systemStatus['disk_used'] }} / {{ $systemStatus['disk_total']
                            }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ $systemStatus['disk_percent'] }}%">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Utilisation mémoire</span>
                        <span class="text-gray-500">{{ $systemStatus['memory_used'] }} / {{
                            $systemStatus['memory_total'] }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $systemStatus['memory_percent'] }}%">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">Charge CPU</span>
                        <span class="text-gray-500">{{ $systemStatus['cpu_load'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $systemStatus['cpu_load'] }}%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-100">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Dernière sauvegarde</h3>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="far fa-clock mr-2"></i>
                    <span>{{ $systemStatus['last_backup'] ?? 'Jamais' }}</span>
                </div>
                <button
                    class="mt-4 w-full bg-indigo-50 hover:bg-indigo-100 text-indigo-700 py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-database mr-2"></i> Sauvegarder maintenant
                </button>
            </div>
        </div>
    </div>

    <div class="space-y-4 mt-2">
        @foreach($plans as $plan)
        <div
            class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-start space-x-4">
                <div class="p-3 rounded-lg bg-blue-50 text-blue-600 shadow-inner">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-1">{{ $plan->name }}</h2>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($plan->price, 2) }} MAD</p>
                    <div class="text-sm text-gray-500 mt-1">
                        {{ $plan->description }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activity Chart (Line)
        const activityCtx = document.getElementById('activityChart').getContext('2d');
        const activityChart = new Chart(activityCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Contacts',
                    data: [12, 19, 3, 5, 2, 3, 15],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.05)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2
                }, {
                    label: 'RDVs',
                    data: [5, 8, 12, 6, 9, 4, 7],
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2
                }, {
                    label: 'Devis',
                    data: [3, 7, 5, 11, 6, 8, 10],
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.05)',
                    tension: 0.3,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 11 },
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: true,
                        intersect: false,
                        mode: 'index'
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6B7280' }
                    },
                    y: {
                        grid: { color: '#F3F4F6', drawBorder: false },
                        ticks: { color: '#6B7280' },
                        beginAtZero: true
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // Distribution Chart (Doughnut)
        const distributionCtx = document.getElementById('distributionChart').getContext('2d');
        const distributionChart = new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Contacts', 'RDVs', 'Devis', 'Commissions'],
                datasets: [{
                    data: [35, 25, 20, 20],
                    backgroundColor: [
                        '#4F46E5',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444'
                    ],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        bodyFont: { size: 11 },
                        padding: 8,
                        cornerRadius: 6,
                        displayColors: false
                    }
                }
            }
        });

        // Period selector functionality
        document.querySelectorAll('[data-period]').forEach(button => {
            button.addEventListener('click', function() {
                // This would be replaced with actual data fetching logic
                console.log(`Period changed to ${this.dataset.period}`);
            });
        });
    });
</script>
@endsection