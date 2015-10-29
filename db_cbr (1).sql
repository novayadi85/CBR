-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2015 at 02:10 AM
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
  `jenis` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `keyword` text NOT NULL,
  `text` text NOT NULL,
  `year` year(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_id` int(12) NOT NULL COMMENT 'User ID',
  `lecturer_ids` varchar(6) NOT NULL,
  `filepath` text NOT NULL,
  `filetext` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='DATA JURNAL' AUTO_INCREMENT=40 ;

--
-- Dumping data for table `jurnals`
--

INSERT INTO `jurnals` (`id_jurnal`, `nim`, `jenis`, `title`, `keyword`, `text`, `year`, `created`, `modified`, `user_id`, `lecturer_ids`, `filepath`, `filetext`) VALUES
(39, 851054, '', 'Magento Adalah e-commerce', '', 'Magento Adalah e-commercetest', 2012, '2015-09-25 00:00:00', '0000-00-00 00:00:00', 1, '1', '9365ae98144317761399217241310273418.docx', '9365ae98144317761399217241310273418.xml');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='DATA DOSEN ';

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id_lecturer`, `nip`, `name`, `address`, `photo`) VALUES
(1, '23235325', 'Komang Novayadi', 'Denpasar', 'Layer 9.png');

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE IF NOT EXISTS `problems` (
`id_problem` int(11) NOT NULL,
  `term` text NOT NULL,
  `tahun` year(4) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `lecturer_ids` int(11) NOT NULL,
  `result` text NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id_problem`, `term`, `tahun`, `jenis`, `lecturer_ids`, `result`, `created`) VALUES
(41, 'magento', 0000, '', 0, 'a:1:{i:851054;a:12:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-09-25 00:00:00'),
(43, 'aplikasi', 0000, '', 0, 'a:1:{i:851054;a:12:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-09-25 00:00:00'),
(44, 'magento dan aplikasi', 0000, '', 0, 'a:1:{i:851054;a:12:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-09-25 00:00:00'),
(51, 'magento aplikasi', 0000, '', 0, 'a:1:{i:851054;a:13:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"jenis";s:0:"";s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-10-28 00:00:00'),
(52, 'magento aplikasi', 0000, '', 0, 'a:1:{i:851054;a:13:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"jenis";s:0:"";s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-10-28 00:00:00'),
(53, 'magento aplikasi', 2012, '1', 0, 'a:1:{i:851054;a:13:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"jenis";s:0:"";s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-10-28 00:00:00'),
(54, 'magento', 2012, '0', 1, 'a:1:{i:851054;a:13:{s:9:"id_jurnal";i:39;s:3:"nim";i:851054;s:5:"jenis";s:0:"";s:5:"title";s:25:"Magento Adalah e-commerce";s:7:"keyword";s:0:"";s:4:"text";s:29:"Magento Adalah e-commercetest";s:4:"year";i:2012;s:7:"created";s:19:"2015-09-25 00:00:00";s:8:"modified";s:19:"0000-00-00 00:00:00";s:7:"user_id";i:1;s:12:"lecturer_ids";s:1:"1";s:8:"filepath";s:40:"9365ae98144317761399217241310273418.docx";s:8:"filetext";s:39:"9365ae98144317761399217241310273418.xml";}}', '2015-10-28 00:00:00');

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
(851054, 'Komang Novayadi', '1901-01-17', 'Denpasar', 2, 2, '2d3d9d53143748140690084185310718869.jpg'),
(851055, 'Percussion Bargains', '1999-05-12', 'Denpasar', 2, 1, 'fd9dcf1d143748139424378892811085655.jpg');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`, `address`) VALUES
(1, 'admin', 'admin', 'admin', '');

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
MODIFY `id_jurnal` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
MODIFY `id_problem` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
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
