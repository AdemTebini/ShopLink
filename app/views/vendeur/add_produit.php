<h2>Ajouter Produit ➕</h2>

<form method="POST" action="/ShopLink/app/controllers/ProduitController.php" enctype="multipart/form-data">

    Nom:
    <input type="text" name="nom" required><br><br>

    Prix:
    <input type="number" name="prix" required><br><br>

    Description:
    <textarea name="description"></textarea><br><br>

    Image:
    <input type="file" name="image" required><br><br>

    <button type="submit" name="add">Ajouter</button>

</form>