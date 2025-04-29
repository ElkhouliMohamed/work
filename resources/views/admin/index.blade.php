@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Tableau de Bord</h1>
            <p class="text-gray-600 mt-2">Bienvenue ! Voici un résumé de votre système.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- RDVs Card -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total des Rendez-vous</p>
                        <h2 class="mt-1 text-3xl font-semibold text-gray-800">{{ $rdvCount }}</h2>
                        <p class="mt-1 text-sm text-gray-500">Derniers 30 jours</p>
                    </div>
                    <div class="bg-indigo-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Contacts Card -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total des Contacts</p>
                        <h2 class="mt-1 text-3xl font-semibold text-gray-800">{{ $contactCount }}</h2>
                        <p class="mt-1 text-sm text-gray-500">Derniers 30 jours</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Devis Card -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 transition-all hover:shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total des Devis</p>
                        <h2 class="mt-1 text-3xl font-semibold text-gray-800">{{ $devisCount }}</h2>
                        <p class="mt-1 text-sm text-gray-500">Derniers 30 jours</p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent RDVs -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">Rendez-vous Récents</h2>
                        <a href="{{ route('rdvs.index') }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Voir Tous</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($latestRdvs as $rdv)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $rdv->contact->prenom }} {{ $rdv->contact->nom }} - {{
                                    \App\Models\Rdv::getTypeOptions()[$rdv->type] ?? $rdv->type }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1">
                                    <span class="inline-flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \App\Helpers\AppHelper::formatDate($rdv->date) }}
                                    </span>
                                </p>
                            </div>
                            <span
                                class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $rdv->statut === 'confirmed' ? 'bg-green-100 text-green-800' : ($rdv->statut === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ \App\Models\Rdv::getStatusOptions()[$rdv->statut] ?? $rdv->statut }}
                            </span>
                        </div>
                        @if($rdv->notes)
                        <p class="mt-2 text-sm text-gray-600">{{ Str::limit($rdv->notes, 60) }}</p>
                        @endif
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <p class="mt-2 text-sm">Aucun rendez-vous récent trouvé</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Contacts -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">Contacts Récents</h2>
                        <a href="{{ route('contacts.index') }}"
                            class="text-sm font-medium text-blue-600 hover:text-blue-500">Voir Tous</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($latestContacts as $contact)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">{{
                                        \App\Helpers\AppHelper::initials($contact->prenom . ' ' . $contact->nom)
                                        }}</span>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="font-medium text-gray-800">{{ $contact->prenom }} {{ $contact->nom }}</p>
                                    <span class="text-xs text-gray-500">{{ $contact->created_at->diffForHumans()
                                        }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $contact->email }}</p>
                                @if($contact->nom_entreprise)
                                <p class="mt-2 text-sm text-gray-600">{{ $contact->nom_entreprise }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="mt-2 text-sm">Aucun contact récent trouvé</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Additional Stats Section -->
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-800">Statistiques du Système</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                <!-- Active Users -->
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Utilisateurs Actifs</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800">{{ $activeUsersCount }}</p>
                    <p class="mt-1 text-xs text-green-600 font-medium">+12% par rapport au dernier mois</p>
                </div>
                <!-- Conversion Rate -->
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Taux de Conversion</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($conversionRate, 1) }}%</p>
                    <p class="mt-1 text-xs text-red-600 font-medium">-0.5% par rapport au dernier mois</p>
                </div>
                <!-- Average Response Time -->
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Temps de Réponse Moyen</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($avgResponseTime, 1) }}h</p>
                    <p class="mt-1 text-xs text-green-600 font-medium">-15% par rapport au dernier mois</p>
                </div>
                <!-- Satisfaction Rate -->
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500">Taux de Satisfaction</p>
                    <p class="mt-1 text-2xl font-semibold text-gray-800">{{ $satisfactionRate }}%</p>
                    <p class="mt-1 text-xs text-green-600 font-medium">+2% par rapport au dernier mois</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection