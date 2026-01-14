@extends('layouts.app')

@section('title', 'Liste des matières')

@section('content')
<div class="container">
    <h2 class="mb-4"><i class="fa-solid fa-book"></i> Liste des matières</h2>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-check"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    {{-- Bouton Ajouter --}}
    <div class="mb-3 text-end">
        <a href="{{ route('matieres.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Ajouter une matière
        </a>
    </div>

    {{-- Tableau des matières --}}
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Code</th>
                    <th>Coefficient</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($matieres as $matiere)
                    <tr>
                        <td>{{ $matiere->id }}</td>
                        <td>{{ $matiere->nom }}</td>
                        <td>{{ $matiere->code }}</td>
                        <td>{{ $matiere->coefficient }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('matieres.edit', $matiere->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('matieres.destroy', $matiere->id) }}" method="POST" class="m-0 delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucune matière enregistrée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Confirmation JS --}}
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('⚠️ Voulez-vous vraiment supprimer cette matière ?')) {
                this.submit();
            }
        });
    });
</script>
@endsection
