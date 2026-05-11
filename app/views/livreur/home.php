

<h2>Livraisons disponibles</h2>

<?php while ($row = $commandes->fetch_assoc()) { ?>

    Commande #<?= $row['id']; ?><br>
    <a href="index.php?page=accepter&id=<?= $row['id']; ?>">Accepter</a>

<?php } ?>



