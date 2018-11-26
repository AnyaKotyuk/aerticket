-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: mysql    Database: aer
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `airport`
--

DROP TABLE IF EXISTS `airport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `airport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `airport_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `airport`
--

LOCK TABLES `airport` WRITE;
/*!40000 ALTER TABLE `airport` DISABLE KEYS */;
INSERT INTO `airport` VALUES (1,'ABC');
/*!40000 ALTER TABLE `airport` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `raices`
--

DROP TABLE IF EXISTS `raices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `raices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transporter` int(11) NOT NULL,
  `flightNumber` varchar(20) NOT NULL,
  `departureTime` datetime NOT NULL,
  `arrivalTime` datetime NOT NULL,
  `arrivalAirport` varchar(30) NOT NULL,
  `departureAirport` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `raices_departureAirport_arrivalAirport_index` (`departureAirport`,`arrivalAirport`),
  KEY `raices-aairport___fk` (`arrivalAirport`),
  KEY `raices-transporter___fk` (`transporter`),
  CONSTRAINT `raices-aairport___fk` FOREIGN KEY (`arrivalAirport`) REFERENCES `airport` (`name`),
  CONSTRAINT `raices-dairport___fk` FOREIGN KEY (`departureAirport`) REFERENCES `airport` (`name`),
  CONSTRAINT `raices-transporter___fk` FOREIGN KEY (`transporter`) REFERENCES `transporter` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `raices`
--

LOCK TABLES `raices` WRITE;
/*!40000 ALTER TABLE `raices` DISABLE KEYS */;
INSERT INTO `raices` VALUES (1,1,'1','2018-11-25 14:51:01','2018-11-26 14:51:04','ABC','ABC');
/*!40000 ALTER TABLE `raices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporter`
--

DROP TABLE IF EXISTS `transporter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transporter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transporter_name_uindex` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporter`
--

LOCK TABLES `transporter` WRITE;
/*!40000 ALTER TABLE `transporter` DISABLE KEYS */;
INSERT INTO `transporter` VALUES (1,'cdn','CDN');
/*!40000 ALTER TABLE `transporter` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-25 15:28:43
