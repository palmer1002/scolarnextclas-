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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bulletins.store') }}" method="POST">
                        @csrf
                        
                        <ul class="nav nav-tabs mb-4" id="bulletinType" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="single-tab" data-bs-toggle="tab" data-bs-target="#single" type="button" role="tab" aria-controls="single" aria-selected="true">Par Élève</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="class-tab" data-bs-toggle="tab" data-bs-target="#class" type="button" role="tab" aria-controls="class" aria-selected="false">Par Classe</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="bulletinTypeContent">
                            <div class="tab-pane fade show active" id="single" role="tabpanel" aria-labelledby="single-tab">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Élève</label>
                                    <select name="eleve_id" class="form-select select2">
                                        <option value="">Sélectionner un élève</option>
                                        @foreach($eleves as $eleve)
                                            <option value="{{ $eleve->id }}">{{ $eleve->nomComplet }} ({{ $eleve->matricule }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="class" role="tabpanel" aria-labelledby="class-tab">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Classe</label>
                                    <select name="classe_id" class="form-select select2">
                                        <option value="">Sélectionner une classe</option>
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
