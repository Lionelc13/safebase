-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 06 sep. 2024 à 14:32
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
  KEY `ID_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bachup`
--

DROP TABLE IF EXISTS `bachup`;
CREATE TABLE IF NOT EXISTS `bachup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `version` datetime NOT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ID_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `ID_TYPE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ID_TYPE` (`ID_TYPE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  KEY `ID_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
