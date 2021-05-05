<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('status' => 'error', 'You must login before accessing this content.'));
		
	} else {
		
		$GetRecentNotifications = $db->prepare("SELECT 2 AS Type, UserNotificationMessage.ID, UserNotificationMessage.Title, UserNotificationMessage.Message, User.Username, User.TimeLastSeen, User.AvatarURL, UserNotificationMessage.TimeMessage, (SELECT COUNT(*) FROM UserNotification AS UN WHERE (UN.SenderID = User.ID AND UN.ReceiverID = ".$myU->ID.") AND UN.TimeRead = 0) AS UnreadMessageCount FROM UserNotificationMessage JOIN UserNotification ON UserNotification.RelevanceID = UserNotificationMessage.ID JOIN User ON User.ID = UserNotificationMessage.UserID WHERE UserNotification.NotificationType = 4 AND UserNotification.ReceiverID = ".$myU->ID."");
		$GetRecentNotifications->execute();
		$Results = array();
		
		while ($gN = $GetRecentNotifications->fetch(PDO::FETCH_OBJ)) {
			
			$UserOnlineColor = ($gN->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
			$UnreadCount = ($gN->UnreadMessageCount < 99) ? $gN->UnreadMessageCount : '99+';
			
			$Row = array('type' => (int)$gN->Type, 'notificationId' => (int)$gN->ID, 'name' => $gN->Username, 'avatar' => $cdnName . $gN->AvatarURL . '-thumb.png', 'timelastseen' => $UserOnlineColor, 'timechat' => get_timeago($gN->TimeMessage), 'message' => LimitTextByCharacters('<strong>'.$gN->Title.'</strong> '.$gN->Message, 128), 'unread' => (int)$UnreadCount);
			array_push($Results, $Row);
			
		}
		
		echo json_encode($Results);
		
	}