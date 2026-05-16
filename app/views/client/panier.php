<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . "/../../../config/db.php");

$client_id = $_SESSION['user']['id'];

$panier = $conn->query("
    SELECT p.*,
           pa.quantite,
           (p.prix * pa.quantite) AS total
    FROM panier pa
    JOIN produits p ON pa.produit_id = p.id
    WHERE pa.client_id = $client_id
");

$total_general = 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">
    <style>
        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1.5rem;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-item img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 0.5rem;
        }
        @media (max-width: 640px) {
            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 1rem;
            }
            .cart-item-price {
                grid-column: 1 / -1;
                text-align: right;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=client_home" class="navbar-brand">
                🛒 Shop<span>Link</span>
            </a>
            <div class="navbar-nav">
                <a href="/ShopLink/public/index.php?page=client_commandes" class="nav-user">📦 Mes Commandes</a>
                <a href="/ShopLink/public/index.php?page=panier" class="nav-user" style="color: var(--primary);">🛒 Panier</a>
                <a href="/ShopLink/app/controllers/AuthController.php?logout=1">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Mon Panier 🛒</h1>
            <a href="index.php?page=client_home" class="btn btn-secondary">Continuer mes achats</a>
        </div>

        <?php if ($panier->num_rows === 0): ?>
            <div class="card" style="text-align: center; padding: 4rem 1rem;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🛍️</div>
                <h2 style="margin-bottom: 1rem;">Votre panier est vide !</h2>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Parcourez nos catégories et découvrez nos meilleures offres.</p>
                <a href="index.php?page=client_home" class="btn btn-primary">Commencer mes achats</a>
            </div>
        <?php else: ?>
            <div class="detail-grid" style="grid-template-columns: 2fr 1fr;">
                <div class="card" style="padding: 0;">
                    <?php while ($item = $panier->fetch_assoc()): ?>
                        <div class="cart-item">
                            <?php $image = $item['image'] ? "/ShopLink/images/" . htmlspecialchars($item['image']) : "/ShopLink/images/template.jpg"; ?>
                            <img src="<?= $image; ?>" alt="<?= htmlspecialchars($item['nom']); ?>">
                            
                            <div>
                                <h3 style="font-size: 1.1rem; margin-bottom: 0.25rem;"><?= htmlspecialchars($item['nom']); ?></h3>
                                <div style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.5rem;">
                                    Prix unitaire : <?= number_format((float)$item['prix'], 2); ?> DT
                                </div>
                                <div>
                                    <span style="font-weight: 600;">Quantité : <?= $item['quantite']; ?></span>
                                </div>
                            </div>

                            <div class="cart-item-price" style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">
                                <?= number_format((float)$item['total'], 2); ?> DT
                            </div>
                        </div>
                        <?php $total_general += $item['total']; ?>
                    <?php endwhile; ?>
                </div>

                <div>
                    <div class="card" style="position: sticky; top: 100px;">
                        <h3 style="margin-bottom: 1.5rem; font-size: 1.25rem; border-bottom: 1px solid var(--border-color); padding-bottom: 1rem;">Résumé de la commande</h3>
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: var(--text-muted);">
                            <span>Sous-total</span>
                            <span><?= number_format((float)$total_general, 2); ?> DT</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: var(--text-muted);">
                            <span>Frais de livraison</span>
                            <span style="color: var(--success); font-weight: bold;">Gratuit</span>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); font-size: 1.5rem; font-weight: 800; color: var(--text-main);">
                            <span>Total</span>
                            <span><?= number_format((float)$total_general, 2); ?> DT</span>
                        </div>

                        <a href="/ShopLink/public/index.php?page=commande_form_panier" class="btn btn-primary btn-block" style="margin-top: 2rem; padding: 1rem; font-size: 1.1rem;">
                            Procéder au paiement
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>