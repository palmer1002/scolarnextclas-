<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ScolarNextClas</title>
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

        .login-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            margin: 40px auto;
            text-align: center;
        }

        .logo img {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
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
        }

        .form-control:focus {
            border-color: #170B9D;
            box-shadow: 0 0 0 0.2rem rgba(23, 11, 157, 0.25);
        }

        .btn-login {
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

        .btn-login:hover {
            background: #120890;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
            text-align: left;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo d-flex align-items-center justify-content-center mb-3">
            @include('partials.login-logo', ['class' => 'me-3', 'width' => '80px', 'height' => '80px'])
            <div class="text-start">
                <h2 style="margin:0;color:#170B9D;font-weight: 800;font-size: 2.2rem;letter-spacing: -1.5px;">ScolarNextClas</h2>
            </div>
        </div>
        <p class="text-muted">Plateforme de Gestion Scolaire</p>

        @if (session('status'))
            <div class="alert alert-success mt-3 shadow-sm">
                <i class="fas fa-check-circle me-1"></i> {{ session('status') }}
            </div>
        @endif

        <div id="error-message" class="alert alert-danger" style="display: none;"></div>

        <form method="POST" action="/login" id="login-form">
            @csrf
            <div class="mb-4 text-start">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control mb-0 @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="votre@email.com">
                @error('email')
                    <div class="invalid-feedback d-block">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-4 text-start">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <input type="password" class="form-control mb-0 @error('password') is-invalid @enderror" 
                           id="password" name="password" required placeholder="••••••••">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border-radius: 0 8px 8px 0; border: 1px solid #ddd; border-left: none; background: #fff;">
                        <i class="fas fa-eye" id="eyeIcon" style="color: #666;"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 text-start">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="acceptPrivacy" required>
                    <label class="form-check-label text-muted" for="acceptPrivacy" style="font-size: 0.85rem;">
                        J'ai lu et j'accepte la <a href="{{ route('privacy') }}" target="_blank" style="color: #170B9D; font-weight: 500;">politique de confidentialité</a> <i class="fa-solid fa-circle-check text-success"></i>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-muted">
                <small>Mot de passe oublié ?</small>
            </a>
        </div>

        <div class="text-center mt-4">

            <a href="{{ route('privacy') }}" class="text-muted"><small>Politique de confidentialité</small></a>
        </div>
    </div>

    <script>
        // Toggle Password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Gestion basique du formulaire
        document.getElementById('login-form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const passwordVal = document.getElementById('password').value;
            const acceptPrivacy = document.getElementById('acceptPrivacy').checked;
            const errorDiv = document.getElementById('error-message');
            
            // Réinitialiser les erreurs
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            
            // Validation basique
            if (!email || !passwordVal) {
                e.preventDefault(); 
                errorDiv.textContent = 'Veuillez remplir tous les champs.';
                errorDiv.style.display = 'block';
                return;
            }

            if (!acceptPrivacy) {
                e.preventDefault();
                errorDiv.textContent = 'Vous devez accepter la politique de confidentialité pour vous connecter.';
                errorDiv.style.display = 'block';
                return;
            }
        });
    </script>
</body>
</html>