-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2016 at 07:35 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teknack`
--

-- --------------------------------------------------------

--
-- Table structure for table `cty`
--

CREATE TABLE IF NOT EXISTS `cty` (
  `tek_username` varchar(50) NOT NULL,
  `battery` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dtb`
--

CREATE TABLE IF NOT EXISTS `dtb` (
  `tek_userid` varchar(40) NOT NULL,
  `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `diff` int(40) NOT NULL,
  `level_start` int(2) NOT NULL,
  `level` int(2) NOT NULL,
  `score` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dtb`
--

INSERT INTO `dtb` (`tek_userid`, `start`, `end`, `diff`, `level_start`, `level`, `score`) VALUES
('10001', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
`id` int(50) NOT NULL,
  `tek_username` varchar(50) NOT NULL,
  `battery` int(11) NOT NULL,
  `land` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `resource`
--

INSERT INTO `resource` (`id`, `tek_username`, `battery`, `land`) VALUES
(1, 'queeny', 20, 'snow'),
(2, 'queeny', 100, 'city'),
(4, 'queeny', 100, 'desert'),
(5, 'car', 100, 'nature');

-- --------------------------------------------------------

--
-- Table structure for table `snow`
--

CREATE TABLE IF NOT EXISTS `snow` (
  `tek_username` varchar(50) NOT NULL,
  `battery` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `snow`
--

INSERT INTO `snow` (`tek_username`, `battery`) VALUES
('21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tek_student`
--

CREATE TABLE IF NOT EXISTS `tek_student` (
  `tek_userid` varchar(40) NOT NULL,
  `tek_name` varchar(10) NOT NULL,
  `password` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tek_student`
--

INSERT INTO `tek_student` (`tek_userid`, `tek_name`, `password`) VALUES
('10001', 'teknack', 'teknack');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cty`
--
ALTER TABLE `cty`
 ADD PRIMARY KEY (`tek_username`);

--
-- Indexes for table `dtb`
--
ALTER TABLE `dtb`
 ADD PRIMARY KEY (`tek_userid`);

--
-- Indexes for table `resource`
--
ALTER TABLE `resource`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `snow`
--
ALTER TABLE `snow`
 ADD PRIMARY KEY (`tek_username`);

--
-- Indexes for table `tek_student`
--
ALTER TABLE `tek_student`
 ADD PRIMARY KEY (`tek_userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `resource`
--
ALTER TABLE `resource`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
