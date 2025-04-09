@extends('layouts.app')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 max-w-6xl">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Planifier un Rendez-vous</h1>
        <div class="flex space-x-2">
            <a href="{{ url()->previous() }}"
                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Retour
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"></path>
            </svg>
            <h3 class="font-medium">Veuillez corriger les erreurs suivantes :</h3>
        </div>
        <ul class="mt-2 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Card -->
    <form action="{{ route('rdvs.store') }}" method="POST"
        class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @csrf

        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-gray-50">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Détails du Rendez-vous
            </h2>
        </div>

        <div class="p-6 space-y-6">
            <!-- Contact Selection -->
            <div>
                <label for="contact_id" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner un
                    Contact</label>
                <select name="contact_id" id="contact_id"
                    class="block w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="" disabled selected>Choisir un contact</option>
                    @foreach($contacts as $contact)
                    <option value="{{ $contact->id }}">{{ $contact->nom }} {{ $contact->prenom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Plans Selection -->
            <div>
                <label for="plans" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner des
                    Forfaits</label>
                <select name="plans[]" id="plans" multiple
                    class="block w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 select2"
                    required data-placeholder="Sélectionnez des plans">
                    @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->name }} - {{ number_format($plan->price, 2) }} MAD
                    </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner
                    plusieurs plans.</p>
            </div>

            <!-- Date and Type -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date and Time -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date et Heure</label>
                    <input type="datetime-local" id="date" name="date"
                        class="block w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <!-- Appointment Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type de Rendez-vous</label>
                    <select name="type" id="type"
                        class="block w-full pl-4 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="" disabled selected>Sélectionner un type</option>
                        <option value="Consultation">Consultation</option>
                        <option value="Suivi">Suivi</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes Complémentaires</label>
                <textarea id="notes" name="notes" rows="4"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Des exigences particulières ou des notes..."></textarea>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                    </path>
                </svg>
                Planifier le Rendez-vous
            </button>
        </div>
    </form>
</div>
@endsection

<style>
    .select2-container .select2-selection--multiple {
        @apply border-gray-300 rounded-lg shadow-sm focus: border-blue-500 focus:ring-blue-500 focus:ring-2 focus:ring-offset-2;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        @apply bg-blue-100 text-blue-800 border border-blue-300 rounded-full px-2 py-1 text-sm;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        @apply text-blue-800 hover: text-blue-600 ml-1 cursor-pointer;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        @apply border-blue-500 ring-2 ring-blue-500 ring-offset-2;
    }

    .select2-dropdown {
        @apply border border-gray-300 rounded-lg shadow-lg bg-white;
    }

    .select2-search__field {
        @apply border-gray-300 rounded-lg px-2 py-1;
    }

    .select2-results__option {
        @apply px-4 py-2 text-sm text-gray-800 hover: bg-blue-100 cursor-pointer;
    }

    .select2-results__option--highlighted {
        @apply bg-blue-500 text-white;
    }
</style>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            width: '100%',
            placeholder: "Sélectionnez des plans",
            closeOnSelect: false,
            theme: 'default'
        });
    });
</script>