@extends('layouts.user_app')

@section('title', 'Dashboard Élève - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue, {{ Auth::user()->name }}</h1>
            <p class="lead">Tableau de bord Élève - {{ $eleve->matricule }} ({{ $eleve->classe?->nom ?? 'N/A' }})</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Ma Classe</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $eleve->classe?->nom ?? 'N/A' }}</h5>
                            <p class="card-text small">Consultez les détails de votre classe</p>
                            <a href="{{ $eleve->classe_id ? route('classes.show', $eleve->classe_id) : '#' }}" class="btn btn-light btn-sm w-100">Détails Classe</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Moyenne Générale</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $stats['personal_moyenne'] }}/20</h5>
                            <p class="card-text small">Basée sur vos notes récentes</p>
                            <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm w-100">Mes Notes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Mes Bulletins</div>
                        <div class="card-body">
                            <h5 class="card-title">Certificats</h5>
                            <p class="card-text small">Téléchargez vos bulletins</p>
                            <a href="{{ route('bulletins.index') }}" class="btn btn-light btn-sm w-100">Accéder</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3 shadow-sm border-0">
                        <div class="card-header border-0 bg-transparent fw-bold">Présence</div>
                        <div class="card-body">
                            <h5 class="card-title text-white">{{ $stats['personal_presence_rate'] }}%</h5>
                            <p class="card-text small">Taux de présence global</p>
                            <a href="{{ $eleve->id ? route('eleves.presence.stats', $eleve->id) : '#' }}" class="btn btn-light btn-sm w-100">Détails</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0 fw-bold">Mes Dernières Notes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Matière</th>
                                            <th>Note</th>
                                            <th>Date</th>
                                            <th>Coefficient</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_notes as $note)
                                        <tr>
                                            <td class="fw-bold">{{ $note->matiere->nom ?? 'N/A' }}</td>
                                            <td class="text-{{ $note->note >= 10 ? 'success' : 'danger' }} fw-bold">{{ $note->note }}/20</td>
                                            <td>{{ $note->created_at->format('d/m/Y') }}</td>
                                            <td>x{{ $note->coefficient ?? 1 }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted italic">Aucune note enregistrée pour le moment.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white py-3">
                            <h4 class="mb-0 fw-bold">Résumé</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-center">
                                    <h5 class="fw-bold text-primary">{{ $stats['personal_moyenne'] }}</h5>
                                    <p class="text-muted small">Moyenne</p>
                                </div>
                                <div class="text-center">
                                    <h5 class="fw-bold text-success">{{ $stats['personal_presence_rate'] }}%</h5>
                                    <p class="text-muted small">Présence</p>
                                </div>
                                <div class="text-center">
                                    <h5 class="fw-bold text-danger">{{ $stats['personal_absences'] }}</h5>
                                    <p class="text-muted small">Absences</p>
                                </div>
                            </div>
                            
                            <label class="small text-muted mb-1">Taux de présence global</label>
                            <div class="progress mb-4" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $stats['personal_presence_rate'] }}%"></div>
                            </div>
                            
                            <div class="alert alert-primary border-0 bg-primary bg-opacity-10">
                                <h6 class="alert-heading fw-bold"><i class="fas fa-calendar-alt me-2"></i>Événements à venir</h6>
                                <ul class="list-unstyled mb-0 small">
                                    @forelse($evenements as $event)
                                        <li class="mb-2"><strong>{{ $event->titre }}</strong> - {{ \Carbon\Carbon::parse($event->date_debut)->format('d/m') }}</li>
                                    @empty
                                        <li>Aucun événement prévu.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection