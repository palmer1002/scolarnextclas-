@extends('layouts.user_app')

@section('title', 'Dashboard Admin - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue, {{ Auth::check() ? Auth::user()->name : 'Visiteur' }}</h1>
            <p class="lead">Tableau de bord Administrateur</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Élèves</div>
                        <div class="card-body">
                            <h5 class="card-title">Gestion des élèves</h5>
                            <p class="card-text">Ajouter, modifier et suivre les élèves</p>
                            <a href="{{ route('eleves.index') }}" class="btn btn-light">Gérer les élèves</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Enseignants</div>
                        <div class="card-body">
                            <h5 class="card-title">Gestion du personnel</h5>
                            <p class="card-text">Gérer les enseignants et leur affectation</p>
                            <a href="{{ route('enseignants.index') }}" class="btn btn-light">Gérer enseignants</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Paiements</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi des paiements</h5>
                            <p class="card-text">Surveiller les paiements scolaires</p>
                            <a href="{{ route('paiements.index') ?? '#' }}" class="btn btn-light">Voir paiements</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Utilisateurs</div>
                        <div class="card-body">
                            <h5 class="card-title">Gestion des accès</h5>
                            <p class="card-text">Créer et gérer les utilisateurs</p>
                            <a href="{{ route('utilisateurs.index') ?? '#' }}" class="btn btn-light">Gérer utilisateurs</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistiques Générales</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <h3>1250</h3>
                                    <p class="text-muted">Élèves</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3>85</h3>
                                    <p class="text-muted">Enseignants</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3>45</h3>
                                    <p class="text-muted">Classes</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3>98%</h3>
                                    <p class="text-muted">Présence</p>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5>Présence par niveau</h5>
                
                                        </div>
                                    </div>
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 92%">
                                            Collège (92%)
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 90%">
                                            Lycée (90%)
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Répartition par sexe</h5>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="genderChart" width="200" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Activités Récentes</h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Nouvel élève inscrit</h6>
                                        <small>Il y a 5 min</small>
                                    </div>
                                    <p class="mb-1">Jean Dupont - 6ème A</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Paiement reçu</h6>
                                        <small>Il y a 1h</small>
                                    </div>
                                    <p class="mb-1">Frais scolaires - 120,000 FCFA</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Nouvel enseignant</h6>
                                        <small>Il y a 2h</small>
                                    </div>
                                    <p class="mb-1">M. Martin - Mathématiques</p>
                                </div>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Notes mises à jour</h6>
                                        <small>Il y a 3h</small>
                                    </div>
                                    <p class="mb-1">5ème A - Français</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Alertes</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 3 paiements en retard
                            </div>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 2 bulletins à valider
                            </div>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> 5 inscriptions aujourd'hui
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Rapports et Analyses</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chart-bar fa-2x text-primary mb-2"></i>
                                            <h6>Rapport Mensuel</h6>
                                            <a href="#" class="btn btn-sm btn-primary mt-2">Générer</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <i class="fas fa-file-invoice-dollar fa-2x text-success mb-2"></i>
                                            <h6>Rapport Financier</h6>
                                            <a href="#" class="btn btn-sm btn-success mt-2">Générer</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-graduate fa-2x text-warning mb-2"></i>
                                            <h6>Rapport Académique</h6>
                                            <a href="#" class="btn btn-sm btn-warning mt-2">Générer</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                                            <h6>Alertes Système</h6>
                                            <a href="#" class="btn btn-sm btn-danger mt-2">Voir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simple chart for gender distribution
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('genderChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        
        // Draw a simple pie chart
        ctx.beginPath();
        ctx.moveTo(100, 100);
        ctx.arc(100, 100, 80, 0, 2 * Math.PI * 0.6);
        ctx.closePath();
        ctx.fillStyle = '#28a745';
        ctx.fill();
        
        ctx.beginPath();
        ctx.moveTo(100, 100);
        ctx.arc(100, 100, 80, 2 * Math.PI * 0.6, 2 * Math.PI);
        ctx.closePath();
        ctx.fillStyle = '#007bff';
        ctx.fill();
        
        // Labels
        ctx.fillStyle = '#28a745';
        ctx.fillText('Garçons (60%)', 150, 80);
        ctx.fillStyle = '#007bff';
        ctx.fillText('Filles (40%)', 150, 100);
    }
});
</script>
@endsection