<?php
require_once('/var/www/html/root/private/db.php');

	$ThreadId = $argv[1];
	$ReplyId = $argv[2];
	$CreatorId = $argv[3];
	if (!$ThreadId || !$ReplyId || !$CreatorId) die;
	
	$InsertUserNotification = $db->prepare("INSERT INTO UserNotification (SenderID, ReceiverID, TimeNotification, NotificationType, RelevanceID) SELECT ".$CreatorId.", ForumThreadBookmark.UserID, UNIX_TIMESTAMP(), 2, ".$ReplyId." FROM ForumThreadBookmark WHERE ThreadID = " . $ThreadId);
	$InsertUserNotification->execute();