<h1>Inscription Vendeur</h1>

<form method="POST" action="../app/controllers/AuthController.php">

    <input type="text" name="nom" placeholder="Nom" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <input type="text" name="ville" placeholder="Ville" required><br><br>

    <input type="text" name="telephone" placeholder="Téléphone" required><br><br>

    <input type="text" name="cin" placeholder="CIN" required><br><br>

    <input type="hidden" name="role" value="vendeur">

    <button type="submit" name="register">
        S'inscrire
    </button>

</form>