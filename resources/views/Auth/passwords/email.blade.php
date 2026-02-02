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
            background: #f4f4f4;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .password-reset-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            margin: 40px auto;
            text-align: center;
        }

        h2 {
            color: #170B9D;
            font-weight: bold;
            margin-bottom: 10px;
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
            text-align: left;
        }

        .back-to-login {
            margin-top: 25px;
        }

        .back-to-login a {
            color: #170B9D;
            text-decoration: none;
            font-weight: 500;
        }

        .back-to-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="password-reset-container">
        <div class="logo d-flex align-items-center justify-content-center mb-3">
            @include('partials.login-logo', ['class' => 'me-3', 'width' => '70px', 'height' => '70px'])
            <div class="text-start">
                <h2 style="margin:0;color:#170B9D;font-weight: 800;font-size: 1.8rem;letter-spacing: -1px;">ScolarNextClas</h2>
            </div>
        </div>
        <p class="text-muted mb-4">Réinitialisation du mot de passe</p>

        @if(session('status'))
            <div class="alert alert-success mt-3 shadow-sm">
                <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mt-3 shadow-sm">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Votre adresse email</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="{{ old('email') }}" required autofocus placeholder="exemple@ecole.com">
                <div class="form-text small">Un lien de réinitialisation vous sera envoyé par email.</div>
            </div>
            <button type="submit" class="btn btn-reset mt-3">
                <i class="fas fa-paper-plane me-1"></i> Envoyer le lien
            </button>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i> Retour à la connexion
            </a>
        </div>
    </div>
</body>
</html>