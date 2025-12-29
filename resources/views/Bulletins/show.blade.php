@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Bulletin scolaire - {{ $eleve->nom }} {{ $eleve->prenom }}</h2>
    <p><strong>Classe :</strong> {{ $eleve->classe->nom }} ({{ $eleve->classe->niveau }})</p>
    <p><strong>Année scolaire :</strong> {{ $bulletins->first()->annee_scolaire ?? 'N/A' }}</p>

    <hr>

    <h4>Détail par matière</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note</th>
                <th>Coefficient</th>
                <th>Moyenne pondérée</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr>
                    <td>{{ $note->matiere->nom }}</td>
                    <td>{{ $note->note }}</td>
                    <td>{{ $note->coefficient }}</td>
                    <td>{{ round($note->note * $note->coefficient, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Moyennes trimestrielles</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Trimestre</th>
                <th>Moyenne générale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulletins->whereNotNull('trimestre') as $bulletin)
                <tr>
                    <td>{{ $bulletin->trimestre }}</td>
                    <td>{{ $bulletin->moyenne }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Moyennes semestrielles</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Semestre</th>
                <th>Moyenne générale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bulletins->whereNotNull('semestre') as $bulletin)
                <tr>
                    <td>{{ $bulletin->semestre }}</td>
                    <td>{{ $bulletin->moyenne }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection