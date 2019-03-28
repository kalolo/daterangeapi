CREATE TABLE `price_ranges` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `price` float DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;