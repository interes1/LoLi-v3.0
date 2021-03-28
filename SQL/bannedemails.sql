CREATE TABLE IF NOT EXISTS `bannedemails` (
  `id` tinyint(1) unsigned NOT NULL,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `addedby` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `comment` varchar(30) NOT NULL DEFAULT '',
  `email` varchar(12) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `bannedemails` (`id`, `added`, `addedby`, `comment`, `email`) VALUES
(1, '2019-07-14 09:36:41', 1, 'Only mail is allowed Gmail.com', '*@gmail.com');

ALTER TABLE `bannedemails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`added`,`email`,`id`,`addedby`,`comment`) USING BTREE;

ALTER TABLE `bannedemails`
  MODIFY `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
