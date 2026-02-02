@extends('layouts.app')

@section('title', 'Détails Enseignant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-chalkboard-teacher me-2"></i> Détails Enseignant</h2>
                <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-header bg-primary text-white p-3 radius-top-10">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $enseignant->title }} {{ $enseignant->first_name }} {{ $enseignant->last_name }}</h4>
                        <span class="badge bg-light text-primary">{{ $enseignant->status }}</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="text-secondary border-bottom pb-2 mb-3">Informations Personnelles</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Email:</span>
                                    <span>{{ $enseignant->email }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Téléphone:</span>
                                    <span>{{ $enseignant->phone ?: 'Non renseigné' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Matière:</span>
                                    <span>{{ $enseignant->subject }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-8">
                             <h5 class="text-secondary border-bottom pb-2 mb-3">Compétences & Affectations</h5>
                             
                             <div class="mb-4">
                                 <h6 class="fw-bold text-muted mb-2 small uppercase">Matières Enseignées</h6>
                                 @if($enseignant->matieres->count() > 0)
                                     <div class="d-flex flex-wrap gap-2">
                                         @foreach($enseignant->matieres as $matiere)
                                             <span class="badge bg-success fs-6">{{ $matiere->nom }}</span>
                                         @endforeach
                                     </div>
                                 @else
                                     <div class="text-muted italic small"><i class="fas fa-info-circle me-1"></i> Aucune matière spécifique enregistrée.</div>
                                 @endif
                             </div>

                             <div>
                                 <h6 class="fw-bold text-muted mb-2 small uppercase">Classes Assignées</h6>
                                 @if($enseignant->classes->count() > 0)
                                     <div class="d-flex flex-wrap gap-2">
                                         @foreach($enseignant->classes as $classe)
                                             <span class="badge bg-primary fs-6">{{ $classe->nom }}</span>
                                         @endforeach
                                     </div>
                                 @else
                                     <div class="alert alert-info py-2">
                                         <i class="fas fa-info-circle me-1"></i> Aucune classe assignée.
                                     </div>
                                 @endif
                             </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->role === 'admin')
                    <div class="d-flex justify-content-end mt-4 pt-3 border-top gap-2">
                        <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                        <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
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
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .radius-top-10 { border-top-left-radius: 10px; border-top-right-radius: 10px; }
    .list-group-item { border: none; padding-left: 0; padding-right: 0; }
</style>
@endsection