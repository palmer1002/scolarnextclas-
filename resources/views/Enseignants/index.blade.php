<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ScolarNextClas - Gestion des Enseignants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Styles de la sidebar identiques au tableau de bord */
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
            margin-bottom: 30px;
        }
        
        /* Styles spécifiques à la gestion des enseignants */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #170B9DFF;
        }
        .card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            font-size: 1.5rem;
            color: #170B9DFF;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #170B9DFF;
            color: white;
        }
        .btn-primary:hover {
            background-color: #120890;
            transform: translateY(-2px);
        }
        .btn-outline {
            background-color: transparent;
            border: 1px solid #ddd;
            color: #333;
        }
        .btn-outline:hover {
            background-color: #f5f5f5;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-warning {
            background-color: #ffc107;
            color: #333;
        }
        .btn-info {
            background-color: #17a2b8;
            color: white;
        }
        .search-filter {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            gap: 20px;
        }
        .search-box {
            flex: 1;
            position: relative;
        }
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        .search-box input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border 0.3s;
        }
        .search-box input:focus {
            border-color: #170B9DFF;
            outline: none;
            box-shadow: 0 0 0 2px rgba(23, 11, 157, 0.1);
        }
        
        /* Table styles */
        .table-container {
            overflow-x: auto;
            border-radius: 8px;
            border: 1px solid #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #170B9DFF;
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
        .status-active {
            background-color: #d4edda;
            color: #155724;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            color: #666;
            transition: all 0.3s;
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }
        .action-btn:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
        }
        .badge {
            display: inline-block;
            background-color: #e8f4ff;
            color: #170B9DFF;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            margin: 2px;
            font-weight: 500;
        }
        .subject-icon {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 5px;
        }
        .page-item {
            list-style: none;
        }
        .page-link {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background: white;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
        }
        .page-link:hover {
            background-color: #f0f0f0;
        }
        .page-item.active .page-link {
            background-color: #170B9DFF;
            color: white;
            border-color: #170B9DFF;
        }
        
        /* Form styles */
        .form-container {
            max-width: 800px;
            margin: 0 auto;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            font-family: inherit;
            transition: border 0.3s;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #170B9DFF;
            outline: none;
            box-shadow: 0 0 0 2px rgba(23, 11, 157, 0.1);
        }
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        /* Detail view styles */
        .detail-card {
            max-width: 800px;
            margin: 0 auto;
        }
        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .detail-label {
            flex: 0 0 200px;
            font-weight: 600;
            color: #555;
        }
        .detail-value {
            flex: 1;
            color: #333;
        }
        .classes-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .teacher-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        .teacher-avatar {
            width: 80px;
            height: 80px;
            background-color: #170B9DFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }
        
        /* Delete confirmation */
        .delete-confirmation {
            text-align: center;
            padding: 40px 20px;
        }
        .delete-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 20px;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0;
            }
            .sidebar {
                display: none;
            }
        }
        @media (max-width: 768px) {
            .search-filter {
                flex-direction: column;
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .action-buttons {
                flex-wrap: wrap;
            }
            .detail-row {
                flex-direction: column;
                gap: 10px;
            }
            .detail-label {
                flex: none;
            }
            .form-grid {
                grid-template-columns: 1fr;
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
            <li>
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
            <li class="active">
                <a href="enseignants.html" style="color: white; text-decoration: none; display: flex; align-items: center;">
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
                <h1><i class="fas fa-chalkboard-teacher"></i> Gestion des Enseignants</h1>
                <p>Administrez le personnel enseignant et leurs affectations</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                    Année 2025-2026
                </span>
            </div>
        </div>

        <!-- Page de liste des enseignants -->
        <div id="pageContent">
            <div class="container">
                <section class="card">
                    <div class="card-header">
                        <h2 class="card-title"><i class="fas fa-list"></i> Liste des Enseignants</h2>
                        <a href="#create" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajouter un enseignant
                        </a>
                    </div>

                    <div class="search-filter">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Rechercher un enseignant par nom, matière...">
                        </div>
                        <select class="form-control" style="width: 200px;">
                            <option value="">Toutes les matières</option>
                            <option value="math">Mathématiques</option>
                            <option value="french">Français</option>
                            <option value="english">Anglais</option>
                            <option value="physics">Sciences Physiques</option>
                            <option value="history">Histoire-Géographie</option>
                            <option value="svt">SVT</option>
                            <option value="philo">Philosophie</option>
                        </select>
                    </div>

                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom complet</th>
                                    <th>Matière</th>
                                    <th>Contact</th>
                                    <th>Classes</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>Pr. Jean Kokoroko</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            <i class="fas fa-id-card me-1"></i> ENS001
                                        </div>
                                    </td>
                                    <td>
                                        <span class="subject-icon">
                                            <i class="fas fa-calculator" style="color: #170B9DFF;"></i>
                                            <strong>Mathématiques</strong>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <div style="color: #170B9DFF; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-envelope"></i>
                                                j.kokoroko@school.com
                                            </div>
                                            <div style="color: #666; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-phone"></i>
                                                +228 98 98 98 98
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                            <span class="badge">6ème A</span>
                                            <span class="badge">5ème B</span>
                                            <span class="badge">Terminale C</span>
                                            <span class="badge">1ère D</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-active">Actif</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#show" class="action-btn" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#edit" class="action-btn" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#delete" class="action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Mme. Fatima Traoré</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            <i class="fas fa-id-card me-1"></i> ENS002
                                        </div>
                                    </td>
                                    <td>
                                        <span class="subject-icon">
                                            <i class="fas fa-book" style="color: #28a745;"></i>
                                            <strong>Français</strong>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <div style="color: #170B9DFF; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-envelope"></i>
                                                f.traore@school.com
                                            </div>
                                            <div style="color: #666; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-phone"></i>
                                                +228 97 97 97 97
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                            <span class="badge">6ème A</span>
                                            <span class="badge">Terminale C</span>
                                            <span class="badge">4ème B</span>
                                            <span class="badge">3ème A</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-active">Actif</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#show" class="action-btn" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#edit" class="action-btn" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#delete" class="action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>M. Samuel Mensah</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            <i class="fas fa-id-card me-1"></i> ENS003
                                        </div>
                                    </td>
                                    <td>
                                        <span class="subject-icon">
                                            <i class="fas fa-globe" style="color: #17a2b8;"></i>
                                            <strong>Anglais</strong>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <div style="color: #170B9DFF; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-envelope"></i>
                                                s.mensah@school.com
                                            </div>
                                            <div style="color: #666; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-phone"></i>
                                                +228 99 99 99 99
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                            <span class="badge">5ème B</span>
                                            <span class="badge">4ème A</span>
                                            <span class="badge">Terminale A4</span>
                                            <span class="badge">1ère C</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-active">Actif</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#show" class="action-btn" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#edit" class="action-btn" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#delete" class="action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Dr. Marie Bossro</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            <i class="fas fa-id-card me-1"></i> ENS004
                                        </div>
                                    </td>
                                    <td>
                                        <span class="subject-icon">
                                            <i class="fas fa-flask" style="color: #dc3545;"></i>
                                            <strong>Sciences Physiques</strong>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <div style="color: #170B9DFF; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-envelope"></i>
                                                m.bossro@school.com
                                            </div>
                                            <div style="color: #666; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-phone"></i>
                                                +228 96 96 96 96
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                            <span class="badge">Terminale C</span>
                                            <span class="badge">1ère D</span>
                                            <span class="badge">2nde S</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-active">Actif</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#show" class="action-btn" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#edit" class="action-btn" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#delete" class="action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>M. Ahmed Hassan</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            <i class="fas fa-id-card me-1"></i> ENS005
                                        </div>
                                    </td>
                                    <td>
                                        <span class="subject-icon">
                                            <i class="fas fa-landmark" style="color: #6f42c1;"></i>
                                            <strong>Histoire-Géographie</strong>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <div style="color: #170B9DFF; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-envelope"></i>
                                                a.hassan@school.com
                                            </div>
                                            <div style="color: #666; display: flex; align-items: center; gap: 8px;">
                                                <i class="fas fa-phone"></i>
                                                +228 90 90 90 90
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                            <span class="badge">4ème A</span>
                                            <span class="badge">3ème C</span>
                                            <span class="badge">Terminale A4</span>
                                            <span class="badge">1ère D</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-active">Actif</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#show" class="action-btn" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#edit" class="action-btn" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#delete" class="action-btn" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <li class="page-item active">
                            <a href="#" class="page-link">1</a>
                        </li>
                        <li class="page-item">
                            <a href="#" class="page-link">2</a>
                        </li>
                        <li class="page-item">
                            <a href="#" class="page-link">Suivant</a>
                        </li>
                    </div>
                </section>
            </div>
        </div>
    </div>

</body>
</html>