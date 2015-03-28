SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `maiv_komen` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `maiv_komen`;

DROP TABLE IF EXISTS `kb_admin`;
CREATE TABLE `kb_admin` (
  `date` date NOT NULL,
  `finished` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `kb_groups`;
CREATE TABLE `kb_groups` (
`id` int(11) NOT NULL,
  `week` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `kb_photos`;
CREATE TABLE `kb_photos` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `photo_url` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `kb_rate`;
CREATE TABLE `kb_rate` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `points_show` tinyint(2) NOT NULL,
  `points_baby` tinyint(2) NOT NULL,
  `points_partner` tinyint(2) NOT NULL,
  `contender_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `kb_users`;
CREATE TABLE `kb_users` (
`id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `partner` varchar(255) NOT NULL,
  `photo_url` text NOT NULL,
  `duedate` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `kb_groups`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `kb_photos`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `kb_rate`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `kb_users`
 ADD PRIMARY KEY (`id`);


ALTER TABLE `kb_groups`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `kb_photos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `kb_rate`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `kb_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
