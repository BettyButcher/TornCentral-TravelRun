
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
-- Table structure for table `itemtype`
--

CREATE TABLE `itemtype` (
  `itemtypeid` int(11) NOT NULL,
  `itemtypename` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `cssclass` varchar(50) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `itemtype`
--

INSERT INTO `itemtype` (`itemtypeid`, `itemtypename`, `cssclass`) VALUES
(1, 'Flowers', 'flower'),
(2, 'Plushies', 'plushie'),
(3, 'Drugs', 'drug'),
(4, 'Primary Weapons', 'default'),
(5, 'Secondary Weapons', 'default'),
(6, 'Melee Weapons', 'default'),
(7, 'Temporary Items', 'default'),
(8, 'Armour', 'default'),
(9, 'Candy', 'default'),
(10, 'Clothes', 'default'),
(11, 'Other boosters', 'default'),
(12, 'Alcohol', 'alcohol'),
(13, 'Jewelry', 'default'),
(14, 'Medical Items', 'default'),
(15, 'Electronic Items', 'default'),
(16, 'Enhancers', 'default'),
(17, 'Special Items', 'default'),
(-1, '(unknown)', 'default'),
(18, 'Energy Drinks', 'default'),
(19, 'Cars', 'default'),
(20, 'Viruses', 'default'),
(21, 'Artifacts', 'default'),
(22, 'Supply Packs', 'default'),
(23, 'Collectibles', 'default'),
(24, 'Miscellaneous', 'misc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `itemtype`
--
ALTER TABLE `itemtype`
  ADD PRIMARY KEY (`itemtypeid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `itemtype`
--
ALTER TABLE `itemtype`
  MODIFY `itemtypeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
