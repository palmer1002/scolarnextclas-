@extends('layouts.app')

@section('title', 'Modifier un Parent')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-warning"><i class="fas fa-user-edit me-2"></i> Modifier Parent</h2>
                <a href="{{ route('parents.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-body p-4">
                    <form action="{{ route('parents.update', $parent->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-3">
                            <h5 class="mb-3 text-secondary border-bottom pb-2">Informations Personnelles</h5>
                            
                            <div class="col-md-6">
                                <label for="nom_complet" class="form-label fw-bold">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom_complet" name="nom_complet" value="{{ old('nom_complet', $parent->nom_complet) }}" required>
                                @error('nom_complet')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telephone" class="form-label fw-bold">Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $parent->telephone) }}" required>
                                @error('telephone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $parent->email) }}">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="profession" class="form-label">Profession</label>
                                <input type="text" class="form-control" id="profession" name="profession" value="{{ old('profession', $parent->profession) }}">
                                @error('profession')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{ old('adresse', $parent->adresse) }}">
                                @error('adresse')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <h5 class="mt-4 mb-3 text-secondary border-bottom pb-2">Relation & Statut</h5>

                            <div class="col-md-6">
                                <label for="relation" class="form-label fw-bold">Relation <span class="text-danger">*</span></label>
                                <select class="form-select" id="relation" name="relation" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="Père" {{ old('relation', $parent->relation) == 'Père' ? 'selected' : '' }}>Père</option>
                                    <option value="Mère" {{ old('relation', $parent->relation) == 'Mère' ? 'selected' : '' }}>Mère</option>
                                    <option value="Tuteur" {{ old('relation', $parent->relation) == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                                    <option value="Autre" {{ old('relation', $parent->relation) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('relation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="statut" class="form-label fw-bold">Statut</label>
                                <select class="form-select" id="statut" name="statut">
                                    <option value="active" {{ old('statut', $parent->statut) == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ old('statut', $parent->statut) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                </select>
                                @error('statut')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="students" class="form-label fw-bold">Élève(s) associé(s)</label>
                                <select class="form-select" id="students" name="students[]" multiple size="5">
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" 
                                            {{ in_array($student->id, old('students', $parent->students ? $parent->students->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                            {{ $student->nom }} {{ $student->prenom }} ({{ $student->matricule }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs élèves.</div>
                                @error('students')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label">Notes supplémentaires</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $parent->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('parents.index') }}" class="btn btn-light border">Annuler</a>
                            <button type="submit" class="btn btn-warning px-4">
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