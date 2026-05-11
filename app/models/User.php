<?php
class User {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByEmail($email) {
        $res = $this->conn->query("SELECT * FROM users WHERE email='$email'");
        return $res->fetch_assoc();
    }
}
?>