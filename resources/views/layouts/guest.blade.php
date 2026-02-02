<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ScolarNextClas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .radius-10 { border-radius: 10px; }
        .text-primary { color: #170B9DFF !important; }
        .btn-primary { background-color: #170B9DFF; border-color: #170B9DFF; }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}" style="font-size: 1.5rem; letter-spacing: -1px;">
                @include('partials.login-logo', ['class' => 'me-2', 'width' => '55px', 'height' => '55px'])
                ScolarNextClas
            </a>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Se connecter</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
