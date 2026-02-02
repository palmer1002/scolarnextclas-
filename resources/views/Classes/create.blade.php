@extends('layouts.app')

@section('title', 'Nouvelle Classe')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold"><i class="fas fa-plus-circle me-2"></i> Ajouter une Classe</h2>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-body p-4">
                    <form action="{{ route('classes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nom de la Classe</label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="ex: 6ème A" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Niveau</label>
                                <input type="text" name="niveau" class="form-control @error('niveau') is-invalid @enderror" value="{{ old('niveau') }}" placeholder="ex: Collège" required>
                                @error('niveau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Capacité Maximale</label>
                                <input type="number" name="capacite_max" class="form-control @error('capacite_max') is-invalid @enderror" value="{{ old('capacite_max') }}" placeholder="Nombre d'élèves" required>
                                @error('capacite_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description (Optionnel)</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Description de la classe...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="reset" class="btn btn-light px-4">Réinitialiser</button>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Créer la Classe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
</style>
@endsection
