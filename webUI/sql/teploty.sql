CREATE TABLE IF NOT EXISTS `Hodnoty` (
  `teplota` char(6) COLLATE utf8_czech_ci NOT NULL,
  `vlhkost` char(6) COLLATE utf8_czech_ci NOT NULL,
  `casMereni` datetime NOT NULL,
  `id_hodnoty` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_hodnoty`),
  KEY `index_teplota` (`teplota`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=8 ;
