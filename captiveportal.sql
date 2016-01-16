CREATE DATABASE IF NOT EXISTS `captiveportal` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `captiveportal`;

CREATE TABLE `disallow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `time` datetime NOT NULL,
  `type` enum('temporary','always') NOT NULL,
  `reason` varchar(250) NOT NULL,
  `admin` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `action` varchar(50) NOT NULL,
  `sys` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;