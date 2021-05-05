<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('error' => 'You must login before accessing this content.'));
		
	} else {
		
		$Results = array();
		
		$CountUserChats = $db->prepare('
		SELECT 
			COUNT(*)
		FROM
			UserChat
				JOIN
			User ON User.ID = (CASE
				WHEN UserChat.SenderID = '.$myU->ID.' THEN UserChat.ReceiverID
				ELSE UserChat.SenderID
			END)
		WHERE
			UserChat.ID IN (SELECT 
					UserChatt.ID
				FROM
					UserChat AS UserChatt
				WHERE
					UserChatt.SenderID = '.$myU->ID.'
						OR UserChatt.ReceiverID = '.$myU->ID.'  ORDER BY UserChatt.TimeChat DESC) 
		UNION SELECT 
			1 AS Type,
			UserChatGroup.ID,
			UserChatGroup.Name,
			User.Username,
			UserChatGroup.GroupImage AS Image,
			UserChatGroup.ImageStatus AS TimeLastSeen,
			UserChatGroupMessage.TimeChat,
			UserChatGroupMessage.Message,
			UserChatGroupMember.UnreadMessageCount
		FROM
			UserChatGroupMessage
				JOIN
			UserChatGroupMember ON UserChatGroupMember.UserID = '.$myU->ID.'
				JOIN
			UserChatGroup ON UserChatGroupMember.ChatGroupID = UserChatGroup.ID
				JOIN
			User ON UserChatGroupMessage.UserID = User.ID
		WHERE
			UserChatGroupMessage.ID = (SELECT 
					UserChatGroupMessagee.ID
				FROM
					UserChatGroupMessage AS UserChatGroupMessagee
				WHERE
					UserChatGroupMessagee.ChatGroupID = UserChatGroup.ID ORDER BY UserChatGroupMessagee.TimeChat DESC LIMIT 1) 
		UNION SELECT 
			2 AS Type,
			UserNotificationMessage.ID,
			User.Username AS Name,
			NULL AS Username,
			User.AvatarURL AS Image,
			User.TimeLastSeen,
			UserNotificationMessage.TimeMessage AS TimeChat,
			UserNotificationMessage.Message,
			(SELECT 
					COUNT(*)
				FROM
					UserNotification AS UN
				WHERE
					(UN.SenderID = User.ID
						AND UN.ReceiverID = '.$myU->ID.')
						AND UN.TimeRead = 0) AS UnreadMessageCount
		FROM
			UserNotificationMessage
				JOIN
			UserNotification ON UserNotification.RelevanceID = UserNotificationMessage.ID
				JOIN
			User ON User.ID = UserNotificationMessage.UserID
		WHERE
			UserNotification.NotificationType = 4
				AND UserNotification.ReceiverID = '.$myU->ID.'
		ORDER BY TimeChat DESC
		');
		$CountUserChats->execute();
		
		$Pages = ceil($CountUserChats / $Limit);
		
		$GetRecentChats = $db->prepare('
SELECT * FROM(		SELECT * FROM (SELECT 
			0 AS Type,
			(CASE
				WHEN UserChat.SenderID = '.$myU->ID.' THEN UserChat.ReceiverID
				ELSE UserChat.SenderID
			END) AS ID,
			User.Username AS Name,
			NULL AS Username,
			User.AvatarURL AS Image,
			User.TimeLastSeen,
			UserChat.TimeChat,
			UserChat.Message,
			(SELECT 
					COUNT(*)
				FROM
					UserChat AS UC
				WHERE
					(UC.SenderID = User.ID
						AND UC.ReceiverID = '.$myU->ID.')
						AND UC.TimeRead = 0) AS UnreadMessageCount
		FROM
			UserChat
				JOIN
			User ON User.ID = (CASE
				WHEN UserChat.SenderID = '.$myU->ID.' THEN UserChat.ReceiverID
				ELSE UserChat.SenderID
			END)
		WHERE
			UserChat.SenderID = '.$myU->ID.' OR UserChat.ReceiverID = '.$myU->ID.' ORDER BY UserChat.TimeChat DESC) AS x
		UNION SELECT 
			'.$myU->ID.' AS Type,
			UserChatGroup.ID,
			UserChatGroup.Name,
			User.Username,
			UserChatGroup.GroupImage AS Image,
			UserChatGroup.ImageStatus AS TimeLastSeen,
			UserChatGroupMessage.TimeChat,
			UserChatGroupMessage.Message,
			UserChatGroupMember.UnreadMessageCount
		FROM
			UserChatGroupMessage
				JOIN
			UserChatGroupMember ON UserChatGroupMember.UserID = '.$myU->ID.'
				JOIN
			UserChatGroup ON UserChatGroupMember.ChatGroupID = UserChatGroup.ID
				JOIN
			User ON UserChatGroupMessage.UserID = User.ID
		WHERE
			UserChatGroupMessage.ID = (SELECT 
					MAX(UserChatGroupMessage.ID)
				FROM
					UserChatGroupMessage
				WHERE
					UserChatGroupMessage.ChatGroupID = UserChatGroup.ID) 
		UNION SELECT 
			2 AS Type,
			UserNotificationMessage.ID,
			User.Username AS Name,
			NULL AS Username,
			User.AvatarURL AS Image,
			User.TimeLastSeen,
			UserNotificationMessage.TimeMessage AS TimeChat,
			UserNotificationMessage.Message,
			(SELECT 
					COUNT(*)
				FROM
					UserNotification AS UN
				WHERE
					(UN.SenderID = User.ID
						AND UN.ReceiverID = '.$myU->ID.')
						AND UN.TimeRead = 0) AS UnreadMessageCount
		FROM
			UserNotificationMessage
				JOIN
			UserNotification ON UserNotification.RelevanceID = UserNotificationMessage.ID
				JOIN
			User ON User.ID = UserNotificationMessage.UserID
		WHERE
			UserNotification.NotificationType = 4
				AND UserNotification.ReceiverID = '.$myU->ID.') x
		GROUP BY Name
		ORDER BY TimeChat DESC
		');
		$GetRecentChats->execute();
		
		while ($gR = $GetRecentChats->fetch(PDO::FETCH_OBJ)) {
			
			$UserOnlineColor = ($gR->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
			$UnreadCount = ($gR->UnreadMessageCount < 99) ? $gR->UnreadMessageCount : '99+';
			
			if ($gR->Type == 0) {
				$Message = ($gR->ID == $myU->ID) ? '<strong>You:</strong> ' . $gR->Message : $gR->Message;
			} else if ($gR->Type == 1) {
				$Message = ($gR->ID == $myU->ID) ? '<strong>You:</strong> ' . $gR->Message : '<strong>'.$gR->Username.':</strong> ' . $gR->Message;
			} else if ($gR->Type == 2) {
				$Message = $gR->Message;
			}
			
			if (empty($gR->Image)) {
				$Image = 'tb.png';
			} else if ($gR->Type == 0 || $gR->Type == 2) {
				$Image = $gR->Image . '-thumb.png';
			} else if ($gR->TimeLastSeen == 0) {
				$Image = 'pending.png';
			} else if ($gR->TimeLastSeen == 2) {
				$Image = 'rejected.png';
			} else {
				$Image = $gR->Image;
			}
			
			$groupChatId = ($gR->Type == 0) ? 0 : (int)$gR->ID;
			
			$Row = array('type' => (int)$gR->Type, 'groupChatId' => $groupChatId, 'name' => $gR->Name, 'avatar' => $cdnName . $Image, 'timelastseen' => $UserOnlineColor, 'timechat' => get_timeago($gR->TimeChat), 'message' => LimitTextByCharacters($Message, 128), 'unread' => $UnreadCount);
			array_push($Results, $Row);
			
		}
		
		echo json_encode($Results);
		
	}