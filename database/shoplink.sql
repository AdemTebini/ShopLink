-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 17 mai 2026 à 04:00
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `shoplink`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`) VALUES
(1, 'Electronique'),
(2, 'Vetements'),
(3, 'Gaming'),
(4, 'Maison'),
(5, 'Sport'),
(6, 'Beauté'),
(7, 'Accessoires');

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `vendeur_id` int(11) DEFAULT NULL,
  `livreur_id` int(11) DEFAULT NULL,
  `statut` enum('en attente','en attente livraison','en livraison','livree','refusee') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `produit_id` int(11) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1,
  `ville` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `client_id`, `vendeur_id`, `livreur_id`, `statut`, `created_at`, `produit_id`, `nom`, `prenom`, `phone`, `adresse`, `quantite`, `ville`) VALUES
(30, 51, 60, NULL, 'en attente', '2026-05-17 01:40:07', 40, 'Fatma', 'Ghazouani', '95175609', 'Rue de la Republique, 81', 2, 'Tunis'),
(31, 50, 67, 72, 'livree', '2026-05-17 01:40:07', 84, 'Nour', 'Gharbi', '96924247', 'Rue de la Republique, 46', 1, 'Nabeul'),
(32, 41, 61, 77, 'livree', '2026-05-17 01:40:07', 35, 'Aicha', 'Ben Ammar', '97412676', 'Rue de la Republique, 197', 2, 'Ariana'),
(33, 44, 60, NULL, 'refusee', '2026-05-17 01:40:07', 66, 'Sami', 'Mabrouk', '93508837', 'Rue de la Republique, 33', 3, 'Ben Arous'),
(34, 29, 62, NULL, 'refusee', '2026-05-17 01:40:07', 75, 'Farah', 'Trabelsi', '92971656', 'Rue de la Republique, 172', 2, 'Jendouba'),
(35, 37, 65, NULL, 'refusee', '2026-05-17 01:40:07', 42, 'Ali', 'Ben Ali', '93952202', 'Rue de la Republique, 111', 2, 'Sidi Bouzid'),
(36, 25, 58, NULL, 'en attente livraison', '2026-05-17 01:40:07', 41, 'Asma', 'Ayari', '95550766', 'Rue de la Republique, 192', 3, 'Ben Arous'),
(37, 40, 65, 77, 'en livraison', '2026-05-17 01:40:07', 33, 'Sarah', 'Trabelsi', '92485658', 'Rue de la Republique, 64', 2, 'Kasserine'),
(38, 35, 67, NULL, 'en attente', '2026-05-17 01:40:07', 88, 'Ali', 'Louati', '91097267', 'Rue de la Republique, 148', 2, 'Kebili'),
(39, 54, 65, NULL, 'en attente', '2026-05-17 01:40:07', 69, 'Sami', 'Mabrouk', '93022277', 'Rue de la Republique, 73', 3, 'Bizerte'),
(40, 30, 67, NULL, 'refusee', '2026-05-17 01:40:07', 84, 'Karim', 'Ayari', '98784036', 'Rue de la Republique, 102', 2, 'Sousse'),
(41, 42, 67, NULL, 'en attente livraison', '2026-05-17 01:40:07', 45, 'Farah', 'Bouazizi', '95418960', 'Rue de la Republique, 170', 3, 'Jendouba'),
(42, 30, 69, 76, 'livree', '2026-05-17 01:40:07', 89, 'Ahmed', 'Mabrouk', '99586679', 'Rue de la Republique, 80', 3, 'Tunis'),
(43, 41, 59, 77, 'livree', '2026-05-17 01:40:07', 47, 'Sarah', 'Ben Ali', '94881542', 'Rue de la Republique, 53', 4, 'Gafsa'),
(44, 54, 60, NULL, 'en attente', '2026-05-17 01:40:07', 39, 'Omar', 'Ayari', '91973738', 'Rue de la Republique, 86', 4, 'Sfax'),
(45, 40, 59, NULL, 'refusee', '2026-05-17 01:40:07', 21, 'Omar', 'Gharbi', '96819087', 'Rue de la Republique, 164', 2, 'Monastir'),
(46, 39, 67, 78, 'livree', '2026-05-17 01:40:07', 72, 'Mohamed', 'Ben Ammar', '91986927', 'Rue de la Republique, 127', 2, 'Le Kef'),
(47, 46, 67, NULL, 'en attente livraison', '2026-05-17 01:40:07', 44, 'Mariem', 'Ben Ali', '95716364', 'Rue de la Republique, 193', 1, 'Sousse'),
(48, 54, 62, NULL, 'en attente', '2026-05-17 01:40:07', 81, 'Ali', 'Trabelsi', '97560841', 'Rue de la Republique, 11', 3, 'Siliana'),
(49, 42, 67, 73, 'livree', '2026-05-17 01:40:07', 84, 'Hassan', 'Trabelsi', '98825964', 'Rue de la Republique, 156', 1, 'Manouba'),
(50, 43, 61, 72, 'en livraison', '2026-05-17 01:40:07', 54, 'Omar', 'Ghazouani', '99738409', 'Rue de la Republique, 148', 4, 'Gabes'),
(51, 40, 61, NULL, 'refusee', '2026-05-17 01:40:07', 38, 'Aicha', 'Mabrouk', '95520840', 'Rue de la Republique, 69', 4, 'Monastir'),
(52, 52, 64, 77, 'livree', '2026-05-17 01:40:07', 20, 'Asma', 'Mathlouthi', '92192694', 'Rue de la Republique, 62', 3, 'Nabeul'),
(53, 40, 64, NULL, 'en attente livraison', '2026-05-17 01:40:07', 20, 'Mehdi', 'Ben Ammar', '97674172', 'Rue de la Republique, 100', 3, 'Jendouba'),
(54, 30, 60, NULL, 'refusee', '2026-05-17 01:40:07', 26, 'Sarah', 'Mathlouthi', '91216481', 'Rue de la Republique, 129', 3, 'Ben Arous'),
(55, 33, 67, NULL, 'refusee', '2026-05-17 01:40:07', 45, 'Fatma', 'Mathlouthi', '99650969', 'Rue de la Republique, 76', 1, 'Sidi Bouzid'),
(56, 33, 60, NULL, 'en attente livraison', '2026-05-17 01:40:07', 39, 'Khadija', 'Driss', '92832806', 'Rue de la Republique, 196', 4, 'Sousse'),
(57, 37, 58, 76, 'en livraison', '2026-05-17 01:40:07', 70, 'Hassan', 'Louati', '92979740', 'Rue de la Republique, 6', 3, 'Ariana'),
(58, 22, 65, NULL, 'refusee', '2026-05-17 01:40:07', 59, 'Aicha', 'Mabrouk', '93115109', 'Rue de la Republique, 103', 1, 'Ben Arous'),
(59, 23, 62, NULL, 'en attente', '2026-05-17 01:40:07', 75, 'Farah', 'Jelassi', '94890860', 'Rue de la Republique, 127', 4, 'Manouba'),
(60, 54, 67, NULL, 'refusee', '2026-05-17 01:40:07', 84, 'Hassan', 'Ben Ali', '98267710', 'Rue de la Republique, 133', 4, 'Ariana'),
(61, 29, 60, NULL, 'refusee', '2026-05-17 01:40:07', 87, 'Sarah', 'Trabelsi', '93683943', 'Rue de la Republique, 28', 2, 'Nabeul'),
(62, 47, 61, NULL, 'refusee', '2026-05-17 01:40:07', 43, 'Sami', 'Mathlouthi', '98775829', 'Rue de la Republique, 20', 4, 'Monastir'),
(63, 24, 64, 73, 'en livraison', '2026-05-17 01:40:07', 46, 'Nour', 'Ben Ammar', '98060995', 'Rue de la Republique, 67', 1, 'Mahdia'),
(64, 52, 65, 70, 'en livraison', '2026-05-17 01:40:07', 82, 'Asma', 'Trabelsi', '91034624', 'Rue de la Republique, 2', 4, 'Gafsa'),
(65, 30, 69, NULL, 'refusee', '2026-05-17 01:40:07', 24, 'Amine', 'Mabrouk', '92798224', 'Rue de la Republique, 120', 3, 'Nabeul'),
(66, 29, 69, 78, 'en livraison', '2026-05-17 01:40:07', 77, 'Nour', 'Driss', '98004853', 'Rue de la Republique, 73', 1, 'Zaghouan'),
(67, 54, 64, NULL, 'refusee', '2026-05-17 01:40:07', 29, 'Asma', 'Chabbi', '94348535', 'Rue de la Republique, 139', 4, 'Beja'),
(68, 37, 64, NULL, 'en attente', '2026-05-17 01:40:07', 20, 'Khadija', 'Gharbi', '93993169', 'Rue de la Republique, 195', 3, 'Beja'),
(69, 33, 59, 75, 'livree', '2026-05-17 01:40:07', 21, 'Ali', 'Ghazouani', '97229894', 'Rue de la Republique, 161', 3, 'Le Kef'),
(70, 35, 58, NULL, 'en attente', '2026-05-17 01:40:07', 74, 'Karim', 'Trabelsi', '94049778', 'Rue de la Republique, 53', 2, 'Gabes'),
(71, 48, 62, NULL, 'en attente livraison', '2026-05-17 01:40:07', 28, 'Fatma', 'Ayari', '96677333', 'Rue de la Republique, 101', 3, 'Zaghouan'),
(72, 30, 65, 72, 'livree', '2026-05-17 01:40:07', 73, 'Ines', 'Ben Ammar', '98682799', 'Rue de la Republique, 57', 1, 'Sfax'),
(73, 53, 60, NULL, 'refusee', '2026-05-17 01:40:07', 87, 'Mehdi', 'Louati', '97696097', 'Rue de la Republique, 64', 4, 'Bizerte'),
(74, 45, 67, 76, 'livree', '2026-05-17 01:40:07', 44, 'Ahmed', 'Chabbi', '98858926', 'Rue de la Republique, 148', 2, 'Beja'),
(75, 50, 61, NULL, 'refusee', '2026-05-17 01:40:07', 80, 'Youssef', 'Trabelsi', '95452323', 'Rue de la Republique, 29', 3, 'Mahdia'),
(76, 44, 60, 71, 'en livraison', '2026-05-17 01:40:07', 87, 'Yasmine', 'Driss', '94265883', 'Rue de la Republique, 45', 4, 'Tunis'),
(77, 28, 62, 79, 'livree', '2026-05-17 01:40:07', 63, 'Yasmine', 'Jelassi', '96975976', 'Rue de la Republique, 77', 1, 'Sfax'),
(78, 20, 69, 72, 'livree', '2026-05-17 01:40:07', 83, 'Youssef', 'Zouari', '99475692', 'Rue de la Republique, 195', 4, 'Bizerte'),
(79, 38, 60, 76, 'livree', '2026-05-17 01:40:07', 26, 'Sarah', 'Mabrouk', '94884498', 'Rue de la Republique, 173', 3, 'Tunis'),
(80, 36, 62, 76, 'en livraison', '2026-05-17 01:40:07', 75, 'Karim', 'Jelassi', '93971927', 'Rue de la Republique, 47', 1, 'Kairouan'),
(81, 49, 59, NULL, 'en attente', '2026-05-17 01:40:07', 21, 'Asma', 'Mabrouk', '95391392', 'Rue de la Republique, 159', 2, 'Nabeul'),
(82, 40, 62, NULL, 'en attente', '2026-05-17 01:40:07', 78, 'Hassan', 'Louati', '95268680', 'Rue de la Republique, 183', 4, 'Ben Arous'),
(83, 53, 59, 78, 'en livraison', '2026-05-17 01:40:07', 53, 'Mehdi', 'Ben Ammar', '92121061', 'Rue de la Republique, 101', 1, 'Siliana'),
(84, 21, 62, NULL, 'en attente', '2026-05-17 01:40:07', 55, 'Ahmed', 'Ben Ammar', '96894877', 'Rue de la Republique, 163', 1, 'Jendouba'),
(85, 25, 61, NULL, 'en attente', '2026-05-17 01:40:07', 80, 'Mohamed', 'Mathlouthi', '91883505', 'Rue de la Republique, 136', 2, 'Sfax'),
(86, 41, 62, NULL, 'en attente', '2026-05-17 01:40:07', 55, 'Ahmed', 'Trabelsi', '96026502', 'Rue de la Republique, 59', 4, 'Tunis'),
(87, 32, 58, NULL, 'en attente', '2026-05-17 01:40:07', 74, 'Fatma', 'Trabelsi', '99027834', 'Rue de la Republique, 142', 4, 'Gafsa'),
(88, 21, 61, 72, 'en livraison', '2026-05-17 01:40:07', 54, 'Aicha', 'Ben Ammar', '91355421', 'Rue de la Republique, 22', 3, 'Jendouba'),
(89, 50, 60, 72, 'en livraison', '2026-05-17 01:40:07', 31, 'Hassan', 'Trabelsi', '97370851', 'Rue de la Republique, 144', 2, 'Sidi Bouzid');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `note` int(11) DEFAULT NULL CHECK (`note` >= 1 and `note` <= 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `contenu`, `client_id`, `produit_id`, `created_at`, `note`) VALUES
(20, 'Excellent, je vais en racheter un autre pour l\'offrir.', 42, 20, '2026-05-17 01:40:07', 5),
(21, 'Tres pratique, s\'integre parfaitement.', 47, 31, '2026-05-17 01:40:07', 4),
(22, 'Super rapport qualite-prix, bravo.', 27, 50, '2026-05-17 01:40:07', 5),
(23, 'Incroyable, la qualite est au rendez-vous.', 38, 30, '2026-05-17 01:40:07', 3),
(24, 'Incroyable, la qualite est au rendez-vous.', 54, 57, '2026-05-17 01:40:07', 3),
(25, 'Pas mal, fait le job.', 50, 58, '2026-05-17 01:40:07', 5),
(26, 'Couleur legerement differente de la photo, sinon bien.', 29, 48, '2026-05-17 01:40:07', 2),
(27, 'Produit conforme a la description, tres satisfait.', 36, 28, '2026-05-17 01:40:07', 3),
(28, 'Couleur legerement differente de la photo, sinon bien.', 31, 81, '2026-05-17 01:40:07', 5),
(29, 'Super rapport qualite-prix, bravo.', 32, 24, '2026-05-17 01:40:07', 4),
(30, 'Couleur legerement differente de la photo, sinon bien.', 27, 36, '2026-05-17 01:40:07', 5),
(31, 'Pas mal, fait le job.', 45, 84, '2026-05-17 01:40:07', 3),
(32, 'C\'est exactement ce que je cherchais. Merci !', 54, 28, '2026-05-17 01:40:07', 1),
(33, 'Je recommande vivement ce vendeur !', 27, 28, '2026-05-17 01:40:07', 4),
(34, 'Super rapport qualite-prix, bravo.', 49, 71, '2026-05-17 01:40:07', 5),
(35, 'Pas mal, fait le job.', 40, 49, '2026-05-17 01:40:07', 3),
(36, 'C\'est exactement ce que je cherchais. Merci !', 29, 34, '2026-05-17 01:40:07', 4),
(37, 'Super rapport qualite-prix, bravo.', 47, 78, '2026-05-17 01:40:07', 3),
(38, 'Un peu cher pour ce que c\'est, mais fonctionnel.', 44, 70, '2026-05-17 01:40:07', 4),
(39, 'Couleur legerement differente de la photo, sinon bien.', 42, 20, '2026-05-17 01:40:07', 3),
(40, 'La livraison a ete un peu longue, mais le produit est top.', 42, 30, '2026-05-17 01:40:07', 3),
(41, 'Excellent, je vais en racheter un autre pour l\'offrir.', 36, 80, '2026-05-17 01:40:07', 3),
(42, 'Incroyable, la qualite est au rendez-vous.', 31, 85, '2026-05-17 01:40:07', 1),
(43, 'C\'est exactement ce que je cherchais. Merci !', 37, 70, '2026-05-17 01:40:07', 3),
(44, 'Pas mal, fait le job.', 53, 62, '2026-05-17 01:40:07', 5),
(45, 'C\'est exactement ce que je cherchais. Merci !', 42, 34, '2026-05-17 01:40:07', 1),
(46, 'Je recommande vivement ce vendeur !', 30, 60, '2026-05-17 01:40:07', 5),
(47, 'Excellent, je vais en racheter un autre pour l\'offrir.', 43, 49, '2026-05-17 01:40:07', 2),
(48, 'Incroyable, la qualite est au rendez-vous.', 21, 85, '2026-05-17 01:40:07', 5),
(49, 'Je recommande vivement ce vendeur !', 37, 83, '2026-05-17 01:40:07', 2),
(50, 'Super rapport qualite-prix, bravo.', 47, 22, '2026-05-17 01:40:07', 5),
(51, 'C\'est exactement ce que je cherchais. Merci !', 32, 77, '2026-05-17 01:40:07', 4),
(52, 'Couleur legerement differente de la photo, sinon bien.', 34, 28, '2026-05-17 01:40:07', 5),
(53, 'Super rapport qualite-prix, bravo.', 47, 74, '2026-05-17 01:40:07', 1),
(54, 'Super rapport qualite-prix, bravo.', 24, 24, '2026-05-17 01:40:07', 5),
(55, 'C\'est exactement ce que je cherchais. Merci !', 49, 78, '2026-05-17 01:40:07', 3),
(56, 'Couleur legerement differente de la photo, sinon bien.', 25, 71, '2026-05-17 01:40:07', 4),
(57, 'La livraison a ete un peu longue, mais le produit est top.', 30, 82, '2026-05-17 01:40:07', 4),
(58, 'Couleur legerement differente de la photo, sinon bien.', 24, 67, '2026-05-17 01:40:07', 3),
(59, 'Tres pratique, s\'integre parfaitement.', 51, 77, '2026-05-17 01:40:07', 4),
(60, 'Incroyable, la qualite est au rendez-vous.', 31, 88, '2026-05-17 01:40:07', 5),
(61, 'Produit conforme a la description, tres satisfait.', 20, 54, '2026-05-17 01:40:07', 5),
(62, 'Couleur legerement differente de la photo, sinon bien.', 40, 50, '2026-05-17 01:40:07', 4),
(63, 'Super rapport qualite-prix, bravo.', 31, 67, '2026-05-17 01:40:07', 3),
(64, 'Incroyable, la qualite est au rendez-vous.', 33, 27, '2026-05-17 01:40:07', 4),
(65, 'Couleur legerement differente de la photo, sinon bien.', 29, 82, '2026-05-17 01:40:07', 5),
(66, 'Couleur legerement differente de la photo, sinon bien.', 48, 89, '2026-05-17 01:40:07', 3),
(67, 'Incroyable, la qualite est au rendez-vous.', 33, 25, '2026-05-17 01:40:07', 2),
(68, 'Excellent, je vais en racheter un autre pour l\'offrir.', 40, 50, '2026-05-17 01:40:07', 3),
(69, 'Couleur legerement differente de la photo, sinon bien.', 26, 23, '2026-05-17 01:40:07', 5),
(70, 'La livraison a ete un peu longue, mais le produit est top.', 23, 63, '2026-05-17 01:40:07', 3),
(71, 'Excellent, je vais en racheter un autre pour l\'offrir.', 30, 72, '2026-05-17 01:40:07', 4),
(72, 'Un peu cher pour ce que c\'est, mais fonctionnel.', 41, 78, '2026-05-17 01:40:07', 3),
(73, 'Excellent, je vais en racheter un autre pour l\'offrir.', 44, 45, '2026-05-17 01:40:07', 1),
(74, 'Decevant, je m\'attendais a mieux vu le prix.', 30, 21, '2026-05-17 01:40:07', 4),
(75, 'Pas mal, fait le job.', 32, 50, '2026-05-17 01:40:07', 2),
(76, 'Pas mal, fait le job.', 29, 51, '2026-05-17 01:40:07', 5),
(77, 'Super rapport qualite-prix, bravo.', 42, 55, '2026-05-17 01:40:07', 5),
(78, 'Produit conforme a la description, tres satisfait.', 49, 36, '2026-05-17 01:40:07', 2),
(79, 'Produit conforme a la description, tres satisfait.', 22, 69, '2026-05-17 01:40:07', 5),
(80, 'Super rapport qualite-prix, bravo.', 39, 22, '2026-05-17 01:40:07', 4),
(81, 'C\'est exactement ce que je cherchais. Merci !', 21, 64, '2026-05-17 01:40:07', 4),
(82, 'Incroyable, la qualite est au rendez-vous.', 37, 78, '2026-05-17 01:40:07', 5),
(83, 'Produit conforme a la description, tres satisfait.', 44, 67, '2026-05-17 01:40:07', 3),
(84, 'Decevant, je m\'attendais a mieux vu le prix.', 53, 51, '2026-05-17 01:40:07', 5),
(85, 'Tres pratique, s\'integre parfaitement.', 50, 45, '2026-05-17 01:40:07', 3),
(86, 'La livraison a ete un peu longue, mais le produit est top.', 45, 37, '2026-05-17 01:40:07', 2),
(87, 'Pas mal, fait le job.', 40, 69, '2026-05-17 01:40:07', 4),
(88, 'Je recommande vivement ce vendeur !', 46, 71, '2026-05-17 01:40:07', 5),
(89, 'Produit conforme a la description, tres satisfait.', 54, 47, '2026-05-17 01:40:07', 5),
(90, 'La livraison a ete un peu longue, mais le produit est top.', 36, 34, '2026-05-17 01:40:07', 5),
(91, 'Un peu cher pour ce que c\'est, mais fonctionnel.', 27, 22, '2026-05-17 01:40:07', 3),
(92, 'Tres pratique, s\'integre parfaitement.', 47, 89, '2026-05-17 01:40:07', 5),
(93, 'Un peu cher pour ce que c\'est, mais fonctionnel.', 31, 89, '2026-05-17 01:40:07', 1),
(94, 'C\'est exactement ce que je cherchais. Merci !', 28, 22, '2026-05-17 01:40:07', 4),
(95, 'Produit conforme a la description, tres satisfait.', 50, 76, '2026-05-17 01:40:07', 1),
(96, 'Pas mal, fait le job.', 35, 32, '2026-05-17 01:40:07', 4),
(97, 'Pas mal, fait le job.', 27, 64, '2026-05-17 01:40:07', 4),
(98, 'Incroyable, la qualite est au rendez-vous.', 45, 72, '2026-05-17 01:40:07', 5),
(99, 'Excellent, je vais en racheter un autre pour l\'offrir.', 50, 66, '2026-05-17 01:40:07', 4);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `is_read`, `created_at`) VALUES
(10, 28, 58, 'Le prix est deja tres bas, desole.', 1, '2026-05-17 01:40:07'),
(11, 43, 60, 'Est-ce que la livraison est incluse ?', 0, '2026-05-17 01:40:07'),
(12, 53, 67, 'Oui, absolument !', 0, '2026-05-17 01:40:07'),
(13, 32, 64, 'Pouvez-vous me faire un prix ?', 1, '2026-05-17 01:40:07'),
(14, 51, 60, 'Merci pour votre achat !', 1, '2026-05-17 01:40:07'),
(15, 37, 69, 'Pouvez-vous me faire un prix ?', 1, '2026-05-17 01:40:07'),
(16, 25, 58, 'Oui, absolument !', 1, '2026-05-17 01:40:07'),
(17, 46, 62, 'Avez-vous d\'autres couleurs ?', 0, '2026-05-17 01:40:07'),
(18, 20, 61, 'Merci pour votre achat !', 1, '2026-05-17 01:40:07'),
(19, 32, 60, 'Oui, absolument !', 0, '2026-05-17 01:40:07'),
(20, 44, 60, 'Oui, absolument !', 0, '2026-05-17 01:40:07'),
(21, 30, 60, 'Merci pour votre achat !', 1, '2026-05-17 01:40:07'),
(22, 34, 69, 'Bonjour, le produit est-il toujours disponible ?', 1, '2026-05-17 01:40:07'),
(23, 21, 62, 'Le prix est deja tres bas, desole.', 1, '2026-05-17 01:40:07'),
(24, 26, 62, 'D\'accord, je vais le prendre.', 0, '2026-05-17 01:40:07'),
(25, 40, 64, 'Est-ce que la livraison est incluse ?', 1, '2026-05-17 01:40:07'),
(26, 35, 60, 'Non, la livraison est en supplement.', 1, '2026-05-17 01:40:07'),
(27, 51, 67, 'Est-ce que la livraison est incluse ?', 0, '2026-05-17 01:40:07'),
(28, 28, 65, 'Oui, absolument !', 0, '2026-05-17 01:40:07'),
(29, 30, 64, 'Est-ce que la livraison est incluse ?', 1, '2026-05-17 01:40:07'),
(30, 50, 64, 'Avez-vous d\'autres couleurs ?', 0, '2026-05-17 01:40:07'),
(31, 37, 59, 'Parfait, merci.', 0, '2026-05-17 01:40:07'),
(32, 38, 62, 'Le prix est deja tres bas, desole.', 0, '2026-05-17 01:40:07'),
(33, 44, 61, 'Merci pour votre achat !', 1, '2026-05-17 01:40:07'),
(34, 41, 69, 'D\'accord, je vais le prendre.', 1, '2026-05-17 01:40:07'),
(35, 53, 61, 'Pouvez-vous me faire un prix ?', 1, '2026-05-17 01:40:07'),
(36, 36, 65, 'Merci pour votre achat !', 0, '2026-05-17 01:40:07'),
(37, 27, 65, 'D\'accord, je vais le prendre.', 0, '2026-05-17 01:40:07'),
(38, 29, 67, 'Est-ce que la livraison est incluse ?', 0, '2026-05-17 01:40:07'),
(39, 26, 64, 'Bonjour, le produit est-il toujours disponible ?', 1, '2026-05-17 01:40:07'),
(40, 54, 60, 'Oui, absolument !', 1, '2026-05-17 01:40:07'),
(41, 30, 58, 'Le prix est deja tres bas, desole.', 1, '2026-05-17 01:40:07'),
(42, 43, 60, 'Oui, absolument !', 0, '2026-05-17 01:40:07'),
(43, 42, 67, 'Non, c\'est le seul modele.', 1, '2026-05-17 01:40:07'),
(44, 40, 69, 'Bonjour, le produit est-il toujours disponible ?', 1, '2026-05-17 01:40:07'),
(45, 37, 61, 'D\'accord, je vais le prendre.', 1, '2026-05-17 01:40:07'),
(46, 53, 64, 'Est-ce que la livraison est incluse ?', 0, '2026-05-17 01:40:07'),
(47, 31, 65, 'D\'accord, je vais le prendre.', 0, '2026-05-17 01:40:07'),
(48, 53, 64, 'Bonjour, le produit est-il toujours disponible ?', 1, '2026-05-17 01:40:07'),
(49, 42, 59, 'Oui, absolument !', 0, '2026-05-17 01:40:07'),
(50, 20, 58, 'Bonjour Sami, le produit \"Smartphone 743\" est-il toujours disponible ?', 1, '2026-05-17 01:59:02'),
(51, 58, 20, 'Bonjour Youssef. Oui, il est disponible et en stock.', 1, '2026-05-17 01:59:02'),
(52, 20, 58, 'Super ! Pouvez-vous me faire un petit prix ? Je suis vraiment intéressé et prêt à acheter aujourd\'hui.', 1, '2026-05-17 01:59:02'),
(53, 58, 20, 'Le prix est déjà très compétitif, mais je peux vous offrir la livraison gratuite si vous passez commande tout de suite.', 1, '2026-05-17 01:59:02'),
(54, 20, 58, 'C\'est d\'accord, je valide la commande à l\'instant. Merci !', 1, '2026-05-17 01:59:02'),
(55, 58, 20, 'Merci à vous. Je prépare l\'expédition dès que je reçois la confirmation.', 0, '2026-05-17 01:59:02'),
(56, 21, 60, 'Bonjour Mehdi, est-ce que le \"Jeans Slim 121\" taille normalement ou un peu petit ?', 1, '2026-05-17 01:59:02'),
(57, 60, 21, 'Bonjour Nour. Il taille un peu petit. Je vous conseille de prendre une taille au-dessus de votre taille habituelle pour être à l\'aise.', 1, '2026-05-17 01:59:02'),
(58, 21, 60, 'Parfait, je fais du M habituellement, je vais prendre du L alors.', 1, '2026-05-17 01:59:02'),
(59, 60, 21, 'Très bon choix ! N\'hésitez pas si vous avez d\'autres questions. Bonne journée !', 0, '2026-05-17 01:59:02'),
(60, 25, 64, 'Bonjour Hassan, je n\'ai toujours pas reçu ma commande prévue pour ce matin. Est-ce normal ?', 1, '2026-05-17 01:59:02'),
(61, 64, 25, 'Bonjour Sami. Laissez-moi vérifier avec notre livreur. Je reviens vers vous dans 10 minutes.', 1, '2026-05-17 01:59:02'),
(62, 64, 25, 'Je viens d\'avoir le livreur au téléphone, il a eu un petit contretemps sur la route. Votre commande sera livrée en début d\'après-midi. Vraiment désolé pour le retard !', 1, '2026-05-17 01:59:02'),
(63, 25, 64, 'Pas de souci, merci pour la rapidité de votre réponse. J\'attends la livraison.', 0, '2026-05-17 01:59:02'),
(64, 24, 61, 'Coucou ! J\'adore la \"Robe de Soirée 452\". L\'avez-vous en rouge ?', 1, '2026-05-17 01:59:02'),
(65, 61, 24, 'Bonjour Asma ! Malheureusement nous n\'avons plus que du noir et du bleu marine pour ce modèle.', 1, '2026-05-17 01:59:02'),
(66, 24, 61, 'Dommage... Je vais prendre la bleue marine alors. Les photos sur le site sont-elles fidèles à la vraie couleur ?', 1, '2026-05-17 01:59:02'),
(67, 61, 24, 'Oui tout à fait, la couleur est très fidèle et le tissu est d\'excellente qualité, vous ne serez pas déçue !', 0, '2026-05-17 01:59:02'),
(68, 22, 62, 'Bonjour, est-ce que ce produit est sous garantie ?', 1, '2026-05-17 01:59:02'),
(69, 62, 22, 'Bonjour ! Oui, il a une garantie constructeur de 12 mois.', 1, '2026-05-17 01:59:02'),
(70, 22, 62, 'Parfait. Et si j\'ai un problème, je vous le ramène ou je contacte le constructeur ?', 1, '2026-05-17 01:59:02'),
(71, 62, 22, 'Vous passez par moi directement, je m\'occupe du SAV.', 1, '2026-05-17 01:59:02'),
(72, 22, 62, 'Excellent, je passe la commande de suite.', 1, '2026-05-17 01:59:02'),
(73, 62, 22, 'Merci pour votre confiance !', 0, '2026-05-17 01:59:02'),
(74, 23, 59, 'Salut, je suis intéressé par plusieurs articles. Vous faites un prix de gros ?', 1, '2026-05-17 01:59:02'),
(75, 59, 23, 'Bonjour. Oui, à partir de 5 articles je peux vous faire -15%.', 1, '2026-05-17 01:59:02'),
(76, 23, 59, 'Je vais en prendre 6. Comment on fait pour le paiement avec la réduction ?', 1, '2026-05-17 01:59:02'),
(77, 59, 23, 'Passez la commande, choisissez paiement à la livraison, et je déduirai la réduction sur la facture finale.', 1, '2026-05-17 01:59:02'),
(78, 23, 59, 'C\'est noté, commande passée.', 1, '2026-05-17 01:59:02'),
(79, 59, 23, 'Bien reçu, je prépare le colis.', 0, '2026-05-17 01:59:02'),
(80, 26, 65, 'Bonjour, le produit est exactement comme sur la photo ?', 1, '2026-05-17 01:59:02'),
(81, 65, 26, 'Bonjour, oui ce sont nos propres photos, le produit est 100% identique.', 1, '2026-05-17 01:59:02'),
(82, 26, 65, 'D\'accord, car j\'ai eu de mauvaises surprises avec d\'autres vendeurs.', 1, '2026-05-17 01:59:02'),
(83, 65, 26, 'Ne vous inquiétez pas, vous pouvez vérifier le colis avant de payer le livreur.', 1, '2026-05-17 01:59:02'),
(84, 26, 65, 'Super, ça me rassure. Merci.', 1, '2026-05-17 01:59:02'),
(85, 65, 26, 'A votre service !', 0, '2026-05-17 01:59:02'),
(86, 27, 67, 'Bonsoir, l\'article est neuf ou reconditionné ?', 1, '2026-05-17 01:59:02'),
(87, 67, 27, 'Bonsoir, c\'est un article 100% neuf, sous blister.', 1, '2026-05-17 01:59:02'),
(88, 27, 67, 'D\'accord, et vous livrez à Kairouan ?', 1, '2026-05-17 01:59:02'),
(89, 67, 27, 'Oui, la livraison se fait partout en Tunisie en 24/48h.', 1, '2026-05-17 01:59:02'),
(90, 27, 67, 'Parfait, je vais commander.', 1, '2026-05-17 01:59:02'),
(91, 67, 27, 'Merci, bonne soirée.', 0, '2026-05-17 01:59:02'),
(92, 28, 68, 'Salut, est-ce qu\'il y a d\'autres couleurs disponibles ?', 1, '2026-05-17 01:59:02'),
(93, 68, 28, 'Salut, oui nous avons noir, blanc, et bleu.', 1, '2026-05-17 01:59:02'),
(94, 28, 68, 'Le bleu est foncé ou clair ?', 1, '2026-05-17 01:59:02'),
(95, 68, 28, 'C\'est un bleu nuit, assez foncé.', 1, '2026-05-17 01:59:02'),
(96, 28, 68, 'Ok, mettez-moi un bleu s\'il vous plaît.', 1, '2026-05-17 01:59:02'),
(97, 68, 28, 'C\'est noté dans votre dossier. Merci.', 0, '2026-05-17 01:59:02'),
(98, 29, 69, 'Bonjour, je n\'arrive pas à utiliser le code promo.', 1, '2026-05-17 01:59:02'),
(99, 69, 29, 'Bonjour, quel code essayez-vous d\'utiliser ?', 1, '2026-05-17 01:59:02'),
(100, 29, 69, 'Le code BIENVENUE10.', 1, '2026-05-17 01:59:02'),
(101, 69, 29, 'Ce code n\'est valable que pour la première commande. Avez-vous déjà acheté chez nous ?', 1, '2026-05-17 01:59:02'),
(102, 29, 69, 'Ah oui, c\'est ma deuxième commande. Tant pis !', 1, '2026-05-17 01:59:02'),
(103, 69, 29, 'Je vous offre la livraison gratuite exceptionnellement. Passez la commande.', 0, '2026-05-17 01:59:02'),
(104, 30, 55, 'Bonjour, j\'ai passé commande hier, quand est-ce que ça sera expédié ?', 1, '2026-05-17 01:59:02'),
(105, 55, 30, 'Bonjour, votre commande a été remise au livreur ce matin.', 1, '2026-05-17 01:59:02'),
(106, 30, 55, 'Ah super rapide ! Vous avez un numéro de suivi ?', 1, '2026-05-17 01:59:02'),
(107, 55, 30, 'Le livreur va vous appeler d\'ici demain pour fixer le rdv.', 1, '2026-05-17 01:59:02'),
(108, 30, 55, 'Merci beaucoup.', 1, '2026-05-17 01:59:02'),
(109, 55, 30, 'Je vous en prie.', 0, '2026-05-17 01:59:02'),
(110, 31, 56, 'Salut, le produit est cassé à l\'arrivée...', 1, '2026-05-17 01:59:02'),
(111, 56, 31, 'Bonjour, je suis vraiment désolé. Pouvez-vous m\'envoyer une photo ?', 1, '2026-05-17 01:59:02'),
(112, 31, 56, 'Oui je viens de l\'envoyer sur Whatsapp au numéro affiché.', 1, '2026-05-17 01:59:02'),
(113, 56, 31, 'Je vois, c\'est un problème de transport. On vous envoie un remplaçant demain.', 1, '2026-05-17 01:59:02'),
(114, 31, 56, 'Merci pour votre réactivité.', 1, '2026-05-17 01:59:02'),
(115, 56, 31, 'C\'est la moindre des choses, encore désolé.', 0, '2026-05-17 01:59:02'),
(116, 32, 57, 'Bonjour, je veux annuler ma commande numéro 45 s\'il vous plaît.', 1, '2026-05-17 01:59:02'),
(117, 57, 32, 'Bonjour, la commande n\'est pas encore partie. Puis-je savoir pourquoi ?', 1, '2026-05-17 01:59:02'),
(118, 32, 57, 'J\'ai trouvé le même produit moins cher ailleurs.', 1, '2026-05-17 01:59:02'),
(119, 57, 32, 'Je comprends. C\'est annulé, bonne journée.', 1, '2026-05-17 01:59:02'),
(120, 32, 57, 'Merci de votre compréhension.', 1, '2026-05-17 01:59:02'),
(121, 57, 32, 'Au revoir.', 0, '2026-05-17 01:59:02'),
(122, 33, 61, 'Coucou, l\'emballage est comment ? C\'est pour offrir en cadeau.', 1, '2026-05-17 01:59:02'),
(123, 61, 33, 'Bonjour, il vient dans une belle boîte cartonnée avec le logo de la marque.', 1, '2026-05-17 01:59:02'),
(124, 33, 61, 'Est-ce que je peux avoir un ruban ou un mot avec ?', 1, '2026-05-17 01:59:02'),
(125, 61, 33, 'Oui, on peut rajouter une carte avec votre texte gratuitement.', 1, '2026-05-17 01:59:02'),
(126, 33, 61, 'C\'est génial, voici le texte: Joyeux anniversaire mon amour.', 1, '2026-05-17 01:59:02'),
(127, 61, 33, 'C\'est noté, on s\'en occupe !', 0, '2026-05-17 01:59:02'),
(128, 34, 63, 'Bonjour, avez-vous une boutique physique pour voir le produit ?', 1, '2026-05-17 01:59:02'),
(129, 63, 34, 'Bonjour, non nous sommes exclusivement en ligne.', 1, '2026-05-17 01:59:02'),
(130, 34, 63, 'Est-ce que je peux essayer avant d\'acheter ?', 1, '2026-05-17 01:59:02'),
(131, 63, 34, 'Oui, le livreur peut attendre que vous essayiez le vêtement.', 1, '2026-05-17 01:59:02'),
(132, 34, 63, 'Super, je commande de suite.', 1, '2026-05-17 01:59:02'),
(133, 63, 34, 'Merci, à très bientôt.', 0, '2026-05-17 01:59:02'),
(134, 35, 66, 'Bonsoir, c\'est du cuir véritable ?', 1, '2026-05-17 01:59:02'),
(135, 66, 35, 'Bonsoir, oui c\'est du cuir de vachette 100% véritable.', 1, '2026-05-17 01:59:02'),
(136, 35, 66, 'D\'accord, et ça ne s\'abîme pas avec l\'eau ?', 1, '2026-05-17 01:59:02'),
(137, 66, 35, 'Il vaut mieux éviter le contact prolongé avec l\'eau pour préserver le cuir.', 1, '2026-05-17 01:59:02'),
(138, 35, 66, 'Merci pour le conseil.', 1, '2026-05-17 01:59:02'),
(139, 66, 35, 'Avec plaisir.', 0, '2026-05-17 01:59:02');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `categorie_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `prix`, `description`, `image`, `user_id`, `created_at`, `categorie_id`, `stock`) VALUES
(20, 'Smartphone 743', 2308.00, 'Decouvrez cet excellent smartphone issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique10.png', 64, '2026-05-17 01:40:07', 1, 89),
(21, 'Laptop Pro 993', 2190.00, 'Decouvrez cet excellent laptop pro issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique7.png', 59, '2026-05-17 01:40:07', 1, 99),
(22, 'Smart TV 4K 791', 676.00, 'Decouvrez cet excellent smart tv 4k issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique6.png', 59, '2026-05-17 01:40:07', 1, 120),
(23, 'Ecouteurs sans fil 742', 2044.00, 'Decouvrez cet excellent ecouteurs sans fil issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique7.png', 65, '2026-05-17 01:40:07', 1, 23),
(24, 'Tablette Tactile 978', 2428.00, 'Decouvrez cet excellent tablette tactile issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique4.png', 69, '2026-05-17 01:40:07', 1, 104),
(25, 'Appareil Photo 885', 1415.00, 'Decouvrez cet excellent appareil photo issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique4.png', 61, '2026-05-17 01:40:07', 1, 114),
(26, 'Enceinte Bluetooth 431', 1125.00, 'Decouvrez cet excellent enceinte bluetooth issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique9.png', 60, '2026-05-17 01:40:07', 1, 58),
(27, 'Montre Connectee 512', 1644.00, 'Decouvrez cet excellent montre connectee issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique4.png', 65, '2026-05-17 01:40:07', 1, 106),
(28, 'Disque Dur Externe 525', 1243.00, 'Decouvrez cet excellent disque dur externe issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique2.png', 62, '2026-05-17 01:40:07', 1, 79),
(29, 'Chargeur Rapide 999', 1850.00, 'Decouvrez cet excellent chargeur rapide issu de la categorie Electronique. Concu avec soin pour garantir une qualite optimale.', 'Electronique5.png', 64, '2026-05-17 01:40:07', 1, 132),
(30, 'T-Shirt en Coton 303', 1302.00, 'Decouvrez cet excellent t-shirt en coton issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsshelter-dg0uHhW0Fd4-unsplash.jpg', 58, '2026-05-17 01:40:07', 2, 84),
(31, 'Jeans Slim 121', 767.00, 'Decouvrez cet excellent jeans slim issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsmoein-niroumand-6oWEaAgsqvM-unsplash.jpg', 60, '2026-05-17 01:40:07', 2, 140),
(32, 'Veste en Cuir 684', 185.00, 'Decouvrez cet excellent veste en cuir issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementskawah-kaos-dakwah-XsP4kDfzeb4-unsplash.jpg', 59, '2026-05-17 01:40:07', 2, 85),
(33, 'Robe de Soiree 452', 1426.00, 'Decouvrez cet excellent robe de soiree issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementstuananh-blue-JUrNzQiFJB8-unsplash.jpg', 65, '2026-05-17 01:40:07', 2, 13),
(34, 'Manteau 420', 1028.00, 'Decouvrez cet excellent manteau issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsmoein-niroumand-6oWEaAgsqvM-unsplash.jpg', 58, '2026-05-17 01:40:07', 2, 29),
(35, 'Sneakers de Sport 442', 513.00, 'Decouvrez cet excellent sneakers de sport issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsanomaly-WWesmHEgXDs-unsplash.jpg', 61, '2026-05-17 01:40:07', 2, 36),
(36, 'Pull en Laine 175', 892.00, 'Decouvrez cet excellent pull en laine issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsgeoffroy-danest-uhKVcZNBv80-unsplash.jpg', 59, '2026-05-17 01:40:07', 2, 57),
(37, 'Chemise Classique 619', 2245.00, 'Decouvrez cet excellent chemise classique issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementskoray-guler-SV4r7ZlDDXo-unsplash.jpg', 65, '2026-05-17 01:40:07', 2, 50),
(38, 'Pantalon Chino 303', 1055.00, 'Decouvrez cet excellent pantalon chino issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsmediamodifier-F5i3PZXYkvY-unsplash.jpg', 61, '2026-05-17 01:40:07', 2, 96),
(39, 'Survetement Complet 885', 2246.00, 'Decouvrez cet excellent survetement complet issu de la categorie Vetements. Concu avec soin pour garantir une qualite optimale.', 'vetementsmoein-niroumand-6oWEaAgsqvM-unsplash.jpg', 60, '2026-05-17 01:40:07', 2, 13),
(40, 'Console NextGen 292', 944.00, 'Decouvrez cet excellent console nextgen issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingamadej-tauses-RpLs6gFoKBg-unsplash.jpg', 60, '2026-05-17 01:40:07', 3, 46),
(41, 'Manette Sans Fil Pro 786', 1385.00, 'Decouvrez cet excellent manette sans fil pro issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingalexandre-juca-rL61zw9ZBwI-unsplash.jpg', 58, '2026-05-17 01:40:07', 3, 129),
(42, 'Casque Gamer 7.1 663', 317.00, 'Decouvrez cet excellent casque gamer 7.1 issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingsam-pak-WIeJcQrd3Tw-unsplash.jpg', 65, '2026-05-17 01:40:07', 3, 28),
(43, 'Clavier Mecanique 389', 1894.00, 'Decouvrez cet excellent clavier mecanique issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingsayan-majhi-bYknLZygc58-unsplash.jpg', 61, '2026-05-17 01:40:07', 3, 71),
(44, 'Souris Gaming RGB 382', 591.00, 'Decouvrez cet excellent souris gaming rgb issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingsayan-majhi-dwJBqRX8W-o-unsplash.jpg', 67, '2026-05-17 01:40:07', 3, 149),
(45, 'Chaise Ergonomique 556', 2497.00, 'Decouvrez cet excellent chaise ergonomique issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingalexandre-juca-rL61zw9ZBwI-unsplash.jpg', 67, '2026-05-17 01:40:07', 3, 64),
(46, 'Tapis de Souris XXL 714', 1436.00, 'Decouvrez cet excellent tapis de souris xxl issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingandrew-m-kTXF26LzRDA-unsplash.jpg', 64, '2026-05-17 01:40:07', 3, 83),
(47, 'Ecran 144Hz 715', 1442.00, 'Decouvrez cet excellent ecran 144hz issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingsayan-majhi-VMZ5Y7fh2fc-unsplash.jpg', 59, '2026-05-17 01:40:07', 3, 58),
(48, 'Microphone de Stream 489', 1613.00, 'Decouvrez cet excellent microphone de stream issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingsam-pak-WIeJcQrd3Tw-unsplash.jpg', 60, '2026-05-17 01:40:07', 3, 99),
(49, 'Webcam 1080p 643', 312.00, 'Decouvrez cet excellent webcam 1080p issu de la categorie Gaming. Concu avec soin pour garantir une qualite optimale.', 'gamingextremerate--IDi7cIACKs-unsplash.jpg', 64, '2026-05-17 01:40:07', 3, 138),
(50, 'Canape Moderne 3 Places 867', 1547.00, 'Decouvrez cet excellent canape moderne 3 places issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonrebecca-chandler-3_S2XTMGCvs-unsplash.jpg', 64, '2026-05-17 01:40:07', 4, 20),
(51, 'Table a Manger 455', 2183.00, 'Decouvrez cet excellent table a manger issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonspacejoy-TbWzzDaqgRE-unsplash.jpg', 64, '2026-05-17 01:40:07', 4, 71),
(52, 'Lampe Decorative 464', 915.00, 'Decouvrez cet excellent lampe decorative issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonpuscas-adryan-enwU2R7m-bI-unsplash.jpg', 62, '2026-05-17 01:40:07', 4, 43),
(53, 'Tapis Moelleux 687', 1307.00, 'Decouvrez cet excellent tapis moelleux issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonspacejoy-NrdwhqreL8M-unsplash.jpg', 59, '2026-05-17 01:40:07', 4, 96),
(54, 'Vase en Ceramique 274', 305.00, 'Decouvrez cet excellent vase en ceramique issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonpuscas-adryan-DtAKgIz24A8-unsplash.jpg', 61, '2026-05-17 01:40:07', 4, 106),
(55, 'Miroir Mural Rond 194', 970.00, 'Decouvrez cet excellent miroir mural rond issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonmutzii-ZQm_wg8jxhI-unsplash.jpg', 62, '2026-05-17 01:40:07', 4, 86),
(56, 'Etagere Murale en Bois 860', 1421.00, 'Decouvrez cet excellent etagere murale en bois issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonspacejoy-NrdwhqreL8M-unsplash.jpg', 65, '2026-05-17 01:40:07', 4, 69),
(57, 'Cadre Photo Vintage 143', 1632.00, 'Decouvrez cet excellent cadre photo vintage issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonpuscas-adryan-enwU2R7m-bI-unsplash.jpg', 67, '2026-05-17 01:40:07', 4, 119),
(58, 'Fauteuil en Velours 654', 1617.00, 'Decouvrez cet excellent fauteuil en velours issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonpuscas-adryan-jpZt7A0QH2c-unsplash.jpg', 61, '2026-05-17 01:40:07', 4, 141),
(59, 'Horloge Murale Design 266', 2354.00, 'Decouvrez cet excellent horloge murale design issu de la categorie Maison. Concu avec soin pour garantir une qualite optimale.', 'Maisonpuscas-adryan-n854nQPOkRI-unsplash.jpg', 65, '2026-05-17 01:40:07', 4, 60),
(60, 'Halteres 5kg (Paire) 770', 478.00, 'Decouvrez cet excellent halteres 5kg (paire) issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport1.png', 60, '2026-05-17 01:40:07', 5, 7),
(61, 'Tapis de Yoga Antiderapant 421', 2290.00, 'Decouvrez cet excellent tapis de yoga antiderapant issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport14.png', 67, '2026-05-17 01:40:07', 5, 116),
(62, 'Corde a Sauter Pro 680', 634.00, 'Decouvrez cet excellent corde a sauter pro issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport1.png', 62, '2026-05-17 01:40:07', 5, 69),
(63, 'Gourde Isotherme 1L 608', 900.00, 'Decouvrez cet excellent gourde isotherme 1l issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport11.png', 62, '2026-05-17 01:40:07', 5, 52),
(64, 'Sac de Sport 743', 929.00, 'Decouvrez cet excellent sac de sport issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport4.png', 67, '2026-05-17 01:40:07', 5, 121),
(65, 'Bandes de Resistance 820', 411.00, 'Decouvrez cet excellent bandes de resistance issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport7.png', 69, '2026-05-17 01:40:07', 5, 114),
(66, 'Roulette a Abdos 408', 324.00, 'Decouvrez cet excellent roulette a abdos issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport2.png', 60, '2026-05-17 01:40:07', 5, 68),
(67, 'Gants de Musculation 433', 2313.00, 'Decouvrez cet excellent gants de musculation issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport12.png', 64, '2026-05-17 01:40:07', 5, 88),
(68, 'Protege-Tibias 446', 1888.00, 'Decouvrez cet excellent protege-tibias issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport6.png', 64, '2026-05-17 01:40:07', 5, 15),
(69, 'Ballon de Football Officiel 391', 1881.00, 'Decouvrez cet excellent ballon de football officiel issu de la categorie Sport. Concu avec soin pour garantir une qualite optimale.', 'Sport14.png', 65, '2026-05-17 01:40:07', 5, 106),
(70, 'Creme Hydratante de Jour 547', 1725.00, 'Decouvrez cet excellent creme hydratante de jour issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéharper-sunday-dtEy_pEqaIs-unsplash.jpg', 58, '2026-05-17 01:40:07', 6, 57),
(71, 'Serum Anti-Age Visage 503', 1370.00, 'Decouvrez cet excellent serum anti-age visage issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéshamblen-studios-xwM61TPMlYk-unsplash.jpg', 61, '2026-05-17 01:40:07', 6, 138),
(72, 'Rouge a Levres Mat 945', 1775.00, 'Decouvrez cet excellent rouge a levres mat issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéjohanne-pold-jacobsen-vyhYvCiL3QQ-unsplash.jpg', 67, '2026-05-17 01:40:07', 6, 8),
(73, 'Palette de Maquillage Nude 853', 1811.00, 'Decouvrez cet excellent palette de maquillage nude issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéluwadlin-bosman-ejWLfAHa4y8-unsplash.jpg', 65, '2026-05-17 01:40:07', 6, 90),
(74, 'Parfum Eau de Toilette 581', 26.00, 'Decouvrez cet excellent parfum eau de toilette issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautémargalit-toyber-OI-XW5ih1BI-unsplash.jpg', 58, '2026-05-17 01:40:07', 6, 88),
(75, 'Mascara Volume Intense 260', 1603.00, 'Decouvrez cet excellent mascara volume intense issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéjohanne-pold-jacobsen-vyhYvCiL3QQ-unsplash.jpg', 62, '2026-05-17 01:40:07', 6, 122),
(76, 'Fond de Teint Couvrant 595', 1311.00, 'Decouvrez cet excellent fond de teint couvrant issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautésierra-alpha-juliet-rs1dfpQYas8-unsplash.jpg', 64, '2026-05-17 01:40:07', 6, 47),
(77, 'Lotion Tonique Purifiante 926', 2194.00, 'Decouvrez cet excellent lotion tonique purifiante issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéjohanne-pold-jacobsen-vyhYvCiL3QQ-unsplash.jpg', 69, '2026-05-17 01:40:07', 6, 132),
(78, 'Gommage Corps Exfoliant 564', 2025.00, 'Decouvrez cet excellent gommage corps exfoliant issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautéfulvio-ciccolo-iDDGJt3veps-unsplash.jpg', 62, '2026-05-17 01:40:07', 6, 4),
(79, 'Huile Capillaire Reparatrice 741', 328.00, 'Decouvrez cet excellent huile capillaire reparatrice issu de la categorie Beaute. Concu avec soin pour garantir une qualite optimale.', 'Beautésierra-alpha-juliet-Bp9ZmP8Dqxk-unsplash.jpg', 61, '2026-05-17 01:40:07', 6, 6),
(80, 'Montre Classique en Acier 714', 1513.00, 'Decouvrez cet excellent montre classique en acier issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesfaizur-rehman-iwd_99qV7Uk-unsplash.jpg', 61, '2026-05-17 01:40:07', 7, 117),
(81, 'Lunettes de Soleil Polarisees 997', 1086.00, 'Decouvrez cet excellent lunettes de soleil polarisees issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesmouad-nadif-MdNtXJG462k-unsplash.jpg', 62, '2026-05-17 01:40:07', 7, 54),
(82, 'Ceinture en Cuir Veritable 629', 866.00, 'Decouvrez cet excellent ceinture en cuir veritable issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesdanijela-prijovic-bYwMGLut6pQ-unsplash.jpg', 65, '2026-05-17 01:40:07', 7, 109),
(83, 'Sac a Main en Cuir 193', 2473.00, 'Decouvrez cet excellent sac a main en cuir issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesdeepak-singh-7VDBbdUWRUY-unsplash.jpg', 69, '2026-05-17 01:40:07', 7, 113),
(84, 'Portefeuille Homme 423', 2228.00, 'Decouvrez cet excellent portefeuille homme issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesobi-eXPgWceL488-unsplash.jpg', 67, '2026-05-17 01:40:07', 7, 96),
(85, 'Casquette Ajustable 712', 1604.00, 'Decouvrez cet excellent casquette ajustable issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesshamblen-studios-xwM61TPMlYk-unsplash.jpg', 61, '2026-05-17 01:40:07', 7, 30),
(86, 'Bonnet en Laine 378', 788.00, 'Decouvrez cet excellent bonnet en laine issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessorieswilliam-montout-_kv2tkp8qlg-unsplash.jpg', 58, '2026-05-17 01:40:07', 7, 86),
(87, 'Echarpe Douce 890', 923.00, 'Decouvrez cet excellent echarpe douce issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesfirdaus-roslan-nfr_aSoOI18-unsplash.jpg', 60, '2026-05-17 01:40:07', 7, 104),
(88, 'Gants en Cuir Tactiles 639', 2196.00, 'Decouvrez cet excellent gants en cuir tactiles issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessoriesdrew-williams-P7ZUJ5_pViI-unsplash.jpg', 67, '2026-05-17 01:40:07', 7, 102),
(89, 'Bijoux Fantaisie Collier 424', 1466.00, 'Decouvrez cet excellent bijoux fantaisie collier issu de la categorie Accessoires. Concu avec soin pour garantir une qualite optimale.', 'accessorieskrismawan-kadek-9VYig9LmUmE-unsplash.jpg', 69, '2026-05-17 01:40:07', 7, 123);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','vendeur','livreur','admin') NOT NULL,
  `ville` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `telephone` varchar(20) DEFAULT NULL,
  `cin` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `email`, `password`, `role`, `ville`, `created_at`, `status`, `telephone`, `cin`) VALUES
(13, 'admin', 'admin@test.com', '$2y$10$cG7wY0KkztbZXll7hHfNR.VCISUrqtYbOlQcRGI5/FvY7wiLWbXTq', 'admin', 'Ben Arous', '2026-05-11 15:22:18', 'approved', '', ''),
(20, 'Youssef Ben Ali', 'youssef.ben.ali859@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Sidi Bouzid', '2026-05-17 01:40:07', 'approved', '26130111', NULL),
(21, 'Nour Ayari', 'nour.ayari548@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Sfax', '2026-05-17 01:40:07', 'approved', '28375019', NULL),
(22, 'Hassan Zouari', 'hassan.zouari777@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Tozeur', '2026-05-17 01:40:07', 'approved', '26373924', NULL),
(23, 'Ali Gharbi', 'ali.gharbi333@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Tataouine', '2026-05-17 01:40:07', 'approved', '29547394', NULL),
(24, 'Asma Ben Ali', 'asma.ben.ali886@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Gafsa', '2026-05-17 01:40:07', 'approved', '26560631', NULL),
(25, 'Sami Trabelsi', 'sami.trabelsi531@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Bizerte', '2026-05-17 01:40:07', 'approved', '26864907', NULL),
(26, 'Fatma Gharbi', 'fatma.gharbi606@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Gafsa', '2026-05-17 01:40:07', 'approved', '22178580', NULL),
(27, 'Mehdi Ghazouani', 'mehdi.ghazouani543@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Nabeul', '2026-05-17 01:40:07', 'approved', '24696244', NULL),
(28, 'Mehdi Ayari', 'mehdi.ayari191@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Gafsa', '2026-05-17 01:40:07', 'approved', '23562094', NULL),
(29, 'Ali Driss', 'ali.driss936@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Sidi Bouzid', '2026-05-17 01:40:07', 'approved', '27656641', NULL),
(30, 'Farah Ben Ammar', 'farah.ben.ammar982@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Kasserine', '2026-05-17 01:40:07', 'approved', '22249068', NULL),
(31, 'Ahmed Ben Ammar', 'ahmed.ben.ammar151@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Sidi Bouzid', '2026-05-17 01:40:07', 'approved', '26323162', NULL),
(32, 'Sarah Gharbi', 'sarah.gharbi244@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Ariana', '2026-05-17 01:40:07', 'approved', '24161071', NULL),
(33, 'Sami Khemiri', 'sami.khemiri319@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Beja', '2026-05-17 01:40:07', 'approved', '23767098', NULL),
(34, 'Asma Louati', 'asma.louati146@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Nabeul', '2026-05-17 01:40:07', 'approved', '21568441', NULL),
(35, 'Ali Jelassi', 'ali.jelassi981@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Zaghouan', '2026-05-17 01:40:07', 'approved', '28862444', NULL),
(36, 'Hassan Ben Ali', 'hassan.ben.ali51@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Kasserine', '2026-05-17 01:40:07', 'approved', '28446902', NULL),
(37, 'Mohamed Gharbi', 'mohamed.gharbi355@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Manouba', '2026-05-17 01:40:07', 'approved', '21171661', NULL),
(38, 'Omar Gharbi', 'omar.gharbi75@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Sidi Bouzid', '2026-05-17 01:40:07', 'approved', '29836889', NULL),
(39, 'Asma Zouari', 'asma.zouari178@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Ariana', '2026-05-17 01:40:07', 'approved', '27088890', NULL),
(40, 'Mehdi Khemiri', 'mehdi.khemiri448@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Manouba', '2026-05-17 01:40:07', 'approved', '25805652', NULL),
(41, 'Hassan Ayari', 'hassan.ayari393@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Zaghouan', '2026-05-17 01:40:07', 'approved', '23832424', NULL),
(42, 'Yasmine Ghazouani', 'yasmine.ghazouani691@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Manouba', '2026-05-17 01:40:07', 'approved', '24747590', NULL),
(43, 'Yasmine Khemiri', 'yasmine.khemiri32@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Tunis', '2026-05-17 01:40:07', 'approved', '21404292', NULL),
(44, 'Hassan Trabelsi', 'hassan.trabelsi333@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Kebili', '2026-05-17 01:40:07', 'approved', '24662791', NULL),
(45, 'Ahmed Ben Ammar', 'ahmed.ben.ammar17@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Gafsa', '2026-05-17 01:40:07', 'approved', '29819506', NULL),
(46, 'Ali Zouari', 'ali.zouari176@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Kebili', '2026-05-17 01:40:07', 'approved', '28005891', NULL),
(47, 'Sami Ben Ali', 'sami.ben.ali717@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Ariana', '2026-05-17 01:40:07', 'approved', '21734343', NULL),
(48, 'Sarah Gharbi', 'sarah.gharbi228@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Nabeul', '2026-05-17 01:40:07', 'approved', '22743315', NULL),
(49, 'Hassan Ghazouani', 'hassan.ghazouani263@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Tataouine', '2026-05-17 01:40:07', 'approved', '24061641', NULL),
(50, 'Sarah Ghazouani', 'sarah.ghazouani508@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Medenine', '2026-05-17 01:40:07', 'approved', '24375225', NULL),
(51, 'Khadija Chabbi', 'khadija.chabbi88@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Beja', '2026-05-17 01:40:07', 'approved', '21390654', NULL),
(52, 'Sarah Mathlouthi', 'sarah.mathlouthi864@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Kasserine', '2026-05-17 01:40:07', 'approved', '27420429', NULL),
(53, 'Karim Gharbi', 'karim.gharbi799@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Sfax', '2026-05-17 01:40:07', 'approved', '29628334', NULL),
(54, 'Asma Ghazouani', 'asma.ghazouani714@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'client', 'Bizerte', '2026-05-17 01:40:07', 'approved', '27829017', NULL),
(55, 'Hassan Zouari', 'hassan.zouari685@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Le Kef', '2026-05-17 01:40:07', 'pending', '26940576', NULL),
(56, 'Sarah Mabrouk', 'sarah.mabrouk527@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Mahdia', '2026-05-17 01:40:07', 'pending', '26684642', NULL),
(57, 'Youssef Trabelsi', 'youssef.trabelsi218@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Ariana', '2026-05-17 01:40:07', 'pending', '26725094', NULL),
(58, 'Sami Bouazizi', 'sami.bouazizi762@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Le Kef', '2026-05-17 01:40:07', 'approved', '25599084', NULL),
(59, 'Farah Mathlouthi', 'farah.mathlouthi351@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Gabes', '2026-05-17 01:40:07', 'approved', '27630284', NULL),
(60, 'Mehdi Khemiri', 'mehdi.khemiri281@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Monastir', '2026-05-17 01:40:07', 'approved', '27114309', NULL),
(61, 'Aicha Mabrouk', 'aicha.mabrouk260@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Zaghouan', '2026-05-17 01:40:07', 'approved', '24838639', NULL),
(62, 'Mohamed Jelassi', 'mohamed.jelassi436@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Monastir', '2026-05-17 01:40:07', 'approved', '24130530', NULL),
(63, 'Ahmed Bouazizi', 'ahmed.bouazizi827@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Mahdia', '2026-05-17 01:40:07', 'pending', '27518657', NULL),
(64, 'Hassan Ben Ali', 'hassan.ben.ali915@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Nabeul', '2026-05-17 01:40:07', 'approved', '29131725', NULL),
(65, 'Hassan Ghazouani', 'hassan.ghazouani366@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Monastir', '2026-05-17 01:40:07', 'approved', '27640634', NULL),
(66, 'Youssef Mabrouk', 'youssef.mabrouk237@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Sousse', '2026-05-17 01:40:07', 'pending', '22596622', NULL),
(67, 'Ahmed Driss', 'ahmed.driss92@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Ben Arous', '2026-05-17 01:40:07', 'approved', '27961040', NULL),
(68, 'Sami Bouazizi', 'sami.bouazizi755@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Manouba', '2026-05-17 01:40:07', 'pending', '25960148', NULL),
(69, 'Khadija Khemiri', 'khadija.khemiri639@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'vendeur', 'Ben Arous', '2026-05-17 01:40:07', 'approved', '22328345', NULL),
(70, 'Sarah Trabelsi', 'sarah.trabelsi543@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Tozeur', '2026-05-17 01:40:07', 'approved', '26382144', NULL),
(71, 'Sarah Chabbi', 'sarah.chabbi99@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Mahdia', '2026-05-17 01:40:07', 'approved', '25013915', NULL),
(72, 'Ali Louati', 'ali.louati930@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Kairouan', '2026-05-17 01:40:07', 'approved', '27337818', NULL),
(73, 'Amine Jelassi', 'amine.jelassi472@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Sousse', '2026-05-17 01:40:07', 'approved', '25480465', NULL),
(74, 'Youssef Khemiri', 'youssef.khemiri670@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Siliana', '2026-05-17 01:40:07', 'pending', '29638594', NULL),
(75, 'Fatma Zouari', 'fatma.zouari24@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Beja', '2026-05-17 01:40:07', 'approved', '27098627', NULL),
(76, 'Sarah Bouazizi', 'sarah.bouazizi440@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Monastir', '2026-05-17 01:40:07', 'approved', '22503458', NULL),
(77, 'Ines Trabelsi', 'ines.trabelsi849@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Manouba', '2026-05-17 01:40:07', 'approved', '26350550', NULL),
(78, 'Ines Ayari', 'ines.ayari514@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Tataouine', '2026-05-17 01:40:07', 'approved', '26101749', NULL),
(79, 'Nour Khemiri', 'nour.khemiri755@example.com', '$2y$12$tbf0h1yxWzEmN65GQhXhkeu6CHEAwG4gFLB718XzPQoCEhdkCzfKa', 'livreur', 'Zaghouan', '2026-05-17 01:40:07', 'approved', '28018117', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `vendeur_id` (`vendeur_id`),
  ADD KEY `livreur_id` (`livreur_id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`vendeur_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commandes_ibfk_3` FOREIGN KEY (`livreur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `produits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produits_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
