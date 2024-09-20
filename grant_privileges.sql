-- Création de l'utilisateur et octroi des privilèges
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'user'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

-- Sélection de la base de données
USE safebase;

-- Configuration de l'encodage
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

use safebase;
-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 18 sep. 2024 à 13:49
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `safebase`
--

-- --------------------------------------------------------

--
-- Structure de la table `alert`
--

DROP TABLE IF EXISTS `alert`;
CREATE TABLE IF NOT EXISTS `alert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `date_execution` varchar(50) NOT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `alert`
--

INSERT INTO `alert` (`id`, `message`, `date_execution`, `ID_DATABASE`) VALUES
(1, 'Echec de la sauvegarde', '2024-09-12', 1),
(2, 'DUMP REUSSI', '2024-09-12', 2),
(3, 'DUMP REUSSI', '2024-09-12', 3),
(4, 'DUMP REUSSI', '2024-09-12', 4);

-- --------------------------------------------------------

--
-- Structure de la table `backup`
--

DROP TABLE IF EXISTS `backup`;
CREATE TABLE IF NOT EXISTS `backup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `version` varchar(50) NOT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client_database`
--

DROP TABLE IF EXISTS `client_database`;
CREATE TABLE IF NOT EXISTS `client_database` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_database` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `port` int DEFAULT NULL,
  `used_type` varchar(255) NOT NULL,
  `ID_Type` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Type` (`ID_Type`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `client_database`
--

INSERT INTO `client_database` (`id`, `nom`, `password`, `user_database`, `url`, `port`, `used_type`, `ID_Type`) VALUES
(43, 'echangeJeune', 'toto', 'root', 'localhost', 0, 'prod', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tache_cron`
--

DROP TABLE IF EXISTS `tache_cron`;
CREATE TABLE IF NOT EXISTS `tache_cron` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `recurrence` varchar(50) NOT NULL,
  `date_demarrage` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `tache_cron`
--

INSERT INTO `tache_cron` (`id`, `nom`, `recurrence`, `date_demarrage`, `heure`, `ID_DATABASE`) VALUES
(7, 'echange', 'journaliere', '2024-09-17', '14:26:00', 43),
(8, 'echange', 'journaliere', '2024-09-17', '14:26:00', 43),
(9, 'echange', 'journaliere', '2024-09-17', '14:26:00', 43),
(10, 'echange', 'journaliere', '2024-09-17', '14:26:00', 43),
(11, 'echange', 'jour', '2024-09-17', '10:00:00', 43),
(12, 'echange', 'jour', '2024-09-17', '10:00:00', 43),
(13, 'echange', 'jour', '2024-09-17', '10:00:00', 43),
(14, 'echange', 'jour', '2024-09-17', '10:00:00', 43);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE IF NOT EXISTS `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `version` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id`, `nom`, `version`) VALUES
(1, 'mysql', '8.00');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client_database`
--
ALTER TABLE `client_database`
  ADD CONSTRAINT `client_database_ibfk_1` FOREIGN KEY (`ID_Type`) REFERENCES `type` (`id`);

--
-- Contraintes pour la table `tache_cron`
--
ALTER TABLE `tache_cron`
  ADD CONSTRAINT `tache_cron_ibfk_1` FOREIGN KEY (`ID_DATABASE`) REFERENCES `client_database` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

SET FOREIGN_KEY_CHECKS = 1;