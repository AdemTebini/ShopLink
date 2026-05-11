<h2>Commande 🛒</h2>

<h3><?= $produit['nom']; ?></h3>
<p><?= $produit['prix']; ?> DT</p>

<form method="POST" action="/ShopLink/app/controllers/ClientController.php">

    <input type="hidden" name="produit_id" value="<?= $produit['id']; ?>">

    <!-- 👤 infos client -->
    Nom:
    <input type="text" name="nom" value="<?= $_SESSION['user']['nom']; ?>" required><br><br>

    Prénom:
    <input type="text" name="prenom" value="<?= $_SESSION['user']['prenom'] ?? ''; ?>"><br><br>

    Téléphone:
    <input type="text" name="phone" value="<?= $_SESSION['user']['phone'] ?? ''; ?>"><br><br>

    Ville / Adresse:
    <input type="text" name="adresse" value="<?= $_SESSION['user']['adresse'] ?? ''; ?>"><br><br>

    <!-- 🛒 produit -->
    Quantité:
    <input type="number" name="quantite" value="1" min="1" required><br><br>

    <button name="commander">Confirmer commande</button>

</form>