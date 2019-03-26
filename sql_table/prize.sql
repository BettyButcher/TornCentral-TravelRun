CREATE TABLE `prize` (
 `prizeid` int(11) NOT NULL AUTO_INCREMENT,
 `pdate` datetime NOT NULL,
 `pcode` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `pnote` varchar(255) DEFAULT NULL,
 `puser` varchar(20) NOT NULL,
 `pcountry` varchar(32) DEFAULT NULL,
 `verified` varchar(2) DEFAULT NULL,
 PRIMARY KEY (`prizeid`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=utf8