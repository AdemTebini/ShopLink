<?php
session_start();

include("../../config/db.php");
include("../models/User.php");

$userModel = new User($conn);

//
// LOGIN
//
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $userModel->findByEmail($email);

    if ($user && password_verify($password, $user['password'])) {

        if ($user['status'] == 'pending') {
            die("Compte en attente de validation admin ⏳");
        }

        if ($user['status'] == 'rejected') {
            die("Compte refusé par l'administrateur ❌");
        }

        // Prevent session fixation
        session_regenerate_id(true);

        $_SESSION['user'] = $user;

        if ($user['role'] == 'admin') {
            header("Location: ../../public/index.php?page=admin_dashboard");
        } elseif ($user['role'] == 'vendeur') {
            header("Location: ../../public/index.php?page=vendeur_dashboard");
        } elseif ($user['role'] == 'livreur') {
            header("Location: ../../public/index.php?page=livreur_dashboard");
        } else {
            header("Location: ../../public/index.php?page=client_home");
        }

        exit();
    } else {
        echo "Login incorrect ❌";
    }
}

//
// REGISTER
//
if (isset($_POST['register'])) {

    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $ville = $_POST['ville'];

    $telephone = $_POST['telephone'] ?? null;
    $cin = $_POST['cin'] ?? null;

    // hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // status dynamique
    if ($role == 'client') {
        $status = 'approved';
    } else {
        $status = 'pending';
    }

    $stmt = $conn->prepare("
        INSERT INTO users (nom, email, password, role, ville, telephone, cin, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->bind_param("ssssssss", $nom, $email, $hashed, $role, $ville, $telephone, $cin, $status);

    if ($stmt->execute()) {

        if ($status == 'pending') {
            echo "Compte créé ✅ En attente de validation admin.";
        } else {
            header("Location: ../../public/index.php?page=login");
            exit();
        }
    } else {
        echo "Erreur register ❌ : " . $stmt->error;
    }
}

//
// LOGOUT
//
if (isset($_GET['logout'])) {

    session_unset();
    session_destroy();

    header("Location: ../../public/index.php?page=login");
    exit();
}
