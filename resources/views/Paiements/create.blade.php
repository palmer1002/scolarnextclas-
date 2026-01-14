@extends('layouts.app')

@section('title', 'Nouveau Paiement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary mb-0"><i class="fas fa-plus-circle me-2"></i> Nouveau Paiement</h2>
            <p class="text-muted mb-0">Enregistrer un nouveau règlement scolaire</p>
        </div>
        <a href="{{ route('paiements.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <!-- Instructions -->
    <div class="alert bg-primary bg-opacity-10 border-0 border-start border-4 border-primary mb-4 p-3 shadow-sm">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle me-3 text-primary fs-4"></i>
            <div>
                <strong>Instructions :</strong> Remplissez les informations obligatoires. 
                Le numéro de reçu sera généré automatiquement après validation.
            </div>
        </div>
    </div>

    <div class="card shadow border-0 radius-10">
        <div class="card-body p-4">
            <form id="form-paiement" action="{{ route('paiements.store') }}" method="POST">
                @csrf
                
                <div class="row g-4">
                    <!-- Informations de base -->
                    <div class="col-md-12">
                        <h5 class="text-secondary border-bottom pb-2 mb-0"><i class="fas fa-id-card-alt me-2"></i>Bénéficiaire et Période</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="eleve_id" class="form-label fw-bold">Élève <span class="text-danger">*</span></label>
                        <select id="eleve_id" name="eleve_id" class="form-select select2 @error('eleve_id') is-invalid @enderror" required>
                            <option value="">Sélectionner un élève...</option>
                            @foreach(\App\Models\Eleve::all() as $eleve)
                                <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                    {{ $eleve->nom }} {{ $eleve->prenom }} ({{ $eleve->matricule }})
                                </option>
                            @endforeach
                        </select>
                        @error('eleve_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="type_paiement" class="form-label fw-bold">Type de Paiement <span class="text-danger">*</span></label>
                        <select id="type_paiement" name="type_paiement" class="form-select @error('type_paiement') is-invalid @enderror" required>
                            <option value="">Choisir...</option>
                            @php $types = ['Scolarité', 'Cantine', 'Transport', 'Fournitures', 'Autre']; @endphp
                            @foreach($types as $type)
                                <option value="{{ $type }}" {{ old('type_paiement') == $type ? 'selected' : '' }}>{{ $type }}</option>
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
                        <label for="montant_total" class="form-label fw-bold">Montant Total <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <input type="number" id="montant_total" name="montant_total" class="form-control @error('montant_total') is-invalid @enderror" placeholder="0" value="{{ old('montant_total') }}" required>
                            <span class="input-group-text bg-light">FCFA</span>
                            @error('montant_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="montant_paye" class="form-label fw-bold">Montant Versé</label>
                        <div class="input-group has-validation">
                            <input type="number" id="montant_paye" name="montant_paye" class="form-control @error('montant_paye') is-invalid @enderror" placeholder="0" value="{{ old('montant_paye', 0) }}">
                            <span class="input-group-text bg-light">FCFA</span>
                            @error('montant_paye')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold text-muted">Reste à payer</label>
                        <div class="h4 mb-0 fw-bold text-success p-2 bg-light rounded text-center border" id="reste-display">
                            0 FCFA
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="mode_paiement" class="form-label fw-bold text-dark">Mode de Règlement</label>
                        <select id="mode_paiement" name="mode_paiement" class="form-select @error('mode_paiement') is-invalid @enderror">
                            @php $modes = ['espèces' => 'Espèces', 'chèque' => 'Chèque', 'virement' => 'Virement', 'mobile_money' => 'Mobile Money']; @endphp
                            @foreach($modes as $val => $label)
                                <option value="{{ $val }}" {{ old('mode_paiement') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('mode_paiement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="date_echeance" class="form-label fw-bold text-dark">Date d'Échéance</label>
                        <input type="date" id="date_echeance" name="date_echeance" class="form-control @error('date_echeance') is-invalid @enderror" value="{{ old('date_echeance', now()->addMonth()->format('Y-m-d')) }}">
                        @error('date_echeance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-bold text-dark">Notes / Observations</label>
                        <textarea id="description" name="description" class="form-control" rows="2" placeholder="Ex: Premier versement scolarité T1"></textarea>
                    </div>

                    <div class="col-md-12 mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="{{ route('paiements.index') }}" class="btn btn-light border px-4">Annuler</a>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                            <i class="fas fa-save me-1"></i> Enregistrer le Paiement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: "Rechercher un élève..."
        });

        $('#montant_total, #montant_paye').on('input', function() {
            const total = parseFloat($('#montant_total').val()) || 0;
            const paye = parseFloat($('#montant_paye').val()) || 0;
            const reste = total - paye;
            
            const resteEl = $('#reste-display');
            resteEl.text(reste.toLocaleString('fr-FR') + ' FCFA');
            
            if (reste > 0) resteEl.removeClass('text-success').addClass('text-danger');
            else resteEl.removeClass('text-danger').addClass('text-success');
        });
    });
</script>
@endpush

<style>
    .radius-10 { border-radius: 10px; }
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 0.375rem;
        height: calc(3.5rem + 2px);
    }
</style>
@endsection