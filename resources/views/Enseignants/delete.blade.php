@extends('layouts.app')

@section('title', 'Supprimer un enseignant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="color:#170B9DFF;">
                        <i class="fas fa-trash me-2"></i> Supprimer un enseignant
                    </h4>
                </div>

                <div class="card-body text-center">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Êtes-vous sûr de vouloir supprimer cet enseignant ?
                    </div>

                    <h5 class="mb-4">{{ $teacher->title }} {{ $teacher->last_name }} {{ $teacher->first_name }}</h5>

                    <form action="{{ route('enseignants.destroy', $teacher->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('enseignants') }}" class="btn btn-secondary">
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