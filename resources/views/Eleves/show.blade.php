@extends('layouts.app')

@section('title', 'Détails Élève - ' . $eleve->nom_complet)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-user-graduate me-2"></i> Détails de l'Élève</h2>
                <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10 mb-4">
                <div class="card-header bg-primary text-white p-4 radius-top-10">
                    <div class="d-flex align-items-center">
                        <div class="student-avatar me-4">
                            {{ substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="mb-1">{{ $eleve->nom_complet }}</h3>
                            <div class="d-flex gap-3">
                                <span class="badge bg-light text-primary"><i class="fas fa-id-card me-1"></i> {{ $eleve->matricule }}</span>
                                <span class="badge {{ $eleve->statut == 'actif' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($eleve->statut) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="text-secondary border-bottom pb-2 mb-3"><i class="fas fa-info-circle me-2"></i>Informations Personnelles</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Date de naissance:</span>
                                    <span>{{ \Carbon\Carbon::parse($eleve->date_naissance)->translatedFormat('d F Y') }} ({{ $eleve->age }} ans)</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Genre:</span>
                                    <span>
                                        <i class="fas {{ $eleve->genre == 'Féminin' ? 'fa-venus text-danger' : 'fa-mars text-primary' }} me-1"></i>
                                        {{ $eleve->genre }}
                                    </span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Classe:</span>
                                    <span class="badge bg-secondary">{{ $eleve->classe->nom ?? 'Non assigné' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Date d'inscription:</span>
                                    <span>{{ \Carbon\Carbon::parse($eleve->date_inscription)->translatedFormat('d/m/Y') }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-secondary border-bottom pb-2 mb-3"><i class="fas fa-address-book me-2"></i>Contact & Localisation</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-transparent">
                                    <span class="fw-bold text-muted d-block mb-1">Adresse:</span>
                                    <span>{{ $eleve->adresse ?? 'Non renseignée' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Email:</span>
                                    <span>{{ $eleve->email ?? 'N/A' }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent">
                                    <span class="fw-bold text-muted">Téléphone:</span>
                                    <span>{{ $eleve->telephone ?? 'N/A' }}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-12">
                            <h5 class="text-secondary border-bottom pb-2 mb-3"><i class="fas fa-users me-2"></i>Parent / Tuteur</h5>
                            <div class="row bg-light p-3 rounded mx-0">
                                <div class="col-md-4">
                                    <span class="fw-bold text-muted d-block small uppercase">Nom Complet</span>
                                    <span class="fs-6">{{ $eleve->parent_nom }}</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="fw-bold text-muted d-block small uppercase">Relation</span>
                                    <span class="badge bg-outline-primary border border-primary text-primary">{{ $eleve->parent_relation }}</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="fw-bold text-muted d-block small uppercase">Téléphone</span>
                                    <span class="fs-6"><i class="fas fa-phone-alt me-1 text-success"></i> {{ $eleve->parent_telephone }}</span>
                                </div>
                                @if($eleve->parent_email)
                                <div class="col-md-4 mt-3">
                                    <span class="fw-bold text-muted d-block small uppercase">Email</span>
                                    <span class="fs-6">{{ $eleve->parent_email }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($eleve->notes)
                        <div class="col-12">
                            <h5 class="text-secondary border-bottom pb-2 mb-3"><i class="fas fa-sticky-note me-2"></i>Notes & Remarques</h5>
                            <div class="p-3 border-start border-4 border-primary bg-light">
                                {{ $eleve->notes }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top">
                        <a href="{{ route('eleves.edit', $eleve->id) }}" class="btn btn-warning px-4 text-white fw-bold">
                            <i class="fas fa-edit me-1"></i> Modifier
                        </a>
                        <form action="{{ route('eleves.destroy', $eleve->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4 fw-bold">
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
    .student-avatar {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        border: 3px solid rgba(255,255,255,0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        color: white;
    }
    .list-group-item { border: none; padding-left: 0; padding-right: 0; }
    .uppercase { text-transform: uppercase; letter-spacing: 1px; }
</style>
@endsection