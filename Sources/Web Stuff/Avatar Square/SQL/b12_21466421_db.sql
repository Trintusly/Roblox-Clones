-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql304.byethost12.com
-- Generation Time: Feb 11, 2018 at 04:01 PM
-- Server version: 5.6.35-81.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b12_21466421_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alphakeys`
--

CREATE TABLE IF NOT EXISTS `alphakeys` (
  `email` longtext NOT NULL,
  `code` longtext NOT NULL,
  `ip` longtext NOT NULL,
  `redeemed` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `text` longtext NOT NULL,
  `link` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`) VALUES
(1, 'Welcome to SimpleBuild', 'Normal operations will begin shortly. We are currently working on setting up a business hotline.');

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `SiteName` text COLLATE utf8_unicode_ci NOT NULL,
  `GameURL` text COLLATE utf8_unicode_ci NOT NULL,
  `Image` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `owner` text COLLATE utf8_unicode_ci NOT NULL,
  `visits` int(11) NOT NULL,
  `favorites` int(11) NOT NULL,
  `Created` text COLLATE utf8_unicode_ci NOT NULL,
  `playing` int(11) NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `play` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `title`, `description`, `owner`, `visits`, `favorites`, `Created`, `playing`, `image`, `play`) VALUES
(1, 'Crates', 'just a baseplate with a simple crate\r\n', 'BrickCreate', 312, 7, 'Jan 23rd 2017\r\n', 3, 'https://i.imgur.com/Kq7AKvX.png', '1/'),
(2, 'Particle Testing', 'Testing a bit of particles', 'BrickCreate', 129, 7, 'Feb 2nd, 2018', 2, 'https://i.imgur.com/mjAAb5T.png', '2/');

-- --------------------------------------------------------

--
-- Table structure for table `groupmembers`
--

CREATE TABLE IF NOT EXISTS `groupmembers` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `groupid` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groupmembers`
--

INSERT INTO `groupmembers` (`id`, `userid`, `groupid`, `status`) VALUES
(0, 1, 1, 1),
(0, 302, 1, 1),
(0, 305, 1, 1),
(0, 288, 1, 1),
(0, 313, 1, 1),
(0, 325, 1, 1),
(0, 326, 1, 1),
(0, 322, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `vault` text COLLATE utf8_unicode_ci NOT NULL,
  `members` int(11) NOT NULL,
  `owner` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `private` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'false'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `title`, `vault`, `members`, `owner`, `description`, `image`, `private`) VALUES
(1, 'AvatarSquare', '21418', 5, 'AvatarSquare', 'Open to all members, not just admins!', 'https://i.imgur.com/UBiGSWl.png', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `item` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`item`, `user`) VALUES
(1, 336),
(1, 1),
(1, 275),
(2, 336),
(1, 278),
(1, 278),
(1, 281),
(1, 282),
(1, 283),
(2, 1),
(1, 285),
(1, 287),
(1, 286),
(1, 287),
(2, 286),
(2, 288),
(1, 288),
(2, 289),
(1, 291),
(1, 296),
(3, 1),
(1, 300),
(3, 302),
(2, 302),
(1, 302),
(1, 305),
(2, 308),
(1, 308),
(1, 307),
(2, 308),
(3, 106),
(1, 313),
(2, 313),
(4, 1),
(1, 323),
(2, 326),
(4, 327),
(7, 1),
(6, 1),
(5, 1),
(4, 330),
(1, 332),
(1, 335),
(2, 322),
(4, 322),
(22, 326),
(22, 326),
(1, 326),
(6, 326),
(5, 326),
(2, 326),
(22, 326),
(22, 326),
(8, 1),
(4, 336),
(9, 1),
(9, 326),
(8, 326);

-- --------------------------------------------------------

--
-- Table structure for table `ipbans`
--

CREATE TABLE IF NOT EXISTS `ipbans` (
  `ip` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `iplogs`
--

CREATE TABLE IF NOT EXISTS `iplogs` (
  `ip` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iplogs`
--

INSERT INTO `iplogs` (`ip`) VALUES
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('70.42.131.170'),
('70.42.131.170'),
('52.55.124.222'),
('66.249.64.17'),
('66.249.64.16'),
('66.249.64.17'),
('66.249.64.17'),
('66.249.64.17'),
('66.249.64.18'),
('66.249.64.17'),
('165.161.3.53'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('66.249.93.18'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('185.79.93.76'),
('185.79.93.76'),
('185.79.93.76'),
('185.79.93.76'),
('185.79.93.76'),
('185.79.93.76'),
('185.79.93.76'),
('49.191.33.215'),
('49.191.33.215'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('73.136.88.144'),
('104.218.62.3'),
('104.218.62.3'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('75.132.19.99'),
('66.249.64.16'),
('66.249.64.18'),
('66.249.64.16'),
('66.249.64.17'),
('66.249.64.16'),
('66.249.64.17'),
('66.249.64.17'),
('66.249.64.18'),
('66.249.64.16'),
('66.249.64.18'),
('66.249.64.18'),
('66.249.64.18'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('83.249.230.211'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('66.249.64.18'),
('66.249.64.19'),
('66.249.93.19'),
('66.249.93.19'),
('66.249.64.18'),
('66.249.64.19'),
('62.112.9.166'),
('62.112.9.166'),
('62.112.9.166'),
('62.112.9.166'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('66.249.93.18'),
('66.249.93.17'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('66.249.64.18'),
('66.249.64.17'),
('66.249.64.17'),
('66.249.64.16'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('23.127.208.78'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('86.168.139.31'),
('66.249.93.17'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('73.1.145.75'),
('66.249.64.16'),
('66.249.64.17'),
('86.165.93.173'),
('86.165.93.173'),
('86.165.93.173'),
('174.206.3.252'),
('174.206.3.252'),
('174.206.3.252'),
('174.206.3.252'),
('174.206.3.252'),
('174.206.3.252'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128'),
('109.90.223.128');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `image` text NOT NULL,
  `creator` text NOT NULL,
  `created` text NOT NULL,
  `wearable` text NOT NULL,
  `price` int(11) NOT NULL,
  `onsale` int(11) NOT NULL DEFAULT '1',
  `collectable` varchar(32) NOT NULL DEFAULT 'false',
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `type`, `image`, `creator`, `created`, `wearable`, `price`, `onsale`, `collectable`, `amount`) VALUES
(1, 'Top Hat', 'Simple hat for a Brick Creator', 'accessory', 'https://i.imgur.com/cVeUhjk.png', 'AvatarSquare', 'Jan 23rd 2018', 'top.png', 5, 1, 'false', -1),
(2, 'Recycling Bin', 'Reduce reuse and recycle', 'accessory', 'https://i.imgur.com/Y2n9hRv.png', 'AvatarSquare\r\n', 'Jan 25th, 2002', 'recycle.png', 10, 1, 'false', -1),
(3, 'Ice Cream', 'Perhaps its most unique characteristic is its ability to inspire viewers with awe while at the same time making the wearer look goofy.', 'accessory', 'https://i.imgur.com/ZCpOrIL.png', 'AvatarSquare', 'Jan 25th, 2002', 'Icecream.png', 35, 1, 'true', 2),
(4, 'Man Hair', 'Gorgeous hair for gorgeous people!', 'accessory', 'https://i.imgur.com/NXX7De4.png', 'AvatarSquare\r\n', 'Jan 28th, 2018', 'hairr.png', 5, 1, 'false', -1),
(5, 'Bucket Hat', 'It''s stylish and provides you with 360 degrees of UV Sun ray protection!', 'accessory', 'https://i.imgur.com/dYRtldi.png', 'AvatarSquare', 'Feb 3rd, 2018', 'bucket.png', 65, 1, 'false', -1),
(6, 'Hammer', 'The Hammer will only listen to those whom are worthy', 'body', 'https://i.imgur.com/kzSgHPJ.png', 'AvatarSquare', 'Feb 3rd, 2018', 'hammer.png', 185, 1, 'false', -1),
(7, 'Blonde Man', 'Who says you can''t play the part? With this hair no one will be able to tell that you stuck that whoopee cushion under your coworker''s chair.', 'accessory', 'https://i.imgur.com/hKjT5j0.png', 'AvatarSquare', 'Feb 3rd, 2018', 'jbhair.png', 15, 1, 'false', -1),
(9, 'Diver', 'Who lives in a pineapple under the sea?', 'accessory', 'https://i.imgur.com/tL8nENT.png', 'AvatarSquare', 'Feb 11th, 2018', 'diverwear.png', 30, 1, 'false', -1),
(8, 'Steel King', 'The classic shape in classic material. Classic!', 'accessory', 'https://i.imgur.com/mjMbrJ4.png', 'AvatarSquare', 'Feb 10th, 2018', 'darksteel.png', 75, 1, 'false', -1);

-- --------------------------------------------------------

--
-- Table structure for table `lottery`
--

CREATE TABLE IF NOT EXISTS `lottery` (
  `username` text NOT NULL,
  `userid` int(11) NOT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`sender`, `receiver`, `title`, `message`) VALUES
(21, 1, 'hi', 'yo bro i got banned from the discord for no reason ;(( i asked a simple question'),
(97, 1, 'lol', 'lol'),
(107, 105, '12', '20'),
(283, 283, 'f', 'f'),
(0, 283, 'test', 'test'),
(287, 287, 'hi me', 'how are you doing'),
(307, 308, '<a href="https://www.youtube.com/SkateAlert">THE BEST YOUTUBER EVER</a>', '<a href="https://www.youtube.com/SkateAlert">THE BEST YOUTUBER EVER</a>'),
(307, 308, '<img src="http://i1.ytimg.com/vi/IA5yUXVIcHA/hqdefault.jpg" alt="hi"> ', '<img src="http://i1.ytimg.com/vi/IA5yUXVIcHA/hqdefault.jpg" alt="hi"> '),
(307, 326, '<script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script>', '<script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script> <script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script> <script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script> <script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script> <script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script> <script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script>'),
(307, 308, '<script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script>', '<script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script><script>alert("#Hacked by Team Nice. YouTube - https://www.youtube.com/SkateAlert Website: https://skatealert.xyz")</script>'),
(286, 106, 'hi', 'ugly'),
(315, 315, '<script>alert("hey fix this xss")</script>', '<script>alert("hey fix this xss")</script>'),
(329, 1, 'I would love to be an administrator', 'My discord is iVarialChase#2564 add me please!'),
(326, 1, 'Testing', 'Testing'),
(326, 1, 'Hi send me back something', 'Reply'),
(326, 326, 'Hi', 'papapapaa'),
(0, 326, 'saaaaaaaaaaaaaaaaaa', 'asssssssssssssssss'),
(0, 326, 'sadsadsa', 'sadsadsa'),
(326, 326, 'aaaa', 'aaaaaaaaaa'),
(326, 326, '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `refurbishment`
--

CREATE TABLE IF NOT EXISTS `refurbishment` (
  `status` text COLLATE utf8_unicode_ci NOT NULL,
  `end` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `refurbishment`
--

INSERT INTO `refurbishment` (`status`, `end`) VALUES
('true', '7/29/2017');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `threadId` int(11) NOT NULL,
  `postBy` text NOT NULL,
  `postText` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`threadId`, `postBy`, `postText`) VALUES
(39, 'test', 'Me pls'),
(36, 'Wow', 'This is a clear copy..'),
(54, 'MegaDrive', 'brick planet remake thingy'),
(54, 'Wow', 'This isnt even needed and is pretty much clearly copied'),
(54, 'Warlord', 'i think this is the start of blox city, we went back in time bois'),
(56, 'Wow', 'me too'),
(56, 'Wow', 'me too'),
(56, 'Warlord', ''),
(74, 'niceguy1000', 'yessssss'),
(2, 'drifttwo', '<script>alert("subscribe to SkateAlert on YouTube")</script>'),
(2, 'drifttwo', 'I used his same xss and it still works...'),
(3, 'drifttwo', '<script>alert("Please fix this xss.")</script>'),
(2, 'ihascancer', 'Yesh, Im mlg'),
(6, 'niceguy1000', 'lol'),
(13, 'Babyhamsta', 'testr');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE IF NOT EXISTS `threads` (
  `topicId` int(11) NOT NULL DEFAULT '1',
  `threadId` int(11) NOT NULL AUTO_INCREMENT,
  `threadAdmin` text NOT NULL,
  `threadTitle` varchar(128) NOT NULL,
  `threadBody` varchar(1024) NOT NULL,
  `views` int(11) NOT NULL,
  `replies` int(11) NOT NULL,
  `pinned` varchar(32) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`threadId`),
  UNIQUE KEY `threadId` (`threadId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`topicId`, `threadId`, `threadAdmin`, `threadTitle`, `threadBody`, `views`, `replies`, `pinned`) VALUES
(1, 13, 'Babyhamsta', 'Hamsta -w- Here', 'Suh my HamstaGang Fam! I was here at one point in time.', 0, 0, 'false'),
(1, 11, 'brickcreate', 'Forums have been cleared!', '^Due to spam.', 0, 0, 'false'),
(1, 12, 'Northernlion', 'Hello world!', 'Hello world!', 0, 0, 'false');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL,
  `threads` int(11) NOT NULL,
  `replies` int(11) NOT NULL,
  `name` varchar(512) NOT NULL,
  `description` varchar(512) NOT NULL,
  `lastPostTitle` varchar(512) NOT NULL,
  `lastPostBy` varchar(512) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `threads`, `replies`, `name`, `description`, `lastPostTitle`, `lastPostBy`) VALUES
(1, 0, 0, 'General Discussion', 'General information regarding anything throughout the website should be posted here!', 'Thread', 'Username');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userips`
--

CREATE TABLE IF NOT EXISTS `userips` (
  `id` int(11) NOT NULL,
  `ip` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userips`
--

INSERT INTO `userips` (`id`, `ip`) VALUES
(1, '73.1.145.75'),
(0, '73.1.145.75'),
(1, '172.58.169.15'),
(275, '81.141.179.195'),
(277, '205.215.175.102'),
(278, '205.215.175.102'),
(281, '73.141.196.47'),
(1, '165.161.15.54'),
(282, '129.161.80.16'),
(106, '82.4.137.136'),
(283, '12.91.232.66'),
(284, '82.4.137.136'),
(286, '68.34.80.253'),
(285, '158.248.233.54'),
(287, '5.142.128.202'),
(288, '186.212.234.143'),
(289, '73.1.145.75'),
(291, '80.234.181.130'),
(292, '68.51.176.172'),
(288, '177.205.151.138'),
(296, '24.146.166.122'),
(293, '68.37.53.93'),
(299, '79.160.18.14'),
(300, '68.116.192.161'),
(301, '98.161.55.211'),
(302, '76.189.147.102'),
(304, '68.144.198.156'),
(275, '86.160.130.29'),
(285, '185.59.105.251'),
(305, '141.237.182.30'),
(307, '62.231.136.5'),
(308, '62.231.136.5'),
(309, '12.91.232.66'),
(288, '179.186.30.149'),
(288, '187.59.166.67'),
(310, '71.17.169.156'),
(311, '92.25.189.122'),
(288, '179.177.162.252'),
(312, '24.146.166.122'),
(313, '98.121.115.91'),
(314, '109.152.91.109'),
(315, '142.59.152.131'),
(318, '62.231.136.5'),
(320, '62.231.136.5'),
(321, '91.10.39.165'),
(322, '62.231.136.5'),
(323, '79.116.206.224'),
(325, '68.149.244.125'),
(326, 'Nahfam -Bham cleared'),
(327, '70.166.212.162'),
(329, '70.190.177.60'),
(309, '75.132.19.99'),
(330, '5.68.0.70'),
(331, '109.150.131.119'),
(332, '86.183.180.50'),
(335, '62.231.136.5'),
(1, '165.161.15.38'),
(336, '73.1.145.75');

-- --------------------------------------------------------

--
-- Table structure for table `userposts`
--

CREATE TABLE IF NOT EXISTS `userposts` (
  `id` int(11) NOT NULL,
  `poster` text COLLATE utf8_unicode_ci NOT NULL,
  `posted` int(11) NOT NULL,
  `img` text COLLATE utf8_unicode_ci NOT NULL,
  `status` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` longtext NOT NULL,
  `password` longtext NOT NULL,
  `email` longtext NOT NULL,
  `ip` longtext NOT NULL,
  `datecreated` longtext NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '0',
  `banned` int(11) NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  `emeralds` varchar(2048) NOT NULL DEFAULT '50',
  `getemeralds` int(11) NOT NULL,
  `trades` int(11) NOT NULL,
  `requests` int(11) NOT NULL,
  `messages` int(11) NOT NULL DEFAULT '1',
  `elite` int(11) NOT NULL DEFAULT '0',
  `eliteexpire` longtext NOT NULL,
  `admin` varchar(32) NOT NULL DEFAULT 'false',
  `bouncer` varchar(32) NOT NULL DEFAULT 'false',
  `designer` varchar(32) NOT NULL DEFAULT 'false',
  `visittick` longtext NOT NULL,
  `expiretime` longtext NOT NULL,
  `description` text NOT NULL,
  `package` varchar(32) NOT NULL DEFAULT 'Avatar.png',
  `accessory` text NOT NULL,
  `badge` text NOT NULL,
  `outfit` text NOT NULL,
  `face` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=337 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `ip`, `datecreated`, `verified`, `banned`, `reason`, `emeralds`, `getemeralds`, `trades`, `requests`, `messages`, `elite`, `eliteexpire`, `admin`, `bouncer`, `designer`, `visittick`, `expiretime`, `description`, `package`, `accessory`, `badge`, `outfit`, `face`) VALUES
(1, 'AvatarSquare', '7280horse', 'raeognawr@aol.com', '73.1.145.75', '1500997813', 0, 0, '', '783', 1518379598, 0, 0, 1, 0, '', 'true', 'false', 'false', '1518362542', '1518362842', '', 'hammer.png', 'diverwear.png', '', '', ''),
(2, 'Nicholas', 'corona', 'geawgnawe@aol.com', '73.46.200.163', '1500998034', 0, 0, '', '0', 1501296661, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501210686', '0', '', 'Avatar.png', 'pirate.png', '', 'Logan.png', ''),
(4, 'something', 'nick5501', 'geaiugna@aol.com', '73.46.200.163', '1500998522', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(3, 'Astral', 'Hasbro911', '''', '99.44.106.158', '1500998509', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(5, 'BunnyCoder', 'Hasbro911', 'charcoaldevelopment@gmail.com', '99.44.106.158', '1500998773', 0, 0, '', '25', 1501085181, 0, 0, 1, 0, '', 'false', 'false', 'false', '1500998935', '1500999235', '', 'Avatar.png', '', '', '', ''),
(6, 'ROBLOX', 'nick5501', 'fewainfa@aol.com', '73.46.200.163', '1500999482', 0, 1, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(7, 'Google', 'nick5501', 'cewaiongwa@aol.com', '73.46.200.163', '1500999492', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(8, 'Luke', 'devildoggamer', 'redxx@outlook.com', '162.217.31.137', '1501004464', 0, 0, '', '20', 1501208564, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501122258', '0', '', 'Avatar.png', 'cap.png', '', '', ''),
(9, 'steve', 'noobie12', 'dylanhefner123@gmail.com', '173.90.158.195', '1501004562', 0, 0, '', '25', 1501090976, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501005343', '1501005643', '', 'Avatar.png', '', '', '', ''),
(10, 'Inspired', 'hunter12', 'tecumshe1337@gmail.com', '208.104.232.251', '1501004579', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(11, 'jeff', 'poopoo25', 'John@gmail.com', '82.5.197.226', '1501004611', 0, 0, '', '10', 1501091019, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501005996', '1501006296', '', 'Avatar.png', 'Hardhat.png', '', '', ''),
(12, 'Hat', 'nopassword123', 'NotForYOu@gmail.com', '67.80.153.78', '1501004614', 0, 0, '', '5', 1501091023, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501006072', '1501006372', '', 'Avatar.png', 'Hardhat.png', '', '', ''),
(34, 'Builder', 'ByJkI132x', 'iresetagain21@gmail.com', '81.100.184.151', '1501084379', 0, 0, '', '19', 1501876770, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501790387', '0', '', 'Avatar.png', 'cone.png', '', '', 'sad.png'),
(13, 'Byte', 'fryear0425', 'noahfogarty@live.com', '24.180.130.51', '1501004647', 0, 0, '', '0', 1501091055, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501004760', '1501005060', '', 'Avatar.png', 'Hardhat.png', '', 'outfit.png', ''),
(14, 'idkwhoisthis', 'hahaxdxd', 'dumbasssmh@lol.com', '189.13.171.107', '1501004670', 0, 0, '', '15', 1501276147, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501191340', '1501191640', '', 'Avatar.png', 'natus.png', '', '', ''),
(15, 'nigger', 'nigger', 'dawda@meme.fucku', '174.100.141.204', '1501004715', 0, 0, '', '25', 1501091128, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501004841', '1501005141', '', 'Avatar.png', '', '', '', ''),
(16, 'EddyMe', 'Eddy12ZX', 'vlodymyrbak@gmail.com', '76.113.130.26', '1501004736', 0, 0, '', '25', 1501091157, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501004798', '0', '', 'Avatar.png', '', '', '', ''),
(17, 'kkangaro', 'keziah123', 'Davidxslayer@gmail.com', '68.108.175.100', '1501004983', 0, 0, '', '73', 1503183434, 0, 0, 1, 0, '', 'false', 'false', 'false', '1503169341', '1503169641', '', 'Avatar.png', 'brick.png', '', 'newsuit.png', ''),
(18, 'redzz', 'crushredz99', 'crushpixel4@gmail.com', '69.165.224.233', '1501005286', 0, 0, '', '55', 1501897813, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501815283', '1501815583', '', 'Avatar.png', '', '', '', ''),
(19, 'KillMe', '0favorite0', 'vadici@mystvpn.com', '32.209.83.53', '1501005349', 0, 0, '', '25', 1501091766, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501005470', '0', '', 'Avatar.png', '', '', '', ''),
(20, 'FriedRice', 'loploplop9087', 'paviliongod@gmail.com', '108.95.127.151', '1501005382', 0, 0, '', '25', 1501091799, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501005514', '1501005814', '', 'Avatar.png', '', '', '', ''),
(21, 'DriedChicken', 'ByJkI132x', 'iresetagain21@gmail.com', '81.100.184.151', '1501005577', 0, 1, '', '60', 1502629383, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502542990', '1502543290', '', 'Avatar.png', 'Hardhat.png', '', 'outfit.png', ''),
(31, 'Dox', 'Hacks21', 'robloxfilmcam@gmail.com', '109.90.169.147', '1501020772', 0, 0, '', '0', 1501107180, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501020855', '1501021155', '', 'Avatar.png', 'Hardhat.png', '', 'Logan.png', ''),
(22, 'Logan', '228606', 'datwebguy101@gmail.com', '172.85.1.42', '1501006333', 0, 0, '', '489', 1501437158, 0, 0, 1, 0, '', 'true', 'false', 'false', '1501350810', '1501351110', '', 'Avatar.png', 'natus.png', '', 'newsuit.png', 'sad.png'),
(23, 'Gay', 'lenovo02', 'highimjoxa@gmail.com', '178.149.66.99', '1501006445', 0, 0, '', '25', 1501092858, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501006550', '1501006850', '', 'Avatar.png', '', '', '', ''),
(24, 'Mohammedtam333', 'qwertyuiop', 'mohammedtam444@gmail.com', '86.97.51.141', '1501006756', 0, 0, '', '25', 1501093171, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501006773', '1501007073', '', 'Avatar.png', '', '', '', ''),
(25, 'F3NC1NG', 'Jacob1103', 'f3nc1ngrblx@gmail.com', '109.159.14.246', '1501006761', 0, 0, '', '15', 1502319674, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502234406', '1502234706', '', 'Avatar.png', 'natus.png', '', 'Logan.png', 'sad.png'),
(26, 'Pizza', 'ByJkI132x', 'iresetagain21@gmail.com', '81.100.184.151', '1501007135', 0, 0, '', '15', 1501876792, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501790398', '0', '', 'Avatar.png', 'Hardhat.png', '', 'outfit.png', ''),
(27, '1984hd', 'qwerty123', 'DAdaf.ga@gmail.com', '94.15.207.61', '1501007262', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(28, 'kysnoob', 'qwerty123', 'adfg.ga@gmail.com', '94.15.207.61', '1501007405', 0, 0, '', '10', 1501093814, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501007595', '1501007895', '', 'Avatar.png', 'Hardhat.png', '', '', ''),
(29, 'vorelover6996', 'fag32ab', 'niggerfaggot@grr.la', '82.17.116.125', '1501018640', 0, 0, '', '40', 1503056662, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502970273', '1502970573', '', 'Avatar.png', '', '', '', ''),
(30, 'Player', 'rainbow11', 'kingbluboy@gmail.com', '99.32.148.179', '1501019686', 0, 0, '', '0', 1501106096, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501019743', '1501020043', '', 'Avatar.png', 'pirate.png', '', '', ''),
(32, 'Fluxx', 'mokong123123123', 'rainbowgamingdanilo@gmail.com', '49.145.147.254', '1501024974', 0, 1, '', '10', 1501111390, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501025095', '1501025395', '', 'Avatar.png', 'Hardhat.png', '', '', ''),
(33, 'Dylan', 'Devils16', 'klikcsgo@gmail.com', '24.166.68.253', '1501075620', 0, 0, '', '25', 1501162031, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501075686', '1501075986', '', 'Avatar.png', '', '', '', ''),
(35, 'adik', 'winter22', 'gabitzogaming@gmail.com', '71.17.169.156', '1501110225', 0, 0, '', '0', 1501196634, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501180418', '0', '', 'Avatar.png', 'cap.png', '', 'Logan.png', ''),
(36, 'Animus', 'lollol123', 'prips779@gmail.com', '87.175.124.83', '1501110422', 0, 0, '', '25', 1501196830, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501110459', '1501110759', '', 'Avatar.png', '', '', '', ''),
(37, 'KazeKorp', 'KazeKorp123', 'kaze@korp.com', '78.72.29.47', '1501111527', 0, 0, '', '10', 1501197942, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501111589', '1501111889', '', 'Avatar.png', 'Hardhat.png', '', '', ''),
(42, 'Limited', 'nick5501', 'geagfaefa@gmail.com', '73.46.200.163', '1501165399', 0, 0, '', '25', 1501251805, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501165424', '0', '', 'Avatar.png', '', '', '', ''),
(38, 'Isaac', 'devildoggamer', 'Isaac@outlook.com', '82.4.137.136', '1501122294', 0, 1, '', '24', 1501297829, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501271125', '0', '', 'Avatar.png', 'cap.png', '', 'Logan.png', 'sad.png'),
(39, 'Penguin', 'roblox21', 'MrPenguin@protonmail.com', '71.197.189.89', '1501129612', 0, 0, '', '25', 1501216026, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501129723', '0', '', 'Avatar.png', '', '', '', ''),
(40, 'Rich', 'ByJkI132x', 'iresetagain21@gmail.com', '81.100.184.151', '1501147534', 0, 0, '', '15', 1501876712, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501790365', '0', '', 'Avatar.png', 'crown.png', '', '', ''),
(41, 'lollol12', 'lolol12', 'bd@gmail.com', '86.97.123.171', '1501160037', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(97, 'Jay', 'KekNo', 'Jay', '72.208.207.226', '1501212000', 0, 0, '', '15', 1501298408, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501215688', '1501215988', '', 'Avatar.png', 'cone.png', '', 'outfit.png', ''),
(43, 'SparingFrisk', 'Lonelysoul', 'Amazingsparingfrisk@gmail.com', '68.108.175.100', '1501171673', 0, 0, '', '5', 1501258085, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501171748', '1501172048', '', 'Avatar.png', 'pirate.png', '', 'newsuit.png', ''),
(44, 'kys', '123123123', 'kys@kys.com', '82.32.206.143', '1501189749', 0, 0, '', '15', 1501276156, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501262193', '1501262493', '', 'Avatar.png', 'cone.png', '', 'summer.png', 'sad.png'),
(45, 'izik', 'ilovegames123', 'itsizikperfect@gmail.com', '75.134.129.39', '1501190080', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(46, 'noobooirum', 'Navajo21', 'nooboo@yahoo.com', '24.40.136.221', '1501190099', 0, 0, '', '0', 1501276512, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501190270', '1501190570', '', 'Avatar.png', 'natus.png', '', '', ''),
(47, 'izikisawesome', 'ilovegames123', 'itsizikperfect@gmail.com', '75.134.129.39', '1501190102', 0, 0, '', '0', 1501276509, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501203977', '1501204277', '', 'Avatar.png', 'natus.png', '', '', ''),
(48, 'creeper', '0987654321robby', 'j1283400@mvrht.net', '67.82.43.119', '1501190103', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(49, 'KingofKings', '0987654321robby', 'j1283400@mvrht.net', '67.82.43.119', '1501190151', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(50, 'creeperdudez', '0987654321robbyb', 'j1283400@mvrht.net', '67.82.43.119', '1501190199', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(51, 'Person299', 'eNDLESS70K', 'fake@fake.fake', '75.135.70.121', '1501202498', 0, 0, '', '25', 1501288905, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501202637', '1501202937', '', 'Avatar.png', '', '', '', ''),
(52, 'KidCudi', 'KidCudi', 'KidCudi@gmail.com', '137.186.143.241', '1501202514', 0, 0, '', '25', 1501288920, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501203528', '1501203828', '', 'Avatar.png', '', '', '', ''),
(53, 'gfeaiugnawin', 'nick5501', 'geagaew@aol.com', '73.46.200.163', '1501202558', 0, 0, '', '25', 1501288964, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501202571', '0', '', 'Avatar.png', '', '', '', ''),
(54, 'Zech', 'yeshua247', 'zecharyconley@gmail.com', '47.41.46.159', '1501202953', 0, 0, '', '25', 1501289379, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501203007', '1501203307', '', 'Avatar.png', '', '', '', ''),
(55, 'nigga', 'herecomedatboi', 'shiteater@gmail.com', '24.118.220.7', '1501203175', 0, 0, '', '20', 1501289592, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501204167', '1501204467', '', 'Avatar.png', 'cap.png', '', '', ''),
(56, 'lol', 'poop123eb', 'super.r.moneysz@gmail.com', '96.246.198.93', '1501203248', 0, 0, '', '15', 1501289661, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501204359', '1501204659', '', 'Avatar.png', 'pirate.png', '', '', ''),
(57, 'FUCKINGNIGGER', 'flame6921', 'masterflame11@gmail.com', '199.182.202.14', '1501203472', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(58, 'Miller', 'Miller12ZX', 'Mex_Miller@protonmail.com', '76.113.130.26', '1501203513', 0, 0, '', '25', 1501289937, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501203593', '1501203893', '', 'Avatar.png', '', '', '', ''),
(59, 'Wizard', 'zander88', 'epickid8899@gmail.com', '74.137.142.192', '1501204257', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(60, 'shameless', 'pp993e6fg', 'spaminthisemail@gmail.com', '24.44.249.254', '1501204465', 0, 0, '', '4', 1501290873, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501204775', '1501205075', '', 'Avatar.png', '', '', '', 'sad.png'),
(61, 'Ballora', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204673', 0, 0, '', '40', 1502500595, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502491950', '0', '', 'Avatar.png', 'crown.png', '', '', ''),
(62, 'Cat', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204720', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(63, 'Foxy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204736', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(64, 'Carrie', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204776', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(65, 'Bleach', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204804', 0, 1, '', '24', 1501291557, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501213694', '0', '', 'Avatar.png', '', '', '', 'sad.png'),
(66, 'Marionette', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204839', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(67, 'CircusBaby', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204861', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(68, 'BLOXCity', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204903', 0, 1, '', '25', 1501300112, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501213810', '0', '', 'Avatar.png', '', '', '', ''),
(69, 'HankHill', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501204952', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(70, 'Minecraft', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205003', 0, 0, '', '10', 1501291421, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501205144', '0', '', 'Avatar.png', 'Hardhat.png', '', '', ''),
(71, 'Untitled', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205417', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(72, 'McDonalds', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205434', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(73, 'Noob', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205471', 0, 0, '', '25', 1501300369, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501214036', '0', '', 'Avatar.png', '', '', '', ''),
(74, 'xXcandygirl2', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205491', 0, 0, '', '49', 1502026985, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501940636', '0', 'hAAi', 'Avatar.png', 'pirate.png', '', 'outfit.png', 'sad.png'),
(75, 'Fuck', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205511', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(76, 'Spongebob', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205534', 0, 0, '', '25', 1501300761, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501215306', '0', '', 'Avatar.png', '', '', '', ''),
(77, 'Microsoft', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205658', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(78, 'Satan', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205671', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(79, 'Keylogger', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501205693', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(80, 'KKK', 'chaudhry555', 'sarachaudhry800@gmail.com', '98.227.12.169', '1501205712', 0, 0, '', '25', 1501294559, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501208444', '1501208744', '', 'Avatar.png', '', '', '', ''),
(81, 'Potato', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501206027', 0, 0, '', '25', 1502578764, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502492446', '0', '', 'Avatar.png', '', '', '', ''),
(82, 'This', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501206063', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(83, 'Website', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501206077', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(84, 'Sucks', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501206088', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(87, 'Administrator', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207061', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(85, 'RainbowDude', 'phamHD123', 'vinhson9908@gmail.com', '108.27.248.230', '1501206323', 0, 0, '', '25', 1501292749, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501206451', '0', '', 'Avatar.png', '', '', '', ''),
(86, 'Bob', 'DuelOfDoom123', 'DuelOfDoomFTW@gmail.com', '104.56.196.115', '1501206330', 0, 0, '', '25', 1501292746, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501206755', '1501207055', '', 'Avatar.png', '', '', '', ''),
(88, 'AFK', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207201', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(89, 'Meme', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207211', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(90, 'Troll', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207223', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(91, 'Dora', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207307', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(92, 'Internet', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207331', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(93, 'Pepe', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207362', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(94, '911', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207386', 0, 0, '', '25', 1501307754, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501262219', '0', '', 'Avatar.png', '', '', '', ''),
(95, 'Hooker', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501207678', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(98, 'Mangle', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212121', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(96, 'Lucy', 'devildoggamer', 'Lucy@outlook.com', '82.4.137.136', '1501211650', 0, 1, '', '5', 1501298054, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501267360', '1501267660', '', 'Avatar.png', 'beaniee.png', '', '', ''),
(99, 'Death', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212161', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(100, 'AyanoAishi', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212186', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(101, 'Apple', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212201', 0, 0, '', '25', 1502670972, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502639625', '1502639925', '', 'Avatar.png', '', '', '', ''),
(102, 'Android', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212270', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(103, 'Virus', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212286', 0, 0, '', '25', 1501300455, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501214098', '0', '', 'Avatar.png', '', '', '', ''),
(104, 'Hacker', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212302', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(105, 'Salt', 'chaudhry555', 'sarachaudhry800@gmail.com', '104.37.100.94', '1501212321', 0, 0, '', '40', 1503298158, 0, 0, 1, 0, '', 'false', 'false', 'false', '1503212096', '1503212396', '', 'Avatar.png', '', '', '', ''),
(106, 'Adam', 'devildoggamer', 'Adam@outlook.com', '82.4.137.136', '1501212335', 0, 0, '', '10', 1517097269, 0, 0, 1, 0, '', 'true', 'false', 'false', '1517012716', '1517013016', '', 'Avatar.png', 'Icecream.png', '', 'Logan.png', ''),
(107, 'Pepper', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212340', 0, 0, '', '25', 1501300261, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501213903', '0', '', 'Avatar.png', '', '', '', ''),
(108, 'Pedophile', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212356', 0, 1, '', '0', 1502578405, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502492178', '0', '', 'Avatar.png', 'beaniee.png', '', 'Logan.png', ''),
(109, 'Chica', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212389', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(110, 'Bonnie', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212408', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(111, 'Freddy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212423', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(112, 'OnlineDater', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212443', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(113, 'Mom', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212456', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(114, 'Dad', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212470', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(115, 'Son', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212487', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(116, 'Daughter', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212497', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(117, 'HughesNet', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501212539', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(118, 'Triumphant', 'cmpunk12', 'staticzdenial@gmail.com', '73.8.95.28', '1501212911', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(119, 'null', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214120', 0, 0, '', '25', 1501352570, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501266184', '0', '', 'Avatar.png', '', '', '', ''),
(120, 'JohnDoe', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214145', 0, 0, '', '25', 1501301001, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501214609', '0', '', 'Avatar.png', '', '', '', ''),
(121, 'JaneDoe', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214175', 0, 0, '', '25', 1501301017, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501214634', '0', '', 'Avatar.png', '', '', '', ''),
(122, 'Herobrine', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214211', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(123, 'Username', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214232', 0, 0, '', '20', 1501352255, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501265952', '0', '', 'Avatar.png', '', '', '', ''),
(124, 'Password', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214248', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(125, 'Squidward', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214262', 0, 0, '', '25', 1501300935, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501215195', '0', '', 'Avatar.png', '', '', '', ''),
(126, 'Patrick', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214273', 0, 0, '', '25', 1501300905, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501214822', '0', '', 'Avatar.png', '', '', '', ''),
(127, 'MrKrabs', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214319', 0, 0, '', '25', 1501300726, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501214993', '0', '', 'Avatar.png', '', '', '', ''),
(128, 'Plankton', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501214394', 0, 0, '', '25', 1501301045, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501215279', '0', '', 'Avatar.png', '', '', '', ''),
(129, 'TheLegend27', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501215340', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(130, 'Springtrap', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501215727', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(131, 'Siri', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501215936', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(132, 'Dog', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216063', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(133, 'Barbie', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216095', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(134, 'BonBon', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216170', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(135, 'God', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216181', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(136, 'Jesus', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216203', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(137, 'Batman', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216246', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(138, 'Robin', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216277', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(139, 'Starfire', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216293', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(140, 'Raven', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216309', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(141, 'BeastBoy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216324', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(142, 'Cyborg', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216336', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(143, 'Rick', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216349', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(144, 'Morty', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216360', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(145, 'Robot', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216371', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(146, 'Milk', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216413', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(147, 'Ghost', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216424', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(148, 'Doll', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216459', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(149, 'Soul', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216476', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(150, 'Princess', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216590', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(151, 'Prince', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216605', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(152, 'King', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216616', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(153, 'Queen', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216640', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(154, 'Duck', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216649', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(155, 'Joker', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216661', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(156, 'HarleyQuinn', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216687', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(157, 'Penquin', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216701', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(158, 'Linux', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216763', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(159, 'OkaRuto', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216776', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(160, 'MusumeRonshaku', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216802', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(161, 'OsanaNajimi', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216836', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(162, 'Harambe', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216849', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(163, 'Weed', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501216881', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(164, 'Cash', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217021', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(165, 'HatsuneMiku', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217201', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(166, 'Fluttershy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217240', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(167, 'Mario', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217307', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(168, 'Luigi', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217319', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(169, 'Yoshi', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217377', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(170, 'PrincessPeach', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217388', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(171, 'Wario', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217412', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(172, 'Goomba', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217425', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(173, 'DavidBaszucki', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217540', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(174, 'Cortana', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217927', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(175, 'Alexa', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501217940', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(176, 'Trash', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218001', 0, 0, '', '19', 1501304810, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501221835', '0', '', 'Avatar.png', 'cone.png', '', '', 'sad.png'),
(177, 'Cancer', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218032', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(178, 'Happy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218064', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(179, 'Sad', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218084', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(180, 'Mad', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218094', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(181, 'Template', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218139', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(182, 'Build', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218153', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(183, 'Destroy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218199', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(184, 'Create', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218225', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(185, 'Construction', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218251', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(186, 'ToyChica', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218482', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(187, 'ToyBonnie', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218497', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(188, 'ToyFreddy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218513', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(189, 'Cupcake', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218553', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(190, 'FuntimeFoxy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218623', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(191, 'FuntimeFreddy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218658', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(192, 'FuntimeChica', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218674', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(193, 'FuntimeBonnie', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218684', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(194, 'FuntimeBaylor', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218695', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(195, 'Candix', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218716', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(196, 'Candy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218744', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(197, 'Fairy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218754', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(198, 'Mermaid', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218768', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(199, 'YouTube', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218813', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(200, 'NoRegerts', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501218838', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(201, 'PornHub', 'chaudhry555', 'Sarachaudhry800@gmail.com', '24.213.8.115', '1501219136', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(202, 'Emoji', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501219323', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(203, 'Plushtrap', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501219398', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(204, 'Pikachu', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501221060', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(205, 'Tycoon', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501221110', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(206, 'PeptolBismol', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501221157', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(207, 'Paypal', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501221258', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(208, 'Wifi', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501221317', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(209, 'Hentai', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501221892', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(210, 'TheC0mmunity', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222109', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(211, '1337', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222392', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(212, 'Brother', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222437', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(213, 'Sister', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222456', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(214, 'Grandma', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222469', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(215, 'Grandpa', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222480', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(216, 'Aunt', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222489', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(217, 'Baby', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222508', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(218, 'Cousin', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222523', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(219, 'Girl', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222545', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(220, 'Boy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222556', 0, 0, '', '15', 1501349181, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501262895', '0', '', 'Avatar.png', '', '', 'summer.png', ''),
(221, 'Female', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222574', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(222, 'Male', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222582', 0, 0, '', '20', 1501349312, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501263028', '0', '', 'Avatar.png', '', '', 'outfit.png', ''),
(223, 'Kid', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222604', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(224, 'Child', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222612', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(225, 'PurpleGuy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222625', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(226, 'PurpleGirl', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222649', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(227, 'Man', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222662', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(228, 'Woman', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222672', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(229, 'Feminist', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222685', 0, 0, '', '25', 1501349435, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501263104', '0', '', 'Avatar.png', '', '', '', ''),
(230, 'Nazi', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222735', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(231, 'Hitler', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222745', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(232, 'Grammar', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222767', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(233, 'ABC', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222811', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(234, 'User', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222835', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(235, 'Yesterday', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222852', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(236, 'Today', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222860', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(237, 'Tomorrow', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222868', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(238, 'Water', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222894', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(239, 'Lava', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222914', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(240, 'Neko', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222928', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(241, 'Nemo', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222977', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(242, 'Kawaii', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501222989', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(243, 'Guest', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501223039', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(244, 'Sexy', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501223126', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(245, 'EMS', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501223356', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(246, 'EAS', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501223378', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', '');
INSERT INTO `users` (`id`, `username`, `password`, `email`, `ip`, `datecreated`, `verified`, `banned`, `reason`, `emeralds`, `getemeralds`, `trades`, `requests`, `messages`, `elite`, `eliteexpire`, `admin`, `bouncer`, `designer`, `visittick`, `expiretime`, `description`, `package`, `accessory`, `badge`, `outfit`, `face`) VALUES
(247, 'HillaryClinton', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501223434', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(248, 'DonaldTrump', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501223457', 0, 0, '', '55', 1502670917, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502584553', '0', '', 'Avatar.png', '', '', '', ''),
(249, 'ceffen2', 'Moses61059', 'aaronj5133@gmail.com', '174.130.33.199', '1501225282', 0, 0, '', '20', 1501444751, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501360889', '1501361189', '', 'Avatar.png', 'pirate.png', '', 'Logan.png', ''),
(269, 'dre', 'helloworld', 'alright@gmail.com', '108.199.161.98', '1501820596', 0, 0, '', '25', 1501907026, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501820721', '1501821021', '', 'Avatar.png', '', '', '', ''),
(250, 'Daniel', 'KeyBai105891', 'danielkaapro@gmail.com', '110.169.11.177', '1501236978', 0, 0, '', '25', 1501323393, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501237238', '0', '', 'Avatar.png', '', '', '', ''),
(251, 'Lord', 'thomas01', 'thomasneighbors8@gmail.com', '65.186.25.68', '1501239610', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(252, 'rooted', 'clockwork3030', 'xcloudx0@gmail.com', '124.106.246.211', '1501247644', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(253, 'Trylex', 'kainn1503', 'freezinggotfrozed@hotmail.com', '141.134.171.237', '1501247860', 0, 0, '', '20', 1501334273, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501247992', '1501248292', '', 'Avatar.png', 'cap.png', '', '', ''),
(254, 'overdued', 'clockwork3030', 'xcloudx0@gmail.com', '124.106.246.211', '1501247903', 0, 0, '', '25', 1501334337, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501252311', '1501252611', '', 'Avatar.png', '', '', '', ''),
(255, 'sarb', 'ficodakiviki2014', 'thegtaivfan@gmail.com', '109.92.189.2', '1501256042', 0, 0, '', '0', 1501342454, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501256199', '1501256499', '', 'Avatar.png', 'Hardhat.png', '', 'Logan.png', ''),
(256, 'Sirgaiwan', 'gaca2005', 'goncaloalves2005@gmail.com', '2.80.0.55', '1501261058', 0, 0, '', '25', 1502626871, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502540745', '1502541045', '', 'Avatar.png', 'cap.png', '', 'summer.png', ''),
(257, 'UltraX', 'killon45', 'UltraXGraalHacks@gmail.com', '73.17.136.124', '1501261703', 0, 0, '', '25', 1501348113, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501261733', '1501262033', '', 'Avatar.png', '', '', '', ''),
(258, 'Heart', 'BloxcityCopy101', 'thd04503@sjuaq.com', '104.8.187.51', '1501262707', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(259, 'Yes', 'chaudhry555', 'sarachaudhry800@gmail.com', '24.213.8.115', '1501266127', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(260, 'Alex', 'hej1234', 'Jontyhebbex@hotmail.com', '85.229.215.123', '1501284210', 0, 0, '', '69', 1502918379, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502832478', '1502832778', '', 'Avatar.png', 'brick.png', '', '', ''),
(261, 'fuckme', 'max08max', 'goderpychocolate@gmail.com', '67.166.244.151', '1501287502', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(262, 'Sesuiro', 'blerick123', 'sesuiro@gmail.com', '84.83.253.55', '1501331875', 0, 1, '', '19', 1501746443, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501660113', '1501660413', '', 'Avatar.png', 'cap.png', '', 'outfit.png', 'sad.png'),
(268, 'Pop', 'Loleris123', 'dfgdfg@me.com', '86.176.0.114', '1501654752', 0, 0, '', '40', 1501856551, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501824086', '1501824386', '', 'Avatar.png', '', '', '', ''),
(263, 'DJASODFNOUA', 'Loleris', 'kjnbaf@me.com', '86.176.0.114', '1501567059', 0, 0, '', '25', 1501741104, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501654709', '0', '', 'Avatar.png', 'crown.png', '', '', ''),
(264, 'tetris', 'lango33', 'myemailistemporary@gmail.com', '90.191.16.123', '1501571798', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(265, 'Level', 'Level', 'raqehkjwq@gmail.com', '49.145.147.254', '1501592647', 0, 0, '', '5', 1501679055, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501593476', '1501593776', '', 'Avatar.png', 'natus.png', '', '', ''),
(266, 'Z0rkx', 'zaks159159', 'DragonOfSpace@outlook.com', '78.84.22.194', '1501598763', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(267, 'Akira', '1M0nst3r', 'gamerbroesproduction@gmail.com', '47.184.169.143', '1501607234', 0, 0, '', '0', 1501693642, 0, 0, 1, 0, '', 'false', 'false', 'false', '1501607383', '1501607683', '', 'Avatar.png', 'pirate.png', '', '', ''),
(270, 'F15', 'Echoswag', 'jerechoportillo@outlook.com', '125.212.121.237', '1502158554', 0, 0, '', '25', 1502245536, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502159506', '1502159806', '', 'Avatar.png', '', '', '', ''),
(271, 'Bitch', 'chaudhry555', 'Sarachaudhry800@gmail.com', '24.213.8.115', '1502493106', 0, 0, '', '25', 1502579522, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502493128', '0', '', 'Avatar.png', '', '', '', ''),
(272, 'CarmenWinstead', 'chaudhry555', 'Sarachaudhry800@gmail.com', '24.213.8.115', '1502493268', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(273, 'nooo', 'no123456', 'no@no.com', '81.109.209.193', '1502821167', 0, 0, '', '25', 1502907577, 0, 0, 1, 0, '', 'false', 'false', 'false', '1502821257', '1502821557', '', 'Avatar.png', '', '', '', ''),
(274, 'Yandere', 'chaudhry55', 'sarachaudhry800@gmail.com', '104.37.100.94', '1503211272', 0, 0, '', '25', 1503297681, 0, 0, 1, 0, '', 'false', 'false', 'false', '1503211670', '0', '', 'Avatar.png', '', '', '', ''),
(275, 'Mechy', 'RobloxianWatchDog12', 'leonpugh123@live.co.uk', '86.160.130.29', '1516810547', 0, 0, '', '35', 1517024992, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516939218', '1516939518', '', 'Avatar.png', 'top.png', '', '', ''),
(276, 'SiteAdmin', 'Winter987', 'centralblox@gmail.com', '205.215.175.102', '1516812205', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(277, 'job', 'sonam1234', 'woedsertenzin@gmail.com', '205.215.175.102', '1516813290', 0, 0, '', '25', 1516899701, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516813330', '0', '', 'Avatar.png', '', '', '', ''),
(278, 'John', 'sonam1234', 'juroshima1@gmail.com', '205.215.175.102', '1516813497', 0, 0, '', '10', 1516899912, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516814251', '1516814551', '', 'Avatar.png', 'top.png', '', '', ''),
(279, 'Old', 'sonam1234', 'juroshima2@gmail.com', '205.215.175.102', '1516813670', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(280, 'Admin', 'sonam1234', 'juroshima4@gmail.com', '205.215.175.102', '1516813782', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(281, 'CloutGang', 'Pasta1nico', 'anocknock4all@gmail.com', '73.141.196.47', '1516814312', 0, 0, '', '20', 1516900758, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516814725', '1516815025', '', 'Avatar.png', 'top.png', '', '', ''),
(282, 'test', 'testtest', 'test@test.test', '129.161.80.16', '1516823061', 0, 0, '', '20', 1516909470, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516823501', '1516823801', '', 'Avatar.png', 'top.png', '', '', ''),
(283, 'copy', 'copycopy', 'copy@copy.com', '12.91.232.66', '1516887464', 0, 1, '', '35', 1517060907, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516974531', '1516974831', 'wefretrhtre', 'Avatar.png', 'top.png', '', '', ''),
(284, 'Pedophiles', 'PedophilePedophile', 'Pedophiles@outlook.com', '82.4.137.136', '1516900627', 0, 1, '', '25', 1516987063, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516900695', '1516900995', '', 'Avatar.png', '', '', '', ''),
(285, 'MegaDrive', 'pulppulp75', 'august.lytken@gmail.com', '158.248.233.54', '1516905179', 0, 0, '', '35', 1517140580, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517123677', '1517123977', '', 'Avatar.png', 'top.png', '', '', ''),
(286, 'Wow', 'seth1214', 'robloxgaming92@gmail.com', '68.34.80.253', '1516905189', 0, 0, '', '25', 1517097493, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517011394', '1517011694', '', 'Avatar.png', 'recycle.png', '', '', ''),
(287, 'Warlord', 'hacker007agent', 'nuavorblx@gmail.com', '5.142.128.202', '1516905200', 0, 0, '', '15', 1516991638, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516912738', '1516913038', 'h0h', 'Avatar.png', 'top.png', '', '', ''),
(288, 'DavidTheBest', 'comeculol1', 'brickplaentdavid@gmail.com', '179.177.162.252', '1516905525', 0, 0, '', '25', 1517083800, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517011293', '1517011593', '', 'Avatar.png', 'recycle.png', '', '', ''),
(289, 'NickCool', 'nick5501', 'feaoinfe@gmail.com', '73.1.145.75', '1516906098', 0, 0, '', '15', 1516992506, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516908266', '0', '', 'Avatar.png', '', '', '', ''),
(290, 'Malcolm', 'shamrock61', 'malcolmeli02@gmail.com', '77.71.158.69', '1516907929', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(291, 'Will', 'Eggi1111', 'katybaptist@gmail.com', '80.234.181.130', '1516909599', 0, 0, '', '20', 1516996009, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516909711', '1516910011', '', 'Avatar.png', 'top.png', '', '', ''),
(292, 'Heal', 'datboi1166', 'Purpleshep10199@gmail.com', '68.51.176.172', '1516911247', 0, 0, '', '25', 1516997655, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516911271', '1516911571', '', 'Avatar.png', '', '', '', ''),
(293, 'Ash', '@we$0me64', 'RobbaeFoxay@gmail.com', '68.37.53.93', '1516911700', 0, 0, '', '25', 1516999442, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516913080', '1516913380', '', 'Avatar.png', '', '', '', ''),
(294, 'Nish', 'yousef20', 'nish111po@gmail.com', '99.250.229.159', '1516911732', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(295, '420', '420420420', 'asherludkin@gmail.com', '172.58.120.91', '1516911779', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(296, 'Egg', 'Gaylord99', 'fhuiebwfe779827039@gmail.com', '24.146.166.122', '1516912096', 0, 1, '', '20', 1516998507, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516913550', '1516913850', '', 'Avatar.png', 'top.png', '', '', ''),
(297, 'qawz', 'ads12345q', 'andreyrudachenko228@gmail.com', '134.249.205.208', '1516912120', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(298, 'firecatmagic', 'd3noob666', 'nogay@gay.gay', '75.118.188.119', '1516914256', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(299, 'Ole', 'wtfisthissite', 'yourgamingman@gmail.com', '79.160.18.14', '1516914349', 0, 0, '', '25', 1517000786, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516914415', '1516914715', '', 'Avatar.png', '', '', '', ''),
(300, 'Blank', 'kevin345', 'nbatroop@gmail.com', '68.116.192.161', '1516922165', 0, 0, '', '50', 1517443707, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517357323', '1517357623', '', 'Avatar.png', 'top.png', '', '', ''),
(301, 'stealer', 'stealingstealer', 'niggerfaggot@fuckyou.cum', '98.161.55.211', '1516923159', 0, 0, '', '25', 1517009570, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516925175', '1516925475', '', 'Avatar.png', '', '', '', ''),
(302, 'brandon', 'superman123', 'epicpeep@yahoo.com', '76.189.147.102', '1516925383', 0, 0, '', '49950', 1517011790, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516925648', '1516925948', '', 'Avatar.png', 'Icecream.png', '', '', ''),
(303, 'Shiwjwbe', 'mmmmmmm', 'hdhdhsjsjhs@gmail.com', '24.146.166.122', '1516928505', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(304, 'Iris', 'Cksl1400', 'corod3325@gmail.com', '68.144.198.156', '1516932952', 0, 0, '', '25', 1517019386, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516933016', '1516933316', '', 'Avatar.png', '', '', '', ''),
(305, 'JimmyTheNoob', 'yolo1010', 'jimmynoob0@gmail.com', '141.237.182.30', '1516962380', 0, 0, '', '20', 1517048792, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516962550', '1516962850', '', 'Avatar.png', 'top.png', '', '', ''),
(306, 'Tremor', 'mining12', 'mineswafi2@gmail.com', '42.153.43.141', '1516962886', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(307, 'SkateAlert', '<title>hi</title>', 'faggot@pornhub.cunt', '62.231.136.5', '1516964216', 0, 0, '', '20', 1517050621, 0, 0, 1, 0, '', 'false', 'false', 'false', '1516971794', '1516972094', '', 'Avatar.png', 'top.png', '', '', ''),
(308, 'niceguy1000', 'lolLol99', 'steviep131@outlook.com', '62.231.136.5', '1516964304', 0, 0, '', '30', 1517493350, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517488393', '1517488693', '', 'Avatar.png', 'top.png', '', '', ''),
(309, 'copy1', 'copycopy', 'copy@copy.com', '75.132.19.99', '1516974548', 0, 1, '', '40', 1517809796, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517723627', '1517723927', '', 'Avatar.png', 'Icecream.png', '', '', ''),
(310, 'Gabe', 'winter22', 'qweqweqwe@gmail.com', '71.17.169.156', '1517000034', 0, 0, '', '25', 1517086449, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517000060', '1517000360', '', 'Avatar.png', '', '', '', ''),
(311, 'adsdasasddas', 'adsdasasddas123', 'aasdasdads@Hotmail.com', '92.25.189.122', '1517009086', 0, 0, '', '25', 1517095505, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517009110', '1517009410', '', 'Avatar.png', '', '', '', ''),
(312, 'Knuckles', 'brickplanet', '781jfhuweif@gmail.com', '24.146.166.122', '1517011093', 0, 1, '', '25', 1517097503, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517012183', '1517012483', '', 'Avatar.png', '', '', '', ''),
(313, 'JSONDxCode', 'tn4itk23', 'teamvenomowner@gmail.com', '98.121.115.91', '1517088533', 0, 0, '', '10', 1517174959, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517089047', '1517089347', '', 'Avatar.png', 'top.png', '', '', ''),
(314, 'skatealertxss', 'xssvuln', 'ytskatealert@gmail.com', '109.152.91.109', '1517105381', 0, 0, '', '25', 1517191789, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517139162', '1517139462', '', 'Avatar.png', '', '', '', ''),
(315, 'drifttwo', 'peace123', 'starcon95@gmail.com', '142.59.152.131', '1517207748', 0, 0, '', '25', 1517294162, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517208223', '1517208523', '', 'Avatar.png', '', '', '', ''),
(316, 'sturmwaffeln', 'salkin', 'kramrux10@hotmail.com', '82.83.70.77', '1517212243', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(317, 'Nick90176', 'fuckkkkkk', 'kramrux10@hotmail.com', '82.83.70.77', '1517212300', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(318, 'ihascancer', 'cancer', 'adsad@DAsad.com', '62.231.136.5', '1517216864', 0, 0, '', '25', 1517303272, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517216969', '1517217269', '', 'Avatar.png', '', '', '', ''),
(319, 'KyleGamer', '03987654', 'miguelbuccat@gmail.com', '205.234.124.99', '1517221752', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(320, 'idfkbleach', 'dadadadsaddsadsa', 'adsadA@Ddsad.com', '62.231.136.5', '1517233328', 0, 0, '', '25', 1517319736, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517234248', '1517234548', '', 'Avatar.png', '', '', '', ''),
(321, 'deathspy', 'papamama123', 'gishiev.salman123@gmail.com', '91.10.39.165', '1517478219', 0, 0, '', '25', 1517564629, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517478243', '1517478543', '', 'Avatar.png', '', '', '', ''),
(322, 'teamnice', 'noice', 'dsfD@SFfds.com', '62.231.136.5', '1517482740', 0, 0, '', '25', 1517922919, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517836738', '1517837038', '', 'Avatar.png', 'hairr.png', '', '', ''),
(323, 'Aerous', 'alexuicool1', 'nexthero42@gmail.com', '79.116.206.224', '1517515868', 0, 0, '', '20', 1517602280, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517515908', '1517516208', '', 'Avatar.png', '', '', '', ''),
(324, 'Dank', 'Jonathan12', 'jncawesome@hotmail.com', '107.11.167.186', '1517542166', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(325, 'Northernlion', 'earthbound123', 'thornepop@hotmail.com', '68.149.244.125', '1517542645', 0, 0, '', '25', 1517629079, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517542868', '1517543168', '', 'Avatar.png', '', '', '', ''),
(326, 'Babyhamsta', 'hamstagang', 'Justin@Babyhamsta.com', 'NahFam -Bham cleared', '1517591661', 0, 0, '', '50000', 1518465542, 0, 0, 1, 1, '', 'true', 'true', 'true', '1518382639', '1518382939', '', 'Avatar.png', 'Icecream.png', '', '', ''),
(327, 'City', 'lopez123', 'jimmyjijuba@gmail.com', '70.166.212.162', '1517601610', 0, 0, '', '20', 1517688017, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517601657', '1517601957', '', 'Avatar.png', 'hairr.png', '', '', ''),
(328, 'reeeecee', 'reecey27', 'reecetodd51@gmail.com', '5.68.0.70', '1517695645', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(329, 'Chase', 'Chase71403', 'redsoxchase12@gmail.com', '70.190.177.60', '1517721949', 0, 0, '', '25', 1517808356, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517722471', '1517722771', '', 'Avatar.png', 'Icecream.png', '', '', ''),
(330, 'reece', 'reecey27', 'reecetodd51@gmail.com', '5.68.0.70', '1517739415', 0, 0, '', '35', 1517946763, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517860364', '1517860664', '', 'Avatar.png', 'hairr.png', '', '', ''),
(331, 'Zach', 'fredfred14', 'headquartesbusiness@gmail.com', '109.150.131.119', '1517739863', 0, 0, '', '25', 1517826285, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517739893', '1517740193', '', 'Avatar.png', '', '', '', ''),
(332, 'Axel', 'Axel123', 'axelbusiness@outlook.com', '86.183.180.50', '1517755639', 0, 0, '', '20', 1517842048, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517755785', '1517756085', '', 'Avatar.png', 'top.png', '', '', ''),
(333, 'Owner', '1010121', 'kiritoplayzgamez@gmail.com', '71.10.155.144', '1517771143', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(334, 'H2Oh', '1010121', 'kiritoplayzgamez@gmail.com', '71.10.155.144', '1517771272', 0, 0, '', '10', 0, 0, 0, 1, 0, '', 'false', 'false', 'false', '', '', '', 'Avatar.png', '', '', '', ''),
(335, 'TeamNoice', 'Noice', 'daadsadsDAS@das.com', '62.231.136.5', '1517836348', 0, 0, '', '20', 1517922758, 0, 0, 1, 0, '', 'false', 'false', 'false', '1517836777', '1517837077', '', 'Avatar.png', 'top.png', '', '', ''),
(336, 'nickok', 'nick5501', 'nicholassanfilippo@gmail.com', '73.1.145.75', '1518276578', 0, 0, '', '5', 1518362984, 0, 0, 1, 0, '', 'false', 'false', 'false', '1518276630', '0', '', 'Avatar.png', 'recycle.png', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
