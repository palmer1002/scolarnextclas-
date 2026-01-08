@extends('layouts.app')

@section('title', 'Modifier ' . $eleve->nom_complet . ' - ScolarNextClas')

@section('content')
<div class="container">
    <section class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-edit"></i> Modifier l'élève : {{ $eleve->nom_complet }}</h2>
            <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('eleves.update', $eleve->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label for="matricule" class="required">Matricule *</label>
                        <input type="text" id="matricule" name="matricule" value="{{ old('matricule', $eleve->matricule) }}" required 
                               placeholder="ex: SNC2025001" class="@error('matricule') is-invalid @enderror">
                        @error('matricule')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="prenom" class="required">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $eleve->prenom) }}" required 
                               placeholder="Prénom" class="@error('prenom') is-invalid @enderror">
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nom" class="required">Nom *</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $eleve->nom) }}" required 
                               placeholder="Nom de famille" class="@error('nom') is-invalid @enderror">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="genre" class="required">Genre *</label>
                        <select id="genre" name="genre" required class="@error('genre') is-invalid @enderror">
                            <option value="" disabled {{ old('genre', $eleve->genre) ? '' : 'selected' }}>Sélectionner</option>
                            <option value="Masculin" {{ old('genre', $eleve->genre) == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                            <option value="Féminin" {{ old('genre', $eleve->genre) == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                        </select>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_naissance" class="required">Date de naissance *</label>
                        <input type="date" id="date_naissance" name="date_naissance" 
                               value="{{ old('date_naissance', $eleve->date_naissance) }}" required class="@error('date_naissance') is-invalid @enderror">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_inscription" class="required">Date d'inscription *</label>
                        <input type="date" id="date_inscription" name="date_inscription" 
                               value="{{ old('date_inscription', $eleve->date_inscription ? $eleve->date_inscription->format('Y-m-d') : '') }}" required class="@error('date_inscription') is-invalid @enderror">
                        @error('date_inscription')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="classe_id">Classe *</label>
                        <select id="classe_id" name="classe_id" required class="@error('classe_id') is-invalid @enderror">
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe }}" {{ old('classe_id', $eleve->classe->niveau ?? '') == $classe ? 'selected' : '' }}>
                                    {{ $classe }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $eleve->adresse) }}" 
                               placeholder="Adresse complète">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $eleve->email) }}" 
                               placeholder="email@example.com" class="@error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone élève</label>
                        <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $eleve->telephone) }}" 
                               placeholder="+228 XX XX XX XX">
                    </div>
                    
                    <div class="form-group full-width">
                        <h4 style="color: #170B9D; margin: 20px 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <i class="fas fa-users"></i> Informations du parent/tuteur
                        </h4>
                    </div>
                    
                    <div class="form-group">
                        <label for="parent_nom">Nom du parent/tuteur *</label>
                        <input type="text" id="parent_nom" name="parent_nom" value="{{ old('parent_nom', $eleve->parent_nom) }}" required 
                               placeholder="Nom complet du parent" class="@error('parent_nom') is-invalid @enderror">
                        @error('parent_nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_relation">Relation *</label>
                        <select id="parent_relation" name="parent_relation" required class="@error('parent_relation') is-invalid @enderror">
                            <option value="">Sélectionner</option>
                            <option value="Père" {{ old('parent_relation', $eleve->parent_relation) == 'Père' ? 'selected' : '' }}>Père</option>
                            <option value="Mère" {{ old('parent_relation', $eleve->parent_relation) == 'Mère' ? 'selected' : '' }}>Mère</option>
                            <option value="Tuteur" {{ old('parent_relation', $eleve->parent_relation) == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                            <option value="Frère/Sœur" {{ old('parent_relation', $eleve->parent_relation) == 'Frère/Sœur' ? 'selected' : '' }}>Frère/Sœur</option>
                            <option value="Autre" {{ old('parent_relation', $eleve->parent_relation) == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('parent_relation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_telephone">Téléphone parent *</label>
                        <input type="tel" id="parent_telephone" name="parent_telephone" 
                               value="{{ old('parent_telephone', $eleve->parent_telephone) }}" required 
                               placeholder="+228 XX XX XX XX" class="@error('parent_telephone') is-invalid @enderror">
                        @error('parent_telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_email">Email parent</label>
                        <input type="email" id="parent_email" name="parent_email" 
                               value="{{ old('parent_email', $eleve->parent_email) }}" 
                               placeholder="parent@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut">
                            <option value="actif" {{ old('statut', $eleve->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ old('statut', $eleve->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                            <option value="gradué" {{ old('statut', $eleve->statut) == 'gradué' ? 'selected' : '' }}>Gradué</option>
                            <option value="abandon" {{ old('statut', $eleve->statut) == 'abandon' ? 'selected' : '' }}>Abandon</option>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="notes">Notes supplémentaires</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Allergies, conditions médicales, remarques...">{{ old('notes', $eleve->notes) }}</textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-outline">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    input, select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1rem;
        font-family: inherit;
        transition: border 0.3s;
    }
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23999' viewBox='0 0 16 16'%3E%3Cpath d='M3.204 5.12a.5.5 0 0 1 .697-.06L8 8.293l4.099-3.233a.5.5 0 0 1 .64.768l-4.5 3.547a.5.5 0 0 1-.597 0L3.26 5.83a.5.5 0 0 1-.056-.71z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
    }
    input:focus, select:focus, textarea:focus {
        border-color: #170B9D;
        outline: none;
        box-shadow: 0 0 0 2px rgba(23, 11, 157, 0.1);
    }

    .btn-primary {
        background: linear-gradient(90deg,#170B9D 0%,#0f076d 100%);
        color: white;
        border: none;
        box-shadow: 0 6px 18px rgba(23,11,157,0.12);
    }
    textarea {
        min-height: 120px;
        resize: vertical;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 5px;
    }
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection