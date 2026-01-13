@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Présences</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPresenceModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle Présence
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des présences récentes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Élève</th>
                            <th>Classe</th>
                            <th>Statut</th>
                            <th>Justifié</th>
                            <th>Motif</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($presences as $presence)
                        <tr>
                            <td>{{ $presence->date->format('d/m/Y') }}</td>
                            <td>{{ $presence->eleve->nom }} {{ $presence->eleve->prenom }}</td>
                            <td>{{ $presence->classe->nom ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $presence->statut == 'present' ? 'success' : ($presence->statut == 'absent' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($presence->statut) }}
                                </span>
                            </td>
                            <td>{{ $presence->justifie ? 'Oui' : 'Non' }}</td>
                            <td>{{ $presence->motif }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $presences->links() }}
        </div>
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="addPresenceModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('presences.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Saisir une présence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Élève ID</label>
                        <input type="number" name="eleve_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Statut</label>
                        <select name="statut" class="form-select">
                            <option value="present">Présent</option>
                            <option value="absent">Absent</option>
                            <option value="retard">Retard</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Motif (si absent/retard)</label>
                        <input type="text" name="motif" class="form-control">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="justifie" value="1" class="form-check-input" id="checkJustif">
                        <label class="form-check-label" for="checkJustif">Justifié ?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
