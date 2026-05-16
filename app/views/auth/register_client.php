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
    <title>Inscription Client - ShopLink</title>
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
        <div class="card auth-card" style="max-width: 450px;">
            <h2 class="auth-title">Inscription Client</h2>

            <form method="POST" action="../app/controllers/AuthController.php">
                <input type="hidden" name="role" value="client">

                <div class="form-group">
                    <label class="form-label">Nom Complet</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Adresse Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Ville</label>
                    <select name="ville" class="form-control" required>
                        <option value="">-- Choisir une ville --</option>
                        <?php foreach ($tunisianCities as $city) { ?>
                            <option value="<?= htmlspecialchars($city); ?>"><?= htmlspecialchars($city); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" name="register" class="btn btn-primary btn-block" style="margin-top: 1.5rem;">
                    Créer mon compte Client
                </button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
                <a href="index.php?page=register_choice">Retour aux choix</a>
            </div>
        </div>
    </div>
</body>
</html>