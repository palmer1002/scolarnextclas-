<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vérifiez votre adresse email</title>
</head>
<body>
    <h2>Bienvenue sur ScolarNextClas!</h2>
    <p>Merci de vous être inscrit. Veuillez cliquer sur le bouton ci-dessous pour vérifier votre adresse email :</p>
    
    <p><a href="{{ $verificationUrl }}" style="display: inline-block; padding: 12px 24px; background-color: #170B9D; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">Vérifier l'email</a></p>
    
    <p>Si vous ne pouvez pas cliquer sur le bouton, copiez et collez le lien suivant dans votre navigateur :</p>
    <p>{{ $verificationUrl }}</p>
    
    <p>Si vous n'avez pas créé de compte, aucune action supplémentaire n'est requise.</p>
    
    <p>Cordialement,<br>L'équipe ScolarNextClas</p>
</body>
</html>