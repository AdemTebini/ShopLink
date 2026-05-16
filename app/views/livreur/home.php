<?php
// Protection si accédé directement
if (!isset($_SESSION['user'])) exit();

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

$tunisianCities = [
    'Tunis', 'Ariana', 'Ben Arous', 'Manouba', 'Nabeul', 'Zaghouan',
    'Bizerte', 'Beja', 'Jendouba', 'Kef', 'Siliana', 'Sousse',
    'Monastir', 'Mahdia', 'Kairouan', 'Kasserine', 'Sidi Bouzid',
    'Sfax', 'Gabes', 'Medenine', 'Tataouine', 'Gafsa', 'Tozeur', 'Kebili'
];

$selected_ville = $selected_ville ?? ($livreur_ville ?? '');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Livreur - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=livreur_dashboard" class="navbar-brand">
                🚚 Shop<span>Link</span> <small style="color: var(--success); font-size: 0.9rem;">Livreur</small>
            </a>
            <div class="navbar-nav">
                <span class="nav-user">Ville : <?= e($livreur_ville); ?></span>
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Tableau de bord des livraisons</h1>
        </div>

        <?php if (!empty($ville_mismatch)): ?>
            <div class="alert alert-error">Vous ne pouvez voir et accepter que les commandes de votre ville (<?= e($livreur_ville); ?>).</div>
        <?php endif; ?>

        <!-- SECTION 1 : LIVRAISONS EN COURS -->
        <section style="margin-bottom: 3rem;">
            <h2 style="margin-bottom: 1rem; border-bottom: 2px solid var(--primary); display: inline-block; padding-bottom: 0.5rem;">Mes Livraisons en Cours</h2>
            <?php 
            $enCoursRows = isset($commandes_en_cours) ? $commandes_en_cours->fetch_all(MYSQLI_ASSOC) : [];
            if (count($enCoursRows) === 0): ?>
                <div class="card" style="text-align: center; color: var(--text-muted);"><p>Vous n'avez aucune livraison en cours.</p></div>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($enCoursRows as $row): ?>
                        <div class="card" style="border-top: 4px solid var(--primary); display: flex; flex-direction: column;">
                            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Commande #<?= $row['id']; ?></h3>
                            <div style="flex-grow: 1;">
                                <p style="margin-bottom: 0.5rem;"><strong>Client:</strong> <?= e($row['client_nom']); ?></p>
                                <p style="margin-bottom: 0.5rem;"><strong>Adresse:</strong> <?= e($row['adresse']); ?>, <span style="font-weight: bold;"><?= e($row['ville']); ?></span></p>
                                <p style="margin-bottom: 1rem; color: var(--primary); font-weight: bold;">📞 <?= e($row['phone']); ?></p>
                            </div>
                            
                            <div style="display: flex; gap: 0.5rem; margin-top: auto;">
                                <a href="index.php?page=livrer&id=<?= $row['id']; ?>" class="btn btn-success" style="flex: 2; padding: 0.5rem;">Livrée ✅</a>
                                <a href="index.php?page=refuser&id=<?= $row['id']; ?>" class="btn btn-danger" style="flex: 1; padding: 0.5rem;" onclick="return confirm('Annuler cette livraison ?');">Annuler</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- SECTION 2 : LIVRAISONS DISPONIBLES -->
        <section style="margin-bottom: 3rem;">
            <h2 style="margin-bottom: 1rem; border-bottom: 2px solid var(--secondary); display: inline-block; padding-bottom: 0.5rem;">Nouvelles Livraisons Disponibles</h2>
            <?php 
            $dispoRows = isset($commandes_disponibles) ? $commandes_disponibles->fetch_all(MYSQLI_ASSOC) : [];
            if (count($dispoRows) === 0): ?>
                <div class="card" style="text-align: center; color: var(--text-muted);"><p>Aucune nouvelle livraison disponible dans votre ville.</p></div>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($dispoRows as $row): ?>
                        <div class="card" style="display: flex; flex-direction: column;">
                            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Commande #<?= $row['id']; ?></h3>
                            <div style="flex-grow: 1;">
                                <p style="margin-bottom: 0.5rem;"><strong>Client:</strong> <?= e($row['client_nom']); ?></p>
                                <p style="margin-bottom: 0.5rem;"><strong>Adresse:</strong> <?= e($row['adresse']); ?>, <span style="font-weight: bold;"><?= e($row['ville']); ?></span></p>
                                <p style="margin-bottom: 1rem; color: var(--primary); font-weight: bold;">📞 <?= e($row['phone']); ?></p>
                            </div>
                            
                            <a href="index.php?page=accepter&id=<?= $row['id']; ?>" class="btn btn-primary btn-block" style="margin-top: auto;">Accepter la livraison</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- SECTION 3 : HISTORIQUE -->
        <section>
            <h2 style="margin-bottom: 1rem; border-bottom: 2px solid var(--border-color); display: inline-block; padding-bottom: 0.5rem; color: var(--text-muted);">Historique des Livraisons</h2>
            <?php 
            $histoRows = isset($commandes_historique) ? $commandes_historique->fetch_all(MYSQLI_ASSOC) : [];
            if (count($histoRows) === 0): ?>
                <div class="card" style="text-align: center; color: var(--text-muted);"><p>Vous n'avez pas encore terminé de livraisons.</p></div>
            <?php else: ?>
                <div class="product-grid">
                    <?php foreach ($histoRows as $row): ?>
                        <div class="card" style="opacity: 0.7; background: #f8fafc;">
                            <h3 style="margin-bottom: 0.5rem; font-size: 1.1rem;">Commande #<?= $row['id']; ?></h3>
                            <p style="margin-bottom: 0.25rem;"><strong>Client:</strong> <?= e($row['client_nom']); ?></p>
                            <p style="margin-bottom: 1rem; font-size: 0.9rem;"><strong>Adresse:</strong> <?= e($row['adresse']); ?>, <?= e($row['ville']); ?></p>
                            <div style="color: var(--success); font-weight: bold;">✓ Livrée</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

    </div>
</body>
</html>
