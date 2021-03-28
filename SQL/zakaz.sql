CREATE TABLE IF NOT EXISTS `zakaz` (
  `id` mediumint(7) unsigned NOT NULL,
  `name` varchar(175) NOT NULL,
  `image1` varchar(9) DEFAULT NULL,
  `text` mediumtext NOT NULL,
  `cat_id` tinyint(2) unsigned NOT NULL,
  `incat_id` tinyint(2) unsigned NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(20) NOT NULL,
  `user_id` mediumint(7) unsigned NOT NULL,
  `class` tinyint(2) unsigned NOT NULL,
  `bonus` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cl_user` varchar(20) NOT NULL,
  `cl_user_id` mediumint(7) NOT NULL,
  `cl_user_class` tinyint(2) unsigned NOT NULL,
  `url` tinytext
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

ALTER TABLE `zakaz`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index1` (`data`,`status`,`user_id`,`id`,`name`,`cat_id`,`bonus`) USING BTREE,
  ADD UNIQUE KEY `index2` (`cat_id`,`data`) USING BTREE,
  ADD UNIQUE KEY `index3` (`user_id`,`data`) USING BTREE,
  ADD UNIQUE KEY `index4` (`status`,`data`) USING BTREE;

ALTER TABLE `zakaz`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
