@extends('layouts.app')

@section('title', 'Présence - ' . $eleve->nom_complet)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-user-check me-2"></i> Présence de l'Élève</h2>
                <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow border-0 radius-10 overflow-hidden">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0">{{ $eleve->nom_complet }}</h5>
                    <small class="opacity-75">Matricule: {{ $eleve->matricule }}</small>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <i class="fas fa-tools me-2"></i> <strong>Fonctionnalité en développement :</strong> 
                        L'enregistrement complet et l'historique des présences seront disponibles prochainement.
                    </div>

                    @if(auth()->check() && in_array(auth()->user()->role, ['admin','enseignant']))
                        <form action="{{ route('eleves.presence.store', $eleve->id) }}" method="POST" class="text-start">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Date de l'appel</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                            </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" name="present" value="1" id="present" checked>
                                <label class="form-check-label fw-bold" for="present">Marquer comme présent</label>
                            </div>
                            <div class="d-grid shadow-sm">
                                <button class="btn btn-primary py-2 fw-bold">
                                    <i class="fas fa-save me-1"></i> Enregistrer la présence
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .form-switch .form-check-input { width: 3em; height: 1.5em; cursor: pointer; }
</style>
@endsection