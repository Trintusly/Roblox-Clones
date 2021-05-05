-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2019 at 09:32 PM
-- Server version: 5.7.26-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Achievement`
--

CREATE TABLE `Achievement` (
  `ID` int(11) NOT NULL,
  `Category` int(11) DEFAULT '0',
  `Name` text,
  `Description` longtext,
  `Image` text,
  `Special` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AdminCommendations`
--

CREATE TABLE `AdminCommendations` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Message` longtext,
  `IssuerID` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AdminDiscipline`
--

CREATE TABLE `AdminDiscipline` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Message` longtext,
  `IssuerID` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Points` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AdminEvents`
--

CREATE TABLE `AdminEvents` (
  `ID` int(11) NOT NULL,
  `Description` longtext,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AdminEventsAttending`
--

CREATE TABLE `AdminEventsAttending` (
  `ID` int(11) NOT NULL,
  `EventID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AttendingStatus` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AdminFiles`
--

CREATE TABLE `AdminFiles` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Points` int(11) DEFAULT '0',
  `SiteBannerAccess` int(11) DEFAULT '0',
  `PendingAssetsAccess` int(11) DEFAULT '1',
  `UserReportsAccess` int(11) DEFAULT '1',
  `ViewItemsAccess` int(11) DEFAULT '1',
  `ViewUsersAccess` int(11) DEFAULT '1',
  `ViewGroupsAccess` int(11) DEFAULT '1',
  `UploadAssetAccess` int(11) DEFAULT '0',
  `ViewAdminsAccess` int(11) DEFAULT '0',
  `ManageBlogAccess` int(11) DEFAULT '0',
  `PurchaseLogsAccess` int(11) DEFAULT '0',
  `SalesLogsAccess` int(11) DEFAULT '0',
  `AdminLogsAccess` int(11) DEFAULT '0',
  `ViewIPAccess` int(11) DEFAULT '0',
  `PersonnelAccess` int(11) DEFAULT '0',
  `OIGAccess` int(11) DEFAULT '0',
  `CommunityAffairsAccess` int(11) DEFAULT '0',
  `CustomerServiceAccess` int(11) DEFAULT '0',
  `SiteSettingsAccess` int(11) DEFAULT '0',
  `Reports` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AdministratorLogs`
--

CREATE TABLE `AdministratorLogs` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IP` varchar(255) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Action` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AdminReports`
--

CREATE TABLE `AdminReports` (
  `ID` int(11) NOT NULL,
  `ReportType` longtext,
  `Link` longtext,
  `Time` int(11) DEFAULT NULL,
  `Lock` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AdminShifts`
--

CREATE TABLE `AdminShifts` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `ShiftTime` int(11) DEFAULT NULL,
  `Reports` int(11) DEFAULT NULL,
  `Completed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AdminStatistics`
--

CREATE TABLE `AdminStatistics` (
  `ID` int(11) NOT NULL,
  `NumUsers` int(11) DEFAULT '0',
  `NumItems` int(11) DEFAULT '0',
  `NumGroups` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AdminTasks`
--

CREATE TABLE `AdminTasks` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AssignedBy` int(11) DEFAULT NULL,
  `Description` varchar(256) DEFAULT NULL,
  `TimeAssigned` int(11) DEFAULT NULL,
  `TimeDue` int(11) DEFAULT NULL,
  `RepeatInterval` int(11) DEFAULT NULL,
  `Response` longtext,
  `Completed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AssetChecksum`
--

CREATE TABLE `AssetChecksum` (
  `FileName` varchar(128) DEFAULT NULL,
  `Hash` varchar(128) DEFAULT NULL,
  `Status` tinyint(4) DEFAULT NULL COMMENT '0 - Pending\n1 - Accepted\n2 - Declined',
  `TimeCreated` int(11) DEFAULT NULL,
  `Frequency` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AssetChecksums`
--

CREATE TABLE `AssetChecksums` (
  `ID` int(11) NOT NULL,
  `Checksum` varchar(256) DEFAULT NULL,
  `ViewFile` varchar(128) DEFAULT NULL,
  `Approved` int(11) DEFAULT '0',
  `AssetType` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AssetModerationLogs`
--

CREATE TABLE `AssetModerationLogs` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Message` varchar(255) DEFAULT NULL,
  `LogTime` int(11) DEFAULT NULL,
  `IP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `AvatarUpdateQueue`
--

CREATE TABLE `AvatarUpdateQueue` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Locked` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BanLogs`
--

CREATE TABLE `BanLogs` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Message` varchar(255) DEFAULT NULL,
  `LogTime` int(11) DEFAULT NULL,
  `IP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BlockedEmail`
--

CREATE TABLE `BlockedEmail` (
  `ID` int(11) NOT NULL,
  `Email` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BlockedUser`
--

CREATE TABLE `BlockedUser` (
  `ID` int(11) NOT NULL,
  `RequesterID` int(11) DEFAULT NULL,
  `BlockedID` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `BlockedUsername`
--

CREATE TABLE `BlockedUsername` (
  `ID` int(11) NOT NULL,
  `Username` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `DirectChat`
--

CREATE TABLE `DirectChat` (
  `ID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `Message` varchar(256) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Type` int(11) DEFAULT '0' COMMENT '0 - Chat\n1 - Notification\n2 - Module',
  `Read` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EmailBlacklist`
--

CREATE TABLE `EmailBlacklist` (
  `ID` int(11) NOT NULL,
  `Email` varchar(45) DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EmailQueue`
--

CREATE TABLE `EmailQueue` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Type` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `IP` varchar(60) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `RevertCode` varchar(256) DEFAULT NULL,
  `Processing` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EmojiList`
--

CREATE TABLE `EmojiList` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Description` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `FavoriteFriend`
--

CREATE TABLE `FavoriteFriend` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TargetID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumAdminLog`
--

CREATE TABLE `ForumAdminLog` (
  `ID` int(11) NOT NULL,
  `ForumType` int(11) DEFAULT NULL,
  `ForumID` int(11) DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeAction` int(11) DEFAULT NULL,
  `ActionIP` varchar(60) DEFAULT NULL,
  `ActionDescription` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumBan`
--

CREATE TABLE `ForumBan` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT '0',
  `Reason` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumCategory`
--

CREATE TABLE `ForumCategory` (
  `ID` int(11) NOT NULL,
  `Name` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumReply`
--

CREATE TABLE `ForumReply` (
  `ID` int(11) NOT NULL,
  `ThreadID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Post` longtext,
  `TimePost` int(11) DEFAULT NULL,
  `QuoteType` int(11) DEFAULT '0',
  `QuoteID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumReplyLike`
--

CREATE TABLE `ForumReplyLike` (
  `ID` int(11) NOT NULL,
  `ReplyID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeLike` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumThread`
--

CREATE TABLE `ForumThread` (
  `ID` int(11) NOT NULL,
  `TopicID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(128) DEFAULT NULL,
  `Post` longtext,
  `TimePost` int(11) DEFAULT NULL,
  `TimeUpdated` int(11) DEFAULT NULL,
  `Likes` int(11) DEFAULT '0',
  `Locked` int(11) DEFAULT '0',
  `Pinned` int(11) DEFAULT '0',
  `Views` int(11) DEFAULT '0',
  `Replies` int(11) DEFAULT '0',
  `LastPostReplyID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumThreadBookmark`
--

CREATE TABLE `ForumThreadBookmark` (
  `UserID` int(11) DEFAULT NULL,
  `ThreadID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumThreadDraft`
--

CREATE TABLE `ForumThreadDraft` (
  `ID` int(11) NOT NULL,
  `Title` varchar(40) DEFAULT NULL,
  `Post` longtext,
  `UserID` int(11) DEFAULT NULL,
  `TopicID` int(11) DEFAULT NULL,
  `TimePost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumThreadLike`
--

CREATE TABLE `ForumThreadLike` (
  `ThreadID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeLike` int(11) DEFAULT NULL,
  `Active` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumThreadView`
--

CREATE TABLE `ForumThreadView` (
  `ID` int(11) NOT NULL,
  `ThreadID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeView` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ForumTopic`
--

CREATE TABLE `ForumTopic` (
  `ID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Name` varchar(128) DEFAULT NULL,
  `Description` varchar(128) DEFAULT NULL,
  `Posts` int(11) DEFAULT '0',
  `Replies` int(11) DEFAULT '0',
  `LastPostThreadID` int(11) DEFAULT NULL,
  `LastPostReplyID` int(11) DEFAULT NULL,
  `AdminPost` int(11) DEFAULT '0',
  `Sort` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Friend`
--

CREATE TABLE `Friend` (
  `ID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `TimeSent` int(11) DEFAULT NULL,
  `Accepted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `IPBan`
--

CREATE TABLE `IPBan` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `IP` varchar(60) DEFAULT NULL,
  `Reason` varchar(128) DEFAULT NULL,
  `TimePlaced` int(11) DEFAULT NULL,
  `TimeExpire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Item`
--

CREATE TABLE `Item` (
  `ID` int(11) NOT NULL,
  `ItemType` tinyint(4) DEFAULT NULL,
  `Name` varchar(70) DEFAULT NULL,
  `Description` varchar(1024) DEFAULT NULL,
  `CreatorID` int(11) DEFAULT NULL,
  `CreatorType` tinyint(4) DEFAULT '0',
  `TimeCreated` int(11) DEFAULT NULL,
  `TimeUpdated` int(11) DEFAULT NULL,
  `Cost` int(11) DEFAULT '1',
  `CostCredits` int(11) DEFAULT '0',
  `SaleActive` tinyint(4) DEFAULT '1',
  `PreviewImage` varchar(128) DEFAULT NULL,
  `ShadowImage` varchar(128) DEFAULT NULL,
  `ThumbnailImage` varchar(128) DEFAULT NULL,
  `BackendFile` varchar(128) DEFAULT NULL,
  `BackendFileBlink` varchar(128) DEFAULT NULL,
  `TextureOne` varchar(128) DEFAULT NULL,
  `TextureTwo` varchar(128) DEFAULT NULL,
  `TextureThree` varchar(128) DEFAULT NULL,
  `IsCollectible` tinyint(4) DEFAULT '0',
  `InitialStock` int(11) DEFAULT '0',
  `RemainingStock` int(11) DEFAULT '0',
  `NumberCopies` int(11) UNSIGNED DEFAULT '0',
  `NumberFavorites` int(11) UNSIGNED DEFAULT '0',
  `PublicView` tinyint(4) DEFAULT '1',
  `TimeOffSale` int(11) DEFAULT '0',
  `ImpressionCount` int(11) UNSIGNED DEFAULT '0',
  `ItemSellerCount` int(11) UNSIGNED DEFAULT '0',
  `TradeLock` tinyint(4) DEFAULT '0',
  `ItemZoom` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ItemComment`
--

CREATE TABLE `ItemComment` (
  `ID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Comment` longtext,
  `TimeOfPost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ItemCrateContent`
--

CREATE TABLE `ItemCrateContent` (
  `ID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `ContentRarity` int(11) DEFAULT NULL,
  `ContentType` int(11) DEFAULT NULL,
  `ContentID` int(11) DEFAULT NULL,
  `ContentValue` int(11) DEFAULT NULL,
  `ContentQuantity` int(11) DEFAULT NULL,
  `QuantityRemaining` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ItemCrateLog`
--

CREATE TABLE `ItemCrateLog` (
  `ID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Text` varchar(256) DEFAULT NULL,
  `TimeLog` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ItemFavorite`
--

CREATE TABLE `ItemFavorite` (
  `UserID` int(11) DEFAULT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `IP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ItemImpression`
--

CREATE TABLE `ItemImpression` (
  `ID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ItemSalesHistory`
--

CREATE TABLE `ItemSalesHistory` (
  `ID` int(11) NOT NULL,
  `BuyerID` int(11) DEFAULT NULL,
  `CreatorID` int(11) DEFAULT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `PaymentType` varchar(45) DEFAULT NULL,
  `InventoryID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ItemSeller`
--

CREATE TABLE `ItemSeller` (
  `ID` int(11) NOT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `InventoryID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `TimeCreated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ItemSellerHistory`
--

CREATE TABLE `ItemSellerHistory` (
  `ID` int(11) NOT NULL,
  `UTLID` int(11) DEFAULT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `SellerID` int(11) DEFAULT NULL,
  `BuyerID` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `TimeSale` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ModHistory`
--

CREATE TABLE `ModHistory` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AccountBanTime` int(11) DEFAULT NULL,
  `AccountBanLength` longtext,
  `AccountBanCategory` longtext,
  `AccountBanContent` longtext,
  `AccountBanNote` longtext,
  `AccountUnbanTime` int(11) DEFAULT NULL,
  `AccountBanAppealable` int(11) DEFAULT NULL,
  `AdministrativeNote` longtext,
  `BannedBy` longtext,
  `Status` int(11) DEFAULT '0' COMMENT '0 = default ban\n1 = appealed\n2 = escalated',
  `ChangedBy` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Notification`
--

CREATE TABLE `Notification` (
  `NotificationID` int(11) NOT NULL,
  `PosterID` int(11) DEFAULT NULL,
  `Message` longtext,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PersonnelLogs`
--

CREATE TABLE `PersonnelLogs` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Message` varchar(255) DEFAULT NULL,
  `LogTime` int(11) DEFAULT NULL,
  `IP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personnel_files`
--

CREATE TABLE `personnel_files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date_hired` int(11) DEFAULT NULL,
  `hiredby` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `zone` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `department_title` varchar(100) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `address_line1` varchar(45) DEFAULT NULL,
  `address_line2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `country_name` varchar(45) DEFAULT NULL,
  `teamspeak` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ProfanityFilter`
--

CREATE TABLE `ProfanityFilter` (
  `ID` int(11) NOT NULL,
  `Word` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ProfanityWhitelist`
--

CREATE TABLE `ProfanityWhitelist` (
  `ID` int(11) NOT NULL,
  `Word` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Reports`
--

CREATE TABLE `Reports` (
  `ID` int(11) NOT NULL,
  `ReporterID` int(11) DEFAULT NULL,
  `SourceID` int(11) DEFAULT NULL,
  `RelevanceID` int(11) DEFAULT NULL,
  `Category` int(11) DEFAULT NULL,
  `Comment` varchar(255) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SiteSetting`
--

CREATE TABLE `SiteSetting` (
  `ID` int(11) NOT NULL,
  `Maintenance` tinyint(4) DEFAULT '0',
  `Registration` tinyint(4) DEFAULT '1',
  `RegistrationTimer` int(11) DEFAULT '0',
  `Upgrades` tinyint(4) DEFAULT '1',
  `UpgradesTimer` int(11) DEFAULT '0',
  `CatalogPurchases` tinyint(4) DEFAULT '1',
  `StoreTimer` int(11) DEFAULT '0',
  `BannerAlertMessage` varchar(256) DEFAULT NULL,
  `BannerAlertTextColor` varchar(6) DEFAULT 'EEEEEE',
  `BannerAlertBackgroundColor` varchar(6) DEFAULT '383A3F',
  `BannerAlertFontSize` int(11) DEFAULT '16',
  `MaintenanceTimer` int(11) DEFAULT '0',
  `MaintenanceTimerVisible` int(11) DEFAULT '0',
  `AllowGroups` tinyint(4) DEFAULT '1',
  `AllowEditCharacter` tinyint(4) DEFAULT '1',
  `AllowTrades` tinyint(4) DEFAULT '1',
  `GameMaintenance` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SiteSettingAbout`
--

CREATE TABLE `SiteSettingAbout` (
  `TermsOfService` text NOT NULL,
  `PrivacyPolicy` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `StaticNotification`
--

CREATE TABLE `StaticNotification` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(256) DEFAULT NULL,
  `Message` varchar(256) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL,
  `Expires` int(11) DEFAULT NULL,
  `Read` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `updates` text NOT NULL,
  `updates2` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `ID` int(11) NOT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Email` varchar(128) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `AccountVerified` tinyint(4) DEFAULT '0',
  `undef1` tinyint(4) DEFAULT '0',
  `undef2` tinyint(4) DEFAULT '0',
  `undef3` varchar(50) DEFAULT NULL,
  `LastAccountVerifiedAttempt` int(11) DEFAULT '0',
  `Gender` tinyint(4) DEFAULT '0',
  `Avatar` tinyint(4) DEFAULT '0',
  `BirthdateMonth` int(11) DEFAULT NULL,
  `BirthdateDay` int(11) DEFAULT NULL,
  `BirthdateYear` int(11) DEFAULT NULL,
  `TimeRegister` int(11) DEFAULT NULL,
  `TimeLastSeen` int(11) DEFAULT NULL,
  `LastIP` varchar(60) DEFAULT NULL,
  `PublicKey` varchar(25) DEFAULT NULL,
  `AvatarURL` varchar(128) DEFAULT NULL,
  `ThumbnailURL` varchar(128) DEFAULT NULL,
  `Admin` tinyint(4) DEFAULT '0',
  `BetaTester` tinyint(4) DEFAULT '0',
  `About` varchar(1500) DEFAULT NULL,
  `CurrencyCoins` int(11) UNSIGNED DEFAULT '0',
  `CurrencyCredits` int(11) UNSIGNED DEFAULT '0',
  `UserFlood` int(11) DEFAULT '0',
  `NextFreeCoinPay` int(11) DEFAULT '0',
  `NextUpgradeCoinPay` int(11) DEFAULT '0',
  `NumMessages` int(11) UNSIGNED DEFAULT '0',
  `NumChats` int(11) UNSIGNED DEFAULT '0',
  `NumFriendRequests` int(11) UNSIGNED DEFAULT '0',
  `NumFriends` int(11) UNSIGNED DEFAULT '0',
  `NumTradeRequests` int(11) UNSIGNED DEFAULT '0',
  `NumNotifications` int(11) UNSIGNED DEFAULT '0',
  `NumForumPosts` int(11) UNSIGNED DEFAULT '0',
  `NumForumBookmarks` int(11) UNSIGNED DEFAULT '0',
  `NumForumDrafts` int(11) UNSIGNED DEFAULT '0',
  `NumEquippedHats` int(11) UNSIGNED DEFAULT '0',
  `NumWallPosts` int(11) UNSIGNED DEFAULT '0',
  `NumGroups` int(11) UNSIGNED DEFAULT '0',
  `ForumEXP` int(11) UNSIGNED DEFAULT '0',
  `ForumLevel` int(11) UNSIGNED DEFAULT '1',
  `HexHead` int(11) DEFAULT '3',
  `HexLeftArm` int(11) DEFAULT '3',
  `HexTorso` int(11) DEFAULT '2',
  `HexRightArm` int(11) DEFAULT '3',
  `HexLeftLeg` int(11) DEFAULT '3',
  `HexRightLeg` int(11) DEFAULT '3',
  `AccountRestricted` tinyint(4) DEFAULT '0',
  `PersonalStatus` varchar(128) DEFAULT NULL,
  `PrivateMessageSettings` tinyint(4) DEFAULT '0',
  `FriendRequestSettings` tinyint(4) DEFAULT '0',
  `TradeSettings` tinyint(4) DEFAULT '0',
  `PostWallSettings` tinyint(4) DEFAULT '0',
  `ViewWallSettings` tinyint(4) DEFAULT '0',
  `NotificationSettingsChats` tinyint(4) DEFAULT '1',
  `NotificationSettingsIncomingTrades` tinyint(4) DEFAULT '1',
  `NotificationSettingsSellItem` tinyint(4) DEFAULT '1',
  `NotificationSettingsBlog` tinyint(4) DEFAULT '1',
  `NotificationSettingsFriendRequests` tinyint(4) DEFAULT '1',
  `NotificationSettingsGroups` tinyint(4) DEFAULT '1',
  `NotificationSettingsWall` tinyint(4) DEFAULT '1',
  `CountryRestrict` tinyint(4) DEFAULT '1',
  `EmailNotifications` tinyint(4) DEFAULT '1',
  `Country` varchar(6) DEFAULT '0',
  `VIP` tinyint(4) DEFAULT '0',
  `VIP_Recurring` tinyint(4) DEFAULT '0',
  `VIP_Expires` int(11) DEFAULT '0',
  `TotalEarningsCount` int(11) DEFAULT '0',
  `TotalEarningsRank` int(11) DEFAULT '0',
  `SalesCount` int(11) DEFAULT '0',
  `EarningsCount` int(11) DEFAULT '0',
  `ItemCount` int(11) DEFAULT '0',
  `UpgradesCount` int(11) DEFAULT '0',
  `StripeKey` varchar(128) DEFAULT NULL,
  `NextEmailChange` int(11) DEFAULT '0',
  `AvatarOrientation` tinyint(4) DEFAULT '0' COMMENT '0 - Right\n1 - Left',
  `FavoriteGroup` int(11) DEFAULT '0',
  `DiscordId` varchar(20) DEFAULT '0',
  `ChatId` varchar(20) DEFAULT NULL,
  `InGame` tinyint(4) DEFAULT '0',
  `InGameId` int(11) DEFAULT NULL,
  `InGameTime` int(11) DEFAULT '0',
  `NumGameVisits` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserAccountLock`
--

CREATE TABLE `UserAccountLock` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT '0',
  `Reason` longtext,
  `AdminID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserActionLog`
--

CREATE TABLE `UserActionLog` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Action` text,
  `TimeLog` int(11) DEFAULT NULL,
  `IP` varchar(60) DEFAULT NULL,
  `ArchiveID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserAdminLogs`
--

CREATE TABLE `UserAdminLogs` (
  `ID` int(11) NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `Message` longtext,
  `LogTime` int(11) DEFAULT NULL,
  `IP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserBadge`
--

CREATE TABLE `UserBadge` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL DEFAULT '0',
  `AchievementID` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `UserBanHistory`
--

CREATE TABLE `UserBanHistory` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `TimeBan` int(11) DEFAULT NULL,
  `TimeUnban` int(11) DEFAULT NULL,
  `BanCategory` int(11) DEFAULT NULL,
  `Content` text,
  `ModNote` varchar(128) DEFAULT NULL,
  `AdminNote` varchar(128) DEFAULT NULL,
  `Status` int(11) DEFAULT '0' COMMENT '0 - Active\n1 - Reviewed By User\n2 - Overturned by Administrator',
  `UnbannedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserBlocked`
--

CREATE TABLE `UserBlocked` (
  `ID` int(11) NOT NULL,
  `RequesterID` int(11) DEFAULT NULL,
  `BlockedID` int(11) DEFAULT NULL,
  `TimeBlocked` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserChat`
--

CREATE TABLE `UserChat` (
  `ID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `TimeChat` int(11) DEFAULT NULL,
  `TimeRead` int(11) DEFAULT '0',
  `Message` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserChatGroup`
--

CREATE TABLE `UserChatGroup` (
  `ID` int(11) NOT NULL,
  `Name` varchar(40) DEFAULT NULL,
  `OwnerID` int(11) DEFAULT NULL,
  `MemberCount` tinyint(4) DEFAULT '0',
  `InviteCode` varchar(10) DEFAULT NULL,
  `GroupImage` varchar(128) DEFAULT NULL,
  `ImageStatus` varchar(128) DEFAULT '1',
  `TimeCreate` int(11) DEFAULT '0',
  `TimeNameUpdate` int(11) DEFAULT '0',
  `TimeImageUpdate` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserChatGroupMember`
--

CREATE TABLE `UserChatGroupMember` (
  `ID` int(11) NOT NULL,
  `ChatGroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Role` tinyint(4) DEFAULT '0' COMMENT '0 - User\n1 - Moderator\n2 - Owner',
  `UnreadMessageCount` int(11) DEFAULT '0',
  `TimeLastAction` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserChatGroupMessage`
--

CREATE TABLE `UserChatGroupMessage` (
  `ID` int(11) NOT NULL,
  `ChatGroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeChat` int(11) DEFAULT NULL,
  `Message` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserColor`
--

CREATE TABLE `UserColor` (
  `ID` int(11) NOT NULL,
  `HexColor` varchar(6) DEFAULT NULL,
  `R` varchar(5) DEFAULT NULL,
  `G` varchar(5) DEFAULT NULL,
  `B` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserDailyEarning`
--

CREATE TABLE `UserDailyEarning` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Coins` int(11) DEFAULT NULL,
  `TimeStart` int(11) DEFAULT NULL,
  `TimeEnd` int(11) DEFAULT NULL,
  `TransactionsCount` int(11) DEFAULT '0',
  `Status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserDiscordVerify`
--

CREATE TABLE `UserDiscordVerify` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Key` varchar(24) DEFAULT NULL,
  `TimeInitiated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserEmailChange`
--

CREATE TABLE `UserEmailChange` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `OldEmail` varchar(128) DEFAULT NULL,
  `NewEmail` varchar(128) DEFAULT NULL,
  `OldWasVerified` int(11) DEFAULT NULL,
  `ChangeKey` varchar(20) DEFAULT NULL,
  `TimeChange` int(11) DEFAULT NULL,
  `Changed` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserEmojiHistory`
--

CREATE TABLE `UserEmojiHistory` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `TimeLastUsed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserEquipped`
--

CREATE TABLE `UserEquipped` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ItemType` int(11) DEFAULT NULL,
  `InventoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroup`
--

CREATE TABLE `UserGroup` (
  `ID` int(11) NOT NULL,
  `GroupCategory` tinyint(4) DEFAULT '0',
  `Name` varchar(60) DEFAULT NULL,
  `SEOName` varchar(128) DEFAULT NULL,
  `Description` text,
  `OwnerID` int(11) DEFAULT NULL,
  `OwnerType` tinyint(4) DEFAULT '0',
  `TimeCreate` int(11) DEFAULT NULL,
  `LogoImage` varchar(128) DEFAULT NULL,
  `LogoStatus` tinyint(4) DEFAULT '0',
  `CoinsVault` int(11) DEFAULT '0',
  `VaultDisplay` int(11) DEFAULT '0',
  `JoinType` tinyint(4) DEFAULT '0',
  `NonMemberTab` int(11) DEFAULT '1',
  `MemberTab` int(11) DEFAULT '1',
  `MemberCount` int(11) DEFAULT '1',
  `WallCount` int(11) DEFAULT '0',
  `DivisionCount` int(11) DEFAULT '0',
  `StoreCount` int(11) DEFAULT '0',
  `JoinRequestCount` int(11) DEFAULT '0',
  `OutboundRequestCount` int(11) DEFAULT '0',
  `TotalEarningsCount` int(11) DEFAULT '0',
  `TotalEarningsRank` int(11) DEFAULT '0',
  `SalesCount` int(11) DEFAULT '0',
  `EarningsCount` int(11) DEFAULT '0',
  `IsVerified` tinyint(4) DEFAULT '0',
  `IsDisabled` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupAbandonRequest`
--

CREATE TABLE `UserGroupAbandonRequest` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `Code` varchar(128) DEFAULT NULL,
  `TimeExpire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupChangeOwnershipRequest`
--

CREATE TABLE `UserGroupChangeOwnershipRequest` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `NewOwnerType` int(11) DEFAULT '0',
  `NewGroupID` int(11) DEFAULT '0',
  `Code` varchar(128) DEFAULT NULL,
  `TimeExpire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupDailyEarning`
--

CREATE TABLE `UserGroupDailyEarning` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `Coins` int(11) DEFAULT NULL,
  `TimeStart` int(11) DEFAULT NULL,
  `TimeEnd` int(11) DEFAULT NULL,
  `TransactionsCount` int(11) DEFAULT '0',
  `Status` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupJoinRequest`
--

CREATE TABLE `UserGroupJoinRequest` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeRequest` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupMember`
--

CREATE TABLE `UserGroupMember` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Rank` tinyint(4) DEFAULT '1',
  `IsFavorite` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupOutboundRequest`
--

CREATE TABLE `UserGroupOutboundRequest` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeRequest` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupRank`
--

CREATE TABLE `UserGroupRank` (
  `GroupID` int(11) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Rank` tinyint(4) DEFAULT NULL,
  `MemberCount` int(11) DEFAULT '0',
  `PermissionViewWall` tinyint(4) DEFAULT '0',
  `PermissionPostWall` tinyint(4) DEFAULT '0',
  `PermissionModerateWall` tinyint(4) DEFAULT '0',
  `PermissionChangeRank` tinyint(4) DEFAULT '0',
  `PermissionKickUser` tinyint(4) DEFAULT '0',
  `PermissionInviteUser` tinyint(4) DEFAULT '0',
  `PermissionAcceptRequests` tinyint(4) DEFAULT '0',
  `PermissionAnnouncements` tinyint(4) DEFAULT '0',
  `PermissionEvents` tinyint(4) DEFAULT '0',
  `PermissionGroupFunds` tinyint(4) DEFAULT '0',
  `PermissionGroupStore` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserGroupWall`
--

CREATE TABLE `UserGroupWall` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Message` varchar(512) DEFAULT NULL,
  `TimePosted` int(11) DEFAULT NULL,
  `IsPinned` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserInventory`
--

CREATE TABLE `UserInventory` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ItemID` int(11) DEFAULT NULL,
  `TimeCreated` int(11) DEFAULT NULL,
  `CollectionNumber` int(11) DEFAULT '0',
  `CanTrade` tinyint(4) DEFAULT '1',
  `CrateOpened` int(11) DEFAULT '0',
  `CrateItemID` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserIP`
--

CREATE TABLE `UserIP` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IP` varchar(60) DEFAULT NULL,
  `TimeFirstUse` int(11) DEFAULT NULL,
  `TimeLastUse` int(11) DEFAULT NULL,
  `City` varchar(128) DEFAULT NULL,
  `Region` varchar(128) DEFAULT NULL,
  `Country` varchar(128) DEFAULT NULL,
  `PostalCode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserIPBan`
--

CREATE TABLE `UserIPBan` (
  `ID` int(11) NOT NULL,
  `IPAddress` varchar(60) DEFAULT NULL,
  `TimePlaced` int(11) DEFAULT NULL,
  `TimeExpires` int(11) DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `AdminReason` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserLoginLog`
--

CREATE TABLE `UserLoginLog` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IP` varchar(60) DEFAULT NULL,
  `TimeLog` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserLogs`
--

CREATE TABLE `UserLogs` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Message` longtext,
  `LogTime` int(11) DEFAULT NULL,
  `IP` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserMessage`
--

CREATE TABLE `UserMessage` (
  `ID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `Message` varchar(1000) DEFAULT NULL,
  `TimeSent` int(11) DEFAULT '0',
  `TimeRead` int(11) DEFAULT '0',
  `IsRead` int(11) DEFAULT '0',
  `Archived` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UsernameHistory`
--

CREATE TABLE `UsernameHistory` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Username` varchar(20) DEFAULT NULL,
  `Time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserNotification`
--

CREATE TABLE `UserNotification` (
  `ID` int(11) NOT NULL,
  `SenderID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `TimeNotification` int(11) DEFAULT '0',
  `TimeRead` int(11) DEFAULT '0',
  `NotificationType` int(11) DEFAULT '0',
  `RelevanceID` int(11) DEFAULT '0',
  `Message` varchar(512) DEFAULT NULL,
  `URL` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserNotificationMessage`
--

CREATE TABLE `UserNotificationMessage` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Title` varchar(512) DEFAULT NULL,
  `Message` text,
  `TimeMessage` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserPassResetRequest`
--

CREATE TABLE `UserPassResetRequest` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `IP` varchar(60) DEFAULT NULL,
  `Code` varchar(256) DEFAULT NULL,
  `TimeRequest` int(11) DEFAULT NULL,
  `TimeExpires` int(11) DEFAULT NULL,
  `Redeemed` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserPasswordChange`
--

CREATE TABLE `UserPasswordChange` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PreviousPassword` longtext NOT NULL,
  `NewPassword` longtext NOT NULL,
  `RevertCode` longtext NOT NULL,
  `Expire` longtext NOT NULL,
  `IP` longtext NOT NULL,
  `Reverted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `UserPaymentHistory`
--

CREATE TABLE `UserPaymentHistory` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PlanID` tinyint(4) DEFAULT NULL COMMENT '0-2=VIP',
  `PaymentType` tinyint(4) DEFAULT NULL COMMENT '0 - Credit Card\n1 - PayPal\n2 - Credits',
  `TimePayment` int(11) DEFAULT NULL,
  `PayerName` varchar(100) DEFAULT NULL,
  `PayerEmail` varchar(100) DEFAULT NULL,
  `PayerAddress` varchar(256) DEFAULT NULL,
  `PayerCity` varchar(100) DEFAULT NULL,
  `PayerState` varchar(100) DEFAULT NULL,
  `PayerCountry` varchar(100) DEFAULT NULL,
  `TransactionID` varchar(128) DEFAULT NULL,
  `SubscriptionID` varchar(128) DEFAULT NULL,
  `LastFour` int(11) DEFAULT NULL,
  `RedeemedRefund` tinyint(4) DEFAULT '0' COMMENT 'Expires 10/05/2017',
  `Status` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserProfileView`
--

CREATE TABLE `UserProfileView` (
  `UserID` int(11) DEFAULT NULL,
  `TargetID` int(11) DEFAULT NULL,
  `Recurring` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserSearchHistory`
--

CREATE TABLE `UserSearchHistory` (
  `UserID` int(11) NOT NULL,
  `ContentType` int(11) DEFAULT NULL,
  `ContentID` int(11) DEFAULT NULL,
  `TimeSearch` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserTrade`
--

CREATE TABLE `UserTrade` (
  `ID` int(11) NOT NULL,
  `RequesterID` int(11) DEFAULT NULL,
  `ReceiverID` int(11) DEFAULT NULL,
  `Status` int(11) DEFAULT '0',
  `Time` int(11) DEFAULT NULL,
  `Expires` int(11) DEFAULT NULL,
  `GivingOne` int(11) DEFAULT '0',
  `GivingTwo` int(11) DEFAULT '0',
  `GivingThree` int(11) DEFAULT '0',
  `GivingFour` int(11) DEFAULT '0',
  `GivingCredits` int(11) DEFAULT '0',
  `WantOne` int(11) DEFAULT '0',
  `WantTwo` int(11) DEFAULT '0',
  `WantThree` int(11) DEFAULT '0',
  `WantFour` int(11) DEFAULT '0',
  `WantCredits` int(11) DEFAULT '0',
  `UpdatedOn` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserTransactionLog`
--

CREATE TABLE `UserTransactionLog` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `EventID` int(11) DEFAULT NULL,
  `ReferenceID` int(11) DEFAULT NULL,
  `PreviousBalance` int(11) DEFAULT NULL,
  `NewBalance` int(11) DEFAULT NULL,
  `TimeTransaction` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserVerifyEmail`
--

CREATE TABLE `UserVerifyEmail` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TimeSent` int(11) DEFAULT NULL,
  `VerifyType` int(11) DEFAULT NULL,
  `VerifyCode` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `UserWall`
--

CREATE TABLE `UserWall` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PosterID` int(11) DEFAULT NULL,
  `Post` varchar(256) DEFAULT NULL,
  `TimePosted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Achievement`
--
ALTER TABLE `Achievement`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminCommendations`
--
ALTER TABLE `AdminCommendations`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminDiscipline`
--
ALTER TABLE `AdminDiscipline`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminEvents`
--
ALTER TABLE `AdminEvents`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminEventsAttending`
--
ALTER TABLE `AdminEventsAttending`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminFiles`
--
ALTER TABLE `AdminFiles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdministratorLogs`
--
ALTER TABLE `AdministratorLogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminReports`
--
ALTER TABLE `AdminReports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminShifts`
--
ALTER TABLE `AdminShifts`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminStatistics`
--
ALTER TABLE `AdminStatistics`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AdminTasks`
--
ALTER TABLE `AdminTasks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AssetChecksums`
--
ALTER TABLE `AssetChecksums`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AssetModerationLogs`
--
ALTER TABLE `AssetModerationLogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `AvatarUpdateQueue`
--
ALTER TABLE `AvatarUpdateQueue`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `AvatarUpdateQueue_UserID_Unique` (`UserID`),
  ADD KEY `AvatarUpdateQueue_UserID_FK_idx` (`UserID`);

--
-- Indexes for table `BanLogs`
--
ALTER TABLE `BanLogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `BlockedEmail`
--
ALTER TABLE `BlockedEmail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `BlockedEmail_Email_Index` (`Email`);

--
-- Indexes for table `BlockedUser`
--
ALTER TABLE `BlockedUser`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `BlockedUser_Unique` (`RequesterID`,`BlockedID`);

--
-- Indexes for table `BlockedUsername`
--
ALTER TABLE `BlockedUsername`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `BlockedUsername_Username_Index` (`Username`);

--
-- Indexes for table `DirectChat`
--
ALTER TABLE `DirectChat`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `EmailBlacklist`
--
ALTER TABLE `EmailBlacklist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `EmailQueue`
--
ALTER TABLE `EmailQueue`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `EmojiList`
--
ALTER TABLE `EmojiList`
  ADD PRIMARY KEY (`ID`);
ALTER TABLE `EmojiList` ADD FULLTEXT KEY `EmojiList_Description` (`Description`);

--
-- Indexes for table `FavoriteFriend`
--
ALTER TABLE `FavoriteFriend`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ForumAdminLog`
--
ALTER TABLE `ForumAdminLog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ForumBan`
--
ALTER TABLE `ForumBan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ForumCategory`
--
ALTER TABLE `ForumCategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ForumReply`
--
ALTER TABLE `ForumReply`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForumReply_TimePost_Index` (`TimePost`),
  ADD KEY `ForumReplyy_UserID_FK_idx` (`UserID`),
  ADD KEY `ForumReplyy_ThreadID_FK_idx` (`ThreadID`);
ALTER TABLE `ForumReply` ADD FULLTEXT KEY `ForumReply_Post_FT` (`Post`);

--
-- Indexes for table `ForumReplyLike`
--
ALTER TABLE `ForumReplyLike`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForumReplyLike_ReplyID_FK_idx` (`ReplyID`),
  ADD KEY `ForumReplyLike_UserID_FK_idx` (`UserID`);

--
-- Indexes for table `ForumThread`
--
ALTER TABLE `ForumThread`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForumThread_UserID_FK_idx` (`UserID`),
  ADD KEY `ForumThread_TopicID_FK_idx` (`TopicID`),
  ADD KEY `ForumThread_TimeUpdated_Index` (`TimeUpdated`),
  ADD KEY `ForumThread_Locked_Index` (`Locked`),
  ADD KEY `ForumThread_Pinned_Index` (`Pinned`),
  ADD KEY `ForumThread_Combined_Index` (`UserID`,`TopicID`);
ALTER TABLE `ForumThread` ADD FULLTEXT KEY `ForumThread_Title_FT` (`Title`);
ALTER TABLE `ForumThread` ADD FULLTEXT KEY `ForumThread_Post_FT` (`Post`);

--
-- Indexes for table `ForumThreadBookmark`
--
ALTER TABLE `ForumThreadBookmark`
  ADD KEY `ForumThreadBookmark_UserID_FK_idx` (`UserID`),
  ADD KEY `ForumThreadBookmark_ThreadID_FK_idx` (`ThreadID`);

--
-- Indexes for table `ForumThreadDraft`
--
ALTER TABLE `ForumThreadDraft`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForumThreadDraft_UserID_FK_idx` (`UserID`),
  ADD KEY `ForumThreadDraft_TopicID_FK_idx` (`TopicID`),
  ADD KEY `ForumThread_TimePost_Index` (`TimePost`);

--
-- Indexes for table `ForumThreadLike`
--
ALTER TABLE `ForumThreadLike`
  ADD KEY `ForumThread_ThreadID_FK_idx` (`ThreadID`),
  ADD KEY `ForumThreadLike_UserID_FK_idx` (`UserID`),
  ADD KEY `ForumThreadLike_TimeLike_Index` (`TimeLike`),
  ADD KEY `ForumThread_Active_Index` (`Active`);

--
-- Indexes for table `ForumThreadView`
--
ALTER TABLE `ForumThreadView`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForumThreadView_ThreadID_FK_idx` (`ThreadID`),
  ADD KEY `ForumThreadView_UserID_FK_idx` (`UserID`);

--
-- Indexes for table `ForumTopic`
--
ALTER TABLE `ForumTopic`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ForumTopic_CategoryID_FK_idx` (`CategoryID`),
  ADD KEY `ForumTopic_Sort_Index` (`Sort`);

--
-- Indexes for table `Friend`
--
ALTER TABLE `Friend`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Friend_SenderID_FK_idx` (`SenderID`),
  ADD KEY `Friend_ReceiverID_FK_idx` (`ReceiverID`),
  ADD KEY `Friend_TimeSent_Index` (`TimeSent`),
  ADD KEY `Friend_Accepted_Index` (`Accepted`);

--
-- Indexes for table `IPBan`
--
ALTER TABLE `IPBan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IPBan_AdminID_FK_idx` (`AdminID`),
  ADD KEY `IPBan_IP_Index` (`IP`),
  ADD KEY `IPBan_TimePlaced_Index` (`TimePlaced`),
  ADD KEY `IPBan_TimeExpire_Index` (`TimeExpire`);

--
-- Indexes for table `Item`
--
ALTER TABLE `Item`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Item_ItemType_Index` (`ItemType`),
  ADD KEY `Item_TimeUpdated_Index` (`TimeUpdated`),
  ADD KEY `Item_PublicView_Index` (`PublicView`),
  ADD KEY `Item_PreviewImage_Index` (`PreviewImage`),
  ADD KEY `Item_TimeCreated_Index` (`TimeCreated`);
ALTER TABLE `Item` ADD FULLTEXT KEY `Item_Name_FT` (`Name`);

--
-- Indexes for table `ItemComment`
--
ALTER TABLE `ItemComment`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ItemCrateContent`
--
ALTER TABLE `ItemCrateContent`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ItemCrateLog`
--
ALTER TABLE `ItemCrateLog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ItemImpression`
--
ALTER TABLE `ItemImpression`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ItemImpression_ItemID_FK_idx` (`ItemID`);

--
-- Indexes for table `ItemSalesHistory`
--
ALTER TABLE `ItemSalesHistory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ItemSalesHistory_ItemID_FK_idx` (`ItemID`),
  ADD KEY `ItemSalesHistory_Time_Index` (`Time`),
  ADD KEY `ItemSalesHistory_UserID_FK_idx` (`BuyerID`);

--
-- Indexes for table `ItemSeller`
--
ALTER TABLE `ItemSeller`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ItemSeller_Unique` (`ItemID`,`InventoryID`,`UserID`);

--
-- Indexes for table `ItemSellerHistory`
--
ALTER TABLE `ItemSellerHistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ModHistory`
--
ALTER TABLE `ModHistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Notification`
--
ALTER TABLE `Notification`
  ADD PRIMARY KEY (`NotificationID`);

--
-- Indexes for table `PersonnelLogs`
--
ALTER TABLE `PersonnelLogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `personnel_files`
--
ALTER TABLE `personnel_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ProfanityFilter`
--
ALTER TABLE `ProfanityFilter`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ProfanityWhitelist`
--
ALTER TABLE `ProfanityWhitelist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Reports`
--
ALTER TABLE `Reports`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SiteSetting`
--
ALTER TABLE `SiteSetting`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `StaticNotification`
--
ALTER TABLE `StaticNotification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Time` (`Time`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User_Admin_Index` (`Admin`),
  ADD KEY `User_BetaTester_Index` (`BetaTester`),
  ADD KEY `User_AccountRestricted` (`AccountRestricted`),
  ADD KEY `User_LastIP_Index` (`LastIP`),
  ADD KEY `User_Username_Index` (`Username`),
  ADD KEY `User_TimeRegister_Index` (`TimeRegister`),
  ADD KEY `User_DiscordId_Index` (`DiscordId`),
  ADD KEY `User_ChatId_Index` (`ChatId`),
  ADD KEY `User_TimeLastSeen_Index` (`TimeLastSeen`),
  ADD KEY `User_InGameId_FK_idx` (`InGameId`),
  ADD KEY `User_InGame_Index` (`InGame`),
  ADD KEY `User_AccountVerified_Index` (`AccountVerified`),
  ADD KEY `User_EmailAccountVerified_Index` (`Email`,`AccountVerified`),
  ADD KEY `User_VIP_Index` (`VIP`);
ALTER TABLE `User` ADD FULLTEXT KEY `User_Username_FullText` (`Username`);

--
-- Indexes for table `UserAccountLock`
--
ALTER TABLE `UserAccountLock`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserActionLog`
--
ALTER TABLE `UserActionLog`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserActionLog_UserID_FK_idx` (`UserID`);

--
-- Indexes for table `UserAdminLogs`
--
ALTER TABLE `UserAdminLogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserBadge`
--
ALTER TABLE `UserBadge`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserBadge_Unique` (`UserID`,`AchievementID`),
  ADD KEY `UserBadge_AchievementID_FK_idx` (`AchievementID`);

--
-- Indexes for table `UserBanHistory`
--
ALTER TABLE `UserBanHistory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserBanHistory_UserID_FK_idx` (`UserID`),
  ADD KEY `UserBanHistory_AdminID_FK_idx` (`AdminID`),
  ADD KEY `UserBanHistory_TimeBan_Index` (`TimeBan`),
  ADD KEY `UserBanHistory_TimeUnban_Index` (`TimeUnban`),
  ADD KEY `UserBanHistory_UnbannedBy_FK_idx` (`UnbannedBy`);

--
-- Indexes for table `UserBlocked`
--
ALTER TABLE `UserBlocked`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserChat`
--
ALTER TABLE `UserChat`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserChat_SenderID_FK_idx` (`SenderID`),
  ADD KEY `UserChat_ReceiverID_FK_idx` (`ReceiverID`),
  ADD KEY `UserChat_TimeChat_Index` (`TimeChat`),
  ADD KEY `UserChat_TimeRead_Index` (`TimeRead`),
  ADD KEY `UserChat_SenderReceiverID_Index` (`SenderID`,`ReceiverID`);

--
-- Indexes for table `UserChatGroup`
--
ALTER TABLE `UserChatGroup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserChatGroupMember`
--
ALTER TABLE `UserChatGroupMember`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserChatGroupMember_Unique` (`ChatGroupID`,`UserID`),
  ADD KEY `UserChatGroupMember_ChatGroupID_FK_idx` (`ChatGroupID`),
  ADD KEY `UserChatGroupMember_UserID_FK_idx` (`UserID`),
  ADD KEY `UserChatGroupMember_Role_Index` (`Role`);

--
-- Indexes for table `UserChatGroupMessage`
--
ALTER TABLE `UserChatGroupMessage`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserChatGroupMessage_TimeChat_Index` (`TimeChat`),
  ADD KEY `UserChatGroupMessage_ChatGroupID_FK_idx` (`ChatGroupID`),
  ADD KEY `UserChatGroupMessage_UserID_FK_idx` (`UserID`);

--
-- Indexes for table `UserColor`
--
ALTER TABLE `UserColor`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserDailyEarning`
--
ALTER TABLE `UserDailyEarning`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserDailyEarning_UserID_FK_idx` (`UserID`),
  ADD KEY `UserDailyEarning_TimeStart_Index` (`TimeStart`),
  ADD KEY `UserDailyEarning_TimeEnd_Index` (`TimeEnd`),
  ADD KEY `UserDailyEarning_Status_Index` (`Status`);

--
-- Indexes for table `UserDiscordVerify`
--
ALTER TABLE `UserDiscordVerify`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserDiscordVerify_UserID_FK_idx` (`UserID`),
  ADD KEY `UserDiscordVerify_Key_Index` (`Key`);

--
-- Indexes for table `UserEmailChange`
--
ALTER TABLE `UserEmailChange`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserEmojiHistory`
--
ALTER TABLE `UserEmojiHistory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserEquipped`
--
ALTER TABLE `UserEquipped`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserEquipped_UserID_FK_idx` (`UserID`),
  ADD KEY `UserEquipped_ItemType_Index` (`ItemType`),
  ADD KEY `UserEquipped_InventoryID_FK_idx` (`InventoryID`);

--
-- Indexes for table `UserGroup`
--
ALTER TABLE `UserGroup`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserGroup_Name_Unique` (`Name`),
  ADD KEY `UserGroup_GroupCategory_Index` (`GroupCategory`),
  ADD KEY `UserGroup_Name_Index` (`Name`),
  ADD KEY `UserGroup_LogoStatus_Index` (`LogoStatus`),
  ADD KEY `UserGroup_OwnerID_FK_idx` (`OwnerID`),
  ADD KEY `UserGroup_OwnerType_Index` (`OwnerType`),
  ADD KEY `UserGroup_MemberCount_Index` (`MemberCount`),
  ADD KEY `UserGroup_IsDisabled_Index` (`IsDisabled`);
ALTER TABLE `UserGroup` ADD FULLTEXT KEY `UserGroup_Description_FT` (`Description`);
ALTER TABLE `UserGroup` ADD FULLTEXT KEY `UserGroup_Name_FT` (`Name`);

--
-- Indexes for table `UserGroupAbandonRequest`
--
ALTER TABLE `UserGroupAbandonRequest`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserGroupAbandonRequest_Unique` (`GroupID`),
  ADD KEY `UserGroupAbandonRequest_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserGroupAbandonRequest_Code` (`Code`),
  ADD KEY `UserGroupAbandonRequest_TimeExpire` (`TimeExpire`);

--
-- Indexes for table `UserGroupChangeOwnershipRequest`
--
ALTER TABLE `UserGroupChangeOwnershipRequest`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserGroupChangeOwnershipRequest_Unique` (`GroupID`),
  ADD KEY `UserGroupChangeOwnershipRequest_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserGroupChangeOwnershipRequest_Code` (`Code`),
  ADD KEY `UserGroupChangeOwnershipRequest_TimeExpire` (`TimeExpire`);

--
-- Indexes for table `UserGroupDailyEarning`
--
ALTER TABLE `UserGroupDailyEarning`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserDailyEarning_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserDailyEarning_TimeStart_Index` (`TimeStart`),
  ADD KEY `UserDailyEarning_TimeEnd_Index` (`TimeEnd`),
  ADD KEY `UserDailyEarning_Status_Index` (`Status`);

--
-- Indexes for table `UserGroupJoinRequest`
--
ALTER TABLE `UserGroupJoinRequest`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserGroupJoinRequest_Unique` (`GroupID`,`UserID`),
  ADD KEY `UserGroupJoinRequest_GroupID_idx` (`GroupID`),
  ADD KEY `UserGroupJoinRequest_UserID_FK_idx` (`UserID`),
  ADD KEY `UserGroupJoinRequest_TimeRequest_Index` (`TimeRequest`);

--
-- Indexes for table `UserGroupMember`
--
ALTER TABLE `UserGroupMember`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserGroupMember_Unique` (`GroupID`,`UserID`),
  ADD KEY `UserGroupMember_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserGroupMember_UserID_FK_idx` (`UserID`),
  ADD KEY `UserGroupMember_Rank_Index` (`Rank`),
  ADD KEY `UserGroupMember_IsFavorite_Index` (`IsFavorite`);

--
-- Indexes for table `UserGroupOutboundRequest`
--
ALTER TABLE `UserGroupOutboundRequest`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UserGroupOutboundRequest_Unique` (`GroupID`,`UserID`),
  ADD KEY `UserGroupOutboundRequest_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserGroupOutboundRequest_UserID_FK_idx` (`UserID`),
  ADD KEY `UserGroupOutboundRequest_TimeRequest_Index` (`TimeRequest`);

--
-- Indexes for table `UserGroupRank`
--
ALTER TABLE `UserGroupRank`
  ADD KEY `UserGroupRank_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserGroupRank_Rank_Index` (`Rank`);

--
-- Indexes for table `UserGroupWall`
--
ALTER TABLE `UserGroupWall`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserGroupWall_GroupID_FK_idx` (`GroupID`),
  ADD KEY `UserGroupWall_UserID_FK_idx` (`UserID`),
  ADD KEY `UserGroupWall_IsPinned_Index` (`IsPinned`),
  ADD KEY `UserGroupWall_TimePosted_Index` (`TimePosted`);
ALTER TABLE `UserGroupWall` ADD FULLTEXT KEY `UserGroupWall_Message_FT` (`Message`);

--
-- Indexes for table `UserInventory`
--
ALTER TABLE `UserInventory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserInventory_UserID_FK_idx` (`UserID`),
  ADD KEY `UserInventory_ItemID_FK_idx` (`ItemID`);

--
-- Indexes for table `UserIP`
--
ALTER TABLE `UserIP`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserIP_UserID_FK_idx` (`UserID`),
  ADD KEY `UserIP_IP_Index` (`IP`);

--
-- Indexes for table `UserIPBan`
--
ALTER TABLE `UserIPBan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserIPBan_TimePlaced_Index` (`TimePlaced`),
  ADD KEY `UserIPBan_TimeExpires` (`TimeExpires`),
  ADD KEY `UserIPBan_AdminID_FK_idx` (`AdminID`);

--
-- Indexes for table `UserLoginLog`
--
ALTER TABLE `UserLoginLog`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserLoginLog_TimeLog_Index` (`TimeLog`),
  ADD KEY `UserLoginLog_IP_Index` (`IP`);

--
-- Indexes for table `UserLogs`
--
ALTER TABLE `UserLogs`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserMessage`
--
ALTER TABLE `UserMessage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UsernameHistory`
--
ALTER TABLE `UsernameHistory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UsernameHistory_UserID_FK_idx` (`UserID`),
  ADD KEY `UsernameHistory_Username_Index` (`Username`);
ALTER TABLE `UsernameHistory` ADD FULLTEXT KEY `UsernameHistory_Username_FT` (`Username`);

--
-- Indexes for table `UserNotification`
--
ALTER TABLE `UserNotification`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserNotification_ReceiverID_FK_idx` (`ReceiverID`),
  ADD KEY `UserNotification_SenderID_FK_idx` (`SenderID`),
  ADD KEY `UserNotification_TimeNotification_Index` (`TimeNotification`),
  ADD KEY `UserNotification_TimeRead_Index` (`TimeRead`),
  ADD KEY `UserNotification_NotificationType` (`NotificationType`),
  ADD KEY `UserNotification_RelevanceID` (`RelevanceID`),
  ADD KEY `UserNotification_NotificationTypeReceiverID_Index` (`ReceiverID`,`NotificationType`);

--
-- Indexes for table `UserNotificationMessage`
--
ALTER TABLE `UserNotificationMessage`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserNotificationMessage_UserID_FK_idx` (`UserID`),
  ADD KEY `UserNotificationMessage_TimeMessage_Index` (`TimeMessage`);

--
-- Indexes for table `UserPassResetRequest`
--
ALTER TABLE `UserPassResetRequest`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserPasswordChange`
--
ALTER TABLE `UserPasswordChange`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserPaymentHistory`
--
ALTER TABLE `UserPaymentHistory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserPaymentHistory_UserID_FK_idx` (`UserID`),
  ADD KEY `UserPaymentHistory_TimePayment_Index` (`TimePayment`);

--
-- Indexes for table `UserProfileView`
--
ALTER TABLE `UserProfileView`
  ADD KEY `UserProfileView_UserID_FK_idx` (`UserID`),
  ADD KEY `UserProfileView_TargetID_FK_idx` (`TargetID`);

--
-- Indexes for table `UserSearchHistory`
--
ALTER TABLE `UserSearchHistory`
  ADD UNIQUE KEY `UserSearchHistory_Uniques` (`UserID`,`ContentType`,`ContentID`),
  ADD KEY `UserSearchHistory_TimeSearch_Index` (`TimeSearch`),
  ADD KEY `UserSearchHistory_UserID_FK_idx` (`UserID`);

--
-- Indexes for table `UserTrade`
--
ALTER TABLE `UserTrade`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserTrade_RequesterID_FK_idx` (`RequesterID`),
  ADD KEY `UserTrade_ReceiverID_FK_idx` (`ReceiverID`),
  ADD KEY `UserTrade_Expires_Index` (`Expires`);

--
-- Indexes for table `UserTransactionLog`
--
ALTER TABLE `UserTransactionLog`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserTransactionLog_UserID_FK_idx` (`UserID`),
  ADD KEY `UserTransactionLog_TimeTransaction_Index` (`TimeTransaction`),
  ADD KEY `UserTransactionLog_EventID_Index` (`EventID`),
  ADD KEY `UserTransactionLog_ReferenceID_Index` (`ReferenceID`);

--
-- Indexes for table `UserVerifyEmail`
--
ALTER TABLE `UserVerifyEmail`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `UserWall`
--
ALTER TABLE `UserWall`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserWall_UserID_FK_idx` (`UserID`),
  ADD KEY `UserWall_PosterID_FK_idx` (`PosterID`),
  ADD KEY `UserWall_TimePosted_Index` (`TimePosted`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Achievement`
--
ALTER TABLE `Achievement`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminCommendations`
--
ALTER TABLE `AdminCommendations`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminDiscipline`
--
ALTER TABLE `AdminDiscipline`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminEvents`
--
ALTER TABLE `AdminEvents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminEventsAttending`
--
ALTER TABLE `AdminEventsAttending`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminFiles`
--
ALTER TABLE `AdminFiles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdministratorLogs`
--
ALTER TABLE `AdministratorLogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminReports`
--
ALTER TABLE `AdminReports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminShifts`
--
ALTER TABLE `AdminShifts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminStatistics`
--
ALTER TABLE `AdminStatistics`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AdminTasks`
--
ALTER TABLE `AdminTasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AssetChecksums`
--
ALTER TABLE `AssetChecksums`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AssetModerationLogs`
--
ALTER TABLE `AssetModerationLogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `AvatarUpdateQueue`
--
ALTER TABLE `AvatarUpdateQueue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BanLogs`
--
ALTER TABLE `BanLogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BlockedEmail`
--
ALTER TABLE `BlockedEmail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BlockedUser`
--
ALTER TABLE `BlockedUser`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `BlockedUsername`
--
ALTER TABLE `BlockedUsername`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `DirectChat`
--
ALTER TABLE `DirectChat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `EmailBlacklist`
--
ALTER TABLE `EmailBlacklist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `EmailQueue`
--
ALTER TABLE `EmailQueue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `EmojiList`
--
ALTER TABLE `EmojiList`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `FavoriteFriend`
--
ALTER TABLE `FavoriteFriend`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumAdminLog`
--
ALTER TABLE `ForumAdminLog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumCategory`
--
ALTER TABLE `ForumCategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumReply`
--
ALTER TABLE `ForumReply`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumReplyLike`
--
ALTER TABLE `ForumReplyLike`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumThread`
--
ALTER TABLE `ForumThread`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumThreadDraft`
--
ALTER TABLE `ForumThreadDraft`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumThreadView`
--
ALTER TABLE `ForumThreadView`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ForumTopic`
--
ALTER TABLE `ForumTopic`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Friend`
--
ALTER TABLE `Friend`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `IPBan`
--
ALTER TABLE `IPBan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Item`
--
ALTER TABLE `Item`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemComment`
--
ALTER TABLE `ItemComment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemCrateContent`
--
ALTER TABLE `ItemCrateContent`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemCrateLog`
--
ALTER TABLE `ItemCrateLog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemImpression`
--
ALTER TABLE `ItemImpression`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemSalesHistory`
--
ALTER TABLE `ItemSalesHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemSeller`
--
ALTER TABLE `ItemSeller`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ItemSellerHistory`
--
ALTER TABLE `ItemSellerHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ModHistory`
--
ALTER TABLE `ModHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Notification`
--
ALTER TABLE `Notification`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PersonnelLogs`
--
ALTER TABLE `PersonnelLogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personnel_files`
--
ALTER TABLE `personnel_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProfanityFilter`
--
ALTER TABLE `ProfanityFilter`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProfanityWhitelist`
--
ALTER TABLE `ProfanityWhitelist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Reports`
--
ALTER TABLE `Reports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SiteSetting`
--
ALTER TABLE `SiteSetting`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `StaticNotification`
--
ALTER TABLE `StaticNotification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserAccountLock`
--
ALTER TABLE `UserAccountLock`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserActionLog`
--
ALTER TABLE `UserActionLog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserAdminLogs`
--
ALTER TABLE `UserAdminLogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserBadge`
--
ALTER TABLE `UserBadge`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserBanHistory`
--
ALTER TABLE `UserBanHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserBlocked`
--
ALTER TABLE `UserBlocked`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserChat`
--
ALTER TABLE `UserChat`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserChatGroup`
--
ALTER TABLE `UserChatGroup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserChatGroupMember`
--
ALTER TABLE `UserChatGroupMember`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserChatGroupMessage`
--
ALTER TABLE `UserChatGroupMessage`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserColor`
--
ALTER TABLE `UserColor`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserDailyEarning`
--
ALTER TABLE `UserDailyEarning`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserDiscordVerify`
--
ALTER TABLE `UserDiscordVerify`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserEmailChange`
--
ALTER TABLE `UserEmailChange`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserEmojiHistory`
--
ALTER TABLE `UserEmojiHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserEquipped`
--
ALTER TABLE `UserEquipped`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroup`
--
ALTER TABLE `UserGroup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupAbandonRequest`
--
ALTER TABLE `UserGroupAbandonRequest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupChangeOwnershipRequest`
--
ALTER TABLE `UserGroupChangeOwnershipRequest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupDailyEarning`
--
ALTER TABLE `UserGroupDailyEarning`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupJoinRequest`
--
ALTER TABLE `UserGroupJoinRequest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupMember`
--
ALTER TABLE `UserGroupMember`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupOutboundRequest`
--
ALTER TABLE `UserGroupOutboundRequest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserGroupWall`
--
ALTER TABLE `UserGroupWall`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserInventory`
--
ALTER TABLE `UserInventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserIP`
--
ALTER TABLE `UserIP`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserIPBan`
--
ALTER TABLE `UserIPBan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserLoginLog`
--
ALTER TABLE `UserLoginLog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserLogs`
--
ALTER TABLE `UserLogs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserMessage`
--
ALTER TABLE `UserMessage`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UsernameHistory`
--
ALTER TABLE `UsernameHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserNotification`
--
ALTER TABLE `UserNotification`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserNotificationMessage`
--
ALTER TABLE `UserNotificationMessage`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserPassResetRequest`
--
ALTER TABLE `UserPassResetRequest`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserPasswordChange`
--
ALTER TABLE `UserPasswordChange`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserPaymentHistory`
--
ALTER TABLE `UserPaymentHistory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserTrade`
--
ALTER TABLE `UserTrade`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserTransactionLog`
--
ALTER TABLE `UserTransactionLog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserVerifyEmail`
--
ALTER TABLE `UserVerifyEmail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UserWall`
--
ALTER TABLE `UserWall`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `AvatarUpdateQueue`
--
ALTER TABLE `AvatarUpdateQueue`
  ADD CONSTRAINT `AvatarUpdateQueue_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumReply`
--
ALTER TABLE `ForumReply`
  ADD CONSTRAINT `ForumReplyy_ThreadID_FK` FOREIGN KEY (`ThreadID`) REFERENCES `ForumThread` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumReplyy_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumReplyLike`
--
ALTER TABLE `ForumReplyLike`
  ADD CONSTRAINT `ForumReplyLike_ReplyID_FK` FOREIGN KEY (`ReplyID`) REFERENCES `ForumReply` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumReplyLike_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumThread`
--
ALTER TABLE `ForumThread`
  ADD CONSTRAINT `ForumThread_TopicID_FK` FOREIGN KEY (`TopicID`) REFERENCES `ForumTopic` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumThread_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumThreadBookmark`
--
ALTER TABLE `ForumThreadBookmark`
  ADD CONSTRAINT `ForumThreadBookmark_ThreadID_FK` FOREIGN KEY (`ThreadID`) REFERENCES `ForumThread` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumThreadBookmark_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumThreadDraft`
--
ALTER TABLE `ForumThreadDraft`
  ADD CONSTRAINT `ForumThreadDraft_TopicID_FK` FOREIGN KEY (`TopicID`) REFERENCES `ForumTopic` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumThreadDraft_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumThreadLike`
--
ALTER TABLE `ForumThreadLike`
  ADD CONSTRAINT `ForumThreadLike_ThreadID_FK` FOREIGN KEY (`ThreadID`) REFERENCES `ForumThread` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumThreadLike_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumThreadView`
--
ALTER TABLE `ForumThreadView`
  ADD CONSTRAINT `ForumThreadView_ThreadID_FK` FOREIGN KEY (`ThreadID`) REFERENCES `ForumThread` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ForumThreadView_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ForumTopic`
--
ALTER TABLE `ForumTopic`
  ADD CONSTRAINT `ForumTopic_CategoryID_FK` FOREIGN KEY (`CategoryID`) REFERENCES `ForumCategory` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `Friend`
--
ALTER TABLE `Friend`
  ADD CONSTRAINT `Friend_ReceiverID_FK` FOREIGN KEY (`ReceiverID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Friend_SenderID_FK` FOREIGN KEY (`SenderID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `IPBan`
--
ALTER TABLE `IPBan`
  ADD CONSTRAINT `IPBan_AdminID_FK` FOREIGN KEY (`AdminID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ItemImpression`
--
ALTER TABLE `ItemImpression`
  ADD CONSTRAINT `ItemImpression_ItemID_FK` FOREIGN KEY (`ItemID`) REFERENCES `Item` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ItemSalesHistory`
--
ALTER TABLE `ItemSalesHistory`
  ADD CONSTRAINT `ItemSalesHistory_BuyerID_FK` FOREIGN KEY (`BuyerID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ItemSalesHistory_ItemID_FK` FOREIGN KEY (`ItemID`) REFERENCES `Item` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserBadge`
--
ALTER TABLE `UserBadge`
  ADD CONSTRAINT `UserBadge_AchievementID_FK` FOREIGN KEY (`AchievementID`) REFERENCES `Achievement` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserBadge_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserBanHistory`
--
ALTER TABLE `UserBanHistory`
  ADD CONSTRAINT `UserBanHistory_AdminID_FK` FOREIGN KEY (`AdminID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserBanHistory_UnbannedBy_FK` FOREIGN KEY (`UnbannedBy`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserBanHistory_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserChat`
--
ALTER TABLE `UserChat`
  ADD CONSTRAINT `UserChat_ReceiverID_FK` FOREIGN KEY (`ReceiverID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserChat_SenderID_FK` FOREIGN KEY (`SenderID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserChatGroupMember`
--
ALTER TABLE `UserChatGroupMember`
  ADD CONSTRAINT `UserChatGroupMember_ChatGroupID_FK` FOREIGN KEY (`ChatGroupID`) REFERENCES `UserChatGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserChatGroupMember_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserChatGroupMessage`
--
ALTER TABLE `UserChatGroupMessage`
  ADD CONSTRAINT `UserChatGroupMessage_ChatGroupID_FK` FOREIGN KEY (`ChatGroupID`) REFERENCES `UserChatGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserChatGroupMessage_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserDailyEarning`
--
ALTER TABLE `UserDailyEarning`
  ADD CONSTRAINT `UserDailyEarning_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserDiscordVerify`
--
ALTER TABLE `UserDiscordVerify`
  ADD CONSTRAINT `UserDiscordVerify_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserEquipped`
--
ALTER TABLE `UserEquipped`
  ADD CONSTRAINT `UserEquipped_InventoryID_FK` FOREIGN KEY (`InventoryID`) REFERENCES `UserInventory` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserEquipped_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroup`
--
ALTER TABLE `UserGroup`
  ADD CONSTRAINT `UserGroup_OwnerID_FK` FOREIGN KEY (`OwnerID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupAbandonRequest`
--
ALTER TABLE `UserGroupAbandonRequest`
  ADD CONSTRAINT `UserGroupAbandonRequest_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupChangeOwnershipRequest`
--
ALTER TABLE `UserGroupChangeOwnershipRequest`
  ADD CONSTRAINT `UserGroupChangeOwnershipRequest_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupDailyEarning`
--
ALTER TABLE `UserGroupDailyEarning`
  ADD CONSTRAINT `UserDailyEarning_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupJoinRequest`
--
ALTER TABLE `UserGroupJoinRequest`
  ADD CONSTRAINT `UserGroupJoinRequest_GroupID` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserGroupJoinRequest_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupMember`
--
ALTER TABLE `UserGroupMember`
  ADD CONSTRAINT `UserGroupMember_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserGroupMember_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupOutboundRequest`
--
ALTER TABLE `UserGroupOutboundRequest`
  ADD CONSTRAINT `UserGroupOutboundRequest_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserGroupOutboundRequest_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupRank`
--
ALTER TABLE `UserGroupRank`
  ADD CONSTRAINT `UserGroupRank_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserGroupWall`
--
ALTER TABLE `UserGroupWall`
  ADD CONSTRAINT `UserGroupWall_GroupID_FK` FOREIGN KEY (`GroupID`) REFERENCES `UserGroup` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserGroupWall_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserInventory`
--
ALTER TABLE `UserInventory`
  ADD CONSTRAINT `UserInventory_ItemID_FK` FOREIGN KEY (`ItemID`) REFERENCES `Item` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserInventory_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserIPBan`
--
ALTER TABLE `UserIPBan`
  ADD CONSTRAINT `UserIPBan_AdminID_FK` FOREIGN KEY (`AdminID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UsernameHistory`
--
ALTER TABLE `UsernameHistory`
  ADD CONSTRAINT `UsernameHistory_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserNotification`
--
ALTER TABLE `UserNotification`
  ADD CONSTRAINT `UserNotification_ReceiverID_FK` FOREIGN KEY (`ReceiverID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserNotification_SenderID_FK` FOREIGN KEY (`SenderID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserNotificationMessage`
--
ALTER TABLE `UserNotificationMessage`
  ADD CONSTRAINT `UserNotificationMessage_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserPaymentHistory`
--
ALTER TABLE `UserPaymentHistory`
  ADD CONSTRAINT `UserPaymentHistory_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserProfileView`
--
ALTER TABLE `UserProfileView`
  ADD CONSTRAINT `UserProfileView_TargetID_FK` FOREIGN KEY (`TargetID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserProfileView_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserSearchHistory`
--
ALTER TABLE `UserSearchHistory`
  ADD CONSTRAINT `UserSearchHistory_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserTrade`
--
ALTER TABLE `UserTrade`
  ADD CONSTRAINT `UserTrade_ReceiverID_FK` FOREIGN KEY (`ReceiverID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserTrade_RequesterID_FK` FOREIGN KEY (`RequesterID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserTransactionLog`
--
ALTER TABLE `UserTransactionLog`
  ADD CONSTRAINT `UserTransactionLog_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `UserWall`
--
ALTER TABLE `UserWall`
  ADD CONSTRAINT `UserWall_PosterID_FK` FOREIGN KEY (`PosterID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `UserWall_UserID_FK` FOREIGN KEY (`UserID`) REFERENCES `User` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
