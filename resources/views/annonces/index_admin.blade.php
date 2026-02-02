@extends('layouts.app')

@section('title', 'Gestion des Annonces')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h1 class="h3 mb-4 text-gray-800 fw-bold"><i class="fa-solid fa-bullhorn text-primary me-2"></i>Gestion des Annonces</h1>

    <div class="row">
        <!-- Formulaire de Publication -->
        <div class="col-md-4">
            <div class="card shadow mb-4 border-0 radius-15">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 fw-bold"><i class="fas fa-plus-circle me-1"></i> Nouvelle Annonce</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('annonces.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titre de l'annonce</label>
                            <input type="text" name="titre" class="form-control" required placeholder="Ex: Réunion des parents">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Type</label>
                            <select name="type" class="form-select">
                                <option value="info">Information</option>
                                <option value="urgent">Urgent</option>
                                <option value="event">Événement</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cible (Destinataires)</label>
                            <select name="cible" class="form-select">
                                <option value="tous">Tout le monde</option>
                                <option value="enseignants">Enseignants uniquement</option>
                                <option value="parents">Parents uniquement</option>
                                <option value="eleves">Élèves uniquement</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Contenu</label>
                            <textarea name="contenu" class="form-control" rows="5" required placeholder="Écrivez votre message ici..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold"><i class="fas fa-paper-plane me-1"></i> Publier l'annonce</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des Annonces -->
        <div class="col-md-8">
            <div class="card shadow mb-4 border-0 radius-15">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-1"></i> Historique des publications</h6>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="list-group list-group-flush">
                        @foreach($annonces as $annonce)
                            <div class="list-group-item p-3 border-bottom-0 mb-3 shadow-sm rounded bg-light">
                                <div class="d-flex w-100 justify-content-between align-items-center mb-2">
                                    <h5 class="mb-1 fw-bold text-dark">
                                        @if($annonce->type == 'urgent') <span class="badge bg-danger me-2">URGENT</span>
                                        @elseif($annonce->type == 'event') <span class="badge bg-info me-2">ÉVÉNEMENT</span>
                                        @else <span class="badge bg-secondary me-2">INFO</span> @endif
                                        {{ $annonce->titre }}
                                    </h5>
                                    <small class="text-muted"><i class="far fa-clock me-1"></i> {{ $annonce->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-2 text-secondary">{{ $annonce->contenu }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">
                                        <strong>Cible :</strong> 
                                        @if($annonce->cible == 'tous') Tout le monde
                                        @elseif($annonce->cible == 'enseignants') Enseignants
                                        @elseif($annonce->cible == 'parents') Parents
                                        @else Élèves @endif
                                    </small>
                                    <form action="{{ route('annonces.destroy', $annonce) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette annonce ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        @if($annonces->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Aucune annonce publiée pour le moment.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
