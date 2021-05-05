<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	$Code = (!empty($_GET['code'])) ? $_GET['code'] : NULL;
	
	if (!$Code) die;
	
	$GetUserChatGroup = $db->prepare("SELECT ID, MemberCount FROM UserChatGroup WHERE InviteCode = ?");
	$GetUserChatGroup->bindValue(1, $Code, PDO::PARAM_STR);
	$GetUserChatGroup->execute();
	$gG = $GetUserChatGroup->fetch(PDO::FETCH_OBJ);
	
	if ($GetUserChatGroup->rowCount() == 0) {
		
		header("Location: ".$serverName."/inbox");
		die;
		
	} else if ($gG->MemberCount > 50) {
		
		echo '
		<div class="grid-x grid-margin-x align-middle">
			<div class="large-6 cell large-offset-3">
				<h5>Join Group Chat</h5>
				<div class="push-5"></div>
				<div class="container border-r lg-padding">
					<p style="font-size:18px;">We\'re sorry, this group has reached its limit of <strong>50</strong> members.</p>
					<div class="push-15"></div>
					<a href="'.$serverName.'/inbox" class="button button-green text-center" style="display:inline;">Return to Inbox</a>
				</div>
			</div>
		</div>
		';
		
	} else {
		
		$InsertUserChatGroupMember = $db->prepare("INSERT INTO UserChatGroupMember (ChatGroupID, UserID) VALUES(".$gG->ID.", ".$myU->ID.")");
		$InsertUserChatGroupMember->execute();
		
		if ($InsertUserChatGroupMember->rowCount() == 0) {
			
			header("Location: ".$serverName."/inbox/group/" . $gG->ID);
			die;
			
		} else {
			
			header("Location: ".$serverName."/inbox/group/" . $gG->ID);
			die;
			
		}
	
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");