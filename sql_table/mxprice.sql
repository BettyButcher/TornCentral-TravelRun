CREATE TABLE `mxprice` (
 `countryname` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `itemname` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
 `max_price` bigint(11) DEFAULT NULL,
 `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8