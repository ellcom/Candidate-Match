-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2013 at 02:15 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `match`
--
CREATE DATABASE IF NOT EXISTS `match` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `match`;

-- --------------------------------------------------------

--
-- Table structure for table `candidateanswers`
--

CREATE TABLE IF NOT EXISTS `candidateanswers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionID` int(11) unsigned NOT NULL,
  `candidateID` int(11) unsigned NOT NULL,
  `answer` int(1) unsigned NOT NULL,
  `justification` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questionID` (`questionID`),
  KEY `candidateID` (`candidateID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `candidateanswers`
--

INSERT INTO `candidateanswers` (`id`, `questionID`, `candidateID`, `answer`, `justification`) VALUES
(21, 1, 1, 1, NULL),
(22, 2, 1, 2, 'moo'),
(23, 3, 1, 2, ''),
(24, 4, 1, 2, ''),
(25, 5, 1, 5, NULL),
(26, 6, 1, 2, ''),
(27, 7, 1, 2, ''),
(28, 8, 1, 2, ''),
(29, 9, 1, 2, ''),
(30, 10, 1, 2, ''),
(31, 1, 2, 1, NULL),
(32, 2, 2, 2, NULL),
(33, 3, 2, 3, NULL),
(34, 4, 2, 4, NULL),
(35, 5, 2, 5, NULL),
(36, 6, 2, 5, NULL),
(37, 7, 2, 4, NULL),
(38, 8, 2, 3, NULL),
(39, 9, 2, 2, NULL),
(40, 10, 2, 1, NULL),
(41, 11, 1, 2, ''),
(42, 12, 1, 2, ''),
(43, 11, 2, 2, NULL),
(44, 12, 2, 5, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
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
  KEY `electionID` (`electionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `userID`, `electionID`, `age`, `gender`, `course`, `picture`, `manifestoLink`, `recomendationCount`) VALUES
(1, 2, 1, 21, 'M', 'Computer Science', 'me.png', 'mymanifesto.html', NULL),
(2, 3, 1, 24, 'M', 'Women''s studies', 'test.png', 'testmanifesto.org', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `electionquestions`
--

CREATE TABLE IF NOT EXISTS `electionquestions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `electionID` int(11) unsigned NOT NULL,
  `questionID` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `electionID` (`electionID`),
  KEY `questionID` (`questionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `electionquestions`
--

INSERT INTO `electionquestions` (`id`, `electionID`, `questionID`) VALUES
(64, 1, 12),
(65, 1, 4),
(66, 1, 6),
(67, 1, 3),
(68, 1, 2),
(69, 1, 7),
(70, 1, 8),
(71, 1, 11),
(72, 1, 10),
(73, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE IF NOT EXISTS `elections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `description` varchar(200) NOT NULL DEFAULT 'No description set.',
  `timestamp` int(11) DEFAULT NULL,
  `end_timestamp` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`id`, `name`, `description`, `timestamp`, `end_timestamp`) VALUES
(1, 'First Election', 'No description set.', 1385911631, 1389279799);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `electionID` int(11) NOT NULL,
  `questionText` varchar(200) NOT NULL DEFAULT '',
  `category` int(11) DEFAULT NULL,
  `divisiveness` float DEFAULT NULL,
  `selected` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `electionID`, `questionText`, `category`, `divisiveness`, `selected`) VALUES
(1, 1, 'Should we kill 3 billion people to save Earth?', NULL, 4, 0),
(2, 1, 'Should Ben cut his hair?', NULL, 0.612372, 0),
(3, 1, 'Is Garlen the coolest guy you know?', NULL, 0.612372, 0),
(4, 1, 'Does Elliot often say the gayest thing of the day?', NULL, 0, 0),
(5, 1, 'Are pears a tasty fruit?', NULL, 4, 0),
(6, 1, 'Stack Overflow is the most useful website', NULL, 0, 0),
(7, 1, 'Bing is a superior search engine to Google', NULL, 0.612372, 0),
(8, 1, 'Elliot is more strawberry blonde than ginger ', NULL, 1.22474, 0),
(9, 1, 'Garlen is too tall for his own good', NULL, 1.83712, 0),
(10, 1, 'Tesco is Garlens favourite shop in the world', NULL, 1.83712, 0),
(11, 1, 'There should be more questions in this DB', NULL, 1.83712, 0),
(12, 1, 'To what extent do you agree with this statement', NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) unsigned NOT NULL,
  `sessionID` varchar(40) NOT NULL DEFAULT '',
  `timestamp` int(11) DEFAULT NULL,
  `lastSeen` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `userID`, `sessionID`, `timestamp`, `lastSeen`) VALUES
(6, 1, 'm166017gtktbcqp6404c2jtot5', 1387285316, '/CM/createelection.php');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `active`, `email`, `name`, `picture`) VALUES
(1, 'admin', '8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b', 'admin', 1, 'admin@localhost', NULL, NULL),
(2, 'BenThurlow', '8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b', 'candidate', 1, 'ben@localhost.co.uk', 'Ben', NULL),
(3, 'JoeBloggs', '8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b', 'candidate', 1, 'joebloggs@localhost.co.uk', 'Joe', NULL),
(4, 'AndrewBenfield', '8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b', 'candidate', 1, 'ab@email.lol', 'Andrew Benfield', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usertypes`
--

CREATE TABLE IF NOT EXISTS `usertypes` (
  `name` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usertypes`
--

INSERT INTO `usertypes` (`name`) VALUES
('admin'),
('candidate');

-- --------------------------------------------------------

--
-- Table structure for table `voteranswers`
--

CREATE TABLE IF NOT EXISTS `voteranswers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questionID` int(11) unsigned NOT NULL,
  `answer` int(1) unsigned NOT NULL,
  `count` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionID` (`questionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `voteranswers`
--

INSERT INTO `voteranswers` (`id`, `questionID`, `answer`, `count`) VALUES
(1, 2, 5, 2),
(2, 3, 3, 2),
(3, 4, 3, 2),
(4, 6, 3, 2),
(5, 7, 5, 1),
(6, 10, 3, 2),
(7, 11, 3, 2),
(8, 12, 3, 2),
(9, 7, 3, 1),
(10, 8, 3, 1),
(11, 9, 3, 1),
(12, 2, 3, 1),
(13, 3, 2, 3),
(14, 4, 2, 3),
(15, 6, 2, 3),
(16, 7, 2, 3),
(17, 8, 2, 3),
(18, 9, 2, 3),
(19, 10, 2, 3),
(20, 11, 2, 3),
(21, 12, 2, 3),
(22, 2, 2, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidateanswers`
--
ALTER TABLE `candidateanswers`
  ADD CONSTRAINT `candidateanswers_ibfk_1` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidateanswers_ibfk_2` FOREIGN KEY (`candidateID`) REFERENCES `candidates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidates_ibfk_2` FOREIGN KEY (`electionID`) REFERENCES `elections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `electionquestions`
--
ALTER TABLE `electionquestions`
  ADD CONSTRAINT `electionquestions_ibfk_1` FOREIGN KEY (`electionID`) REFERENCES `elections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `electionquestions_ibfk_2` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type`) REFERENCES `usertypes` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `voteranswers`
--
ALTER TABLE `voteranswers`
  ADD CONSTRAINT `voteranswers_ibfk_1` FOREIGN KEY (`questionID`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
