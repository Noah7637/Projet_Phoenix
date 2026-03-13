-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 16 jan. 2026 à 11:00
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `phoenix`
--

-- --------------------------------------------------------

--
-- Structure de la table `tp_accounts`
--

DROP TABLE IF EXISTS `tp_accounts`;
CREATE TABLE IF NOT EXISTS `tp_accounts` (
  `id_account` int NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `adress` varchar(100) DEFAULT NULL,
  `tel` varchar(15) DEFAULT NULL,
  `num_carte` varchar(16) DEFAULT NULL,
  `crypto` varchar(3) DEFAULT NULL,
  `conditions` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_account`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table des comptes utilisateurs';

-- --------------------------------------------------------

--
-- Structure de la table `tp_category`
--

DROP TABLE IF EXISTS `tp_category`;
CREATE TABLE IF NOT EXISTS `tp_category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name_category` varchar(20) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table des catégories de voyages';

--
-- Déchargement des données de la table `tp_category`
--

INSERT INTO `tp_category` (`id_category`, `name_category`) VALUES
(1, 'Montagne'),
(2, 'Plage'),
(3, 'Ville'),
(4, 'Campagne'),
(5, 'Aventure');

-- --------------------------------------------------------

--
-- Structure de la table `tp_orders`
--

DROP TABLE IF EXISTS `tp_orders`;
CREATE TABLE IF NOT EXISTS `tp_orders` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `reference` varchar(8) NOT NULL,
  `id_account` int NOT NULL,
  `id_travel` int NOT NULL,
  `nb_personne` int NOT NULL,
  `nb_week` int NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`id_order`),
  UNIQUE KEY `reference` (`reference`),
  KEY `idx_orders_account` (`id_account`),
  KEY `idx_orders_travel` (`id_travel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table des commandes de voyages';

-- --------------------------------------------------------

--
-- Structure de la table `tp_travels`
--

DROP TABLE IF EXISTS `tp_travels`;
CREATE TABLE IF NOT EXISTS `tp_travels` (
  `id_travel` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `price` float NOT NULL,
  `id_category` int NOT NULL,
  PRIMARY KEY (`id_travel`),
  KEY `idx_travels_category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='Table des voyages disponibles';

--
-- Déchargement des données de la table `tp_travels`
--

INSERT INTO `tp_travels` (`id_travel`, `name`, `description`, `image`, `price`, `id_category`) VALUES
(1, 'Les Boucaniers', 'Après les eaux calmes, partez à la découverte des spectaculaires cascades des gorges de la Falaise, à Trinité.', 'caraibes_martinique_boucaniers.jpg', 1600, 5),
(2, 'Kamarina', 'Bienvenue au pays de l’Etna où ruelles escarpées et places en fleurs s’ouvrent sur la Méditerranée !', 'sicile_kamarina.jpg', 1300, 2);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tp_orders`
--
ALTER TABLE `tp_orders`
  ADD CONSTRAINT `tp_orders_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `tp_accounts` (`id_account`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `tp_orders_ibfk_2` FOREIGN KEY (`id_travel`) REFERENCES `tp_travels` (`id_travel`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `tp_travels`
--
ALTER TABLE `tp_travels`
  ADD CONSTRAINT `tp_travels_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `tp_category` (`id_category`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
