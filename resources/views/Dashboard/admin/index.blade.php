@extends('layouts.app')

@section('title', 'Tableau de bord - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Tableau de Bord</h1>
            <p class="mb-0 text-muted">Aperçu global de votre établissement - Année 2025-2026</p>
        </div>
        <div class="d-none d-sm-inline-block">
             <span class="badge bg-light text-primary border p-2">
                <i class="fas fa-calendar-day me-1"></i> {{ now()->translatedFormat('d F Y') }}
             </span>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-4">
        <!-- Total Élèves -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Élèves</div>
                            <div class="h4 mb-0 fw-bold">{{ $stats['eleves_count'] }}</div>
                            <div class="small text-muted mt-1">Inscrits cette année</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Enregistrées -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Notes Enregistrées</div>
                            <div class="h4 mb-0 fw-bold">6</div>
                            <div class="small text-muted mt-1">Sur 2 trimestres</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Moyenne Générale -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Moyenne Générale</div>
                            <div class="h4 mb-0 fw-bold">{{ $stats['moyenne_generale'] }}/20</div>
                            <div class="small text-muted mt-1">Tous élèves confondus</div>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertes Actives -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alertes Actives</div>
                            <div class="h4 mb-0 fw-bold text-danger">{{ count($alerts) }}</div>
                            <div class="small text-muted mt-1">Détections automatiques</div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Alertes IA -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm radius-10 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-robot me-2 text-primary"></i>Analyses Intelligentes - IA</h5>
                </div>
                <div class="card-body">
                    @forelse($alerts as $alert)
                        <div class="alert bg-{{ $alert['type'] }} bg-opacity-10 border-0 border-start border-4 border-{{ $alert['type'] }} mb-3 p-3">
                            <div class="d-flex align-items-center mb-2">
                                 <span class="me-2 fs-5">{{ $alert['type'] == 'danger' ? '⚠️' : 'ℹ️' }}</span>
                                 <strong class="text-{{ $alert['type'] }}">{{ $alert['title'] }}</strong>
                            </div>
                            <p class="mb-2 small">{{ $alert['message'] }}</p>
                            @if(isset($alert['student_id']))
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="fas fa-user me-1"></i> ID: #{{ $alert['student_id'] }}</span>
                                <a href="#" class="btn btn-sm btn-outline-{{ $alert['type'] }} py-0 px-2 fw-bold">Voir Détails</a>
                            </div>
                            @endif
                        </div>
                    @empty
                        <div class="alert bg-success bg-opacity-10 border-0 border-start border-4 border-success p-3 text-center py-4">
                            <span class="fs-4 d-block mb-2">✅</span>
                            <strong class="text-success">Aucune alerte critique</strong>
                            <p class="mb-0 small text-muted">Tout fonctionne parfaitement pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Inscriptions Récentes -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm radius-10 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-user-plus me-2 text-primary"></i>Élèves Récents</h5>
                    <a href="{{ route('eleves.index') }}" class="btn btn-sm btn-link text-decoration-none p-0">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recent_students as $student)
                        <div class="list-group-item bg-transparent border-0 px-4 py-3 border-bottom d-flex align-items-center">
                            <div class="avatar-sm me-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                {{ substr($student->nom, 0, 1) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold mb-0" style="font-size: 0.9rem;">{{ $student->nom }} {{ $student->prenom }}</div>
                                <div class="small text-muted">{{ $student->matricule }} • {{ $student->classe->nom ?? 'N/A' }} • 
                                    <i class="fas fa-{{ $student->genre == 'Féminin' ? 'venus text-danger' : 'mars text-primary' }}" style="font-size: 0.7rem;"></i>
                                </div>
                            </div>
                            <div class="small text-muted fst-italic">{{ $student->created_at->format('d/m/Y') }}</div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted small italic">Aucun élève récent.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .text-xs { font-size: 0.75rem; letter-spacing: 0.5px; }
    .avatar-sm { width: 35px; height: 35px; }
</style>
@endsection