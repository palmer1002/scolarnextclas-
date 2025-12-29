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
            margin-bottom: 20px;
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
        <div class="logo">
            <!-- Remplacez le chemin par le vrai chemin de votre logo -->
            <img src="/images/logo.png" alt="Logo ScolarNextClas">
        </div>
        <h2>ScolarNextClas</h2>
        <p class="text-muted">Plateforme de Gestion Scolaire</p>

        <div id="error-message" class="alert alert-danger" style="display: none;"></div>

        <form method="POST" action="/login" id="login-form">
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
        
        <div class="text-center mt-3">
            <a href="/forgot-password" class="text-muted">
                <small>Mot de passe oublié ?</small>
            </a>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted">Année scolaire 2025-2026</p>
        </div>
    </div>

    <script>
        // Gestion basique du formulaire
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorDiv = document.getElementById('error-message');
            
            // Réinitialiser les erreurs
            errorDiv.style.display = 'none';
            errorDiv.textContent = '';
            
            // Validation basique
            if (!email || !password) {
                errorDiv.textContent = 'Veuillez remplir tous les champs.';
                errorDiv.style.display = 'block';
                return;
            }
            
            // Ici, vous ajouteriez l'appel AJAX à votre backend
            // Pour l'instant, on simule juste l'envoi
            console.log('Tentative de connexion:', { email, password });
            
            // Envoyer le formulaire normalement (sans AJAX)
            this.submit();
        });
    </script>
</body>
</html>