@extends('layouts.app')

@section('title', 'Supprimer Utilisateur - ' . $user->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center pt-5">
        <div class="col-md-6 col-lg-5 text-center">
            <div class="card shadow border-0 radius-10">
                <div class="card-body p-5">
                    <div class="delete-icon-wrapper mb-4">
                        <i class="fas fa-exclamation-triangle fa-4x text-danger animate__animated animate__pulse animate__infinite"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-3">Confirmation de suppression</h2>
                    <p class="text-secondary fs-5 mb-4">
                        Êtes-vous certain de vouloir supprimer l'utilisateur <br>
                        <strong class="text-dark">{{ $user->name }}</strong> ({{ $user->email }}) ?
                    </p>
                    
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <i class="fas fa-exclamation-circle me-1"></i> 
                        <strong>Attention :</strong> Cette action supprimera définitivement le compte utilisateur. L'accès au système sera immédiatement révoqué.
                    </div>

                    @if($user->id === auth()->id())
                        <div class="alert alert-warning border-0">
                            <i class="fas fa-lock me-1"></i> Vous ne pouvez pas supprimer votre propre compte.
                        </div>
                        <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn btn-secondary px-4 fw-bold shadow-sm">
                            <i class="fas fa-arrow-left me-1"></i> Retour
                        </a>
                    @else
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn btn-light border px-4 fw-bold">
                                <i class="fas fa-times me-1"></i> Annuler
                            </a>
                            <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4 fw-bold shadow-sm">
                                    <i class="fas fa-trash me-1"></i> Supprimer définitivement
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .delete-icon-wrapper {
        background: rgba(220, 53, 69, 0.1);
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto;
    }
</style>
@endsection