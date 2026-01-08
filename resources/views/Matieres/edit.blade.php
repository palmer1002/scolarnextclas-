@extends('layouts.app')

@section('title', 'Modifier la matière')

@section('content')
<div class="container">
    <h2 class="mb-4">
        <i class="fa-solid fa-pen-to-square"></i> Modifier la matière
    </h2>

    {{-- Messages d’erreurs --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Oups !</strong> Merci de corriger les erreurs ci-dessous :
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Formulaire --}}
    <form action="{{ route('matieres.update', $matiere->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label fw-bold">Nom de la matière</label>
            <input
                type="text"
                name="nom"
                class="form-control @error('nom') is-invalid @enderror"
                value="{{ old('nom', $matiere->nom) }}"
                required
            >
            @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Code</label>
            <input
                type="text"
                name="code"
                class="form-control @error('code') is-invalid @enderror"
                value="{{ old('code', $matiere->code) }}"
                required
            >
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Coefficient</label>
            <input
                type="number"
                name="coefficient"
                class="form-control @error('coefficient') is-invalid @enderror"
                value="{{ old('coefficient', $matiere->coefficient) }}"
                min="1"
                required
            >
            @error('coefficient')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-floppy-disk"></i> Mettre à jour
            </button>

            <a href="{{ route('matieres.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Retour
            </a>
        </div>
    </form>
</div>
@endsection
