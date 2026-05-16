<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['user']['role'] != 'vendeur') {
    header("Location: ../../public/index.php?page=login");
    exit();
}

include(__DIR__ . "/../../../config/db.php");

$vendeur_id = (int)$_SESSION['user']['id'];

// --- REQUÊTES DE STATISTIQUES VENDEUR ---

// 1. Produits
$stmtProd = $conn->prepare("SELECT COUNT(*) as total_produits FROM produits WHERE user_id = ?");
$stmtProd->bind_param("i", $vendeur_id);
$stmtProd->execute();
$statsProduits = $stmtProd->get_result()->fetch_assoc();

// 2. Commandes & Chiffre d'Affaires
$stmtCmd = $conn->prepare("
    SELECT 
        COUNT(c.id) as total_commandes,
        SUM(CASE WHEN c.statut='livree' THEN 1 ELSE 0 END) as commandes_livrees,
        SUM(CASE WHEN c.statut='livree' THEN (p.prix * c.quantite) ELSE 0 END) as chiffre_affaires
    FROM commandes c
    JOIN produits p ON c.produit_id = p.id
    WHERE c.vendeur_id = ?
");
$stmtCmd->bind_param("i", $vendeur_id);
$stmtCmd->execute();
$statsCommandes = $stmtCmd->get_result()->fetch_assoc();

// 3. Top Produits Vendus
$stmtTop = $conn->prepare("
    SELECT p.nom, SUM(c.quantite) as total_vendus, SUM(p.prix * c.quantite) as ca_genere
    FROM commandes c
    JOIN produits p ON c.produit_id = p.id
    WHERE c.vendeur_id = ? AND c.statut = 'livree'
    GROUP BY p.id
    ORDER BY total_vendus DESC
    LIMIT 5
");
$stmtTop->bind_param("i", $vendeur_id);
$stmtTop->execute();
$topProducts = $stmtTop->get_result();

// 4. Dernières commandes clients (5)
$stmtRecent = $conn->prepare("
    SELECT c.id, c.statut, c.created_at, c.quantite, p.nom as produit_nom, p.prix, u.nom as client_nom
    FROM commandes c
    JOIN produits p ON c.produit_id = p.id
    JOIN users u ON c.client_id = u.id
    WHERE c.vendeur_id = ?
    ORDER BY c.created_at DESC
    LIMIT 5
");
$stmtRecent->bind_param("i", $vendeur_id);
$stmtRecent->execute();
$recentOrders = $stmtRecent->get_result();

// Helpers
function formatMoney($amount) {
    return number_format((float)($amount ?? 0), 2, ',', ' ') . ' DT';
}

function getStatusBadge($statut) {
    switch ($statut) {
        case 'en attente': return '<span class="badge badge-pending">Nouveau</span>';
        case 'en attente livraison': return '<span class="badge badge-info" style="background:#e0f2fe; color:#0369a1;">Prêt</span>';
        case 'en livraison': return '<span class="badge badge-info" style="background:#fef08a; color:#854d0e;">En route</span>';
        case 'livree': return '<span class="badge badge-success">Livrée</span>';
        default: return '<span class="badge">' . htmlspecialchars($statut) . '</span>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Vendeur - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">

</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=vendeur_dashboard" class="navbar-brand">
                🏪 Shop<span>Link</span> <small style="color: var(--text-muted); font-size: 0.9rem;">Vendeur</small>
            </a>
            <div class="navbar-nav">
                <span class="nav-user">Bonjour, <?= htmlspecialchars($_SESSION['user']['nom']); ?></span>
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-grid">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php?page=vendeur_dashboard" style="background: #e0f2fe; color: var(--secondary);">📊 Tableau de bord</a></li>
                <li><a href="index.php?page=add_produit">➕ Ajouter un Produit</a></li>
                <li><a href="/ShopLink/public/index.php?page=mes_produits&action=mes_produits">📦 Mes Produits</a></li>
                <li><a href="index.php?page=commandes">🧾 Commandes reçues</a></li>
                <li><a href="index.php?page=messages">💬 Messagerie</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <h1 class="page-title" style="margin-bottom: 1.5rem;">Aperçu de la Boutique</h1>
            
            <!-- STATISTIQUES KPI -->
            <div class="kpi-grid">
                <div class="kpi-card primary">
                    <h3>Chiffre d'Affaires</h3>
                    <div class="value"><?= formatMoney($statsCommandes['chiffre_affaires']); ?></div>
                </div>
                <div class="kpi-card">
                    <h3>Produits Actifs</h3>
                    <div class="value"><?= (int)$statsProduits['total_produits']; ?></div>
                </div>
                <div class="kpi-card success">
                    <h3>Total Commandes</h3>
                    <div class="value"><?= (int)$statsCommandes['total_commandes']; ?></div>
                    <div style="font-size: 0.8rem; color: var(--success); margin-top: 0.5rem; font-weight: bold;">
                        <?= (int)$statsCommandes['commandes_livrees']; ?> livrées
                    </div>
                </div>
            </div>

            <div class="content-grid">
                
                <!-- TOP PRODUITS -->
                <section>
                    <h2 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 2px solid var(--primary); padding-bottom: 0.5rem; display: inline-block;">Top Ventes</h2>
                    <div class="card" style="padding: 0;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>CA Généré</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($topProducts && $topProducts->num_rows > 0): ?>
                                    <?php while ($prod = $topProducts->fetch_assoc()): ?>
                                        <tr>
                                            <td><strong><?= htmlspecialchars($prod['nom']) ?></strong></td>
                                            <td><?= (int)$prod['total_vendus'] ?> unités</td>
                                            <td style="color: var(--success); font-weight: bold;"><?= formatMoney($prod['ca_genere']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center;">Aucune vente finalisée pour l'instant.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- DERNIÈRES COMMANDES -->
                <section>
                    <h2 style="font-size: 1.1rem; margin-bottom: 1rem; border-bottom: 2px solid var(--secondary); padding-bottom: 0.5rem; display: inline-block;">Commandes Récentes</h2>
                    <div class="card" style="padding: 0;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Produit</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($recentOrders && $recentOrders->num_rows > 0): ?>
                                    <?php while ($ord = $recentOrders->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <strong><?= htmlspecialchars($ord['client_nom']) ?></strong><br>
                                                <small style="color: var(--text-muted);"><?= date('d/m/Y', strtotime($ord['created_at'])) ?></small>
                                            </td>
                                            <td><?= htmlspecialchars($ord['produit_nom']) ?> (x<?= $ord['quantite'] ?>)</td>
                                            <td><?= getStatusBadge($ord['statut']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" style="text-align: center;">Aucune commande récente.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        
                        <?php if ($recentOrders && $recentOrders->num_rows > 0): ?>
                        <div style="padding: 1rem; text-align: center; border-top: 1px solid var(--border-color);">
                            <a href="index.php?page=commandes" style="color: var(--primary); font-weight: bold; text-decoration: none;">Voir toutes les commandes →</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>

            </div>
        </main>
    </div>
</body>
</html>