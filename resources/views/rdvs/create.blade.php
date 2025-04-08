@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-100 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Planifier un Rendez-vous</h1>
            <p class="text-lg text-gray-600">Réservez votre consultation avec notre équipe professionnelle</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 sm:p-12">
                <form action="{{ route('rdvs.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Contact Selection -->
                    <div class="space-y-2">
                        <label for="contact_id" class="block text-sm font-medium text-gray-700">Sélectionner un Contact</label>
                        <select name="contact_id" id="contact_id" class="select2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                            <option value="" disabled selected>Choisir un contact</option>
                            @foreach($contacts as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->nom }} {{ $contact->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Plans Selection -->
                    <div class="space-y-2">
                        <label for="plans" class="block text-sm font-medium text-gray-700">Sélectionner des Forfaits</label>
                        <select name="plans[]" id="plans" multiple class="select2-multiple block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }} - {{ number_format($plan->price, 2) }} MAD</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Cliquez simplement pour sélectionner plusieurs options</p>
                    </div>

                    <!-- Date and Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date and Time -->
                        <div class="space-y-2">
                            <label for="date" class="block text-sm font-medium text-gray-700">Date et Heure</label>
                            <input type="datetime-local" id="date" name="date" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                        </div>

                        <!-- Appointment Type -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de Rendez-vous</label>
                            <select name="type" id="type" class="select2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" required>
                                <option value="" disabled selected>Sélectionner un type</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Suivi">Suivi</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="space-y-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes Complémentaires</label>
                        <textarea id="notes" name="notes" rows="4" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" placeholder="Des exigences particulières ou des notes..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Planifier le Rendez-vous
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- Select2 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Custom Select2 styling to match Tailwind */
        .select2-container .select2-selection--single,
        .select2-container .select2-selection--multiple {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem !important;
            height: auto !important;
            min-height: 2.75rem;
            background-color: white !important;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 2.5rem;
            padding-left: 0.75rem;
            color: #374151;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: white !important;
            margin-top: 4px;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            margin-left: 0.5rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }

        .select2-dropdown {
            border-color: #d1d5db !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
            background-color: white !important;
        }

        .select2-results__option {
            padding: 0.75rem 1rem !important;
            color: #374151 !important;
        }

        .select2-results__option--highlighted {
            background-color: #e5e7eb !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- jQuery (required by Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Sélectionner une option",
                allowClear: true,
                theme: "default"
            });

            $('.select2-multiple').select2({
                width: '100%',
                placeholder: "Sélectionner des forfaits",
                allowClear: true,
                closeOnSelect: false,
                multiple: true,
                theme: "default"
            });
        });
    </script>
@endpush
