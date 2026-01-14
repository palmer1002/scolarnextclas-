@extends('layouts.app')

@section('title', 'Détails du Paiement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary mb-0"><i class="fas fa-receipt me-2"></i> Détails du Paiement</h2>
            <p class="text-muted mb-0">Informations complètes et historique</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
            <a href="{{ route('paiements.download', $paiement->id) }}" class="btn btn-outline-primary shadow-sm">
                <i class="fas fa-download me-1"></i> Télécharger PDF
            </a>
            <button class="btn btn-success shadow-sm" onclick="window.print()">
                <i class="fas fa-print me-1"></i> Imprimer
            </button>
        </div>
    </div>

    <!-- Section Reçu (Visible uniquement à l'impression) -->
    <div class="d-none d-print-block receipt-container">
        <div class="receipt-header text-center mb-4">
            <h1 class="display-6 fw-bold text-uppercase mb-0">scolarnextclas</h1>
            <p class="mb-0 text-muted">Système de Gestion Scolaire Moderne</p>
            <hr class="my-3">
            <h2 class="fw-bold">REÇU DE PAIEMENT</h2>
            <div class="small text-muted">Référence: {{ $paiement->numero_recu ?? $paiement->reference }}</div>
        </div>

        <div class="receipt-body m-4">
            <div class="row mb-4">
                <div class="col-6">
                    <p class="mb-1 fw-bold text-dark">DÉLIVRÉ À :</p>
                    <p class="mb-0 text-uppercase fw-bold">{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</p>
                    <p class="mb-0 small text-muted">Matricule : {{ $paiement->eleve->matricule }}</p>
                    <p class="mb-0 small text-muted">Classe : {{ $paiement->eleve->classe->nom ?? 'N/A' }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="mb-1 fw-bold text-dark">DATE D'ÉMISSION :</p>
                    <p class="mb-0">{{ now()->format('d/m/Y') }}</p>
                    <p class="mb-0 small text-muted">Date du paiement : {{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y') : $paiement->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Désignation</th>
                        <th>Mode</th>
                        <th>Montant Total</th>
                        <th>Montant Payé</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $paiement->type_paiement }}</span><br>
                            <small class="text-muted">{{ $paiement->description ?? 'Règlement scolaire' }}</small>
                        </td>
                        <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                        <td>{{ number_format($paiement->montant_total, 0, ',', ' ') }} FCFA</td>
                        <td class="fw-bold fs-5">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tbody>
            </table>

            <div class="row mt-4">
                <div class="col-7">
                    <div class="p-3 border rounded">
                        <p class="mb-1 small fw-bold text-muted">RÉSUMÉ DU COMPTE</p>
                        <div class="d-flex justify-content-between mb-1">
                            <span>TOTAL À PAYER :</span>
                            <span class="fw-bold">{{ number_format($paiement->montant_total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1 text-success">
                            <span>TOTAL VERSÉ :</span>
                            <span class="fw-bold">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top text-danger fs-5">
                            <span class="fw-bold">RESTE À PAYER :</span>
                            <span class="fw-bold">{{ number_format($paiement->montant_restant, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
                <div class="col-5 text-center pt-4">
                    <p class="fw-bold mb-5 pb-3">SIGNATURE ET CACHET</p>
                    <div class="mt-5 border-top pt-2">scolarnextclas Administration</div>
                </div>
            </div>
        </div>

        <div class="receipt-footer mt-5 pt-5 text-center small text-muted border-top border-dotted">
            <p>Merci pour votre confiance. En cas de litige, seul ce reçu fait foi.</p>
            <p>Document généré électroniquement par scolarnextclas</p>
        </div>
    </div>

    <!-- Interface Standard (Cachée à l'impression) -->
    <div class="d-print-none">
        <div id="paiement-details">
            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card shadow border-0 radius-10 mb-4">
                        <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Informations Générales</h5>
                            <span class="badge {{ $paiement->statut == 'payé' ? 'bg-success' : ($paiement->statut == 'en_attente' ? 'bg-warning text-dark' : ($paiement->statut == 'partiel' ? 'bg-info' : 'bg-danger')) }} fs-6 px-3 py-2 rounded-pill">
                                {{ ucfirst($paiement->statut) }}
                            </span>
                        </div>
                        <div class="card-body p-4 pt-0">
                            <div class="row mb-4">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="text-muted small fw-bold text-uppercase">Référence / Reçu</label>
                                    <div class="fs-5 fw-bold text-dark">{{ $paiement->numero_recu ?? 'N/A' }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small fw-bold text-uppercase">Référence Interne</label>
                                    <div class="fs-5 fw-bold text-dark">{{ $paiement->reference ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <label class="text-muted small fw-bold text-uppercase">Type de frais</label>
                                    <div><span class="badge bg-light text-dark border">{{ $paiement->type_paiement }}</span></div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small fw-bold text-uppercase">Mode de Règlement</label>
                                    <div class="text-dark">{{ ucfirst($paiement->mode_paiement) ?? 'Non spécifié' }}</div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="text-muted small fw-bold text-uppercase">Description</label>
                                <div class="text-muted p-2 bg-light rounded">{{ $paiement->description ?? 'Aucune description' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow border-0 radius-10">
                        <div class="card-header bg-white p-4 border-0">
                            <h5 class="mb-0 fw-bold">Informations de l'Élève</h5>
                        </div>
                        <div class="card-body p-4 pt-0">
                            @if($paiement->eleve)
                            <div class="d-flex align-items-center">
                                <div class="avatar-lg me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3 text-uppercase">
                                    {{ substr($paiement->eleve->nom, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fs-5 fw-bold text-dark">{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</div>
                                    <div class="text-muted">Matricule: {{ $paiement->eleve->matricule }} • Classe: {{ $paiement->eleve->classe->nom ?? 'N/A' }}</div>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-warning">Données élève indisponibles</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow border-0 radius-10 mb-4">
                        <div class="card-header bg-white p-4 border-0">
                            <h5 class="mb-0 fw-bold">État Financier</h5>
                        </div>
                        <div class="card-body p-4 pt-0">
                            <div class="mb-4 p-3 bg-light rounded border-start border-4 border-primary">
                                <label class="text-muted small fw-bold text-uppercase">Montant Total</label>
                                <div class="h3 fw-bold text-primary mb-0">{{ number_format($paiement->montant_total, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="p-3 bg-success bg-opacity-10 rounded text-center">
                                        <label class="text-success small fw-bold text-uppercase">Réglé</label>
                                        <div class="h5 fw-bold text-success mb-0">{{ number_format($paiement->montant_paye, 0, ',', ' ') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-danger bg-opacity-10 rounded text-center">
                                        <label class="text-danger small fw-bold text-uppercase">Reste</label>
                                        <div class="h5 fw-bold text-danger mb-0">{{ number_format($paiement->montant_restant, 0, ',', ' ') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                @php $pourcentage = $paiement->montant_total > 0 ? round(($paiement->montant_paye / $paiement->montant_total) * 100) : 0; @endphp
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small fw-bold">Progression du règlement</span>
                                    <span class="small fw-bold text-primary">{{ $pourcentage }}%</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $pourcentage }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow border-0 radius-10">
                        <div class="card-header bg-white p-4 border-0">
                            <h5 class="mb-0 fw-bold">Historique & Dates</h5>
                        </div>
                        <div class="card-body p-4 pt-0">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between bg-transparent border-0 px-0">
                                    <span class="text-muted small fw-bold text-uppercase">Enregistré le</span>
                                    <span class="fw-bold">{{ $paiement->created_at->format('d/m/Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between bg-transparent border-0 px-0">
                                    <span class="text-muted small fw-bold text-uppercase">Échéance</span>
                                    <span class="fw-bold text-danger">{{ $paiement->date_echeance ? $paiement->date_echeance->format('d/m/Y') : 'N/A' }}</span>
                                </li>
                                @if($paiement->date_paiement)
                                <li class="list-group-item d-flex justify-content-between bg-transparent border-0 px-0">
                                    <span class="text-muted small fw-bold text-uppercase">Effectué le</span>
                                    <span class="fw-bold text-success">{{ $paiement->date_paiement->format('d/m/Y') }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .radius-10 { border-radius: 10px; }
    .avatar-lg { width: 60px; height: 60px; }
    
    @media print {
        body { background: white !important; }
        .sidebar, .navbar, .btn, .d-print-none { display: none !important; }
        .content { margin-left: 0 !important; padding: 0 !important; }
        .receipt-container { 
            display: block !important; 
            padding: 2.5cm !important; 
            border: none !important; 
        }
        .table-bordered { border: 2px solid #000 !important; }
        .table-bordered th, .table-bordered td { border: 1px solid #000 !important; }
        .border-dotted { border-top: 1px dashed #000 !important; }
    }
</style>