CREATE TABLE IF NOT EXISTS `sessions` (
  `id` smallint(5) unsigned NOT NULL,
  `sid` varchar(32) NOT NULL DEFAULT '',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL DEFAULT '',
  `class` tinyint(2) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `url` varchar(150) NOT NULL DEFAULT '',
  `useragent` varchar(60) DEFAULT NULL,
  `avatar` varchar(30) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `index1` (`time`,`username`,`class`,`uid`,`avatar`) USING BTREE,
  ADD KEY `index2` (`sid`,`uid`,`username`,`class`,`ip`,`time`,`url`,`avatar`) USING BTREE;

ALTER TABLE `sessions`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
