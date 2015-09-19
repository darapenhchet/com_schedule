DROP TABLE IF EXISTS `dbsc_schedule_ci`;
CREATE TABLE `dbsc_schedule_ci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `description` text,
  `place` text,
  `datecreate` datetime DEFAULT CURRENT_TIMESTAMP,
  `eventstart` datetime DEFAULT NULL,
  `eventend` datetime DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `imageurl` text,
  `url` text,
  `type` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;