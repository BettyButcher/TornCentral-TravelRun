-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2019 at 05:10 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `torn`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `countryid` int(11) NOT NULL,
  `countryname` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `letter` char(1) COLLATE latin1_general_ci NOT NULL,
  `flower` int(11) NOT NULL,
  `tornid` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counts`
--

CREATE TABLE `counts` (
  `vkey` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemid` int(11) NOT NULL,
  `itemtype` int(11) NOT NULL,
  `itemname` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemtype`
--

CREATE TABLE `itemtype` (
  `itemtypeid` int(11) NOT NULL,
  `itemtypename` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cssclass` varchar(50) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mxprice`
--

CREATE TABLE `mxprice` (
  `countryname` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `itemname` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `max_price` bigint(11) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `postid` int(11) NOT NULL,
  `postUTC` datetime NOT NULL,
  `postdata` varchar(60000) COLLATE latin1_general_ci NOT NULL,
  `user_agent` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `referer` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `sender` varchar(78) COLLATE latin1_general_ci NOT NULL DEFAULT ' '
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prize`
--

CREATE TABLE `prize` (
  `prizeid` int(11) NOT NULL,
  `pdate` datetime NOT NULL,
  `pcode` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `pnote` varchar(255) DEFAULT NULL,
  `puser` varchar(20) NOT NULL,
  `pcountry` varchar(32) DEFAULT NULL,
  `verified` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stockid` int(11) NOT NULL,
  `utctime` datetime NOT NULL,
  `country` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `price` bigint(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `manual` tinyint(4) NOT NULL,
  `sender` varchar(78) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`countryid`),
  ADD UNIQUE KEY `letter` (`letter`);

--
-- Indexes for table `counts`
--
ALTER TABLE `counts`
  ADD PRIMARY KEY (`vkey`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `itemtype` (`itemtype`);

--
-- Indexes for table `itemtype`
--
ALTER TABLE `itemtype`
  ADD PRIMARY KEY (`itemtypeid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postid`);

--
-- Indexes for table `prize`
--
ALTER TABLE `prize`
  ADD PRIMARY KEY (`prizeid`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stockid`),
  ADD KEY `country` (`country`),
  ADD KEY `item` (`item`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `itemtype`
--
ALTER TABLE `itemtype`
  MODIFY `itemtypeid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prize`
--
ALTER TABLE `prize`
  MODIFY `prizeid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stockid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
