<h2>Mes Produits 📦</h2>

<?php while ($row = $result->fetch_assoc()) { ?>

    <h3><?= $row['nom']; ?></h3>
    <p><?= $row['prix']; ?> DT</p>
    <p><?= $row['description']; ?></p>

    <img src="/ShopLink/images/<?= $row['image']; ?>" width="120">

    <hr>



<h4>Commentaires </h4>

    <?php
    $resC = $conn->query("
        SELECT c.*, u.nom AS client_nom
        FROM commentaires c
        JOIN users u ON c.client_id = u.id
        WHERE c.produit_id = ".$row['id']."
        ORDER BY c.created_at DESC
    ");

    if ($resC->num_rows == 0) {
        echo "<p>Aucun commentaire</p>";
    }

    while ($c = $resC->fetch_assoc()) {
        echo "<div style='background:#f5f5f5; padding:8px; margin:5px;'>";
        echo "<b>".$c['client_nom']."</b> ";
        echo "<small>(".$c['created_at'].")</small>";
        echo "<p>".$c['contenu']."</p>";
        echo "</div>";
    }
    ?>

</div>

<?php } ?>