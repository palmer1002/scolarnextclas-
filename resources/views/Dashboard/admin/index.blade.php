@extends('layouts.app')

@section('title', 'Tableau de bord - ScolarNextClas')

@section('content')
<div class="container-fluid">

    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                
                Tableau de Bord
            </h1>
            <p class="mb-0 text-muted">Aperçu global de votre établissement</p>
        </div>
        <div class="d-none d-sm-inline-block">
            <span class="badge bg-light text-primary border p-2">
                <i class="fa-solid fa-calendar-day me-1"></i>
                {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-4">

        <!-- Total Élèves -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-primary">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Total Élèves</div>
                        <div class="h4 fw-bold mb-0">{{ $stats['eleves_count'] }}</div>
                        <div class="small text-muted">Inscrits cette année</div>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                        <i class="fa-solid fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-success">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Notes Enregistrées</div>
                        <div class="h4 fw-bold mb-0">0</div>
                        <div class="small text-muted">Sur 2 trimestres</div>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                        <i class="fa-solid fa-clipboard-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Moyenne -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-info">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Moyenne Générale</div>
                        <div class="h4 fw-bold mb-0">{{ $stats['moyenne_generale'] }}/20</div>
                        <div class="small text-muted">Tous élèves confondus</div>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                        <i class="fa-solid fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-10 h-100 border-start border-4 border-danger">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs fw-bold text-danger text-uppercase mb-1">Alertes Actives</div>
                        <div class="h4 fw-bold text-danger mb-0">{{ count($alerts) }}</div>
                        <div class="small text-muted">Détections automatiques</div>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                        <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- IA + Élèves récents -->
    <div class="row g-4">

        <!-- Alertes IA -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm radius-10 h-100">
                <div class="card-header bg-white border-0 fw-bold">
                    <i class="fa-solid fa-robot me-2 text-primary"></i>
                    Analyses Intelligentes - IA
                </div>
                <div class="card-body">

                    @forelse($alerts as $alert)
                        <div class="alert bg-{{ $alert['type'] }} bg-opacity-10 border-start border-4 border-{{ $alert['type'] }}">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-circle-info me-2 text-{{ $alert['type'] }}"></i>
                                <strong class="text-{{ $alert['type'] }}">
                                    {{ $alert['title'] }}
                                </strong>
                            </div>
                            <p class="small mb-2">{{ $alert['message'] }}</p>

                            @isset($alert['student_id'])
                            <div class="d-flex justify-content-between">
                                <span class="small text-muted">
                                    <i class="fa-solid fa-user me-1"></i>
                                    ID #{{ $alert['student_id'] }}
                                </span>
                                <a href="#" class="btn btn-sm btn-outline-{{ $alert['type'] }}">
                                    Voir détails
                                </a>
                            </div>
                            @endisset
                        </div>
                    @empty
                        <div class="alert bg-success bg-opacity-10 text-center">
                            <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                            <p class="fw-bold mb-0">Aucune alerte critique</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

        <!-- Élèves récents -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm radius-10 h-100">
                <div class="card-header bg-white border-0 fw-bold d-flex justify-content-between">
                    <span>
                        <i class="fa-solid fa-user-plus me-2 text-primary"></i>
                        Élèves Récents
                    </span>
                    <a href="{{ route('eleves.index') }}">Voir tout</a>
                </div>
                <div class="card-body p-0">

                    @forelse($recent_students as $student)
                        <div class="d-flex align-items-center px-4 py-3 border-bottom">
                            <div class="avatar-sm me-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                {{ strtoupper(substr($student->nom, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $student->nom }} {{ $student->prenom }}</div>
                                <small class="text-muted">
                                    {{ $student->matricule }} • {{ $student->classe->nom ?? 'N/A' }}
                                    <i class="fa-solid fa-{{ $student->genre == 'Féminin' ? 'venus text-danger' : 'mars text-primary' }}"></i>
                                </small>
                            </div>
                            <small class="text-muted">{{ $student->created_at->format('d/m/Y') }}</small>
                        </div>
                    @empty
                        <p class="text-center p-4 text-muted">Aucun élève récent</p>
                    @endforelse

                </div>
            </div>
        </div>

    </div>

</div>

<style>
.radius-10 { border-radius: 10px; }
.text-xs { font-size: 0.75rem; letter-spacing: .5px; }
.avatar-sm { width: 35px; height: 35px; }
</style>
@endsection
