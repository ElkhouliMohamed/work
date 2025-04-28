@extends('layouts.app')

@section('content')
<div>
    <h1>Devis Inforamtion </h1>
    <div>
        <h2>Devis ID: {{ $devis->id }}</h2>
        <p><strong>Contact:</strong> {{ $devis->contact->nom ?? 'N/A' }} {{ $devis->contact->prenom ?? '' }}</p>
        <p><strong>Freelancer:</strong> {{ $devis->freelancer->name ?? 'Aucun' }}</p>
        <p><strong>Montant:</strong> {{ number_format($devis->montant, 2) }} MAD</p>
        <p><strong>Statut:</strong> {{ ucfirst($devis->statut) }}</p>
        <p><strong>Commentaire:</strong> {{ $devis->notes }}</p>
        <p><strong>Date de création:</strong> {{ $devis->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Date de mise à jour:</strong> {{ $devis->updated_at->format('d/m/Y H:i') }}</p>
        <p><strong>Date et heure de rendez-vous:</strong> {{ $devis->rdv->date ?? 'N/A' }}</p>


        <a href={{ route('devis.index') }}> Retour à la Liste</a>
        <a href={{ route('devis.edit', $devis->id) }}>
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Modifier</button>
        </a>
    </div>
</div>
@endsection
