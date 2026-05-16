<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../config/db.php");

// Petit helper pour rediriger simplement dans le projet.
function redirect_to($url) {
    header("Location: " . $url);
    exit();
}

//
// AJOUTER UN AVIS PRODUIT
//
if (isset($_POST['add_review'])) {

    $produit_id = (int)($_POST['produit_id'] ?? 0);
    $note = (int)($_POST['note'] ?? 0);
    $contenu = trim($_POST['contenu'] ?? '');

    // Seuls les clients connectés peuvent publier un avis.
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'client') {
        $_SESSION['review_error'] = "Vous devez être connecté comme client pour publier un avis.";
        redirect_to("/ShopLink/public/index.php?page=produit_detail&id=" . $produit_id);
    }

    // Empêcher les commentaires vides.
    if ($contenu == '') {
        $_SESSION['review_error'] = "Le commentaire ne peut pas être vide.";
        redirect_to("/ShopLink/public/index.php?page=produit_detail&id=" . $produit_id);
    }

    // La base impose déjà une note entre 1 et 5, on valide aussi côté PHP.
    if ($note < 1 || $note > 5) {
        $_SESSION['review_error'] = "La note doit être entre 1 et 5.";
        redirect_to("/ShopLink/public/index.php?page=produit_detail&id=" . $produit_id);
    }

    $client_id = (int)$_SESSION['user']['id'];

    // Vérifier que le produit existe avant d'insérer l'avis.
    $stmtProduit = $conn->prepare("SELECT id FROM produits WHERE id = ?");
    $stmtProduit->bind_param("i", $produit_id);
    $stmtProduit->execute();

    if ($stmtProduit->get_result()->num_rows == 0) {
        $_SESSION['review_error'] = "Produit introuvable.";
        redirect_to("/ShopLink/public/index.php?page=client_home");
    }

    $stmt = $conn->prepare("
        INSERT INTO commentaires (contenu, client_id, produit_id, note)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("siii", $contenu, $client_id, $produit_id, $note);
    $stmt->execute();

    $_SESSION['review_success'] = "Votre avis a été ajouté.";
    redirect_to("/ShopLink/public/index.php?page=produit_detail&id=" . $produit_id);
}

//
// AFFICHER PRODUITS (HOME CLIENT)
//
if (isset($_GET['page']) && $_GET['page'] == 'client_home') {

    // 1. Récupération des catégories et villes pour les filtres
    $categories = $conn->query("SELECT * FROM categories ORDER BY nom ASC");
    $villes_vendeurs = $conn->query("SELECT DISTINCT ville FROM users WHERE role = 'vendeur' AND ville != '' ORDER BY ville ASC");

    // 2. Construction dynamique de la requête de sélection des produits
    $search = $_GET['search'] ?? '';
    $categorie_id = $_GET['categorie'] ?? '';
    $ville = $_GET['ville'] ?? '';
    $prix_min = $_GET['prix_min'] ?? '';
    $prix_max = $_GET['prix_max'] ?? '';

    $sql = "
        SELECT p.*,
               u.nom AS vendeur_nom,
               c.nom AS categorie_nom,
               notes.moyenne_note,
               COALESCE(notes.nombre_avis, 0) AS nombre_avis
        FROM produits p
        JOIN users u ON p.user_id = u.id 
        LEFT JOIN categories c ON p.categorie_id = c.id
        LEFT JOIN (
            SELECT produit_id,
                   ROUND(AVG(note), 1) AS moyenne_note,
                   COUNT(id) AS nombre_avis
            FROM commentaires
            GROUP BY produit_id
        ) notes ON notes.produit_id = p.id
        WHERE 1=1
    ";

    $params = [];
    $types = "";

    if (!empty($search)) {
        $sql .= " AND p.nom LIKE ?";
        $params[] = "%" . $search . "%";
        $types .= "s";
    }

    if (!empty($categorie_id)) {
        $sql .= " AND p.categorie_id = ?";
        $params[] = (int)$categorie_id;
        $types .= "i";
    }

    if (!empty($ville)) {
        $sql .= " AND u.ville = ?";
        $params[] = $ville;
        $types .= "s";
    }

    if (!empty($prix_min) && is_numeric($prix_min)) {
        $sql .= " AND p.prix >= ?";
        $params[] = (float)$prix_min;
        $types .= "d";
    }

    if (!empty($prix_max) && is_numeric($prix_max)) {
        $sql .= " AND p.prix <= ?";
        $params[] = (float)$prix_max;
        $types .= "d";
    }

    $sql .= " ORDER BY p.created_at DESC";

    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $bindArgs = [$types];
        foreach ($params as $k => $v) {
            $bindArgs[] = &$params[$k];
        }
        call_user_func_array([$stmt, 'bind_param'], $bindArgs);
    }

    $stmt->execute();
    $produits = $stmt->get_result();

    include(__DIR__ . "/../views/client/home.php");
    exit();
}

//
// DETAIL PRODUIT
//
if (isset($_GET['page']) && $_GET['page'] == 'produit_detail') {

    $produit_id = (int)($_GET['id'] ?? 0);

    $stmt = $conn->prepare("
        SELECT p.*,
               u.nom AS vendeur_nom,
               c.nom AS categorie_nom,
               notes.moyenne_note,
               COALESCE(notes.nombre_avis, 0) AS nombre_avis
        FROM produits p
        JOIN users u ON p.user_id = u.id
        LEFT JOIN categories c ON p.categorie_id = c.id
        LEFT JOIN (
            SELECT produit_id,
                   ROUND(AVG(note), 1) AS moyenne_note,
                   COUNT(id) AS nombre_avis
            FROM commentaires
            GROUP BY produit_id
        ) notes ON notes.produit_id = p.id
        WHERE p.id = ?
    ");
    $stmt->bind_param("i", $produit_id);
    $stmt->execute();
    $produit = $stmt->get_result()->fetch_assoc();

    if (!$produit) {
        echo "Produit introuvable.";
        exit();
    }

    $stmtAvis = $conn->prepare("
        SELECT co.*, u.nom AS client_nom
        FROM commentaires co
        JOIN users u ON co.client_id = u.id
        WHERE co.produit_id = ?
        ORDER BY co.created_at DESC
    ");
    $stmtAvis->bind_param("i", $produit_id);
    $stmtAvis->execute();
    $avis = $stmtAvis->get_result();

    include(__DIR__ . "/../views/client/produit_detail.php");
    exit();
}

//
// MES COMMANDES CLIENT
//
if (isset($_GET['page']) && $_GET['page'] == 'client_commandes') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'client') {
        redirect_to("/ShopLink/public/index.php?page=login");
    }

    $id = (int)$_SESSION['user']['id'];

    $stmtCommandes = $conn->prepare("
        SELECT c.*, p.nom AS produit_nom
        FROM commandes c
        JOIN produits p ON c.produit_id = p.id
        WHERE c.client_id = ?
    ");
    $stmtCommandes->bind_param("i", $id);
    $stmtCommandes->execute();
    $commandes = $stmtCommandes->get_result();

    include(__DIR__ . "/../views/client/commandes.php");
}
//
// AFFICHER FORMULAIRE COMMANDE
//
if (isset($_GET['page']) && $_GET['page'] == 'commande_form') {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'client') {
        redirect_to("/ShopLink/public/index.php?page=login");
    }

    $produit_id = (int)$_GET['produit_id'];

    $stmtProduit = $conn->prepare("SELECT * FROM produits WHERE id = ?");
    $stmtProduit->bind_param("i", $produit_id);
    $stmtProduit->execute();
    $produit = $stmtProduit->get_result()->fetch_assoc();

    include(__DIR__ . "/../views/client/commande_form.php");
}
//
// PASSER COMMANDE
//
if (isset($_POST['commander'])) {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'client') {
        redirect_to("/ShopLink/public/index.php?page=login");
    }

    $produit_id = (int)$_POST['produit_id'];
    $quantite = (int)$_POST['quantite'];

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $phone = $_POST['phone'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];

    $client_id = (int)$_SESSION['user']['id'];

    $stmtProduit = $conn->prepare("SELECT * FROM produits WHERE id = ?");
    $stmtProduit->bind_param("i", $produit_id);
    $stmtProduit->execute();
    $p = $stmtProduit->get_result()->fetch_assoc();

    if (!$p) {
        die("Produit introuvable.");
    }

    $vendeur_id = (int)$p['user_id'];

    $stmtCommande = $conn->prepare("
        INSERT INTO commandes 
        (produit_id, client_id, vendeur_id, quantite, nom, prenom, phone, adresse, ville, statut)
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, 'en attente')
    ");
    $stmtCommande->bind_param(
        "iiiisssss",
        $produit_id,
        $client_id,
        $vendeur_id,
        $quantite,
        $nom,
        $prenom,
        $phone,
        $adresse,
        $ville
    );
    $stmtCommande->execute();

    header("Location: /ShopLink/public/index.php?page=client_commandes");
    exit();
}
