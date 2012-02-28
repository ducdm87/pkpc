
CREATE TABLE IF NOT EXISTS `#__spa_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `link` text NOT NULL,
  `module` int(11) NOT NULL COMMENT 'module id',
  `secid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `thumb` text NOT NULL,
  `thumb_width` int(11) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `introtext` mediumtext NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `premium` tinyint(3) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `target` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;