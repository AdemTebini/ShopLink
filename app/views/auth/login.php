<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar simplifiée -->
    <nav class="navbar">
        <div class="navbar-container" style="justify-content: center;">
            <a href="index.php?page=client_home" class="navbar-brand">
                🛒 Shop<span>Link</span>
            </a>
        </div>
    </nav>

    <div class="auth-container">
        <div class="card auth-card">
            <h2 class="auth-title">Connexion</h2>

            <form method="POST" action="/ShopLink/app/controllers/AuthController.php" autocomplete="off">
                <div class="form-group">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nom@exemple.com" required autocomplete="off">
                </div>
                
                <div class="form-group">
                    <label class="form-label">Mot de Passe</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="new-password">
                </div>

                <button type="submit" name="login" class="btn btn-primary btn-block" style="margin-top: 1rem;">
                    Se connecter
                </button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
                <p style="color: var(--text-muted);">
                    Nouveau sur ShopLink ? 
                    <a href="index.php?page=register_choice" style="font-weight: 600;">Créer un compte</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>