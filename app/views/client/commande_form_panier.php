<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$tunisianCities = [
       'Tunis', 'Ariana', 'Ben Arous', 'Manouba', 'Nabeul', 'Zaghouan',
       'Bizerte', 'Beja', 'Jendouba', 'Kef', 'Siliana', 'Sousse',
       'Monastir', 'Mahdia', 'Kairouan', 'Kasserine', 'Sidi Bouzid',
       'Sfax', 'Gabes', 'Medenine', 'Tataouine', 'Gafsa', 'Tozeur', 'Kebili'
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraison - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=client_home" class="navbar-brand">
                🛒 Shop<span>Link</span>
            </a>
            <div class="navbar-nav">
                <a href="/ShopLink/public/index.php?page=client_commandes" class="nav-user">📦 Mes Commandes</a>
                <a href="/ShopLink/public/index.php?page=panier" class="nav-user">🛒 Panier</a>
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 600px; margin-top: 3rem;">
        <div class="card">
            <h2 style="margin-bottom: 2rem; text-align: center; font-size: 1.75rem;">Informations de livraison 📦</h2>

            <form method="POST" action="/ShopLink/app/controllers/CommandeController.php">
                <input type="hidden" name="nom" value="<?= htmlspecialchars($_SESSION['user']['nom'] ?? ''); ?>">

                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" placeholder="Votre prénom" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control" placeholder="Ex: 55 123 456" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Ville de livraison</label>
                    <select name="ville" class="form-control" required>
                        <option value="">-- Choisir une ville --</option>
                        <?php foreach ($tunisianCities as $city) { ?>
                                <option value="<?= htmlspecialchars($city); ?>" <?= (($_SESSION['user']['ville'] ?? '') === $city) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($city); ?>
                                </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse détaillée</label>
                    <textarea name="adresse" class="form-control" rows="3" placeholder="Rue, numéro de bâtiment, code postal..." required></textarea>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="/ShopLink/public/index.php?page=panier" class="btn btn-secondary" style="flex: 1; text-align: center;">Retour au panier</a>
                    <button type="submit" name="valider_commande" class="btn btn-primary" style="flex: 2; font-size: 1.1rem;">
                        Confirmer Commande ✅
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>