CREATE TABLE `item` (
 `itemid` int(11) NOT NULL,
 `itemtype` int(11) NOT NULL,
 `itemname` varchar(100) COLLATE latin1_general_ci NOT NULL,
 PRIMARY KEY (`itemid`),
 KEY `itemtype` (`itemtype`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
