<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletins de Classe</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 9pt; color: #333; line-height: 1.2; }
        .page-break { page-break-after: always; }
        .company-header { text-align: center; margin-bottom: 10px; border-bottom: 2px solid #2e59d9; padding-bottom: 5px; }
        .school-name { font-size: 20pt; font-weight: bold; color: #2e59d9; margin: 0; }
        .school-slogan { font-size: 8pt; font-style: italic; color: #666; }
        .title { text-align: center; font-size: 14pt; text-transform: uppercase; margin: 10px 0; background: #f8f9fc; padding: 5px; border: 1px solid #e3e6f0; }
        .info-grid { width: 100%; margin-bottom: 15px; border-collapse: collapse; font-size: 10pt; }
        table.notes-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        table.notes-table th { background-color: #4e73df; color: white; padding: 4px; font-weight: bold; border: 1px solid #2e59d9; font-size: 8pt; }
        table.notes-table td { border: 1px solid #e3e6f0; padding: 4px; text-align: center; font-size: 9pt; }
        .text-left { text-align: left; }
        .summary { width: 40%; margin-left: 60%; margin-bottom: 20px; }
        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-table td { font-weight: bold; padding: 5px; border: 1px solid #e3e6f0; }
        .summary-title { background: #4e73df; color: white; padding: 5px; text-align: center; font-weight: bold; }
        .footer { margin-top: 30px; }
        .signature-box { width: 45%; display: inline-block; vertical-align: top; text-align: center; }
        .appreciation-row { font-style: italic; font-size: 8pt; color: #555; }
        .failed { color: #e74a3b; font-weight: bold; }
        .passed { color: #1cc88a; font-weight: bold; }
        .bg-light { background-color: #f8f9fc; }
    </style>
</head>
<body>
    @foreach($allData as $index => $data)
        <div class="{{ $loop->last ? '' : 'page-break' }}">
            <div class="company-header">
                <h1 class="school-name">SCOLARNEXT</h1>
                <p class="school-slogan">L'Excellence au Service de l'Éducation</p>
            </div>

            <div class="title">BULLETIN DE NOTES - {{ strtoupper($data['periode']) }}</div>

            <table class="info-grid">
                <tr>
                    <td class="text-left" style="width: 50%; padding: 5px;">
                        <strong>ÉLÈVE :</strong> {{ strtoupper($data['eleve']->nom) }} {{ $data['eleve']->prenom }}<br>
                        <strong>MATRICULE :</strong> {{ $data['eleve']->matricule }}<br>
                        <strong>DATE DE NAISSANCE :</strong> {{ $data['eleve']->date_naissance ? \Carbon\Carbon::parse($data['eleve']->date_naissance)->format('d/m/Y') : 'N/A' }}
                    </td>
                    <td class="text-left" style="width: 50%; padding: 5px;">
                        <strong>CLASSE :</strong> {{ $data['eleve']->classe->nom ?? '—' }}<br>
                        <strong>ANNÉE SCOLAIRE :</strong> 2025-2026<br>
                        <strong>RANG :</strong> {{ $data['rang']['position'] }} / {{ $data['rang']['total'] }}
                    </td>
                </tr>
            </table>

            <table class="notes-table">
                <thead>
                    <tr>
                        <th class="text-left" rowspan="2">Matières</th>
                        <th colspan="3">Interros</th>
                        <th colspan="2">Devoirs</th>
                        <th rowspan="2">Comp.</th>
                        <th rowspan="2">Moy. T</th>
                        <th rowspan="2">Coef</th>
                        <th rowspan="2">Points</th>
                        <th rowspan="2">Appréciation</th>
                    </tr>
                    <tr>
                        <th>I1</th>
                        <th>I2</th>
                        <th>I3</th>
                        <th>D1</th>
                        <th>D2</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['resultats'] as $res)
                    <tr>
                        <td class="text-left"><strong>{{ $res['matiere'] }}</strong></td>
                        <td>{{ number_format($res['interro1'], 1) ?? '-' }}</td>
                        <td>{{ number_format($res['interro2'], 1) ?? '-' }}</td>
                        <td>{{ number_format($res['interro3'], 1) ?? '-' }}</td>
                        <td>{{ number_format($res['devoir1'], 1) ?? '-' }}</td>
                        <td>{{ number_format($res['devoir2'], 1) ?? '-' }}</td>
                        <td class="bg-light">{{ number_format($res['composition'], 1) ?? '-' }}</td>
                        <td class="{{ $res['moyenne'] < 10 ? 'failed' : '' }} fw-bold" style="background: #eee;">{{ number_format($res['moyenne'], 2) }}</td>
                        <td>{{ $res['coef'] }}</td>
                        <td>{{ number_format($res['points'], 2) }}</td>
                        <td class="appreciation-row">{{ $res['appreciation'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: #f8f9fc; font-weight: bold;">
                        <td class="text-left" colspan="8">TOTAUX</td>
                        <td>{{ $data['totalCoef'] }}</td>
                        <td>{{ number_format($data['totalPoints'], 2) }}</td>
                        <td>-</td>
                    </tr>
                </tfoot>
            </table>

            <div class="summary">
                <div class="summary-title">RÉSULTAT GÉNÉRAL</div>
                <table class="summary-table">
                    <tr>
                        <td>MOYENNE GÉNÉRALE</td>
                        <td class="{{ $data['moyenneGenerale'] < 10 ? 'failed' : 'passed' }}" style="font-size: 14pt;">{{ number_format($data['moyenneGenerale'], 2) }} / 20</td>
                    </tr>
                    <tr>
                        <td>RANG</td>
                        <td>{{ $data['rang']['position'] }} sur {{ $data['rang']['total'] }}</td>
                    </tr>
                    <tr>
                        <td>DÉCISION</td>
                        <td>{{ $data['moyenneGenerale'] >= 10 ? 'ADMIS(E)' : 'ÉCHEC' }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <div class="signature-box">
                    <p>Observations du Parent</p>
                    <div style="height: 60px; border-bottom: 1px dotted #ccc;"></div>
                </div>
                <div class="signature-box" style="float: right;">
                    <p>Fait le, {{ now()->translatedFormat('d F Y') }}</p>
                    <p>Le Chef d'Établissement</p>
                    <br>
                    <p style="font-weight: bold; margin-top: 30px;">Cachet & Signature</p>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
