@extends('layouts.app')

@section('title', 'Nouvel Utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary mb-0"><i class="fas fa-user-plus me-2"></i> Nouveau Staff</h2>
                    <p class="text-muted mb-0">Création d'un nouveau compte administratif</p>
                </div>
                <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>

            <div class="card shadow border-0 radius-10 overflow-hidden">
                <div class="card-header bg-primary bg-opacity-10 border-0 p-4">
                    <h5 class="text-dark mb-0 fw-bold"><i class="fas fa-info-circle me-2 text-primary"></i>Informations de base</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('utilisateurs.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold text-dark">Nom Complet <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required placeholder="Admin Nextclas">
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="email" class="form-label fw-bold text-dark">Adresse Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required placeholder="admin@nextclas.com">
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="role" class="form-label fw-bold text-dark">Rôle du compte <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-tag text-muted"></i></span>
                                    <select class="form-select border-start-0 @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Choisir un rôle...</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                        <option value="secretaire" {{ old('role') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                        <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                    </select>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 py-3 bg-light rounded-3 px-4 mt-4">
                                <h6 class="fw-bold mb-3"><i class="fas fa-lock me-2 text-danger"></i>Sécurité du compte</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password" class="form-label small fw-bold">Mot de passe <span class="text-danger">*</span></label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-key text-muted"></i></span>
                                            <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required placeholder="Min 4 caractères">
                                        </div>
                                        @error('password')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label small fw-bold">Confirmation <span class="text-danger">*</span></label>
                                        <div class="input-group shadow-sm">
                                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-check text-muted"></i></span>
                                            <input type="password" class="form-control border-start-0" 
                                                   id="password_confirmation" name="password_confirmation" required placeholder="Répéter mot de passe">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4 pt-2 border-top">
                                <div class="d-grid shadow-sm">
                                    <button type="submit" class="btn btn-primary py-3 fw-bold fs-5">
                                        <i class="fas fa-plus-circle me-1"></i> Créer le compte Staff
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .input-group-text { border-color: #dee2e6; }
    .form-control:focus, .form-select:focus {
        border-color: #170B9DFF;
        box-shadow: 0 0 0 0.25rem rgba(23, 11, 157, 0.1);
    }
</style>
@endsection