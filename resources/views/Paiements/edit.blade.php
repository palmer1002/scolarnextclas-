@extends('layouts.app')

@section('title', 'Modifier le Paiement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary mb-0"><i class="fas fa-edit me-2"></i> Modifier le Paiement</h2>
            <p class="text-muted mb-0">Mise à jour des informations de règlement</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('paiements.show', $paiement->id) }}" class="btn btn-outline-info">
                <i class="fas fa-eye me-1"></i> Consulter
            </a>
            <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card shadow border-0 radius-10">
        <div class="card-body p-4">
            <form id="form-edit-paiement" action="{{ route('paiements.update', $paiement->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <!-- Informations de base -->
                    <div class="col-md-12">
                        <h5 class="text-secondary border-bottom pb-2 mb-0"><i class="fas fa-id-card-alt me-2"></i>Bénéficiaire et Période</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Élève (Non modifiable)</label>
                        <input type="text" class="form-control bg-light" value="{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }} ({{ $paiement->eleve->matricule }})" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="type_paiement" class="form-label fw-bold text-dark">Type de Paiement</label>
                        <select id="type_paiement" name="type_paiement" class="form-select @error('type_paiement') is-invalid @enderror" required>
                            @php $types = ['Scolarité', 'Cantine', 'Transport', 'Fournitures', 'Autre']; @endphp
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type_paiement', $paiement->type_paiement) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('type_paiement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Montants -->
                    <div class="col-md-12">
                        <h5 class="text-secondary border-bottom pb-2 mb-0"><i class="fas fa-money-check-alt me-2"></i>Détails Financiers</h5>
                    </div>

                    <div class="col-md-4">
                        <label for="montant_total" class="form-label fw-bold text-dark">Montant Total</label>
                        <div class="input-group has-validation">
                            <input type="number" id="montant_total" name="montant_total" class="form-control @error('montant_total') is-invalid @enderror" value="{{ old('montant_total', $paiement->montant_total) }}" required>
                            <span class="input-group-text bg-light">FCFA</span>
                            @error('montant_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="montant_paye" class="form-label fw-bold text-dark">Montant Versé</label>
                        <div class="input-group has-validation">
                            <input type="number" id="montant_paye" name="montant_paye" class="form-control @error('montant_paye') is-invalid @enderror" value="{{ old('montant_paye', $paiement->montant_paye) }}">
                            <span class="input-group-text bg-light">FCFA</span>
                            @error('montant_paye')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted text-dark">Reste à payer</label>
                        <div class="h4 mb-0 fw-bold p-2 bg-light rounded text-center border" id="reste-display">
                            {{ number_format($paiement->montant_total - $paiement->montant_paye, 0, ',', ' ') }} FCFA
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="statut" class="form-label fw-bold text-dark">Statut</label>
                        <select id="statut" name="statut" class="form-select @error('statut') is-invalid @enderror" required>
                            @php $statuts = ['payé' => 'Payé', 'en_attente' => 'En attente', 'partiel' => 'Partiel', 'annulé' => 'Annulé', 'remboursé' => 'Remboursé']; @endphp
                            @foreach($statuts as $val => $label)
                                <option value="{{ $val }}" {{ old('statut', $paiement->statut) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="mode_paiement" class="form-label fw-bold text-dark">Mode de Règlement</label>
                        <select id="mode_paiement" name="mode_paiement" class="form-select @error('mode_paiement') is-invalid @enderror">
                             @php $modes = ['espèces' => 'Espèces', 'chèque' => 'Chèque', 'virement' => 'Virement', 'mobile_money' => 'Mobile Money']; @endphp
                            @foreach($modes as $val => $label)
                                <option value="{{ $val }}" {{ old('mode_paiement', $paiement->mode_paiement) == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('mode_paiement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-bold text-dark">Notes / Observations</label>
                        <textarea id="description" name="description" class="form-control" rows="2">{{ $paiement->description }}</textarea>
                    </div>

                    <div class="col-md-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('paiements.index') }}" class="btn btn-light border px-4 text-dark">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Mettre à jour le Paiement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#montant_total, #montant_paye').on('input', function() {
            const total = parseFloat($('#montant_total').val()) || 0;
            const paye = parseFloat($('#montant_paye').val()) || 0;
            const reste = total - paye;
            
            const resteEl = $('#reste-display');
            resteEl.text(reste.toLocaleString('fr-FR') + ' FCFA');
            
            if (reste > 0) resteEl.attr('class', 'h4 mb-0 fw-bold p-2 bg-light rounded text-center border text-danger');
            else resteEl.attr('class', 'h4 mb-0 fw-bold p-2 bg-light rounded text-center border text-success');
        });
    });
</script>
@endpush

<style>
    .radius-10 { border-radius: 10px; }
</style>
@endsection