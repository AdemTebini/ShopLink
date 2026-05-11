# Analyse du projet ShopLink

## Résumé rapide
ShopLink est une application web PHP/MySQL de type mini marketplace / gestion de commandes. Le projet est organisé autour de 4 rôles principaux: `client`, `vendeur`, `livreur` et `admin`. L’application permet d’authentifier un utilisateur, de parcourir des produits, de passer des commandes, de gérer un catalogue vendeur, d’assigner des livreurs et d’administrer les comptes et les produits.

L’architecture est simple et très directe: un front controller dans `public/index.php` route les pages via `?page=...`, puis les contrôleurs chargent les vues et exécutent les requêtes SQL. C’est fonctionnel pour un petit projet, mais la logique métier, la sécurité et l’accès aux données sont trop mélangés pour tenir sur le long terme.

## Stack et structure
- Backend: PHP natif
- Base de données: MySQL via `mysqli`
- Authentification: session PHP
- Uploads: images produits stockées dans `images/`
- Entrée principale: `public/index.php`

### Arborescence fonctionnelle
- `app/controllers/`: logique de traitement
- `app/models/`: wrappers très légers autour des requêtes SQL
- `app/views/`: interfaces HTML séparées par rôle
- `config/db.php`: connexion à la base `shoplink`
- `public/`: point d’entrée web

## Architecture réelle
Le projet suit une forme de MVC très légère, mais pas stricte.

- `public/index.php` joue le rôle de routeur central.
- Les contrôleurs incluent parfois directement les vues.
- Les modèles contiennent peu de logique et servent surtout à exécuter une requête.
- Plusieurs actions métier sont déclenchées directement par `$_GET` ou `$_POST`.

En pratique, la logique métier est répartie entre les contrôleurs et certaines vues. Cela marche pour un prototype, mais cela rend les tests, la maintenance et la sécurité plus difficiles.

## Fonctionnalités par rôle

### Authentification
Le projet gère l’inscription, la connexion et la déconnexion.

- Connexion avec vérification du mot de passe hashé.
- Redirection selon le rôle.
- Inscription avec choix du rôle et de la ville.
- Déconnexion via destruction de session.

Références utiles: `app/controllers/AuthController.php`, `app/models/User.php`.

### Client
Le client peut:

- voir la liste des produits,
- ouvrir un formulaire de commande,
- valider une commande,
- consulter ses commandes.

Le flux client est centré sur `app/controllers/ClientController.php` et les vues `app/views/client/home.php` et `app/views/client/commande_form.php`.

### Vendeur
Le vendeur peut:

- ajouter un produit avec image,
- voir ses produits,
- voir les commandes liées à son compte,
- assigner un livreur parmi ceux de la même ville.

### Admin
L’admin peut:

- lister les utilisateurs,
- modifier leur rôle,
- supprimer des utilisateurs,
- lister tous les produits,
- supprimer un produit.

### Livreur
La partie livreur existe, mais elle semble incomplète. La vue `app/views/livreur/home.php` affiche des commandes disponibles et un lien “Accepter”, mais la route correspondante n’est pas câblée dans `public/index.php`.

## Flux métier principal

### 1. Login
Le formulaire envoie vers `app/controllers/AuthController.php`. Si l’email existe et que le mot de passe est valide, la session est remplie avec les données utilisateur, puis l’utilisateur est redirigé selon son rôle.

### 2. Consultation des produits
Le client arrive sur `client_home`, où les produits sont récupérés avec une jointure sur `users` pour afficher le nom du vendeur.

### 3. Passer une commande
Le client ouvre un formulaire de commande, remplit les informations, puis la commande est insérée dans la table `commandes` avec le vendeur associé au produit.

### 4. Traitement vendeur
Le vendeur voit les commandes de sa boutique, puis choisit un livreur parmi les livreurs de sa ville. Le statut passe à `en livraison`.

### 5. Administration
L’admin pilote les comptes et le catalogue, surtout pour la modération et la maintenance.

## Modèle de données inféré
Même sans script SQL visible, les requêtes permettent d’inférer les tables suivantes:

- `users`: `id`, `nom`, `email`, `password`, `role`, `ville`
- `produits`: `id`, `nom`, `prix`, `description`, `image`, `user_id`
- `commandes`: `id`, `produit_id`, `client_id`, `vendeur_id`, `livreur_id`, `quantite`, `nom`, `prenom`, `phone`, `adresse`, `statut`
- `commentaires`: `id`, `produit_id`, `client_id`, `contenu`, `created_at`

## Points forts
- Le projet couvre un vrai cycle métier de bout en bout.
- Les rôles sont déjà bien identifiés.
- Les pages sont séparées par domaine fonctionnel.
- La structure est facile à comprendre pour un petit projet scolaire ou prototype.

## Problèmes et risques

### 1. Bug critique dans la commande client
Dans `app/controllers/ClientController.php`, il y a deux blocs `if (isset($_POST['commander']))`. Le premier insère une commande minimale puis redirige immédiatement, donc le second bloc devient inatteignable. Résultat: la version avec `quantite`, `prenom`, `phone` et `adresse` ne s’exécute jamais.

Conséquence: la commande enregistrée n’utilise pas les infos du formulaire complet.

### 2. SQL Injection
Beaucoup de requêtes concatènent directement les variables utilisateur dans le SQL.

Exemples:
- `app/models/User.php`
- `app/controllers/AuthController.php`
- `app/controllers/ClientController.php`
- `app/controllers/ProduitController.php`

Cela expose le projet à des injections SQL sur login, recherche, insertion, suppression et mise à jour.

### 3. Contrôles d’accès incomplets
Certaines pages vérifient le rôle, mais pas toutes les routes sensibles.

- `vendeur_dashboard` et `livreur_dashboard` sont inclus sans garde forte dans `public/index.php`.
- Plusieurs actions mutatives sont déclenchées uniquement par `GET` ou `POST`, sans CSRF ni vérification supplémentaire.

### 4. Déconnexion incohérente
Le lien de déconnexion n’est pas uniforme.

- `AuthController.php` gère bien `?logout=1`.
- `app/views/admin/dashboard.php` pointe vers le contrôleur.
- `app/views/client/home.php` pointe vers `/ShopLink/public/logout.php`, fichier qui n’apparaît pas dans le projet.

### 5. Upload image fragile
L’ajout produit accepte un fichier image sans validation de type, taille ou nom.

### 6. Code mort ou routes incomplètes
On voit des fichiers ou liens non entièrement câblés:

- `app/views/client/dashboard.php` existe mais n’est pas branché comme page dédiée.
- `app/views/vendeur/assign_livreur.php` contient une logique d’assignation différente de celle du contrôleur principal.
- La page livreur affiche un lien `accepter` qui n’a pas d’implémentation visible dans `public/index.php`.

## Lecture produit / maintenabilité
Le projet est bon comme démonstration fonctionnelle, mais il souffre de trois limites principales:

1. La logique métier est dispersée.
2. La sécurité est trop faible pour un usage réel.
3. La navigation dépend de chaînes de requêtes et d’inclusions directes, ce qui rend les bugs de routing fréquents.

## Priorités de correction
1. Corriger le flux de commande client et supprimer le doublon `if (isset($_POST['commander']))`.
2. Passer toutes les requêtes SQL sensibles en requêtes préparées.
3. Centraliser les garde-fous d’accès par rôle.
4. Harmoniser la déconnexion et supprimer les liens cassés.
5. Valider les uploads d’images.
6. Extraire les règles métier vers des méthodes de modèle ou de service.

## Conclusion
ShopLink est une base claire pour un projet e-commerce multi-rôles en PHP natif. Le fonctionnement global est lisible et couvre les cas d’usage principaux, mais le code a besoin d’une remise à niveau en sécurité, en séparation des responsabilités et en cohérence des routes avant d’être considéré robuste.