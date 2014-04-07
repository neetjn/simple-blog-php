CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `author_id` bigint(20) DEFAULT '1',
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `post_comments` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;