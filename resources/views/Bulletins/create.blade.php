@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Créer un bulletin</h2>

    <!-- Message de succès ou d'erreur -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bulletins.store') }}" method="POST">
        @csrf

        <!-- Élève -->
        <div class="mb-3">
            <label for="eleve_id" class="form-label">Élève</label>
            <select name="eleve_id" id="eleve_id" class="form-select" required>
                <option value="">-- Choisir un élève --</option>
                @foreach($eleves as $eleve)
                    <option value="{{ $eleve->id }}">
                        {{ $eleve->nom }} {{ $eleve->prenom }} - {{ $eleve->classe->niveau }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Année scolaire -->
        <div class="mb-3">
            <label for="annee_scolaire" class="form-label">Année scolaire</label>
            <input type="text" name="annee_scolaire" id="annee_scolaire" class="form-control" placeholder="2025-2026" required>
        </div>

        <!-- Type de période -->
        <div class="mb-3">
            <label for="periodType" class="form-label">Type de période</label>
            <select name="periodType" id="periodType" class="form-select" required>
                <option value="">-- Choisir --</option>
                <option value="trimestre">Trimestre</option>
                <option value="semestre">Semestre</option>
            </select>
        </div>

        <!-- Champ trimestre -->
        <div class="mb-3" id="trimestreField" style="display:none;">
            <label for="trimestre" class="form-label">Numéro du trimestre</label>
            <input type="number" name="trimestre" id="trimestre" class="form-control" min="1" max="3">
        </div>

        <!-- Champ semestre -->
        <div class="mb-3" id="semestreField" style="display:none;">
            <label for="semestre" class="form-label">Numéro du semestre</label>
            <input type="number" name="semestre" id="semestre" class="form-control" min="1" max="2">
        </div>

        <!-- Moyenne générale -->
        <div class="mb-3">
            <label for="moyenne" class="form-label">Moyenne générale</label>
            <input type="number" step="0.01" name="moyenne" id="moyenne" class="form-control" required>
        </div>

        <!-- Option: remplacer le bulletin existant si présent -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="1" id="replace_existing" name="replace_existing">
            <label class="form-check-label" for="replace_existing">Remplacer le bulletin existant si présent</label>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('bulletins.index') }}" class="btn btn-secondary">Annuler</a>
    </form>

    @if(session('existing_bulletin'))
        <div class="alert alert-warning mt-3">
            <strong>Remarque :</strong> Un bulletin existe déjà pour l'élève et la période sélectionnés. <a href="{{ session('existing_bulletin') }}">Voir le bulletin existant</a> ou cochez "Remplacer le bulletin existant" pour le mettre à jour.
        </div>
    @endif
</div>

<!-- Script pour afficher le champ correct -->
<script>
    document.getElementById('periodType').addEventListener('change', function() {
        let type = this.value;
        document.getElementById('trimestreField').style.display = (type === 'trimestre') ? 'block' : 'none';
        document.getElementById('semestreField').style.display = (type === 'semestre') ? 'block' : 'none';
    });
</script>
@endsection
