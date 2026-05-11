<?php
session_start();

$page = $_GET['page'] ?? 'login';

switch ($page) {

    case 'login':
        include("../app/views/auth/login.php");
        break;

    //  ADMIN
    case 'admin_dashboard':
        if ($_SESSION['user']['role'] != 'admin') {
            die("Accès refusé ❌");
        }
        include("../app/views/admin/dashboard.php");
        break;

    //  VENDEUR
    case 'vendeur_dashboard':
        include("../app/views/vendeur/dashboard.php");
        break;

    //  LIVREUR
    case 'livreur_dashboard':
        include("../app/views/livreur/home.php");
        break;

    //  CLIENT
    case 'client_home':
        include("../app/controllers/ClientController.php");
        break;
    case 'client_commandes':
        include("../app/controllers/ClientController.php");
        break;
    case 'commande_form':
        include("../app/controllers/ClientController.php");
        break;

    case 'register_choice':
        include("../app/views/auth/register_choice.php");
        break;
    case 'register_client':
        include("../app/views/auth/register_client.php");
        break;
    case 'register_vendeur':
        include("../app/views/auth/register_vendeur.php");
        break;
    case 'register_livreur':
        include("../app/views/auth/register_livreur.php");
        break;

    case 'add_produit':
        include("../app/views/vendeur/add_produit.php");
        break;

    case 'mes_produits':
        include("../app/controllers/ProduitController.php");
        break;
    case 'commandes':
        include("../app/controllers/ProduitController.php");
        break;
    case 'users':
        include("../app/controllers/UserController.php");
        break;
    case 'admin_produits':
        include("../app/controllers/ProduitController.php");
        break;
    case 'produits':
        include("../app/controllers/ProduitController.php");
        break;
    default:
        echo "Page not found";
}
