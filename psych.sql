-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2016 at 12:05 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `psych`
--

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `race` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `lastname`, `firstname`, `age`, `country`, `race`, `gender`) VALUES
(1, 'Doe', 'John', 21, 'Canada', 'Caucasian', 'Male'),
(2, 'Doe', 'Jane', 25, 'France', 'Asian', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `agenttriggers`
--

CREATE TABLE IF NOT EXISTS `agenttriggers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agentid` int(11) NOT NULL,
  `triggerid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_agentid` (`agentid`),
  KEY `fk_triggerid` (`triggerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `agenttriggers`
--

INSERT INTO `agenttriggers` (`id`, `agentid`, `triggerid`) VALUES
(4, 1, 1),
(5, 1, 2),
(6, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`) VALUES
(1, 'Spider Video'),
(2, 'Height Video');

-- --------------------------------------------------------

--
-- Table structure for table `eventtriggers`
--

CREATE TABLE IF NOT EXISTS `eventtriggers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` int(11) NOT NULL,
  `triggerid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `eventid` (`eventid`),
  KEY `triggerid` (`triggerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `eventtriggers`
--

INSERT INTO `eventtriggers` (`id`, `eventid`, `triggerid`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `trigger`
--

CREATE TABLE IF NOT EXISTS `trigger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `trigger`
--

INSERT INTO `trigger` (`id`, `name`) VALUES
(1, 'Fear of Spiders'),
(2, 'Fear of Heights');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agenttriggers`
--
ALTER TABLE `agenttriggers`
  ADD CONSTRAINT `fk_triggerid` FOREIGN KEY (`triggerid`) REFERENCES `trigger` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_agentid` FOREIGN KEY (`agentid`) REFERENCES `agent` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eventtriggers`
--
ALTER TABLE `eventtriggers`
  ADD CONSTRAINT `fk_triggerid2` FOREIGN KEY (`triggerid`) REFERENCES `trigger` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_eventid` FOREIGN KEY (`eventid`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
