<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ScolarNextClas - Gestion des Utilisateurs</title>
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
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .users-table {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
            overflow-x: auto;
        }
        .users-table h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }
        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .table tr:hover {
            background-color: #f8f9fa;
        }
        .role-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .badge-admin {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .badge-secretaire {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-directeur {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-comptable {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-active {
            color: #28a745;
            font-weight: 500;
        }
        .btn-action {
            background: none;
            border: 1px solid #ddd;
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            color: #666;
            transition: all 0.2s;
        }
        .btn-action:hover {
            background-color: #f0f0f0;
            color: #333;
        }
        .btn-primary-custom {
            background-color: #170B9DFF;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
        }
        .btn-primary-custom:hover {
            background-color: #0e0770;
        }
        .search-bar {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 250px;
        }
        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .status-active {
    color: #28a745;
    font-weight: 500;
}

.status-inactive {
    color: #dc3545;
    font-weight: 500;
}

.status-active i,
.status-inactive i {
    margin-right: 5px;
}

/* Pour plus de clarté */
.status-active i {
    color: #28a745;
}

.status-inactive i {
    color: #dc3545;
}

.action-buttons {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

.btn-action {
    background: none;
    border: 1px solid #ddd;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    color: #666;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-action:active {
    transform: translateY(0);
}

/* Bouton Voir */
.btn-show {
    color: #17a2b8;
    border-color: #17a2b8;
    background-color: rgba(23, 162, 184, 0.05);
}

.btn-show:hover {
    background-color: rgba(23, 162, 184, 0.1);
    color: #138496;
    border-color: #138496;
}

/* Bouton Modifier */
.btn-edit {
    color: #ffc107;
    border-color: #ffc107;
    background-color: rgba(255, 193, 7, 0.05);
}

.btn-edit:hover {
    background-color: rgba(255, 193, 7, 0.1);
    color: #e0a800;
    border-color: #e0a800;
}

/* Bouton Supprimer */
.btn-delete {
    color: #dc3545;
    border-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.05);
}

.btn-delete:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: #c82333;
    border-color: #c82333;
}

/* Version avec icônes seulement (pour espace réduit) */
.btn-action.icon-only {
    padding: 6px 8px;
    width: 32px;
    height: 32px;
    justify-content: center;
}

.btn-action.icon-only i {
    margin-right: 0;
}

/* Version compacte pour tableaux */
.compact-actions .action-buttons {
    gap: 3px;
}

.compact-actions .btn-action {
    padding: 4px 8px;
    font-size: 0.8rem;
}

/* Version avec badges de statut */
.btn-action.with-badge {
    position: relative;
}

.badge-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Boutons désactivés */
.btn-action:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
    box-shadow: none !important;
}

.btn-action:disabled:hover {
    background-color: initial;
    border-color: #ddd;
    color: #666;
}

/* Animation pour les actions */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.btn-action.pulse {
    animation: pulse 0.3s ease;
}

/* Bouton supplémentaire pour activation/désactivation */
.btn-toggle {
    color: #6c757d;
    border-color: #6c757d;
    background-color: rgba(108, 117, 125, 0.05);
}

.btn-toggle:hover {
    background-color: rgba(108, 117, 125, 0.1);
    color: #545b62;
    border-color: #545b62;
}

.btn-toggle.active {
    color: #28a745;
    border-color: #28a745;
    background-color: rgba(40, 167, 69, 0.1);
}

.btn-toggle.inactive {
    color: #dc3545;
    border-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.1);
}

/* Styles pour la responsivité */
@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        gap: 3px;
    }
    
    .btn-action {
        padding: 5px 8px;
        font-size: 0.8rem;
        justify-content: center;
    }
    
    .btn-action i {
        margin-right: 0;
    }
    
    .btn-action span {
        display: none;
    }
    
    .btn-action.icon-only {
        width: 30px;
        height: 30px;
    }
}

/* Effet de survol pour les lignes du tableau */
.table tr:hover .btn-action {
    opacity: 1;
    visibility: visible;
}

/* Option: cacher les boutons par défaut et les montrer au survol */
.table tr .btn-action {
    transition: opacity 0.2s ease, visibility 0.2s ease;
}

.table tr:not(:hover) .btn-action.hide-on-hover {
    opacity: 0;
    visibility: hidden;
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
            <li class="active">
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
                <h1>Gestion des Utilisateurs</h1>
                <p>Comptes et permissions du système</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                    Année 2025-2026
                </span>
            </div>
        </div>

   
        <!-- En-tête avec actions -->
        <div class="header-actions">
            <div>
                <h3 style="margin: 0;">Liste des Utilisateurs</h3>
                <p style="font-size: 0.9rem; color: #666; margin: 5px 0 0 0;">
                    Gestion des comptes et permissions du système
                </p>
            </div>
            <div style="display: flex; gap: 10px;">
                <input type="text" class="search-bar" placeholder="Rechercher un utilisateur...">
                <button class="btn-primary-custom">
                    <i class="fas fa-plus"></i> Nouvel Utilisateur
                </button>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="users-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Dernière Connexion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
    <tr>
        <td><strong>Admin Principal</strong></td>
        <td>admin@scolar.com</td>
        <td>
            <span class="role-badge badge-admin">
                <i class="fas fa-user-shield"></i> Administrateur
            </span>
        </td>
        <td class="status-active">
            <i class="fas fa-circle" style="font-size: 0.7rem;"></i> Actif
        </td>
        <td>20/01/2025</td>
        <td>
            <div class="action-buttons">
                <button class="btn-action btn-show">
                    <i class="fas fa-eye"></i> Voir
                </button>
                <button class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn-action btn-delete">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </td>
    </tr>
    <tr>
        <td><strong>Secrétaire Générale</strong></td>
        <td>secrétaire@scolar.com</td>
        <td>
            <span class="role-badge badge-secretaire">
                <i class="fas fa-user-tie"></i> Secrétaire
            </span>
        </td>
        <td class="status-inactive">
            <i class="fas fa-circle" style="font-size: 0.7rem;"></i> Inactif
        </td>
        <td>15/12/2024</td>
        <td>
            <div class="action-buttons">
                <button class="btn-action btn-show">
                    <i class="fas fa-eye"></i> Voir
                </button>
                <button class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn-action btn-delete">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </td>
    </tr>
    <tr>
        <td><strong>Directeur des Études</strong></td>
        <td>directeur@scolar.com</td>
        <td>
            <span class="role-badge badge-directeur">
                <i class="fas fa-user-graduate"></i> Directeur
            </span>
        </td>
        <td class="status-active">
            <i class="fas fa-circle" style="font-size: 0.7rem;"></i> Actif
        </td>
        <td>19/01/2025</td>
        <td>
            <div class="action-buttons">
                <button class="btn-action btn-show">
                    <i class="fas fa-eye"></i> Voir
                </button>
                <button class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn-action btn-delete">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </td>
    </tr>
    <tr>
        <td><strong>Comptable</strong></td>
        <td>comptable@scolar.com</td>
        <td>
            <span class="role-badge badge-comptable">
                <i class="fas fa-calculator"></i> Comptable
            </span>
        </td>
        <td class="status-active">
            <i class="fas fa-circle" style="font-size: 0.7rem;"></i> Actif
        </td>
        <td>18/01/2025</td>
        <td>
            <div class="action-buttons">
                <button class="btn-action btn-show">
                    <i class="fas fa-eye"></i> Voir
                </button>
                <button class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn-action btn-delete">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </td>
    </tr>
    <tr>
        <td><strong>Enseignant de Français</strong></td>
        <td>francais@scolar.com</td>
        <td>
            <span class="role-badge badge-enseignant">
                <i class="fas fa-chalkboard-teacher"></i> Enseignant
            </span>
        </td>
        <td class="status-active">
            <i class="fas fa-circle" style="font-size: 0.7rem;"></i> Actif
        </td>
        <td>28/03/2025</td>
        <td>
            <div class="action-buttons">
                <button class="btn-action btn-show">
                    <i class="fas fa-eye"></i> Voir
                </button>
                <button class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn-action btn-delete">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </td>
    </tr>
    <tr>
        <td><strong>Enseignant de Mathématiques</strong></td>
        <td>maths@scolar.com</td>
        <td>
            <span class="role-badge badge-enseignant">
                <i class="fas fa-chalkboard-teacher"></i> Enseignant
            </span>
        </td>
        <td class="status-inactive">
            <i class="fas fa-circle" style="font-size: 0.7rem;"></i> Inactif
        </td>
        <td>05/02/2025</td>
        <td>
            <div class="action-buttons">
                <button class="btn-action btn-show">
                    <i class="fas fa-eye"></i> Voir
                </button>
                <button class="btn-action btn-edit">
                    <i class="fas fa-edit"></i> Modifier
                </button>
                <button class="btn-action btn-delete">
                    <i class="fas fa-trash"></i> Supprimer
                </button>
            </div>
        </td>
    </tr>
</tbody>
            </table>
            
               </div>
    </div>

            
</body>
</html>