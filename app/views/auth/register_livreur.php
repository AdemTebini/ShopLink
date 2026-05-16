<?php
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
    <title>Inscription Livreur - ShopLink</title>
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

    <div class="auth-container" style="padding: 2rem 1rem;">
        <div class="card auth-card" style="max-width: 500px;">
            <h2 class="auth-title">Devenir Livreur</h2>
            <div class="alert alert-info" style="font-size: 0.85rem; padding: 0.75rem;">
                ℹ️ Votre compte devra être validé par un administrateur avant de recevoir des courses.
            </div>

            <form method="POST" action="../app/controllers/AuthController.php">
                <input type="hidden" name="role" value="livreur">

                <div class="form-group">
                    <label class="form-label">Nom Complet</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="detail-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0;">
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Numéro CIN</label>
                        <input type="text" name="cin" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ville de Livraison</label>
                    <select name="ville" class="form-control" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($tunisianCities as $city) { ?>
                            <option value="<?= htmlspecialchars($city); ?>"><?= htmlspecialchars($city); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" name="register" class="btn btn-primary btn-block" style="margin-top: 1rem;">
                    Soumettre ma demande
                </button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
                <a href="index.php?page=register_choice">Retour aux choix</a>
            </div>
        </div>
    </div>
</body>
</html>