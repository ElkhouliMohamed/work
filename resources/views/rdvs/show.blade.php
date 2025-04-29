@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-indigo-600 to-blue-700 rounded-t-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-white">
                        Détails du Rendez-vous
                    </h3>
                    <p class="mt-1 text-sm text-indigo-200">
                        {{ $contact->prenom }} {{ $contact->nom }}
                    </p>
                </div>
                <a href="{{ route('rdvs.index') }}"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-indigo-800 hover:bg-indigo-100 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white shadow-xl rounded-b-lg border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <!-- Personal Information Section -->
                <div class="py-4 sm:py-5 sm:px-6">
                    <h4 class="text-base font-semibold text-gray-900 mb-4">Informations Personnelles</h4>
                    <div class="grid sm:grid-cols-3 sm:gap-4">
                        <!-- Full Name -->
                        <dt class="text-sm font-medium text-gray-500">Nom complet</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $contact->prenom }} {{ $contact->nom }}
                        </dd>
                    </div>
                    <!-- Email -->
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <a href="mailto:{{ $contact->email }}"
                                class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                    </path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                {{ $contact->email }}
                            </a>
                        </dd>
                    </div>
                    <!-- Phone -->
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                    </path>
                                </svg>
                                {{ $contact->telephone ?? 'Non fourni' }}
                            </div>
                        </dd>
                    </div>
                    <!-- Address -->
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Adresse</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $contact->adresse ?? 'Non fourni' }}
                            </div>
                        </dd>
                    </div>
                </div>

                <!-- Professional Information Section -->
                <div class="py-4 sm:py-5 sm:px-6 border-t border-gray-200">
                    <h4 class="text-base font-semibold text-gray-900 mb-4">Informations Professionnelles</h4>
                    <!-- Company Name -->
                    <div class="grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Entreprise</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $contact->nom_entreprise ?? 'Non fourni' }}
                            </div>
                        </dd>
                    </div>
                    <!-- Website -->
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Site Web</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($contact->siteweb)
                            <a href="{{ $contact->siteweb }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $contact->siteweb }}
                            </a>
                            @else
                            Non fourni
                            @endif
                        </dd>
                    </div>
                </div>

                <!-- Social Media Section -->
                <div class="py-4 sm:py-5 sm:px-6 border-t border-gray-200">
                    <h4 class="text-base font-semibold text-gray-900 mb-4">Réseaux Sociaux</h4>
                    <!-- Facebook -->
                    <div class="grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Facebook</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($contact->facebook)
                            <a href="{{ $contact->facebook }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z">
                                    </path>
                                </svg>
                                {{ $contact->facebook }}
                            </a>
                            @else
                            Non fourni
                            @endif
                        </dd>
                    </div>
                    <!-- Instagram -->
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Instagram</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($contact->instagram)
                            <a href="{{ $contact->instagram }}" target="_blank"
                                class="text-indigo-600 hover:text-indigo-800 flex items-center">
                                <svg class="h-5 w-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z">
                                    </path>
                                </svg>
                                {{ $contact->instagram }}
                            </a>
                            @else
                            Non fourni
                            @endif
                        </dd>
                    </div>
                </div>

                <!-- RDV Information Section -->
                <div class="py-4 sm:py-5 sm:px-6 border-t border-gray-200">
                    <h4 class="text-base font-semibold text-gray-900 mb-4">Rendez-vous Info</h4>
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Les Packs </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($plans)
                            @foreach ($plans as $plan)

                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">
                                {{ $plan->name }}
                            </span>
                            @endforeach
                            @else
                            Non fourni
                            @endif
                        </dd>
                    </div>
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Date de rendez-vous </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($rdv->date)
                            <span
                                class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                {{ $rdv->date }}
                            </span>
                            @else
                            Non fourni
                            @endif
                        </dd>
                    </div>
                    <div class="grid sm:grid-cols-3 sm:gap-4 mt-4">
                        <dt class="text-sm font-medium text-gray-500">Note </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 ">
                            @if ($rdv->notes)
                            <p class="text-gray-700 bg-gray-100 p-2 rounded-md text-xl ">
                                {{ $rdv->notes }}
                            </p>
                            @else
                            Non fourni
                            @endif
                        </dd>
                    </div>
                </div>

            </dl>
        </div>

        <!-- Actions -->
        <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-between items-center border-t border-gray-200">
            <a href="{{ route('rdvs.index') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
            <div class="space-x-3">
                @can('update', $rdv)
                <a href="{{ route('rdvs.edit', $rdv->id) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    Modifier
                </a>
                @endcan

            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 for Enhanced Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('form[action*="{{ route('rdvs.destroy', $rdv->id) }}"] button[type="submit"]').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "La suppression de ce contact est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        });
    });
</script>
@endsection