<?php
function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function afficherEtoiles($note) {
    $noteArrondie = (int)round((float)$note);
    $html = '';

    for ($i = 1; $i <= 5; $i++) {
        $html .= $i <= $noteArrondie ? '&#9733;' : '&#9734;';
    }

    return $html;
}

$produitsRows = [];
if (isset($produits) && $produits) {
    $produitsRows = $produits->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique - ShopLink</title>
    <link rel="stylesheet" href="/ShopLink/public/style.css">

</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=client_home" class="navbar-brand">
                🛒 Shop<span>Link</span>
            </a>
            <div class="navbar-nav">
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/ShopLink/public/index.php?page=client_commandes" class="nav-user">📦 Mes Commandes</a>
                    <a href="/ShopLink/public/index.php?page=messages" class="nav-user">💬 Messages</a>
                    <a href="/ShopLink/public/index.php?page=panier" class="nav-user" style="color: var(--primary);">
                        🛒 Panier
                    </a>
                    <a href="/ShopLink/app/controllers/AuthController.php?logout=1">Déconnexion</a>
                <?php else: ?>
                    <a href="/ShopLink/public/index.php?page=login" style="font-weight: 600;">Se connecter</a>
                    <a href="/ShopLink/public/index.php?page=register_choice" class="btn btn-primary" style="color:white !important; font-weight: bold;">S'inscrire</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Nos Produits</h1>
        </div>

        <form method="GET" action="/ShopLink/public/index.php" class="filter-card">
            <input type="hidden" name="page" value="client_home">
            
            <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..." value="<?= e($_GET['search'] ?? '') ?>" style="flex-grow: 2; min-width: 250px;">
            
            <select name="categorie" class="form-control">
                <option value="">Toutes catégories</option>
                <?php if(isset($categories)) while($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>" <?= (($_GET['categorie'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                        <?= e($cat['nom']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <input type="number" name="prix_min" class="form-control" placeholder="Prix Min" min="0" step="0.01" value="<?= e($_GET['prix_min'] ?? '') ?>">
            <input type="number" name="prix_max" class="form-control" placeholder="Prix Max" min="0" step="0.01" value="<?= e($_GET['prix_max'] ?? '') ?>">
            
            <button type="submit" class="btn btn-secondary">Filtrer</button>
            <a href="/ShopLink/public/index.php?page=client_home" class="btn" style="color: var(--text-muted);">Effacer</a>
        </form>

        <?php if (count($produitsRows) === 0): ?>
            <div class="alert alert-info">Aucun produit ne correspond à vos critères de recherche.</div>
        <?php else: ?>
            <div class="product-grid">
                <?php foreach ($produitsRows as $p): ?>
                    <?php
                    $moyenne = $p['moyenne_note'] ?? 0;
                    $image = $p['image'] ? "/ShopLink/images/" . e($p['image']) : "/ShopLink/images/template.jpg";
                    ?>
                    <article class="product-card">
                        <a href="/ShopLink/public/index.php?page=produit_detail&id=<?= (int)$p['id']; ?>">
                            <img class="product-image" src="<?= $image; ?>" alt="<?= e($p['nom']); ?>">
                        </a>

                        <div class="product-info">
                            <div class="product-category"><?= e($p['categorie_nom']); ?> - Vendu par <?= e($p['vendeur_nom']); ?></div>
                            <h2 class="product-title">
                                <a href="/ShopLink/public/index.php?page=produit_detail&id=<?= (int)$p['id']; ?>" style="color: inherit;">
                                    <?= e($p['nom']); ?>
                                </a>
                            </h2>
                            <div class="product-price"><?= number_format((float)$p['prix'], 2); ?> DT</div>
                            
                            <div class="product-stars">
                                <?= afficherEtoiles($moyenne); ?>
                                <span>(<?= (int)$p['nombre_avis'] ?>)</span>
                            </div>

                            <div class="product-actions" style="display:flex; flex-direction:column; gap:0.5rem;">
                                <a class="btn btn-secondary btn-block" href="/ShopLink/public/index.php?page=produit_detail&id=<?= (int)$p['id']; ?>">
                                    Voir détails
                                </a>

                                <?php if ((int)$p['stock'] > 0): ?>
                                    <form method="POST" action="/ShopLink/app/controllers/PanierController.php" style="width:100%;">
                                        <input type="hidden" name="produit_id" value="<?= (int)$p['id']; ?>">
                                        <button class="btn btn-primary btn-block" type="submit" name="add_panier">
                                            Ajouter au panier
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-block" type="button" disabled style="opacity: 0.5; cursor: not-allowed;">En rupture</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
