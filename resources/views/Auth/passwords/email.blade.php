<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe - ScolarNextClas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2313d4 0%, #7d6ae8 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .password-reset-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
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
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .form-control:focus {
            border-color: #170B9D;
            box-shadow: 0 0 0 0.2rem rgba(23, 11, 157, 0.25);
        }
        .btn-reset {
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
        .btn-reset:hover {
            background: #120890;
            transform: translateY(-2px);
        }
        .alert {
            border-radius: 8px;
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

        .password-reset-container {
    width: 350px;
    margin: 80px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    text-align: center; /* centre tout le contenu */
}

.logo img {
    width: 90px;   /* taille du logo */
    height: 90px;
    margin-bottom: 15px; /* espace entre logo et titre */
}

    </style>
</head>
<body>
    <div class="password-reset-container"> <div class="logo"> <img src="{{ asset('images/logo.png') }}" alt="Logo ScolarNextClas"> </div>
            <h2>ScolarNextClas</h2>
            <p class="text-muted">Réinitialisation du mot de passe</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn btn-reset">
                <i class="fas fa-paper-plane"></i> Envoyer le lien de réinitialisation
            </button>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i> Retour à la connexion
            </a>
        </div>
    </div>
</body>
</html>