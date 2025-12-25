<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer Utilisateur - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .confirmation-card {
            max-width: 500px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .warning-icon {
            font-size: 4rem;
            color: #dc3545;
        }
        .user-info {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-card">
            <div class="card">
                <!-- En-tête -->
                <div class="card-header bg-danger text-white text-center py-4">
                    <i class="fas fa-exclamation-triangle warning-icon mb-3"></i>
                    <h3 class="mb-0">Confirmation de Suppression</h3>
                </div>
                
                <!-- Corps -->
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h5>Êtes-vous sûr de vouloir supprimer cet utilisateur ?</h5>
                    </div>

                    <!-- Informations utilisateur -->
                    <div class="user-info">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 60px; height: 60px; font-size: 1.5rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">{{ $user->email }}</p>
                                <p class="mb-0">
                                    <span class="badge bg-secondary">{{ $user->role }}</span>
                                    @if($user->status == 'active')
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-danger">Inactif</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <p class="mb-2"><strong>Date de création :</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                            <p class="mb-0"><strong>Dernière connexion :</strong> 
                                {{ $user->last_login ? $user->last_login->format('d/m/Y H:i') : 'Jamais' }}
                            </p>
                        </div>
                    </div>

                    <!-- Avertissements -->
                    <div class="alert alert-warning" role="alert">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-circle"></i> Attention !</h6>
                        <ul class="mb-0">
                            <li>Cette action est irréversible</li>
                            <li>Toutes les données associées seront supprimées</li>
                            <li>L'utilisateur perdra immédiatement l'accès au système</li>
                            @if($user->is_admin)
                                <li class="text-danger"><strong>Vous supprimez un compte administrateur !</strong></li>
                            @endif
                        </ul>
                    </div>

                    <!-- Options de suppression -->
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            Je comprends les conséquences et souhaite procéder à la suppression
                        </label>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour aux détails
                        </a>
                        
                        <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" id="submitBtn" disabled>
                                <i class="fas fa-trash"></i> Supprimer définitivement
                            </button>
                        </form>
                    </div>

                    <!-- Alternative (désactiver au lieu de supprimer) -->
                    @if($user->status == 'active')
                        <hr class="my-4">
                        <div class="text-center">
                            <p class="text-muted mb-2">Alternative recommandée :</p>
                            <form action="{{ route('utilisateurs.deactivate', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-user-slash"></i> Désactiver l'utilisateur (garder les données)
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Pied de page -->
                <div class="card-footer text-center text-muted py-3">
                    <small><i class="fas fa-info-circle"></i> Pour toute question, contactez l'administrateur système</small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activer le bouton de suppression uniquement si la case est cochée
        document.getElementById('confirmDelete').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });

        // Confirmation supplémentaire avant soumission
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            if (!confirm('Dernière confirmation : Êtes-vous ABSOLUMENT SÛR de vouloir supprimer cet utilisateur ?')) {
                e.preventDefault();
                return false;
            }
            
            // Afficher un indicateur de chargement
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Suppression en cours...';
            submitBtn.disabled = true;
        });

        // Empêcher la soumission avec la touche Entrée
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.id !== 'confirmDelete') {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>