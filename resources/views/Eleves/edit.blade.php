@extends('layouts.app')

@section('title', 'Modifier Élève - ' . $eleve->nom_complet)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-warning"><i class="fas fa-user-edit me-2"></i> Modifier l'Élève</h2>
                <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-body p-4">
                    <form action="{{ route('eleves.update', $eleve->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <h5 class="mb-3 text-secondary border-bottom pb-2">Informations de l'Élève</h5>
                            
                            <div class="col-md-4">
                                <label for="matricule" class="form-label fw-bold">Matricule <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="matricule" name="matricule" value="{{ old('matricule', $eleve->matricule) }}" required>
                                @error('matricule')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="prenom" class="form-label fw-bold">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $eleve->prenom) }}" required>
                                @error('prenom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="nom" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $eleve->nom) }}" required>
                                @error('nom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="genre" class="form-label fw-bold">Genre <span class="text-danger">*</span></label>
                                <select class="form-select" id="genre" name="genre" required>
                                    <option value="" disabled {{ old('genre', $eleve->genre) ? '' : 'selected' }}>Sélectionner</option>
                                    <option value="masculin" {{ old('genre', $eleve->genre) == 'masculin' ? 'selected' : '' }}>Masculin</option>
                                    <option value="feminin" {{ old('genre', $eleve->genre) == 'feminin' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('genre')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="date_naissance" class="form-label fw-bold">Date de naissance <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $eleve->date_naissance) }}" required>
                                @error('date_naissance')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="classe_id" class="form-label fw-bold">Classe <span class="text-danger">*</span></label>
                                <select class="form-select" id="classe_id" name="classe_id" required>
                                    <option value="">Sélectionner...</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_id', $eleve->classe_id) == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classe_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="date_inscription" class="form-label fw-bold">Date d'inscription <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_inscription" name="date_inscription" 
                                       value="{{ old('date_inscription', $eleve->date_inscription ? $eleve->date_inscription->format('Y-m-d') : '') }}" required>
                                @error('date_inscription')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="col-md-6">
                                <label for="statut" class="form-label fw-bold">Statut</label>
                                <select class="form-select" id="statut" name="statut">
                                    <option value="actif" {{ old('statut', $eleve->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactif" {{ old('statut', $eleve->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                    <option value="gradué" {{ old('statut', $eleve->statut) == 'gradué' ? 'selected' : '' }}>Gradué</option>
                                    <option value="abandon" {{ old('statut', $eleve->statut) == 'abandon' ? 'selected' : '' }}>Abandon</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse', $eleve->adresse) }}">
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email Élève (optionnel)</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $eleve->email) }}">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone Élève (optionnel)</label>
                                <input type="tel" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $eleve->telephone) }}">
                            </div>

                            <h5 class="mt-4 mb-3 text-secondary border-bottom pb-2">Informations du Parent / Tuteur</h5>

                            <div class="col-md-6">
                                <label for="parent_nom" class="form-label fw-bold">Nom du parent <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="parent_nom" name="parent_nom" value="{{ old('parent_nom', $eleve->parent_nom) }}" required>
                                @error('parent_nom')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="parent_relation" class="form-label fw-bold">Relation <span class="text-danger">*</span></label>
                                <select class="form-select" id="parent_relation" name="parent_relation" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="Père" {{ old('parent_relation', $eleve->parent_relation) == 'Père' ? 'selected' : '' }}>Père</option>
                                    <option value="Mère" {{ old('parent_relation', $eleve->parent_relation) == 'Mère' ? 'selected' : '' }}>Mère</option>
                                    <option value="Tuteur" {{ old('parent_relation', $eleve->parent_relation) == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                                    <option value="Frère/Sœur" {{ old('parent_relation', $eleve->parent_relation) == 'Frère/Sœur' ? 'selected' : '' }}>Frère/Sœur</option>
                                    <option value="Autre" {{ old('parent_relation', $eleve->parent_relation) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('parent_relation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="parent_telephone" class="form-label fw-bold">Téléphone parent <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="parent_telephone" name="parent_telephone" value="{{ old('parent_telephone', $eleve->parent_telephone) }}" required>
                                @error('parent_telephone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="parent_email" class="form-label">Email parent</label>
                                <input type="email" class="form-control" id="parent_email" name="parent_email" value="{{ old('parent_email', $eleve->parent_email) }}">
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label">Notes supplémentaires</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $eleve->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-light border">Annuler</a>
                            <button type="submit" class="btn btn-warning px-4 text-white fw-bold">
                                <i class="fas fa-save me-1"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection