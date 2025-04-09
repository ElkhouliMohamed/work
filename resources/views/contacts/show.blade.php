@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-8 border-b-2 border-gray-200 pb-2">Détails du Contact</h1>

    <div class="max-w-2xl mx-auto bg-white shadow-2xl rounded-xl p-6 sm:p-8">
        <!-- Contact Details -->
        <div class="space-y-6">
            <!-- Nom -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nom</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->nom }}</p>
            </div>

            <!-- Prénom -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Prénom</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->prenom }}</p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Email</label>
                <p class="mt-1 text-lg text-gray-900">
                    <a href="mailto:{{ $contact->email }}" class="text-indigo-600 hover:underline">{{ $contact->email
                        }}</a>
                </p>
            </div>

            <!-- Téléphone -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Téléphone</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->telephone ?? 'Non spécifié' }}</p>
            </div>

            <!-- Adresse -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Adresse</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->adresse ?? 'Non spécifiée' }}</p>
            </div>

            <!-- Nom de l'entreprise -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nom de l'entreprise</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->nom_entreprise ?? 'Non spécifié' }}</p>
            </div>

            <!-- Instagram -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Instagram</label>
                <p class="mt-1 text-lg text-gray-900">
                    @if($contact->instagram)
                    <a href="{{ $contact->instagram }}" target="_blank" class="text-indigo-600 hover:underline">{{
                        $contact->instagram }}</a>
                    @else
                    Non spécifié
                    @endif
                </p>
            </div>

            <!-- Facebook -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Facebook</label>
                <p class="mt-1 text-lg text-gray-900">
                    @if($contact->facebook)
                    <a href="{{ $contact->facebook }}" target="_blank" class="text-indigo-600 hover:underline">{{
                        $contact->facebook }}</a>
                    @else
                    Non spécifié
                    @endif
                </p>
            </div>

            <!-- Site Web -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Site Web</label>
                <p class="mt-1 text-lg text-gray-900">
                    @if($contact->siteweb)
                    <a href="{{ $contact->siteweb }}" target="_blank" class="text-indigo-600 hover:underline">{{
                        $contact->siteweb }}</a>
                    @else
                    Non spécifié
                    @endif
                </p>
            </div>

            <!-- Statut -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Statut</label>
                <p class="mt-1 text-lg text-gray-900 capitalize">{{ $contact->statut }}</p>
            </div>

            <!-- Created At -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Date de création</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <!-- Updated At -->
            <div>
                <label class="block text-sm font-semibold text-gray-700">Dernière mise à jour</label>
                <p class="mt-1 text-lg text-gray-900">{{ $contact->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('contacts.index') }}"
                class="bg-gray-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-gray-600 transition duration-200 ease-in-out transform hover:-translate-y-1">
                Retour
            </a>
            @if(Auth::user()->hasRole('Freelancer') || Auth::user()->hasRole('Account Manager') ||
            Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Super Admin'))
            <a href="{{ route('contacts.edit', $contact) }}"
                class="bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition duration-200 ease-in-out transform hover:-translate-y-1">
                Modifier
            </a>
            @endif
        </div>
    </div>
</div>
@endsection