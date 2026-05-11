<h2>Client Home 🛍️</h2>

<p>Bienvenue client 👋</p><h2>Produits 🛍️</h2>

<?php while ($p = $produits->fetch_assoc()) { ?>

<div style="border:1px solid #ccc; padding:10px; margin:10px;">

    <h3><?= $p['nom']; ?></h3>
    <p><?= $p['prix']; ?> DT</p>
    <p>Vendeur: <?= $p['vendeur_nom']; ?></p>

    <img src="/ShopLink/images/<?= $p['image']; ?>" width="100">

    <form method="GET" action="/ShopLink/public/index.php">
        <input type="hidden" name="page" value="commande_form">
        <input type="hidden" name="produit_id" value="<?= $p['id']; ?>">
        <button>Commander 🛒</button>
    </form>
    

</div>


<?php } ?>
<a href="/ShopLink/public/logout.php">🚪 Déconnexion</a>