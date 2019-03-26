CREATE TABLE `post` (
 `postid` int(11) NOT NULL AUTO_INCREMENT,
 `postUTC` datetime NOT NULL,
 `postdata` varchar(60000) COLLATE latin1_general_ci NOT NULL,
 `user_agent` varchar(255) COLLATE latin1_general_ci NOT NULL,
 `referer` varchar(255) COLLATE latin1_general_ci NOT NULL,
 `sender` varchar(78) COLLATE latin1_general_ci NOT NULL DEFAULT ' ',
 PRIMARY KEY (`postid`)
) ENGINE=MyISAM AUTO_INCREMENT=341849 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
