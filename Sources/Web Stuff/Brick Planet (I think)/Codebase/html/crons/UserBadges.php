<?php
	require_once('/var/www/html/root/private/db.php');
	
	// Respect The Veteran (account >1 year)
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '2' FROM User WHERE User.TimeRegister <= ".(time() - 31536000)." AND User.ID NOT IN(SELECT UserID FROM UserBadge WHERE AchievementID = 2)");
	$Insert->execute();
	
	// Collectible Hoard (items >10 collectible)
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT UserInventory.UserID, '5' FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE Item.IsCollectible = 1 AND UserInventory.UserID NOT IN(SELECT UserID FROM UserBadge WHERE AchievementID = 5) GROUP BY UserID HAVING COUNT(*) >=10");
	$Insert->execute();
	
	// Pile 'O Gold (coins >5000)
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '6' FROM User WHERE User.CurrencyCoins >= 5000 AND User.ID NOT IN(SELECT UserID FROM UserBadge WHERE AchievementID = 6)");
	$Insert->execute();
	
	// Packin' Up The House (items >100)
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '7' FROM User WHERE User.ID IN(SELECT UserInventory.UserID FROM UserInventory GROUP BY UserID HAVING COUNT(*) >= 100) AND User.ID NOT IN(SELECT UserID FROM UserBadge WHERE AchievementID = 7)");
	$Insert->execute();
	
	// Forum Enthusiast (>7 forum level)
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '8' FROM User WHERE User.ForumLevel >= 7 AND User.ID NOT IN(SELECT UserID FROM UserBadge WHERE AchievementID = 8)");
	$Insert->execute();
	
	// Elite Order (3 membership badges)
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '12' FROM User WHERE User.ID IN(SELECT UserID FROM UserPaymentHistory WHERE PlanID IN(1,2,3) GROUP BY UserID HAVING COUNT(*) >= 3) AND User.ID NOT IN(SELECT UserID FROM UserBadge WHERE AchievementID = 12)");
	$Insert->execute();
	
	// 250+ Game Visits
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '18' FROM User WHERE User.NumGameVisits >= 250 AND User.ID NOT IN (SELECT UserID FROM UserBadge WHERE AchievementID = 18)");
	$Insert->execute();
	
	// 1,000+ Game Visits
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '19' FROM User WHERE User.NumGameVisits >= 1000 AND User.ID NOT IN (SELECT UserID FROM UserBadge WHERE AchievementID = 19)");
	$Insert->execute();
	
	// 100,000+ Game Visits
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '20' FROM User WHERE User.NumGameVisits >= 100000 AND User.ID NOT IN (SELECT UserID FROM UserBadge WHERE AchievementID = 20)");
	$Insert->execute();
	
	// 500,000+ Game Visits
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '21' FROM User WHERE User.NumGameVisits >= 500000 AND User.ID NOT IN (SELECT UserID FROM UserBadge WHERE AchievementID = 21)");
	$Insert->execute();
	
	// 1,000,000+ Game Visits
	$Insert = $db->prepare("INSERT INTO UserBadge (UserID, AchievementID) SELECT User.ID, '22' FROM User WHERE User.NumGameVisits >= 1000000 AND User.ID NOT IN (SELECT UserID FROM UserBadge WHERE AchievementID = 22)");
	$Insert->execute();