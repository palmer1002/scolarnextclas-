@extends('layouts.app')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="container mt-4">
    <!-- Bouton retour -->
    <a href="{{ route('utilisateurs.index') }}" class="back-btn mb-3 d-inline-block">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus"></i> Créer un Nouvel Utilisateur
                    </h4>
                </div>
                
                <form action="{{ route('utilisateurs.store') }}" method="POST" id="createUserForm">
                    @csrf
                    
                    <div class="card-body">
                        <!-- Informations personnelles -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-id-card"></i> Informations Personnelles</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label required">Nom complet</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label required">Adresse email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="department" class="form-label">Département/Service</label>
                                        <select class="form-select @error('department') is-invalid @enderror" 
                                                id="department" name="department">
                                            <option value="">Sélectionner un département</option>
                                            <option value="administration" {{ old('department') == 'administration' ? 'selected' : '' }}>Administration</option>
                                            <option value="enseignement" {{ old('department') == 'enseignement' ? 'selected' : '' }}>Enseignement</option>
                                            <option value="comptabilite" {{ old('department') == 'comptabilite' ? 'selected' : '' }}>Comptabilité</option>
                                            <option value="direction" {{ old('department') == 'direction' ? 'selected' : '' }}>Direction</option>
                                            <option value="autre" {{ old('department') == 'autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                        @error('department')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rôle et accès -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-user-tag"></i> Rôle et Accès</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">Sélectionnez un rôle</label>
                                    <div class="row" id="roleSelection">
                                        <div class="col-md-4">
                                            <div class="role-option" data-role="admin">
                                                <div class="text-center">
                                                    <i class="fas fa-user-shield fa-2x text-primary mb-2"></i>
                                                    <h6>Administrateur</h6>
                                                    <small class="text-muted">Accès complet au système</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="role-option" data-role="admin">
                                                <div class="text-center">
                                                    <i class="fas fa-user-graduate fa-2x text-success mb-2"></i>
                                                    <h6>Directeur</h6>
                                                    <small class="text-muted">Direction et supervision</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="role-option" data-role="admin">
                                                <div class="text-center">
                                                    <i class="fas fa-user-tie fa-2x text-info mb-2"></i>
                                                    <h6>Secrétaire</h6>
                                                    <small class="text-muted">Gestion administrative</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="role-option" data-role="admin">
                                                <div class="text-center">
                                                    <i class="fas fa-calculator fa-2x text-warning mb-2"></i>
                                                    <h6>Comptable</h6>
                                                    <small class="text-muted">Gestion financière</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="role-option" data-role="enseignant">
                                                <div class="text-center">
                                                    <i class="fas fa-chalkboard-teacher fa-2x text-danger mb-2"></i>
                                                    <h6>Enseignant</h6>
                                                    <small class="text-muted">Enseignement et évaluation</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="role" id="selectedRole" value="{{ old('role') }}" required>
                                    @error('role')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Permissions spécifiques -->
                                <div class="permission-group">
                                    <h6><i class="fas fa-shield-alt"></i> Permissions supplémentaires</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="permission_notes" name="permissions[]" value="gestion_notes">
                                                <label class="form-check-label" for="permission_notes">
                                                    Gestion des notes
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="permission_eleves" name="permissions[]" value="gestion_eleves">
                                                <label class="form-check-label" for="permission_eleves">
                                                    Gestion des élèves
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="permission_paiements" name="permissions[]" value="gestion_paiements">
                                                <label class="form-check-label" for="permission_paiements">
                                                    Gestion des paiements
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="permission_rapports" name="permissions[]" value="generation_rapports">
                                                <label class="form-check-label" for="permission_rapports">
                                                    Génération de rapports
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="permission_parametres" name="permissions[]" value="modification_parametres">
                                                <label class="form-check-label" for="permission_parametres">
                                                    Modification des paramètres
                                                </label>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="permission_export" name="permissions[]" value="export_donnees">
                                                <label class="form-check-label" for="permission_export">
                                                    Export des données
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Authentification -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-key"></i> Authentification</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label required">Mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Le mot de passe doit contenir au moins 8 caractères.
                                        </small>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label required">Confirmer le mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required>
                                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer l'utilisateur
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des rôles
    const roleOptions = document.querySelectorAll('.role-option');
    const selectedRoleInput = document.getElementById('selectedRole');
    
    roleOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Retirer la sélection des autres options
            roleOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Ajouter la sélection à l'option cliquée
            this.classList.add('selected');
            
            // Mettre à jour le champ caché
            selectedRoleInput.value = this.getAttribute('data-role');
        });
    });
    
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    
    // Toggle confirm password visibility
    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const confirmPasswordField = document.getElementById('password_confirmation');
        const icon = this.querySelector('i');
        
        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            confirmPasswordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>

<style>
.role-option {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
}

.role-option:hover {
    border-color: #170B9DFF;
    background-color: #f8f9fa;
}

.role-option.selected {
    border-color: #170B9DFF;
    background-color: #e6f0ff;
    box-shadow: 0 0 0 3px rgba(23, 11, 157, 0.25);
}

.permission-group {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin-top: 20px;
}

.required::after {
    content: " *";
    color: #dc3545;
}
</style>
@endsection