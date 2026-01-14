@extends('layouts.app')

@section('title', 'Détails du Parent')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-user-circle me-2"></i> Détails du Parent</h2>
                <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-header bg-primary text-white p-3 radius-top-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $parent->nom_complet }}</h4>
                        <div>
                            <span class="badge bg-light text-primary me-2">{{ $parent->relation }}</span>
                            @if($parent->statut == 'active')
                                <span class="badge bg-success border border-white">Actif</span>
                            @else
                                <span class="badge bg-danger border border-white">Inactif</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="text-secondary border-bottom pb-2 mb-3">Coordonnées</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Téléphone:</span>
                                    <span>{{ $parent->telephone }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Email:</span>
                                    <span>{{ $parent->email ?: 'Non renseigné' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Adresse:</span>
                                    <span class="text-end">{{ $parent->adresse ?: 'Non renseignée' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Profession:</span>
                                    <span>{{ $parent->profession ?: 'Non renseignée' }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-secondary border-bottom pb-2 mb-3">Enfants Associés</h5>
                            @if($parent->students->count() > 0)
                                <div class="list-group">
                                    @foreach($parent->students as $student)
                                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-user-graduate me-2 text-primary"></i>
                                                {{ $student->nom }} {{ $student->prenom }}
                                            </div>
                                            <span class="badge bg-light text-dark border">{{ $student->matricule }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i> Aucun élève associé.
                                </div>
                            @endif
                        </div>

                        @if($parent->notes)
                        <div class="col-12 mt-4">
                            <div class="bg-light p-3 rounded border">
                                <h6 class="fw-bold text-muted mb-2">Notes supplémentaires:</h6>
                                <p class="mb-0 text-dark">{{ $parent->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top gap-2">
                        <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                        <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .radius-top-10 { border-top-left-radius: 10px; border-top-right-radius: 10px; }
    .list-group-item { border: none; padding-left: 0; padding-right: 0; }
</style>
@endsection