@extends('layouts.user_app')

@section('title', 'Gestion des Paiements - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Gestion des Paiements</h1>
            <p class="mb-0 text-muted">Suivi des frais scolaires</p>
        </div>
        <a href="{{ route('paiements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouveau Paiement
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Statistiques Rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Payé</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format(\App\Models\Paiement::sum('montant_paye'), 0, ',', ' ') }} FCFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Paiements</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>N° Reçu</th>
                            <th>Élève</th>
                            <th>Type</th>
                            <th>Montant Total</th>
                            <th>Payé</th>
                            <th>Reste</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                            <td>{{ $paiement->numero_recu ?? '-' }}</td>
                            <td>
                                @if($paiement->eleve)
                                    {{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}
                                @else
                                    <span class="text-muted">Élève supprimé</span>
                                @endif
                            </td>
                            <td>{{ $paiement->type_paiement }}</td>
                            <td>{{ number_format($paiement->montant_total, 0, ',', ' ') }} FCFA</td>
                            <td class="text-success">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                            <td class="text-danger">{{ number_format($paiement->montant_restant ?? ($paiement->montant_total - $paiement->montant_paye), 0, ',', ' ') }} FCFA</td>
                            <td>
                                @php
                                    $badges = [
                                        'payé' => 'success',
                                        'en_attente' => 'warning',
                                        'partiel' => 'info',
                                        'retard' => 'danger'
                                    ];
                                    $badge = $badges[$paiement->statut] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($paiement->statut) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('paiements.edit', $paiement->id) }}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('paiements.destroy', $paiement->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Supprimer ce paiement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Aucun paiement enregistré.</td>
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
@endsection