@extends('layouts.app')

@section('title', 'Présence de l\'élève')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fa-solid fa-user-check"></i> Présence — {{ $eleve->nom }} {{ $eleve->prenom }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4">
        <p>Fonctionnalité de présence (placeholder). Bientôt : enregistrement et historique des présences.</p>

        @if(auth()->check() && in_array(auth()->user()->role, ['admin','enseignant']))
            <form action="{{ route('eleves.presence.store', $eleve->id) }}" method="POST" class="mb-3">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="present" value="1" id="present">
                    <label class="form-check-label" for="present">Présent</label>
                </div>
                <button class="btn btn-primary">Enregistrer (placeholder)</button>
            </form>
        @endif

        <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-secondary">Retour</a>
    </div>
</div>
@endsection