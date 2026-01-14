@extends('layouts.app')

@section('title', 'Gestion des Paiements')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary mb-0"><i class="fas fa-money-bill-wave me-2"></i> Gestion des Paiements</h2>
            <p class="text-muted mb-0">Suivi des frais scolaires par élève</p>
        </div>
        <a href="{{ route('paiements.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Nouveau Paiement
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm radius-10 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Encaissé</div>
                            <div class="h5 mb-0 fw-bold">{{ number_format(\App\Models\Paiement::sum('montant_paye'), 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded text-success">
                            <i class="fas fa-hand-holding-usd fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 radius-10">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Reçu N°</th>
                            <th>Élève</th>
                            <th>Type de frais</th>
                            <th>Montant Total</th>
                            <th>Montant Payé</th>
                            <th>Reste</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                            <td class="fw-bold">{{ $paiement->numero_recu ?? '-' }}</td>
                            <td>
                                @if($paiement->eleve)
                                    <div class="fw-bold">{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</div>
                                    <small class="text-muted">{{ $paiement->eleve->matricule }}</small>
                                @else
                                    <span class="text-muted fst-italic">Élève non trouvé</span>
                                @endif
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $paiement->type_paiement }}</span></td>
                            <td>{{ number_format($paiement->montant_total, 0, ',', ' ') }}</td>
                            <td class="text-success fw-bold">{{ number_format($paiement->montant_paye, 0, ',', ' ') }}</td>
                            <td class="text-danger fw-bold">{{ number_format($paiement->montant_restant ?? ($paiement->montant_total - $paiement->montant_paye), 0, ',', ' ') }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'payé' => 'success',
                                        'en_attente' => 'warning',
                                        'partiel' => 'info',
                                        'retard' => 'danger'
                                    ];
                                    $label = [
                                        'payé' => 'Payé',
                                        'en_attente' => 'En attente',
                                        'partiel' => 'Partiel',
                                        'retard' => 'En retard'
                                    ];
                                    $badge = $badges[$paiement->statut] ?? 'secondary';
                                    $text = $label[$paiement->statut] ?? ucfirst($paiement->statut);
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $text }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-sm btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" class="m-0" onsubmit="return confirm('Confirmer la suppression de ce paiement ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-receipt fa-4x mb-3 d-block opacity-25"></i>
                                Aucun paiement enregistré.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $paiements->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        color: #5a5c69;
    }
</style>
@endsection