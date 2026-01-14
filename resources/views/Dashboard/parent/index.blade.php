@extends('layouts.user_app')

@section('title', 'Dashboard Parent - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-3"><i class="fas fa-users me-2 text-primary"></i> Bienvenue, {{ Auth::user()->name }}</h1>
            <p class="lead text-muted">Tableau de bord Parent - Suivi de vos enfants</p>
            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-1"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <div class="row mt-4 g-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Mes Enfants</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $enfants_stats->count() }}</h5>
                            <p class="card-text small">Enfants inscrits</p>
                            <a href="#enfants-section" class="btn btn-light btn-sm w-100">Voir le suivi</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Notes</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $enfants_stats->sum(fn($e) => $e['eleve']->notes->count()) }}</h5>
                            <p class="card-text small">Notes enregistrées</p>
                            <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm w-100">Consulter</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Bulletins</div>
                        <div class="card-body">
                            <h5 class="card-title">Disponibles</h5>
                            <p class="card-text small">Bulletins scolaires</p>
                            <a href="{{ route('bulletins.index') }}" class="btn btn-light btn-sm w-100">Télécharger</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Présences</div>
                        <div class="card-body">
                            @php
                                $avg_presence = $enfants_stats->avg('taux_presence');
                            @endphp
                            <h5 class="card-title">{{ round($avg_presence) }}%</h5>
                            <p class="card-text small">Taux moyen</p>
                            <a href="{{ route('presences.index') }}" class="btn btn-light btn-sm w-100">Détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4" id="enfants-section">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3 border-0">
                            <h4 class="mb-0 fw-bold"><i class="fas fa-child me-2 text-primary"></i> Suivi de Mes Enfants</h4>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Nom & Prénoms</th>
                                            <th>Classe</th>
                                            <th>Moyenne</th>
                                            <th>Dernière note</th>
                                            <th>Présence</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($enfants_stats as $enfant_stat)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-3 bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                            {{ substr($enfant_stat['eleve']->nom, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $enfant_stat['eleve']->nomComplet }}</div>
                                                            <small class="text-muted">{{ $enfant_stat['eleve']->matricule }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info text-dark">{{ $enfant_stat['eleve']->classe->nom ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-{{ $enfant_stat['moyenne'] >= 10 ? 'success' : 'danger' }}">
                                                        {{ $enfant_stat['moyenne'] }}/20
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($enfant_stat['derniere_note'])
                                                        <span class="badge bg-{{ $enfant_stat['derniere_note']->note >= 10 ? 'success' : 'danger' }}">
                                                            {{ $enfant_stat['derniere_note']->note }}/20
                                                        </span>
                                                        <small class="text-muted d-block">{{ $enfant_stat['derniere_note']->created_at->format('d/m/Y') }}</small>
                                                    @else
                                                        <span class="text-muted small">Aucune note</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="progress flex-grow-1 me-2" style="height: 6px; width: 60px;">
                                                            <div class="progress-bar bg-{{ $enfant_stat['taux_presence'] >= 80 ? 'success' : 'warning' }}" 
                                                                 style="width: {{ $enfant_stat['taux_presence'] }}%"></div>
                                                        </div>
                                                        <small class="fw-bold">{{ $enfant_stat['taux_presence'] }}%</small>
                                                    </div>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('eleves.show', $enfant_stat['eleve']->id) }}" 
                                                           class="btn btn-outline-primary" title="Voir profil">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('notes.index') }}" 
                                                           class="btn btn-outline-success" title="Voir notes">
                                                            <i class="fas fa-clipboard-list"></i>
                                                        </a>
                                                        <a href="{{ route('bulletins.index') }}" 
                                                           class="btn btn-outline-warning" title="Voir bulletins">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                                                        <p>Aucun enfant enregistré pour le moment.</p>
                                                        <small>Veuillez contacter l'administration pour lier vos enfants à votre compte.</small>
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
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-sm { width: 40px; height: 40px; font-size: 1.2rem; }
    .card { border-radius: 10px; }
</style>
@endsection