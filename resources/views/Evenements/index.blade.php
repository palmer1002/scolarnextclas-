<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScolarNextClas - Tableau de Bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Styles généraux */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            min-height: 100vh;
        }

        /* Sidebar commune */
        .sidebar {
            width: 250px;
            background-color: #170B9D;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            color: white;
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
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar li:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #7d6ae8;
        }

        .sidebar li.active {
            background-color: #7d6ae8;
            border-left-color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
        }

        /* Contenu principal */
        .content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: #f5f7fa;
        }

        /* Navbar commune */
        .navbar {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar h1 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin: 0;
        }

        .navbar p {
            color: #6c757d;
            margin: 5px 0 0 0;
            font-size: 0.95rem;
        }

        .year-selector {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            color: #495057;
        }

        /* Cards communes */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 25px;
            border: 1px solid #eee;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #170B9D;
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            font-size: 1.5rem;
            color: #2c3e50;
        }

        /* Boutons communs */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #170B9D;
            color: white;
        }

        .btn-primary:hover {
            background-color: #120890;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 11, 157, 0.2);
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid #170B9D;
            color: #170B9D;
        }

        .btn-outline:hover {
            background-color: #170B9D;
            color: white;
        }

        /* Grille de contenu */
        .content-container {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 4px solid #170B9D;
        }

        .stat-card i {
            font-size: 2rem;
            color: #170B9D;
        }

        .stat-info h3 {
            font-size: 2rem;
            margin: 0;
            color: #2c3e50;
        }

        .stat-info p {
            margin: 5px 0 0 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Alertes */
        .alert-card {
            margin-bottom: 25px;
        }

        .alert-header {
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-item {
            background: #fff5f5;
            border: 1px solid #ff6b6b;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #eee;
            background: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #170B9D;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #120890;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* Calendrier */
        .calendar-grid {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 25px;
        }

        .calendar-view {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .weekday {
            text-align: center;
            font-weight: 600;
            color: #170B9D;
            padding: 10px;
            font-size: 0.9rem;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-day {
            min-height: 100px;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #eee;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
            position: relative;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
            }
            .sidebar {
                display: none;
            }
            .calendar-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content-container {
                padding: 15px;
            }
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .grid-4 {
                grid-template-columns: 1fr;
            }
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
                <a href="#dashboard">
                    <i class="fas fa-chart-pie"></i> Tableau de bord
                </a>
            </li>
            <li>
                <a href="#eleves">
                    <i class="fas fa-user-graduate"></i> Élèves
                </a>
            </li>
            <li>
                <a href="#notes">
                    <i class="fas fa-pen-to-square"></i> Notes
                </a>
            </li>
            <li>
                <a href="#bulletins">
                    <i class="fas fa-file-alt"></i> Bulletins
                </a>
            </li>
            <li>
                <a href="#enseignants">
                    <i class="fas fa-chalkboard-teacher"></i> Enseignants
                </a>
            </li>
            <li>
                <a href="#parents">
                    <i class="fas fa-users"></i> Parents
                </a>
            </li>
            <li>
                <a href="#evenements">
                    <i class="fas fa-calendar-days"></i> Événements
                </a>
            </li>
            <li>
                <a href="#paiement">
                    <i class="fas fa-money-bill-wave"></i> Paiement
                </a>
            </li>
            <li>
                <a href="#cantine">
                    <i class="fas fa-utensils"></i> Cantine
                </a>
            </li>
            <li>
                <a href="#utilisateurs">
                    <i class="fas fa-user-group"></i> Utilisateurs
                </a>
            </li>
            <li>
                <a href="#chat">
                    <i class="fas fa-comments"></i> Chat
                </a>
            </li>
            <li>
                <a href="#activite">
                    <i class="fas fa-chart-line"></i> Activité
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1 id="pageTitle"><i class="fas fa-chart-pie"></i> Tableau de bord</h1>
                <p id="pageDescription">Plateforme de Gestion Scolaire Numérique</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <span class="year-selector">
                    Année 2025-2026
                </span>
            </div>
        </div>

        <!-- Contenu de la page -->
        <div class="content-container" id="mainContent">
            <!-- Page Tableau de bord -->
            <div id="dashboardContent">
                <!-- Statistiques -->
                <div class="grid-4">
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>Total Élèves</p>
                            <small style="color: #999;">Inscrits cette année</small>
                        </div>
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>6</h3>
                            <p>Notes Enregistrées</p>
                            <small style="color: #999;">Sur 2 trimestres</small>
                        </div>
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3>12.89/20</h3>
                            <p>Moyenne Générale</p>
                            <small style="color: #999;">Tous élèves confondus</small>
                        </div>
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h3 style="color: #dc3545;">2</h3>
                            <p>Alertes Actives</p>
                            <small style="color: #999;">Chutes de notes détectées</small>
                        </div>
                        <i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i>
                    </div>
                </div>

                <!-- Alertes -->
                <div class="card alert-card">
                    <div class="alert-header" style="color: #dc3545;">
                        <i class="fas fa-exclamation-triangle"></i> Alertes Intelligentes - IA
                    </div>
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 15px;">
                        Système d'alerte automatique pour les chutes de notes supérieures à 20%
                    </p>
                    
                    <!-- Alerte négative -->
                    <div class="alert-item">
                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                            <span style="margin-right: 10px; font-size: 1.2rem; color: #dc3545;">⚠️</span>
                            <strong>Amina Diallo (SNC2024001)</strong>
                        </div>
                        <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #666;">
                            Chute de 26.9% détectée entre T1 (14.89) et T2 (10.89)
                        </p>
                        <p style="margin: 10px 0 0 0; font-size: 0.8rem; color: #999;">
                            Contact parent: +228 90 90 90 90
                        </p>
                    </div>

                    <!-- Alerte positive -->
                    <div class="alert-item" style="background: #f0fff4; border-color: #28a745;">
                        <div style="display: flex; align-items: center; margin-bottom: 5px;">
                            <span style="margin-right: 10px; font-size: 1.2rem; color: #28a745;">⬆️</span>
                            <strong>Ray Kokoroko (SNC2024002)</strong>
                        </div>
                        <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #666;">
                            Amélioration de 26.9% détectée entre T1 (10.89) et T2 (14.89)
                        </p>
                        <p style="margin: 10px 0 0 0; font-size: 0.8rem; color: #999;">
                            Contact parent: +228 90 90 90 90
                        </p>
                    </div>
                </div>

                <!-- Élèves récents -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fas fa-user-graduate"></i> Élèves Récents</h2>
                        <button class="btn btn-outline" onclick="loadPage('#eleves')">
                            Voir tous
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom & Prénom</th>
                                    <th>Matricule</th>
                                    <th>Classe</th>
                                    <th>Genre</th>
                                    <th>Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Amina Diallo</strong></td>
                                    <td>SNC2024001</td>
                                    <td>4ème A</td>
                                    <td><i class="fas fa-venus" style="color: #d63384;"></i> Féminin</td>
                                    <td>01/09/2024</td>
                                </tr>
                                <tr>
                                    <td><strong>Ray Kokoroko</strong></td>
                                    <td>SNC2024002</td>
                                    <td>Terminale D</td>
                                    <td><i class="fas fa-mars" style="color: #0d6efd;"></i> Masculin</td>
                                    <td>05/09/2024</td>
                                </tr>
                                <tr>
                                    <td><strong>Arnaud Klanlenou</strong></td>
                                    <td>SNC2024003</td>
                                    <td>3ème C</td>
                                    <td><i class="fas fa-mars" style="color: #0d6efd;"></i> Masculin</td>
                                    <td>10/09/2024</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Page Élèves -->
            <div id="elevesContent" style="display: none;">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fas fa-list"></i> Liste des Élèves</h2>
                        <button class="btn btn-primary" onclick="showForm('createStudent')">
                            <i class="fas fa-plus"></i> Ajouter un élève
                        </button>
                    </div>

                    <div class="search-filter" style="display: flex; gap: 20px; margin-bottom: 25px;">
                        <div style="flex: 1; position: relative;">
                            <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
                            <input type="text" placeholder="Rechercher un élève..." style="width: 100%; padding: 12px 12px 12px 40px; border: 1px solid #ddd; border-radius: 6px;">
                        </div>
                        <select style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; min-width: 200px;">
                            <option value="">Toutes les classes</option>
                            <option value="6A">6ème A</option>
                            <option value="4A">4ème A</option>
                            <option value="3C">3ème C</option>
                            <option value="TD">Terminale D</option>
                        </select>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom & Prénom</th>
                                    <th>Classe</th>
                                    <th>Genre</th>
                                    <th>Parent/Tuteur</th>
                                    <th>Téléphone</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>SNC2024001</strong></td>
                                    <td><strong>Amina Diallo</strong></td>
                                    <td>4ème A</td>
                                    <td><i class="fas fa-venus" style="color: #d63384;"></i></td>
                                    <td>Mohamed Diallo</td>
                                    <td>+228 99 99 99 99</td>
                                    <td><span style="background: #d4edda; color: #155724; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">Actif</span></td>
                                    <td>
                                        <div style="display: flex; gap: 8px;">
                                            <button class="btn btn-outline" style="padding: 5px 10px; font-size: 0.85rem;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline" style="padding: 5px 10px; font-size: 0.85rem;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline" style="padding: 5px 10px; font-size: 0.85rem;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Plus d'élèves... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Page Événements -->
            <div id="evenementsContent" style="display: none;">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fas fa-calendar-alt"></i> Calendrier des Événements</h2>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nouvel événement
                        </button>
                    </div>

                    <div class="calendar-grid">
                        <div class="calendar-view">
                            <div class="calendar-header">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <button class="btn btn-outline" style="padding: 8px;">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <h3 style="margin: 0;">Janvier 2025</h3>
                                    <button class="btn btn-outline" style="padding: 8px;">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                                <div style="display: flex; gap: 10px;">
                                    <button class="btn btn-outline" style="padding: 8px 15px;">
                                        <i class="fas fa-calendar-week"></i> Semaine
                                    </button>
                                    <button class="btn btn-primary" style="padding: 8px 15px;">
                                        <i class="fas fa-calendar-alt"></i> Mois
                                    </button>
                                </div>
                            </div>

                            <div class="calendar-weekdays">
                                <div class="weekday">Lun</div>
                                <div class="weekday">Mar</div>
                                <div class="weekday">Mer</div>
                                <div class="weekday">Jeu</div>
                                <div class="weekday">Ven</div>
                                <div class="weekday">Sam</div>
                                <div class="weekday">Dim</div>
                            </div>

                            <div class="calendar-days">
                                <!-- Les jours du calendrier ici -->
                            </div>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="card">
                                <h3><i class="fas fa-bell"></i> Événements à venir</h3>
                                <div style="margin-top: 15px;">
                                    <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; border-left: 4px solid #17a2b8; margin-bottom: 10px;">
                                        <strong>Réunion Parents-Professeurs</strong>
                                        <p style="margin: 5px 0; font-size: 0.9rem; color: #666;">15 janvier 2025 • 14:00</p>
                                    </div>
                                    <div style="background: #f0fff4; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745; margin-bottom: 10px;">
                                        <strong>Compétition Sportive</strong>
                                        <p style="margin: 5px 0; font-size: 0.9rem; color: #666;">5 février 2025 • 09:00</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <h3><i class="fas fa-tags"></i> Catégories</h3>
                                <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Réunions</span>
                                        <span style="background: #eef2f7; padding: 2px 10px; border-radius: 12px;">2</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Sportif</span>
                                        <span style="background: #eef2f7; padding: 2px 10px; border-radius: 12px;">3</span>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Culturel</span>
                                        <span style="background: #eef2f7; padding: 2px 10px; border-radius: 12px;">1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Navigation entre les pages
        function loadPage(pageId) {
            // Mettre à jour la sidebar
            document.querySelectorAll('.sidebar li').forEach(li => {
                li.classList.remove('active');
            });
            
            // Activer l'élément correspondant
            const navItem = document.querySelector(`.sidebar a[href="${pageId}"]`);
            if (navItem) {
                navItem.parentElement.classList.add('active');
            }

            // Cacher tout le contenu
            document.querySelectorAll('#mainContent > div').forEach(div => {
                div.style.display = 'none';
            });

            // Afficher le contenu correspondant
            const contentId = pageId.replace('#', '') + 'Content';
            const content = document.getElementById(contentId);
            if (content) {
                content.style.display = 'block';
            }

            // Mettre à jour le titre de la page
            const titles = {
                '#dashboard': { title: 'Tableau de bord', desc: 'Plateforme de Gestion Scolaire Numérique' },
                '#eleves': { title: 'Gestion des Élèves', desc: 'Administrez les élèves inscrits dans l\'établissement' },
                '#evenements': { title: 'Calendrier des Événements', desc: 'Planification et suivi des événements scolaires' },
                '#notes': { title: 'Gestion des Notes', desc: 'Saisie et consultation des notes' },
                '#bulletins': { title: 'Bulletins', desc: 'Génération et consultation des bulletins' },
                '#enseignants': { title: 'Gestion des Enseignants', desc: 'Administration du personnel enseignant' }
            };

            const pageInfo = titles[pageId] || titles['#dashboard'];
            document.getElementById('pageTitle').innerHTML = `<i class="${navItem ? navItem.querySelector('i').className : 'fas fa-chart-pie'}"></i> ${pageInfo.title}`;
            document.getElementById('pageDescription').textContent = pageInfo.desc;
        }

        // Initialiser la navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Écouter les clics sur les liens de la sidebar
            document.querySelectorAll('.sidebar a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pageId = this.getAttribute('href');
                    loadPage(pageId);
                });
            });

            // Charger la page dashboard par défaut
            loadPage('#dashboard');
        });
    </script>
</body>
</html>