-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: safebase
-- ------------------------------------------------------
-- Server version	8.0.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alert`
--

DROP TABLE IF EXISTS `alert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` varchar(255) DEFAULT NULL,
  `date_execution` varchar(50) NOT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alert`
--

LOCK TABLES `alert` WRITE;
/*!40000 ALTER TABLE `alert` DISABLE KEYS */;
INSERT INTO `alert` VALUES (1,'Echec de la sauvegarde','2024-09-12',1),(2,'DUMP REUSSI','2024-09-12',2),(3,'DUMP REUSSI','2024-09-12',3),(4,'DUMP REUSSI','2024-09-12',4);
/*!40000 ALTER TABLE `alert` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `version` varchar(50) NOT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATABASE` (`ID_DATABASE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_database`
--

DROP TABLE IF EXISTS `client_database`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client_database` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_database` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `port` int DEFAULT NULL,
  `used_type` varchar(255) NOT NULL,
  `ID_Type` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Type` (`ID_Type`),
  CONSTRAINT `client_database_ibfk_1` FOREIGN KEY (`ID_Type`) REFERENCES `type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_database`
--

LOCK TABLES `client_database` WRITE;
/*!40000 ALTER TABLE `client_database` DISABLE KEYS */;
INSERT INTO `client_database` VALUES (44,'echangeJeune','toto','root','localhost',0,'prod',1),(45,'echangeJeune','sdfgh','sdfg','localhost',0,'prod',1),(46,'echangeJeune','dfg','sdf','dfg',0,'prod',1),(47,'safebase','toto','root','localhost',0,'prod',1),(48,'safebase','toto','root','localhost',0,'prod',1),(49,'safebase','toto','root','localhost',0,'prod',1);
/*!40000 ALTER TABLE `client_database` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tache_cron`
--

DROP TABLE IF EXISTS `tache_cron`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tache_cron` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `recurrence` varchar(50) NOT NULL,
  `date_demarrage` date DEFAULT NULL,
  `heure` time DEFAULT NULL,
  `ID_DATABASE` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_DATABASE` (`ID_DATABASE`),
  CONSTRAINT `tache_cron_ibfk_1` FOREIGN KEY (`ID_DATABASE`) REFERENCES `client_database` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tache_cron`
--

LOCK TABLES `tache_cron` WRITE;
/*!40000 ALTER TABLE `tache_cron` DISABLE KEYS */;
INSERT INTO `tache_cron` VALUES (37,'echange','journaliere','2024-09-23','14:00:00',47),(38,'echange','journaliere','2024-09-23','14:00:00',47),(39,'echange','journaliere','2024-09-23','14:00:00',47),(40,'echange','journaliere','2024-09-23','14:00:00',47),(41,'echange','journaliere','2024-09-23','14:00:00',47);
/*!40000 ALTER TABLE `tache_cron` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `type`
--

DROP TABLE IF EXISTS `type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `version` decimal(15,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `type`
--

LOCK TABLES `type` WRITE;
/*!40000 ALTER TABLE `type` DISABLE KEYS */;
INSERT INTO `type` VALUES (1,'mysql',8.00);
/*!40000 ALTER TABLE `type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-23 14:03:59
