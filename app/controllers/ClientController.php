<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../config/db.php");

//
// AFFICHER PRODUITS (HOME CLIENT)
//
if (isset($_GET['page']) && $_GET['page'] == 'client_home') {

    $produits = $conn->query("
        SELECT p.*, u.nom AS vendeur_nom
        FROM produits p
        JOIN users u ON p.user_id = u.id
    ");

    include(__DIR__ . "/../views/client/home.php");
}

//
// CLIENT - PASSER COMMANDE
//
if (isset($_POST['commander'])) {

    $produit_id = $_POST['produit_id'];
    $client_id = $_SESSION['user']['id'];

    $p = $conn->query("SELECT * FROM produits WHERE id=$produit_id")->fetch_assoc();
    $vendeur_id = $p['user_id'];

    $conn->query("
        INSERT INTO commandes (produit_id, client_id, vendeur_id, statut)
        VALUES ($produit_id, $client_id, $vendeur_id, 'en attente')
    ");

    header("Location: /ShopLink/public/index.php?page=client_home");
    exit();
}

//
// MES COMMANDES CLIENT
//
if (isset($_GET['page']) && $_GET['page'] == 'client_commandes') {

    $id = $_SESSION['user']['id'];

    $commandes = $conn->query("
        SELECT c.*, p.nom AS produit_nom
        FROM commandes c
        JOIN produits p ON c.produit_id = p.id
        WHERE c.client_id = $id
    ");

    include(__DIR__ . "/../views/client/commandes.php");
}
//
// AFFICHER FORMULAIRE COMMANDE
//
if (isset($_GET['page']) && $_GET['page'] == 'commande_form') {

    $produit_id = $_GET['produit_id'];

    $produit = $conn->query("
        SELECT * FROM produits WHERE id=$produit_id
    ")->fetch_assoc();

    include(__DIR__ . "/../views/client/commande_form.php");
}
//
// PASSER COMMANDE
//
if (isset($_POST['commander'])) {

    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $phone = $_POST['phone'];
    $adresse = $_POST['adresse'];

    $client_id = $_SESSION['user']['id'];

    $p = $conn->query("SELECT * FROM produits WHERE id=$produit_id")->fetch_assoc();
    $vendeur_id = $p['user_id'];

    $conn->query("
        INSERT INTO commandes 
        (produit_id, client_id, vendeur_id, quantite, nom, prenom, phone, adresse, statut)
        VALUES 
        ($produit_id, $client_id, $vendeur_id, $quantite, '$nom', '$prenom', '$phone', '$adresse', 'en attente')
    ");

    header("Location: /ShopLink/public/index.php?page=client_commandes");
    exit();
}
if (!isset($_SESSION['user'])) {
    header("Location: index.php?page=login");
    exit();
}
?>