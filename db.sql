CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) NOT NULL,
  `name` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'China'),
(2, 'India'),
(3, 'USA'),
(4, 'Indonesia'),
(5, 'Pakistan'),
(6, 'Brazil'),
(7, 'Nigeria'),
(8, 'Bangladesh'),
(9, 'Russia'),
(10, 'Mexico'),
(11, 'Japan'),
(12, 'Ethiopia'),
(13, 'Philippines'),
(14, 'Egypt'),
(15, 'Vietnam'),
(16, 'DRC'),
(17, 'Iran'),
(18, 'Turkey'),
(19, 'Germany'),
(20, 'France'),
(21, 'Great Britain'),
(22, 'Thailand'),
(23, 'Italy'),
(24, 'Tanzania'),
(25, 'SA'),
(26, 'Myanmar'),
(27, 'Republic of Korea'),
(28, 'Colombia'),
(29, 'Kenya'),
(30, 'Spain');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `login` char(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country_id` int(5) unsigned DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `users` (`id`, `login`, `password`, `country_id`) VALUES
(1, 'admin', NULL, NULL);

ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

ALTER TABLE `countries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
