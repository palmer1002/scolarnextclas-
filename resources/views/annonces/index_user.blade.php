@extends('layouts.app')

@section('title', 'Fil d\'actualités')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800 fw-bold"><i class="fa-solid fa-newspaper text-primary me-2"></i>Fil d'actualités</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mx-auto">
            @forelse($annonces as $annonce)
                <div class="card shadow mb-4 border-0 radius-15">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 1.25rem;">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div>
                                    <h5 class="m-0 font-weight-bold text-primary">{{ $annonce->titre }}</h5>
                                    <small class="text-muted">Publié par {{ $annonce->auteur->name ?? 'Administration' }} • {{ $annonce->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @if($annonce->type == 'urgent')
                                <span class="badge bg-danger rounded-pill px-3 py-2"><i class="fas fa-exclamation-triangle me-1"></i> URGENT</span>
                            @elseif($annonce->type == 'event')
                                <span class="badge bg-info rounded-pill px-3 py-2"><i class="fas fa-calendar-alt me-1"></i> ÉVÉNEMENT</span>
                            @else
                                <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fas fa-info-circle me-1"></i> INFO</span>
                            @endif
                        </div>
                        <p class="card-text text-dark" style="font-size: 1.05rem; line-height: 1.6;">
                            {!! nl2br(e($annonce->contenu)) !!}
                        </p>
                    </div>
                    <!-- (Optionnel) Pied de carte pour interactions futures -->
                    <!-- <div class="card-footer bg-white border-0 pt-0">
                        <button class="btn btn-sm btn-light text-primary"><i class="far fa-thumbs-up me-1"></i> J'aime</button>
                    </div> -->
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-bullhorn fa-4x text-gray-300"></i>
                    </div>
                    <h4 class="text-muted fw-bold">Aucune annonce pour le moment</h4>
                    <p class="text-muted">Les informations importantes de l'école apparaîtront ici.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
