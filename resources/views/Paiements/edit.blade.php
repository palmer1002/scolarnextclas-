<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Paiement - ScolarNextClas</title>
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
        .form-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .montant-input {
            font-size: 1.2rem;
            font-weight: bold;
            text-align: right;
        }
        .required::after {
            content: " *";
            color: red;
        }
        .info-helper {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: -10px;
            margin-bottom: 10px;
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
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1>Modifier le Paiement</h1>
                <p>Mettez à jour les informations du paiement</p>
            </div>
            <div>
                <a href="/paiement" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="form-container">
            <form id="form-edit-paiement">
                <div id="erreurs" class="alert alert-danger d-none"></div>
                
                <!-- Section Élève -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-user-graduate"></i> Élève</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="required">Élève</label>
                            <select id="eleve_id" class="form-select" required disabled>
                                <option value="">Sélectionnez un élève</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section Montants -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-money-bill-wave"></i> Montants</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="required">Montant Total (FCFA)</label>
                                    <input type="number" id="montant_total" class="form-control montant-input" 
                                           step="0.01" min="0" required>
                                    <div class="info-helper">Montant total à payer</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="required">Montant Déjà Payé (FCFA)</label>
                                    <input type="number" id="montant_paye" class="form-control montant-input" 
                                           step="0.01" min="0" required>
                                    <div class="info-helper">Montant déjà payé par l'élève</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Montant Restant (FCFA)</label>
                                    <input type="text" id="montant_restant" class="form-control montant-input" 
                                           readonly style="background-color: #f8f9fa;">
                                    <div class="info-helper">Calculé automatiquement</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Pourcentage Payé</label>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar" id="progress-bar" style="width: 0%"></div>
                                    </div>
                                    <div class="text-center mt-1" id="pourcentage-text">0%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Informations de Paiement -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-info-circle"></i> Informations de Paiement</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="required">Type de Paiement</label>
                                    <select id="type_paiement" class="form-select" required>
                                        <option value="">Sélectionnez un type</option>
                                        <option value="Scolarité">Scolarité</option>
                                        <option value="Cantine">Cantine</option>
                                        <option value="Transport">Transport</option>
                                        <option value="Fournitures">Fournitures</option>
                                        <option value="Activités">Activités</option>
                                        <option value="Assurance">Assurance</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="required">Statut</label>
                                    <select id="statut" class="form-select" required>
                                        <option value="brouillon">Brouillon</option>
                                        <option value="en_attente">En attente</option>
                                        <option value="partiel">Partiel</option>
                                        <option value="payé">Payé</option>
                                        <option value="annulé">Annulé</option>
                                        <option value="remboursé">Remboursé</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Mode de Paiement</label>
                                    <select id="mode_paiement" class="form-select">
                                        <option value="">Sélectionnez un mode</option>
                                        <option value="espèces">Espèces</option>
                                        <option value="chèque">Chèque</option>
                                        <option value="virement">Virement</option>
                                        <option value="carte_bancaire">Carte bancaire</option>
                                        <option value="mobile_money">Mobile Money</option>
                                        <option value="autre">Autre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Date d'Échéance</label>
                                    <input type="date" id="date_echeance" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Type de Période</label>
                                    <select id="type_periode" class="form-select">
                                        <option value="">Sélectionnez une période</option>
                                        <option value="Trimestre">Trimestre</option>
                                        <option value="Semestre">Semestre</option>
                                        <option value="Mois">Mois</option>
                                        <option value="Annuel">Annuel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Numéro de Période</label>
                                    <input type="number" id="numero_periode" class="form-control" min="1">
                                    <div class="info-helper">Ex: 1 pour Trimestre 1</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Année Scolaire</label>
                            <input type="text" id="annee_scolaire" class="form-control" placeholder="Ex: 2025-2026">
                        </div>

                        <div class="mb-3">
                            <label>Description</label>
                            <textarea id="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea id="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section Informations Bancaires -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-university"></i> Informations Bancaires (Optionnel)</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Banque</label>
                                    <input type="text" id="banque" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Numéro de Chèque</label>
                                    <input type="text" id="numero_cheque" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Référence Virement</label>
                                    <input type="text" id="reference_virement" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Opérateur Mobile</label>
                                    <input type="text" id="operateur_mobile" class="form-control" 
                                           placeholder="Ex: Orange Money, MTN Mobile Money">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a href="/paiement" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
                    <div>
                        <button type="button" class="btn btn-warning" onclick="reinitialiserFormulaire()">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let paiementId = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer l'ID du paiement depuis l'URL
            const pathArray = window.location.pathname.split('/');
            paiementId = pathArray[pathArray.length - 2];
            
            chargerEleves();
            chargerPaiement(paiementId);
            initialiserCalculs();
            
            // Soumission du formulaire
            document.getElementById('form-edit-paiement').addEventListener('submit', function(e) {
                e.preventDefault();
                soumettreFormulaire();
            });
        });

        function chargerEleves() {
            fetch('/api/eleves')
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById('eleve_id');
                    data.forEach(eleve => {
                        const option = document.createElement('option');
                        option.value = eleve.id;
                        option.textContent = `${eleve.nom} ${eleve.prenom} - ${eleve.matricule}`;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }

        function chargerPaiement(id) {
            fetch(`/api/paiements/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        remplirFormulaire(data.data);
                    } else {
                        afficherErreur('Paiement non trouvé');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    afficherErreur('Erreur lors du chargement du paiement');
                });
        }

        function remplirFormulaire(paiement) {
            // Remplir les champs du formulaire
            document.getElementById('eleve_id').value = paiement.eleve_id;
            document.getElementById('montant_total').value = paiement.montant_total;
            document.getElementById('montant_paye').value = paiement.montant_paye;
            document.getElementById('type_paiement').value = paiement.type_paiement;
            document.getElementById('statut').value = paiement.statut;
            document.getElementById('mode_paiement').value = paiement.mode_paiement || '';
            document.getElementById('date_echeance').value = paiement.date_echeance ? paiement.date_echeance.split('T')[0] : '';
            document.getElementById('type_periode').value = paiement.type_periode || '';
            document.getElementById('numero_periode').value = paiement.numero_periode || '';
            document.getElementById('annee_scolaire').value = paiement.annee_scolaire || '';
            document.getElementById('description').value = paiement.description || '';
            document.getElementById('notes').value = paiement.notes || '';
            document.getElementById('banque').value = paiement.banque || '';
            document.getElementById('numero_cheque').value = paiement.numero_cheque || '';
            document.getElementById('reference_virement').value = paiement.reference_virement || '';
            document.getElementById('operateur_mobile').value = paiement.operateur_mobile || '';
            
            // Mettre à jour les calculs
            calculerMontantRestant();
        }

        function initialiserCalculs() {
            // Écouter les changements sur les montants
            document.getElementById('montant_total').addEventListener('input', calculerMontantRestant);
            document.getElementById('montant_paye').addEventListener('input', calculerMontantRestant);
        }

        function calculerMontantRestant() {
            const montantTotal = parseFloat(document.getElementById('montant_total').value) || 0;
            const montantPaye = parseFloat(document.getElementById('montant_paye').value) || 0;
            
            const montantRestant = montantTotal - montantPaye;
            document.getElementById('montant_restant').value = montantRestant.toFixed(2);
            
            // Calculer le pourcentage
            let pourcentage = 0;
            if (montantTotal > 0) {
                pourcentage = Math.min(100, Math.round((montantPaye / montantTotal) * 100));
            }
            
            document.getElementById('progress-bar').style.width = `${pourcentage}%`;
            document.getElementById('pourcentage-text').textContent = `${pourcentage}%`;
            
            // Changer la couleur de la barre de progression
            const progressBar = document.getElementById('progress-bar');
            if (pourcentage < 50) {
                progressBar.className = 'progress-bar bg-warning';
            } else if (pourcentage < 100) {
                progressBar.className = 'progress-bar bg-info';
            } else {
                progressBar.className = 'progress-bar bg-success';
            }
        }

        function soumettreFormulaire() {
            const formData = {
                montant_total: document.getElementById('montant_total').value,
                montant_paye: document.getElementById('montant_paye').value,
                type_paiement: document.getElementById('type_paiement').value,
                statut: document.getElementById('statut').value,
                mode_paiement: document.getElementById('mode_paiement').value,
                date_echeance: document.getElementById('date_echeance').value,
                type_periode: document.getElementById('type_periode').value,
                numero_periode: document.getElementById('numero_periode').value,
                annee_scolaire: document.getElementById('annee_scolaire').value,
                description: document.getElementById('description').value,
                notes: document.getElementById('notes').value,
                banque: document.getElementById('banque').value,
                numero_cheque: document.getElementById('numero_cheque').value,
                reference_virement: document.getElementById('reference_virement').value,
                operateur_mobile: document.getElementById('operateur_mobile').value
            };

            fetch(`/api/paiements/${paiementId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Paiement modifié avec succès');
                    window.location.href = `/paiements/${paiementId}`;
                } else {
                    afficherErreurs(data.errors);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                afficherErreur('Erreur lors de la modification');
            });
        }

        function reinitialiserFormulaire() {
            if (confirm('Voulez-vous réinitialiser le formulaire ? Toutes les modifications seront perdues.')) {
                chargerPaiement(paiementId);
                document.getElementById('erreurs').classList.add('d-none');
            }
        }

        function afficherErreur(message) {
            const erreursDiv = document.getElementById('erreurs');
            erreursDiv.innerHTML = `<strong>Erreur:</strong> ${message}`;
            erreursDiv.classList.remove('d-none');
        }

        function afficherErreurs(errors) {
            const erreursDiv = document.getElementById('erreurs');
            let html = '<strong>Veuillez corriger les erreurs suivantes:</strong><ul>';
            
            for (const champ in errors) {
                errors[champ].forEach(message => {
                    html += `<li>${message}</li>`;
                });
            }
            
            html += '</ul>';
            erreursDiv.innerHTML = html;
            erreursDiv.classList.remove('d-none');
            
            // Faire défiler jusqu'aux erreurs
            erreursDiv.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>