<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Paiement - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar {
            width: 250px;
            background-color: #170B9DFF;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            color: white;
            font-family: Arial, sans-serif;
        }
        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }
        .sidebar .logo span {
            background: #ff6b6b;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            color: white;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar li {
            padding: 15px 20px;
        }
        .sidebar li.active {
            background-color: #7d6ae8;
        }
        .sidebar li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: white;
            border-bottom: 1px solid #ddd;
            font-family: Arial, sans-serif;
            margin: -20px -20px 20px -20px;
        }
        .info-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .badge-statut {
            padding: 8px 15px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: bold;
        }
        .badge-paye { background-color: #d4edda; color: #155724; }
        .badge-en-attente { background-color: #fff3cd; color: #856404; }
        .badge-partiel { background-color: #cce5ff; color: #004085; }
        .badge-annule { background-color: #f8d7da; color: #721c24; }
        .badge-brouillon { background-color: #e2e3e5; color: #383d41; }
        .badge-rembourse { background-color: #d1ecf1; color: #0c5460; }
        .info-label {
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        .montant-box {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 15px;
            margin: 10px 0;
        }
        .btn-print {
            background: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <span>$</span>
            <h3>ScolarNextClas</h3>
        </div>
        <ul>
            <li>
                <a href="/">
                    <i class="fas fa-chart-pie"></i> Tableau de bord
                </a>
            </li>
            <li>
                <a href="/paiement" class="active">
                    <i class="fas fa-money-bill-wave"></i> Paiement
                </a>
            </li>
            <li>
                <a href="/eleves">
                    <i class="fas fa-user-graduate"></i> Élèves
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1>Détails du Paiement</h1>
                <p>Informations complètes sur le paiement</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="/paiement" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <button class="btn btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimer
                </button>
            </div>
        </div>

        <div id="paiement-details">
            <!-- Les détails seront chargés ici -->
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer l'ID du paiement depuis l'URL
            const pathArray = window.location.pathname.split('/');
            const paiementId = pathArray[pathArray.length - 1];
            
            chargerDetailsPaiement(paiementId);
        });

        function chargerDetailsPaiement(id) {
            fetch(`/api/paiements/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        afficherDetailsPaiement(data.data);
                    } else {
                        document.getElementById('paiement-details').innerHTML = 
                            '<div class="alert alert-danger">Paiement non trouvé</div>';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.getElementById('paiement-details').innerHTML = 
                        '<div class="alert alert-danger">Erreur lors du chargement des détails</div>';
                });
        }

        function afficherDetailsPaiement(paiement) {
            // Déterminer la classe du badge
            let badgeClass = '';
            let badgeText = '';
            switch(paiement.statut) {
                case 'payé':
                    badgeClass = 'badge-paye';
                    badgeText = 'Payé';
                    break;
                case 'en_attente':
                    badgeClass = 'badge-en-attente';
                    badgeText = 'En attente';
                    break;
                case 'partiel':
                    badgeClass = 'badge-partiel';
                    badgeText = 'Partiel';
                    break;
                case 'annulé':
                    badgeClass = 'badge-annule';
                    badgeText = 'Annulé';
                    break;
                case 'remboursé':
                    badgeClass = 'badge-rembourse';
                    badgeText = 'Remboursé';
                    break;
                case 'brouillon':
                    badgeClass = 'badge-brouillon';
                    badgeText = 'Brouillon';
                    break;
            }

            const html = `
                <div class="row">
                    <!-- Informations générales -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3>Informations Générales</h3>
                                <span class="badge-statut ${badgeClass}">${badgeText}</span>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">Numéro de Reçu</div>
                                    <div class="info-value">${paiement.numero_recu || 'N/A'}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Référence</div>
                                    <div class="info-value">${paiement.reference || 'N/A'}</div>
                                </div>
                            </div>
                            
                            <div class="info-label">Type de Paiement</div>
                            <div class="info-value">${paiement.type_paiement}</div>
                            
                            <div class="info-label">Mode de Paiement</div>
                            <div class="info-value">${paiement.mode_paiement || 'Non spécifié'}</div>
                            
                            <div class="info-label">Description</div>
                            <div class="info-value">${paiement.description || 'Aucune description'}</div>
                        </div>

                        <!-- Informations sur l'élève -->
                        <div class="info-card">
                            <h4 class="mb-4">Informations de l'Élève</h4>
                            
                            ${paiement.eleve ? `
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">Nom</div>
                                    <div class="info-value">${paiement.eleve.nom} ${paiement.eleve.prenom}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Matricule</div>
                                    <div class="info-value">${paiement.eleve.matricule || 'N/A'}</div>
                                </div>
                            </div>
                            
                            <div class="info-label">Classe</div>
                            <div class="info-value">${paiement.eleve.classe || 'Non spécifiée'}</div>
                            ` : '<div class="text-muted">Information élève non disponible</div>'}
                        </div>
                    </div>

                    <!-- Montants et dates -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <h4 class="mb-4">Montants</h4>
                            
                            <div class="montant-box">
                                <div class="info-label">Montant Total</div>
                                <div class="info-value" style="font-size: 1.5rem; font-weight: bold;">
                                    ${formatMontant(paiement.montant_total)} FCFA
                                </div>
                            </div>
                            
                            <div class="montant-box">
                                <div class="info-label">Montant Déjà Payé</div>
                                <div class="info-value" style="font-size: 1.3rem; color: #28a745;">
                                    ${formatMontant(paiement.montant_paye)} FCFA
                                </div>
                            </div>
                            
                            <div class="montant-box">
                                <div class="info-label">Montant Restant</div>
                                <div class="info-value" style="font-size: 1.3rem; color: ${paiement.montant_restant > 0 ? '#dc3545' : '#28a745'}">
                                    ${formatMontant(paiement.montant_restant)} FCFA
                                </div>
                            </div>
                            
                            <!-- Barre de progression -->
                            <div class="mt-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Progression</span>
                                    <span>${paiement.pourcentage_paye || 0}%</span>
                                </div>
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar bg-success" 
                                         style="width: ${paiement.pourcentage_paye || 0}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="info-card">
                            <h4 class="mb-4">Dates</h4>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-label">Date de Création</div>
                                    <div class="info-value">${formatDate(paiement.created_at)}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-label">Date de Paiement</div>
                                    <div class="info-value">${formatDate(paiement.date_paiement)}</div>
                                </div>
                            </div>
                            
                            <div class="info-label">Date d'Échéance</div>
                            <div class="info-value ${paiement.est_en_retard ? 'text-danger' : ''}">
                                ${formatDate(paiement.date_echeance)} 
                                ${paiement.est_en_retard ? ' (En retard)' : ''}
                            </div>
                            
                            ${paiement.date_validation ? `
                            <div class="info-label">Date de Validation</div>
                            <div class="info-value">${formatDate(paiement.date_validation)}</div>
                            ` : ''}
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="info-card">
                            <h4 class="mb-4">Informations Supplémentaires</h4>
                            
                            ${paiement.banque ? `
                            <div class="info-label">Banque</div>
                            <div class="info-value">${paiement.banque}</div>
                            ` : ''}
                            
                            ${paiement.numero_cheque ? `
                            <div class="info-label">Numéro de Chèque</div>
                            <div class="info-value">${paiement.numero_cheque}</div>
                            ` : ''}
                            
                            ${paiement.reference_virement ? `
                            <div class="info-label">Référence Virement</div>
                            <div class="info-value">${paiement.reference_virement}</div>
                            ` : ''}
                            
                            ${paiement.notes ? `
                            <div class="info-label">Notes</div>
                            <div class="info-value">${paiement.notes}</div>
                            ` : ''}
                            
                            ${paiement.preuve_paiement ? `
                            <div class="info-label">Preuve de Paiement</div>
                            <div class="info-value">
                                <a href="/storage/${paiement.preuve_paiement}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Voir la preuve
                                </a>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="info-card mt-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="/paiement" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour à la liste
                            </a>
                        </div>
                        <div>
                            ${paiement.peut_etre_modifie ? `
                            <a href="/paiements/${paiement.id}/edit" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            ` : ''}
                            
                            ${paiement.statut !== 'payé' && paiement.statut !== 'annulé' && paiement.statut !== 'remboursé' ? `
                            <button class="btn btn-primary" onclick="payerPaiement(${paiement.id})">
                                <i class="fas fa-money-bill-wave"></i> Marquer comme payé
                            </button>
                            ` : ''}
                            
                            ${paiement.statut !== 'annulé' && paiement.statut !== 'remboursé' ? `
                            <button class="btn btn-danger" onclick="annulerPaiement(${paiement.id})">
                                <i class="fas fa-times-circle"></i> Annuler
                            </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('paiement-details').innerHTML = html;
        }

        function payerPaiement(id) {
            if (confirm('Marquer ce paiement comme entièrement payé ?')) {
                fetch(`/api/paiements/${id}/marquer-paye`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        mode_paiement: 'espèces' // Par défaut
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Paiement marqué comme payé avec succès');
                        chargerDetailsPaiement(id);
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }

        function annulerPaiement(id) {
            const motif = prompt('Veuillez entrer le motif d\'annulation:');
            if (motif) {
                fetch(`/api/paiements/${id}/annuler`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        motif_annulation: motif
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Paiement annulé avec succès');
                        chargerDetailsPaiement(id);
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
        }

        // Fonctions utilitaires
        function formatMontant(montant) {
            return parseFloat(montant).toLocaleString('fr-FR');
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR') + ' ' + date.toLocaleTimeString('fr-FR');
        }
    </script>
</body>
</html>