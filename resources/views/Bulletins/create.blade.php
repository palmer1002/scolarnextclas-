@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Générer un Bulletin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('bulletins.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Élève</label>
                            <select name="eleve_id" class="form-select select2" required>
                                <option value="">Sélectionner un élève</option>
                                @foreach($eleves as $eleve)
                                    <option value="{{ $eleve->id }}">{{ $eleve->nomComplet }} ({{ $eleve->matricule }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Type de Période</label>
                                <select name="type_periode" class="form-select" required>
                                    <option value="Trimestre">Trimestre</option>
                                    <option value="Semestre">Semestre</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Numéro de Période</label>
                                <select name="numero_periode" class="form-select" required>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Année Scolaire</label>
                            <input type="text" name="annee_scolaire" class="form-control" placeholder="ex: 2025-2026" required value="{{ date('Y') . '-' . (date('Y') + 1) }}">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('bulletins.index') }}" class="btn btn-light">Annuler</a>
                            <button type="submit" class="btn btn-primary">Calculer et Historiser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
