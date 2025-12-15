@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow-sm">
                <div class="card-header text-center" style="color: #dc3545;">
                    <i class="fas fa-exclamation-triangle me-1"></i> Confirmer la suppression
                </div>

                <div class="card-body text-center">
                    <p>Êtes-vous sûr de vouloir supprimer l’enseignant :</p>
                    <h5 class="mb-4">{{ $teacher->title }} {{ $teacher->last_name }} {{ $teacher->first_name }}</h5>

                    <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i> Supprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
