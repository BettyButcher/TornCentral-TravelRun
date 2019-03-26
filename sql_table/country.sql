CREATE TABLE `country` (
 `countryid` int(11) NOT NULL,
 `countryname` varchar(100) COLLATE latin1_general_ci NOT NULL,
 `letter` char(1) COLLATE latin1_general_ci NOT NULL,
 `flower` int(11) NOT NULL,
 `tornid` int(2) NOT NULL,
 PRIMARY KEY (`countryid`),
 UNIQUE KEY `letter` (`letter`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
