-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2013 at 05:24 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `match`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `type` varchar(11) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `type`, `active`) VALUES
(1, 'admin', '8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b', 'admin', 0),
(3, 'admin2', '8eedf5e5ff3df74b923c545df2e0af1472d8245bc46ff24298774b72cd0a043b', 'admin', 0),
(7, 'elliot', 'hello', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userTypes`
--

CREATE TABLE `userTypes` (
  `name` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userTypes`
--

INSERT INTO `userTypes` (`name`) VALUES
('admin'),
('candidate');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`type`) REFERENCES `userTypes` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
