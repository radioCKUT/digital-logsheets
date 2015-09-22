-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: c9
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'all spoken word'),(2,'general music'),(3,'jazz, classical & traditional music'),(4,'musical productions'),(5,'ads, promos');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `episode`
--

DROP TABLE IF EXISTS `episode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `episode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `playlist` int(11) NOT NULL,
  `program` int(11) NOT NULL,
  `programmer` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `program` (`program`),
  KEY `programmer` (`programmer`),
  CONSTRAINT `episode_ibfk_2` FOREIGN KEY (`program`) REFERENCES `program` (`id`),
  CONSTRAINT `episode_ibfk_3` FOREIGN KEY (`programmer`) REFERENCES `programmer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `episode`
--

LOCK TABLES `episode` WRITE;
/*!40000 ALTER TABLE `episode` DISABLE KEYS */;
INSERT INTO `episode` VALUES (7,129,1,3,'2000-00-06 00:00:00','2000-00-08 00:00:00'),(8,130,1,4,'2000-00-06 00:00:06','2000-00-06 00:00:08'),(9,131,1,5,'2015-00-06 00:00:06','2015-00-06 00:00:08'),(10,188,1,13,'2015-08-03 10:00:00','2015-08-03 11:00:00'),(11,189,1,14,'2015-08-03 10:00:00','2015-08-03 11:00:00'),(12,196,1,20,'2015-08-21 01:00:00','2015-08-21 02:00:00'),(13,197,1,21,'2015-08-19 01:01:00','2015-08-20 01:01:00'),(14,198,1,22,'2015-07-29 01:01:00','2015-08-24 01:02:00'),(15,199,1,23,'2015-09-09 11:00:00','2015-09-10 00:00:00');
/*!40000 ALTER TABLE `episode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genre`
--

LOCK TABLES `genre` WRITE;
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
INSERT INTO `genre` VALUES (1,'rpm'),(5,'loud'),(6,'jazz');
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist`
--

LOCK TABLES `playlist` WRITE;
/*!40000 ALTER TABLE `playlist` DISABLE KEYS */;
INSERT INTO `playlist` VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(14),(15),(16),(17),(18),(19),(20),(21),(22),(23),(24),(25),(26),(27),(28),(29),(30),(31),(32),(33),(34),(35),(36),(37),(38),(39),(40),(41),(42),(43),(44),(45),(46),(47),(48),(49),(50),(51),(52),(53),(54),(55),(56),(57),(58),(59),(60),(61),(62),(63),(64),(65),(66),(67),(68),(69),(70),(71),(72),(73),(74),(75),(76),(77),(78),(79),(80),(81),(82),(83),(84),(85),(86),(87),(88),(89),(90),(91),(92),(93),(94),(95),(96),(97),(98),(99),(100),(101),(102),(103),(104),(105),(106),(107),(108),(109),(110),(111),(112),(113),(114),(115),(116),(117),(118),(119),(120),(121),(122),(123),(124),(125),(126),(127),(128),(129),(130),(131),(132),(133),(134),(135),(136),(137),(138),(139),(140),(141),(142),(143),(144),(145),(146),(147),(148),(149),(150),(151),(152),(153),(154),(155),(156),(157),(158),(159),(160),(161),(162),(163),(164),(165),(166),(167),(168),(169),(170),(171),(172),(173),(174),(175),(176),(177),(178),(179),(180),(181),(182),(183),(184),(185),(186),(187),(188),(189),(190),(191),(192),(193),(194),(195),(196),(197),(198),(199);
/*!40000 ALTER TABLE `playlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist_segments`
--

DROP TABLE IF EXISTS `playlist_segments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist_segments` (
  `playlist` int(11) NOT NULL,
  `segment` int(11) NOT NULL,
  KEY `id` (`playlist`),
  KEY `segment` (`segment`),
  CONSTRAINT `playlist_segments_ibfk_2` FOREIGN KEY (`segment`) REFERENCES `segment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist_segments`
--

LOCK TABLES `playlist_segments` WRITE;
/*!40000 ALTER TABLE `playlist_segments` DISABLE KEYS */;
INSERT INTO `playlist_segments` VALUES (49,14),(49,15),(50,16),(50,17),(51,18),(51,19),(69,21),(70,22),(70,23),(70,24),(71,25),(71,26),(85,27),(86,28),(87,29),(88,30),(89,31),(90,32),(91,33),(92,34),(93,35),(94,36),(95,37),(96,38),(97,39),(101,40),(102,41),(103,42),(104,43),(105,44),(106,45),(107,46),(108,47),(108,48),(109,49),(109,50),(110,51),(110,52),(111,53),(111,54),(112,55),(112,56),(113,57),(114,58),(115,59),(116,60),(117,61),(118,62),(119,63),(120,64),(121,65),(122,66),(123,67),(124,68),(125,69),(126,70),(127,71),(128,72),(129,73),(130,74),(131,75),(175,139),(176,140),(177,141),(178,142),(178,143),(178,144),(184,145),(185,146),(186,147),(187,148),(188,149),(189,150),(190,151),(190,152),(190,153),(191,154),(191,155),(191,156),(192,157),(192,158),(192,159),(193,160),(193,161),(193,162),(194,163),(194,164),(194,165),(196,166),(196,167),(196,168),(197,169),(198,170),(199,171),(199,172);
/*!40000 ALTER TABLE `playlist_segments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `genres` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
INSERT INTO `program` VALUES (1,'lo signal',NULL,NULL),(2,'Ecolibrium',NULL,NULL);
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_genres`
--

DROP TABLE IF EXISTS `program_genres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program_genres` (
  `id` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  KEY `genre` (`genre`),
  CONSTRAINT `program_genres_ibfk_1` FOREIGN KEY (`genre`) REFERENCES `genre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_genres`
--

LOCK TABLES `program_genres` WRITE;
/*!40000 ALTER TABLE `program_genres` DISABLE KEYS */;
/*!40000 ALTER TABLE `program_genres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programmer`
--

DROP TABLE IF EXISTS `programmer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programmer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programmer`
--

LOCK TABLES `programmer` WRITE;
/*!40000 ALTER TABLE `programmer` DISABLE KEYS */;
INSERT INTO `programmer` VALUES (1,'0','0'),(2,'Dean','Mike'),(3,'Dean','Mike'),(4,'Madden','Meow'),(5,'',''),(6,'diggity','Mikael'),(7,'Dean','Michael'),(8,'Dean','Michael'),(9,'Filyavich','Tamara'),(10,'Wadsworth','Chris'),(11,'Wadsworth','Chris'),(12,'Wadsworth','Chris'),(13,'Wadsworth','Chris'),(14,'Wadsworth','Chris'),(15,'dfgdfgsdg','dsgsdfg'),(16,'dfgdfgsdg','dsgsdfg'),(17,'dfgdfgsdg','dsgsdfg'),(18,'dfgdfgsdg','dsgsdfg'),(19,'dfgdfgsdg','dsgsdfg'),(20,'dfgdfgsdg','dsgsdfg'),(21,'dfgdfg','sdgsdfsd'),(22,'fghnfgj','Mcvn'),(23,'','');
/*!40000 ALTER TABLE `programmer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `segment`
--

DROP TABLE IF EXISTS `segment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `segment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `album` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `length` time DEFAULT NULL,
  `category` int(11) NOT NULL,
  `can_con` char(1) DEFAULT NULL,
  `new_release` char(1) DEFAULT NULL,
  `french_vocal_music` char(1) DEFAULT NULL,
  `request` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  CONSTRAINT `segment_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `segment`
--

LOCK TABLES `segment` WRITE;
/*!40000 ALTER TABLE `segment` DISABLE KEYS */;
INSERT INTO `segment` VALUES (1,'Peripheral Artifacts','Primordia','Deadbeat','00:07:24',2,NULL,NULL,NULL,NULL),(2,'In Between','Les Fruits de la Famille','Zeina','00:06:58',2,NULL,NULL,NULL,NULL),(5,'Stick On The Ice','','',NULL,2,NULL,NULL,NULL,NULL),(10,'Some title',NULL,'Some author',NULL,1,NULL,NULL,NULL,NULL),(11,'What title',NULL,'Another Person',NULL,4,NULL,NULL,NULL,NULL),(12,'Some title',NULL,'Some author',NULL,1,NULL,NULL,NULL,NULL),(13,'What title',NULL,'Another Person',NULL,4,NULL,NULL,NULL,NULL),(14,'My track',NULL,'Mike Dean',NULL,1,NULL,NULL,NULL,NULL),(15,'I\'m a towel',NULL,'Best Artist Ever',NULL,3,NULL,NULL,NULL,NULL),(16,'Here\'s a track',NULL,'Some Artist',NULL,1,NULL,NULL,NULL,NULL),(17,'I\'m a tune',NULL,'Mikey Dean',NULL,4,NULL,NULL,NULL,NULL),(18,'Tun #44',NULL,'ArtistLyfe',NULL,1,NULL,NULL,NULL,NULL),(19,'Yo Tune Man',NULL,'Ariste',NULL,1,NULL,NULL,NULL,NULL),(20,'First Track',NULL,'Mike Dean',NULL,1,NULL,NULL,NULL,NULL),(21,'First Track',NULL,'Mike Dean',NULL,1,NULL,NULL,NULL,NULL),(22,'Meow',NULL,'Mr D',NULL,2,NULL,NULL,NULL,NULL),(23,'Ruff',NULL,'Vice P',NULL,1,NULL,NULL,NULL,NULL),(24,'Don\'t speak to me like that!',NULL,'Dr. Dean',NULL,1,NULL,NULL,NULL,NULL),(25,'Some track',NULL,'Vice P',NULL,1,NULL,NULL,NULL,NULL),(26,'Here\'s another',NULL,'Diggity Dawg',NULL,1,NULL,NULL,NULL,NULL),(27,'NOW','Best Album','Mikal','00:00:06',2,'o',NULL,'o',NULL),(28,'NOW','Best Album','Mikal','00:00:06',4,NULL,'o',NULL,'o'),(29,'My Track','Greatest hits','Dawgy D','00:00:06',2,'o','o',NULL,NULL),(30,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(31,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(32,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(33,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(34,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(35,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(36,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(37,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(38,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(39,'Reggae Track','Goldern','Jah Lion','00:00:06',2,'o','o',NULL,NULL),(40,'seFWQEF',NULL,'Qwfwef',NULL,1,NULL,NULL,NULL,NULL),(41,'seFWQEF',NULL,'Qwfwef',NULL,1,NULL,NULL,NULL,NULL),(42,'seFWQEF',NULL,'Qwfwef',NULL,1,NULL,NULL,NULL,NULL),(43,'seFWQEF',NULL,'Qwfwef',NULL,1,NULL,NULL,NULL,NULL),(44,'dgsdfg',NULL,'sdgsg',NULL,1,NULL,NULL,NULL,NULL),(45,'asfsdfsdf',NULL,'asfafasdfds',NULL,1,NULL,NULL,NULL,NULL),(46,'sdfsdf',NULL,'dsfsdf',NULL,1,NULL,NULL,NULL,NULL),(47,'Some Tune',NULL,'Some Artist',NULL,3,NULL,NULL,NULL,NULL),(48,'Another Tune',NULL,'Someone else Artist',NULL,4,NULL,NULL,NULL,NULL),(49,'Some music',NULL,'To Test',NULL,1,NULL,NULL,NULL,NULL),(50,'Some musicwewe',NULL,'To Testwewe',NULL,1,NULL,NULL,NULL,NULL),(51,'Some music',NULL,'To Test',NULL,1,NULL,NULL,NULL,NULL),(52,'Some musicwewe',NULL,'To Testwewe',NULL,1,NULL,NULL,NULL,NULL),(53,'Some music',NULL,'To Test',NULL,1,NULL,NULL,NULL,NULL),(54,'Some musicwewe',NULL,'To Testwewe',NULL,1,NULL,NULL,NULL,NULL),(55,'Some music',NULL,'To Test',NULL,1,NULL,NULL,NULL,NULL),(56,'Some musicwewe',NULL,'To Testwewe',NULL,1,NULL,NULL,NULL,NULL),(57,'Wewewww',NULL,'Wwweeeeww',NULL,1,NULL,NULL,NULL,NULL),(58,'Wewewww',NULL,'Wwweeeeww',NULL,1,NULL,NULL,NULL,NULL),(59,'Wewewww',NULL,'Wwweeeeww',NULL,1,NULL,NULL,NULL,NULL),(60,'asdfg',NULL,'asdg',NULL,1,NULL,NULL,NULL,NULL),(61,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(62,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(63,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(64,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(65,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(66,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(67,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(68,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(69,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(70,'sdfsdg',NULL,'sdgsdg',NULL,3,NULL,NULL,NULL,NULL),(71,'Mewo',NULL,'SDsds',NULL,1,NULL,NULL,NULL,NULL),(72,'Mewo',NULL,'SDsds',NULL,1,NULL,NULL,NULL,NULL),(73,'sdf',NULL,'sdf',NULL,1,NULL,NULL,NULL,NULL),(74,'Dsdfsdg',NULL,'dsgsdgf',NULL,1,NULL,NULL,NULL,NULL),(75,'',NULL,'',NULL,1,NULL,NULL,NULL,NULL),(76,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(77,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(78,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(79,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(80,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(81,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(82,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(83,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(84,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(85,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(86,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(87,'Track Name',NULL,'Mister Artist',NULL,2,NULL,NULL,NULL,NULL),(88,'Track sqqwe',NULL,'Mister qweqweqe',NULL,2,NULL,NULL,NULL,NULL),(89,'Track sqqwe',NULL,'Mister qweqweqe',NULL,2,NULL,NULL,NULL,NULL),(90,'Montreal',NULL,'K giggity',NULL,2,NULL,NULL,NULL,NULL),(91,'Track 1',NULL,'Md Beat',NULL,3,NULL,NULL,NULL,NULL),(92,'Track 2',NULL,'My Sisteer',NULL,4,NULL,NULL,NULL,NULL),(93,'Track 3',NULL,'My Brother',NULL,2,NULL,NULL,NULL,NULL),(94,'Track 1',NULL,'Mo Bro',NULL,3,NULL,NULL,NULL,NULL),(95,'Track 2',NULL,'sf Yes',NULL,2,NULL,NULL,NULL,NULL),(96,'Track 3',NULL,'Towel',NULL,3,NULL,NULL,NULL,NULL),(97,'Track 1',NULL,'Mo Bro',NULL,3,NULL,NULL,NULL,NULL),(98,'Track 2',NULL,'sf Yes',NULL,2,NULL,NULL,NULL,NULL),(99,'Track 3',NULL,'Towel',NULL,3,NULL,NULL,NULL,NULL),(100,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(101,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(102,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(103,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(104,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(105,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(106,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(107,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(108,'sadfsadf',NULL,'asdfsdf',NULL,1,NULL,NULL,NULL,NULL),(109,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(110,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(111,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(112,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(113,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(114,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(115,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(116,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(117,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(118,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(119,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(120,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(121,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(122,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(123,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(124,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(125,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(126,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(127,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(128,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(129,'sadfsadfsad',NULL,'asdfsadfsda',NULL,1,NULL,NULL,NULL,NULL),(130,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(131,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(132,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(133,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(134,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(135,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(136,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(137,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(138,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(139,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(140,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(141,'dxvdsv',NULL,'dbfdfb',NULL,1,NULL,NULL,NULL,NULL),(142,'sdfsd',NULL,'sdssdf',NULL,1,NULL,NULL,NULL,NULL),(143,'sdfsd',NULL,'sdssdf',NULL,1,NULL,NULL,NULL,NULL),(144,'sdfsd',NULL,'sdssdf',NULL,1,NULL,NULL,NULL,NULL),(145,'dsfdsf',NULL,'sdfsdf',NULL,1,NULL,NULL,NULL,NULL),(146,'Some Track',NULL,'Some Artists',NULL,1,NULL,NULL,NULL,NULL),(147,'Some Track',NULL,'Some Artists',NULL,1,NULL,NULL,NULL,NULL),(148,'Some Track',NULL,'Some Artists',NULL,1,NULL,NULL,NULL,NULL),(149,'Some Track',NULL,'Some Artists',NULL,1,NULL,NULL,NULL,NULL),(150,'Some Track',NULL,'Some Artists',NULL,1,NULL,NULL,NULL,NULL),(151,'Track 1',NULL,'SFnasf',NULL,2,NULL,NULL,NULL,NULL),(152,'sdgsdg',NULL,'sdggdfd',NULL,1,NULL,NULL,NULL,NULL),(153,'sdgsdgsdfdsf',NULL,'sdggdfdffff',NULL,1,NULL,NULL,NULL,NULL),(154,'Track 1',NULL,'SFnasf',NULL,2,NULL,NULL,NULL,NULL),(155,'sdgsdg',NULL,'sdggdfd',NULL,1,NULL,NULL,NULL,NULL),(156,'sdgsdgsdfdsf',NULL,'sdggdfdffff',NULL,1,NULL,NULL,NULL,NULL),(157,'Track 1',NULL,'SFnasf',NULL,2,NULL,NULL,NULL,NULL),(158,'sdgsdg',NULL,'sdggdfd',NULL,1,NULL,NULL,NULL,NULL),(159,'sdgsdgsdfdsf',NULL,'sdggdfdffff',NULL,1,NULL,NULL,NULL,NULL),(160,'Track 1',NULL,'SFnasf',NULL,2,NULL,NULL,NULL,NULL),(161,'sdgsdg',NULL,'sdggdfd',NULL,1,NULL,NULL,NULL,NULL),(162,'sdgsdgsdfdsf',NULL,'sdggdfdffff',NULL,1,NULL,NULL,NULL,NULL),(163,'Track 1',NULL,'SFnasf',NULL,2,NULL,NULL,NULL,NULL),(164,'sdgsdg',NULL,'sdggdfd',NULL,1,NULL,NULL,NULL,NULL),(165,'sdgsdgsdfdsf',NULL,'sdggdfdffff',NULL,1,NULL,NULL,NULL,NULL),(166,'Track 1',NULL,'SFnasf',NULL,2,NULL,NULL,NULL,NULL),(167,'sdgsdg',NULL,'sdggdfd',NULL,1,NULL,NULL,NULL,NULL),(168,'sdgsdgsdfdsf',NULL,'sdggdfdffff',NULL,1,NULL,NULL,NULL,NULL),(169,'sdf',NULL,'sdf',NULL,1,NULL,NULL,NULL,NULL),(170,'fy',NULL,'yr',NULL,1,NULL,NULL,NULL,NULL),(171,'Some track 3242342',NULL,'Some artist 2384234',NULL,3,NULL,NULL,NULL,NULL),(172,'another track 3242342',NULL,'another artist 2384234',NULL,1,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `segment` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-05  8:01:48
