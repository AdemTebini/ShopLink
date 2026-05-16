<?php
include(__DIR__ . "/../../../config/db.php");
if ($_SESSION['user']['role'] != 'admin') exit();

// --- REQUÊTES DE STATISTIQUES ---
// 1. Utilisateurs
$resUsers = $conn->query("
    SELECT 
        COUNT(*) as total_users,
        SUM(CASE WHEN role='client' THEN 1 ELSE 0 END) as total_clients,
        SUM(CASE WHEN role='vendeur' THEN 1 ELSE 0 END) as total_vendeurs,
        SUM(CASE WHEN role='livreur' THEN 1 ELSE 0 END) as total_livreurs
    FROM users
");
$statsUsers = $resUsers->fetch_assoc();

// 2. Produits
$resProduits = $conn->query("SELECT COUNT(*) as total_produits FROM produits");
$statsProduits = $resProduits->fetch_assoc();

// 3. Commandes & Chiffre d'Affaires
$resCommandes = $conn->query("
    SELECT 
        COUNT(c.id) as total_commandes,
        SUM(CASE WHEN c.statut='livree' THEN 1 ELSE 0 END) as commandes_livrees,
        SUM(CASE WHEN c.statut='livree' THEN (p.prix * c.quantite) ELSE 0 END) as chiffre_affaires
    FROM commandes c
    JOIN produits p ON c.produit_id = p.id
");
$statsCommandes = $resCommandes->fetch_assoc();

// 4. Dernières commandes (5)
$recentOrders = $conn->query("
    SELECT c.id, c.statut, c.created_at, c.quantite, p.nom as produit_nom, p.prix, u.nom as client_nom, v.nom as vendeur_nom
    FROM commandes c
    JOIN produits p ON c.produit_id = p.id
    JOIN users u ON c.client_id = u.id
    JOIN users v ON c.vendeur_id = v.id
    ORDER BY c.created_at DESC
    LIMIT 5
");

// Helpers
function formatMoney($amount) {
    return number_format((float)($amount ?? 0), 2, ',', ' ') . ' DT';
}

function getStatusBadge($statut) {
    switch ($statut) {
        case 'en attente': return '<span class="badge badge-pending">En attente</span>';
        case 'en attente livraison': return '<span class="badge badge-info" style="background:#e0f2fe; color:#0369a1;">Prêt livraison</span>';
        case 'en livraison': return '<span class="badge badge-info" style="background:#fef08a; color:#854d0e;">En livraison</span>';
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
    <title>Administration - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .dashboard-grid { display: grid; grid-template-columns: 250px 1fr; gap: 2rem; min-height: calc(100vh - 64px); }
        .sidebar { background: var(--surface); border-right: 1px solid var(--border-color); padding: 2rem 1rem; }
        .sidebar-menu { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; }
        .sidebar-menu a { display: block; padding: 0.75rem 1rem; border-radius: var(--radius); color: var(--text-main); font-weight: 500; transition: all 0.2s; }
        .sidebar-menu a:hover { background: #f1f5f9; color: var(--primary); }
        .dashboard-content { padding: 2rem; }
        
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .kpi-card { background: var(--surface); padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow-sm); border-left: 4px solid var(--primary); }
        .kpi-card h3 { color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; margin-bottom: 0.5rem; }
        .kpi-card .value { font-size: 1.8rem; font-weight: bold; color: var(--text-main); }
        .kpi-card.success { border-left-color: var(--success); }
        .kpi-card.warning { border-left-color: var(--secondary); }
        
        @media (max-width: 768px) { .dashboard-grid { grid-template-columns: 1fr; } .sidebar { border-right: none; border-bottom: 1px solid var(--border-color); } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=admin_dashboard" class="navbar-brand">⚙️ Shop<span>Link</span> <small style="color: var(--danger); font-size: 0.9rem;">Admin</small></a>
            <div class="navbar-nav">
                <span class="nav-user">Bonjour, <?= htmlspecialchars($_SESSION['user']['nom']); ?></span>
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-grid">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php?page=admin_dashboard" style="background: #fee2e2; color: var(--danger);">📊 Vue d'ensemble</a></li>
                <li><a href="index.php?page=users">👥 Utilisateurs</a></li>
                <li><a href="index.php?page=admin_produits">📦 Produits</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Tableau de Bord Administrateur</h1>
            </div>

            <!-- STATISTIQUES KPI -->
            <div class="kpi-grid">
                <div class="kpi-card success">
                    <h3>Chiffre d'Affaires Global</h3>
                    <div class="value"><?= formatMoney($statsCommandes['chiffre_affaires']); ?></div>
                </div>
                <div class="kpi-card">
                    <h3>Total Utilisateurs</h3>
                    <div class="value"><?= (int)$statsUsers['total_users']; ?></div>
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">
                        <?= (int)$statsUsers['total_clients']; ?> Clients | <?= (int)$statsUsers['total_vendeurs']; ?> Vendeurs
                    </div>
                </div>
                <div class="kpi-card warning">
                    <h3>Produits en Ligne</h3>
                    <div class="value"><?= (int)$statsProduits['total_produits']; ?></div>
                </div>
                <div class="kpi-card">
                    <h3>Commandes Passées</h3>
                    <div class="value"><?= (int)$statsCommandes['total_commandes']; ?></div>
                    <div style="font-size: 0.8rem; color: var(--success); margin-top: 0.5rem; font-weight: bold;">
                        <?= (int)$statsCommandes['commandes_livrees']; ?> livrées
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
                
                <!-- SECTION 1 : UTILISATEURS EN ATTENTE -->
                <section>
                    <h2 style="font-size: 1.25rem; margin-bottom: 1rem; border-bottom: 2px solid var(--danger); padding-bottom: 0.5rem; display: inline-block;">Demandes d'inscription en attente</h2>

                    <?php
                    $sql = "SELECT * FROM users WHERE status='pending' AND (role='vendeur' OR role='livreur')";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0):
                        while ($user = $result->fetch_assoc()):
                    ?>
                        <div class="card" style="margin-bottom: 1rem; border-left: 4px solid var(--danger); padding: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                                <div>
                                    <h3 style="margin: 0 0 0.25rem 0; font-size: 1.1rem;">
                                        <?= htmlspecialchars($user['nom']); ?>
                                        <span class="badge badge-pending" style="margin-left: 0.5rem;"><?= htmlspecialchars($user['role']); ?></span>
                                    </h3>
                                    <div style="color: var(--text-muted); font-size: 0.9rem;">
                                        <?= htmlspecialchars($user['email']); ?> | Ville: <?= htmlspecialchars($user['ville'] ?? '-'); ?>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="../../app/controllers/AdminController.php?approve=<?= $user['id'] ?>" class="btn btn-success" style="padding: 0.5rem 1rem;">Approuver</a>
                                    <a href="../../app/controllers/AdminController.php?reject=<?= $user['id'] ?>" class="btn btn-danger" style="padding: 0.5rem 1rem;" onclick="return confirm('Refuser cette inscription ?');">Refuser</a>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <div class="card" style="text-align: center; padding: 2rem;">
                            <p style="color: var(--text-muted); font-size: 1rem;">Aucune demande d'inscription en attente.</p>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- SECTION 2 : DERNIÈRES COMMANDES -->
                <section>
                    <h2 style="font-size: 1.25rem; margin-bottom: 1rem; border-bottom: 2px solid var(--primary); padding-bottom: 0.5rem; display: inline-block;">Commandes Récentes</h2>
                    
                    <div class="card" style="padding: 0; overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produit</th>
                                    <th>Client</th>
                                    <th>Vendeur</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($recentOrders && $recentOrders->num_rows > 0): ?>
                                    <?php while ($ord = $recentOrders->fetch_assoc()): ?>
                                        <tr>
                                            <td>#<?= $ord['id'] ?></td>
                                            <td><?= htmlspecialchars($ord['produit_nom']) ?> (x<?= $ord['quantite'] ?>)</td>
                                            <td><?= htmlspecialchars($ord['client_nom']) ?></td>
                                            <td><?= htmlspecialchars($ord['vendeur_nom']) ?></td>
                                            <td style="font-weight: bold;"><?= formatMoney($ord['prix'] * $ord['quantite']) ?></td>
                                            <td><?= getStatusBadge($ord['statut']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center;">Aucune commande récente.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </main>
    </div>
</body>
</html>