<?php
if ($_SESSION['user']['role'] != 'vendeur') exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit - ShopLink</title>
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
                <li><a href="index.php?page=add_produit" style="background: #e0f2fe; color: var(--secondary);">➕ Ajouter un Produit</a></li>
                <li><a href="/ShopLink/public/index.php?page=mes_produits&action=mes_produits">📦 Mes Produits</a></li>
                <li><a href="index.php?page=commandes">🧾 Commandes reçues</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Ajouter un Produit 📦</h1>
            </div>

            <div class="card" style="max-width: 600px;">
                <form method="POST" action="/ShopLink/app/controllers/ProduitController.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label">Nom du produit</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>

                    <div class="detail-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0;">
                        <div class="form-group">
                            <label class="form-label">Prix (DT)</label>
                            <input type="number" step="0.01" name="prix" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock disponible</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie_id" class="form-control" required>
                            <option value="">Sélectionnez une catégorie</option>
                            <?php
                            include(__DIR__ . "/../../../config/db.php");
                            $categories = $conn->query("SELECT * FROM categories");
                            while ($cat = $categories->fetch_assoc()):
                            ?>
                                <option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['nom']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description détaillée</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group" style="padding: 1rem; border: 2px dashed var(--border-color); border-radius: var(--radius); text-align: center; margin-bottom: 2rem;">
                        <label class="form-label">Image du produit</label>
                        <input type="file" name="image" required style="margin-top: 0.5rem;">
                    </div>

                    <button type="submit" name="add_product" class="btn btn-primary btn-block">Publier le produit</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>