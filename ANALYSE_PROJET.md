# Analyse du Projet : ShopLink

## 1. Project Overview
- **Project Purpose**: ShopLink est une plateforme de commerce électronique (marketplace) où des vendeurs peuvent proposer leurs produits à la vente, des clients peuvent les acheter, et des livreurs indépendants peuvent s'occuper de la livraison des commandes.
- **Marketplace Concept**: Le système met en relation directe vendeurs, clients, et livreurs, avec une supervision par un administrateur.
- **Target Users**: 
  - Clients finaux cherchant à acheter des produits.
  - Commerçants ou particuliers (Vendeurs) souhaitant vendre en ligne.
  - Personnes cherchant à générer des revenus en effectuant des livraisons (Livreurs).
  - Administrateurs de la plateforme assurant la modération.
- **General Workflow**: Un vendeur s'inscrit (attente d'approbation), ajoute des produits. Un client s'inscrit, navigue, ajoute au panier, et commande. Le vendeur confirme la commande. Le livreur de la même ville accepte la livraison et l'achemine au client.

## 2. Current Stack
- **Langage** : PHP (Vanilla, PHP 8+ compatible)
- **Base de données** : MySQL / MariaDB (géré via phpMyAdmin)
- **Sessions** : Utilisation des sessions natives PHP (`$_SESSION`)
- **Architecture** : Structure de type MVC (Modèle-Vue-Contrôleur) basique et personnalisée.
- **Routing System** : Routage centralisé via `public/index.php` en utilisant un paramètre GET (`?page=...`) avec une instruction `switch`.

## 3. Folder Architecture
- `app/controllers` : Contient la logique métier, le traitement des formulaires, et les interactions avec la base de données (ex: `AuthController.php`, `ClientController.php`).
- `app/models` : Contient les classes modèles (ex: `User.php`, `Produit.php`). Actuellement sous-utilisé, une grande partie de la logique SQL est directement dans les contrôleurs.
- `app/views` : Contient l'interface utilisateur (fichiers PHP intégrant du HTML). Divisé par rôles (`admin/`, `auth/`, `client/`, `livreur/`, `vendeur/`).
- `public` : Point d'entrée principal (`index.php`) et ressources accessibles publiquement (`style.css`).
- `config` : Fichiers de configuration, notamment la connexion à la base de données (`db.php`).
- `images` : Dossier de stockage pour les images des produits uploadées par les vendeurs.
- `database` : Contient le script SQL d'initialisation et de structure de la base de données (`shoplink.sql`).

## 4. Roles & Permissions
- **client** : Compte approuvé automatiquement. Peut consulter les produits, voir les détails, ajouter des avis (note de 1 à 5), ajouter des articles au panier, valider une commande, et voir l'historique de ses commandes.
- **vendeur** : Nécessite l'approbation de l'administrateur. Peut ajouter de nouveaux produits (avec gestion des stocks et images), voir ses propres produits, voir les commandes reçues pour ses produits, et confirmer les commandes pour qu'elles passent en livraison.
- **livreur** : Nécessite l'approbation de l'administrateur. Peut voir les commandes en attente de livraison dans sa ville, et peut accepter ou refuser de les livrer.
- **admin** : Gère les utilisateurs (approuver ou rejeter les vendeurs et livreurs), peut supprimer des utilisateurs, modifier leurs rôles, et voir/supprimer n'importe quel produit.

## 5. Authentication System
- **Login** : L'utilisateur se connecte avec son email et mot de passe. Le système vérifie le hash avec `password_verify()`. Le statut du compte est vérifié (rejeté ou en attente).
- **Register** : L'utilisateur choisit un rôle. Le mot de passe est haché via `password_hash()`.
- **Pending Approval** : Si l'utilisateur s'inscrit en tant que `vendeur` ou `livreur`, son champ `status` est mis à `pending`. Il ne peut pas se connecter tant que l'admin ne l'a pas approuvé.
- **Admin Validation** : L'administrateur, depuis son dashboard, peut changer le statut en `approved` ou `rejected`.
- **Sessions** : Les données de l'utilisateur connecté sont stockées dans `$_SESSION['user']`.
- **Access Control** : Le routage et les contrôleurs vérifient `$_SESSION['user']['role']` pour restreindre l'accès (ex: seul un admin peut accéder à `admin_dashboard`).

## 6. Product System
- **Add Product** : Le vendeur utilise un formulaire pour ajouter un produit (nom, prix, description, stock, catégorie, image). L'image est uploadée dans le dossier `images/`.
- **Categories** : Les produits sont liés à une catégorie via `categorie_id` (Électronique, Vêtements, etc.).
- **Stock** : Géré lors de l'ajout et décrémenté lors de la validation d'une commande (panier).
- **Images** : Enregistrées localement (`move_uploaded_file`).
- **Product Listing** : Affichage global pour les clients sur la page d'accueil, avec moyenne des notes et nombre d'avis. Affichage restreint pour le vendeur (ses propres produits).
- **Current Product Display** : La page de détail (`produit_detail`) affiche toutes les infos du produit, le vendeur, la catégorie, et la liste des commentaires/avis.

## 7. Panier & Orders Workflow
- **Add Panier** : Le client ajoute un produit. Si le produit existe déjà, la quantité est incrémentée (sans dépasser le stock disponible).
- **Validation** : Le client valide son panier. Le système vérifie le stock.
- **Stock Update** : Pour chaque produit, si le stock est suffisant, le stock du produit est décrémenté (`stock = stock - quantite`).
- **Commandes Insertion** : Une ligne est insérée dans la table `commandes` avec le statut initial `en attente`. Le vendeur est lié (`vendeur_id`). Le panier du client est ensuite vidé.
- **Statuses** : `en attente` -> `en attente livraison` -> `en livraison` -> `livree` / `refusee`.

## 8. Delivery Workflow
- **Vendeur confirms order** : Le vendeur voit les commandes `en attente` et clique sur confirmer.
- **Status transition 1** : Le statut passe à `en attente livraison`.
- **Livreur sees orders by city** : Le livreur, sur son dashboard, voit les commandes `en attente livraison` n'ayant pas encore de livreur assigné (`livreur_id IS NULL`), et filtrées par sa ville (`ville`).
- **Livreur accepts/refuses** :
  - **Accept** : Le statut passe à `en livraison` et `livreur_id` prend l'ID du livreur.
  - **Refuse** : Le statut passe à `refusee` (note : le workflow pourrait être amélioré car refuser annule la livraison pour tout le monde, au lieu de la laisser à un autre livreur).
- **Status transition final** : Le passage au statut `livree` n'est pas encore implémenté côté contrôleur.

## 9. Database Structure
- **users** : id, nom, email, password, role, ville, created_at, status, telephone, cin.
- **categories** : id, nom.
- **produits** : id, nom, prix, description, image, user_id (vendeur), created_at, categorie_id, stock.
- **panier** : id, client_id, produit_id, quantite.
- **commandes** : id, client_id, vendeur_id, livreur_id, statut, created_at, produit_id, nom, prenom, phone, adresse, quantite, ville.
- **commentaires** : id, contenu, client_id, produit_id, created_at, note.
- **notifications** : id, user_id, message, is_read, created_at (Table existante mais inutilisée pour l'instant).

**Relations** :
- `commandes` est le centre des transactions : lie `users` (client), `users` (vendeur), `users` (livreur), et un `produit_id` (référence externe non stricte ou à revoir car la FK `produit_id` n'a pas de contrainte ON DELETE explicitée).
- `produits` appartient à un `users` (vendeur) et une `categories`.
- `panier` lie `users` (client) et `produits`.
- `commentaires` lie `users` (client) et `produits`.

## 10. Current Features Already Implemented
- [x] Inscription et connexion avec hachage de mots de passe.
- [x] Validation manuelle (admin) des vendeurs et livreurs.
- [x] Ajout, listing et suppression de produits.
- [x] Upload d'images pour les produits.
- [x] Système d'avis et de notation (1 à 5 étoiles) sur les produits.
- [x] Panier d'achat avec gestion des stocks.
- [x] Passage de commande et décrémentation des stocks.
- [x] Confirmation de la commande par le vendeur.
- [x] Dashboard Livreur avec filtrage par ville pour récupérer des courses.
- [x] Dashboard Administrateur (gestion des utilisateurs et produits).

## 11. Missing Features / TODO
- **Visitor Mode** : Les visiteurs non connectés ne peuvent pas naviguer facilement sur les produits sans être redirigés ou restreints, la page par défaut est `login`.
- **Search** : Aucun système de recherche ou de filtre (par catégorie ou nom) n'est implémenté pour les clients.
- **Fin du workflow de livraison** : Le livreur ne peut pas encore marquer une commande comme `livree`.
- **Notifications** : La table `notifications` existe mais n'est pas utilisée pour alerter les utilisateurs.
- **UI Improvements** : Les interfaces doivent être améliorées (responsive, design moderne).
- **Statistiques** : Pas de graphiques ou de statistiques de vente réels sur les dashboards.
- **Gestion des erreurs et UX** : L'utilisation excessive de `die()` pour les erreurs casse l'expérience utilisateur.

## 12. Security Analysis
- **Existing protections** :
  - Hachage des mots de passe (`password_hash`).
  - Validation du rôle via les sessions (`$_SESSION['user']`).
  - L'upload d'images vérifie si le dossier existe, mais ne valide pas le type MIME.
- **Missing protections & Risks** :
  - **SQL Injection (Très critique)** : De nombreuses requêtes utilisent la concaténation de chaînes directement avec les entrées utilisateur (ex: `$_POST['nom']` dans `AuthController.php`, `ProduitController.php`, `CommandeController.php`). Cela permet des injections SQL très facilement. *Seuls `ClientController.php` et `PanierController.php` utilisent les requêtes préparées.*
  - **Upload Risks** : Aucune vérification de l'extension de fichier ni du type MIME. Un attaquant peut uploader un script PHP déguisé en image (`shell.php`) et l'exécuter.
  - **XSS (Cross-Site Scripting)** : Les données affichées ne sont pas toujours échappées avec `htmlspecialchars()`.
  - **CSRF** : Aucun token CSRF n'est utilisé dans les formulaires.

## 13. Current Routing
Géré par `public/index.php` avec `$_GET['page']` :
- `login` : `app/views/auth/login.php`
- `admin_dashboard` : `app/views/admin/dashboard.php`
- `vendeur_dashboard` : `app/views/vendeur/dashboard.php`
- `livreur_dashboard`, `accepter`, `refuser` : redirige vers `LivreurController.php`
- `client_home`, `produit_detail`, `add_review`, `client_commandes`, `commande_form` : redirige vers `ClientController.php`
- `register_choice`, `register_client`, `register_vendeur`, `register_livreur` : pages d'inscription.
- `add_produit`, `mes_produits`, `commandes` (vendeur), `admin_produits`, `produits` : gérés par `ProduitController.php` et vues associées.
- `users` : géré par `UserController.php`.
- `panier` : redirige vers la vue `panier.php`.
- `valider_commande` : géré par `CommandeController.php`.
- `commande_form_panier` : vue d'adresse pour la validation du panier.

## 14. Controllers Responsibilities
- **AuthController** : Gestion du login, de l'inscription (insertion de l'utilisateur avec statut dynamique), et du logout.
- **ClientController** : Affichage du catalogue (home client), détail d'un produit, ajout des commentaires (avis), affichage de l'historique des commandes, et affichage du formulaire de commande (achat direct).
- **CommandeController** : Traitement de la validation d'une commande depuis le panier, transfert des éléments de la table `panier` vers `commandes`, et réduction du stock.
- **LivreurController** : Affichage des commandes disponibles pour un livreur selon sa ville, et actions d'accepter ou de refuser la livraison.
- **PanierController** : Ajout d'un article au panier (avec vérification et limitation par rapport au stock).
- **ProduitController** : Ajout d'un produit par un vendeur, listage des produits pour le vendeur ou l'admin, suppression de produit, affichage des commandes du vendeur, et confirmation d'une commande par le vendeur.
- **UserController** : Affichage de la liste des utilisateurs pour l'admin, modification du rôle d'un utilisateur, et suppression.
- **AdminController** : Gestion des statuts (`approve` ou `reject`) pour les vendeurs et livreurs en attente.

## 15. Recommendations
- **Security Cleanup Priorities** : Réécrire l'intégralité des requêtes SQL pour utiliser des instructions préparées (`prepare` / `bind_param`) afin de contrer les injections SQL. Implémenter la validation du type MIME et de l'extension pour les uploads d'images. Protéger les affichages avec `htmlspecialchars`.
- **Architecture Improvements** :
  - Centraliser le routage proprement dans une classe Router.
  - Vider les modèles (`Produit.php`, `User.php`) pour qu'ils encapsulent les requêtes SQL, allégeant ainsi les contrôleurs.
  - Remplacer les appels `die()` par des redirections avec des messages d'erreur flash dans la session (`$_SESSION['error']`).
- **Future Scalability & Migrations** : Le projet actuel fonctionne sur un MVC Vanilla basique. Pour une évolution future, une migration vers **Laravel** serait excellente. Elle permettrait de bénéficier d'Eloquent ORM, du routage avancé, des Middleware (pour l'authentification et les rôles), et des Blade Templates pour simplifier les vues, tout en corrigeant automatiquement les failles d'injection SQL et de CSRF.
- **Workflow Correctives** : Lorsqu'un livreur refuse une commande, elle ne devrait pas être annulée ("refusee"), mais simplement redevenir disponible pour un autre livreur ("en attente livraison"). Il faut également créer la logique pour finaliser la course ("livree").