-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2015 at 08:41 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_cbr`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_xml`
--

CREATE TABLE IF NOT EXISTS `data_xml` (
`id_xml` int(15) NOT NULL,
  `id_jurnal` int(11) NOT NULL,
  `xml_path` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jurnals`
--

CREATE TABLE IF NOT EXISTS `jurnals` (
`id_jurnal` int(12) NOT NULL,
  `nim` int(11) NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `year` year(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(12) NOT NULL COMMENT 'User ID',
  `lecturer_ids` varchar(6) NOT NULL,
  `filepath` text NOT NULL,
  `filetext` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='DATA JURNAL' AUTO_INCREMENT=38 ;

--
-- Dumping data for table `jurnals`
--

INSERT INTO `jurnals` (`id_jurnal`, `nim`, `title`, `text`, `year`, `created`, `modified`, `user_id`, `lecturer_ids`, `filepath`, `filetext`) VALUES
(37, 851054, 'Porto - Custom Block for Footer Bottom Area', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 2012, '2015-07-21 00:00:00', '0000-00-00 00:00:00', 1, '1,2', '9fa04f87143746744126958060111096141.docx', '9fa04f87143746744126958060111096141.xml');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE IF NOT EXISTS `lecturers` (
`id_lecturer` int(15) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='DATA DOSEN ' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id_lecturer`, `nip`, `name`, `address`, `photo`) VALUES
(1, '23235325', 'Komang Novayadi', 'Denpasar', '7ea4e7fc143746245128692212410569284.jpg'),
(2, '56756767', 'Ibu dayu', 'Gianyar', '0172d289143745814557572198010903077.png'),
(3, '56756767', 'Komang novayadi', 'Gianyar 3', 'd43ab110143746046120619043110416590.png');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE IF NOT EXISTS `problems` (
`id_problem` int(11) NOT NULL,
  `term` text NOT NULL,
  `result` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id_problem`, `term`, `result`, `created`) VALUES
(3, 'ilmu pengetahuan', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(5, 'logistik managemen', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(7, 'pengetahuan', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(8, 'pengetahuan', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(9, 'ilmu pengetahuan', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(10, 'pengetahuan tanpa uang', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(11, 'manajemen transaksi logistik', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(12, 'manajemen transaksi managemen', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:10:"2015-07-18";s:8:"modified";s:10:"0000-00-00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(13, 'Management transaksi logistik', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(14, 'Managemen  logistik transaksi', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(15, 'Managemen logistik transaksi', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(16, 'logistik', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(17, 'ilmu', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(19, 'ilmu tentang pengetahuan alam', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(20, 'tentang alam semesta ilmu', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(21, 'logistik individu', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(22, 'logistik individu pengetahuan', 'a:2:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(23, 'transfer pengetahuan', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(24, 'transfer pengetahuan logistik', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(25, 'transfer logistik', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(26, 'dokter wanita', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(27, 'dokter', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(28, 'dokter wanita pengetahuan', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(29, 'dokter wanita logistik', 'a:1:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}}', '2015-07-20 00:00:00'),
(30, 'wanita logistik', 'a:3:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(31, 'pengetahuan wanita logistik', 'a:3:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(32, 'ilmu pengetahuan wanita logistik', 'a:3:{i:31;a:11:{s:9:"id_jurnal";i:31;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 1";s:4:"text";s:29:"Management transaksi logistik";s:4:"year";i:2000;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"aab3238922bcc25a6f606eb525ffdc56.docx";s:8:"filetext";s:36:"aab3238922bcc25a6f606eb525ffdc56.xml";}i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-20 00:00:00'),
(33, 'ilmu tentang pengetahuan', 'a:2:{i:32;a:11:{s:9:"id_jurnal";i:32;s:3:"nim";i:851054;s:5:"title";s:9:"Abstrak 2";s:4:"text";s:20:"Pengetahuan individu";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c20ad4d76fe97759aa27a0c99bff6710.docx";s:8:"filetext";s:36:"c20ad4d76fe97759aa27a0c99bff6710.xml";}i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:51:"Managemen pengetahuan transfer pengetahuan logistik";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-18 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:0:"";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-21 00:00:00'),
(34, 'ilmu tentang pengetahuan alam', 'a:1:{i:33;a:11:{s:9:"id_jurnal";i:33;s:3:"nim";i:851054;s:5:"title";s:8:"Jurnal 3";s:4:"text";s:0:"";s:4:"year";i:2012;s:7:"created";s:19:"2015-07-21 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:37:"c51ce410c124a10e0db5e4b97fc2af39.docx";s:8:"filetext";s:36:"c51ce410c124a10e0db5e4b97fc2af39.xml";}}', '2015-07-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `nim` int(16) NOT NULL,
  `name` varchar(250) NOT NULL,
  `bod` date NOT NULL,
  `address` text NOT NULL,
  `jurusan` int(11) NOT NULL,
  `jenjang` int(11) NOT NULL,
  `photo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='MAHASISWA';

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`nim`, `name`, `bod`, `address`, `jurusan`, `jenjang`, `photo`) VALUES
(851054, 'Komang Novayadi', '0000-00-00', 'Denpasar', 0, 0, '75ebb02f143746269563635522110909994.png'),
(851055, 'Import Product Magento', '0000-00-00', 'Surabaya', 0, 0, 'a00e5eb0143746284542651980910994003.jpg'),
(851057, 'Import All Products', '0000-00-00', 'Gianyar', 0, 0, '889fbd1a143746281261875248710167284.png'),
(851058, 'Komang novayadi', '0000-00-00', 'Gianyar', 0, 0, '182e6c2d14374629063498985491074234.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(20) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `address`) VALUES
(1, 'admin', 'admin', 'admin', ''),
(2, 'novayadi', 'komang novayadi', 'e10adc3949ba59abbe56', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_xml`
--
ALTER TABLE `data_xml`
 ADD PRIMARY KEY (`id_xml`), ADD KEY `id_jurnal` (`id_jurnal`);

--
-- Indexes for table `jurnals`
--
ALTER TABLE `jurnals`
 ADD PRIMARY KEY (`id_jurnal`), ADD KEY `user_id` (`user_id`), ADD KEY `nim` (`nim`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
 ADD PRIMARY KEY (`id_lecturer`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
 ADD PRIMARY KEY (`id_problem`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
 ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_xml`
--
ALTER TABLE `data_xml`
MODIFY `id_xml` int(15) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jurnals`
--
ALTER TABLE `jurnals`
MODIFY `id_jurnal` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
MODIFY `id_lecturer` int(15) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
MODIFY `id_problem` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_xml`
--
ALTER TABLE `data_xml`
ADD CONSTRAINT `data_xml_ibfk_1` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnals` (`id_jurnal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jurnals`
--
ALTER TABLE `jurnals`
ADD CONSTRAINT `jurnals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
ADD CONSTRAINT `jurnals_ibfk_2` FOREIGN KEY (`nim`) REFERENCES `students` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
