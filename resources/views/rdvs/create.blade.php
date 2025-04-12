@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 max-w-4xl">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="text-center">
            <!-- Company Logo -->
            <img src="https://lh3.googleusercontent.com/p/AF1QipMqTJ1GQsTVo1wnZhxf4sAWjX443-K-GD8Phu3r=s680-w680-h510" alt="Company Logo" class="h-20 mb-6 mx-auto animate-pulse">
            
            <!-- Loading Spinner -->
            <div class="inline-block h-12 w-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
            
            <!-- Loading Text -->
            <p class="mt-4 text-lg font-medium text-gray-700">Création du rendez-vous en cours...</p>
            <p class="text-sm text-gray-500">Veuillez patienter</p>
        </div>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Nouveau Rendez-vous</h1>
            <p class="mt-1 text-sm text-gray-600">Remplissez les détails du rendez-vous</p>
        </div>
        <a href="{{ route('rdvs.index') }}" class="bg-gray-300 text-gray-700 hover:bg-gray-200 rounded-lg px-4 py-2 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
    </div>

    <!-- Form Card -->
    <form id="rdvForm" action="{{ route('rdvs.store') }}" method="POST" class="bg-white rounded-xl shadow-md overflow-hidden">
        @csrf

        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Détails du Rendez-vous
            </h2>
        </div>

        <!-- Form Body -->
        <div class="p-6 space-y-6">
            <!-- Contact Selection -->
            <div>
                <label for="contact_id" class="block text-sm font-medium text-gray-700 mb-2">Contact</label>
                <div class="relative">
                    <select name="contact_id" id="contact_id" required
                        class="block w-full pl-10 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="" disabled selected>Choisir un contact</option>
                        @foreach($contacts as $contact)
                        <option value="{{ $contact->id }}">{{ $contact->prenom }} {{ $contact->nom }} - {{ $contact->email }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Plans Selection -->
            <div>
                <label for="plans" class="block text-sm font-medium text-gray-700 mb-2">Forfaits</label>
                <select name="plans[]" id="plans" multiple required
                    class="block w-full select2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                    data-placeholder="Sélectionnez un ou plusieurs forfaits">
                    @foreach($plans as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->name }} - {{ number_format($plan->price, 2) }} MAD</option>
                    @endforeach
                </select>
            </div>

            <!-- Date and Type -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Date and Time -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date et Heure</label>
                    <div class="relative">
                        <input type="datetime-local" id="date" name="date" required min="{{ $minDate }}" max="{{ $maxDate }}"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Appointment Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de Rendez-vous</label>
                    <div class="relative">
                        <select name="type" id="type" required
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="" disabled selected>Sélectionner un type</option>
                            @foreach($rdvTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes Complémentaires</label>
                <textarea id="notes" name="notes" rows="4"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                    placeholder="Ajoutez des notes ou des exigences particulières..."></textarea>
            </div>
        </div>

        <!-- Form Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button type="submit" id="submitBtn" class="px-6 py-3 rounded-lg bg-green-500 text-white hover:bg-green-600 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Planifier le Rendez-vous
            </button>
        </div>
    </form>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Custom Select2 styling */
    .select2-container--default .select2-selection--multiple {
        min-height: 46px;
        padding: 4px 8px;
        border: 1px solid #d1d5db !important;
        border-radius: 0.5rem !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #e0e7ff;
        border: 1px solid #c7d2fe;
        color: #4f46e5;
        border-radius: 9999px;
    }
    /* Button styling */
    .btn-primary {
        @apply inline-flex items-center px-5 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200;
    }
    .btn-secondary {
        @apply inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm;
    }
    /* Animations */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<!-- Include jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        width: '100%',
        placeholder: $(this).data('placeholder'),
        allowClear: true,
        closeOnSelect: false
    });

    // Form submission handler
    $('#rdvForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitBtn = $('#submitBtn');
        const loadingOverlay = $('#loadingOverlay');
        
        // Show loading state
        submitBtn.prop('disabled', true);
        submitBtn.html(`
            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Envoi en cours...
        `);
        loadingOverlay.removeClass('hidden');

        // Submit form via AJAX
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Redirect on success
                window.location.href = "{{ route('rdvs.index') }}";
            },
            error: function(xhr) {
                // Handle errors
                loadingOverlay.addClass('hidden');
                submitBtn.prop('disabled', false);
                submitBtn.html(`
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Planifier le Rendez-vous
                `);
                
                // Show error message
                let errorMessage = "Une erreur est survenue";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            }
        });
    });
});
</script>
@endsection