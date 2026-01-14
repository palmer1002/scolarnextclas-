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

    <div class="card shadow border-0 radius-10 mb-4">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">Informations Élève</h5>
                    <p class="mb-1"><strong>Nom :</strong> {{ $eleve->nomComplet }}</p>
                    <p class="mb-1"><strong>Matricule :</strong> {{ $eleve->matricule }}</p>
                    <p class="mb-1"><strong>Classe :</strong> {{ $eleve->classe->nom ?? '—' }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="fw-bold mb-3">Période Scolaire</h5>
                    <p class="mb-1"><strong>Type :</strong> {{ explode('-', $periode)[0] }}</p>
                    <p class="mb-1"><strong>Numéro :</strong> {{ explode('-', $periode)[1] }}</p>
                    <p class="mb-1"><strong>Année :</strong> {{ $eleve->annee_scolaire ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 radius-10">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Matière</th>
                            <th>Moyenne</th>
                            <th>Coefficient</th>
                            <th class="text-end pe-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resultats as $res)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $res['matiere'] }}</td>
                                <td>{{ number_format($res['moyenne'], 2) }}/20</td>
                                <td>x{{ $res['coef'] }}</td>
                                <td class="text-end pe-4 fw-bold text-primary">{{ number_format($res['points'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="ps-4 fw-bold text-uppercase">Moyenne Générale</td>
                            <td class="text-end pe-4 fw-bold h5 text-success mb-0">
                                {{ number_format($moyenneGenerale, 2) }}/20
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection