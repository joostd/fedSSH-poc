CREATE TABLE IF NOT EXISTS `pubkey` (
  `username` varchar(100) NOT NULL,
  `pubkey` varchar(1024) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enabled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
