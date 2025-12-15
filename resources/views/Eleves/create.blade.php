@extends('layouts.app')

@section('title', 'Ajouter un Élève - ScolarNextClas')

@section('content')
<div class="container">
    <section class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-user-plus"></i> Ajouter un nouvel élève</h2>
            <a href="{{ route('eleves.index') }}" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('eleves.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="prenom">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required 
                               placeholder="Prénom" class="@error('prenom') is-invalid @enderror">
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom *</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required 
                               placeholder="Nom de famille" class="@error('nom') is-invalid @enderror">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre *</label>
                        <select id="genre" name="genre" required class="@error('genre') is-invalid @enderror">
                            <option value="">Sélectionner</option>
                            <option value="Masculin" {{ old('genre') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                            <option value="Féminin" {{ old('genre') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                        </select>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_naissance">Date de naissance *</label>
                        <input type="date" id="date_naissance" name="date_naissance" 
                               value="{{ old('date_naissance') }}" required class="@error('date_naissance') is-invalid @enderror">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="classe_id">Classe *</label>
                        <select id="classe_id" name="classe_id" required class="@error('classe_id') is-invalid @enderror">
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" 
                               placeholder="Adresse complète">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               placeholder="email@example.com" class="@error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone élève</label>
                        <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" 
                               placeholder="+228 XX XX XX XX">
                    </div>
                    
                    <div class="form-group full-width">
                        <h4 style="color: #170B9D; margin: 20px 0 15px 0; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <i class="fas fa-users"></i> Informations du parent/tuteur
                        </h4>
                    </div>
                    
                    <div class="form-group">
                        <label for="parent_nom">Nom du parent/tuteur *</label>
                        <input type="text" id="parent_nom" name="parent_nom" value="{{ old('parent_nom') }}" required 
                               placeholder="Nom complet du parent" class="@error('parent_nom') is-invalid @enderror">
                        @error('parent_nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_relation">Relation *</label>
                        <select id="parent_relation" name="parent_relation" required class="@error('parent_relation') is-invalid @enderror">
                            <option value="">Sélectionner</option>
                            <option value="Père" {{ old('parent_relation') == 'Père' ? 'selected' : '' }}>Père</option>
                            <option value="Mère" {{ old('parent_relation') == 'Mère' ? 'selected' : '' }}>Mère</option>
                            <option value="Tuteur" {{ old('parent_relation') == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                            <option value="Frère/Sœur" {{ old('parent_relation') == 'Frère/Sœur' ? 'selected' : '' }}>Frère/Sœur</option>
                            <option value="Autre" {{ old('parent_relation') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('parent_relation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_telephone">Téléphone parent *</label>
                        <input type="tel" id="parent_telephone" name="parent_telephone" value="{{ old('parent_telephone') }}" required 
                               placeholder="+228 XX XX XX XX" class="@error('parent_telephone') is-invalid @enderror">
                        @error('parent_telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="parent_email">Email parent</label>
                        <input type="email" id="parent_email" name="parent_email" value="{{ old('parent_email') }}" 
                               placeholder="parent@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="statut">Statut</label>
                        <select id="statut" name="statut">
                            <option value="actif" {{ old('statut', 'actif') == 'actif' ? 'selected' : '' }}>Actif</option>
                            <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                            <option value="gradué" {{ old('statut') == 'gradué' ? 'selected' : '' }}>Gradué</option>
                            <option value="abandon" {{ old('statut') == 'abandon' ? 'selected' : '' }}>Abandon</option>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="notes">Notes supplémentaires</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Allergies, conditions médicales, remarques...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 30px;">
                    <a href="{{ route('eleves.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer l'élève
                    </button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    /* Styles spécifiques au formulaire */
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
    input:focus, select:focus, textarea:focus {
        border-color: #170B9D;
        outline: none;
        box-shadow: 0 0 0 2px rgba(23, 11, 157, 0.1);
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