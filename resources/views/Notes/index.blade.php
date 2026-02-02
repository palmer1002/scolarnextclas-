@extends('layouts.app')

@section('title', 'Liste des notes')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-clipboard-list me-2"></i> Liste des notes</h2>
        <div class="d-flex gap-2">
            @if(in_array(Auth::user()->role, ['admin', 'secretaire', 'enseignant']))
                <a href="{{ route('notes.batch') }}" class="btn btn-outline-primary shadow-sm">
                    <i class="fa-solid fa-tasks me-1"></i> Saisie par Classe
                </a>
                <a href="{{ route('notes.create') }}" class="btn btn-primary shadow-sm">
                    <i class="fa-solid fa-plus me-1"></i> Individuel
                </a>
            @endif
        </div>
    </div>

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
                    <th>Évaluation</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Période</th>

                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                    <tr>
                        <td>{{ optional($note->eleve)->nomComplet ?? 'Élève supprimé' }}</td>
                        <td>{{ optional($note->matiere)->nom ?? 'Matière supprimée' }}</td>
                        <td>
                            <span class="badge {{ $note->type_evaluation == 'Composition' ? 'bg-danger' : ($note->type_evaluation == 'Devoir' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                {{ $note->type_evaluation }} {{ $note->num_evaluation }}
                            </span>
                        </td>
                        <td class="fw-bold">{{ $note->note }}/20</td>
                        <td>x{{ $note->coefficient }}</td>
                        <td>{{ $note->type_periode }} {{ $note->numero_periode }}</td>

                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('notes.show', $note->id) }}" class="btn btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(in_array(Auth::user()->role, ['admin', 'secretaire', 'enseignant']))
                                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
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
