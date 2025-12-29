@extends('layouts.user_app')

@section('title', 'Dashboard Enseignant - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue, {{ Auth::check() ? Auth::user()->name : 'Enseignant' }}</h1>
            <p class="lead">Tableau de bord Enseignant</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Mes Classes</div>
                        <div class="card-body">
                            <h5 class="card-title">Classes assignées</h5>
                            <p class="card-text">Consultez les classes que vous enseignez</p>
                            <a href="{{ route('enseignants.index') }}" class="btn btn-light">Voir mes classes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <h5 class="card-title">Saisie des notes</h5>
                            <p class="card-text">Saisissez et gérez les notes de vos élèves</p>
                            <a href="{{ route('notes.index') }}" class="btn btn-light">Gérer les notes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Bulletins</div>
                        <div class="card-body">
                            <h5 class="card-title">Gestion des bulletins</h5>
                            <p class="card-text">Créez et imprimez les bulletins scolaires</p>
                            <a href="{{ route('bulletins') }}" class="btn btn-light">Voir bulletins</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Présences</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi des présences</h5>
                            <p class="card-text">Enregistrez et suivez les présences</p>
                            <a href="#" class="btn btn-light">Gérer présences</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Mes Dernières Activités</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Activité</th>
                                            <th>Classe</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>24/12/2025</td>
                                            <td>Saisie des notes</td>
                                            <td>6ème A</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Voir</a></td>
                                        </tr>
                                        <tr>
                                            <td>23/12/2025</td>
                                            <td>Mise à jour des bulletins</td>
                                            <td>5ème B</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Voir</a></td>
                                        </tr>
                                        <tr>
                                            <td>22/12/2025</td>
                                            <td>Appel des élèves</td>
                                            <td>4ème A</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Voir</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Mes Statistiques</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-center">
                                    <h5>25</h5>
                                    <p class="text-muted">Classes</p>
                                </div>
                                <div class="text-center">
                                    <h5>180</h5>
                                    <p class="text-muted">Élèves</p>
                                </div>
                                <div class="text-center">
                                    <h5>45</h5>
                                    <p class="text-muted">Notes</p>
                                </div>
                            </div>
                            
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%"></div>
                            </div>
                            <small>75% des notes saisies</small>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Messages</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Aucun message urgent
                            </div>
                            <p>Consultez vos messages et annonces</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection