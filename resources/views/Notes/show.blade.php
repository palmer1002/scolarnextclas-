@extends('layouts.app')

@section('title', 'Détails de la Note')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-eye me-2"></i> Détails de la Note</h2>
        <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Informations de la Note</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2">Élève</h6>
                    <p class="fs-5 fw-bold">{{ $note->eleve->nomComplet }}</p>
                    <small class="text-muted">Matricule: {{ $note->eleve->matricule }}</small>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2">Matière</h6>
                    <p class="fs-5 fw-bold">{{ $note->matiere->nom }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted border-bottom pb-2">Note</h6>
                    <p class="fs-3 fw-bold text-{{ $note->note >= 10 ? 'success' : 'danger' }}">
                        {{ $note->note }}/20
                    </p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted border-bottom pb-2">Coefficient</h6>
                    <p class="fs-5">x{{ $note->coefficient }}</p>
                </div>

                <div class="col-md-4">
                    <h6 class="text-muted border-bottom pb-2">Évaluation</h6>
                    <span class="badge fs-6 {{ $note->type_evaluation == 'Composition' ? 'bg-danger' : ($note->type_evaluation == 'Devoir' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                        {{ $note->type_evaluation }} {{ $note->num_evaluation }}
                    </span>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2">Période</h6>
                    <p class="fs-5">{{ $note->type_periode }} {{ $note->numero_periode }}</p>
                </div>


            </div>

            @if(in_array(Auth::user()->role, ['admin', 'secretaire', 'enseignant']))
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Modifier
                    </a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Supprimer
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
