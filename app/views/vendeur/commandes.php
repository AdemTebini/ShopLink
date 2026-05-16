<?php
if ($_SESSION['user']['role'] != 'vendeur') exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes reçues - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .dashboard-grid { display: grid; grid-template-columns: 250px 1fr; gap: 2rem; min-height: calc(100vh - 64px); }
        .sidebar { background: var(--surface); border-right: 1px solid var(--border-color); padding: 2rem 1rem; }
        .sidebar-menu { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; }
        .sidebar-menu a { display: block; padding: 0.75rem 1rem; border-radius: var(--radius); color: var(--text-main); font-weight: 500; transition: all 0.2s; }
        .sidebar-menu a:hover { background: #f1f5f9; color: var(--primary); }
        .dashboard-content { padding: 2rem; }
        @media (max-width: 768px) { .dashboard-grid { grid-template-columns: 1fr; } .sidebar { border-right: none; border-bottom: 1px solid var(--border-color); } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=vendeur_dashboard" class="navbar-brand">🏪 Shop<span>Link</span></a>
            <div class="navbar-nav">
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-grid">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php?page=vendeur_dashboard">📊 Tableau de bord</a></li>
                <li><a href="index.php?page=add_produit">➕ Ajouter un Produit</a></li>
                <li><a href="/ShopLink/public/index.php?page=mes_produits&action=mes_produits">📦 Mes Produits</a></li>
                <li><a href="index.php?page=commandes" style="background: #e0f2fe; color: var(--secondary);">🧾 Commandes reçues</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Commandes reçues 🧾</h1>
            </div>

            <?php
            if (!isset($commandes) || !$commandes) {
                echo '<div class="card" style="text-align:center; padding: 3rem;"><p>Vous n\'avez aucune commande pour le moment.</p></div>';
                return;
            }

            $commandesRows = $commandes->fetch_all(MYSQLI_ASSOC);
            if (count($commandesRows) === 0) {
                echo '<div class="card" style="text-align:center; padding: 3rem;"><p>Vous n\'avez aucune commande pour le moment.</p></div>';
                return;
            }
            ?>

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php foreach ($commandesRows as $cmd) { ?>
                <div class="card" style="padding: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0; font-size: 1.25rem;">Commande #<?= $cmd['id']; ?></h3>
                        <?php
                        $badgeClass = 'badge-info';
                        if ($cmd['statut'] === 'en attente') $badgeClass = 'badge-pending';
                        if ($cmd['statut'] === 'livree') $badgeClass = 'badge-success';
                        if ($cmd['statut'] === 'refusee') $badgeClass = 'badge-danger';
                        ?>
                        <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($cmd['statut']); ?></span>
                    </div>
                    
                    <div class="detail-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.95rem; margin-bottom: 1.5rem;">
                        <div style="background: #f8fafc; padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5rem;">Client</div>
                            <strong><?= htmlspecialchars($cmd['client_nom']); ?></strong><br>
                            📞 <?= htmlspecialchars($cmd['phone'] ?? ''); ?><br>
                            📍 <?= htmlspecialchars($cmd['ville'] ?? ''); ?>
                        </div>
                        <div style="background: #f8fafc; padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border-color);">
                            <div style="color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5rem;">Livraison</div>
                            <?php if (!empty($cmd['livreur_nom'])): ?>
                                <strong style="color: var(--success);">✓ <?= htmlspecialchars($cmd['livreur_nom']); ?></strong> assigné
                            <?php else: ?>
                                <strong style="color: var(--text-muted); font-style: italic;">En attente de livreur</strong>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($cmd['statut'] === 'en attente') { ?>
                        <form method="POST" action="/ShopLink/app/controllers/ProduitController.php">
                            <input type="hidden" name="commande_id" value="<?= $cmd['id']; ?>">
                            <button name="confirm_commande" class="btn btn-primary">Confirmer pour livraison</button>
                        </form>
                    <?php } ?>
                </div>
            <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>