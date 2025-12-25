@extends('layouts.user_app')

@section('title', 'Tableau de bord - ScolarNextClas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1>Bienvenue, {{ Auth::user()->name }}</h1>
            <p class="lead">Votre tableau de bord personnalisé</p>
            
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header">Profil</div>
                        <div class="card-body">
                            <h5 class="card-title">Informations personnelles</h5>
                            <p class="card-text">Consultez et mettez à jour vos informations personnelles.</p>
                            <a href="#" class="btn btn-light">Voir mon profil</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-header">Accès rapide</div>
                        <div class="card-body">
                            <h5 class="card-title">Fonctionnalités</h5>
                            <p class="card-text">Accédez rapidement aux fonctionnalités qui vous concernent.</p>
                            <a href="#" class="btn btn-light">Voir mes accès</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-header">Notifications</div>
                        <div class="card-body">
                            <h5 class="card-title">Messages importants</h5>
                            <p class="card-text">Consultez vos notifications et messages importants.</p>
                            <a href="#" class="btn btn-light">Voir mes notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Vos dernières activités</h4>
                        </div>
                        <div class="card-body">
                            <p>Aucune activité récente pour le moment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection