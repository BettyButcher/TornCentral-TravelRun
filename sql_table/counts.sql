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
-- Table structure for table `counts`
--

CREATE TABLE `counts` (
  `vkey` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `counts`
--

INSERT INTO `counts` (`vkey`, `value`) VALUES
('m', 2298166),
('update2', 331956),
('i', 1052223),
('c', 1091812),
('h', 1095509),
('u', 1339638),
('s', 990105),
('a', 1299833),
('j', 1131377),
('x', 1184059),
('e', 1135094),
('z', 1179496);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counts`
--
ALTER TABLE `counts`
  ADD PRIMARY KEY (`vkey`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
