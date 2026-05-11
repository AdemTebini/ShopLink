<h2>Commandes 🧾</h2>

<?php while ($cmd = $commandes->fetch_assoc()) { ?>

    <h3>Commande #<?= $cmd['id']; ?></h3>
    <p>Client: <?= $cmd['client_nom']; ?></p>
    <p>Statut: <?= $cmd['statut']; ?></p>

    <form method="POST" action="/ShopLink/app/controllers/ProduitController.php">

        <input type="hidden" name="commande_id" value="<?= $cmd['id']; ?>">

        <select name="livreur_id">
            <?php while ($l = $livreurs->fetch_assoc()) { ?>
                <option value="<?= $l['id']; ?>">
                    <?= $l['nom']; ?>
                </option>
            <?php } ?>
        </select>

        <button name="assign">Choisir livreur</button>
    </form>

    <hr>

<?php } ?>