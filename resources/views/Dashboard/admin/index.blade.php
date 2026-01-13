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
                            <a href="{{ route('paiements.index') }}" class="btn btn-light">Voir paiements</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Utilisateurs</div>
                        <div class="card-body">
                            <h5 class="card-title">Gestion des accès</h5>
                            <p class="card-text">Créer et gérer les utilisateurs</p>
                            <a href="{{ route('utilisateurs.index') }}" class="btn btn-light">Gérer utilisateurs</a>
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
                                    <h3>{{ $stats['eleves_count'] }}</h3>
                                    <p class="text-muted">Élèves</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3>{{ $stats['profs_count'] }}</h3>
                                    <p class="text-muted">Enseignants</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3>{{ $stats['classes_count'] }}</h3>
                                    <p class="text-muted">Classes</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h3>{{ $stats['presence_rate'] }}%</h3>
                                    <p class="text-muted">Présence</p>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5>Présence par niveau</h5>
                                    <div class="alert alert-info">Non disponible pour le moment</div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Répartition par sexe</h5>
                                    <div class="d-flex justify-content-center">
                                        <canvas id="genderChart" width="200" height="200" 
                                                data-filles="{{ $stats['filles_count'] }}" 
                                                data-garcons="{{ $stats['garcons_count'] }}"></canvas>
                                    </div>
                                    <div class="text-center mt-2">
                                        <span class="badge bg-primary">Garçons: {{ $stats['garcons_count'] }}</span>
                                        <span class="badge bg-success">Filles: {{ $stats['filles_count'] }}</span>
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
                                <!-- Placeholder for activities -->
                                <div class="list-group-item">
                                    <p class="mb-0 text-muted">Aucune activité récente.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Alertes IA</h4>
                        </div>
                        <div class="card-body">
                            @forelse($alerts as $alert)
                                <div class="alert alert-{{ $alert['type'] == 'warning' ? 'warning' : 'info' }}">
                                    <i class="fas fa-exclamation-triangle"></i> {{ $alert['message'] }}
                                </div>
                            @empty
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Tout va bien. Aucun problème détecté.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Rapports section preserved but simplified -->
            <div class="row mt-4">
                <div class="col-md-12">
                     <!-- ... existing rapport cards ... -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('genderChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        const filles = parseInt(canvas.dataset.filles) || 0;
        const garcons = parseInt(canvas.dataset.garcons) || 0;
        const total = filles + garcons;
        
        if (total === 0) {
            ctx.font = "14px Arial";
            ctx.fillText("Pas de données", 60, 100);
            return;
        }

        const pctFilles = filles / total;
        
        // Filles (Green/Success)
        ctx.beginPath();
        ctx.moveTo(100, 100);
        ctx.arc(100, 100, 80, 0, 2 * Math.PI * pctFilles);
        ctx.closePath();
        ctx.fillStyle = '#28a745';
        ctx.fill();
        
        // Garcons (Blue/Primary)
        ctx.beginPath();
        ctx.moveTo(100, 100);
        ctx.arc(100, 100, 80, 2 * Math.PI * pctFilles, 2 * Math.PI);
        ctx.closePath();
        ctx.fillStyle = '#007bff';
        ctx.fill();
    }
});
</script>
@endsection