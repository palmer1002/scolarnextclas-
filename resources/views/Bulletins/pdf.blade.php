<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bulletin Scolaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Bulletin Scolaire</h2>
    </div>

    <div class="info">
        <p><strong>Élève :</strong> {{ $eleve->nom }} {{ $eleve->prenom }}</p>
        <p><strong>Classe :</strong> {{ $eleve->classe->niveau ?? '—' }}</p>
        <p><strong>Année scolaire :</strong> {{ $bulletins->first()->annee_scolaire ?? 'N/A' }}</p>
    </div>

    <h4>Détail par matière</h4>
    <table>
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

    <h4>Moyennes Trimestrielles</h4>
    <table>
        <thead>
            <tr>
                <th>Trimestre</th>
                <th>Moyenne générale</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($periodType) && $periodType === 'trimestre')
                @foreach($bulletins as $bulletin)
                    <tr>
                        <td>{{ $bulletin->trimestre }}</td>
                        <td>{{ $bulletin->moyenne }}</td>
                    </tr>
                @endforeach
            @elseif(isset($periodType) && $periodType === 'semestre')
                @foreach($bulletins as $bulletin)
                    <tr>
                        <td>{{ $bulletin->semestre }}</td>
                        <td>{{ $bulletin->moyenne }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h4>Moyennes Semestrielles</h4>
    <table>
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

    <div class="footer">
        <p>Fait le : {{ date('d/m/Y') }}</p>
    </div>
</body>
</html>