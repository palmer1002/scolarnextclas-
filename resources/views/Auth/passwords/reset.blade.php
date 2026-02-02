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

        .input-group .form-control {
            border-radius: 8px 0 0 8px;
            margin-bottom: 0;
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
        <p class="text-muted mb-4">Définir un nouveau mot de passe</p>

        @if($errors->any())
            <div class="alert alert-danger shadow-sm mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control bg-light" id="email" name="email" 
                       value="{{ $email ?? old('email') }}" required readonly>
            </div>
            
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required autofocus placeholder="Minimum 8 caractères">
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password" style="border-radius: 0 8px 8px 0; border: 1px solid #ddd; border-left: none;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="mb-3 text-start">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Répétez le mot de passe">
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-target="password_confirmation" style="border-radius: 0 8px 8px 0; border: 1px solid #ddd; border-left: none;">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="btn btn-reset mt-2">
                <i class="fas fa-check-circle me-1"></i> Valider le nouveau mot de passe
            </button>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i> Retour à la connexion
            </a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>