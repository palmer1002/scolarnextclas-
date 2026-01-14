@extends('layouts.app')

@section('title', 'Ajouter un Enseignant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-primary"><i class="fas fa-user-plus me-2"></i> Ajouter un Enseignant</h2>
                <a href="{{ route('enseignants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10">
                <div class="card-body p-4">
                    <form action="{{ route('enseignants.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <h5 class="mb-3 text-secondary border-bottom pb-2">Informations Personnelles</h5>
                            
                            <div class="col-md-4">
                                <label for="title" class="form-label fw-bold">Titre <span class="text-danger">*</span></label>
                                <select class="form-select" id="title" name="title" required>
                                    <option value="">Sélectionner...</option>
                                    <option value="M." {{ old('title') == 'M.' ? 'selected' : '' }}>M.</option>
                                    <option value="Mme" {{ old('title') == 'Mme' ? 'selected' : '' }}>Mme</option>
                                    <option value="Mlle" {{ old('title') == 'Mlle' ? 'selected' : '' }}>Mlle</option>
                                </select>
                                @error('title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="last_name" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="first_name" class="form-label fw-bold">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <h5 class="mt-4 mb-3 text-secondary border-bottom pb-2">Enseignement & Affectation</h5>

                            <div class="col-md-6">
                                <label for="subject" class="form-label fw-bold">Matière enseignée <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold">Statut</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Permanent" {{ old('status') == 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                    <option value="Vacataire" {{ old('status') == 'Vacataire' ? 'selected' : '' }}>Vacataire</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12">
                                <label for="classes" class="form-label fw-bold">Classes assignées</label>
                                <div class="card bg-light border-0">
                                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                        <div class="row">
                                            @foreach($classes as $classe)
                                                <div class="col-md-4 col-sm-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="classes[]" value="{{ $classe->id }}" id="class_{{ $classe->id }}" 
                                                            {{ in_array($classe->id, old('classes', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="class_{{ $classe->id }}">
                                                            {{ $classe->nom }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @error('classes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('enseignants.index') }}" class="btn btn-light border">Annuler</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection