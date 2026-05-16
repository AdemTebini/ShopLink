<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../config/db.php");
// ADD PRODUIT
//
if (isset($_POST['add_product'])) {

    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];

    $stock = $_POST['stock'];
    $categorie_id = $_POST['categorie_id'];

    $user_id = $_SESSION['user']['id'];

    // IMAGE UPLOAD SECURITY
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    
    // Check if a file was uploaded and there were no errors
    if (!empty($image) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $folder = __DIR__ . "/../../images/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $tmp);
        finfo_close($finfo);

        $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($mime_type, $allowed_mimes)) {
            die("Type de fichier non autorisé. Uniquement JPG, PNG ou WEBP.");
        }

        // Generate a secure unique filename
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $secure_filename = uniqid('prod_', true) . '.' . $ext;
        $path = $folder . $secure_filename;

        if (move_uploaded_file($tmp, $path)) {
            $stmt = $conn->prepare("
                INSERT INTO produits (nom, prix, description, image, user_id, stock, categorie_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("sdssiii", $nom, $prix, $description, $secure_filename, $user_id, $stock, $categorie_id);
            $stmt->execute();

            header("Location: /ShopLink/public/index.php?page=mes_produits");
            exit();
        } else {
            die("Erreur lors de l'upload de l'image.");
        }
    } else {
        die("Veuillez sélectionner une image valide.");
    }
}

//
// MES PRODUITS (VENDEUR)
//
if (isset($_GET['page']) && $_GET['page'] == 'mes_produits') {

    $id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("SELECT * FROM produits WHERE user_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    include(__DIR__ . "/../views/vendeur/mes_produits.php");
}

//
// COMMANDES VENDEUR
//
if (isset($_GET['page']) && $_GET['page'] == 'commandes') {

    $vendeur_id = $_SESSION['user']['id'];

    $stmt = $conn->prepare("
        SELECT c.*, u.nom AS client_nom, l.nom AS livreur_nom
        FROM commandes c
        JOIN users u ON c.client_id = u.id
        LEFT JOIN users l ON c.livreur_id = l.id
        WHERE c.vendeur_id = ?
        ORDER BY c.id DESC
    ");
    $stmt->bind_param("i", $vendeur_id);
    $stmt->execute();
    $commandes = $stmt->get_result();

    include(__DIR__ . "/../views/vendeur/commandes.php");
}

//
// CONFIRMER COMMANDE (VENDEUR)
//
if (isset($_POST['confirm_commande'])) {

    $commande_id = (int)$_POST['commande_id'];
    $vendeur_id = (int)$_SESSION['user']['id'];

        $stmt = $conn->prepare("
                UPDATE commandes
                SET statut='en attente livraison'
                WHERE id=?
                    AND vendeur_id=?
                    AND statut='en attente'
        ");
        $stmt->bind_param("ii", $commande_id, $vendeur_id);
        $stmt->execute();

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

    $id = (int)$_GET['delete_produit'];

    $stmt = $conn->prepare("DELETE FROM produits WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: /ShopLink/public/index.php?page=admin_produits");
    exit();
}
