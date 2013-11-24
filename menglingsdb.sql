-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2013 at 07:51 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `menglingsdb`
--
CREATE DATABASE IF NOT EXISTS `menglingsdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `menglingsdb`;

-- --------------------------------------------------------

--
-- Table structure for table `candidateanswers`
--

CREATE TABLE IF NOT EXISTS `candidateanswers` (
  `CandidateAnswerID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionID` int(11) NOT NULL,
  `CandidateID` int(11) NOT NULL,
  `Answer` int(11) NOT NULL,
  `Justification` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`CandidateAnswerID`),
  KEY `QUESTION` (`QuestionID`),
  KEY `CANDIDATE` (`CandidateID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `candidateanswers`
--

INSERT INTO `candidateanswers` (`CandidateAnswerID`, `QuestionID`, `CandidateID`, `Answer`, `Justification`) VALUES
(1, 1, 1, 5, NULL),
(2, 1, 2, 4, NULL),
(3, 1, 3, 4, NULL),
(4, 1, 4, 3, NULL),
(5, 1, 5, 5, NULL),
(6, 2, 1, 5, NULL),
(7, 2, 2, 2, NULL),
(8, 2, 3, 4, NULL),
(9, 2, 4, 3, NULL),
(10, 2, 5, 2, NULL),
(11, 3, 1, 5, NULL),
(12, 3, 2, 5, NULL),
(13, 3, 3, 3, NULL),
(14, 3, 4, 1, NULL),
(15, 3, 5, 1, NULL),
(16, 4, 1, 2, NULL),
(17, 4, 2, 2, NULL),
(18, 4, 3, 2, NULL),
(19, 4, 4, 2, NULL),
(20, 4, 5, 2, NULL),
(21, 5, 1, 3, NULL),
(22, 5, 2, 4, NULL),
(23, 5, 3, 2, NULL),
(24, 5, 4, 3, NULL),
(25, 5, 5, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `CandidateID` int(11) NOT NULL AUTO_INCREMENT,
  `ElectionID` int(11) NOT NULL,
  `FirstName` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Picture` varchar(150) DEFAULT NULL,
  `ManifestoLink` varchar(150) DEFAULT NULL,
  `RecommendationCount` int(11) NOT NULL,
  PRIMARY KEY (`CandidateID`),
  KEY `ELECTION` (`ElectionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`CandidateID`, `ElectionID`, `FirstName`, `Surname`, `Picture`, `ManifestoLink`, `RecommendationCount`) VALUES
(1, 1, 'Ben', 'Thurlow', NULL, NULL, 0),
(2, 1, 'Garlen', 'Saldanha', NULL, NULL, 0),
(3, 1, 'Elliot', 'Adderton', NULL, NULL, 0),
(4, 1, 'Andrew', 'Benfield', NULL, NULL, 0),
(5, 1, 'David', 'Hamilton', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE IF NOT EXISTS `elections` (
  `ElectionID` int(11) NOT NULL AUTO_INCREMENT,
  `ElectionName` varchar(150) NOT NULL,
  `ElectionYear` int(11) NOT NULL,
  PRIMARY KEY (`ElectionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `elections`
--

INSERT INTO `elections` (`ElectionID`, `ElectionName`, `ElectionYear`) VALUES
(1, 'First LGoS student president election', 2013);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `QuestionID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionText` varchar(150) NOT NULL,
  `Category` varchar(30) DEFAULT NULL,
  `Divisiveness` int(11) DEFAULT NULL,
  `Selected` tinyint(4) NOT NULL,
  PRIMARY KEY (`QuestionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`QuestionID`, `QuestionText`, `Category`, `Divisiveness`, `Selected`) VALUES
(1, 'Do you agree with £9,000 tuition fees?', NULL, NULL, 0),
(2, 'How much do you agree with the following: Ben is great', NULL, NULL, 0),
(3, 'Is metal music good?', NULL, NULL, 0),
(4, 'Do you think David Cameron is a good prime minister?', NULL, NULL, 0),
(5, 'Should Comp Sci labs be open 24/7?', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tempinputtest`
--

CREATE TABLE IF NOT EXISTS `tempinputtest` (
  `inputID` int(11) NOT NULL AUTO_INCREMENT,
  `answer` int(11) NOT NULL,
  PRIMARY KEY (`inputID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `tempinputtest`
--

INSERT INTO `tempinputtest` (`inputID`, `answer`) VALUES
(1, 3),
(2, 5),
(3, 2),
(4, 4),
(5, 1),
(6, 3),
(7, 5),
(8, 1),
(9, 3),
(10, 5),
(11, 1),
(12, 1),
(13, 1),
(14, 5),
(15, 5),
(16, 1),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 1),
(24, 3),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1);

-- --------------------------------------------------------

--
-- Table structure for table `voteranswers`
--

CREATE TABLE IF NOT EXISTS `voteranswers` (
  `VoterAnswerID` int(11) NOT NULL AUTO_INCREMENT,
  `QuestionID` int(11) NOT NULL,
  `Answer` int(11) NOT NULL,
  `AnswerCount` int(11) NOT NULL,
  PRIMARY KEY (`VoterAnswerID`),
  UNIQUE KEY `QUESTION` (`QuestionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidateanswers`
--
ALTER TABLE `candidateanswers`
  ADD CONSTRAINT `candidateanswers_ibfk_1` FOREIGN KEY (`CandidateID`) REFERENCES `candidates` (`CandidateID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `candidateanswers_ibfk_2` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`ElectionID`) REFERENCES `elections` (`ElectionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `voteranswers`
--
ALTER TABLE `voteranswers`
  ADD CONSTRAINT `voteranswers_ibfk_1` FOREIGN KEY (`QuestionID`) REFERENCES `questions` (`QuestionID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
