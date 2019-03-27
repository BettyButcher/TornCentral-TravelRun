
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
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

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`countryid`, `countryname`, `letter`, `flower`, `tornid`) VALUES
(1, 'Mexico', 'm', 260, 2),
(2, 'Cayman Islands', 'i', 617, 12),
(3, 'Canada', 'c', 263, 9),
(4, 'Hawaii', 'h', 264, 3),
(5, 'United Kingdom', 'u', 267, 10),
(6, 'Argentina', 'a', 271, 7),
(7, 'Switzerland', 's', 272, 8),
(8, 'Japan', 'j', 277, 5),
(9, 'China', 'x', 276, 6),
(10, 'UAE', 'e', 385, 11),
(11, 'South Africa', 'z', 282, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`countryid`),
  ADD UNIQUE KEY `letter` (`letter`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
