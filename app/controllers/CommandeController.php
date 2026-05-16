<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include(__DIR__ . "/../../config/db.php");
//
// VALIDER COMMANDE
//
if (isset($_POST['valider_commande'])) {
    $client_id = $_SESSION['user']['id'];
    $nom = $_POST['nom'] ?? ($_SESSION['user']['nom'] ?? '');
    $prenom = $_POST['prenom'];
    $phone = $_POST['phone'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    //
    // récupérer panier
    //
    $panier = $conn->query("
        SELECT pa.*,
               p.nom,
               p.prix,
               p.stock,
               p.user_id AS vendeur_id
        FROM panier pa
        JOIN produits p
        ON pa.produit_id = p.id
        WHERE pa.client_id = $client_id
    ");
    if (!$panier || $panier->num_rows === 0) {
        echo "<p>Panier vide.</p>";
        exit();
    }

    $inserted = 0;
    $errors = [];

    //
    // création commandes
    //
    while ($item = $panier->fetch_assoc()) {
        $produit_id = $item['produit_id'];
        $vendeur_id = $item['vendeur_id'];
        $quantite = $item['quantite'];
        //
        // vérifier stock
        //
        if ($item['stock'] >= $quantite) {
            //
            // INSERT commande
            //
            $ok = $conn->query("
                INSERT INTO commandes
                 (produit_id,
                  client_id,
                  vendeur_id,
                  quantite,
                  nom,
                  prenom,
                  phone,
                  adresse,
                  ville,
                  statut)
                VALUES
                ($produit_id,
                 $client_id,
                 $vendeur_id,
                 $quantite,
                  '$nom',
                 '$prenom',
                 '$phone',
                 '$adresse',
                  '$ville',
                 'en attente')
            ");

            if ($ok) {
                $inserted++;
            } else {
                $errors[] = $conn->error;
            }
            //
            // diminuer stock
            //
            $conn->query("
                UPDATE produits
                SET stock = stock - $quantite
                WHERE id = $produit_id
            ");
        } else {
            $errors[] = "Stock insuffisant pour le produit #" . $produit_id;
        }
    }

    if ($inserted > 0) {
        //
        // vider panier
        //
        $conn->query("
            DELETE FROM panier
            WHERE client_id = $client_id
        ");
    }

    if ($inserted === 0) {
        echo "<p>Aucune commande n'a ete creee.</p>";
        if (count($errors) > 0) {
            echo "<p>Details: " . implode(" | ", $errors) . "</p>";
        }
        exit();
    }
    echo "
    <h2>
        Commande validée ✅
    </h2>
    <a href='/ShopLink/public/index.php?page=client_home'>
        Retour accueil
    </a>
    ";
}
