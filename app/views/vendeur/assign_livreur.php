<?php
include("../../config/db.php");
session_start();

$commande_id = $_POST['commande_id'];
$livreur_id = $_POST['livreur_id'];

$conn->query("
    UPDATE commandes 
    SET livreur_id=$livreur_id,
        statut='en cours livraison'
    WHERE id=$commande_id
");

header("Location: commandes.php");
?>