<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('error' => 'You must login before accessing this content.'));
		
	} else {
		
		$Results = array();
		
		$GetRecentChats = $db->prepare("
		SELECT * FROM (SELECT 
			UserChat.SenderID AS ID,
			User.Username AS Name,
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
						AND UC.ReceiverID = ".$myU->ID.")
						AND UC.TimeRead = 0) AS UnreadMessageCount
		FROM
			UserChat
				JOIN
			User ON User.ID = (CASE
				WHEN UserChat.SenderID = ".$myU->ID." THEN UserChat.ReceiverID
				ELSE UserChat.SenderID
			END)
		WHERE
			UserChat.SenderID = ".$myU->ID." OR UserChat.ReceiverID = ".$myU->ID." ORDER BY UserChat.TimeChat DESC) AS x
		GROUP BY Name ORDER BY TimeChat DESC
		");
		$GetRecentChats->execute();
		
		while ($gR = $GetRecentChats->fetch(PDO::FETCH_OBJ)) {
			
			$UserOnlineColor = ($gR->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
			if ($gR->Type == 0) {
				$Message = ($gR->ID == $myU->ID) ? '<strong>You:</strong> ' . $gR->Message : $gR->Message;
			} else {
				$Message = ($gR->ID == $myU->ID) ? '<strong>You:</strong> ' . $gR->Message : '<strong>'.$gR->Username.':</strong> ' . $gR->Message;
			}
			$UnreadCount = ($gR->UnreadMessageCount < 99) ? $gR->UnreadMessageCount : '99+';
			if ($gR->Type == 0) {
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