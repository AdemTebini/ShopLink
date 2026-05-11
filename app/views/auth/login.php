<h2>Login</h2>

<form method="POST" action="/ShopLink/app/controllers/AuthController.php">
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>

    <button type="submit" name="login">Se connecter</button>
</form>

<p>
    Pas de compte ?
    <a href="index.php?page=register_choice">Register</a>
</p>