@extends('layouts.user_app')

@section('title', 'Dashboard Parent - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue, {{ Auth::check() ? Auth::user()->name : 'Parent' }}</h1>
            <p class="lead">Tableau de bord Parent</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Mes Enfants</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi des enfants</h5>
                            <p class="card-text">Consultez les informations de vos enfants</p>
                            <a href="{{ route('parents.index') }}" class="btn btn-light">Voir mes enfants</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Notes</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi des notes</h5>
                            <p class="card-text">Consultez les notes de vos enfants</p>
                            <a href="{{ route('notes.index') }}" class="btn btn-light">Voir les notes</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-header">Bulletins</div>
                        <div class="card-body">
                            <h5 class="card-title">Bulletins scolaires</h5>
                            <p class="card-text">Téléchargez les bulletins de vos enfants</p>
                            <a href="" class="btn btn-light">Voir bulletins</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Présences</div>
                        <div class="card-body">
                            <h5 class="card-title">Suivi de présence</h5>
                            <p class="card-text">Consultez les présences de vos enfants</p>
                            <a href="#" class="btn btn-light">Voir présences</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Suivi de Mes Enfants</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Classe</th>
                                            <th>Dernière note</th>
                                            <th>Présence</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Marie Klanlenou</td>
                                            <td>6ème A</td>
                                            <td>16/20</td>
                                            <td>95%</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-primary">Détails</a></td>
                                        </tr>
                                        <tr>
                                            <td>Jean Klanlenou</td>
                                            <td>4ème B</td>
                                            <td>14/20</td>
                                            <td>92%</td>
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
                            <h4>Mes Paiements</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="text-center">
                                    <h5>3</h5>
                                    <p class="text-muted">Total</p>
                                </div>
                                <div class="text-center">
                                    <h5>2</h5>
                                    <p class="text-muted">Payés</p>
                                </div>
                                <div class="text-center">
                                    <h5>1</h5>
                                    <p class="text-muted">En attente</p>
                                </div>
                            </div>
                            
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 66%"></div>
                            </div>
                            <small>66% des paiements effectués</small>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Messages</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> 1 message non lu
                            </div>
                            <p>Consultez les messages de l'école</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection