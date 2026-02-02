@extends('layouts.app')

@section('title', 'Gestion des Classes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-chalkboard me-2"></i> Gestion des Classes</h2>
        <a href="{{ route('classes.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Nouvelle Classe
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 radius-10">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Nom de la Classe</th>
                            <th>Niveau</th>
                            <th>Capacité</th>
                            <th>Élèves inscrits</th>

                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $classe)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold">{{ $classe->nom }}</span>
                                </td>
                                <td><span class="badge bg-info text-dark">{{ $classe->niveau }}</span></td>
                                <td>{{ $classe->capacite_max }} places</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                            @php $percent = $classe->capacite_max > 0 ? ($classe->eleves_count / $classe->capacite_max) * 100 : 0; @endphp
                                            <div class="progress-bar bg-primary" style="width: {{ min($percent, 100) }}%"></div>
                                        </div>
                                        <small>{{ $classe->eleves_count }}</small>
                                    </div>
                                </td>

                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm shadow-sm">
                                        <a href="{{ route('classes.show', $classe->id) }}" class="btn btn-outline-info" title="Détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('classes.edit', $classe->id) }}" class="btn btn-outline-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cette classe ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p>Aucune classe enregistrée.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .table thead th { font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; }
</style>
@endsection
