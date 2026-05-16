<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../config/db.php");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'livreur') {
    die("Acces refuse ❌");
}

//
// LIVRAISONS DISPONIBLES
//
if (isset($_GET['page']) && $_GET['page'] == 'livreur_dashboard') {

    $livreur_ville = $_SESSION['user']['ville'] ?? '';
    $selected_ville = $_GET['ville'] ?? $livreur_ville;
    $selected_ville = trim($selected_ville);
    $ville_mismatch = false;

    if ($selected_ville !== $livreur_ville) {
        $selected_ville = $livreur_ville;
        $ville_mismatch = true;
    }

    $ville_sql = $conn->real_escape_string($selected_ville);
    $livreur_id = (int)$_SESSION['user']['id'];

    // 1. Livraisons disponibles
    $commandes_disponibles = $conn->query("
        SELECT c.*, u.nom AS client_nom
        FROM commandes c
        JOIN users u ON c.client_id = u.id
        WHERE c.statut = 'en attente livraison'
          AND c.livreur_id IS NULL
          AND c.ville = '$ville_sql'
        ORDER BY c.id DESC
    ");

    // 2. Livraisons en cours
    $commandes_en_cours = $conn->query("
        SELECT c.*, u.nom AS client_nom
        FROM commandes c
        JOIN users u ON c.client_id = u.id
        WHERE c.statut = 'en livraison'
          AND c.livreur_id = $livreur_id
        ORDER BY c.id DESC
    ");

    // 3. Historique
    $commandes_historique = $conn->query("
        SELECT c.*, u.nom AS client_nom
        FROM commandes c
        JOIN users u ON c.client_id = u.id
        WHERE c.statut = 'livree'
          AND c.livreur_id = $livreur_id
        ORDER BY c.id DESC
    ");

    include(__DIR__ . "/../views/livreur/home.php");
}

//
// ACCEPTER COMMANDE
//
if (isset($_GET['page']) && $_GET['page'] == 'accepter' && isset($_GET['id'])) {

    $livreur_id = (int)$_SESSION['user']['id'];
    $commande_id = (int)$_GET['id'];
    $livreur_ville = $conn->real_escape_string($_SESSION['user']['ville'] ?? '');

    $conn->query("
        UPDATE commandes
        SET livreur_id = $livreur_id,
            statut = 'en livraison'
        WHERE id = $commande_id
          AND livreur_id IS NULL
          AND statut = 'en attente livraison'
          AND ville = '$livreur_ville'
    ");

    header("Location: /ShopLink/public/index.php?page=livreur_dashboard");
    exit();
}

//
// REFUSER / ANNULER COMMANDE
//
if (isset($_GET['page']) && $_GET['page'] == 'refuser' && isset($_GET['id'])) {

    $commande_id = (int)$_GET['id'];
    $livreur_id = (int)$_SESSION['user']['id'];
    $livreur_ville = $conn->real_escape_string($_SESSION['user']['ville'] ?? '');

    $conn->query("
        UPDATE commandes
        SET statut = 'en attente livraison',
            livreur_id = NULL
        WHERE id = $commande_id
          AND ville = '$livreur_ville'
          AND (livreur_id IS NULL OR livreur_id = $livreur_id)
    ");

    header("Location: /ShopLink/public/index.php?page=livreur_dashboard");
    exit();
}

//
// MARQUER COMMANDE LIVREE
//
if (isset($_GET['page']) && $_GET['page'] == 'livrer' && isset($_GET['id'])) {

    $commande_id = (int)$_GET['id'];
    $livreur_id = (int)$_SESSION['user']['id'];

    $conn->query("
        UPDATE commandes
        SET statut = 'livree'
        WHERE id = $commande_id
          AND livreur_id = $livreur_id
          AND statut = 'en livraison'
    ");

    header("Location: /ShopLink/public/index.php?page=livreur_dashboard");
    exit();
}
