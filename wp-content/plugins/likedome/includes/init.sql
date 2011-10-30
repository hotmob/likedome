CREATE TABLE `wp_likedome_match_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '队伍名字',
  `captain_id` int(11) NOT NULL COMMENT '队长用户id',
  `maxpeople` int(11) NOT NULL DEFAULT '30' COMMENT '队伍最大人数',
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '队伍创建时间戳',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否准许加入队伍, 0, 不准许',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_likedome_match_race` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `stage` int(11) NOT NULL DEFAULT '0' COMMENT '比赛阶段, 0未开始, 1报名中, 2进行中, 3已结束',
  `grouplimit` int(11) NOT NULL DEFAULT '100',
  `groupmemberlimit` int(11) NOT NULL DEFAULT '100',
  `groupnumber` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `select_match` (`name`,`type`,`stage`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_likedome_match_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ngid` int(11) NOT NULL,
  `sgid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `round` int(11) NOT NULL DEFAULT '1',
  `begin` varchar(255) DEFAULT NULL,
  `end` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `wp_likedome_match_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

CREATE TABLE `wp_likedome_match_user` (
  `uid` int(11) NOT NULL,
  `match_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `apply_match` tinyint(4) NOT NULL DEFAULT '0',
  `apply_group` tinyint(4) NOT NULL DEFAULT '0',
  `apply_follow` tinyint(4) NOT NULL DEFAULT '0',
  `pass_apply_match` tinyint(4) NOT NULL DEFAULT '0',
  `pass_apply_group` tinyint(4) NOT NULL DEFAULT '0',
  KEY `wp_likedome_match_user` (`uid`,`match_id`,`apply_match`,`group_id`,`apply_group`),
  KEY `wp_likedome_match_user_select` (`uid`,`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
