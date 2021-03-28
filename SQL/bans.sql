CREATE TABLE IF NOT EXISTS `bans` (
  `id` smallint(5) unsigned NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(40) NOT NULL DEFAULT '',
  `first` varchar(25) DEFAULT NULL,
  `haker` enum('yes','no') DEFAULT 'no'
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `bans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`added`,`addedby`,`id`,`comment`,`first`,`haker`) USING BTREE;

ALTER TABLE `bans`
  MODIFY `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
