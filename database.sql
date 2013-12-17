-- MySQL dump 10.13  Distrib 5.5.33, for osx10.6 (i386)
--
-- Host: localhost    Database: match
-- ------------------------------------------------------
-- Server version	5.5.33

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
-- Table structure for table `candidateanswers`
--

DROP TABLE IF EXISTS `candidateanswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `candidateanswers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionID` int(11) unsigned NOT NULL,
  `candidateID` int(11) unsigned NOT NULL,
  `answer` int(1) unsigned NOT NULL,
  `justification` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionID` (`questionID`),
  KEY `candidateID` (`candidateID`),
  CONSTRAINT `candidateanswers_ibfk_1` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `candidateanswers_ibfk_2` FOREIGN KEY (`candidateID`) REFERENCES `candidates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidateanswers`
--

LOCK TABLES `candidateanswers` WRITE;
/*!40000 ALTER TABLE `candidateanswers` DISABLE KEYS */;
INSERT INTO `candidateanswers` VALUES (21,1,1,1,NULL),(22,2,1,2,'moo'),(23,3,1,2,''),(24,4,1,2,''),(25,5,1,5,NULL),(26,6,1,2,''),(27,7,1,2,''),(28,8,1,2,''),(29,9,1,2,''),(30,10,1,2,''),(31,1,2,1,NULL),(32,2,2,2,NULL),(33,3,2,3,NULL),(34,4,2,4,NULL),(35,5,2,5,NULL),(36,6,2,5,NULL),(37,7,2,4,NULL),(38,8,2,3,NULL),(39,9,2,2,NULL),(40,10,2,1,NULL),(41,11,1,2,''),(42,12,1,2,''),(43,11,2,2,NULL),(44,12,2,5,NULL);
/*!40000 ALTER TABLE `candidateanswers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `candidates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) unsigned DEFAULT NULL,
  `electionID` int(11) unsigned DEFAULT NULL,
  `age` int(3) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `course` varchar(50) NOT NULL,
  `picture` varchar(200) DEFAULT NULL,
  `manifestoLink` varchar(200) DEFAULT NULL,
  `recomendationCount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  KEY `electionID` (`electionID`),
  CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`electionID`) REFERENCES `elections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidates`
--

LOCK TABLES `candidates` WRITE;
/*!40000 ALTER TABLE `candidates` DISABLE KEYS */;
INSERT INTO `candidates` VALUES (1,2,1,21,'M','Computer Science','me.png','mymanifesto.html',NULL),(2,3,1,24,'M','Women\'s studies','test.png','testmanifesto.org',NULL);
/*!40000 ALTER TABLE `candidates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `electionquestions`
--

DROP TABLE IF EXISTS `electionquestions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `electionquestions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `electionID` int(11) unsigned NOT NULL,
  `questionID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `electionID` (`electionID`),
  KEY `questionID` (`questionID`),
  CONSTRAINT `electionquestions_ibfk_1` FOREIGN KEY (`electionID`) REFERENCES `elections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `electionquestions_ibfk_2` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `electionquestions`
--

LOCK TABLES `electionquestions` WRITE;
/*!40000 ALTER TABLE `electionquestions` DISABLE KEYS */;
INSERT INTO `electionquestions` VALUES (64,1,12),(65,1,4),(66,1,6),(67,1,3),(68,1,2),(69,1,7),(70,1,8),(71,1,11),(72,1,10),(73,1,9);
/*!40000 ALTER TABLE `electionquestions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elections`
--

DROP TABLE IF EXISTS `elections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(200) NOT NULL DEFAULT 'No description set.',
  `timestamp` int(11) DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  `end_timestamp` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elections`
--

LOCK TABLES `elections` WRITE;
/*!40000 ALTER TABLE `elections` DISABLE KEYS */;
INSERT INTO `elections` VALUES (1,'First Election','No description set.',1385911631,0,1389279799),(2,'LOL','No description set.',1387288800,0,1387288800),(3,'LOLA','No description set.',1387288800,0,1387288800),(4,'pop','No description set.',1387288800,0,1387288800),(5,'sa','No description set.',1387288800,0,1387288800);
/*!40000 ALTER TABLE `elections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `electionID` int(11) NOT NULL,
  `questionText` varchar(200) NOT NULL DEFAULT '',
  `category` varchar(200) DEFAULT NULL,
  `divisiveness` float DEFAULT NULL,
  `selected` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,'Should we kill 3 billion people to save Earth?',NULL,4,0),(2,1,'Should Ben cut his hair?',NULL,0.612372,0),(3,1,'Is Garlen the coolest guy you know?',NULL,0.612372,0),(4,1,'Does Elliot often say the gayest thing of the day?',NULL,0,0),(5,1,'Are pears a tasty fruit?',NULL,4,0),(6,1,'Stack Overflow is the most useful website',NULL,0,0),(7,1,'Bing is a superior search engine to Google',NULL,0.612372,0),(8,1,'Elliot is more strawberry blonde than ginger ',NULL,1.22474,0),(9,1,'Garlen is too tall for his own good',NULL,1.83712,0),(10,1,'Tesco is Garlens favourite shop in the world',NULL,1.83712,0),(11,1,'There should be more questions in this DB',NULL,1.83712,0),(12,1,'To what extent do you agree with this statement',NULL,0,0),(13,1,'A \"Lol\" is a good?','0',NULL,0);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) unsigned NOT NULL,
  `sessionID` varchar(40) NOT NULL DEFAULT '',
  `timestamp` int(11) DEFAULT NULL,
  `lastSeen` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`),
  CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (7,1,'4556ccf9f990309899b00d00eaa82d0b',1387298225,'/electionprofiler.php?id=1');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `type` varchar(11) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `type` (`type`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type`) REFERENCES `usertypes` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b','admin',1,'admin@localhost',NULL,NULL),(2,'BenThurlow','8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b','candidate',1,'ben@localhost.co.uk','Ben',NULL),(3,'JoeBloggs','8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b','candidate',1,'joebloggs@localhost.co.uk','Joe',NULL),(4,'AndrewBenfield','8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b','candidate',1,'ab@email.lol','Andrew Benfield',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertypes`
--

DROP TABLE IF EXISTS `usertypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usertypes` (
  `name` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertypes`
--

LOCK TABLES `usertypes` WRITE;
/*!40000 ALTER TABLE `usertypes` DISABLE KEYS */;
INSERT INTO `usertypes` VALUES ('admin'),('candidate');
/*!40000 ALTER TABLE `usertypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voteranswers`
--

DROP TABLE IF EXISTS `voteranswers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `voteranswers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionID` int(11) unsigned NOT NULL,
  `answer` int(1) unsigned NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionID` (`questionID`),
  CONSTRAINT `voteranswers_ibfk_1` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voteranswers`
--

LOCK TABLES `voteranswers` WRITE;
/*!40000 ALTER TABLE `voteranswers` DISABLE KEYS */;
INSERT INTO `voteranswers` VALUES (1,2,5,2),(2,3,3,2),(3,4,3,3),(4,6,3,2),(5,7,5,1),(6,10,3,2),(7,11,3,3),(8,12,3,3),(9,7,3,2),(10,8,3,1),(11,9,3,2),(12,2,3,1),(13,3,2,3),(14,4,2,3),(15,6,2,4),(16,7,2,3),(17,8,2,4),(18,9,2,3),(19,10,2,4),(20,11,2,3),(21,12,2,3),(22,2,2,2),(23,2,1,1),(24,3,1,1);
/*!40000 ALTER TABLE `voteranswers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-17 16:39:55
