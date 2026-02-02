<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScolarNextClas')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar {
            width: 280px;
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
            padding: 10px 0;
            margin: 0;
        }
        .sidebar li {
            padding: 0;
            margin: 4px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .sidebar li.active {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .sidebar li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .sidebar li:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.08);
            transform: translateX(5px);
        }
        .sidebar li a i {
            margin-right: 12px;
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .sidebar li form button {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .sidebar .border-top {
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .content {
            margin-left: 280px;
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
        .sidebar .logo h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: white;
            line-height: 1.2;
            white-space: nowrap;
        }
        .sidebar .logo .login-logo {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            @include('partials.login-logo', ['class' => 'me-2', 'width' => '50px', 'height' => '50px'])
            <h3 class="mb-0">ScolarNextClas</h3>
        </div>
        <ul>
            <li class="{{ request()->is('/') || request()->is('dashboard*') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-chart-pie"></i> Tableau de bord
                </a>
            </li>
            
            @if(Auth::user()->role === 'enseignant')
            <li class="{{ request()->is('mon-profil*') ? 'active' : '' }}">
                <a href="{{ route('enseignants.profile') }}">
                    <i class="fas fa-chalkboard-teacher"></i> Mon profil
                </a>
            </li>
            @endif
            
            @if(Auth::user()->role === 'parent')
            <li class="{{ request()->is('mon-profil*') ? 'active' : '' }}">
                <a href="{{ route('parents.profile') }}">
                    <i class="fas fa-users"></i> Mon profil
                </a>
            </li>
            @endif
            
            @if(Auth::user()->role === 'eleve')
            <li class="{{ request()->is('mon-profil*') ? 'active' : '' }}">
                <a href="{{ route('eleves.profile') }}">
                    <i class="fas fa-user-graduate"></i> Mon profil
                </a>
            </li>
            @endif
            
            <li class="mt-4 border-top pt-2">
                <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
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