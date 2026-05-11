<h2>Gestion Produits 🛍️</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Prix</th>
    <th>Vendeur</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php while ($p = $produits->fetch_assoc()) { ?>

<tr>
    <td><?= $p['id']; ?></td>
    <td><?= $p['nom']; ?></td>
    <td><?= $p['prix']; ?> DT</td>
    <td><?= $p['vendeur_nom']; ?></td>

    <td>
        <img src="/ShopLink/images/<?= $p['image']; ?>" width="80">
    </td>

    <td>
        <a onclick="return confirm('Supprimer ?')"
        href="/ShopLink/public/index.php?page=admin_produits&delete_produit=<?= $p['id']; ?>">
            Supprimer ❌
        </a>
    </td>
</tr>

<?php } ?>

</table>