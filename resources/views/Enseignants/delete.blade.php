@extends('layouts.app')

@section('title', 'Supprimer Enseignant')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center pt-5">
        <div class="col-md-6 col-lg-5 text-center">
            <div class="card shadow border-0 radius-10">
                <div class="card-body p-5">
                    <div class="delete-icon-wrapper mb-4">
                        <i class="fas fa-exclamation-triangle fa-4x text-danger"></i>
                    </div>
                    <h2 class="fw-bold text-dark mb-3">Confirmation de suppression</h2>
                    <p class="text-secondary fs-5 mb-4">
                        Êtes-vous certain de vouloir supprimer l'enseignant <br>
                        <strong class="text-dark">{{ $teacher->title }} {{ $teacher->first_name }} {{ $teacher->last_name }}</strong> ?
                    </p>
                    
                    <div class="alert alert-danger border-0 shadow-sm mb-4">
                        <i class="fas fa-exclamation-circle me-1"></i> 
                        <strong>Attention :</strong> Cette action supprimera définitivement le profil de l'enseignant et ses affectations de cours.
                    </div>

                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('enseignants.index') }}" class="btn btn-light border px-4 fw-bold">
                            <i class="fas fa-times me-1"></i> Annuler
                        </a>
                        <form action="{{ route('enseignants.destroy', $teacher->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger px-4 fw-bold shadow-sm">
                                <i class="fas fa-trash me-1"></i> Supprimer définitivement
                            </button>
                        </form>
                    </div>
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