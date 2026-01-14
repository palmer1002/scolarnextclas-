@extends('layouts.app')

@section('title', 'Gestion des Parents')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-users me-2"></i> Gestion des Parents</h2>
        <a href="{{ route('parents.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Ajouter un parent
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 radius-10">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom complet</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Relation</th>
                            <th>Élève(s)</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parents as $parent)
                        <tr>
                            <td class="fw-bold">{{ $parent->nom_complet }}</td>
                            <td>{{ $parent->telephone }}</td>
                            <td>{{ $parent->email }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $parent->relation }}</span>
                            </td>
                            <td>
                                @foreach($parent->students as $student)
                                    <div class="badge bg-secondary mb-1">
                                        {{ $student->nom }} {{ $student->prenom }} <small>({{ $student->matricule }})</small>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                @if($parent->statut == 'active')
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('parents.show', $parent->id) }}" class="btn btn-sm btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" class="m-0" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce parent ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-search fa-3x mb-3 d-block"></i>
                                Aucun parent trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $parents->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom polished styles for this view */
    .radius-10 {
        border-radius: 10px;
    }
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        color: #5a5c69;
    }
    .btn-group .btn {
        margin-left: 2px;
        border-radius: 4px;
    }
</style>
@endsection