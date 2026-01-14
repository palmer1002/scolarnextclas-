@extends('layouts.app')

@section('title', 'Gestion des Enseignants')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-chalkboard-teacher me-2"></i> Gestion des Enseignants</h2>
        <a href="{{ route('enseignants.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Ajouter un enseignant
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
                            <th>Matière</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Classes assignées</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enseignants as $enseignant)
                        <tr>
                            <td class="fw-bold">
                                {{ $enseignant->title }} {{ $enseignant->first_name }} {{ $enseignant->last_name }}
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $enseignant->subject }}</span></td>
                            <td>{{ $enseignant->email }}</td>
                            <td>{{ $enseignant->phone }}</td>
                            <td>
                                @if($enseignant->classes && $enseignant->classes->count() > 0)
                                    @foreach($enseignant->classes as $classe)
                                        <span class="badge bg-secondary mb-1">{{ $classe->nom }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted small">Aucune classe</span>
                                @endif
                            </td>
                            <td>
                                @if($enseignant->status == 'Permanent')
                                    <span class="badge bg-primary">Permanent</span>
                                @else
                                    <span class="badge bg-info text-dark">Vacataire</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('enseignants.show', $enseignant->id) }}" class="btn btn-sm btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('enseignants.edit', $enseignant->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('enseignants.destroy', $enseignant->id) }}" method="POST" class="m-0" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?');">
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
                                Aucun enseignant trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination if available --}}
            {{-- <div class="d-flex justify-content-end mt-3">{{ $enseignants->links() }}</div> --}}
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        color: #5a5c69;
    }
</style>
@endsection