@extends('layouts.app')

@section('title', 'Ajouter une note')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fa-solid fa-square-plus"></i> Ajouter une nouvelle note</h2>

    {{-- Messages d’erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Oups !</strong> Merci de corriger les erreurs ci-dessous :
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('notes.store') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Élève</label>
            <select name="eleve_id" class="form-control @error('eleve_id') is-invalid @enderror" required>
                <option value="">-- Sélectionner un élève --</option>
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                        {{ $eleve->nomComplet }}
                    </option>
                @endforeach
            </select>
            @error('eleve_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Matière</label>
            <select name="matiere_id" class="form-control @error('matiere_id') is-invalid @enderror" required>
                <option value="">-- Sélectionner une matière --</option>
                @foreach($matieres as $matiere)
                    <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                        {{ $matiere->nom }}
                    </option>
                @endforeach
            </select>
            @error('matiere_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Note</label>
            <input type="number"
                   name="note"
                   class="form-control @error('note') is-invalid @enderror"
                   placeholder="Ex: 15"
                   min="0"
                   max="20"
                   step="0.5"
                   value="{{ old('note') }}"
                   required>
            @error('note')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Coefficient</label>
            <input type="number"
                   name="coefficient"
                   class="form-control @error('coefficient') is-invalid @enderror"
                   placeholder="Ex: 2"
                   min="1"
                   value="{{ old('coefficient', 1) }}"
                   required>
            @error('coefficient')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Trimestre</label>
            <select name="trimestre" class="form-control @error('trimestre') is-invalid @enderror" required>
                <option value="1" {{ old('trimestre') == 1 ? 'selected' : '' }}>1er trimestre</option>
                <option value="2" {{ old('trimestre') == 2 ? 'selected' : '' }}>2ème trimestre</option>
                <option value="3" {{ old('trimestre') == 3 ? 'selected' : '' }}>3ème trimestre</option>
            </select>
            @error('trimestre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Année scolaire</label>
            <input type="text"
                   name="annee_scolaire"
                   class="form-control @error('annee_scolaire') is-invalid @enderror"
                   placeholder="Ex: 2025-2026"
                   value="{{ old('annee_scolaire') }}"
                   required>
            @error('annee_scolaire')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-check"></i> Enregistrer
            </button>
            <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Retour
            </a>
        </div>
    </form>
</div>
@endsection
