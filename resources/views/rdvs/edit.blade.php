@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8 max-w-4xl">
    <!-- Loading Overlay -->
    <div id="loadingOverlay"
        class="fixed inset-0 bg-white bg-opacity-90 flex items-center justify-center z-50 hidden transition-opacity duration-300">
        <div class="text-center">
            <img src="https://lh3.googleusercontent.com/p/AF1QipMqTJ1GQsTVo1wnZhxf4sAWjX443-K-GD8Phu3r=s680-w680-h510"
                alt="Company Logo" class="h-20 mb-6 mx-auto animate-pulse">
            <div class="inline-block h-12 w-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
            </div>
            <p class="mt-4 text-lg font-medium text-gray-700">Mise à jour du rendez-vous en cours...</p>
            <p class="text-sm text-gray-500">Veuillez patienter</p>
        </div>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Modifier le Rendez-vous</h1>
            <p class="mt-1 text-sm text-gray-600">Mettez à jour les détails du rendez-vous</p>
        </div>
        <a href="{{ route('rdvs.index') }}"
            class="bg-gray-300 text-gray-700 hover:bg-gray-200 rounded-lg px-4 py-2 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Retour
        </a>
    </div>

    <!-- Form Card -->
    <form id="rdvForm" action="{{ route('rdvs.update', $rdv) }}" method="POST"
        class="bg-white rounded-xl shadow-md overflow-hidden">
        @csrf
        @method('PUT')

        <!-- Form Header -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Détails du Rendez-vous
            </h2>
        </div>

        <!-- Form Body -->
        <div class="p-6 space-y-6">
            <!-- Contact Selection -->
            <div class="form-group">
                <label for="contact_id" class="block text-sm font-medium text-gray-700 mb-2">Contact</label>
                <div class="relative">
                    <select name="contact_id" id="contact_id" required
                        class="block w-full pl-10 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="" disabled>Choisir un contact</option>
                        @forelse($contacts as $contact)
                        <option value="{{ $contact->id }}" {{ old('contact_id', $rdv->contact_id) == $contact->id ?
                            'selected' : '' }}>
                            {{ $contact->prenom }} {{ $contact->nom }} - {{ $contact->email }}
                        </option>
                        @empty
                        <option value="" disabled selected>Aucun contact disponible</option>
                        @endforelse
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                @error('contact_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Plans Selection -->
            <div class="form-group">
                <label for="plans" class="block text-sm font-medium text-gray-700 mb-2">Forfaits</label>
                <select name="plans[]" id="plans" multiple required
                    class="block w-full select2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                    data-placeholder="Sélectionnez un ou plusieurs forfaits">
                    @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ $rdv->plans->contains($plan->id) || in_array($plan->id,
                        old('plans', [])) ? 'selected' : '' }}>
                        {{ $plan->name }} - {{ number_format($plan->price, 2) }} MAD
                    </option>
                    @endforeach
                </select>
                @error('plans')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date, Type, and Status -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <!-- Date and Time -->
                <div class="form-group">
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Date et Heure</label>
                    <div class="relative">
                        <input type="datetime-local" id="date" name="date" required min="{{ $minDate }}"
                            max="{{ $maxDate }}" value="{{ old('date', $rdv->date->format('Y-m-d\TH:i')) }}"
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('date')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Appointment Type -->
                <div class="form-group">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de Rendez-vous</label>
                    <div class="relative">
                        <select name="type" id="type" required
                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                            <option value="" disabled>Sélectionner un type</option>
                            @foreach($rdvTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('type', $rdv->type) == $value ? 'selected' : '' }}>{{
                                $label }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    @error('type')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <div class="relative">
                    <select name="statut" id="statut" required
                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        <option value="" disabled>Sélectionner un statut</option>
                        @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ old('statut', $rdv->statut) == $value ? 'selected' : '' }}>{{
                            $label }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                @error('statut')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location (Conditional) -->
            <div id="locationField"
                class="form-group {{ $rdv->type == \App\Models\Rdv::TYPE_PHYSICAL ? '' : 'hidden' }}">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lieu</label>
                <input type="text" id="location" name="location" value="{{ old('location', $rdv->location) }}"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                    placeholder="Entrez le lieu du rendez-vous">
                @error('location')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes Complémentaires</label>
                <textarea id="notes" name="notes" rows="4"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                    placeholder="Ajoutez des notes ou des exigences particulières...">{{ old('notes', $rdv->notes) }}</textarea>
                @error('notes')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end space-x-4">
            <button type="submit" id="submitBtn"
                class="px-6 py-3 rounded-lg bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Mettre à jour
            </button>
            <form action="{{ route('rdvs.cancel', $rdv) }}" method="POST" class="inline-block">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="px-6 py-3 rounded-lg bg-red-500 text-white hover:bg-red-600 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200"
                    onclick="return confirm('Are you sure you want to cancel this appointment?')">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    Annuler le rendez-vous
                </button>
            </form>
        </div>
    </form>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
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

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    .is-invalid {
        border-color: #f56565 !important;
    }

    .invalid-feedback {
        color: #f56565;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    #loadingOverlay.flex {
        display: flex;
    }

    #loadingOverlay.hidden {
        display: none;
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

        // Toggle location field based on appointment type
        function toggleLocationField() {
            const type = $('#type').val();
            const locationField = $('#locationField');
            const locationInput = $('#location');

            if (type === '{{ \App\Models\Rdv::TYPE_PHYSICAL }}') {
                locationField.removeClass('hidden').addClass('block');
                locationInput.prop('required', true);
            } else {
                locationField.addClass('hidden').removeClass('block');
                locationInput.prop('required', false);
            }
        }

        $('#type').on('change', toggleLocationField);
        toggleLocationField(); // Initialize on page load

        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
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
                Mise à jour en cours...
            `);
            loadingOverlay.removeClass('hidden').addClass('flex');

            // Submit form via AJAX
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect || "{{ route('rdvs.index') }}";
                    } else {
                        showError(response.message || 'Une erreur est survenue');
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Une erreur est survenue lors de la mise à jour";

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        errorMessage = Object.values(errors).flat().join('<br>');

                        // Highlight error fields
                        form.find('.is-invalid').removeClass('is-invalid');
                        Object.keys(errors).forEach(field => {
                            const input = form.find(`[name="${field}"]`);
                            input.addClass('is-invalid');
                            input.closest('.form-group').find('.invalid-feedback').remove();
                            input.after(`<div class="invalid-feedback text-red-600">${errors[field][0]}</div>`);
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    showError(errorMessage);
                }
            });

            function showError(message) {
                loadingOverlay.addClass('hidden').removeClass('flex');
                submitBtn.prop('disabled', false);
                submitBtn.html(`
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Mettre à jour
                `);

                // Use a more user-friendly error display
                const errorAlert = $(`
                    <div class="fixed bottom-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg z-50 max-w-md">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <strong class="font-bold">Erreur</strong>
                        </div>
                        <div class="mt-2">${message}</div>
                        <button class="absolute top-1 right-1 text-red-700 hover:text-red-900">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                `);

                errorAlert.find('button').on('click', function() {
                    errorAlert.fadeOut(300, function() { $(this).remove(); });
                });

                $('body').append(errorAlert);
                setTimeout(() => errorAlert.fadeOut(300, function() { $(this).remove(); }), 5000);
            }
        });
    });
</script>
@endsection