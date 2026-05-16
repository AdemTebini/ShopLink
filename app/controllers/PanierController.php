<?php

session_start();

include("../../config/db.php");

//
// AJOUTER AU PANIER
//
if (isset($_POST['add_panier'])) {

    // Seuls les clients connectés peuvent ajouter au panier.
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'client') {
        header("Location: /ShopLink/public/index.php?page=login");
        exit();
    }

    $client_id = (int)$_SESSION['user']['id'];
    $produit_id = (int)$_POST['produit_id'];

    // Vérifier le stock avant l'ajout.
    $stmtProduit = $conn->prepare("SELECT stock FROM produits WHERE id = ?");
    $stmtProduit->bind_param("i", $produit_id);
    $stmtProduit->execute();
    $produit = $stmtProduit->get_result()->fetch_assoc();

    $stockDisponible = (int)($produit['stock'] ?? 0);

    if (!$produit || $stockDisponible <= 0) {
        header("Location: /ShopLink/public/index.php?page=produit_detail&id=" . $produit_id);
        exit();
    }

    // Vérifier si le produit existe déjà dans le panier.
    $stmtCheck = $conn->prepare("
        SELECT id, quantite
        FROM panier
        WHERE client_id = ?
        AND produit_id = ?
    ");
    $stmtCheck->bind_param("ii", $client_id, $produit_id);
    $stmtCheck->execute();
    $check = $stmtCheck->get_result();

    if ($check->num_rows > 0) {

        // Augmenter la quantité sans dépasser le stock disponible.
        $stmtUpdate = $conn->prepare("
            UPDATE panier
            SET quantite = LEAST(quantite + 1, ?)
            WHERE client_id = ?
            AND produit_id = ?
        ");
        $stmtUpdate->bind_param("iii", $stockDisponible, $client_id, $produit_id);
        $stmtUpdate->execute();
    } else {

        // Ajouter le produit au panier.
        $stmtInsert = $conn->prepare("
            INSERT INTO panier (client_id, produit_id, quantite)
            VALUES (?, ?, 1)
        ");
        $stmtInsert->bind_param("ii", $client_id, $produit_id);
        $stmtInsert->execute();
    }

    header("Location: /ShopLink/public/index.php?page=panier");
    exit();
}
