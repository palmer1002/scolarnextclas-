@extends('layouts.app')

@section('title', 'Détails de la Classe - ' . $class->nom)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('classes.index') }}">Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $class->nom }}</li>
                </ol>
            </nav>
            <h2 class="text-primary mb-0"><i class="fas fa-chalkboard me-2"></i> {{ $class->nom }}</h2>
        </div>
        <div>
            <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-warning shadow-sm me-2">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations Générales -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-0 radius-10 h-100">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted"><i class="fas fa-layer-group me-2"></i> Niveau</span>
                            <span class="fw-bold">{{ $class->niveau }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted"><i class="fas fa-users me-2"></i> Capacité</span>
                            <span class="fw-bold text-primary">{{ $class->capacite_max }} places</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted"><i class="fas fa-calendar-alt me-2"></i> Année Scolaire</span>
                            <span class="fw-bold">{{ $class->annee_scolaire }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted"><i class="fas fa-info-circle me-2"></i> Statut</span>
                            <span class="badge {{ $class->statut ? 'bg-success' : 'bg-danger' }}">
                                {{ $class->statut ? 'Active' : 'Inactive' }}
                            </span>
                        </li>
                    </ul>
                    @if($class->description)
                        <div class="mt-4">
                            <h6 class="fw-bold text-muted mb-2">Description</h6>
                            <p class="small text-secondary mb-0">{{ $class->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques Rapides -->
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow border-0 radius-10 bg-gradients-primary text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2">Total Élèves</h6>
                                <h2 class="mb-0 fw-bold">{{ $class->eleves->count() }}</h2>
                            </div>
                            <i class="fas fa-user-graduate fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow border-0 radius-10 bg-gradients-info text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase mb-2">Enseignants</h6>
                                <h2 class="mb-0 fw-bold">{{ $class->enseignants->count() }}</h2>
                            </div>
                            <i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des Élèves -->
            <div class="card shadow border-0 radius-10 mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-bold">Liste des Élèves</h5>
                    <span class="badge bg-primary rounded-pill">{{ $class->eleves->count() }} inscrits</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Matricule</th>
                                    <th>Nom & Prénoms</th>
                                    <th>Genre</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($class->eleves as $eleve)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">{{ $eleve->matricule }}</td>
                                        <td>{{ $eleve->nomComplet }}</td>
                                        <td>
                                            @if($eleve->genre === 'Masculin')
                                                <span class="badge bg-light text-primary border"><i class="fas fa-mars me-1"></i> Masculin</span>
                                            @else
                                                <span class="badge bg-light text-danger border"><i class="fas fa-venus me-1"></i> Féminin</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-sm btn-link text-info p-0" title="Voir profil">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">Aucun élève inscrit dans cette classe.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .bg-gradients-primary { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); }
    .bg-gradients-info { background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); }
    .breadcrumb-item + .breadcrumb-item::before { color: #6c757d; }
</style>
@endsection
