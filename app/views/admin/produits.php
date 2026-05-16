<?php
if ($_SESSION['user']['role'] != 'admin') exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produits - Admin ShopLink</title>
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
            <a href="index.php?page=admin_dashboard" class="navbar-brand">⚙️ Shop<span>Link</span> <small style="color: var(--danger); font-size: 0.9rem;">Admin</small></a>
            <div class="navbar-nav">
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-grid">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="index.php?page=admin_dashboard">📊 Vue d'ensemble</a></li>
                <li><a href="index.php?page=users">👥 Utilisateurs</a></li>
                <li><a href="index.php?page=produits" style="background: #fee2e2; color: var(--danger);">📦 Produits</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Gestion des Produits 🛍️</h1>
            </div>

            <div class="card" style="padding: 0; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Image</th>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Vendeur</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($p = $produits->fetch_assoc()) { ?>
                                <tr>
                                    <td>
                                        <?php $image = $p['image'] ? "/ShopLink/images/" . htmlspecialchars($p['image']) : "/ShopLink/images/template.jpg"; ?>
                                        <img src="<?= $image; ?>" alt="Image produit" style="width: 50px; height: 50px; object-fit: contain; background: #fff; border: 1px solid var(--border-color); border-radius: 4px;">
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;"><?= htmlspecialchars($p['nom']); ?></div>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">ID: <?= $p['id']; ?></div>
                                    </td>
                                    <td style="font-weight: 700; color: var(--primary);"><?= number_format((float)$p['prix'], 2); ?> DT</td>
                                    <td><?= htmlspecialchars($p['vendeur_nom']); ?></td>
                                    <td style="text-align: right;">
                                        <a onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce produit ?')"
                                           href="/ShopLink/public/index.php?page=admin_produits&delete_produit=<?= $p['id']; ?>"
                                           class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                            Supprimer 🗑️
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>