@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="container mt-4">
    <!-- Bouton retour -->
    <a href="{{ route('utilisateurs.show', $user->id) }}" class="back-btn mb-3 d-inline-block">
        <i class="fas fa-arrow-left"></i> Retour aux détails
    </a>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit"></i> Modifier l'Utilisateur
                    </h4>
                    <span class="badge bg-light text-dark">
                        ID: {{ $user->id }}
                    </span>
                </div>
                
                <form action="{{ route('utilisateurs.update', $user->id) }}" method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <!-- Onglets -->
                        <ul class="nav nav-tabs" id="editUserTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button">
                                    <i class="fas fa-info-circle"></i> Informations
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="role-tab" data-bs-toggle="tab" data-bs-target="#role" type="button">
                                    <i class="fas fa-user-tag"></i> Rôle & Permissions
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button">
                                    <i class="fas fa-shield-alt"></i> Sécurité
                                </button>
                            </li>
                        </ul>

                        <!-- Contenu des onglets -->
                        <div class="tab-content" id="editUserTabsContent">
                            <!-- Onglet Informations -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label required">Nom complet</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label required">Adresse email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="department" class="form-label">Département/Service</label>
                                        <select class="form-select @error('department') is-invalid @enderror" 
                                                id="department" name="department">
                                            <option value="">Sélectionner un département</option>
                                            <option value="administration" {{ old('department', $user->department) == 'administration' ? 'selected' : '' }}>Administration</option>
                                            <option value="enseignement" {{ old('department', $user->department) == 'enseignement' ? 'selected' : '' }}>Enseignement</option>
                                            <option value="comptabilite" {{ old('department', $user->department) == 'comptabilite' ? 'selected' : '' }}>Comptabilité</option>
                                            <option value="direction" {{ old('department', $user->department) == 'direction' ? 'selected' : '' }}>Direction</option>
                                            <option value="autre" {{ old('department', $user->department) == 'autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                        @error('department')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label required">Statut</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status" required>
                                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                            <option value="suspended" {{ old('status', $user->status) == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                            <option value="vacation" {{ old('status', $user->status) == 'vacation' ? 'selected' : '' }}>En congé</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="notes" class="form-label">Notes additionnelles</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                  id="notes" name="notes" rows="2">{{ old('notes', $user->notes) }}</textarea>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Onglet Rôle & Permissions -->
                            <div class="tab-pane fade" id="role" role="tabpanel">
                                <div class="mb-4">
                                    <label class="form-label required">Rôle</label>
                                    <div class="row" id="roleSelection">
                                        <div class="col-md-4 mb-3">
                                            <div class="role-option {{ old('role', $user->role) == 'administrateur' ? 'selected' : '' }}" data-role="administrateur">
                                                <div class="text-center">
                                                    <i class="fas fa-user-shield fa-2x text-primary mb-2"></i>
                                                    <h6>Administrateur</h6>
                                                    <small class="text-muted">Accès complet au système</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="role-option {{ old('role', $user->role) == 'directeur' ? 'selected' : '' }}" data-role="directeur">
                                                <div class="text-center">
                                                    <i class="fas fa-user-graduate fa-2x text-success mb-2"></i>
                                                    <h6>Directeur</h6>
                                                    <small class="text-muted">Direction et supervision</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="role-option {{ old('role', $user->role) == 'secretaire' ? 'selected' : '' }}" data-role="secretaire">
                                                <div class="text-center">
                                                    <i class="fas fa-user-tie fa-2x text-info mb-2"></i>
                                                    <h6>Secrétaire</h6>
                                                    <small class="text-muted">Gestion administrative</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="role-option {{ old('role', $user->role) == 'comptable' ? 'selected' : '' }}" data-role="comptable">
                                                <div class="text-center">
                                                    <i class="fas fa-calculator fa-2x text-warning mb-2"></i>
                                                    <h6>Comptable</h6>
                                                    <small class="text-muted">Gestion financière</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="role-option {{ old('role', $user->role) == 'enseignant' ? 'selected' : '' }}" data-role="enseignant">
                                                <div class="text-center">
                                                    <i class="fas fa-chalkboard-teacher fa-2x text-danger mb-2"></i>
                                                    <h6>Enseignant</h6>
                                                    <small class="text-muted">Enseignement et évaluation</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="role" id="selectedRole" value="{{ old('role', $user->role) }}" required>
                                    @error('role')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Permissions -->
                                <div class="permission-group">
                                    <h5><i class="fas fa-shield-alt"></i> Permissions</h5>
                                    <p class="text-muted mb-3">Sélectionnez les permissions spécifiques pour cet utilisateur</p>
                                    
                                    <div class="row">
                                        @foreach($permissions as $group => $groupPermissions)
                                            <div class="col-md-6 mb-4">
                                                <h6 class="mb-3">{{ $group }}</h6>
                                                @foreach($groupPermissions as $permission)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="permission_{{ $permission['id'] }}" 
                                                               name="permissions[]" 
                                                               value="{{ $permission['id'] }}"
                                                               {{ in_array($permission['id'], old('permissions', $user->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permission['id'] }}">
                                                            {{ $permission['name'] }}
                                                        </label>
                                                        @if($permission['description'])
                                                            <small class="form-text text-muted d-block">{{ $permission['description'] }}</small>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Onglet Sécurité -->
                            <div class="tab-pane fade" id="security" role="tabpanel">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Pour modifier le mot de passe, utilisez la fonction de réinitialisation dans la page de détails de l'utilisateur.
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Journal de sécurité</h5>
                                        @if($user->securityLogs->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Événement</th>
                                                            <th>IP</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($user->securityLogs->take(5) as $log)
                                                            <tr>
                                                                <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                                                <td>{{ $log->event }}</td>
                                                                <td>{{ $log->ip_address }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted">Aucun événement de sécurité enregistré.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer les modifications
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
    // Gestion des onglets
    const triggerTabList = [].slice.call(document.querySelectorAll('#editUserTabs button'))
    triggerTabList.forEach(function (triggerEl) {
        const tabTrigger = new bootstrap.Tab(triggerEl)
        
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })

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
});
</script>

<style>
.nav-tabs .nav-link {
    color: #6c757d;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #170B9DFF;
    border-bottom-color: #170B9DFF;
}

.role-option {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
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
}

.required::after {
    content: " *";
    color: #dc3545;
}
</style>
@endsection