@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-extrabold text-gray-900 border-b-2 border-gray-200 pb-2">Gestion des Rendez-vous</h1>
        <a href="{{ route('rdvs.create') }}"
            class="bg-gray-800 text-white px-6 py-2 rounded-lg shadow-md hover:bg-gray-700 transition duration-200 ease-in-out transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
            Planifier un Rendez-vous
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
        <p class="font-bold">Succès</p>
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <!-- RDVs Table -->
    <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Statut RDV</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Devis Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($rdvs as $rdv)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $rdv->contact->nom }} {{ $rdv->contact->prenom }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $rdv->type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                        $statusColor = [
                        'planifié' => 'bg-blue-100 text-blue-800',
                        'annulé' => 'bg-red-100 text-red-800',
                        'confirmé' => 'bg-green-100 text-green-800',
                        'terminé' => 'bg-purple-100 text-purple-800',
                        ][strtolower($rdv->statut)] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst($rdv->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                        $devisCollection = $rdv->devis ?? collect();
                        if ($devisCollection instanceof \App\Models\Devis) {
                        $devisCollection = collect([$devisCollection]);
                        }
                        $hasAcceptedDevis = $devisCollection->contains('statut', 'Accepté');
                        @endphp

                        @if ($devisCollection->isNotEmpty())
                        <span class="text-sm text-green-600">Avec Devis</span>
                        @foreach ($devisCollection as $devis)
                        <p class="text-xs text-gray-500">Statut: {{ $devis->statut }}, Montant: {{
                            number_format($devis->montant, 2) }} MAD</p>
                        @endforeach
                        @else
                        <span class="text-sm text-red-600">Sans Devis</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                        @role('Super Admin|Account Manager')
                        @if(!$hasAcceptedDevis)
                        <a href="{{ route('devis.create', ['rdvId' => $rdv->id]) }}"
                            class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
                            Créer un Devis
                        </a>
                        @endif
                        @endrole
                        @role('Freelancer|Super Admin')
                        @if(!$hasAcceptedDevis)
                        <a href="{{ route('rdvs.edit', $rdv->id) }}"
                            class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
                            Modifier
                        </a>

                        <form action="{{ route('rdvs.destroy', $rdv->id) }}" method="POST"
                            class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-600 focus:ring-opacity-50">
                                Supprimer
                            </button>
                        </form>
                        @endif
                        @endrole
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 text-lg">
                        Aucun rendez-vous trouvé.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($rdvs->hasPages())
    <div class="mt-6">
        {{ $rdvs->links() }}
    </div>
    @endif
</div>

@push('scripts')
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Delete confirmation with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: "Vous ne pourrez pas annuler cette action!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, supprimer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Show success message from session
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush
@endsection