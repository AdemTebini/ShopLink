<?php


if ($_SESSION['user']['role'] != 'vendeur') {
    header("Location: ../../public/index.php?page=login");
    exit();
}
?>

<h2>Dashboard Vendeur 🏪</h2>

<a href="index.php?page=add_produit">➕ Ajouter Produit</a><br>
<a href="/ShopLink/public/index.php?page=mes_produits&action=mes_produits">
    Mes Produits
</a><br>
<a href="index.php?page=commandes">🧾 Commandes</a><br>