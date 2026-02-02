<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScolarNextClas')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .sidebar {
            width: 280px;
            background-color: #170B9D;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            color: white;
            font-family: 'Segoe UI', Arial, sans-serif;
            z-index: 1000;
            overflow-y: auto; /* Permet le scroll sur petits écrans */
        }
        .sidebar .logo {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 20px;
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
        .content {
            margin-left: 280px;
            padding: 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
        }
        /* Mobile adjustment */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .content {
                margin-left: 0;
            }
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-item.active .nav-link {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left: 4px solid #ff6b6b;
            padding-left: 16px; 
        }
        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            @include('partials.login-logo', ['class' => 'me-2', 'width' => '40px', 'height' => '40px'])
            <div>
                <h3 class="mb-0">ScolarNextClas</h3>
            </div>
        </div>

        {{-- Menu dynamique --}}
        @include('layouts.menu')
    </div>

    <!-- Contenu principal -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
