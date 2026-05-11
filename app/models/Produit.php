<?php
class Produit {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        return $this->conn->query("
            SELECT p.*, u.nom AS vendeur_nom, u.ville
            FROM produits p
            JOIN users u ON p.user_id = u.id
        ");
    }
}
?>