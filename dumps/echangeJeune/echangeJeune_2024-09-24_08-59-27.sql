-- MySQL dump 10.13  Distrib 8.0.31, for Win64 (x86_64)
--
-- Host: localhost    Database: echangeJeune
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
-- Table structure for table `appartenir`
--

DROP TABLE IF EXISTS `appartenir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appartenir` (
  `id_etu` int NOT NULL,
  `id_esp` int NOT NULL,
  `e_nbr` int NOT NULL,
  PRIMARY KEY (`id_etu`,`id_esp`),
  KEY `id_esp` (`id_esp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appartenir`
--

LOCK TABLES `appartenir` WRITE;
/*!40000 ALTER TABLE `appartenir` DISABLE KEYS */;
/*!40000 ALTER TABLE `appartenir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chambre`
--

DROP TABLE IF EXISTS `chambre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chambre` (
  `id_etu` int NOT NULL,
  `i_tai` int NOT NULL,
  `v_con` varchar(50) DEFAULT NULL,
  `v_pho` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_etu`),
  CONSTRAINT `TMIN` CHECK ((`I_tai` > 8))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chambre`
--

LOCK TABLES `chambre` WRITE;
/*!40000 ALTER TABLE `chambre` DISABLE KEYS */;
INSERT INTO `chambre` VALUES (1,10,NULL,NULL);
/*!40000 ALTER TABLE `chambre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `espece`
--

DROP TABLE IF EXISTS `espece`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `espece` (
  `id_esp` int NOT NULL,
  `lib_esp` varchar(25) NOT NULL,
  PRIMARY KEY (`id_esp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `espece`
--

LOCK TABLES `espece` WRITE;
/*!40000 ALTER TABLE `espece` DISABLE KEYS */;
/*!40000 ALTER TABLE `espece` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudiant`
--

DROP TABLE IF EXISTS `etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudiant` (
  `id_etu` int NOT NULL AUTO_INCREMENT,
  `v_nom_etu` varchar(50) NOT NULL,
  `v_pre_etu` varchar(25) NOT NULL,
  `v_pas` varchar(255) NOT NULL,
  `v_ema` varchar(50) NOT NULL,
  `d_nais_etu` date NOT NULL,
  `v_reg` varchar(50) DEFAULT NULL,
  `v_phot_Per` varchar(50) DEFAULT NULL,
  `v_pho_Fam` varchar(50) DEFAULT NULL,
  `v_pho_ide` varchar(50) DEFAULT NULL,
  `id_vil` int DEFAULT NULL,
  PRIMARY KEY (`id_etu`),
  UNIQUE KEY `uni_email` (`v_ema`),
  KEY `fk_ville_etu` (`id_vil`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudiant`
--

LOCK TABLES `etudiant` WRITE;
/*!40000 ALTER TABLE `etudiant` DISABLE KEYS */;
INSERT INTO `etudiant` VALUES (1,'CANAL','Lionel','$2y$10$x3fSt8fjIbYPvSGD4kzyKuY5BKYvKOI9zCE3c.CF6fPlR2C1zIUXm','lionelc.13@gmail.com','1980-09-19',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `etudiant` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `recup_id` AFTER INSERT ON `etudiant` FOR EACH ROW BEGIN
 		insert into tampon values (new.id_etu, new.v_ema);
	END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `etudier`
--

DROP TABLE IF EXISTS `etudier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etudier` (
  `id_etu` int NOT NULL,
  `id_vil` int NOT NULL,
  `id_sta` int NOT NULL,
  `d_deb` date DEFAULT NULL,
  `d_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_etu`,`id_vil`,`id_sta`),
  KEY `id_vil` (`id_vil`),
  KEY `id_sta` (`id_sta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudier`
--

LOCK TABLES `etudier` WRITE;
/*!40000 ALTER TABLE `etudier` DISABLE KEYS */;
/*!40000 ALTER TABLE `etudier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation`
--

DROP TABLE IF EXISTS `evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation` (
  `id_eva` int NOT NULL AUTO_INCREMENT,
  `v_com` varchar(255) NOT NULL,
  `i_eto` int NOT NULL,
  `id_etu` int NOT NULL,
  PRIMARY KEY (`id_eva`),
  UNIQUE KEY `uni_etudiant` (`id_etu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation`
--

LOCK TABLES `evaluation` WRITE;
/*!40000 ALTER TABLE `evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facture`
--

DROP TABLE IF EXISTS `facture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `facture` (
  `no_fac` int NOT NULL AUTO_INCREMENT,
  `d_ht_fac` decimal(4,2) NOT NULL,
  `d_tva_fac` decimal(4,2) NOT NULL,
  `d_fac` date NOT NULL,
  `d_val` date NOT NULL,
  `id_etu` int NOT NULL,
  PRIMARY KEY (`no_fac`),
  KEY `fk_etudiant_fac` (`id_etu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facture`
--

LOCK TABLES `facture` WRITE;
/*!40000 ALTER TABLE `facture` DISABLE KEYS */;
/*!40000 ALTER TABLE `facture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lien`
--

DROP TABLE IF EXISTS `lien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lien` (
  `id_lie` int NOT NULL AUTO_INCREMENT,
  `v_lib_lie` varchar(25) NOT NULL,
  PRIMARY KEY (`id_lie`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lien`
--

LOCK TABLES `lien` WRITE;
/*!40000 ALTER TABLE `lien` DISABLE KEYS */;
INSERT INTO `lien` VALUES (1,'mère'),(2,'père'),(3,'frère'),(4,'belle-mère'),(5,'beau-père'),(6,'beau-frère'),(7,'belle -soeur'),(8,'grand-père'),(9,' grand-mère'),(10,'oncle'),(11,'tante'),(12,'étudiant'),(13,'ami'),(14,'amie'),(15,'cousin'),(16,'cousine'),(17,'autre');
/*!40000 ALTER TABLE `lien` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membre`
--

DROP TABLE IF EXISTS `membre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `membre` (
  `id_mem` int NOT NULL AUTO_INCREMENT,
  `d_nai_mem` date DEFAULT NULL,
  `v_nom_mem` varchar(50) DEFAULT NULL,
  `v_pre_mem` varchar(25) DEFAULT NULL,
  `id_etu` int NOT NULL,
  `id_Lie` int NOT NULL,
  `d_ins` date DEFAULT (curdate()),
  PRIMARY KEY (`id_mem`),
  KEY `fk_etudiant_mem` (`id_etu`),
  KEY `fk_lien_mem` (`id_Lie`),
  CONSTRAINT `date_inf_now` CHECK ((`d_nai_mem` < `d_ins`))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membre`
--

LOCK TABLES `membre` WRITE;
/*!40000 ALTER TABLE `membre` DISABLE KEYS */;
INSERT INTO `membre` VALUES (1,'2024-01-14','Nathalie','Nathalie',1,2,'2024-02-02');
/*!40000 ALTER TABLE `membre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statut`
--

DROP TABLE IF EXISTS `statut`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `statut` (
  `id_sta` int NOT NULL,
  `v_lib_sta` varchar(20) NOT NULL,
  PRIMARY KEY (`id_sta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statut`
--

LOCK TABLES `statut` WRITE;
/*!40000 ALTER TABLE `statut` DISABLE KEYS */;
/*!40000 ALTER TABLE `statut` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tampon`
--

DROP TABLE IF EXISTS `tampon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tampon` (
  `id` int DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tampon`
--

LOCK TABLES `tampon` WRITE;
/*!40000 ALTER TABLE `tampon` DISABLE KEYS */;
/*!40000 ALTER TABLE `tampon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ville`
--

DROP TABLE IF EXISTS `ville`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ville` (
  `id_vil` int NOT NULL AUTO_INCREMENT,
  `cp` char(5) DEFAULT NULL,
  `v_vil` varchar(50) NOT NULL,
  PRIMARY KEY (`id_vil`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ville`
--

LOCK TABLES `ville` WRITE;
/*!40000 ALTER TABLE `ville` DISABLE KEYS */;
/*!40000 ALTER TABLE `ville` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-24 10:59:32
