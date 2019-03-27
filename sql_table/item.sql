
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemid` int(11) NOT NULL,
  `itemtype` int(11) NOT NULL,
  `itemname` varchar(100) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `itemtype`, `itemname`) VALUES
(260, 1, 'Dahlia'),
(617, 1, 'Banana Orchid'),
(263, 1, 'Crocus'),
(264, 1, 'Orchid'),
(267, 1, 'Heather'),
(271, 1, 'Ceibo Flower'),
(272, 1, 'Edelweiss'),
(277, 1, 'Cherry Blossom'),
(276, 1, 'Peony'),
(385, 1, 'Tribulus Omanense'),
(282, 1, 'African Violet'),
(17, 5, 'Beretta 92FS'),
(146, 6, 'Yasukuni Sword'),
(251, 6, 'Wushu Double Axes'),
(235, 6, 'Wooden Nunchucks'),
(170, 6, 'Wand of Destruction'),
(250, 6, 'Twin Tiger Hooks'),
(175, 6, 'Taser'),
(224, 6, 'Swiss Army Knife'),
(227, 6, 'Spear'),
(9, 6, 'Scimitar'),
(11, 6, 'Samurai Sword'),
(238, 6, 'Sai'),
(147, 6, 'Rusty Sword'),
(440, 6, 'Pillow'),
(632, 6, 'Petrified Humerus'),
(5, 6, 'Pen Knife'),
(604, 6, 'Pair of Ice Skates'),
(346, 6, 'Pair of High Heels'),
(395, 6, 'Nunchakas'),
(111, 6, 'Ninja Claws'),
(615, 6, 'Naval Cutlass Sword'),
(397, 6, 'Mace'),
(391, 6, 'Macana'),
(110, 6, 'Leather Bull Whip'),
(401, 6, 'Lead Pipe'),
(237, 6, 'Kodachi Swords'),
(4, 6, 'Knuckle Dusters'),
(6, 6, 'Kitchen Knife'),
(247, 6, 'Katana'),
(236, 6, 'Kama'),
(360, 6, 'Ivory Walking Cane'),
(402, 6, 'Ice Pick'),
(387, 6, 'Handbag'),
(1, 6, 'Hammer'),
(400, 6, 'Guandao'),
(599, 6, 'Golden Broomstick'),
(439, 6, 'Frying Pan'),
(560, 6, 'Fruitcake'),
(359, 6, 'Fine Chisel'),
(291, 6, 'Dual Scimitars'),
(292, 6, 'Dual Samurai Swords'),
(290, 6, 'Dual Hammers'),
(289, 6, 'Dual Axes'),
(605, 6, 'Diamond Icicle'),
(614, 6, 'Diamond Bladed Knife'),
(600, 6, 'Devils Pitchfork'),
(7, 6, 'Dagger'),
(3, 6, 'Crow Bar'),
(438, 6, 'Cricket Bat'),
(217, 6, 'Claymore Sword'),
(10, 6, 'Chainsaw'),
(234, 6, 'Chain Whip'),
(173, 6, 'Butterfly Knife'),
(245, 6, 'Bo Staff'),
(539, 6, 'Blood Spattered Sickle'),
(2, 6, 'Baseball Bat'),
(8, 6, 'Axe'),
(184, 1, 'Bunch of Black Roses'),
(97, 1, 'Bunch of Flowers'),
(129, 1, 'Dozen Roses'),
(435, 1, 'Dozen White Roses'),
(183, 1, 'Single Red Rose'),
(244, 5, 'Blowgun'),
(490, 5, 'Blunderbuss'),
(233, 5, 'BT MP9'),
(177, 5, 'Cobra Derringer'),
(218, 5, 'Crossbow'),
(20, 5, 'Desert Eagle'),
(21, 5, 'Dual 96G Berettas'),
(246, 5, 'Fireworks'),
(18, 5, 'Fiveseven'),
(255, 5, 'Flame Thrower'),
(230, 5, 'Flare Gun'),
(12, 5, 'Glock 18'),
(613, 5, 'Harpoon'),
(253, 5, 'Lorcin 380'),
(489, 5, 'Luger'),
(15, 5, 'M-9'),
(19, 5, 'Magnum'),
(248, 5, 'Qsz-92'),
(13, 5, 'Raven MP25'),
(109, 5, 'RPG Launcher'),
(14, 5, 'Ruger 22/45'),
(254, 5, 'S&W M29'),
(189, 5, 'S&W Revolver'),
(393, 5, 'Slingshot'),
(99, 5, 'Springfield 1911-A1'),
(243, 5, 'Taurus'),
(16, 5, 'USP');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemid`),
  ADD KEY `itemtype` (`itemtype`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
