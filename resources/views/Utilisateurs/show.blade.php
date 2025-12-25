@extends('layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="container mt-4">
    <!-- Bouton retour -->
    <a href="{{ route('utilisateurs') }}" class="back-btn mb-3 d-inline-block">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle"></i> Détails de l'Utilisateur
                    </h4>
                    <div class="btn-group">
                        <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Informations de base -->
                        <div class="col-md-8">
                            <div class="card info-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-id-card"></i> Informations Personnelles
                                    </h5>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Nom complet:</strong><br>
                                            {{ $user->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Email:</strong><br>
                                            {{ $user->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Rôle et statut -->
                            <div class="card info-card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-user-tag"></i> Rôle et Accès
                                    </h5>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Rôle:</strong><br>
                                            <span class="badge badge-{{ strtolower($user->role) }} p-2">
                                                <i class="fas fa-{{ $user->role_icon }}"></i>
                                                {{ $user->role }}
                                            </span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Statut:</strong><br>
                                            <span class="status-{{ $user->status }}">
                                                <i class="fas fa-circle"></i>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations de connexion -->
                            <div class="card info-card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-sign-in-alt"></i> Informations de Connexion
                                    </h5>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <p><strong>Date de création:</strong><br>
                                            {{ $user->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Dernière connexion:</strong><br>
                                            {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Jamais' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Photo et actions rapides -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <div class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle" 
                                             style="width: 120px; height: 120px; font-size: 3rem;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                    <h5>{{ $user->name }}</h5>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    
                                    <div class="mt-4">
                                        @if($user->status == 'active')
                                            <form action="{{ route('utilisateurs.deactivate', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 mb-2">
                                                    <i class="fas fa-user-slash"></i> Désactiver
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('utilisateurs.activate', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-success btn-sm w-100 mb-2">
                                                    <i class="fas fa-user-check"></i> Activer
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <button class="btn btn-outline-info btn-sm w-100" data-bs-toggle="modal" data-bs-target="#passwordModal">
                                            <i class="fas fa-key"></i> Réinitialiser mot de passe
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Permissions -->
                            <div class="card">
                                <div class="card-body">
                                    <h6><i class="fas fa-shield-alt"></i> Permissions</h6>
                                    <ul class="list-unstyled mt-3">
                                        @foreach($user->permissions as $permission)
                                            <li class="mb-2">
                                                <i class="fas fa-check text-success"></i>
                                                {{ $permission }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activités récentes -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-history"></i> Activités Récentes</h5>
                        </div>
                        <div class="card-body">
                            @if($user->activities->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Action</th>
                                                <th>Détails</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($user->activities->take(5) as $activity)
                                                <tr>
                                                    <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $activity->action }}</td>
                                                    <td>{{ $activity->details }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted text-center">Aucune activité enregistrée</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle"></i> Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ $user->name }}</strong> ?</p>
                <p class="text-danger">Cette action est irréversible. Toutes les données associées seront perdues.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Annuler
                </button>
                <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de réinitialisation du mot de passe -->
<div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-key"></i> Réinitialiser le mot de passe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('utilisateurs.reset-password', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <small class="form-text text-muted">
                            Le mot de passe doit contenir au moins 8 caractères.
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sync"></i> Réinitialiser
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.info-card {
    border-left: 4px solid #170B9DFF;
}

.status-active {
    color: #198754;
}

.status-inactive {
    color: #6c757d;
}

.status-suspended {
    color: #dc3545;
}

.badge-administrateur {
    background-color: #0d6efd;
}

.badge-directeur {
    background-color: #198754;
}

.badge-secretaire {
    background-color: #0dcaf0;
}

.badge-comptable {
    background-color: #ffc107;
}

.badge-enseignant {
    background-color: #dc3545;
}
</style>
@endsection