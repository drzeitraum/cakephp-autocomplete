CREATE TABLE `countries` (
  `id` int(10) NOT NULL,
  `name` char(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Russia'),
(2, 'Canada'),
(3, 'China'),
(4, 'USA'),
(5, 'Brazil'),
(6, 'Australia'),
(7, 'India'),
(8, 'Argentina'),
(9, 'Kazakhstan'),
(10, 'Algeria');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` char(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country_id` int(5) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `users` (`id`, `login`, `password`, `country_id`) VALUES
(1, 'admin', NULL, NULL);

ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

ALTER TABLE `countries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
