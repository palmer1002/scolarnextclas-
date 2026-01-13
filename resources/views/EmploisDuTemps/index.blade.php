@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Emploi du Temps</h1>
        @if(auth()->user()->role == 'admin')
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCreneauModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter Créneau
        </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $jour)
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">{{ $jour }}</h6>
                </div>
                <div class="card-body">
                    @if(isset($grouped[$jour]))
                        @foreach($grouped[$jour] as $cours)
                        <div class="p-2 border-bottom">
                            <strong>{{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}</strong><br>
                            <span class="text-primary">{{ $cours->matiere->nom }}</span><br>
                            <small class="text-muted">{{ $cours->classe->nom }} - {{ $cours->salle }}</small>
                            @if($cours->enseignant)
                            <br><small><i>{{ $cours->enseignant->name }}</i></small>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center mt-3">Aucun cours</p>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Ajout (Admin Only) -->
@if(auth()->user()->role == 'admin')
<div class="modal fade" id="addCreneauModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('emplois.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un cours</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Classe ID</label>
                        <input type="number" name="classe_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Matière ID</label>
                        <input type="number" name="matiere_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jour</label>
                        <select name="jour_semaine" class="form-select">
                            <option>Lundi</option>
                            <option>Mardi</option>
                            <option>Mercredi</option>
                            <option>Jeudi</option>
                            <option>Vendredi</option>
                            <option>Samedi</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Heure Début</label>
                            <input type="time" name="heure_debut" class="form-control" required>
                        </div>
                        <div class="col">
                            <label>Heure Fin</label>
                            <input type="time" name="heure_fin" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label>Salle</label>
                        <input type="text" name="salle" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
