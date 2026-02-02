@extends('layouts.app')

@section('title', 'Modifier une Note')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-edit me-2"></i> Modifier une Note</h2>
        <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('notes.update', $note->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="eleve_id" class="form-label">Élève <span class="text-danger">*</span></label>
                        <select name="eleve_id" id="eleve_id" class="form-select @error('eleve_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner un élève --</option>
                            @foreach($eleves as $eleve)
                                <option value="{{ $eleve->id }}" {{ old('eleve_id', $note->eleve_id) == $eleve->id ? 'selected' : '' }}>
                                    {{ $eleve->nomComplet }} ({{ $eleve->matricule }})
                                </option>
                            @endforeach
                        </select>
                        @error('eleve_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="matiere_id" class="form-label">Matière <span class="text-danger">*</span></label>
                        <select name="matiere_id" id="matiere_id" class="form-select @error('matiere_id') is-invalid @enderror" required>
                            <option value="">-- Sélectionner une matière --</option>
                            @foreach($matieres as $matiere)
                                <option value="{{ $matiere->id }}" {{ old('matiere_id', $note->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                    {{ $matiere->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('matiere_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="note" class="form-label">Note (/20) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" max="20" name="note" id="note" 
                               class="form-control @error('note') is-invalid @enderror" 
                               value="{{ old('note', $note->note) }}" required>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="coefficient" class="form-label">Coefficient <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="coefficient" id="coefficient" 
                               class="form-control @error('coefficient') is-invalid @enderror" 
                               value="{{ old('coefficient', $note->coefficient) }}" required>
                        @error('coefficient')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="type_evaluation" class="form-label">Type d'évaluation <span class="text-danger">*</span></label>
                        <select name="type_evaluation" id="type_evaluation" class="form-select @error('type_evaluation') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="Interrogation" {{ old('type_evaluation', $note->type_evaluation) == 'Interrogation' ? 'selected' : '' }}>Interrogation</option>
                            <option value="Devoir" {{ old('type_evaluation', $note->type_evaluation) == 'Devoir' ? 'selected' : '' }}>Devoir</option>
                            <option value="Composition" {{ old('type_evaluation', $note->type_evaluation) == 'Composition' ? 'selected' : '' }}>Composition</option>
                        </select>
                        @error('type_evaluation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="num_evaluation" class="form-label">Numéro <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="num_evaluation" id="num_evaluation" 
                               class="form-control @error('num_evaluation') is-invalid @enderror" 
                               value="{{ old('num_evaluation', $note->num_evaluation) }}" required>
                        @error('num_evaluation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="type_periode" class="form-label">Type de période <span class="text-danger">*</span></label>
                        <select name="type_periode" id="type_periode" class="form-select @error('type_periode') is-invalid @enderror" required>
                            <option value="">-- Sélectionner --</option>
                            <option value="Trimestre" {{ old('type_periode', $note->type_periode) == 'Trimestre' ? 'selected' : '' }}>Trimestre</option>
                            <option value="Semestre" {{ old('type_periode', $note->type_periode) == 'Semestre' ? 'selected' : '' }}>Semestre</option>
                        </select>
                        @error('type_periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="numero_periode" class="form-label">Numéro de période <span class="text-danger">*</span></label>
                        <input type="number" min="1" max="3" name="numero_periode" id="numero_periode" 
                               class="form-control @error('numero_periode') is-invalid @enderror" 
                               value="{{ old('numero_periode', $note->numero_periode) }}" required>
                        @error('numero_periode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
