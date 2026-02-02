@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-th-list me-2"></i> Grille de Saisie des Notes</h2>
        <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour listes
        </a>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show radius-10 border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger radius-10 border-0 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filtres -->
    <div class="card shadow-sm border-0 radius-10 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('notes.batch') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Classe</label>
                    <select name="classe_id" class="form-select select-field" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $selectedClass == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small">Matière</label>
                    <select name="matiere_id" class="form-select select-field" required>
                        <option value="">Sélectionner une matière</option>
                        @foreach($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ $selectedMatiere == $matiere->id ? 'selected' : '' }}>{{ $matiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold small">Période</label>
                    <select name="type_periode" class="form-select select-field">
                        <option value="Trimestre" {{ $type_periode == 'Trimestre' ? 'selected' : '' }}>Trimestre</option>
                        <option value="Semestre" {{ $type_periode == 'Semestre' ? 'selected' : '' }}>Semestre</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label fw-bold small">№</label>
                    <select name="numero_periode" class="form-select select-field">
                        <option value="1" {{ $numero_periode == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $numero_periode == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $numero_periode == 3 ? 'selected' : '' }}>3</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="fas fa-search me-1"></i> Charger la grille
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedClass && $selectedMatiere && count($eleves) > 0)
    <form action="{{ route('notes.batch.store') }}" method="POST">
        @csrf
        <input type="hidden" name="matiere_id" value="{{ $selectedMatiere }}">
        <input type="hidden" name="type_periode" value="{{ $type_periode }}">
        <input type="hidden" name="numero_periode" value="{{ $numero_periode }}">
        
        <div class="card shadow-sm border-0 radius-10 mb-4 bg-light">
            <div class="card-body py-2 px-4">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <span class="text-muted small">Coefficient :</span>
                        <input type="number" name="coefficient" class="form-control form-control-sm d-inline-block w-25 ms-2" value="1" min="1" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 radius-10 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th rowspan="2" class="align-middle" style="min-width: 200px;">Élève</th>
                            <th colspan="3" class="bg-info bg-opacity-75">Interrogations</th>
                            <th colspan="2" class="bg-warning text-dark">Devoirs</th>
                            <th class="bg-danger">Composition</th>
                        </tr>
                        <tr>
                            <th style="width: 100px;">Int 1</th>
                            <th style="width: 100px;">Int 2</th>
                            <th style="width: 100px;">Int 3</th>
                            <th style="width: 100px;">Dev 1</th>
                            <th style="width: 100px;">Dev 2</th>
                            <th style="width: 100px;">Examen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eleves as $eleve)
                            <tr>
                                <td class="ps-3 fw-bold bg-light">
                                    {{ $eleve->nomComplet }}
                                    <div class="text-muted small fw-normal">{{ $eleve->matricule }}</div>
                                </td>
                                <td>
                                    <input type="number" name="notes[{{ $eleve->id }}][Interrogation_1]" class="form-control text-center note-input" step="0.5" min="0" max="20" value="{{ $existingNotes[$eleve->id]['Interrogation_1'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" name="notes[{{ $eleve->id }}][Interrogation_2]" class="form-control text-center note-input" step="0.5" min="0" max="20" value="{{ $existingNotes[$eleve->id]['Interrogation_2'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" name="notes[{{ $eleve->id }}][Interrogation_3]" class="form-control text-center note-input" step="0.5" min="0" max="20" value="{{ $existingNotes[$eleve->id]['Interrogation_3'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" name="notes[{{ $eleve->id }}][Devoir_1]" class="form-control text-center note-input border-warning" step="0.5" min="0" max="20" value="{{ $existingNotes[$eleve->id]['Devoir_1'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" name="notes[{{ $eleve->id }}][Devoir_2]" class="form-control text-center note-input border-warning" step="0.5" min="0" max="20" value="{{ $existingNotes[$eleve->id]['Devoir_2'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" name="notes[{{ $eleve->id }}][Composition_1]" class="form-control text-center note-input border-danger fw-bold" step="0.5" min="0" max="20" value="{{ $existingNotes[$eleve->id]['Composition_1'] ?? '' }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted italic small"><i class="fas fa-info-circle me-1"></i> Les cases vides ne seront pas enregistrées ou resteront inchangées.</span>
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                        <i class="fas fa-save me-2"></i> Enregistrer la grille de notes
                    </button>
                </div>
            </div>
        </div>
    </form>
    @elseif($selectedClass && $selectedMatiere)
        <div class="alert alert-info shadow-sm border-0 radius-10">
            <i class="fas fa-info-circle me-2"></i> Aucun élève trouvé dans cette classe.
        </div>
    @else
        <div class="text-center py-5 text-muted">
            <i class="fas fa-table fa-5x mb-3 opacity-25"></i>
            <h4>Veuillez sélectionner une classe et une matière pour afficher la grille.</h4>
        </div>
    @endif
</div>

<style>
    .radius-10 { border-radius: 10px; }
    .note-input {
        border-radius: 4px;
        padding: 5px;
        font-size: 1rem;
    }
    .note-input:focus {
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.2);
        background-color: #fff9db;
    }
    .table thead th {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .select-field { border-radius: 8px; }
</style>
@endsection
