@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Gestion des Rendez-vous</h1>
            <div class="flex items-center mt-2">
                <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-sm text-gray-500">Gérez et suivez tous vos rendez-vous clients</p>
            </div>
        </div>
        <a href="{{ route('rdvs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nouveau Rendez-vous
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('rdvs.index') }}" class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" placeholder="Rechercher des rendez-vous..." 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" 
                           value="{{ request('search', '') }}">
                </div>
            </div>
            <div class="flex space-x-2">
                <select name="status" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Tous les statuts</option>
                    @foreach($statusOptions as $statusOption)
                        <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>{{ ucfirst($statusOption) }}</option>
                    @endforeach
                </select>
                <select name="type" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Tous les types</option>
                    @foreach($typeOptions as $typeKey => $typeValue)
                        <option value="{{ $typeKey }}" {{ $type === $typeKey ? 'selected' : '' }}>{{ $typeValue }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filtrer
                </button>
            </div>
        </div>
    </form>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="relative p-4 rounded-lg shadow-sm bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-500 overflow-hidden">
            <div class="text-sm font-medium text-blue-800">Total RDV</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalCount }}</div>
            <svg class="absolute right-4 top-4 h-8 w-8 text-blue-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        
        <div class="relative p-4 rounded-lg shadow-sm bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 overflow-hidden">
            <div class="text-sm font-medium text-green-800">À venir</div>
            <div class="text-2xl font-bold text-gray-800">{{ $upcomingCount }}</div>
            <svg class="absolute right-4 top-4 h-8 w-8 text-green-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <div class="relative p-4 rounded-lg shadow-sm bg-gradient-to-r from-purple-50 to-purple-100 border-l-4 border-purple-500 overflow-hidden">
            <div class="text-sm font-medium text-purple-800">Confirmés</div>
            <div class="text-2xl font-bold text-gray-800">{{ $confirmedCount }}</div>
            <svg class="absolute right-4 top-4 h-8 w-8 text-purple-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <div class="relative p-4 rounded-lg shadow-sm bg-gradient-to-r from-gray-50 to-gray-100 border-l-4 border-gray-500 overflow-hidden">
            <div class="text-sm font-medium text-gray-800">Terminés</div>
            <div class="text-2xl font-bold text-gray-800">{{ $completedCount }}</div>
            <svg class="absolute right-4 top-4 h-8 w-8 text-gray-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
    </div>

    <!-- RDVs Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Heure</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Devis</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rdvs as $rdv)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- Contact Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-medium">{{ substr($rdv->contact->prenom, 0, 1) }}{{ substr($rdv->contact->nom, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $rdv->contact->prenom }} {{ $rdv->contact->nom }}</div>
                                    <div class="text-xs text-gray-500">{{ $rdv->contact->email }}</div>
                                    <div class="text-xs text-gray-400 mt-1">
                                        <span class="inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            {{ $rdv->contact->telephone }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Date/Time Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $rdv->date->isToday() ? 'bg-blue-100 text-blue-800' : ($rdv->date->isPast() ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $rdv->date->format('d M') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $rdv->date->format('H:i') }}</div>
                                    <div class="text-xs text-gray-500">{{ $rdv->date->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Type Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $typeColors = [
                                    'Consultation' => 'bg-blue-100 text-blue-800',
                                    'Suivi' => 'bg-purple-100 text-purple-800',
                                    'Autre' => 'bg-gray-100 text-gray-800',
                                ];
                                $typeColor = $typeColors[$rdv->type] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $typeColor }}">
                                {{ $typeOptions[$rdv->type] ?? $rdv->type }}
                            </span>
                        </td>
                        
                        <!-- Status Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'planifié' => 'bg-blue-100 text-blue-800',
                                    'confirmé' => 'bg-green-100 text-green-800',
                                    'terminé' => 'bg-purple-100 text-purple-800',
                                    'annulé' => 'bg-red-100 text-red-800'
                                ];
                                $statusColor = $statusColors[strtolower($rdv->statut)] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ ucfirst($rdv->statut) }}
                            </span>
                        </td>
                        
                        <!-- Devis Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $devisCollection = $rdv->devis ?? collect();
                                if ($devisCollection instanceof \App\Models\Devis) {
                                    $devisCollection = collect([$devisCollection]);
                                }
                                $hasAcceptedDevis = $devisCollection->contains('statut', 'Accepté');
                            @endphp

                            @if($devisCollection->isNotEmpty())
                                @foreach($devisCollection as $devis)
                                <div class="devis-item text-xs flex items-center {{ $devis->statut == 'Accepté' ? 'text-green-600' : 'text-gray-600' }}">
                                    <span class="font-medium">{{ $devis->statut }}</span>
                                    <span class="text-xs ml-2">{{ number_format($devis->montant, 2) }} MAD</span>
                                </div>
                                @endforeach
                            @else
                                <span class="text-xs text-gray-500 italic">Aucun devis</span>
                            @endif
                        </td>
                        
                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex justify-end space-x-1">
                                <a href="{{ route('rdvs.show', $rdv->id) }}" 
                                   class="p-2 rounded-md inline-flex items-center justify-center bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors duration-200"
                                   title="Voir les détails">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                @role('Super Admin|Account Manager')
                                @if(!$hasAcceptedDevis)
                                <a href="{{ route('devis.create', ['rdvId' => $rdv->id]) }}" 
                                   class="p-2 rounded-md inline-flex items-center justify-center bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors duration-200"
                                   title="Créer un devis">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </a>
                                @endif
                                @endrole

                                @role('Freelancer|Super Admin')
                                @if(!$hasAcceptedDevis)
                                <a href="{{ route('rdvs.edit', $rdv->id) }}" 
                                   class="p-2 rounded-md inline-flex items-center justify-center bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors duration-200"
                                   title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('rdvs.destroy', $rdv->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 rounded-md inline-flex items-center justify-center bg-red-100 text-red-600 hover:bg-red-200 transition-colors duration-200"
                                            title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                @endrole
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun rendez-vous trouvé</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par créer un nouveau rendez-vous</p>
                            <div class="mt-6">
                                <a href="{{ route('rdvs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Planifier un RDV
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($rdvs->hasPages())
    <div class="mt-6 px-4">
        {{ $rdvs->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    const deleteForms = document.querySelectorAll('.delete-form');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Confirmer la suppression',
                text: "Cette action supprimera définitivement le rendez-vous. Voulez-vous continuer?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                focusCancel: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });

    // Show success message from session
    @if(session('success'))
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    
    Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
    })
    @endif
});
</script>
@endpush
@endsection