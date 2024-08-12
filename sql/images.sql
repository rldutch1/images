
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) DEFAULT NULL,
  `image` varchar(80) NOT NULL,
  `extension` varchar(10) NOT NULL,
  `tstamp` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `active_ind` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB;

