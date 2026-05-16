<?php
session_start();

$page = $_GET['page'] ?? 'client_home';
$_GET['page'] = $page;

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
        include("../app/controllers/LivreurController.php");
        break;
    case 'accepter':
        include("../app/controllers/LivreurController.php");
        break;
    case 'refuser':
        include("../app/controllers/LivreurController.php");
        break;
    case 'livrer':
        include("../app/controllers/LivreurController.php");
        break;

    //  CLIENT
    case 'client_home':
        include("../app/controllers/ClientController.php");
        break;
    case 'produit_detail':
        include("../app/controllers/ClientController.php");
        break;
    case 'add_review':
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
    case 'panier':
        include("../app/views/client/panier.php");
        break;
    case 'valider_commande':
        include("../app/controllers/CommandeController.php");
        break;
    case 'commande_form_panier':
        include("../app/views/client/commande_form_panier.php");
        break;
    case 'messages':
    case 'chat':
    case 'send_message':
        // Redirect send_message to send action
        if ($page === 'send_message') $_GET['action'] = 'send';
        if ($page === 'chat') $_GET['action'] = 'chat';
        include("../app/controllers/MessageController.php");
        break;

    default:
        echo "Page not found";
}

