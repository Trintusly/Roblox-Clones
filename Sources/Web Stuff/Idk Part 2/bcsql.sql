-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql201.byetcluster.com
-- Generation Time: Feb 05, 2017 at 07:07 PM
-- Server version: 5.6.34-79.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rfgd_19602460_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `3DItemComments`
--

CREATE TABLE IF NOT EXISTS `3DItemComments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Post` longtext NOT NULL,
  `time` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `3DItemDrafts`
--

CREATE TABLE IF NOT EXISTS `3DItemDrafts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `File` longtext NOT NULL,
  `Type` longtext NOT NULL,
  `Price` longtext NOT NULL,
  `CreatorID` int(11) NOT NULL,
  `saletype` varchar(1337) NOT NULL,
  `numbersales` int(11) NOT NULL,
  `numberstock` int(11) NOT NULL,
  `sell` varchar(1337) NOT NULL DEFAULT 'yes',
  `Description` longtext NOT NULL,
  `CreationTime` longtext NOT NULL,
  `store` varchar(1337) NOT NULL DEFAULT 'regular',
  `timemake` longtext NOT NULL,
  `itemDeleted` int(11) NOT NULL,
  `SalePrices` int(11) NOT NULL,
  `NumberSold` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `3DItems`
--

CREATE TABLE IF NOT EXISTS `3DItems` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `File` longtext NOT NULL,
  `Type` longtext NOT NULL,
  `Price` longtext NOT NULL,
  `saletype` varchar(1337) NOT NULL,
  `numbersales` int(11) NOT NULL,
  `numberstock` int(11) NOT NULL,
  `sell` varchar(1337) NOT NULL DEFAULT 'yes',
  `Description` longtext NOT NULL,
  `CreationTime` longtext NOT NULL,
  `store` varchar(1337) NOT NULL DEFAULT 'regular',
  `timemake` longtext NOT NULL,
  `itemDeleted` int(11) NOT NULL DEFAULT '0',
  `SalePrices` int(11) NOT NULL DEFAULT '0',
  `NumberSold` int(11) NOT NULL,
  `CreatorID` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Badges`
--

CREATE TABLE IF NOT EXISTS `Badges` (
  `UserID` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Position` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Badges`
--

INSERT INTO `Badges` (`UserID`, `ID`, `Position`) VALUES
(1, 1, 'Premium'),
(-1, 2, 'Premium'),
(1, 3, 'Referrer'),
(-1, 4, 'Referrer'),
(-1, 5, 'Admin'),
(1, 6, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `Configuration`
--

CREATE TABLE IF NOT EXISTS `Configuration` (
  `Register` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'true',
  `Maintenance` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `Avatars` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '3D'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Configuration`
--

INSERT INTO `Configuration` (`Register`, `Maintenance`, `Avatars`) VALUES
('true', 'false', '2D');

-- --------------------------------------------------------

--
-- Table structure for table `Inventory`
--

CREATE TABLE IF NOT EXISTS `Inventory` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `File` longtext NOT NULL,
  `Type` longtext NOT NULL,
  `code1` longtext NOT NULL,
  `code2` longtext NOT NULL,
  `SerialNum` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

CREATE TABLE IF NOT EXISTS `Items` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `File` longtext NOT NULL,
  `Type` longtext NOT NULL,
  `Price` longtext NOT NULL,
  `saletype` varchar(1337) NOT NULL,
  `numbersales` int(11) NOT NULL,
  `numberstock` int(11) NOT NULL,
  `sell` varchar(1337) NOT NULL DEFAULT 'yes',
  `Description` longtext NOT NULL,
  `CreationTime` longtext NOT NULL,
  `store` varchar(1337) NOT NULL DEFAULT 'regular',
  `timemake` longtext NOT NULL,
  `itemDeleted` int(11) NOT NULL DEFAULT '0',
  `SalePrices` int(11) NOT NULL DEFAULT '0',
  `NumberSold` int(11) NOT NULL,
  `CreatorID` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Outfits`
--

CREATE TABLE IF NOT EXISTS `Outfits` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `Eyes` varchar(1337) NOT NULL,
  `Mouth` varchar(1337) NOT NULL,
  `Hair` varchar(1337) NOT NULL,
  `Bottom` varchar(1337) NOT NULL,
  `Top` varchar(1337) NOT NULL,
  `Hat` varchar(1337) NOT NULL,
  `Shoes` varchar(1337) NOT NULL,
  `Accessory` varchar(1337) NOT NULL,
  `Background` varchar(1337) NOT NULL,
  `Body` varchar(1337) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Shout`
--

CREATE TABLE IF NOT EXISTS `Shout` (
  `Text` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Shout`
--

INSERT INTO `Shout` (`Text`) VALUES
('Welcome to BuildCity!');

-- --------------------------------------------------------

--
-- Table structure for table `UserIPs`
--

CREATE TABLE IF NOT EXISTS `UserIPs` (
  `UserID` int(11) NOT NULL,
  `IP` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `UserIPs`
--

INSERT INTO `UserIPs` (`UserID`, `IP`) VALUES
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(1, 10990),
(2, 90192),
(2, 90192),
(2, 90192),
(2, 90192),
(2, 90192),
(2, 90192),
(2, 90192),
(2, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 90192),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(3, 109152),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(-1, 9218),
(4, 69204),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(4, 69204),
(4, 69204),
(5, 71199),
(4, 69204),
(4, 69204),
(5, 71199),
(4, 69204),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(4, 69204),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(5, 71199),
(4, 69204),
(4, 69204),
(4, 69204),
(4, 69204);

-- --------------------------------------------------------

--
-- Table structure for table `UserItemComments`
--

CREATE TABLE IF NOT EXISTS `UserItemComments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Post` longtext NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `Username` longtext NOT NULL,
  `Password` longtext NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Rank` int(11) NOT NULL DEFAULT '0',
  `PowerAdmin` varchar(1337) NOT NULL DEFAULT 'false',
  `Description` varchar(20000) NOT NULL DEFAULT 'none',
  `Email` longtext NOT NULL,
  `Twitter` varchar(1337) NOT NULL,
  `IP` longtext NOT NULL,
  `visitTick` longtext NOT NULL,
  `expireTime` longtext NOT NULL,
  `PowerGame` varchar(1337) NOT NULL DEFAULT 'false',
  `PowerImageModerator` varchar(1337) NOT NULL DEFAULT 'false',
  `PowerForumModerator` varchar(1337) NOT NULL DEFAULT 'false',
  `PowerArtist` varchar(1337) NOT NULL DEFAULT 'false',
  `PowerMegaModerator` varchar(1337) NOT NULL DEFAULT 'false',
  `OriginalName` longtext NOT NULL,
  `Eyes` varchar(1337) NOT NULL,
  `Mouth` varchar(1337) NOT NULL,
  `Hair` varchar(1337) NOT NULL,
  `Bottom` varchar(1337) NOT NULL,
  `Top` varchar(1337) NOT NULL,
  `Hat` varchar(1337) NOT NULL,
  `Shoes` varchar(1337) NOT NULL,
  `Accessory` varchar(1337) NOT NULL,
  `forumflood` longtext NOT NULL,
  `Bux` varchar(1337) NOT NULL DEFAULT '15',
  `Rubies` varchar(1337) NOT NULL DEFAULT '10',
  `Background` longtext NOT NULL,
  `Body` varchar(1337) NOT NULL DEFAULT 'Avatar.png',
  `Avatar3D` varchar(1337) NOT NULL DEFAULT 'Avatar.png',
  `Ban` int(11) NOT NULL DEFAULT '0',
  `BanType` longtext NOT NULL,
  `BanTime` longtext NOT NULL,
  `BanDescription` longtext NOT NULL,
  `BanLength` longtext NOT NULL,
  `Hash` longtext NOT NULL,
  `SuccessReferrer` int(11) NOT NULL DEFAULT '0',
  `Premium` int(11) NOT NULL DEFAULT '0',
  `PremiumExpire` longtext NOT NULL,
  `isTester` int(11) NOT NULL DEFAULT '0',
  `pviews` int(11) NOT NULL DEFAULT '0',
  `BanContent` longtext NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `PowerTop` varchar(1337) NOT NULL DEFAULT '0',
  `vipStart` varchar(1000) NOT NULL DEFAULT '0',
  `vipEnd` varchar(100) NOT NULL DEFAULT '0',
  `vipsubscrid` varchar(50) NOT NULL DEFAULT '0',
  `adminID` varchar(3) NOT NULL DEFAULT '0',
  `room` varchar(50) NOT NULL,
  `myroomID` varchar(250) NOT NULL,
  `myroomIMG` varchar(250) NOT NULL DEFAULT 'templates/default/background.jpg	',
  `roomaccess` varchar(3) NOT NULL DEFAULT '1',
  `roomname` varchar(32) NOT NULL,
  `roommax` varchar(4) NOT NULL DEFAULT '5',
  `roomMaxStart` varchar(100) NOT NULL DEFAULT '0',
  `roomMaxEnd` varchar(100) NOT NULL DEFAULT '0',
  `roommaxsubscrid` varchar(20) NOT NULL DEFAULT '0',
  `startX` varchar(3) NOT NULL DEFAULT '100',
  `startY` varchar(3) NOT NULL DEFAULT '180',
  `music` varchar(255) NOT NULL DEFAULT 'music/index.php',
  `avatar` varchar(1000) NOT NULL,
  `avatara` varchar(250) NOT NULL,
  `avatarb` varchar(250) NOT NULL,
  `avatarc` varchar(250) NOT NULL,
  `avatar_x` varchar(10) NOT NULL,
  `avatar_y` varchar(10) NOT NULL,
  `online_time` varchar(50) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'nopic.jpg',
  `WallFlood` int(11) NOT NULL,
  `MainGroupID` int(11) NOT NULL,
  `userx` int(50) NOT NULL DEFAULT '5',
  `usery` int(50) NOT NULL DEFAULT '5',
  `gameid` int(50) NOT NULL,
  `CommentFlood` int(11) NOT NULL,
  `getBux` int(11) NOT NULL,
  `ingamenum` varchar(5) NOT NULL,
  `chatid` varchar(50) NOT NULL,
  `chatstatus` varchar(50) NOT NULL,
  `ingame` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`Username`, `Password`, `ID`, `Rank`, `PowerAdmin`, `Description`, `Email`, `Twitter`, `IP`, `visitTick`, `expireTime`, `PowerGame`, `PowerImageModerator`, `PowerForumModerator`, `PowerArtist`, `PowerMegaModerator`, `OriginalName`, `Eyes`, `Mouth`, `Hair`, `Bottom`, `Top`, `Hat`, `Shoes`, `Accessory`, `forumflood`, `Bux`, `Rubies`, `Background`, `Body`, `Avatar3D`, `Ban`, `BanType`, `BanTime`, `BanDescription`, `BanLength`, `Hash`, `SuccessReferrer`, `Premium`, `PremiumExpire`, `isTester`, `pviews`, `BanContent`, `status`, `PowerTop`, `vipStart`, `vipEnd`, `vipsubscrid`, `adminID`, `room`, `myroomID`, `myroomIMG`, `roomaccess`, `roomname`, `roommax`, `roomMaxStart`, `roomMaxEnd`, `roommaxsubscrid`, `startX`, `startY`, `music`, `avatar`, `avatara`, `avatarb`, `avatarc`, `avatar_x`, `avatar_y`, `online_time`, `photo`, `WallFlood`, `MainGroupID`, `userx`, `usery`, `gameid`, `CommentFlood`, `getBux`, `ingamenum`, `chatid`, `chatstatus`, `ingame`) VALUES
('BuildCity', '11d7c8872cfb4f1ce7dde190d54559ba0239eff06452f608c6ead9e9566aa5349cccf979301e9e02fd239778458ee8d2a2ad3b1a57f8a1b2b9c1edf6bb285ce2', 1, 0, 'true', 'none', 'robloxfilmcam@gmail.com', '', '109.90.223.100', '1481453484', '1481453784', 'false', 'true', 'true', 'true', 'false', '', '', '', '', '', '', '', '', '', '', '115', '10', '', 'Avatar.png', 'Avatar.png', 0, '', '', '', '', '41b2bcd87e4a562ecb9c9e5a0da1fcd0', 100, 1, '54687425465687', 0, 0, '', '0', '0', '0', '0', '0', '0', '', '', 'templates/default/background.jpg	', '1', '', '5', '0', '0', '0', '100', '180', 'music/index.php', '', '', '', '', '', '', '', 'nopic.jpg', 0, 0, 5, 5, 0, 0, 1481539208, '', '', '', ''),
('Carl', 'ebec6b58eb8e5d3c64dc3ceac1c6665f98fe2827da8df3d712c2e72cda7f80d15e0371209d78734c05d4db128da1859d07dd0bd713c622360306a493dc6ab500', -1, 0, 'true', 'Hi my name is Carl', 'martyn99roblox@gmail.com', '', '92.18.89.215', '1481644541', '1481644841', 'false', 'true', 'true', 'true', 'false', '', '', '', '', '', '', '', '', '', '', '365', '10', '', 'Avatar.png', 'Avatar.png', 0, '', '', '', '', '5c5b2cddedc20c86426d78d2b215ef48', 0, 1, 'unlimited', 0, 0, '', '0', '0', '0', '0', '0', '0', '', '', 'templates/default/background.jpg	', '1', '', '5', '0', '0', '0', '100', '180', 'music/index.php', '', '', '', '', '', '', '', 'nopic.jpg', 0, 0, 5, 5, 0, 0, 1481649470, '', '', '', ''),
('Itzbennytime', 'a8330bb050972e88be0903d09e29426fdd7d94f4c5c0b0e5a519f90b02963f3ff247eb177e74c91aa5ff7bc5e4d1656a87313da83c122c6a1c3b8b287fe9cfa2', 3, 0, 'false', 'none', 'benshieber21@gmail.com', '', '109.152.242.215', '1481563610', '1481563910', 'false', 'false', 'false', 'false', 'false', '', '', '', '', '', '', '', '', '', '', '115', '10', '', 'Avatar.png', 'Avatar.png', 0, '', '', '', '', 'e32a104f1f571d4980cdaf173f830681', 0, 0, '', 0, 0, '', '0', '0', '0', '0', '0', '0', '', '', 'templates/default/background.jpg	', '1', '', '5', '0', '0', '0', '100', '180', 'music/index.php', '', '', '', '', '', '', '', 'nopic.jpg', 0, 0, 5, 5, 0, 0, 1481650010, '', '', '', ''),
('test123', '1a0d665a20b95aff34cfd1d4585ecdb32cb73efede44486f5724ac94d8c4d29291fec17a4603857cd588bcc4e31b2dd76ab721a837848cdec3976d31b89746a9', 4, 0, 'false', 'none', 'iighost1337@gmail.com', '', '69.204.83.160', '1486339675', '1486339975', 'false', 'false', 'false', 'false', 'false', '', '', '', '', '', '', '', '', '', '', '115', '10', '', 'Avatar.png', 'Avatar.png', 0, '', '', '', '', '4bcf3022aee37320e81edd603f588679', 0, 0, '', 0, 0, '', '0', '0', '0', '0', '0', '0', '', '', 'templates/default/background.jpg	', '1', '', '5', '0', '0', '0', '100', '180', 'music/index.php', '', '', '', '', '', '', '', 'nopic.jpg', 0, 0, 5, 5, 0, 0, 1486425795, '', '', '', ''),
('Colin', 'd76616176af78a1f87df8eb9dbc38449d9bb4cdd7f9779217a283dac1426b95faed91251bcce500c328b0efe6f4a49b4fffb0550edcc1f9ee7a71984ef09b2fd', 5, 0, 'false', 'none', 'bloxytown@outlook.com', '', '71.199.208.150', '1486339597', '1486339897', 'false', 'false', 'false', 'false', 'false', '', '', '', '', '', '', '', '', '', '', '115', '10', '', 'Avatar.png', 'Avatar.png', 0, '', '', '', '', '02e401201bcf3056a31fff7d84c3752b', 0, 0, '', 0, 0, '', '0', '0', '0', '0', '0', '0', '', '', 'templates/default/background.jpg	', '1', '', '5', '0', '0', '0', '100', '180', 'music/index.php', '', '', '', '', '', '', '', 'nopic.jpg', 0, 0, 5, 5, 0, 0, 1486425820, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `UserStore`
--

CREATE TABLE IF NOT EXISTS `UserStore` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` longtext NOT NULL,
  `File` longtext NOT NULL,
  `Type` longtext NOT NULL,
  `Price` int(11) NOT NULL,
  `CreatorID` int(11) NOT NULL,
  `saletype` varchar(1337) NOT NULL DEFAULT 'regular',
  `numbersales` varchar(50) NOT NULL DEFAULT 'regular',
  `numberstock` varchar(50) NOT NULL DEFAULT 'regular',
  `sell` varchar(50) NOT NULL DEFAULT 'yes',
  `ns` varchar(100) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '0',
  `code1` longtext NOT NULL,
  `code2` longtext NOT NULL,
  `Description` longtext NOT NULL,
  `CreationTime` longtext NOT NULL,
  `store` varchar(1337) NOT NULL DEFAULT 'user',
  `itemDeleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
