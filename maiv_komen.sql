-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Machine: localhost:8889
-- Gegenereerd op: 26 mrt 2015 om 00:49
-- Serverversie: 5.5.38
-- PHP-versie: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `maiv_komen`
--
CREATE DATABASE IF NOT EXISTS `maiv_komen` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `maiv_komen`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kb_admin`
--

DROP TABLE IF EXISTS `kb_admin`;
CREATE TABLE `kb_admin` (
  `date` date NOT NULL,
  `finished` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `kb_users`
--

DROP TABLE IF EXISTS `kb_users`;
CREATE TABLE `kb_users` (
`id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `mother` varchar(255) NOT NULL,
  `partner` varchar(255) NOT NULL,
  `duedate` date NOT NULL,
  `street` varchar(255) NOT NULL,
  `streetnr` varchar(9) NOT NULL,
  `city` varchar(255) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `kb_users`
--
ALTER TABLE `kb_users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `kb_users`
--
ALTER TABLE `kb_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
