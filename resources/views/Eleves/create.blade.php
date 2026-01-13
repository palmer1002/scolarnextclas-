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
                    {{-- Matricule généré automatiquement --}}
                    <div class="form-group">
                        <label for="prenom" class="required">Prénom *</label>
                        <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required 
                               placeholder="Prénom" class="@error('prenom') is-invalid @enderror">
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nom" class="required">Nom *</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required 
                               placeholder="Nom de famille" class="@error('nom') is-invalid @enderror">
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="genre" class="required">Genre *</label>
                        <select id="genre" name="genre" required class="@error('genre') is-invalid @enderror">
                            <option value="" disabled {{ old('genre') ? '' : 'selected' }}>Sélectionner</option>
                            <option value="masculin" {{ old('genre') == 'masculin' ? 'selected' : '' }}>Masculin</option>
                            <option value="feminin" {{ old('genre') == 'feminin' ? 'selected' : '' }}>Féminin</option>
                        </select>
                        @error('genre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_naissance" class="required">Date de naissance *</label>
                        <input type="date" id="date_naissance" name="date_naissance" 
                               value="{{ old('date_naissance') }}" required class="@error('date_naissance') is-invalid @enderror">
                        @error('date_naissance')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date_inscription" class="required">Date d'inscription *</label>
                        <input type="date" id="date_inscription" name="date_inscription" 
                               value="{{ old('date_inscription', now()->format('Y-m-d')) }}" required class="@error('date_inscription') is-invalid @enderror">
                        @error('date_inscription')
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

@push('styles')
<style>
    /* Styles spécifiques au formulaire d'ajout d'élève */
    .card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .card-header {
        background: #170B9DFF;
        color: white;
        padding: 20px;
        border-bottom: 1px solid #eee;
    }
    .card-title {
        margin: 0;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-header a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        margin-top: 10px;
        display: inline-block;
    }
    .card-header a:hover {
        color: white;
        text-decoration: underline;
    }
    .form-container {
        padding: 30px;
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
        font-weight: 600;
        color: #333;
        font-size: 0.95rem;
    }
    input, select, textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 1rem;
        font-family: inherit;
        transition: all 0.3s;
        background-color: #fff;
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
        border-color: #170B9DFF;
        outline: none;
        box-shadow: 0 0 0 3px rgba(23, 11, 157, 0.2);
    }
    input:disabled, select:disabled {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }

    .btn-primary {
        background: linear-gradient(90deg,#170B9D 0%,#0f076d 100%);
        color: white;
        border: none;
        box-shadow: 0 6px 18px rgba(23,11,157,0.15);
        transition: transform 0.18s, box-shadow 0.18s;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 26px rgba(23,11,157,0.18);
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
        display: block;
    }
    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-primary {
        background: #170B9DFF;
        color: white;
        border: none;
    }
    .btn-primary:hover {
        background: #0f076d;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(23, 11, 157, 0.3);
    }
    .btn-outline {
        background: transparent;
        color: #170B9DFF;
        border: 2px solid #170B9DFF;
    }
    .btn-outline:hover {
        background: #170B9DFF;
        color: white;
    }
    .required:after {
        content: " *";
        color: #dc3545;
    }
    .form-section {
        padding: 20px 0;
        margin: 20px 0;
        border-bottom: 1px solid #eee;
    }
    .form-section-title {
        font-size: 1.2rem;
        color: #170B9DFF;
        margin: 20px 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush