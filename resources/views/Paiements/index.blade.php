<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Paiements - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
        .sidebar li a:hover {
            color: #ddd;
        }
        .sidebar li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
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
        .badge-statut {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
        }
        .badge-paye { background-color: #d4edda; color: #155724; }
        .badge-en-attente { background-color: #fff3cd; color: #856404; }
        .badge-partiel { background-color: #cce5ff; color: #004085; }
        .badge-annule { background-color: #f8d7da; color: #721c24; }
        .badge-brouillon { background-color: #e2e3e5; color: #383d41; }
        .badge-rembourse { background-color: #d1ecf1; color: #0c5460; }
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin: 10px 0;
        }
        .filter-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn-action {
            padding: 5px 10px;
            margin: 2px;
            font-size: 0.8rem;
        }
        .montant-cell {
            font-weight: bold;
            text-align: right;
        }
        .progress-paiement {
            height: 8px;
            margin-top: 5px;
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
        <li class="active">
    <a href="/" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-chart-pie" style="margin-right: 10px;"></i> Tableau de bord
    </a>
</li>

<li>
    <a href="/eleves" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-user-graduate" style="margin-right: 10px;"></i> Élèves
    </a>
</li>

<li>
    <a href="/notes" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-pen-to-square" style="margin-right: 10px;"></i> Notes
    </a>
</li>

<li>
    <a href="/bulletins" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-file-alt" style="margin-right: 10px;"></i> Bulletins
    </a>
</li>

<li>
    <a href="/enseignants" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-chalkboard-teacher" style="margin-right: 10px;"></i> Enseignants
    </a>
</li>

<li>
    <a href="/parents" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-users" style="margin-right: 10px;"></i> Parents
    </a>
</li>

<li>
    <a href="/evenements" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-calendar-days" style="margin-right: 10px;"></i> Événements
    </a>
</li>

<li>
    <a href="/paiement" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-money-bill-wave" style="margin-right: 10px;"></i> Paiement
    </a>
</li>

<li>
    <a href="/cantine" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-utensils" style="margin-right: 10px;"></i> Cantine
    </a>
</li>

<li>
    <a href="/utilisateurs" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-user-group" style="margin-right: 10px;"></i> Utilisateurs
    </a>
</li>

<li>
    <a href="/chat" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-comments" style="margin-right: 10px;"></i> Chat
    </a>
</li>

<li>
    <a href="/activite" style="color: white; text-decoration: none; display: flex; align-items: center;">
        <i class="fas fa-chart-line" style="margin-right: 10px;"></i> Activité
    </a>
</li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1>Gestion des Paiements</h1>
                <p>Gérez les paiements des frais scolaires</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                    Année 2025-2026
                </span>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <div>Total Collecté</div>
                    <div class="stat-value text-success">381 569 FCFA</div>
                    <div class="text-muted">84.8% du total attendu</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div>Paiements Payés</div>
                    <div class="stat-value text-success" id="stat-payes">0</div>
                    <div class="text-muted">Paiements complétés</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div>En Attente</div>
                    <div class="stat-value text-warning" id="stat-en-attente">0</div>
                    <div class="text-muted">Paiements en attente</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <div>En Retard</div>
                    <div class="stat-value text-danger" id="stat-en-retard">0</div>
                    <div class="text-muted">Paiements échus</div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="filter-card">
            <div class="row">
                <div class="col-md-3">
                    <label>Statut</label>
                    <select id="filter-statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="brouillon">Brouillon</option>
                        <option value="en_attente">En attente</option>
                        <option value="partiel">Partiel</option>
                        <option value="payé">Payé</option>
                        <option value="annulé">Annulé</option>
                        <option value="remboursé">Remboursé</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Type de Paiement</label>
                    <select id="filter-type" class="form-select">
                        <option value="">Tous les types</option>
                        <option value="Scolarité">Scolarité</option>
                        <option value="Cantine">Cantine</option>
                        <option value="Transport">Transport</option>
                        <option value="Fournitures">Fournitures</option>
                        <option value="Activités">Activités</option>
                        <option value="Assurance">Assurance</option>
                        <option value="Autre">Autre</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Année Scolaire</label>
                    <select id="filter-annee" class="form-select">
                        <option value="">Toutes les années</option>
                        <option value="2024-2025">2024-2025</option>
                        <option value="2025-2026">2025-2026</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Recherche</label>
                    <div class="input-group">
                        <input type="text" id="search-input" class="form-control" placeholder="Rechercher...">
                        <button class="btn btn-outline-secondary" type="button" onclick="rechercherPaiements()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12 d-flex justify-content-between">
                    <div>
                        <button class="btn btn-outline-secondary" onclick="reinitialiserFiltres()">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </button>
                    </div>
                    <div>
                        <button class="btn btn-primary" onclick="exporterExcel()">
                            <i class="fas fa-file-excel"></i> Exporter Excel
                        </button>
                        <a href="/paiements/create" class="btn btn-success">
                            <i class="fas fa-plus"></i> Nouveau Paiement
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des paiements -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="paiements-table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Élève</th>
                                <th>N° Reçu</th>
                                <th>Type</th>
                                <th>Montant Total</th>
                                <th>Montant Payé</th>
                                <th>Reste à Payer</th>
                                <th>Statut</th>
                                <th>Date Échéance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="paiements-tbody">
                            <!-- Les données seront chargées via JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Modal pour le paiement partiel -->
    <div class="modal fade" id="modalPaiementPartiel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enregistrer un Paiement Partiel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formPaiementPartiel">
                        <input type="hidden" id="paiement-id">
                        <div class="mb-3">
                            <label>Montant à Payer</label>
                            <input type="number" id="montant-paye" class="form-control" required>
                            <small class="text-muted">Montant restant: <span id="montant-restant">0</span> FCFA</small>
                        </div>
                        <div class="mb-3">
                            <label>Mode de Paiement</label>
                            <select id="mode-paiement" class="form-select" required>
                                <option value="espèces">Espèces</option>
                                <option value="chèque">Chèque</option>
                                <option value="virement">Virement</option>
                                <option value="carte_bancaire">Carte bancaire</option>
                                <option value="mobile_money">Mobile Money</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea id="notes-paiement" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="enregistrerPaiementPartiel()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour confirmation de suppression -->
    <div class="modal fade" id="modalConfirmation" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="message-confirmation"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="btn-confirmer">Confirmer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        let paiementsData = [];
        let table;

        // Charger les paiements au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            chargerPaiements();
            initialiserFiltres();
        });

        function chargerPaiements() {
            fetch('/api/paiements')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        paiementsData = data.data;
                        afficherPaiements(paiementsData);
                        mettreAJourStatistiques(data.statistiques);
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }

        function afficherPaiements(paiements) {
            const tbody = document.getElementById('paiements-tbody');
            tbody.innerHTML = '';

            paiements.forEach((paiement, index) => {
                const row = document.createElement('tr');
                
                // Déterminer la classe du badge selon le statut
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

                // Calculer le pourcentage
                const pourcentage = paiement.montant_total > 0 
                    ? Math.round((paiement.montant_paye / paiement.montant_total) * 100) 
                    : 0;

                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>
                        <strong>${paiement.eleve?.nom || ''} ${paiement.eleve?.prenom || ''}</strong><br>
                        <small class="text-muted">${paiement.eleve?.matricule || ''}</small>
                    </td>
                    <td>${paiement.numero_recu || 'N/A'}</td>
                    <td>${paiement.type_paiement}</td>
                    <td class="montant-cell">${formatMontant(paiement.montant_total)} FCFA</td>
                    <td class="montant-cell">${formatMontant(paiement.montant_paye)} FCFA</td>
                    <td class="montant-cell">
                        ${formatMontant(paiement.montant_restant)} FCFA
                        <div class="progress progress-paiement">
                            <div class="progress-bar bg-success" style="width: ${pourcentage}%"></div>
                        </div>
                        <small>${pourcentage}%</small>
                    </td>
                    <td>
                        <span class="badge-statut ${badgeClass}">${badgeText}</span>
                        ${paiement.est_en_retard ? '<br><small class="text-danger">En retard</small>' : ''}
                    </td>
                    <td>${formatDate(paiement.date_echeance)}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info btn-action" onclick="voirPaiement(${paiement.id})" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                            ${paiement.peut_etre_modifie ? `
                            <button class="btn btn-sm btn-warning btn-action" onclick="editerPaiement(${paiement.id})" title="Éditer">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-primary btn-action" onclick="payerPartiel(${paiement.id}, ${paiement.montant_restant})" 
                                    ${paiement.statut === 'payé' ? 'disabled' : ''} title="Payer partiel">
                                <i class="fas fa-money-bill"></i>
                            </button>
                            ` : ''}
                            ${paiement.peut_etre_supprime ? `
                            <button class="btn btn-sm btn-danger btn-action" onclick="supprimerPaiement(${paiement.id})" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                            ` : ''}
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Initialiser DataTables si ce n'est pas déjà fait
            if (!table) {
                table = $('#paiements-table').DataTable({
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
                    },
                    pageLength: 25,
                    order: [[0, 'desc']]
                });
            }
        }

        function mettreAJourStatistiques(stats) {
            document.getElementById('stat-payes').textContent = stats.payes;
            document.getElementById('stat-en-attente').textContent = stats.en_attente;
            document.getElementById('stat-en-retard').textContent = stats.en_retard;
        }

        function initialiserFiltres() {
            // Écouter les changements sur les filtres
            document.getElementById('filter-statut').addEventListener('change', filtrerPaiements);
            document.getElementById('filter-type').addEventListener('change', filtrerPaiements);
            document.getElementById('filter-annee').addEventListener('change', filtrerPaiements);
            document.getElementById('search-input').addEventListener('keyup', filtrerPaiements);
        }

        function filtrerPaiements() {
            const statut = document.getElementById('filter-statut').value;
            const type = document.getElementById('filter-type').value;
            const annee = document.getElementById('filter-annee').value;
            const search = document.getElementById('search-input').value.toLowerCase();

            let filtres = [];
            if (statut) filtres.push(p => p.statut === statut);
            if (type) filtres.push(p => p.type_paiement === type);
            if (annee) filtres.push(p => p.annee_scolaire === annee);
            if (search) {
                filtres.push(p => 
                    (p.numero_recu && p.numero_recu.toLowerCase().includes(search)) ||
                    (p.eleve?.nom && p.eleve.nom.toLowerCase().includes(search)) ||
                    (p.eleve?.prenom && p.eleve.prenom.toLowerCase().includes(search)) ||
                    (p.eleve?.matricule && p.eleve.matricule.toLowerCase().includes(search))
                );
            }

            let paiementsFiltres = paiementsData;
            filtres.forEach(filtre => {
                paiementsFiltres = paiementsFiltres.filter(filtre);
            });

            afficherPaiements(paiementsFiltres);
        }

        function reinitialiserFiltres() {
            document.getElementById('filter-statut').value = '';
            document.getElementById('filter-type').value = '';
            document.getElementById('filter-annee').value = '';
            document.getElementById('search-input').value = '';
            afficherPaiements(paiementsData);
        }

        function rechercherPaiements() {
            // La recherche se fait déjà avec le filtre keyup
        }

        function exporterExcel() {
            // Implémenter l'export Excel
            alert('Fonctionnalité d\'export Excel à implémenter');
        }

        function voirPaiement(id) {
            window.location.href = `/paiements/${id}`;
        }

        function editerPaiement(id) {
            window.location.href = `/paiements/${id}/edit`;
        }

        function payerPartiel(id, montantRestant) {
            document.getElementById('paiement-id').value = id;
            document.getElementById('montant-restant').textContent = formatMontant(montantRestant);
            document.getElementById('montant-paye').value = '';
            document.getElementById('montant-paye').max = montantRestant;
            
            const modal = new bootstrap.Modal(document.getElementById('modalPaiementPartiel'));
            modal.show();
        }

        function enregistrerPaiementPartiel() {
            const id = document.getElementById('paiement-id').value;
            const montantPaye = parseFloat(document.getElementById('montant-paye').value);
            const modePaiement = document.getElementById('mode-paiement').value;
            const notes = document.getElementById('notes-paiement').value;

            fetch(`/api/paiements/${id}/payer-partiel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    montant_paye: montantPaye,
                    mode_paiement: modePaiement,
                    notes: notes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Paiement partiel enregistré avec succès');
                    chargerPaiements();
                    bootstrap.Modal.getInstance(document.getElementById('modalPaiementPartiel')).hide();
                } else {
                    alert('Erreur: ' + data.message);
                }
            })
            .catch(error => console.error('Erreur:', error));
        }

        function supprimerPaiement(id) {
            document.getElementById('message-confirmation').textContent = 
                'Êtes-vous sûr de vouloir supprimer ce paiement ? Cette action est irréversible.';
            
            document.getElementById('btn-confirmer').onclick = function() {
                fetch(`/api/paiements/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Paiement supprimé avec succès');
                        chargerPaiements();
                        bootstrap.Modal.getInstance(document.getElementById('modalConfirmation')).hide();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => console.error('Erreur:', error));
            };

            const modal = new bootstrap.Modal(document.getElementById('modalConfirmation'));
            modal.show();
        }

        // Fonctions utilitaires
        function formatMontant(montant) {
            return parseFloat(montant).toLocaleString('fr-FR');
        }

        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR');
        }
    </script>
</body>
</html>