@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary mb-0"><i class="fas fa-user-shield me-2"></i> Administration du Système</h2>
            <p class="text-muted mb-0">Gestion des accès et du personnel administratif</p>
        </div>
        <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary shadow-sm px-4 fw-bold">
            <i class="fas fa-plus-circle me-1"></i> Nouveau Staff
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 radius-10">
        <div class="card-header bg-white py-3">
            <form action="{{ route('utilisateurs.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-0 bg-light" value="{{ request('search') }}" placeholder="Rechercher par nom ou email...">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="fas fa-filter me-1"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Utilisateur & Fonction</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Dernière MAJ</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        @php
                                            $roleBadge = match($user->role) {
                                                'admin' => 'bg-danger',
                                                'secretaire' => 'bg-info text-dark',
                                                'enseignant' => 'bg-primary',
                                                default => 'bg-secondary',
                                            };
                                            $roleLabel = match($user->role) {
                                                'admin' => 'Administrateur',
                                                'secretaire' => 'Secrétaire',
                                                'enseignant' => 'Enseignant',
                                                default => ucfirst($user->role),
                                            };
                                        @endphp
                                        <span class="badge {{ $roleBadge }} rounded-pill" style="font-size: 0.65rem;">{{ $roleLabel }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">{{ $user->email }}</span>
                            </td>
                            <td>
                                @if($user->status == 'active')
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3">
                                        <i class="fas fa-check-circle me-1"></i> Actif
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3">
                                        <i class="fas fa-times-circle me-1"></i> Inactif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">{{ $user->updated_at->diffForHumans() }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('utilisateurs.show', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" class="m-0" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-user-slash fa-3x mb-3 d-block opacity-25"></i>
                                Aucun membre du staff trouvé.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-top bg-light rounded-bottom">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .avatar-sm { width: 40px; height: 40px; font-size: 1.1rem; }
    .table thead th {
        border-bottom: 2px solid #e3e6f0;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.8px;
        color: #4e73df;
        padding: 1rem 0.5rem;
    }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-2px); }
</style>
@endsection