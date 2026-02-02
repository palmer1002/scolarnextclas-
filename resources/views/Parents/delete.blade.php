@extends('layouts.app')

@section('content')
<div class="content">
    <!-- Navbar -->
    <div class="navbar">
        <div>
            <h1><i class="fas fa-users"></i> Gestion des Parents</h1>
            <p>Administrez les informations des parents et tuteurs des élèves</p>
        </div>
        <div style="display: flex; gap: 15px;">
        </div>
    </div>

    <!-- Page de suppression -->
    <div class="container">
        <section class="card">
            <div class="delete-confirmation">
                <div class="delete-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2>Confirmer la suppression</h2>
                <p style="margin: 20px 0; font-size: 1.1rem; color: #666;">
                    Êtes-vous sûr de vouloir supprimer le parent <strong>{{ $parent->name }}</strong> ?
                    Cette action est irréversible.
                </p>
                
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <a href="{{ route('parents.index') }}" class="btn btn-outline">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                    <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Confirmer la suppression
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection