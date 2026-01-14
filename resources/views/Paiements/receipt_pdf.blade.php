<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de Paiement - {{ $paiement->numero_recu }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }
        .school-name {
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .document-title {
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
        }
        .info-section {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-box {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            font-weight: bold;
            text-transform: uppercase;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f8f9fa;
            font-size: 13px;
            font-weight: bold;
        }
        .summary-section {
            width: 100%;
        }
        .summary-left {
            width: 55%;
            display: inline-block;
        }
        .summary-right {
            width: 40%;
            display: inline-block;
            text-align: center;
            vertical-align: top;
            padding-top: 20px;
        }
        .calculation-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
        }
        .calc-row {
            margin-bottom: 5px;
            font-size: 14px;
        }
        .calc-label {
            display: inline-block;
            width: 150px;
        }
        .calc-value {
            font-weight: bold;
        }
        .total-row {
            border-top: 1px solid #ddd;
            margin-top: 10px;
            padding-top: 5px;
            font-size: 16px;
            color: #dc3545;
        }
        .signature-area {
            margin-top: 50px;
            font-weight: bold;
        }
        .footer {
            margin-top: 100px;
            padding-top: 10px;
            border-top: 1px dotted #999;
            text-align: center;
            font-size: 11px;
            color: #777;
        }
        .text-end { text-align: right; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="school-name">scolarnextclas</div>
            <p style="margin: 0; color: #666;">Système de Gestion Scolaire Moderne</p>
            <div class="document-title">REÇU DE PAIEMENT</div>
            <p style="margin: 5px 0 0 0; font-size: 12px;">Référence: {{ $paiement->numero_recu ?? $paiement->reference }}</p>
        </div>

        <div class="info-section">
            <div class="info-box">
                <div class="info-label">DÉLIVRÉ À :</div>
                <div class="info-value text-uppercase">{{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</div>
                <div style="font-size: 13px;">Matricule : {{ $paiement->eleve->matricule }}</div>
                <div style="font-size: 13px;">Classe : {{ $paiement->eleve->classe->nom ?? 'N/A' }}</div>
            </div>
            <div class="info-box text-end">
                <div class="info-label">DATE D'ÉMISSION :</div>
                <div class="info-value">{{ now()->format('d/m/Y') }}</div>
                <div style="font-size: 12px; color: #666;">Date du paiement : {{ $paiement->date_paiement ? $paiement->date_paiement->format('d/m/Y') : $paiement->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th width="40%">Désignation</th>
                    <th width="20%">Mode</th>
                    <th width="20%">Montant Total</th>
                    <th width="20%">Montant Payé</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;">
                        <div style="font-weight: bold;">{{ $paiement->type_paiement }}</div>
                        <div style="font-size: 11px; color: #666;">{{ $paiement->description ?? 'Règlement scolaire' }}</div>
                    </td>
                    <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                    <td>{{ number_format($paiement->montant_total, 0, ',', ' ') }} FCFA</td>
                    <td style="font-weight: bold; font-size: 16px;">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div class="summary-section">
            <div class="summary-left">
                <div class="calculation-box">
                    <div class="info-label" style="margin-bottom: 10px;">RÉSUMÉ DU COMPTE</div>
                    <div class="calc-row">
                        <span class="calc-label">TOTAL À PAYER :</span>
                        <span class="calc-value">{{ number_format($paiement->montant_total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="calc-row text-success">
                        <span class="calc-label">TOTAL VERSÉ :</span>
                        <span class="calc-value">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="total-row">
                        <span class="calc-label fw-bold">RESTE À PAYER :</span>
                        <span class="calc-value fw-bold">{{ number_format($paiement->montant_restant, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>
            <div class="summary-right">
                <div class="signature-area">SIGNATURE ET CACHET</div>
                <div style="margin-top: 60px; font-size: 13px; border-top: 1px solid #666; padding-top: 5px;">
                    scolarnextclas Administration
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Merci pour votre confiance. En cas de litige, seul ce reçu fait foi.</p>
            <p>Document généré électroniquement par scolarnextclas</p>
        </div>
    </div>
</body>
</html>
