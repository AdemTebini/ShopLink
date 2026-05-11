<?php

include("../../config/db.php");

//
// APPROVE USER
//
if (isset($_GET['approve'])) {

    $id = $_GET['approve'];

    $sql = "UPDATE users
            SET status='approved'
            WHERE id=$id";

    if ($conn->query($sql)) {

        header("Location: ../../public/index.php?page=admin_dashboard");
        exit();

    } else {
        echo "Erreur approve ❌";
    }
}

//
// REJECT USER
//
if (isset($_GET['reject'])) {

    $id = $_GET['reject'];

    $sql = "UPDATE users
            SET status='rejected'
            WHERE id=$id";

    if ($conn->query($sql)) {

        header("Location: ../../public/index.php?page=admin_dashboard");
        exit();

    } else {
        echo "Erreur reject ❌";
    }
}
?>