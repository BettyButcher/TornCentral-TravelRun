CREATE TABLE `itemtype` (
 `itemtypeid` int(11) NOT NULL AUTO_INCREMENT,
 `itemtypename` varchar(100) COLLATE latin1_general_ci NOT NULL,
 `cssclass` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
 PRIMARY KEY (`itemtypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
