<form method="POST" action="../app/controllers/AuthController.php">

    <input type="text" name="nom" placeholder="Nom"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>

    <script>
        const role = document.getElementById('role');
        const extra = document.getElementById('extraFields');
        role.addEventListener('change', () => {
            if (role.value === 'vendeur' || role.value === 'livreur') {
                extra.style.display = 'block';
            } else {
                extra.style.display = 'none';
            }
        });
    </script>

    <select name="role" id="role">
        <option value="client">Client</option>
        <option value="vendeur">Vendeur</option>
        <option value="livreur">Livreur</option>
    </select><br>

    <div id="extraFields" style="display:none;">
        <input type="text" name="telephone" placeholder="Téléphone">
        <input type="text" name="cin" placeholder="CIN">
    </div>

    <input type="text" name="ville" placeholder="Ville"><br>

    <button type="submit" name="register">S'inscrire</button>
</form>