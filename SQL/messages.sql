DROP TABLE IF EXISTS `messages`;

CREATE TABLE IF NOT EXISTS `messages` (
  `id` mediumint(7) unsigned NOT NULL,
  `sender` mediumint(7) unsigned NOT NULL,
  `sender_class` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `sender_username` varchar(20) NOT NULL DEFAULT '',
  `sender_avatar` varchar(30) NOT NULL DEFAULT '',
  `receiver` mediumint(7) unsigned NOT NULL,
  `receiver_class` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `receiver_username` varchar(20) NOT NULL DEFAULT '',
  `receiver_avatar` varchar(30) NOT NULL DEFAULT '',
  `added` datetime DEFAULT NULL,
  `subject` varchar(65) NOT NULL DEFAULT '',
  `msg` text,
  `unread` enum('yes','no') NOT NULL DEFAULT 'yes',
  `location` tinyint(1) NOT NULL DEFAULT '1',
  `saved` enum('no','yes') NOT NULL DEFAULT 'no'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receiver_unread_id` (`receiver`,`unread`,`id`) USING BTREE,
  ADD KEY `receiver` (`receiver`) USING BTREE,
  ADD KEY `sender` (`sender`) USING BTREE,
  ADD KEY `unread` (`unread`) USING BTREE,
  ADD KEY `added` (`added`) USING BTREE,
  ADD KEY `saved` (`saved`) USING BTREE,
  ADD KEY `sender_saved_unread_added` (`sender`,`saved`,`unread`,`added`) USING BTREE,
  ADD KEY `sender_saved_added` (`sender`,`saved`,`added`) USING BTREE,
  ADD KEY `unread_saved_added` (`unread`,`saved`,`added`) USING BTREE,
  ADD KEY `saved_added` (`saved`,`added`) USING BTREE,
  ADD KEY `receiver_2` (`receiver`,`location`);

ALTER TABLE `messages`
  MODIFY `id` mediumint(7) unsigned NOT NULL AUTO_INCREMENT;
