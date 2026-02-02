@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-file-invoice me-2"></i> Bulletin de Notes</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('bulletins.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
            <a href="{{ route('bulletins.exportPdf', [$eleve->id, $periode]) }}" class="btn btn-success">
                <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="card shadow border-0 radius-10 mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <h5 class="fw-bold mb-3 text-secondary text-uppercase small">Informations Élève</h5>
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-light-primary text-primary rounded-circle me-3 p-3">
                                    <i class="fas fa-user fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-bold">{{ $eleve->nomComplet }}</h4>
                                    <p class="text-muted mb-0">Matricule: {{ $eleve->matricule }}</p>
                                </div>
                            </div>
                            <p class="mb-1"><strong>Classe :</strong> <span class="badge bg-info text-dark">{{ $eleve->classe->nom ?? '—' }}</span></p>
                        </div>
                        <div class="col-md-6 ps-md-4">
                            <h5 class="fw-bold mb-3 text-secondary text-uppercase small">Période Scolaire</h5>
                            <p class="mb-1 text-muted"><strong>Type :</strong> {{ explode('-', $periode)[0] }}</p>
                            <p class="mb-1 text-muted"><strong>Numéro :</strong> {{ explode('-', $periode)[1] }}</p>
                            <p class="mb-1 text-muted"><strong>Année :</strong> 2025-2026</p>
                                <span class="badge bg-primary fs-6">{{ $periode }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th class="ps-4 py-3">Matière</th>
                                    <th>Moyenne</th>
                                    <th>Coef</th>
                                    <th>Points</th>
                                    <th>Classe (Min / Max)</th>
                                    <th class="pe-4">Appréciation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resultats as $res)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold mb-0 text-dark">{{ $res['matiere'] }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold {{ $res['moyenne'] < 10 ? 'text-danger' : 'text-success' }}">
                                                {{ number_format($res['moyenne'], 2) }}/20
                                            </div>
                                        </td>
                                        <td><span class="text-muted">x{{ $res['coef'] }}</span></td>
                                        <td><span class="fw-bold">{{ number_format($res['points'], 2) }}</span></td>
                                        <td>
                                            <div class="small">
                                                <span class="text-primary fw-bold">{{ number_format($res['moyenne_classe'], 2) }}</span>
                                                <span class="text-muted mx-1">|</span>
                                                <span class="text-secondary">{{ number_format($res['min'], 1) }} - {{ number_format($res['max'], 1) }}</span>
                                            </div>
                                        </td>
                                        <td class="pe-4 italic small">
                                            {{ $res['appreciation'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0 radius-10 bg-primary text-white mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase small mb-3 opacity-75">Moyenne Générale</h6>
                    <h2 class="display-5 fw-bold mb-0">{{ number_format($moyenneGenerale, 2) }}</h2>
                    <p class="mb-0">sur 20</p>
                    <hr class="my-3 opacity-25">
                    <div class="row text-center">
                        <div class="col-6 border-end border-white border-opacity-25">
                            <small class="d-block opacity-75">Points</small>
                            <span class="fw-bold">{{ number_format($totalPoints, 2) }}</span>
                        </div>
                        <div class="col-6">
                            <small class="d-block opacity-75">Coefficients</small>
                            <span class="fw-bold">{{ $totalCoef }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow border-0 radius-10 mb-4">
                <div class="card-body p-4">
                    <h6 class="text-uppercase small mb-3 text-muted">Résultats Global</h6>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Rang:</span>
                        <span class="fw-bold fs-5 text-primary">{{ $rang['position'] }}<sup>{{ $rang['position'] == 1 ? 'er' : 'ème' }}</sup> / {{ $rang['total'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Décision:</span>
                        <span class="badge {{ $moyenneGenerale >= 10 ? 'bg-success' : 'bg-danger' }}">
                            {{ $moyenneGenerale >= 10 ? 'Admis(e)' : 'Échec' }}
                        </span>
                    </div>
                    
                    <div class="mt-4 pt-3 border-top">
                        <p class="small text-muted mb-2">Fait le, {{ now()->translatedFormat('d F Y') }}</p>
                        <h6 class="text-uppercase small mb-3 text-muted">Signature Direction</h6>
                        <div style="height: 60px;"></div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info border-0 shadow-sm small">
                <i class="fas fa-info-circle me-1"></i> 
                Ce bulletin est généré automatiquement par le système ScolarNext.
            </div>
        </div>
    </div>
</div>
@endsection