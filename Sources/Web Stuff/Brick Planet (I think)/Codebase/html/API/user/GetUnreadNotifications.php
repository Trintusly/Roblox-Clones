<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('status' => 'error', 'message' => 'You must login before accessing this content.'));
		
	} else {
		
		$Rows = array();
		
		$GetCachedNotifications = $cache->get($myU->ID.'_GetUnreadNotifications');
		
		if (!$GetCachedNotifications) {
		
			$GetUserNotifications = $db->prepare("SELECT UserNotification.ID, User.Username, User.AvatarURL, User.TimeLastSeen, UserNotification.TimeNotification, UserNotification.TimeRead, UserNotification.NotificationType, UserNotification.Message, UserNotification.URL, UserChat.Message AS ChatMessage, Item.ID AS ItemID, Item.Name, UserNotificationMessage.Message AS NotificationMessage, ForumReply.ID AS ReplyID, ForumReply.ThreadID, ForumThread.Title AS ThreadTitle, ForumThread.Title AS ThreadTitle FROM UserNotification LEFT JOIN User ON User.ID = UserNotification.SenderID LEFT JOIN UserChat ON UserChat.ID = UserNotification.RelevanceID LEFT JOIN Item ON Item.ID = UserNotification.RelevanceID LEFT JOIN UserNotificationMessage ON UserNotificationMessage.ID = UserNotification.RelevanceID LEFT JOIN ForumReply ON ForumReply.ID = UserNotification.RelevanceID LEFT JOIN ForumThread ON ForumThread.ID = ForumReply.ThreadID WHERE UserNotification.ReceiverID = ".$myU->ID." AND UserNotification.TimeRead = 0 ORDER BY UserNotification.TimeNotification DESC LIMIT 5");
			$GetUserNotifications->execute();
			$cache->set($myU->ID.'_GetUnreadNotifications', $GetUserNotifications->fetchAll(PDO::FETCH_OBJ), 30);
			$GetCachedNotifications = $cache->get($myU->ID.'_GetUnreadNotifications');
		
		}
		
		foreach ($GetCachedNotifications as $gN) {
			
			$Username = $gN->Username;
			$AvatarURL = $gN->AvatarURL;
			$TimeLastSeen = null;
			$TimeRead = ($gN->TimeRead > 0) ? get_timeago((int)$gN->TimeRead) : 0;
			
			switch ($gN->NotificationType) {
				case 0:
					$Message = 'Sent a chat: "'.$gN->ChatMessage.'"';
					$URL = $serverName . '/inbox/user/' . $gN->Username;
					$TimeLastSeen = ($gN->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
					break;
				case 1:
					$Message = 'Incoming trade request from <strong>'.$gN->Username.'</strong>';
					$URL = $serverName . '/trade/view/' . $gN->RelevanceID . '/';
					$TimeLastSeen = ($gN->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
					break;
				case 2:
					$Message = 'New reply posted on thread <strong>'.$gN->ThreadTitle.'</strong>';
					$URL = $serverName . '/forum/thread/'.$gN->ThreadID.'/#'.$gN->ReplyID.'';
					$TimeLastSeen = ($gN->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
					break;
				case 3:
					$Message = 'You sold <strong>'.$gN->Name.'</strong> for ' . $gN->Message . ' Bits';
					$URL = $serverName . '/store/view/' . $gN->ItemID . '/';
					$TimeLastSeen = ($gN->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
					break;
				case 4:
					$Message = $gN->NotificationMessage;
					$URL = $serverName . '/inbox/user/' . $gN->Username;
					break;
			}
			
			$Row = array('notificationId' => (int)$gN->ID, 'senderUsername' => $Username, 'senderAvatar' => $cdnName . $AvatarURL . '-thumb.png', 'senderTimeLastSeen' => $TimeLastSeen, 'notificationMessage' => LimitTextByCharacters($Message, 64), 'notificationUrl' => $URL, 'notificationTime' => get_timeago($gN->TimeNotification), 'notificationTimeRead' => $TimeRead);
			array_push($Rows, $Row);
			
		}
		
		echo json_encode(array('status' => 'ok', 'unreadNotificationsCount' => shortNum((int)$myU->NumNotifications), 'content' => $Rows));
		
	}