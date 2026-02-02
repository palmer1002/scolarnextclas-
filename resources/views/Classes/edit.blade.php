@extends('layouts.app')

@section('title', 'Modifier la Classe - ' . $class->nom)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary fw-bold"><i class="fas fa-edit me-2"></i> Modifier la Classe</h2>
                <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-body p-4">
                    <form action="{{ route('classes.update', $class->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nom de la Classe</label>
                                <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $class->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Niveau</label>
                                <input type="text" name="niveau" class="form-control @error('niveau') is-invalid @enderror" value="{{ old('niveau', $class->niveau) }}" required>
                                @error('niveau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Capacité Maximale</label>
                                <input type="number" name="capacite_max" class="form-control @error('capacite_max') is-invalid @enderror" value="{{ old('capacite_max', $class->capacite_max) }}" required>
                                @error('capacite_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Description (Optionnel)</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $class->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save me-1"></i> Enregistrer les modifications
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
