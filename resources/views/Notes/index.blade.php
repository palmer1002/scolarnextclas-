<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Saisie des Notes - ScolarNextClas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #170B9D;
            --secondary-color: #7d6ae8;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-bg: #f5f5f5;
            --border-color: #ddd;
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
            z-index: 1000;
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

        .sidebar li.active {
            background-color: var(--secondary-color);
        }

        .sidebar li:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
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
            border-bottom: 1px solid var(--border-color);
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .card h2 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0f076d;
        }

        .btn-success {
            background-color: var(--success-color);
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: var(--warning-color);
            border: none;
            color: #212529;
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
            border-left: 4px solid var(--primary-color);
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-color);
            margin: 10px 0;
        }

        .stat-card .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.3s;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .note-input {
            width: 80px;
            padding: 6px 10px;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            text-align: center;
            font-weight: 500;
            transition: border-color 0.3s;
        }

        .note-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .note-input.excellent {
            border-color: var(--success-color);
            background-color: rgba(40, 167, 69, 0.1);
        }

        .note-input.good {
            border-color: var(--info-color);
            background-color: rgba(23, 162, 184, 0.1);
        }

        .note-input.average {
            border-color: var(--warning-color);
            background-color: rgba(255, 193, 7, 0.1);
        }

        .note-input.poor {
            border-color: var(--danger-color);
            background-color: rgba(220, 53, 69, 0.1);
        }

        .subject-badge {
            background: #f0f0f0;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #333;
        }

        .coef-badge {
            background: var(--primary-color);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .filter-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }

        .filter-select {
            width: 100%;
            padding: 8px 12px;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            background: white;
            transition: border-color 0.3s;
        }

        .filter-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: flex-end;
        }

        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .note-status {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 5px;
        }

        .status-excellent { background-color: var(--success-color); }
        .status-good { background-color: var(--info-color); }
        .status-average { background-color: var(--warning-color); }
        .status-poor { background-color: var(--danger-color); }
        .status-empty { background-color: #ccc; }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .content {
                margin-left: 0;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .filter-bar {
                flex-direction: column;
            }
            
            .filter-group {
                min-width: 100%;
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
        <!-- Navigation -->
        <div class="navbar">
            <div>
                <h1 style="color: var(--primary-color); margin: 0;">Saisie des Notes</h1>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9rem;">Plateforme de Gestion Scolaire Numérique</p>
            </div>
            <div style="display: flex; align-items: center; gap: 15px;">
                <span style="padding: 8px 15px; border: 1px solid var(--border-color); background: white; border-radius: 6px; font-size: 0.9rem;">
                    <i class="fas fa-calendar-alt me-2"></i>Année 2025-2026
                </span>
                
            </div>
        </div>

        <!-- Alertes -->
        <div id="successAlert" class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>Notes enregistrées avec succès!
        </div>
        <div id="errorAlert" class="alert alert-error">
            <i class="fas fa-exclamation-circle me-2"></i>Veuillez vérifier les notes saisies.
        </div>

        <!-- Filtres -->
        <div class="card">
            <h2>Sélection des paramètres</h2>
            <div class="filter-bar">
                <div class="filter-group">
                    <label for="classeSelect">Classe</label>
                    <select id="classeSelect" class="filter-select">
                        <option value="">Sélectionner une classe...</option>
                        <option value="6A" selected>6ème A</option>
                        <option value="5B">5ème B</option>
                        <option value="4A">4ème A</option>
                        <option value="TC">Tle C</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="matiereSelect">Matière</label>
                    <select id="matiereSelect" class="filter-select">
                        <option value="">Toutes les matières</option>
                        <option value="math" selected>Mathématiques</option>
                        <option value="french">Français</option>
                        <option value="english">Anglais</option>
                        <option value="physics">Sciences Physiques</option>
                        <option value="history">Histoire-Géo</option>
                        <option value="svt">SVT</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="eleveSelect">Élève</label>
                    <select id="eleveSelect" class="filter-select">
                        <option value="">Tous les élèves</option>
                        <option value="SNC2024001" selected>Amina Diallo (SNC2024001)</option>
                        <option value="SNC2024002">Ray Kokoroko (SNC2024002)</option>
                        <option value="SNC2024003">Arnaud Klanlenou (SNC2024003)</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="trimestreSelect">Trimestre</label>
                    <select id="trimestreSelect" class="filter-select">
                        <option value="T1" selected>Trimestre 1</option>
                        <option value="T2">Trimestre 2</option>
                        <option value="T3">Trimestre 3</option>
                        <option value="T2">Semestre 1</option>
                        <option value="T3">Semestre 2</option>
                        <option value="A">Annuel</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <button class="btn-primary" style="height: 42px;">
                        <i class="fas fa-filter me-2"></i>Appliquer
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-label">Moyenne Générale</div>
                <div class="stat-value" id="currentAverage">10.89</div>
                <div>/20</div>
                <div style="color: #666; font-size: 0.8rem; margin-top: 5px;">
                    <span id="averageEvolution" style="color: #dc3545;">↓ -4.00</span> vs T1
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-label">Notes saisies</div>
                <div class="stat-value" id="notesCount">3/6</div>
                <div>matières</div>
                <div style="color: #666; font-size: 0.8rem; margin-top: 5px;">
                    Complétion: <span id="completionRate">50%</span>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-label">Meilleure note</div>
                <div class="stat-value" id="bestNote">12.00</div>
                <div>Anglais</div>
                <div style="color: #666; font-size: 0.8rem; margin-top: 5px;">
                    Coefficient: 2
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-label">Évolution</div>
                <div class="stat-value" style="color: #dc3545;" id="evolutionTrend">-4.00</div>
                <div>Points</div>
                <div style="color: #666; font-size: 0.8rem; margin-top: 5px;">
                    Par rapport au T1
                </div>
            </div>
        </div>

        <!-- Tableau des notes -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2>Notes par matière</h2>
                <div style="display: flex; gap: 10px;">
                    <button class="btn-warning" onclick="autoCalculateMissingNotes()">
                        <i class="fas fa-calculator me-2"></i>Calculer auto
                    </button>
                    <button class="btn-success" onclick="validateAllNotes()">
                        <i class="fas fa-check me-2"></i>Valider notes
                    </button>
                </div>
            </div>
            
            <p style="color: #666; margin-bottom: 20px; font-size: 0.9rem;">
                Saisissez les notes pour chaque matière. La moyenne générale est calculée automatiquement.
            </p>

            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Matière</th>
                            <th>Code</th>
                            <th>Coefficient</th>
                            <th>Note (/20)</th>
                            <th>Note x Coef</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="notesTableBody">
                        <!-- Les lignes seront générées dynamiquement -->
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="4" style="text-align: right; font-weight: 600;">
                                Moyenne Générale:
                            </td>
                            <td id="weightedAverage" style="font-weight: 600;">10.89</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="action-buttons">
                <button class="btn-primary" onclick="saveAllNotes()">
                    <i class="fas fa-save me-2"></i>Enregistrer toutes les notes
                </button>
                <button class="btn-warning" onclick="resetAllNotes()">
                    <i class="fas fa-undo me-2"></i>Réinitialiser
                </button>
                <button class="btn-success" onclick="printNotes()">
                    <i class="fas fa-print me-2"></i>Imprimer
                </button>
            </div>
        </div>
    </div>

    <script>
        // ========== DONNÉES SIMULÉES ==========
        const matieres = [
            { id: 'math', nom: 'Mathématiques', code: 'MATH', coef: 4, note: 11.00, noteT1: 15.50 },
            { id: 'french', nom: 'Français', code: 'FR', coef: 3, note: 10.00, noteT1: 14.00 },
            { id: 'english', nom: 'Anglais', code: 'ANG', coef: 2, note: 12.00, noteT1: 13.00 },
            { id: 'history', nom: 'Histoire-Géographie', code: 'HG', coef: 2, note: null, noteT1: 16.50 },
            { id: 'physics', nom: 'Sciences Physiques', code: 'PC', coef: 3, note: null, noteT1: 12.50 },
            { id: 'svt', nom: 'Sciences de la Vie et de la Terre', code: 'SVT', coef: 2, note: null, noteT1: 11.00 }
        ];

        const eleves = {
            'SNC2024001': { nom: 'Amina Diallo', classe: '5ème B' },
            'SNC2024002': { nom: 'Ray Kokoroko', classe: '5ème B' },
            'SNC2024003': { nom: 'Arnaud Klanlenou', classe: '5ème B' }
        };

        // ========== ÉLÉMENTS ==========
        const notesTableBody = document.getElementById('notesTableBody');
        const currentAverage = document.getElementById('currentAverage');
        const notesCount = document.getElementById('notesCount');
        const completionRate = document.getElementById('completionRate');
        const bestNote = document.getElementById('bestNote');
        const evolutionTrend = document.getElementById('evolutionTrend');
        const averageEvolution = document.getElementById('averageEvolution');
        const weightedAverage = document.getElementById('weightedAverage');
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');

        // ========== FONCTIONS UTILITAIRES ==========
        function getNoteStatus(note) {
            if (note === null || note === '') return 'empty';
            if (note >= 16) return 'excellent';
            if (note >= 14) return 'good';
            if (note >= 10) return 'average';
            return 'poor';
        }

        function getNoteClass(note) {
            const status = getNoteStatus(note);
            return `note-input ${status}`;
        }

        function getStatusIcon(status) {
            switch(status) {
                case 'excellent': return 'fas fa-star';
                case 'good': return 'fas fa-thumbs-up';
                case 'average': return 'fas fa-check';
                case 'poor': return 'fas fa-exclamation-triangle';
                default: return 'far fa-circle';
            }
        }

        function getStatusColor(status) {
            switch(status) {
                case 'excellent': return 'var(--success-color)';
                case 'good': return 'var(--info-color)';
                case 'average': return 'var(--warning-color)';
                case 'poor': return 'var(--danger-color)';
                default: return '#ccc';
            }
        }

        function calculateStatistics() {
            let totalNoteCoef = 0;
            let totalCoeff = 0;
            let notesEntered = 0;
            let highestNote = 0;
            let highestNoteSubject = '';
            let totalEvolution = 0;

            matieres.forEach(matiere => {
                if (matiere.note !== null && matiere.note !== '') {
                    const note = parseFloat(matiere.note);
                    totalNoteCoef += note * matiere.coef;
                    totalCoeff += matiere.coef;
                    notesEntered++;

                    if (note > highestNote) {
                        highestNote = note;
                        highestNoteSubject = matiere.code;
                    }

                    if (matiere.noteT1) {
                        totalEvolution += (note - matiere.noteT1);
                    }
                }
            });

            // Mise à jour des statistiques
            const moyenne = totalCoeff > 0 ? (totalNoteCoef / totalCoeff).toFixed(2) : '0.00';
            const evolution = (moyenne - 14.89).toFixed(2); // Comparaison avec T1

            currentAverage.textContent = moyenne;
            weightedAverage.textContent = `${moyenne} / 20`;
            
            notesCount.textContent = `${notesEntered}/${matieres.length}`;
            completionRate.textContent = `${Math.round((notesEntered / matieres.length) * 100)}%`;
            
            bestNote.textContent = highestNote > 0 ? highestNote.toFixed(2) : '-';
            
            evolutionTrend.textContent = evolution;
            evolutionTrend.style.color = evolution >= 0 ? 'var(--success-color)' : 'var(--danger-color)';
            
            averageEvolution.textContent = evolution >= 0 ? `↑ ${evolution}` : `↓ ${Math.abs(evolution)}`;
            averageEvolution.style.color = evolution >= 0 ? 'var(--success-color)' : 'var(--danger-color)';

            return parseFloat(moyenne);
        }

        function updateNote(matiereId, newNote) {
            const matiere = matieres.find(m => m.id === matiereId);
            if (matiere) {
                matiere.note = newNote === '' ? null : parseFloat(newNote);
                renderTable();
                calculateStatistics();
            }
        }

        function saveNote(matiereId) {
            const matiere = matieres.find(m => m.id === matiereId);
            if (matiere) {
                showAlert('success', `Note de ${matiere.nom} enregistrée: ${matiere.note}/20`);
            }
        }

        function saveAllNotes() {
            const notesToSave = matieres.filter(m => m.note !== null);
            if (notesToSave.length > 0) {
                showAlert('success', `${notesToSave.length} notes enregistrées avec succès!`);
            } else {
                showAlert('error', 'Aucune note à enregistrer');
            }
        }

        function validateAllNotes() {
            const invalidNotes = matieres.filter(m => {
                if (m.note === null) return false;
                return m.note < 0 || m.note > 20;
            });

            if (invalidNotes.length === 0) {
                showAlert('success', 'Toutes les notes sont valides!');
            } else {
                showAlert('error', `${invalidNotes.length} note(s) invalide(s). Les notes doivent être entre 0 et 20.`);
            }
        }

        function autoCalculateMissingNotes() {
            matieres.forEach(matiere => {
                if (matiere.note === null && matiere.noteT1) {
                    // Simulation d'un calcul automatique basé sur la note du T1
                    matiere.note = Math.max(0, Math.min(20, matiere.noteT1 * 0.8 + Math.random() * 4));
                }
            });
            renderTable();
            calculateStatistics();
            showAlert('success', 'Notes manquantes calculées automatiquement');
        }

        function resetAllNotes() {
            if (confirm('Voulez-vous vraiment réinitialiser toutes les notes?')) {
                matieres.forEach(matiere => {
                    matiere.note = null;
                });
                renderTable();
                calculateStatistics();
                showAlert('success', 'Toutes les notes ont été réinitialisées');
            }
        }

        function printNotes() {
            window.print();
        }

        function showAlert(type, message) {
            if (type === 'success') {
                successAlert.innerHTML = `<i class="fas fa-check-circle me-2"></i>${message}`;
                successAlert.style.display = 'block';
                errorAlert.style.display = 'none';
            } else {
                errorAlert.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>${message}`;
                errorAlert.style.display = 'block';
                successAlert.style.display = 'none';
            }

            setTimeout(() => {
                successAlert.style.display = 'none';
                errorAlert.style.display = 'none';
            }, 3000);
        }

        function renderTable() {
            notesTableBody.innerHTML = '';
            
            matieres.forEach(matiere => {
                const status = getNoteStatus(matiere.note);
                const statusColor = getStatusColor(status);
                const statusIcon = getStatusIcon(status);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <strong>${matiere.nom}</strong>
                    </td>
                    <td>
                        <span class="subject-badge">${matiere.code}</span>
                    </td>
                    <td>
                        <span class="coef-badge">${matiere.coef}</span>
                    </td>
                    <td>
                        <input type="number" 
                               class="${getNoteClass(matiere.note)}" 
                               value="${matiere.note || ''}" 
                               min="0" 
                               max="20" 
                               step="0.25"
                               onchange="updateNote('${matiere.id}', this.value)"
                               oninput="updateNoteStatus(this)">
                    </td>
                    <td>
                        ${matiere.note !== null ? (matiere.note * matiere.coef).toFixed(2) : '-'}
                    </td>
                    <td>
                        <i class="${statusIcon}" style="color: ${statusColor};"></i>
                        <span class="note-status status-${status}"></span>
                    </td>
                    <td>
                        <button class="btn-success" onclick="saveNote('${matiere.id}')" ${matiere.note === null ? 'disabled' : ''}>
                            <i class="fas fa-save"></i>
                        </button>
                        <button class="btn-warning" onclick="updateNote('${matiere.id}', ${matiere.noteT1 || 10})" title="Remplir avec note T1">
                            <i class="fas fa-history"></i>
                        </button>
                    </td>
                `;
                notesTableBody.appendChild(row);
            });
        }

        function updateNoteStatus(input) {
            const note = parseFloat(input.value) || null;
            input.className = getNoteClass(note);
        }

        // ========== INITIALISATION ==========
        document.addEventListener('DOMContentLoaded', () => {
            renderTable();
            calculateStatistics();
            
            // Écouteurs d'événements pour les filtres
            document.getElementById('classeSelect').addEventListener('change', () => {
                showAlert('success', 'Filtres appliqués');
            });
            
            document.getElementById('matiereSelect').addEventListener('change', () => {
                showAlert('success', 'Filtres appliqués');
            });
            
            document.getElementById('eleveSelect').addEventListener('change', () => {
                showAlert('success', 'Élève sélectionné');
            });
            
            document.getElementById('trimestreSelect').addEventListener('change', () => {
                showAlert('success', 'Trimestre sélectionné');
            });
        });

        // Fermer les alertes en cliquant dessus
        successAlert.addEventListener('click', () => {
            successAlert.style.display = 'none';
        });
        
        errorAlert.addEventListener('click', () => {
            errorAlert.style.display = 'none';
        });
    </script>

</body>
</html>