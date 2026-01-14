@extends('layouts.app')

@section('title', 'Gestion des Élèves')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-user-graduate me-2"></i> Gestion des Élèves</h2>
        <a href="{{ route('eleves.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Ajouter un élève
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 radius-10 mb-4">
        <div class="card-body bg-light rounded-top">
            <form action="{{ route('eleves.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Rechercher par nom ou matricule...">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="classe" class="form-select">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
                @if(request('search') || request('classe'))
                    <div class="col-md-2">
                        <a href="{{ route('eleves.index') }}" class="btn btn-outline-secondary w-100">Réinitialiser</a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow border-0 radius-10">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Matricule</th>
                            <th>Nom & Prénom</th>
                            <th>Classe</th>
                            <th>Genre</th>
                            <th>Parent/Tuteur</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eleves as $eleve)
                        <tr>
                            <td class="fw-bold text-primary">{{ $eleve->matricule }}</td>
                            <td>
                                <div class="fw-bold">{{ $eleve->nom_complet }}</div>
                                {{-- Assuming age attribute exists --}}
                                {{-- <small class="text-muted">{{ $eleve->age }} ans</small> --}}
                            </td>
                            <td>
                                @if($eleve->classe)
                                    <span class="badge bg-secondary">{{ $eleve->classe->nom }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($eleve->genre == 'Féminin')
                                    <i class="fas fa-venus text-danger" title="Féminin"></i>
                                @else
                                    <i class="fas fa-mars text-primary" title="Masculin"></i>
                                @endif
                            </td>
                            <td>
                                {{-- Assuming model accessors --}}
                                @if(method_exists($eleve, 'parent') && $eleve->parent)
                                    <div>{{ $eleve->parent->nom_complet }}</div>
                                    <small class="text-muted">{{ $eleve->parent->telephone }}</small>
                                @else
                                    {{ $eleve->parent_nom }} <br>
                                    <small class="text-muted">{{ $eleve->parent_telephone }}</small>
                                @endif
                            </td>
                            <td>
                                @if($eleve->statut == 'inscrit' || $eleve->statut == 'actif')
                                    <span class="badge bg-success">Inscrit</span>
                                @elseif($eleve->statut == 'en_attente')
                                    <span class="badge bg-warning text-dark">En attente</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($eleve->statut) }}</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('eleves.show', $eleve) }}" class="btn btn-sm btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('eleves.edit', $eleve) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('eleves.destroy', $eleve) }}" method="POST" class="m-0" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');">
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
                                <i class="fas fa-user-graduate fa-3x mb-3 d-block"></i>
                                Aucun élève trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $eleves->links() }}
            </div>
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