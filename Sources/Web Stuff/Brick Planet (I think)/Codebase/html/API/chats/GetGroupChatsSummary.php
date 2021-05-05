<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	header('Content-Type: application/json');

	if (!$AUTH) {
		
		echo json_encode(array('status' => 'error', 'You must login before accessing this content.'));
		
	} else {
		
		$Results = array();
		
		$GetRecentChats = $db->prepare("SELECT 1 AS Type, UserChatGroup.ID, UserChatGroup.Name, User.Username, UserChatGroup.GroupImage AS Image, UserChatGroup.ImageStatus AS TimeLastSeen, UserChatGroupMessage.TimeChat, UserChatGroupMessage.Message, UserChatGroupMember.UnreadMessageCount FROM UserChatGroupMessage JOIN UserChatGroupMember ON UserChatGroupMember.UserID = ".$myU->ID." JOIN UserChatGroup ON UserChatGroupMember.ChatGroupID = UserChatGroup.ID JOIN User ON UserChatGroupMessage.UserID = User.ID WHERE UserChatGroupMessage.ID = (SELECT UM.ID FROM UserChatGroupMessage AS UM WHERE UM.ChatGroupID = UserChatGroup.ID ORDER BY UM.TimeChat DESC LIMIT 1) ORDER BY UserChatGroupMessage.TimeChat DESC");
		$GetRecentChats->execute();
		
		while ($gR = $GetRecentChats->fetch(PDO::FETCH_OBJ)) {
			
			$UserOnlineColor = ($gR->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
			if ($gR->Type == 0) {
				$Message = ($gR->ID == $myU->ID) ? '<strong>You:</strong> ' . $gR->Message : $gR->Message;
			} else {
				$Message = ($gR->ID == $myU->ID) ? '<strong>You:</strong> ' . $gR->Message : '<strong>'.$gR->Username.':</strong> ' . $gR->Message;
			}
			$UnreadCount = ($gR->UnreadMessageCount < 99) ? $gR->UnreadMessageCount : '99+';
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