@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Bulletin scolaire - {{ $eleve->nom }} {{ $eleve->prenom }}</h2>
    <p><strong>Classe :</strong> {{ $eleve->classe->niveau ?? '—' }}</p>
    <p><strong>Année scolaire :</strong> {{ $bulletins->first()->annee_scolaire ?? 'N/A' }}</p>

    <hr>

    <h4>Détail par matière</h4>

    <p><strong>Période :</strong> @if(isset($periodType) && $periodType === 'trimestre') Trimestre {{ $periodInt }} @elseif(isset($periodType) && $periodType === 'semestre') Semestre {{ $periodInt }} @else N/A @endif</p>
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

    @if(isset($periodType) && $periodType === 'trimestre')
        <h4>Moyennes trimestrielles</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Trimestre</th>
                    <th>Moyenne générale</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bulletins as $bulletin)
                    <tr>
                        <td>{{ $bulletin->trimestre }}</td>
                        <td>{{ $bulletin->moyenne }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Bouton pour exporter en PDF -->
        <div class="mt-4">
            <a href="{{ route('bulletins.exportPdf', [$eleve->id, $periodInt]) }}" class="btn btn-success">
                Télécharger en PDF
            </a>
        </div>
    @elseif(isset($periodType) && $periodType === 'semestre')
        <h4>Moyennes semestrielles</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Semestre</th>
                    <th>Moyenne générale</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bulletins as $bulletin)
                    <tr>
                        <td>{{ $bulletin->semestre }}</td>
                        <td>{{ $bulletin->moyenne }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Bouton pour exporter en PDF -->
        <div class="mt-4">
            <a href="{{ route('bulletins.exportPdf', [$eleve->id, $periodInt]) }}" class="btn btn-success">
                Télécharger en PDF
            </a>
        </div>
    @else
        <p>Aucune donnée de période disponible pour cet élève.</p>
    @endif
</div>
@endsection