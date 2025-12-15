@extends('layouts.app')

@section('title', 'Supprimer ' . $eleve->nom_complet . ' - ScolarNextClas')

@section('content')
<div class="container">
    <section class="card">
        <div class="delete-confirmation">
            <div class="delete-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h2>Confirmer la suppression</h2>
            <p style="margin: 20px 0; font-size: 1.1rem; color: #666;">
                Êtes-vous sûr de vouloir supprimer <strong>{{ $eleve->nom_complet }}</strong> ({{ $eleve->matricule }}) ?
            </p>
            <p style="margin: 20px 0; color: #dc3545;">
                <i class="fas fa-exclamation-circle"></i> Cette action est irréversible et supprimera toutes les données associées à cet élève.
            </p>
            
            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                <a href="{{ route('eleves.show', $eleve->id) }}" class="btn btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
                <form action="{{ route('eleves.destroy', $eleve->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous vraiment sûr ?')">
                        <i class="fas fa-trash"></i> Confirmer la suppression
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
<style>
    .delete-confirmation {
        text-align: center;
        padding: 40px 20px;
    }
    .delete-icon {
        font-size: 4rem;
        color: #dc3545;
        margin-bottom: 20px;
    }
</style>
@endsection