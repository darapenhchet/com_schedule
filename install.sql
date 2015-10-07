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
  `shift` text,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dbsc_schedule_ci_type`;
CREATE TABLE `dbsc_schedule_ci_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `dbsc_schedule_ci_type` VALUES ('1', 'ព្រឹទ្ធសភា', 'ព្រឹទ្ធសភា');
INSERT INTO `dbsc_schedule_ci_type` VALUES ('2', 'អគ្គលេខាធិការដ្ឋាន', 'អគ្គលេខាធិការដ្ឋាន');