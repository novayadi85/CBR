-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2014 at 12:02 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tanovi_db`
--
CREATE DATABASE IF NOT EXISTS `tanovi_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tanovi_db`;

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE IF NOT EXISTS `criteria` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `criteria` varchar(20) NOT NULL,
  `persentase` varchar(12) NOT NULL,
  `ncf` varchar(12) NOT NULL,
  `nsf` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `criteria`, `persentase`, `ncf`, `nsf`) VALUES
(1, 'Penjualan', '60', '75', '25'),
(2, 'Penanganan', '30', '40', '20');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE IF NOT EXISTS `offices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`id`, `name`, `telp`, `address`) VALUES
(1, 'Kantor Cabang Dalung', '0361-739188', 'Br. Dalung'),
(2, 'Kantor Cabang Nangka', '0361-581445', 'Jl. Nangka utara'),
(3, 'Kantor Cabang Tain siat', '0361-284877', 'Tes'),
(4, 'a', '3', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month` varchar(30) DEFAULT NULL,
  `year` year(4) NOT NULL,
  `office_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `office_id` (`office_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `month`, `year`, `office_id`) VALUES
(5, 'januari', 2014, 1),
(6, 'januari', 2014, 2);

-- --------------------------------------------------------

--
-- Table structure for table `profiles_option`
--

CREATE TABLE IF NOT EXISTS `profiles_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `sub_criteria_id` int(11) NOT NULL,
  `profile_value` int(11) NOT NULL,
  `profile_persentase` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sub_criteria_id` (`sub_criteria_id`),
  KEY `profile_id` (`profile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `profiles_option`
--

INSERT INTO `profiles_option` (`id`, `profile_id`, `sub_criteria_id`, `profile_value`, `profile_persentase`) VALUES
(15, 5, 1, 2, '35'),
(16, 5, 2, 2, '23'),
(17, 5, 3, 2, '40'),
(18, 5, 4, 3, '58'),
(19, 5, 5, 4, '78'),
(20, 5, 6, 1, '20'),
(21, 5, 7, 2, '30'),
(22, 5, 8, 2, '30'),
(23, 5, 9, 3, '52'),
(24, 5, 10, 4, '75'),
(25, 6, 1, 1, '20'),
(26, 6, 2, 3, '50'),
(27, 6, 3, 5, '90'),
(28, 6, 4, 4, '80'),
(29, 6, 5, 1, '20'),
(30, 6, 6, 1, '10'),
(31, 6, 7, 1, '10'),
(32, 6, 8, 5, '88'),
(33, 6, 9, 3, '52'),
(34, 6, 10, 3, '50');

-- --------------------------------------------------------

--
-- Table structure for table `selection`
--

CREATE TABLE IF NOT EXISTS `selection` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `office_id` int(20) NOT NULL,
  `sub_criteria_id` int(20) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_criteria`
--

CREATE TABLE IF NOT EXISTS `sub_criteria` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `parent_id` int(20) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `sub_criteria` text NOT NULL,
  `persentase` varchar(3) NOT NULL,
  `value` varchar(200) NOT NULL,
  `factor` enum('NCF','NSF') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sub_criteria`
--

INSERT INTO `sub_criteria` (`id`, `parent_id`, `kode`, `sub_criteria`, `persentase`, `value`, `factor`) VALUES
(1, 1, 'A1', 'Target Penjualan', '25', '5', 'NCF'),
(2, 1, 'A2', 'Test2', '45', '4', 'NCF'),
(3, 1, 'A3', 'test3', '20', '4', 'NSF'),
(4, 1, 'A4', 'Tes4', '65', '4', 'NCF'),
(5, 1, 'A5', 'tes5', '50', '3', 'NCF'),
(6, 1, 'A6', 'tes6', '50', '3', 'NSF'),
(7, 2, 'B1', 'Test 1', '30', '5', 'NCF'),
(8, 2, 'B2', 'Tes2', '50', '3', 'NCF'),
(9, 2, 'B3', 'test B3', '30', '4', 'NSF'),
(10, 2, 'B4', 'tes b4', '50', '3', 'NSF');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(20) NOT NULL,
  `address` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `address`) VALUES
(1, 'admin', 'admin', 'admin', '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`office_id`) REFERENCES `offices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profiles_option`
--
ALTER TABLE `profiles_option`
  ADD CONSTRAINT `profiles_option_ibfk_2` FOREIGN KEY (`sub_criteria_id`) REFERENCES `sub_criteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profiles_option_ibfk_3` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_criteria`
--
ALTER TABLE `sub_criteria`
  ADD CONSTRAINT `sub_criteria_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `criteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
