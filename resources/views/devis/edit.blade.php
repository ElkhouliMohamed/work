@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Devis</h2>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('devis.update', $devis->id) }}" method="POST"
        class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- RDV Information -->
            <div class="mb-4">
                <label for="rdv_info" class="block text-gray-700 text-sm font-bold mb-2">RDV Associé</label>
                <div class="p-3 border rounded bg-gray-50">
                    <p class="font-sm">{{ $rdv->title ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Date: {{ $rdv->start_time ?
                        \Carbon\Carbon::parse($rdv->start_time)->format('d/m/Y H:i') : 'N/A' }}</p>
                    <p class="text-sm text-gray-600">Contact: {{ ($rdv->contact->nom ?? '') . ' ' .
                        ($rdv->contact->prenom ?? 'N/A') }}</p>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mb-4">
                <label for="contact_info" class="block text-gray-700 text-sm font-bold mb-2">Contact</label>
                <div class="p-3 border rounded bg-gray-50">
                    <p class="font-semibold">{{ ($devis->contact->nom ?? '') . ' ' . ($devis->contact->prenom ?? 'N/A')
                        }}</p>
                    <p class="text-sm text-gray-600">{{ $devis->contact->email ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-600">{{ $devis->contact->telephone ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Freelancer Selection -->
            <div class="mb-4">
                <label for="freelancer_id" class="block text-gray-700 text-sm font-bold mb-2">Freelancer</label>
                <select name="freelancer_id" id="freelancer_id"
                    class="js-example-basic-single shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Sélectionnez un freelancer</option>
                    @foreach($freelancers as $freelancer)
                    <option value="{{ $freelancer->id }}" {{ $devis->freelancer_id == $freelancer->id ? 'selected' : ''
                        }}>
                        {{ $freelancer->name }} ({{ $freelancer->email }})
                    </option>
                    @endforeach
                </select>
                @error('freelancer_id')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Status Field -->
            <div class="mb-4">
                <label for="statut" class="block text-gray-700 text-sm font-bold mb-2">Statut</label>
                <select name="statut" id="statut" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="Brouillon" {{ $devis->statut == 'Brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="En Attente" {{ $devis->statut == 'En Attente' ? 'selected' : '' }}>En Attente
                    </option>
                    <option value="Accepté" {{ $devis->statut == 'Accepté' ? 'selected' : '' }}>Accepté</option>
                    <option value="Refusé" {{ $devis->statut == 'Refusé' ? 'selected' : '' }}>Refusé</option>
                    <option value="Annulé" {{ $devis->statut == 'Annulé' ? 'selected' : '' }}>Annulé</option>
                </select>
                @error('statut')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Montant Field -->
            <div class="mb-4">
                <label for="montant" class="block text-gray-700 text-sm font-bold mb-2">Montant (MAD)</label>
                <input type="number" step="0.01" name="montant" id="montant"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('montant', $devis->montant) }}" required>
                @error('montant')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date Validite Field -->
            <div class="mb-4">
                <label for="date_validite" class="block text-gray-700 text-sm font-bold mb-2">Date de validité</label>
                <input type="date" name="date_validite" id="date_validite"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    value="{{ old('date_validite', $devis->date_validite ? \Carbon\Carbon::parse($devis->date_validite)->format('Y-m-d') : '') }}"
                    required>
                @error('date_validite')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Multi-Select Plan Selection -->
        <div class="mb-6">
            <label for="plans" class="block text-gray-700 text-sm font-bold mb-2">Plans</label>
            <select id="plans" name="plans[]" multiple="multiple"
                class="js-example-basic-multiple shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach($plans as $plan)
                <option value="{{ $plan->id }}" {{ in_array($plan->id, $devis->plans->pluck('id')->toArray()) ?
                    'selected' : '' }}>
                    {{ $plan->name }} - {{ number_format($plan->price, 2) }} MAD
                </option>
                @endforeach
            </select>
            @error('plans')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Notes Field -->
        <div class="mb-6">
            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
            <textarea name="notes" id="notes" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('notes', $devis->notes) }}</textarea>
            @error('notes')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Mettre à jour
            </button>
            <a href="{{ route('devis.index') }}"
                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Annuler
            </a>
        </div>
    </form>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for single select
        $('.js-example-basic-single').select2({
            placeholder: "Sélectionnez une option",
            allowClear: true
        });

        // Initialize Select2 for multi-select
        $('.js-example-basic-multiple').select2({
            placeholder: "Sélectionnez des plans",
            allowClear: true
        });
    });
</script>
@endsection
