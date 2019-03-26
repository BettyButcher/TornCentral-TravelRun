CREATE TABLE `stock` (
 `stockid` int(11) NOT NULL AUTO_INCREMENT,
 `utctime` datetime NOT NULL,
 `country` int(11) NOT NULL,
 `item` int(11) NOT NULL,
 `price` bigint(11) NOT NULL,
 `quantity` int(11) NOT NULL,
 `manual` tinyint(4) NOT NULL,
 `sender` varchar(78) COLLATE latin1_general_ci NOT NULL,
 PRIMARY KEY (`stockid`),
 KEY `country` (`country`),
 KEY `item` (`item`)
) ENGINE=MyISAM AUTO_INCREMENT=4033055 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
