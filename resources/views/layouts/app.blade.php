<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScolarNextClas')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
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
        .sidebar .logo h3 {
            margin: 0;
            font-size: 1.5rem;
            color: white;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
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
        .sidebar li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar li a i {
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
            <span>$</span>
            <h3>ScolarNextClas</h3>
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
