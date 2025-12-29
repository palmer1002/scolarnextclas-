@extends('layouts.user_app')

@section('title', 'Dashboard Élève - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue, {{ Auth::check() ? Auth::user()->name : 'Élève' }}</h1>
            <p class="lead">Tableau de bord Élève</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Ma Classe</div>
                        <div class="card-body">
                            <h5 class="card-title">Informations de classe</h5>
                            <p class="card-text">Consultez les détails de votre classe</p>
                            <a href="{{ route('eleves.index') }}" class="btn btn-light">Voir ma classe</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Mes Notes</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi de mes notes</h5>
                            <p class="card-text">Consultez vos notes et vos progrès</p>
                            <a href="{{ route('notes.index') }}" class="btn btn-light">Voir mes notes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Mes Bulletins</div>
                        <div class="card-body">
                            <h5 class="card-title">Bulletins scolaires</h5>
                            <p class="card-text">Téléchargez vos bulletins</p>
                            <a href="{{ route('bulletins') }}" class="btn btn-light">Voir mes bulletins</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Ma Présence</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi de présence</h5>
                            <p class="card-text">Consultez votre taux de présence</p>
                            <a href="#" class="btn btn-light">Voir présence</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Mes Dernières Notes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Matière</th>
                                            <th>Note</th>
                                            <th>Date</th>
                                            <th>Professeur</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mathématiques</td>
                                            <td>16/20</td>
                                            <td>24/12/2025</td>
                                            <td>M. Martin</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Détails</a></td>
                                        </tr>
                                        <tr>
                                            <td>Français</td>
                                            <td>14/20</td>
                                            <td>23/12/2025</td>
                                            <td>Mme. Dubois</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Détails</a></td>
                                        </tr>
                                        <tr>
                                            <td>Anglais</td>
                                            <td>15/20</td>
                                            <td>22/12/2025</td>
                                            <td>M. Johnson</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Détails</a></td>
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
                                    <h5>15.2</h5>
                                    <p class="text-muted">Moyenne</p>
                                </div>
                                <div class="text-center">
                                    <h5>94%</h5>
                                    <p class="text-muted">Présence</p>
                                </div>
                                <div class="text-center">
                                    <h5>8</h5>
                                    <p class="text-muted">Absences</p>
                                </div>
                            </div>
                            
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 94%"></div>
                            </div>
                            <small>Taux de présence: 94%</small>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Mes Devoirs</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 2 devoirs à rendre
                            </div>
                            <p>Consultez vos devoirs et devoirs à rendre</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection