<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScolarNextClas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Copiez ici TOUT le CSS de votre sidebar */
        .sidebar {
            width: 250px;
            background-color: #170B9D;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            color: white;
            font-family: Arial, sans-serif;
        }
        /* ... copiez tout le reste du CSS ... */
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
            <li class="{{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}">
                <a href="{{ url('/dashboard') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-chart-pie" style="margin-right: 10px;"></i> Tableau de bord
                </a>
            </li>
            <li class="{{ request()->is('eleves*') ? 'active' : '' }}">
                <a href="{{ url('/eleves') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-user-graduate" style="margin-right: 10px;"></i> Élèves
                </a>
            </li>
            <!-- Ajoutez les autres liens sans route() pour éviter les erreurs -->
            <li>
                <a href="#" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-pen-to-square" style="margin-right: 10px;"></i> Notes
                </a>
            </li>
            <!-- ... autres liens ... -->
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>