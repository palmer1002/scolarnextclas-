<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScolarNextClas')</title>
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
            <li class="{{ request()->is('/') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-chart-pie" style="margin-right: 10px;"></i> Tableau de bord
                </a>
            </li>
            
            @if(Auth::user()->role === 'enseignant')
            <li class="{{ request()->is('enseignants*') ? 'active' : '' }}">
                <a href="{{ route('enseignants.index') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-chalkboard-teacher" style="margin-right: 10px;"></i> Mes cours
                </a>
            </li>
            @endif
            
            @if(Auth::user()->role === 'parent')
            <li class="{{ request()->is('parents*') ? 'active' : '' }}">
                <a href="{{ route('parents.index') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-users" style="margin-right: 10px;"></i> Mes enfants
                </a>
            </li>
            @endif
            
            @if(Auth::user()->role === 'eleve')
            <li class="{{ request()->is('eleves*') ? 'active' : '' }}">
                <a href="{{ route('eleves.index') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-user-graduate" style="margin-right: 10px;"></i> Mon profil
                </a>
            </li>
            @endif
            
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   style="color: white; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <!-- Navbar -->
        <div class="navbar">
            <div>
                <h1>@yield('page-title', 'Tableau de bord')</h1>
                <p>Connecté en tant que {{ ucfirst(Auth::user()->role) }}</p>
            </div>
            <div style="display: flex; gap: 15px;">
                <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                    Année 2025-2026
                </span>
            </div>
        </div>

        <!-- Contenu -->
        <div class="mt-4">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>