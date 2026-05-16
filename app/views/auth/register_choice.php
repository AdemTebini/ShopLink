<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container" style="justify-content: center;">
            <a href="index.php?page=client_home" class="navbar-brand">
                🛒 Shop<span>Link</span>
            </a>
        </div>
    </nav>

    <div class="auth-container">
        <div class="card auth-card" style="max-width: 500px;">
            <h2 class="auth-title">Rejoindre ShopLink</h2>
            <p style="text-align: center; color: var(--text-muted); margin-bottom: 2rem;">Choisissez le type de compte que vous souhaitez créer.</p>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <a href="index.php?page=register_client" class="btn btn-primary btn-block" style="padding: 1rem; font-size: 1.1rem;">
                    👤 Acheter des produits (Client)
                </a>
                
                <a href="index.php?page=register_vendeur" class="btn btn-secondary btn-block" style="padding: 1rem; font-size: 1.1rem; border: 1px solid var(--border-color);">
                    🏪 Vendre des produits (Vendeur)
                </a>
                
                <a href="index.php?page=register_livreur" class="btn btn-secondary btn-block" style="padding: 1rem; font-size: 1.1rem; border: 1px solid var(--border-color);">
                    🚚 Devenir Livreur
                </a>
            </div>

            <div style="margin-top: 2rem; text-align: center; font-size: 0.9rem;">
                <p style="color: var(--text-muted);">
                    Déjà inscrit ? <a href="index.php?page=login" style="font-weight: 600;">Se connecter</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>