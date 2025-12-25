<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouveau Paiement - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <style>
        /* Garder tous les styles précédents */
        .sidebar { width: 250px; background-color: #170B9DFF; height: 100vh; position: fixed; top: 0; left: 0; padding: 20px 0; color: white; font-family: Arial, sans-serif; }
        .sidebar .logo { display: flex; align-items: center; margin-bottom: 30px; padding: 0 20px; }
        .sidebar .logo span { background: #ff6b6b; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 10px; font-weight: bold; color: white; }
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar li { padding: 15px 20px; }
        .sidebar li.active { background-color: #7d6ae8; }
        .sidebar li a { color: white; text-decoration: none; display: flex; align-items: center; }
        .sidebar li a:hover { color: #ddd; }
        .sidebar li a i { margin-right: 10px; width: 20px; text-align: center; }
        .content { margin-left: 250px; padding: 20px; background-color: #f5f5f5; min-height: 100vh; }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 30px; background: white; border-bottom: 1px solid #ddd; font-family: Arial, sans-serif; margin: -20px -20px 20px -20px; }
        .form-container { background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .section-title { border-bottom: 2px solid #170B9DFF; padding-bottom: 10px; margin-bottom: 25px; color: #170B9DFF; }
        .montant-display { font-size: 1.2rem; font-weight: bold; color: #28a745; background: #f8f9fa; padding: 10px; border-radius: 5px; text-align: center; }
        .info-box { background: #e7f3ff; border-left: 4px solid #170B9DFF; padding: 15px; margin-bottom: 20px; border-radius: 0 5px 5px 0; }
        .required:after { content: " *"; color: #dc3545; }
        .preview-card { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-top: 20px; }
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
                    <i class="fas fa-chart-pie" style="margin-right: 10px;"></i> Tableau de bord
                </a>
            </li>
            <li>
                <a href="/eleves">
                    <i class="fas fa-user-graduate" style="margin-right: 10px;"></i> Élèves
                </a>
            </li>
            <li>
                <a href="/paiement">
                    <i class="fas fa-money-bill-wave" style="margin-right: 10px;"></i> Paiement
                </a>
            </li>
            <li class="active">
                <a href="/paiements/create">
                    <i class="fas fa-plus-circle" style="margin-right: 10px;"></i> Nouveau Paiement
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1>Créer un Nouveau Paiement</h1>
                <p>Enregistrer un nouveau paiement scolaire</p>
            </div>
            <div>
                <a href="/paiement" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>

        <!-- Informations -->
        <div class="info-box">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-3" style="color: #170B9DFF; font-size: 1.2rem;"></i>
                <div>
                    <strong>Instructions :</strong> Remplissez tous les champs obligatoires (*). 
                    Le numéro de reçu sera généré automatiquement après enregistrement.
                </div>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="form-container">
            <form id="form-paiement" action="/api/paiements" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Section 1 : Informations de base -->
                    <div class="col-md-12">
                        <h4 class="section-title">
                            <i class="fas fa-info-circle me-2"></i>Informations Générales
                        </h4>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Élève</label>
                        <select id="eleve_id" name="eleve_id" class="form-select select2" required>
                            <option value="">Chargement des élèves...</option>
                        </select>
                        <div class="form-text" id="eleve-info"></div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Année Scolaire</label>
                        <select id="annee_scolaire" name="annee_scolaire" class="form-select" required>
                            <option value="">Sélectionner une année</option>
                            <option value="2024-2025" selected>2024-2025</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Type de Paiement</label>
                        <select id="type_paiement" name="type_paiement" class="form-select" required>
                            <option value="">Sélectionner un type</option>
                            <option value="Scolarité">Scolarité</option>
                            <option value="Cantine">Cantine</option>
                            <option value="Transport">Transport</option>
                            <option value="Fournitures">Fournitures</option>
                            <option value="Activités">Activités</option>
                            <option value="Assurance">Assurance</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Date d'Échéance</label>
                        <input type="date" id="date_echeance" name="date_echeance" class="form-control" required>
                    </div>

                    <!-- Section 2 : Montants -->
                    <div class="col-md-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-money-bill-wave me-2"></i>Montants
                        </h4>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label required">Montant Total</label>
                        <div class="input-group">
                            <input type="number" id="montant_total" name="montant_total" 
                                   class="form-control" step="0.01" min="0" required>
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Montant Payé</label>
                        <div class="input-group">
                            <input type="number" id="montant_paye" name="montant_paye" 
                                   class="form-control" step="0.01" min="0" value="0">
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Montant Restant</label>
                        <div class="montant-display" id="montant-restant-display">
                            0 FCFA
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label required">Statut</label>
                        <select id="statut" name="statut" class="form-select" required>
                            <option value="brouillon">Brouillon</option>
                            <option value="en_attente">En attente</option>
                            <option value="partiel">Partiel</option>
                            <option value="payé">Payé</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mode de Paiement</label>
                        <select id="mode_paiement" name="mode_paiement" class="form-select">
                            <option value="">Sélectionner un mode</option>
                            <option value="espèces">Espèces</option>
                            <option value="chèque">Chèque</option>
                            <option value="virement">Virement</option>
                            <option value="carte_bancaire">Carte bancaire</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>

                    <!-- Section 3 : Détails supplémentaires -->
                    <div class="col-md-12 mt-4">
                        <h4 class="section-title">
                            <i class="fas fa-file-alt me-2"></i>Détails Supplémentaires
                        </h4>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" 
                                  placeholder="Détails supplémentaires sur ce paiement..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date de Paiement</label>
                        <input type="datetime-local" id="date_paiement" name="date_paiement" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Référence</label>
                        <input type="text" id="reference" name="reference" class="form-control" 
                               placeholder="Référence bancaire ou autre...">
                    </div>

                    <!-- Boutons de soumission -->
                    <div class="col-md-12 mt-4">
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="enregistrerBrouillon()">
                                    <i class="fas fa-save"></i> Enregistrer en brouillon
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Créer le paiement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialiser la date d'échéance
            const today = new Date();
            const nextMonth = new Date(today);
            nextMonth.setDate(today.getDate() + 30);
            document.getElementById('date_echeance').value = nextMonth.toISOString().split('T')[0];
            
            // Charger les élèves via API
            chargerEleves();
            
            // Événements pour les montants
            $('#montant_total, #montant_paye').on('input', calculerMontantRestant);
            $('#statut').on('change', mettreAJourApercu);
            $('#eleve_id, #type_paiement, #annee_scolaire').on('change', mettreAJourApercu);
            
            // Soumission du formulaire
            $('#form-paiement').submit(function(e) {
                e.preventDefault();
                soumettreFormulaire();
            });
        });

        function chargerEleves() {
            // Données simulées pour le test
            const elevesSimules = [
                { id: 1, nom: 'Diallo', prenom: 'Amina', matricule: 'SNC2024001' },
                { id: 2, nom: 'Kokoroko', prenom: 'Ray', matricule: 'SNC2024002' },
                { id: 3, nom: 'Klanlenou', prenom: 'Arnaud', matricule: 'SNC2024003' },
                { id: 4, nom: 'Kokodoro', prenom: 'Amina', matricule: 'SNC2025001' },
                { id: 5, nom: 'Klanlenou', prenom: 'Brice', matricule: 'SNC2025002' }
            ];
            
            const select = $('#eleve_id');
            select.empty();
            select.append('<option value="">Sélectionner un élève</option>');
            
            elevesSimules.forEach(eleve => {
                select.append(new Option(
                    `${eleve.nom} ${eleve.prenom} - ${eleve.matricule}`,
                    eleve.id,
                    false,
                    false
                ));
            });
            
            // Initialiser Select2
            $('.select2').select2({
                placeholder: "Sélectionner un élève",
                allowClear: true
            });
            
            // Alternative: Charger depuis une API
            /*
            fetch('/api/eleves')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const select = $('#eleve_id');
                        select.empty();
                        select.append('<option value="">Sélectionner un élève</option>');
                        
                        data.data.forEach(eleve => {
                            select.append(new Option(
                                `${eleve.nom} ${eleve.prenom} - ${eleve.matricule}`,
                                eleve.id,
                                false,
                                false
                            ));
                        });
                        
                        $('.select2').select2({
                            placeholder: "Sélectionner un élève",
                            allowClear: true
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    // Utiliser les données simulées en cas d'erreur
                });
            */
        }

        function calculerMontantRestant() {
            const total = parseFloat($('#montant_total').val()) || 0;
            const paye = parseFloat($('#montant_paye').val()) || 0;
            const restant = total - paye;
            
            $('#montant-restant-display').text(restant.toLocaleString('fr-FR') + ' FCFA');
            
            // Mettre à jour le statut automatiquement
            if (paye === 0) {
                $('#statut').val('en_attente');
            } else if (paye === total) {
                $('#statut').val('payé');
            } else if (paye > 0 && paye < total) {
                $('#statut').val('partiel');
            }
        }

        function mettreAJourApercu() {
            // Cette fonction peut être implémentée si nécessaire
        }

        function enregistrerBrouillon() {
            $('#statut').val('brouillon');
            soumettreFormulaire();
        }

        function soumettreFormulaire() {
            const formData = new FormData(document.getElementById('form-paiement'));
            
            // Afficher le loading
            const submitBtn = $('#form-paiement button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Création en cours...');
            submitBtn.prop('disabled', true);
            
            // Simuler une réponse pour le test
            setTimeout(() => {
                alert('Paiement créé avec succès! (simulation)');
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
                window.location.href = '/paiement';
            }, 1500);
            
            /*
            // Version avec API réelle
            fetch('/api/paiements', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Paiement créé avec succès! Numéro: ' + data.numero_recu);
                    window.location.href = '/paiement';
                } else {
                    alert('Erreur: ' + data.message);
                    submitBtn.html(originalText);
                    submitBtn.prop('disabled', false);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue');
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            });
            */
        }
    </script>
</body>
</html>