-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `3DItemComments`
--

DROP TABLE IF EXISTS `3DItemComments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3DItemComments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Post` longtext NOT NULL,
  `time` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3DItemComments`
--

LOCK TABLES `3DItemComments` WRITE;
/*!40000 ALTER TABLE `3DItemComments` DISABLE KEYS */;
/*!40000 ALTER TABLE `3DItemComments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3DItemDrafts`
--

DROP TABLE IF EXISTS `3DItemDrafts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3DItemDrafts` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3DItemDrafts`
--

LOCK TABLES `3DItemDrafts` WRITE;
/*!40000 ALTER TABLE `3DItemDrafts` DISABLE KEYS */;
/*!40000 ALTER TABLE `3DItemDrafts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `3DItems`
--

DROP TABLE IF EXISTS `3DItems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `3DItems` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `3DItems`
--

LOCK TABLES `3DItems` WRITE;
/*!40000 ALTER TABLE `3DItems` DISABLE KEYS */;
/*!40000 ALTER TABLE `3DItems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Badges`
--

DROP TABLE IF EXISTS `Badges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Badges` (
  `UserID` int(11) NOT NULL,
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Position` longtext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Badges`
--

LOCK TABLES `Badges` WRITE;
/*!40000 ALTER TABLE `Badges` DISABLE KEYS */;
INSERT INTO `Badges` (`UserID`, `ID`, `Position`) VALUES (1,1,'Premium'),(-1,2,'Premium'),(1,3,'Referrer'),(-1,4,'Referrer'),(-1,5,'Admin'),(1,6,'Admin');
/*!40000 ALTER TABLE `Badges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Configuration`
--

DROP TABLE IF EXISTS `Configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Configuration` (
  `Register` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'true',
  `Maintenance` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT 'false',
  `Avatars` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '3D'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Configuration`
--

LOCK TABLES `Configuration` WRITE;
/*!40000 ALTER TABLE `Configuration` DISABLE KEYS */;
INSERT INTO `Configuration` (`Register`, `Maintenance`, `Avatars`) VALUES ('true','false','2D');
/*!40000 ALTER TABLE `Configuration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Inventory`
--

DROP TABLE IF EXISTS `Inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Inventory` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `File` longtext NOT NULL,
  `Type` longtext NOT NULL,
  `code1` longtext NOT NULL,
  `code2` longtext NOT NULL,
  `SerialNum` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Inventory`
--

LOCK TABLES `Inventory` WRITE;
/*!40000 ALTER TABLE `Inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `Inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Items`
--

DROP TABLE IF EXISTS `Items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Items` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Items`
--

LOCK TABLES `Items` WRITE;
/*!40000 ALTER TABLE `Items` DISABLE KEYS */;
/*!40000 ALTER TABLE `Items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Outfits`
--

DROP TABLE IF EXISTS `Outfits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Outfits` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Outfits`
--

LOCK TABLES `Outfits` WRITE;
/*!40000 ALTER TABLE `Outfits` DISABLE KEYS */;
/*!40000 ALTER TABLE `Outfits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Shout`
--

DROP TABLE IF EXISTS `Shout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Shout` (
  `Text` longtext CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Shout`
--

LOCK TABLES `Shout` WRITE;
/*!40000 ALTER TABLE `Shout` DISABLE KEYS */;
INSERT INTO `Shout` (`Text`) VALUES ('Welcome to BuildCity!');
/*!40000 ALTER TABLE `Shout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserIPs`
--

DROP TABLE IF EXISTS `UserIPs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserIPs` (
  `UserID` int(11) NOT NULL,
  `IP` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserIPs`
--

LOCK TABLES `UserIPs` WRITE;
/*!40000 ALTER TABLE `UserIPs` DISABLE KEYS */;
INSERT INTO `UserIPs` (`UserID`, `IP`) VALUES (1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(1,10990),(2,90192),(2,90192),(2,90192),(2,90192),(2,90192),(2,90192),(2,90192),(2,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,90192),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(3,109152),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218),(-1,9218);
/*!40000 ALTER TABLE `UserIPs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserItemComments`
--

DROP TABLE IF EXISTS `UserItemComments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserItemComments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `Post` longtext NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserItemComments`
--

LOCK TABLES `UserItemComments` WRITE;
/*!40000 ALTER TABLE `UserItemComments` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserItemComments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserStore`
--

DROP TABLE IF EXISTS `UserStore`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserStore` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserStore`
--

LOCK TABLES `UserStore` WRITE;
/*!40000 ALTER TABLE `UserStore` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserStore` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` (`Username`, `Password`, `ID`, `Rank`, `PowerAdmin`, `Description`, `Email`, `Twitter`, `IP`, `visitTick`, `expireTime`, `PowerGame`, `PowerImageModerator`, `PowerForumModerator`, `PowerArtist`, `PowerMegaModerator`, `OriginalName`, `Eyes`, `Mouth`, `Hair`, `Bottom`, `Top`, `Hat`, `Shoes`, `Accessory`, `forumflood`, `Bux`, `Rubies`, `Background`, `Body`, `Avatar3D`, `Ban`, `BanType`, `BanTime`, `BanDescription`, `BanLength`, `Hash`, `SuccessReferrer`, `Premium`, `PremiumExpire`, `isTester`, `pviews`, `BanContent`, `status`, `PowerTop`, `vipStart`, `vipEnd`, `vipsubscrid`, `adminID`, `room`, `myroomID`, `myroomIMG`, `roomaccess`, `roomname`, `roommax`, `roomMaxStart`, `roomMaxEnd`, `roommaxsubscrid`, `startX`, `startY`, `music`, `avatar`, `avatara`, `avatarb`, `avatarc`, `avatar_x`, `avatar_y`, `online_time`, `photo`, `WallFlood`, `MainGroupID`, `userx`, `usery`, `gameid`, `CommentFlood`, `getBux`, `ingamenum`, `chatid`, `chatstatus`, `ingame`) VALUES ('BuildCity','11d7c8872cfb4f1ce7dde190d54559ba0239eff06452f608c6ead9e9566aa5349cccf979301e9e02fd239778458ee8d2a2ad3b1a57f8a1b2b9c1edf6bb285ce2',1,0,'true','none','robloxfilmcam@gmail.com','','109.90.223.100','1481453484','1481453784','false','true','true','true','false','','','','','','','','','','','115','10','','Avatar.png','Avatar.png',0,'','','','','41b2bcd87e4a562ecb9c9e5a0da1fcd0',100,1,'54687425465687',0,0,'','0','0','0','0','0','0','','','templates/default/background.jpg	','1','','5','0','0','0','100','180','music/index.php','','','','','','','','nopic.jpg',0,0,5,5,0,0,1481539208,'','','',''),('Carl','ebec6b58eb8e5d3c64dc3ceac1c6665f98fe2827da8df3d712c2e72cda7f80d15e0371209d78734c05d4db128da1859d07dd0bd713c622360306a493dc6ab500',-1,0,'true','Hi my name is Carl','martyn99roblox@gmail.com','','92.18.89.215','1481644541','1481644841','false','true','true','true','false','','','','','','','','','','','365','10','','Avatar.png','Avatar.png',0,'','','','','5c5b2cddedc20c86426d78d2b215ef48',0,1,'unlimited',0,0,'','0','0','0','0','0','0','','','templates/default/background.jpg	','1','','5','0','0','0','100','180','music/index.php','','','','','','','','nopic.jpg',0,0,5,5,0,0,1481649470,'','','',''),('Itzbennytime','a8330bb050972e88be0903d09e29426fdd7d94f4c5c0b0e5a519f90b02963f3ff247eb177e74c91aa5ff7bc5e4d1656a87313da83c122c6a1c3b8b287fe9cfa2',3,0,'false','none','benshieber21@gmail.com','','109.152.242.215','1481563610','1481563910','false','false','false','false','false','','','','','','','','','','','115','10','','Avatar.png','Avatar.png',0,'','','','','e32a104f1f571d4980cdaf173f830681',0,0,'',0,0,'','0','0','0','0','0','0','','','templates/default/background.jpg	','1','','5','0','0','0','100','180','music/index.php','','','','','','','','nopic.jpg',0,0,5,5,0,0,1481650010,'','','','');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'buildcit_main'
--

--
-- Dumping routines for database 'buildcit_main'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-13 10:00:45
