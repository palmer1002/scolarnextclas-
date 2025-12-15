<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ScolarNextClas - Génération de Bulletins</title>
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
            display: block;
            visibility: visible;
            opacity: 1;
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
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
            border-bottom: 3px solid #170B9DFF;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .bulletin-title {
            color: #170B9DFF;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .student-info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-box {
            flex: 1;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            margin: 0 10px;
        }
        .info-box:first-child {
            margin-left: 0;
        }
        .info-box:last-child {
            margin-right: 0;
        }
        .info-box h4 {
            color: #170B9DFF;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-custom th {
            background-color: #170B9DFF;
            color: white;
            padding: 12px;
            text-align: left;
        }
        .table-custom td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .table-custom tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .average-box {
            text-align: center;
            background: #e8f4ff;
            border: 2px solid #170B9DFF;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .average-value {
            font-size: 36px;
            font-weight: bold;
            color: #170B9DFF;
        }
        .btn-generate {
            background-color: #170B9DFF;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-generate:hover {
            background-color: #0f076d;
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
        }
        .generator-form {
            display: flex;
            gap: 20px;
            align-items: flex-end;
        }
        .form-column {
            flex: 1;
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
                <h1>Génération de Bulletins</h1>
                <p>Plateforme de Gestion Scolaire Numérique</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                    Année 2025-2026
                </span>
            </div>
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
            
            <div class="generator-form">
                <div class="form-column">
                    <div class="form-group">
                        <label for="student">Élève</label>
                        <select id="student" class="form-control">
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
                        <select id="trimestre" class="form-control">
                            <option value="">Sélectionner un trimestre</option>
                            <option value="2" selected>Semestre 1</option>
                            <option value="2">Semestre 2</option>
                            <option value="1">Trimestre 1</option>
                            <option value="2">Trimestre 2</option>
                            <option value="3">Trimestre 3</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-column">
                    <button class="btn-generate" onclick="generateBulletin()">
                        <i class="fas fa-print" style="margin-right: 8px;"></i>
                        Imprimer le Bulletin
                    </button>
                </div>
            </div>
        </div>

        <!-- Prévisualisation du Bulletin -->
        <div class="bulletin-preview">
            <div class="bulletin-header">
                <div class="bulletin-title">BULLETIN SCOLAIRE</div>
                <div style="color: #666; font-size: 16px; margin-bottom: 5px;">
                    Trimestre 1 - Année Académique 2025-2026
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
                </div>
                
                <div class="info-box">
                    <h4>Contact Parent</h4>
                    <p><strong>Nom:</strong> Mohamed Diallo</p>
                    <p><strong>Téléphone:</strong> +228 90 11 22 33</p>
                    <p><strong>Adresse:</strong> Lomé, Adakpamé</p>
                </div>
            </div>

            <!-- Résultats par Matière -->
            

    <style>
       
        .container {
            max-width: 1300px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }
        
        h3 {
            color: #170B9DFF;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            font-size: 1.8rem;
        }
        
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: #170B9DFF;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0f0770;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(23, 11, 157, 0.2);
        }
        
        .btn-secondary {
            background-color: #f0f0f0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background-color: #e0e0e0;
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .table-custom th, .table-custom td {
            border: 1px solid #e0e0e0;
            padding: 12px 8px;
            text-align: center;
        }
        
        .table-custom th {
            background-color: #170B9DFF;
            color: white;
            font-weight: 600;
        }
        
        .table-custom tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .table-custom tbody tr:hover {
            background-color: #f0f5ff;
        }
        
        .form-section {
            background-color: #f8f9ff;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
            border: 2px dashed #170B9DFF;
        }
        
        .form-title {
            color: #170B9DFF;
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
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
        }
        
        .form-input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #170B9DFF;
            box-shadow: 0 0 0 2px rgba(23, 11, 157, 0.1);
        }
        
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        
        .notes-title {
            grid-column: 1 / -1;
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
            text-align: left;
        }
        
        .instructions {
            background-color: #f0f7ff;
            border-left: 4px solid #170B9DFF;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 0 6px 6px 0;
            font-size: 0.95rem;
        }
        
        .highlight {
            background-color: #fffacd;
        }
        
        .average-row {
            font-weight: bold;
            background-color: #f0f8ff !important;
        }
        
        .average-row td:first-child {
            text-align: right;
            padding-right: 15px;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            display: flex;
            align-items: center;
        }
        
        .success-message i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        @media (max-width: 992px) {
            .table-custom {
                font-size: 0.9rem;
            }
            
            .table-custom th, .table-custom td {
                padding: 8px 4px;
            }
            
            .notes-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .notes-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <h3>Résultats par Matière</h3>
        
        <!-- Message de succès (simulé) -->
        
        <div class="instructions">
            <p><i class="fas fa-info-circle"></i> Pour ajouter une nouvelle matière, utilisez le formulaire ci-dessous. Remplissez tous les champs requis, puis cliquez sur "Ajouter la matière". Les notes doivent être comprises entre 0 et 20.</p>
        </div>
        
        <div class="header-section">
            <div>
                <a href="#add-form" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Ajouter une matière
                </a>
            </div>
            <div>
                <button class="btn btn-secondary" onclick="window.location.reload()">
                    <i class="fas fa-redo"></i> Actualiser la page
                </button>
            </div>
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
                    </tr>
                    
                    <!-- Nouvelle matière ajoutée (simulée) -->
                    <tr class="highlight">
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
                    </tr>
                    
                    <!-- Exemple d'une autre matière qui pourrait être ajoutée -->
                    <tr>
                        <td>SVT</td>
                        <td>SVT</td>
                        <td>2</td>
                        <td>11</td>
                        <td>10</td>
                        <td>12</td>
                        <td>-</td>
                        <td>11</td>
                        <td>10</td>
                        <td>10.80</td>
                        <td>21.60</td>
                        <td>Assez Bien</td>
                    </tr>
                </tbody>
                
                <tfoot>
                    <tr class="average-row">
                        <td colspan="9" style="text-align: right;"><strong>MOYENNE GÉNÉRALE</strong></td>
                        <td>11.78</td>
                        <td>164.60</td>
                        <td>Assez Bien</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Formulaire d'ajout de matière -->
        <div class="form-section" id="add-form">
            <h3 class="form-title"><i class="fas fa-book-medical"></i> Ajouter une nouvelle matière</h3>
            
            <form action="#" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="subject">Nom de la matière *</label>
                        <input type="text" id="subject" name="subject" class="form-input" placeholder="Ex: Sciences Physiques" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="code">Code de la matière *</label>
                        <input type="text" id="code" name="code" class="form-input" placeholder="Ex: PHYS" maxlength="5" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="coef">Coefficient *</label>
                        <input type="number" id="coef" name="coef" class="form-input" min="1" max="10" value="2" required>
                    </div>
                </div>
                
                <div class="notes-grid">
                    <div class="notes-title">Notes /20 (optionnel)</div>
                    
                    <div class="form-group">
                        <label for="int1">Interro 1</label>
                        <input type="number" id="int1" name="int1" class="form-input" min="0" max="20" step="0.5" placeholder="0-20">
                    </div>
                    
                    <div class="form-group">
                        <label for="int2">Interro 2</label>
                        <input type="number" id="int2" name="int2" class="form-input" min="0" max="20" step="0.5" placeholder="0-20">
                    </div>
                    
                    <div class="form-group">
                        <label for="int3">Interro 3</label>
                        <input type="number" id="int3" name="int3" class="form-input" min="0" max="20" step="0.5" placeholder="0-20">
                    </div>
                    
                    <div class="form-group">
                        <label for="int4">Interro 4</label>
                        <input type="number" id="int4" name="int4" class="form-input" min="0" max="20" step="0.5" placeholder="0-20">
                    </div>
                    
                    <div class="form-group">
                        <label for="devoir">Devoir</label>
                        <input type="number" id="devoir" name="devoir" class="form-input" min="0" max="20" step="0.5" placeholder="0-20">
                    </div>
                    
                    <div class="form-group">
                        <label for="composition">Composition</label>
                        <input type="number" id="composition" name="composition" class="form-input" min="0" max="20" step="0.5" placeholder="0-20">
                    </div>
                </div>
                
                
                
                <div class="form-actions">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-eraser"></i> Effacer le formulaire
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle"></i> Ajouter la matière
                    </button>
                </div>
            </form>
        </div>
        
       
    
    

            <!-- Moyenne Générale -->
            <div class="average-box">
                <div style="color: #666; font-size: 14px; margin-bottom: 5px;">
                    MOYENNE GÉNÉRALE
                </div>
                <div class="average-value">10.89 / 20</div>
            </div>

            <!-- Signature -->
            <div style="display: flex; justify-content: space-between; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ddd;">
                <div style="text-align: center;">
                    <div style="margin-bottom: 10px;">Le Responsable de la Classe</div>
                    <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px;">
                        Signature
                    </div>
                </div>
                <div style="text-align: center;">
                    <div style="margin-bottom: 10px;">Le Directeur de l'Établissement</div>
                    <div style="border-top: 1px solid #333; width: 200px; margin: 0 auto; padding-top: 5px;">
                        Signature
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function generateBulletin() {
            const student = document.getElementById('student').value;
            const trimestre = document.getElementById('trimestre').value;
            
            if (!student || !trimestre) {
                alert('Veuillez sélectionner un élève et un trimestre');
                return;
            }
            
            // Simuler la génération d'un PDF
            alert(`Génération du bulletin PDF pour l'élève ${student}, Trimestre ${trimestre}...\n\nLe fichier PDF sera téléchargé automatiquement.`);
            
            // Ici, vous ajouteriez la logique pour générer le PDF réel
            // Par exemple: window.location.href = `/generate-pdf?student=${student}&trimestre=${trimestre}`;
        }
    </script>
</body>
</html>