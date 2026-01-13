<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin - {{ $eleve->nom }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 20px; border: 1px solid #ccc; padding: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ScolarNextClas</h1>
        <h2>Bulletin de Notes - {{ ucfirst($periode) }}</h2>
    </div>

    <div class="info">
        <strong>Nom :</strong> {{ $eleve->nom }} {{ $eleve->prenom }}<br>
        <strong>Matricule :</strong> {{ $eleve->matricule }}<br>
        <strong>Classe :</strong> {{ $eleve->classe }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Moyenne / 20</th>
                <th>Coef</th>
                <th>Points</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resultats as $matiere)
            <tr>
                <td style="text-align: left; padding-left: 10px;">{{ $matiere['matiere'] }}</td>
                <td>{{ number_format($matiere['moyenne'], 2) }}</td>
                <td>{{ $matiere['coef'] }}</td>
                <td>{{ number_format($matiere['points'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="font-weight: bold; background-color: #e9e9e9;">
                <td colspan="3" style="text-align: right; padding-right: 10px;">Moyenne Générale</td>
                <td>{{ number_format($moyenneGenerale, 2) }} / 20</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Fait à ......................, le {{ date('d/m/Y') }}</p>
        <p><strong>Le Directeur</strong></p>
        <br><br><br>
        <p>Signature</p>
    </div>
</body>
</html>