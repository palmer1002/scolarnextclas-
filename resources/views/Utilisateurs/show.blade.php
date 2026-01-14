@extends('layouts.app')

@section('title', 'Détails Utilisateur - ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary mb-0"><i class="fas fa-user-circle me-2"></i> Profil Utilisateur</h2>
            <p class="text-muted mb-0">Informations détaillées et gestion du compte</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('utilisateurs.index') }}" class="btn btn-outline-secondary px-4 fw-bold">
                <i class="fas fa-arrow-left me-1"></i> Retour list
            </a>
            <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn btn-warning text-white fw-bold px-4">
                <i class="fas fa-edit me-1"></i> Modifier
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Profil Card -->
        <div class="col-lg-4">
            <div class="card shadow border-0 radius-10 text-center p-4">
                <div class="avatar-xl mx-auto bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-1 mb-3 position-relative">
                    {{ substr($user->name, 0, 1) }}
                    <span class="position-absolute bottom-0 end-0 p-2 bg-{{ $user->status == 'active' ? 'success' : 'danger' }} border border-light rounded-circle" title="{{ $user->status == 'active' ? 'En ligne' : 'Hors ligne' }}"></span>
                </div>
                <h4 class="mb-1 fw-bold">{{ $user->name }}</h4>
                <p class="text-muted small mb-3">{{ $user->email }}</p>
                
                <div class="mb-4">
                    @php
                        $roleBadge = match($user->role) {
                            'admin' => 'bg-danger',
                            'secretaire' => 'bg-info text-dark',
                            'enseignant' => 'bg-primary',
                            default => 'bg-secondary',
                        };
                        $roleLabel = match($user->role) {
                            'admin' => 'Administrateur',
                            'secretaire' => 'Secrétaire',
                            'enseignant' => 'Enseignant',
                            default => ucfirst($user->role),
                        };
                    @endphp
                    <span class="badge {{ $roleBadge }} rounded-pill px-4 py-2 fs-6 shadow-sm">
                        <i class="fas fa-user-shield me-1"></i> {{ $roleLabel }}
                    </span>
                </div>

                <div class="d-grid gap-2">
                    @if($user->status == 'active')
                        <form action="{{ route('utilisateurs.deactivate', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger w-100 fw-bold py-2 border-2">
                                <i class="fas fa-toggle-off me-1"></i> Désactiver le compte
                            </button>
                        </form>
                    @else
                        <form action="{{ route('utilisateurs.activate', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-success w-100 fw-bold py-2 border-2">
                                <i class="fas fa-toggle-on me-1"></i> Activer le compte
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <div class="card shadow border-0 radius-10 mt-4 overflow-hidden">
                <div class="card-header bg-light border-0 py-3">
                    <h6 class="mb-0 fw-bold"><i class="fas fa-key me-2 text-danger"></i>Sécurité & Accès</h6>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted small mb-3">Le mot de passe ne peut pas être consulté. Vous devez le réinitialiser si l'utilisateur l'a oublié.</p>
                    <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn btn-dark btn-sm px-4">
                        <i class="fas fa-redo me-1"></i> Réinitialiser mot de passe
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Details -->
        <div class="col-lg-8">
            <div class="card shadow border-0 radius-10 mb-4 h-100">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-fingerprint me-2 text-primary"></i>Détails du compte</h5>
                    <span class="badge bg-light text-muted fw-normal px-3 py-2 border">ID: #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="card-body p-4 pt-0">
                    <div class="row g-4 mt-2">
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Nom Complet</label>
                            <p class="text-dark fw-bold mb-0 border-bottom pb-2">{{ $user->name }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Adresse Email</label>
                            <p class="text-dark fw-bold mb-0 border-bottom pb-2">{{ $user->email }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Rôle Principal</label>
                            <p class="text-dark fw-bold mb-0 border-bottom pb-2">{{ $roleLabel }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Statut du Compte</label>
                            <p class="mb-0 border-bottom pb-2">
                                @if($user->status == 'active')
                                    <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i> Actif</span>
                                @else
                                    <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i> Suspendu</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Date d'inscription</label>
                            <p class="text-muted mb-0 border-bottom pb-2">{{ $user->created_at->format('d F Y') }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Dernière activité</label>
                            <p class="text-muted mb-0 border-bottom pb-2">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-12">
                            <h6 class="fw-bold mb-4"><i class="fas fa-shield-alt me-2 text-warning"></i>Résumé des permissions</h6>
                            <div class="bg-light p-4 rounded-3 d-flex flex-wrap gap-3">
                                @if($user->role == 'admin')
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-lock-open me-2 text-danger"></i>Accès complet au système</span>
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-user-plus me-2 text-primary"></i>Gestion du personnel</span>
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-database me-2 text-success"></i>Sauvegarde & Config</span>
                                @elseif($user->role == 'secretaire')
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-user-graduate me-2 text-primary"></i>Gestion des élèves</span>
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-receipt me-2 text-success"></i>Inscriptions & Paiements</span>
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-calendar-alt me-2 text-warning"></i>Calendrier scolaire</span>
                                @elseif($user->role == 'enseignant')
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-book me-2 text-primary"></i>Saisie des notes</span>
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-file-invoice me-2 text-success"></i>Générer bulletins</span>
                                    <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-clock me-2 text-warning"></i>Emploi du temps</span>
                                @endif
                                <span class="badge bg-white text-dark shadow-sm border px-3 py-2"><i class="fas fa-comment me-2 text-info"></i>Messagerie interne</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="card shadow-sm border-0 radius-10 mt-5 border-start border-4 border-danger overflow-hidden">
        <div class="card-body d-flex justify-content-between align-items-center p-4">
            <div>
                <h5 class="text-danger mb-1 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Zone dangereuse</h5>
                <p class="text-muted mb-0 small">La suppression d'un compte staff est définitive et peut affecter l'historique des actions dans le système.</p>
            </div>
            @if($user->id !== auth()->id())
                <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Êtes-vous ABSOLUMENT sûr de vouloir supprimer ce compte définitivement ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-bold shadow-sm py-2">
                        <i class="fas fa-trash-alt me-1"></i> Supprimer ce compte
                    </button>
                </form>
            @else
                <div class="text-end">
                    <span class="badge bg-light text-danger border border-danger p-3 d-block mb-1">
                        <i class="fas fa-lock me-1"></i> Auto-suppression interdite
                    </span>
                    <small class="text-muted">Vous ne pouvez pas supprimer votre propre compte admin.</small>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .avatar-xl { width: 120px; height: 120px; }
    .border-2 { border-width: 2px !important; }
    .text-xs { font-size: 0.7rem; }
</style>
@endsection