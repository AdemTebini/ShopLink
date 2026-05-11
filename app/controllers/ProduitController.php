<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../config/db.php");

//
// ADD PRODUIT
//
if (isset($_POST['add'])) {

    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user']['id'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $folder = __DIR__ . "/../../images/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $path = $folder . basename($image);

    if (move_uploaded_file($tmp, $path)) {

        $conn->query("
            INSERT INTO produits (nom, prix, description, image, user_id)
            VALUES ('$nom','$prix','$description','$image','$user_id')
        ");

        header("Location: /ShopLink/public/index.php?page=mes_produits");
        exit();
    }
}

//
// MES PRODUITS (VENDEUR)
//
if (isset($_GET['page']) && $_GET['page'] == 'mes_produits') {

    $id = $_SESSION['user']['id'];

    $result = $conn->query("
        SELECT * FROM produits WHERE user_id=$id
    ");

    include(__DIR__ . "/../views/vendeur/mes_produits.php");
}

//
// COMMANDES VENDEUR
//
if (isset($_GET['page']) && $_GET['page'] == 'commandes') {

    $vendeur_id = $_SESSION['user']['id'];
    $ville = $_SESSION['user']['ville'];

    $commandes = $conn->query("
        SELECT c.*, u.nom AS client_nom
        FROM commandes c
        JOIN users u ON c.client_id = u.id
        WHERE c.vendeur_id = $vendeur_id
    ");

    $livreurs = $conn->query("
        SELECT * FROM users 
        WHERE role='livreur' AND ville='$ville'
    ");

    include(__DIR__ . "/../views/vendeur/commandes.php");
}

//
// ASSIGN LIVREUR
//
if (isset($_POST['assign'])) {

    $commande_id = $_POST['commande_id'];
    $livreur_id = $_POST['livreur_id'];

    $conn->query("
        UPDATE commandes 
        SET livreur_id=$livreur_id,
            statut='en livraison'
        WHERE id=$commande_id
    ");

    header("Location: /ShopLink/public/index.php?page=commandes");
    exit();
}

//
// ADMIN PRODUITS
//
if ($_GET['page'] ?? '' == 'produits') {

    if ($_SESSION['user']['role'] != 'admin') {
        die("Accès refusé ❌");
    }

    $produits = $conn->query("
        SELECT p.*, u.nom AS vendeur_nom
        FROM produits p
        JOIN users u ON p.user_id = u.id
    ");

    include(__DIR__ . "/../views/admin/produits.php");
}

//
// DELETE PRODUIT (ADMIN)
//
if (isset($_GET['delete_produit'])) {

    $id = $_GET['delete_produit'];

    $conn->query("DELETE FROM produits WHERE id=$id");

    header("Location: /ShopLink/public/index.php?page=admin_produits");
    exit();
}
?>