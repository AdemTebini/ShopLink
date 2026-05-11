<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "/../../config/db.php");

//
// LIST USERS
//
if (isset($_GET['page']) && $_GET['page'] == 'users') {

    if ($_SESSION['user']['role'] != 'admin') {
        die("Accès refusé ❌");
    }

    $users = $conn->query("SELECT * FROM users");

    include(__DIR__ . "/../views/admin/users.php");
}

//
// DELETE USER
//
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $conn->query("DELETE FROM users WHERE id=$id");

    header("Location: /ShopLink/public/index.php?page=users");
    exit();
}

//
// UPDATE ROLE
//
if (isset($_POST['update_role'])) {

    $id = $_POST['user_id'];
    $role = $_POST['role'];

    $conn->query("UPDATE users SET role='$role' WHERE id=$id");

    header("Location: /ShopLink/public/index.php?page=users");
    exit();
}
?>