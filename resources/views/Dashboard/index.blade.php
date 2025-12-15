<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ScolarNextClas</title>
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
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .alert-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .alert-header {
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        .alert-item {
            background: #fff5f5;
            border: 1px solid #FF6B6B;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
        }
        .recent-students {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .student-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f0f0f0;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <span>$</span>
            <h3>ScolarNextClas</h>
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
                <h1>Tableau de bord</h1>
                <p>Plateforme de Gestion Scolaire Numérique</p>
            </div>
            <div style="display: flex; gap: 15px;">

                <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                    Année 2025-2026
                </span>
            </div>
        </div>

        <!-- Statistiques -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
            <!-- Total Élèves -->
            <div class="card">
    <div>
        <p>Total Élèves</p>
        <h2>3</h2>
        <p style="font-size: 0.8rem; color: #999;">Inscrits cette année</p>
    </div>
    <div style="font-size: 1.5rem;">
        <i class="fas fa-users"></i> <!-- Group icon -->
    </div>
    </div>
            <!-- Notes Enregistrées -->
            <div class="card">
    <div>
        <p>Notes Enregistrées</p>
        <h2>6</h2>
        <p style="font-size: 0.8rem; color: #999;">Sur 2 trimestres</p>
    </div>
    <div style="font-size: 1.5rem;">
        <i class="fas fa-clipboard-list"></i>
    </div>
    </div>

            <!-- Moyenne Générale -->
            <div class="card">
    <div>
        <p>Moyenne Générale</p>
        <h2>12.89/20</h2>
        <p style="font-size: 0.8rem; color: #999;">Tous élèves confondus</p>
    </div>
    <div style="font-size: 1.5rem;">
        <i class="fas fa-chart-line"></i> <!-- Line chart for trends -->
    </div>
</div>


            <!-- Alertes Actives -->
            <div class="card">
                <div>
                    <p>Alertes Actives</p>
                    <h2 style="color: #9D1414FF;">2</h2>
                    <p style="font-size: 0.8rem; color: #999;">Chutes de notes détectées</p>
                </div>
                <div style="font-size: 1.5rem; color: #9D1414FF;">⚠️</div>
            </div>
        </div>

<!-- Alerte négative -->
<div class="alert-card negative">
    <div class="alert-header" style="color: #B60A0AFF;">⚠️ Alertes Intelligentes - IA</div>
    <p style="font-size: 0.9rem; color: #666; margin: 0 0 15px 0;">
        Système d'alerte automatique pour les chutes de notes supérieures à 20%
    </p>
    <div class="alert-item">
        <div style="display: flex; align-items: center; margin-bottom: 5px;">
            <span style="margin-right: 10px; font-size: 1.2rem; color: #9D1414FF;">⚠️</span>
            <strong>Amina Diallo (SNC2024001)</strong>
        </div>
        <p style="margin: 5px 0 0 0; font-size: 0.9rem; color: #666;">
            Chute de 26.9% détectée entre T1 (14.89) et T2 (10.89)
        </p>
        <p style="margin: 10px 0 0 0; font-size: 0.8rem; color: #999;">
            Contact parent: +228 90 90 90 90
        </p>
    </div>
</div>

<!-- Alerte positive -->
<div class="alert-card positive">
    <div class="alert-header" style="color: #4CAF50;">⬆️ Alertes Intelligentes - IA</div>
    <p style="font-size: 0.9rem; color: #666; margin: 0 0 15px 0;">
        Système d'alerte automatique pour les améliorations de notes supérieures à 20%
    </p>
    <div class="alert-item">
        <div style="display: flex; align-items: center; margin-bottom: 5px;">
            <span style="margin-right: 10px; font-size: 1.2rem; color: #4CAF50;">⬆️</span>
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

        <!-- Élèves Récents -->
        <div class="recent-students">
    <h3>Élèves Récents</h3>
    <p style="font-size: 0.9rem; color: #666; margin: 0 0 15px 0;">
        Liste des derniers élèves inscrits
    </p>

    <div class="student-row">
        <div class="student-info">
            <strong>Amina Diallo</strong> - SNC2024001
            <span class="small-class">
                Classe: 4e A | <i class="fa-solid fa-venus" style="color:#d63384;"></i> Féminin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 01/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Ray Kokoroko</strong> - SNC2024002
            <span class="small-class">
                Classe: Tle D | <i class="fa-solid fa-mars" style="color:#0d6efd;"></i> Masculin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 05/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Arnaud Klanlenou</strong> - SNC2024003
            <span class="small-class">
                Classe: 3e C | <i class="fa-solid fa-mars" style="color:#0d6efd;"></i> Masculin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 10/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Amina Kokodoro</strong> - SNC2025001
            <span class="small-class">
                Classe: 2nde S | <i class="fa-solid fa-venus" style="color:#d63384;"></i> Féminin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 12/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Brice Klanlenou</strong> - SNC2025002
            <span class="small-class">
                Classe: 1ère A4 | <i class="fa-solid fa-mars" style="color:#0d6efd;"></i> Masculin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 15/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Gifty Mensah</strong> - SNC2025003
            <span class="small-class">
                Classe: 6e D | <i class="fa-solid fa-venus" style="color:#d63384;"></i> Féminin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 20/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Samuel Yovo</strong> - SNC2025004
            <span class="small-class">
                Classe: 5e E | <i class="fa-solid fa-mars" style="color:#0d6efd;"></i> Masculin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 25/09/2024</span>
        </div>
    </div>

    <div class="student-row">
        <div class="student-info">
            <strong>Mariam Tchalla</strong> - SNC2025005
            <span class="small-class">
                Classe: Tle A4 | <i class="fa-solid fa-venus" style="color:#d63384;"></i> Féminin
            </span>
        </div>
        <div class="student-meta">
            <span class="small-muted">Inscrit le 28/09/2024</span>
        </div>
    </div>
</div>

</body>
</html>