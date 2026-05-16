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
    <title>Achat direct - ShopLink</title>
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
            <h2 style="text-align: center; font-size: 1.75rem; margin-bottom: 0.5rem;">Achat Direct 🛒</h2>
            <div style="background: #f8fafc; border: 1px solid var(--border-color); border-radius: var(--radius); padding: 1rem; margin-bottom: 2rem; text-align: center;">
                <h3 style="color: var(--text-main); margin-bottom: 0.5rem; font-size: 1.25rem;"><?= htmlspecialchars($produit['nom']); ?></h3>
                <div style="font-size: 1.5rem; font-weight: bold; color: var(--primary);"><?= number_format((float)$produit['prix'], 2); ?> DT</div>
            </div>

            <form method="POST" action="/ShopLink/app/controllers/ClientController.php">
                <input type="hidden" name="produit_id" value="<?= (int)$produit['id']; ?>">
                <input type="hidden" name="nom" value="<?= htmlspecialchars($_SESSION['user']['nom']); ?>">

                <h4 style="margin-bottom: 1rem; color: var(--text-muted); border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Informations Client</h4>

                <div class="form-group">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['prenom'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['phone'] ?? ''); ?>" placeholder="Ex: 55 123 456" required>
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
                    <textarea name="adresse" class="form-control" rows="3" placeholder="Rue, numéro de bâtiment, code postal..." required><?= htmlspecialchars($_SESSION['user']['adresse'] ?? ''); ?></textarea>
                </div>

                <h4 style="margin: 1.5rem 0 1rem; color: var(--text-muted); border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Détails d'Achat</h4>

                <div class="form-group">
                    <label class="form-label">Quantité</label>
                    <input type="number" name="quantite" class="form-control" value="1" min="1" max="<?= (int)$produit['stock']; ?>" required>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="/ShopLink/public/index.php?page=produit_detail&id=<?= (int)$produit['id']; ?>" class="btn btn-secondary" style="flex: 1; text-align: center;">Annuler</a>
                    <button type="submit" name="commander" class="btn btn-primary" style="flex: 2; font-size: 1.1rem;">
                        Confirmer l'achat ✅
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>