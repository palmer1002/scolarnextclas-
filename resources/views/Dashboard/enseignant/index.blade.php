@extends('layouts.user_app')

@section('title', 'Dashboard Enseignant - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-3"><i class="fas fa-chalkboard-teacher me-2 text-primary"></i> Bienvenue, {{ Auth::user()->name }}</h1>
            <p class="lead text-muted">Tableau de bord Enseignant</p>

            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-1"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="row mt-4 g-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Mes Classes</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher_stats['classes_count'] }}</h5>
                            <p class="card-text small">Classes assignées</p>
                            <a href="#classes-section" class="btn btn-light btn-sm w-100">Voir mes classes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Notes</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher_stats['notes_count'] }}</h5>
                            <p class="card-text small">Notes saisies</p>
                            <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm w-100">Gérer les notes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Bulletins</div>
                        <div class="card-body">
                            <h5 class="card-title">Disponibles</h5>
                            <p class="card-text small">Gestion des bulletins</p>
                            <a href="{{ route('bulletins.index') }}" class="btn btn-light btn-sm w-100">Voir bulletins</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Élèves</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $teacher_stats['eleves_count'] }}</h5>
                            <p class="card-text small">Total élèves</p>
                            <a href="{{ route('presences.index') }}" class="btn btn-light btn-sm w-100">Gérer présences</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4" id="classes-section">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-0">
                            <h4 class="mb-0 fw-bold"><i class="fas fa-school me-2 text-primary"></i> Mes Classes</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Classe</th>
                                            <th>Niveau</th>
                                            <th>Élèves</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($mes_classes as $classe)
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="fw-bold">{{ $classe->nom }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info text-dark">{{ $classe->niveau }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-users me-2 text-muted"></i>
                                                        <span class="fw-bold">{{ $classe->eleves->count() }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('classes.show', $classe->id) }}" 
                                                           class="btn btn-outline-primary" title="Voir détails">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('notes.index') }}" 
                                                           class="btn btn-outline-success" title="Saisir notes">
                                                            <i class="fas fa-clipboard-list"></i>
                                                        </a>
                                                        <a href="{{ route('presences.index') }}" 
                                                           class="btn btn-outline-info" title="Faire l'appel">
                                                            <i class="fas fa-user-check"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                                                        <p>Aucune classe assignée pour le moment.</p>
                                                        <small>Veuillez contacter l'administration.</small>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-0">
                            <h4 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i> Activités Récentes</h4>
                        </div>
                        <div class="card-body">
                            @forelse($activites_recentes as $activite)
                                <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                                        <i class="fas fa-clipboard-check text-success"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold small">Note saisie</div>
                                        <div class="text-muted small">
                                            {{ $activite->eleve->nomComplet }} - {{ $activite->eleve->classe->nom ?? 'N/A' }}
                                        </div>
                                        <div class="text-muted small">
                                            <i class="fas fa-clock me-1"></i> {{ $activite->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <span class="badge bg-success">{{ $activite->note }}/20</span>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p class="small mb-0">Aucune activité récente</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="card mt-3 shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-0">
                            <h4 class="mb-0 fw-bold"><i class="fas fa-bell me-2 text-primary"></i> Notifications</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info border-0 mb-0">
                                <i class="fas fa-info-circle me-1"></i> Aucun message urgent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 10px; }
</style>
@endsection