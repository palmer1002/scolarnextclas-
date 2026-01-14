@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-file-invoice me-2"></i> Liste des bulletins</h2>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'secretaire')
            <a href="{{ route('bulletins.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Générer un Bulletin
            </a>
        @endif
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Période</th>
                <th>Année scolaire</th>
                <th class="text-end pe-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulletins as $bulletin)
                <tr>
                    <td>{{ optional($bulletin->eleve)->nom ?? '—' }} {{ optional($bulletin->eleve)->prenom ?? '' }}</td>
                    <td>{{ optional(optional($bulletin->eleve)->classe)->nom ?? '—' }}</td>
                    <td>{{ $bulletin->type_periode }} {{ $bulletin->numero_periode }}</td>
                    <td>{{ $bulletin->annee_scolaire }}</td>
                    <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="{{ route('bulletins.show', [$bulletin->eleve_id, $bulletin->type_periode . '-' . $bulletin->numero_periode]) }}" class="btn btn-sm btn-outline-primary" title="Voir bulletin">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection