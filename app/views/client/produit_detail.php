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

$moyenne = $produit['moyenne_note'] ?? 0;
$nombreAvis = (int)($produit['nombre_avis'] ?? 0);
$image = $produit['image'] ? "/ShopLink/images/" . e($produit['image']) : "/ShopLink/images/template.jpg";
$peutPublierAvis = isset($_SESSION['user']) && $_SESSION['user']['role'] == 'client';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($produit['nom']); ?> - ShopLink</title>
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
        <div style="margin-bottom: 2rem;">
            <a href="/ShopLink/public/index.php?page=client_home" class="btn btn-secondary">
                ← Retour aux produits
            </a>
        </div>

        <div class="detail-grid">
            <!-- Image du produit -->
            <div class="detail-img-wrapper">
                <img src="<?= $image; ?>" alt="<?= e($produit['nom']); ?>">
            </div>

            <!-- Infos du produit -->
            <div>
                <div style="text-transform: uppercase; font-size: 0.85rem; color: var(--text-muted); font-weight: 700; margin-bottom: 0.5rem;">
                    <?= e($produit['categorie_nom'] ?? 'Sans catégorie'); ?>
                </div>
                
                <h1 style="font-size: 2rem; margin-bottom: 1rem; color: var(--text-main); line-height: 1.2;">
                    <?= e($produit['nom']); ?>
                </h1>
                
                <div style="font-size: 2.5rem; font-weight: 800; color: var(--primary); margin-bottom: 1rem;">
                    <?= number_format((float)$produit['prix'], 2); ?> DT
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="color: #f59e0b; font-size: 1.2rem;">
                        <?= afficherEtoiles($moyenne); ?>
                    </div>
                    <span style="color: var(--text-muted); font-weight: 600;">
                        <?= $moyenne ? e($moyenne) . "/5" : "Aucun avis"; ?>
                        (<?= $nombreAvis; ?> avis)
                    </span>
                </div>

                <div style="background: #f8fafc; padding: 1.5rem; border-radius: var(--radius); border: 1px solid var(--border-color); margin-bottom: 2rem;">
                    <h3 style="margin-bottom: 0.5rem; font-size: 1.1rem;">À propos de cet article</h3>
                    <p style="color: var(--text-muted); line-height: 1.6;">
                        <?= nl2br(e($produit['description'])); ?>
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem;">
                    <div style="background: var(--surface); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border-color);">
                        <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: bold;">Disponibilité</div>
                        <div style="font-size: 1.2rem; font-weight: bold; color: <?= ((int)$produit['stock'] > 0) ? 'var(--success)' : 'var(--danger)' ?>;">
                            <?= ((int)$produit['stock'] > 0) ? (int)$produit['stock'] . ' en stock' : 'Rupture' ?>
                        </div>
                    </div>
                    <div style="background: var(--surface); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--border-color);">
                        <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: bold;">Vendeur</div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="font-size: 1.1rem; font-weight: bold;"><?= e($produit['vendeur_nom']); ?></div>
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'client'): ?>
                                <a href="/ShopLink/public/index.php?page=chat&id=<?= (int)$produit['user_id'] ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;">
                                    💬 Contacter
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ((int)$produit['stock'] > 0): ?>
                    <form method="POST" action="/ShopLink/app/controllers/PanierController.php">
                        <input type="hidden" name="produit_id" value="<?= (int)$produit['id']; ?>">
                        <button type="submit" name="add_panier" class="btn btn-primary btn-block" style="padding: 1rem; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                            🛒 Ajouter au panier
                        </button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary btn-block" type="button" disabled style="padding: 1rem; font-size: 1.2rem; opacity: 0.6; cursor: not-allowed;">
                        Produit en rupture de stock
                    </button>
                <?php endif; ?>
            </div>
        </div>

        <hr style="margin: 4rem 0; border: 0; border-top: 1px solid var(--border-color);">

        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 1.5rem; margin-bottom: 2rem;">Commentaires clients</h2>

            <?php if (isset($_SESSION['review_error'])): ?>
                <div class="alert alert-error"><?= e($_SESSION['review_error']); ?></div>
                <?php unset($_SESSION['review_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['review_success'])): ?>
                <div class="alert alert-success"><?= e($_SESSION['review_success']); ?></div>
                <?php unset($_SESSION['review_success']); ?>
            <?php endif; ?>

            <?php if ($peutPublierAvis): ?>
                <div class="card" style="margin-bottom: 3rem;">
                    <h3 style="margin-bottom: 1rem;">Évaluer ce produit</h3>
                    <form method="POST" action="/ShopLink/public/index.php?page=add_review">
                        <input type="hidden" name="produit_id" value="<?= (int)$produit['id']; ?>">

                        <div class="form-group">
                            <label class="form-label">Note</label>
                            <select name="note" class="form-control" style="max-width: 200px;" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                <option value="3">⭐⭐⭐ (3/5)</option>
                                <option value="2">⭐⭐ (2/5)</option>
                                <option value="1">⭐ (1/5)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Votre avis détaillé</label>
                            <textarea name="contenu" class="form-control" rows="4" placeholder="Qu'avez-vous pensé de ce produit ?" required></textarea>
                        </div>

                        <button type="submit" name="add_review" class="btn btn-secondary">Publier mon avis</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-info" style="margin-bottom: 3rem;">
                    Vous devez être <a href="/ShopLink/public/index.php?page=login" style="font-weight: bold; text-decoration: underline;">connecté en tant que client</a> pour laisser un avis.
                </div>
            <?php endif; ?>

            <div>
                <?php if ($avis->num_rows == 0): ?>
                    <p style="color: var(--text-muted); font-style: italic;">Aucun avis pour ce produit pour le moment. Soyez le premier !</p>
                <?php else: ?>
                    <?php while ($commentaire = $avis->fetch_assoc()): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <strong style="font-size: 1.1rem;"><?= e($commentaire['client_nom']); ?></strong>
                                <span style="color: var(--text-muted); font-size: 0.9rem;"><?= date('d/m/Y', strtotime($commentaire['created_at'])); ?></span>
                            </div>

                            <div style="color: #f59e0b; margin-bottom: 0.5rem; font-size: 1rem;">
                                <?= afficherEtoiles($commentaire['note']); ?>
                                <span style="color: var(--text-muted); font-size: 0.85rem; margin-left: 0.25rem;">(<?= (int)$commentaire['note']; ?>/5)</span>
                            </div>

                            <p style="line-height: 1.6; color: var(--text-main);">
                                <?= nl2br(e($commentaire['contenu'])); ?>
                            </p>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
