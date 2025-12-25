<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ScolarNextClas - Génération de Bulletins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #170B9DFF;
            --primary-dark: #0f076d;
            --secondary-color: #7d6ae8;
            --light-bg: #f5f5f5;
            --success-color: #28a745;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--primary-color);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            color: white;
            font-family: Arial, sans-serif;
            display: block;
            visibility: visible;
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
            transition: background-color 0.3s;
        }
        .sidebar li:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar li.active {
            background-color: var(--secondary-color);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar i {
            margin-right: 10px;
            width: 20px;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: var(--light-bg);
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
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .bulletin-generator {
            margin-top: 30px;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .bulletin-preview {
            margin-top: 30px;
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .bulletin-header {
            text-align: center;
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .bulletin-title {
            color: var(--primary-color);
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .student-info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .info-box {
            flex: 1;
            min-width: 300px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid var(--primary-color);
        }
        .info-box h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 16px;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-custom th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: 600;
        }
        .table-custom td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .table-custom tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .table-custom tr:hover {
            background-color: #f0f5ff;
        }
        .average-box {
            text-align: center;
            background: #e8f4ff;
            border: 2px solid var(--primary-color);
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .average-value {
            font-size: 36px;
            font-weight: bold;
            color: var(--primary-color);
        }
        .btn-generate {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .btn-generate:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        .btn-generate i {
            margin-right: 8px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(23, 11, 157, 0.1);
        }
        .generator-form {
            display: flex;
            gap: 20px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        .form-column {
            flex: 1;
            min-width: 250px;
        }
        
        /* Styles pour les boutons d'action */
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-print {
            background-color: #28a745;
            color: white;
        }
        
        .btn-print:hover {
            background-color: #218838;
        }
        
        .btn-download {
            background-color: #17a2b8;
            color: white;
        }
        
        .btn-download:hover {
            background-color: #138496;
        }
        
        .btn-email {
            background-color: #ffc107;
            color: #212529;
        }
        
        .btn-email:hover {
            background-color: #e0a800;
        }
        
        /* Styles pour les messages d'information */
        .info-message {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #bee5eb;
            display: flex;
            align-items: center;
        }
        
        .info-message i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        /* Styles pour les boutons de matière */
        .subject-actions {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        
        .btn-edit, .btn-delete {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 5px;
            border-radius: 3px;
            transition: all 0.3s;
        }
        
        .btn-edit {
            color: var(--primary-color);
        }
        
        .btn-edit:hover {
            background-color: rgba(23, 11, 157, 0.1);
        }
        
        .btn-delete {
            color: #dc3545;
        }
        
        .btn-delete:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                padding: 20px 0;
            }
            .sidebar .logo h3,
            .sidebar li a span:not(.fas, .fab, .far) {
                display: none;
            }
            .sidebar .logo {
                justify-content: center;
                padding: 0 10px;
            }
            .sidebar .logo span {
                margin-right: 0;
            }
            .sidebar li {
                padding: 15px 0;
                text-align: center;
            }
            .sidebar i {
                margin-right: 0;
                font-size: 20px;
            }
            .content {
                margin-left: 70px;
            }
        }
        
        @media (max-width: 768px) {
            .student-info-section {
                flex-direction: column;
            }
            .info-box {
                min-width: 100%;
            }
            .generator-form {
                flex-direction: column;
                align-items: stretch;
            }
            .form-column {
                min-width: 100%;
            }
            .action-buttons {
                flex-direction: column;
            }
            .action-btn {
                width: 100%;
            }
        }
        
        /* Style pour les formulaires HTML */
        .form-section {
            background-color: #f8f9ff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            border: 2px dashed var(--primary-color);
        }
        
        .form-title {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.4rem;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 15px;
            margin-bottom: 20px;
        }
        
        .notes-title {
            grid-column: 1 / -1;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            text-align: left;
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .form-grid, .notes-grid {
                grid-template-columns: 1fr;
            }
            .form-actions {
                flex-direction: column;
            }
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
                <a href="/">
                    <i class="fas fa-chart-pie"></i> <span>Tableau de bord</span>
                </a>
            </li>
            <li>
                <a href="/eleves">
                    <i class="fas fa-user-graduate"></i> <span>Élèves</span>
                </a>
            </li>
            <li>
                <a href="/notes">
                    <i class="fas fa-pen-to-square"></i> <span>Notes</span>
                </a>
            </li>
            <li>
                <a href="/bulletins">
                    <i class="fas fa-file-alt"></i> <span>Bulletins</span>
                </a>
            </li>
            <li>
                <a href="/enseignants">
                    <i class="fas fa-chalkboard-teacher"></i> <span>Enseignants</span>
                </a>
            </li>
            <li>
                <a href="/parents">
                    <i class="fas fa-users"></i> <span>Parents</span>
                </a>
            </li>
            <li>
                <a href="/evenements">
                    <i class="fas fa-calendar-days"></i> <span>Événements</span>
                </a>
            </li>
            <li>
                <a href="/paiement">
                    <i class="fas fa-money-bill-wave"></i> <span>Paiement</span>
                </a>
            </li>
            <li>
                <a href="/cantine">
                    <i class="fas fa-utensils"></i> <span>Cantine</span>
                </a>
            </li>
            <li>
                <a href="/utilisateurs">
                    <i class="fas fa-user-group"></i> <span>Utilisateurs</span>
                </a>
            </li>
            <li>
                <a href="/chat">
                    <i class="fas fa-comments"></i> <span>Chat</span>
                </a>
            </li>
            <li>
                <a href="/activite">
                    <i class="fas fa-chart-line"></i> <span>Activité</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1>Génération de Bulletins</h1>
                <p>Plateforme de Gestion Scolaire Numérique</p>
            </div>
            <div style="display: flex; gap: 15px; align-items: center;">
                <span style="padding: 8px 15px; border: 1px solid #ddd; background: #f0f0f0; border-radius: 4px; font-size: 0.9rem;">
                    Année 2025-2026
                </span>
               
            </div>
        </div>

        <!-- Message d'information -->
        <div class="info-message">
            <i class="fas fa-info-circle"></i>
            <span>Cette page permet de générer et visualiser les bulletins scolaires. Sélectionnez un élève et un trimestre pour continuer.</span>
        </div>

        <!-- Génération de Bulletin -->
        <div class="bulletin-generator">
            <h2 style="color: #170B9DFF; margin-bottom: 20px;">
                <i class="fa-solid fa-file-pdf" style="margin-right:10px; color:#dc3545;"></i>
                Génération de Bulletin
            </h2>
            <p style="color: #666; margin-bottom: 30px;">
                Sélectionnez un élève et un trimestre pour générer le bulletin PDF
            </p>
            
            <!-- Formulaire de sélection -->
            <form action="/generate-bulletin" method="GET" class="generator-form">
                <div class="form-column">
                    <div class="form-group">
                        <label for="student">Élève</label>
                        <select id="student" name="student" class="form-control" required>
                            <option value="">Sélectionner un élève</option>
                            <option value="SNC2024001" selected>Amina Diallo (SNC2024001)</option>
                            <option value="SNC2024002">Ray Kokoroko (SNC2024002)</option>
                            <option value="SNC2024003">Arnaud Klanlenou (SNC2024003)</option>
                            <option value="SNC2025001">Amina Kokodoro (SNC2025001)</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-column">
                    <div class="form-group">
                        <label for="trimestre">Trimestre</label>
                        <select id="trimestre" name="trimestre" class="form-control" required>
                            <option value="">Sélectionner un trimestre</option>
                            <option value="s1">Semestre 1</option>
                            <option value="s2">Semestre 2</option>
                            <option value="t1">Trimestre 1</option>
                            <option value="t2" selected>Trimestre 2</option>
                            <option value="t3">Trimestre 3</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-column">
                    <button type="submit" class="btn-generate">
                        <i class="fas fa-file-pdf"></i>
                        Générer le Bulletin PDF
                    </button>
                </div>
            </form>
            
            <!-- Options supplémentaires -->
            <div class="action-buttons">
                <a href="mailto:parent@example.com?subject=Bulletin scolaire&body=Bonjour,%0D%0A%0D%0AVeuillez trouver ci-joint le bulletin scolaire de votre enfant." class="action-btn btn-email">
                    <i class="fas fa-envelope"></i> Envoyer par email
                </a>
                <a href="#" class="action-btn btn-download">
                    <i class="fas fa-download"></i> Télécharger PDF
                </a>
                <a href="#" class="action-btn btn-print" onclick="window.print();return false;">
                    <i class="fas fa-print"></i> Imprimer
                </a>
            </div>
        </div>

        <!-- Prévisualisation du Bulletin -->
        <div class="bulletin-preview">
            <div class="bulletin-header">
                <div class="bulletin-title">BULLETIN SCOLAIRE</div>
                <div style="color: #666; font-size: 16px; margin-bottom: 5px;">
                    Trimestre 2 - Année Académique 2025-2026
                </div>
                <div style="color: #170B9DFF; font-weight: bold; font-size: 14px;">
                    ScolarNextClas - Plateforme de Gestion Scolaire Numérique
                </div>
            </div>

            <!-- Informations Élève -->
            <div class="student-info-section">
                <div class="info-box">
                    <h4>Informations Élève</h4>
                    <p><strong>Matricule:</strong> SNC2024001</p>
                    <p><strong>Nom:</strong> Diallo</p>
                    <p><strong>Prénom:</strong> Amina</p>
                    <p><strong>Classe:</strong> 6ème A</p>
                    <p><strong>Date de naissance:</strong> 15/03/2014</p>
                </div>
                
                <div class="info-box">
                    <h4>Contact Parent</h4>
                    <p><strong>Nom:</strong> Mohamed Diallo</p>
                    <p><strong>Téléphone:</strong> +228 90 11 22 33</p>
                    <p><strong>Email:</strong> parent.diallo@example.com</p>
                    <p><strong>Adresse:</strong> Lomé, Adakpamé</p>
                </div>
                
                <div class="info-box">
                    <h4>Informations Scolaires</h4>
                    <p><strong>Effectif de la classe:</strong> 35 élèves</p>
                    <p><strong>Rang de l'élève:</strong> 12ème/35</p>
                    <p><strong>Absences justifiées:</strong> 2 jours</p>
                    <p><strong>Absences non justifiées:</strong> 0 jour</p>
                </div>
            </div>

            <!-- Résultats par Matière -->
            <h3 style="color: #170B9DFF; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;">
                <i class="fas fa-book"></i> Résultats par Matière
            </h3>
            
            <!-- Boutons d'action pour les matières -->
            <div style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">
                <a href="#add-subject-form" class="action-btn btn-print">
                    <i class="fas fa-plus-circle"></i> Ajouter une matière
                </a>
                <a href="/bulletins?student=SNC2024001&trimestre=t2&action=recalculate" class="action-btn btn-download">
                    <i class="fas fa-calculator"></i> Recalculer les moyennes
                </a>
            </div>
            
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th rowspan="2">Matière</th>
                            <th rowspan="2">Code</th>
                            <th rowspan="2">Coef</th>
                            <th colspan="4">Interrogations</th>
                            <th rowspan="2">Devoir</th>
                            <th rowspan="2">Composition</th>
                            <th rowspan="2">Moyenne /20</th>
                            <th rowspan="2">Note x Coef</th>
                            <th rowspan="2">Appréciation</th>
                            <th rowspan="2">Actions</th>
                        </tr>
                        <tr>
                            <th>Int 1</th>
                            <th>Int 2</th>
                            <th>Int 3</th>
                            <th>Int 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Matières existantes -->
                        <tr>
                            <td>Mathématiques</td>
                            <td>MATH</td>
                            <td>4</td>
                            <td>10</td>
                            <td>12</td>
                            <td>11</td>
                            <td>13</td>
                            <td>12</td>
                            <td>10</td>
                            <td>11.50</td>
                            <td>46.00</td>
                            <td>Passable</td>
                            <td class="subject-actions">
                                <a href="/matieres/edit/1" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/matieres/delete/1" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Français</td>
                            <td>FR</td>
                            <td>3</td>
                            <td>9</td>
                            <td>10</td>
                            <td>11</td>
                            <td>10</td>
                            <td>11</td>
                            <td>10</td>
                            <td>10.20</td>
                            <td>30.60</td>
                            <td>Passable</td>
                            <td class="subject-actions">
                                <a href="/matieres/edit/2" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/matieres/delete/2" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Anglais</td>
                            <td>ANG</td>
                            <td>2</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                            <td>12</td>
                            <td>13</td>
                            <td>12</td>
                            <td>12.80</td>
                            <td>25.60</td>
                            <td>Assez Bien</td>
                            <td class="subject-actions">
                                <a href="/matieres/edit/3" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/matieres/delete/3" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Histoire-Géo</td>
                            <td>HG</td>
                            <td>2</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>Non noté</td>
                            <td class="subject-actions">
                                <a href="/matieres/edit/4" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/matieres/delete/4" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>Sciences Physiques</td>
                            <td>PHYS</td>
                            <td>3</td>
                            <td>14</td>
                            <td>15</td>
                            <td>13</td>
                            <td>12</td>
                            <td>14</td>
                            <td>13</td>
                            <td>13.60</td>
                            <td>40.80</td>
                            <td>Bien</td>
                            <td class="subject-actions">
                                <a href="/matieres/edit/5" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/matieres/delete/5" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette matière ?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="font-weight: bold; background-color: #f0f8ff !important;">
                            <td colspan="9" style="text-align: right;"><strong>MOYENNE GÉNÉRALE</strong></td>
                            <td>11.78</td>
                            <td>164.60</td>
                            <td colspan="2">Assez Bien</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Formulaire d'ajout de matière -->
            <div class="form-section" id="add-subject-form">
                <h3 class="form-title"><i class="fas fa-book-medical"></i> Ajouter une nouvelle matière</h3>
                
                <form action="/matieres/add" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="subject">Nom de la matière *</label>
                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Ex: Sciences Physiques" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="code">Code de la matière *</label>
                            <input type="text" id="code" name="code" class="form-control" placeholder="Ex: PHYS" maxlength="5" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="coef">Coefficient *</label>
                            <input type="number" id="coef" name="coef" class="form-control" min="1" max="10" value="2" required>
                        </div>
                    </div>
                    
                    <div class="notes-grid">
                        <div class="notes-title">Notes /20 (optionnel)</div>
                        
                        <div class="form-group">
                            <label for="int1">Interro 1</label>
                            <input type="number" id="int1" name="int1" class="form-control" min="0" max="20" step="0.5" placeholder="0-20">
                        </div>
                        
                        <div class="form-group">
                            <label for="int2">Interro 2</label>
                            <input type="number" id="int2" name="int2" class="form-control" min="0" max="20" step="0.5" placeholder="0-20">
                        </div>
                        
                        <div class="form-group">
                            <label for="int3">Interro 3</label>
                            <input type="number" id="int3" name="int3" class="form-control" min="0" max="20" step="0.5" placeholder="0-20">
                        </div>
                        
                        <div class="form-group">
                            <label for="int4">Interro 4</label>
                            <input type="number" id="int4" name="int4" class="form-control" min="0" max="20" step="0.5" placeholder="0-20">
                        </div>
                        
                        <div class="form-group">
                            <label for="devoir">Devoir</label>
                            <input type="number" id="devoir" name="devoir" class="form-control" min="0" max="20" step="0.5" placeholder="0-20">
                        </div>
                        
                        <div class="form-group">
                            <label for="composition">Composition</label>
                            <input type="number" id="composition" name="composition" class="form-control" min="0" max="20" step="0.5" placeholder="0-20">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="reset" class="action-btn btn-email">
                            <i class="fas fa-eraser"></i> Effacer le formulaire
                        </button>
                        <button type="submit" class="action-btn btn-print">
                            <i class="fas fa-check-circle"></i> Ajouter la matière
                        </button>
                    </div>
                </form>
            </div>

            <!-- Moyenne Générale -->
            <div class="average-box">
                <div style="color: #666; font-size: 14px; margin-bottom: 5px;">
                    MOYENNE GÉNÉRALE DU TRIMESTRE
                </div>
                <div class="average-value">11.78 / 20</div>
                <div style="color: #666; font-size: 14px; margin-top: 10px;">
                    Appréciation: <strong>Assez Bien</strong> | Rang: <strong>12ème/35</strong>
                </div>
            </div>

            <!-- Commentaires -->
            <div style="margin-top: 30px; padding: 20px; background-color: #f8f9ff; border-radius: 8px;">
                <h4 style="color: #170B9DFF; margin-bottom: 15px;">
                    <i class="fas fa-comment"></i> Commentaires et Appréciations
                </h4>
                <div style="display: flex; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 300px;">
                        <h5>Appréciation du Professeur Principal</h5>
                        <p style="color: #555; font-style: italic;">
                            Amina fait preuve d'une bonne assiduité et d'un travail régulier. Elle pourrait progresser en mathématiques en étant plus méthodique dans la résolution des problèmes. Continue tes efforts !
                        </p>
                    </div>
                    <div style="flex: 1; min-width: 300px;">
                        <h5>Conseils pour la progression</h5>
                        <ul style="color: #555;">
                            <li>Renforcer les exercices en mathématiques</li>
                            <li>Participer davantage à l'oral en français</li>
                            <li>Continuer l'excellent travail en anglais</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Signature -->
            <div style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd; flex-wrap: wrap;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="margin-bottom: 10px; font-weight: bold;">Le Responsable de la Classe</div>
                    <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px; height: 40px;">
                        Signature
                    </div>
                </div>
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="margin-bottom: 10px; font-weight: bold;">Le Directeur de l'Établissement</div>
                    <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px; height: 40px;">
                        Signature
                    </div>
                </div>
                <div style="text-align: center; margin-bottom: 20px;">
                    <div style="margin-bottom: 10px; font-weight: bold;">Date d'édition</div>
                    <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px;">
                        15 Décembre 2025
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>