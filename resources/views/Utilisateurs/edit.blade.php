@extends('layouts.app')

@section('title', 'Modifier Utilisateur')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-primary mb-0"><i class="fas fa-user-edit me-2"></i> Modifier le Staff</h2>
                    <p class="text-muted mb-0">Mise à jour des informations d'accès</p>
                </div>
                <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn btn-outline-secondary px-4 fw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Annuler
                </a>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
            @endif

            <div class="card shadow border-0 radius-10 overflow-hidden">
                <div class="card-header bg-primary bg-opacity-10 border-0 p-4 text-center">
                    <div class="avatar-lg mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-1 mb-2 shadow-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <h5 class="text-dark mb-0 fw-bold">{{ $user->name }}</h5>
                    <span class="badge bg-white text-primary border border-primary border-opacity-25 px-3 mt-2 small">Compte #{{ $user->id }}</span>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('utilisateurs.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold text-dark">Nom Complet <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
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
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
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
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                        <option value="secretaire" {{ old('role', $user->role) == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                        <option value="enseignant" {{ old('role', $user->role) == 'enseignant' ? 'selected' : '' }}>Enseignant</option>
                                    </select>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="alert alert-info border-0 shadow-sm mb-0 p-4">
                                    <h6 class="fw-bold"><i class="fas fa-shield-alt me-2"></i>Sécurité : Changer le mot de passe</h6>
                                    <p class="small mb-3 text-muted">Laissez ces champs **vides** si vous souhaitez conserver le mot de passe actuel.</p>
                                    
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-key text-muted"></i></span>
                                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                                       name="password" placeholder="Nouveau mot de passe">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-check text-muted"></i></span>
                                                <input type="password" class="form-control border-start-0" 
                                                       name="password_confirmation" placeholder="Confirmer">
                                            </div>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4 pt-2 border-top">
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                        <i class="fas fa-save me-1"></i> Enregistrer les modifications
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
    .avatar-lg { width: 90px; height: 90px; }
    .input-group-text { border-color: #dee2e6; }
    .form-control:focus, .form-select:focus {
        border-color: #170B9DFF;
        box-shadow: 0 0 0 0.25rem rgba(23, 11, 157, 0.1);
    }
</style>
@endsection