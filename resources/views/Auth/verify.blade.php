<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de l'email - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #170B9D 0%, #7d6ae8 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verify-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo span {
            background: #170B9D;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .alert {
            border-radius: 8px;
        }
        .btn-verify {
            background: #170B9D;
            color: white;
            padding: 12px;
            border-radius: 8px;
            border: none;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-verify:hover {
            background: #120890;
            transform: translateY(-2px);
        }
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-login a {
            color: #170B9D;
            text-decoration: none;
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="logo">
            <span><i class="fas fa-envelope"></i></span>
            <h2>ScolarNextClas</h2>
            <p class="text-muted">Vérification de l'email</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Avant de continuer, veuillez vérifier votre email pour un lien de vérification.
            Si vous n'avez pas reçu l'email, 
            <a href="{{ route('verification.send') }}" 
               onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                cliquez ici pour en demander un autre
            </a>.
        </div>

        <form id="resend-form" method="POST" action="{{ route('verification.send') }}" class="d-none">
            @csrf
        </form>

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-verify">
                <i class="fas fa-paper-plane"></i> Renvoyer le lien de vérification
            </button>
        </form>

        <div class="back-to-login mt-3">
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </a>
        </div>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</body>
</html>