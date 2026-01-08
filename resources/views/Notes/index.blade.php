@extends('layouts.app')

@section('title', 'Liste des notes')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fa-solid fa-clipboard-list"></i> Liste des notes</h2>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Tableau des notes --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Élève</th>
                    <th>Matière</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Trimestre</th>
                    <th>Année scolaire</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                    <tr>
                        <td>{{ optional($note->eleve)->nomComplet ?? 'Élève supprimé' }}</td>
                        <td>{{ optional($note->matiere)->nom ?? 'Matière supprimée' }}</td>
                        <td>{{ $note->note }}</td>
                        <td>{{ $note->coefficient }}</td>
                        <td>{{ $note->trimestre }}</td>
                        <td>{{ $note->annee_scolaire }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune note enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
