@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-list-ol me-2"></i> Palmarès par Classe</h2>
        <div class="d-flex gap-2">
            @if($selectedClass && count($bulletins) > 0)
                <a href="{{ route('bulletins.exportClassPdf', ['classe_id' => $selectedClass, 'type_periode' => $type, 'numero_periode' => $numero]) }}" class="btn btn-success">
                    <i class="fas fa-file-pdf me-1"></i> Télécharger tous les bulletins
                </a>
            @endif
            <a href="{{ route('bulletins.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 radius-10 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('bulletins.summary') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Classe</label>
                    <select name="classe_id" class="form-select">
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $selectedClass == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Type</label>
                    <select name="type_periode" class="form-select">
                        <option value="Trimestre" {{ $type == 'Trimestre' ? 'selected' : '' }}>Trimestre</option>
                        <option value="Semestre" {{ $type == 'Semestre' ? 'selected' : '' }}>Semestre</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Numéro</label>
                    <select name="numero_periode" class="form-select">
                        @for($i=1; $i<=3; $i++)
                            <option value="{{ $i }}" {{ $numero == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Afficher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($selectedClass)
    <div class="card shadow-sm border-0 radius-10">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Rang</th>
                            <th>Élève</th>
                            <th>Moyenne</th>
                            <th>Décision</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bulletins as $index => $bulletin)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge {{ $index == 0 ? 'bg-warning text-dark' : ($index < 3 ? 'bg-secondary' : 'bg-light text-dark') }}">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $bulletin->eleve->nomComplet }}</div>
                                    <small class="text-muted">{{ $bulletin->eleve->matricule }}</small>
                                </td>
                                <td>
                                    <div class="fw-bold {{ $bulletin->moyenne < 10 ? 'text-danger' : 'text-success' }}">
                                        {{ number_format($bulletin->moyenne, 2) }}/20
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $bulletin->moyenne >= 10 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $bulletin->moyenne >= 10 ? 'Admis(e)' : 'Échec' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('bulletins.show', [$bulletin->eleve_id, $bulletin->type_periode . '-' . $bulletin->numero_periode]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">Aucun bulletin trouvé pour cette sélection.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
