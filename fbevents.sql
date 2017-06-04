-- Table for raw database, namely fbevents
CREATE TABLE fbevents (
`id` int,
`DTSTAMP` TEXT,
`LAST-MODIFIED` TEXT,
`CREATED` TEXT,
`SEQUENCE` TEXT,
`ORGANIZER` TEXT,
`MAILTO` TEXT,
`DTSTART` TEXT,
`DTEND` TEXT,
`UID` TEXT,
`SUMMARY` TEXT,
`LOCATION` TEXT,
`URL` TEXT,
`DESCRIPTION` TEXT
);

-- Table for pins, initialy for KSART.nl
CREATE TABLE IF NOT EXISTS `pins` (
  `id` int(10) unsigned NOT NULL,
  `allow` tinyint(1) DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bright` tinyint(1) NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `town` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;