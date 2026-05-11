<?php
$conn = new mysqli("localhost", "root", "", "shoplink");

if ($conn->connect_error) {
    die("DB error");
}
?>