@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des bulletins</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Classe</th>
                <th>Année scolaire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulletins as $bulletin)
                <tr>
                    <td>{{ $bulletin->eleve->nom }} {{ $bulletin->eleve->prenom }}</td>
                    <td>{{ $bulletin->eleve->classe->nom }}</td>
                    <td>{{ $bulletin->annee_scolaire }}</td>
                    <td>
                        <a href="{{ route('bulletins.show', $bulletin->eleve_id) }}" class="btn btn-primary btn-sm">
                            Voir bulletin
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection