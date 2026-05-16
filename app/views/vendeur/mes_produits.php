<?php
if ($_SESSION['user']['role'] != 'vendeur') exit();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Produits - ShopLink</title>
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
                <li><a href="/ShopLink/public/index.php?page=mes_produits&action=mes_produits" style="background: #e0f2fe; color: var(--secondary);">📦 Mes Produits</a></li>
                <li><a href="index.php?page=commandes">🧾 Commandes reçues</a></li>
            </ul>
        </aside>

        <main class="dashboard-content">
            <div class="page-header">
                <h1 class="page-title">Mes Produits 📦</h1>
                <a href="index.php?page=add_produit" class="btn btn-primary">Ajouter un produit</a>
            </div>

            <?php
            if (!isset($result) || !$result || $result->num_rows === 0) {
                echo '<div class="card" style="text-align:center; padding: 3rem;"><p>Vous n\'avez ajouté aucun produit.</p></div>';
                return;
            }
            $produits = $result->fetch_all(MYSQLI_ASSOC);
            ?>

            <div class="product-grid">
                <?php foreach ($produits as $row) { ?>
                    <article class="card" style="padding: 1rem; display: flex; flex-direction: column;">
                        <?php $image = $row['image'] ? "/ShopLink/images/" . htmlspecialchars($row['image']) : "/ShopLink/images/template.jpg"; ?>
                        <img src="<?= $image; ?>" alt="<?= htmlspecialchars($row['nom']); ?>" style="width:100%; height:150px; object-fit:contain; border-bottom:1px solid var(--border-color); margin-bottom:1rem; padding-bottom:1rem;">
                        
                        <h3 style="font-size:1.1rem; margin-bottom:0.5rem;"><?= htmlspecialchars($row['nom']); ?></h3>
                        <div style="font-weight:bold; color:var(--primary); font-size:1.2rem; margin-bottom:0.5rem;"><?= number_format((float)$row['prix'], 2); ?> DT</div>
                        <p style="color:var(--text-muted); font-size:0.85rem; margin-bottom:1rem; flex-grow:1;"><?= nl2br(htmlspecialchars($row['description'])); ?></p>
                        
                        <hr style="border:0; border-top:1px solid var(--border-color); margin: 1rem 0;">
                        <h4 style="font-size:0.9rem; margin-bottom:0.5rem;">Derniers avis</h4>
                        
                        <div style="font-size:0.85rem; max-height: 150px; overflow-y: auto;">
                            <?php
                            if (isset($conn)) {
                                $resC = $conn->query("
                                    SELECT c.*, u.nom AS client_nom 
                                    FROM commentaires c 
                                    JOIN users u ON c.client_id = u.id 
                                    WHERE c.produit_id = " . (int)$row['id'] . " 
                                    ORDER BY c.created_at DESC LIMIT 3
                                ");
                                if (!$resC || $resC->num_rows == 0) {
                                    echo "<p style='color:var(--text-muted); font-style:italic;'>Aucun avis</p>";
                                } else {
                                    while ($c = $resC->fetch_assoc()) {
                                        echo "<div style='background:#f8fafc; padding:8px; border-radius:4px; margin-bottom:5px;'>";
                                        echo "<strong style='display:block; color:var(--text-main);'>".htmlspecialchars($c['client_nom'])."</strong>";
                                        echo "<span style='color:#f59e0b;'>".str_repeat('⭐', (int)$c['note'])."</span> ";
                                        echo "<p style='margin-top:4px;'>".htmlspecialchars($c['contenu'])."</p>";
                                        echo "</div>";
                                    }
                                }
                            }
                            ?>
                        </div>
                    </article>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>