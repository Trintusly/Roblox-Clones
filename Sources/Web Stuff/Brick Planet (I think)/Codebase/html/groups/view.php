<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (!isset($_GET['id']) || !isset($_GET['seo'])) {

		header("Location: ".$serverName."/groups/");
		die;

	}

	$SEO = $_GET['seo'];

	if (!$AUTH) { $myU->ID = -2; }

	switch ($myU->VIP) {
		case 0:
			$MemberLimit = 5;
			break;
		case 1:
			$MemberLimit = 15;
			break;
		case 2:
			$MemberLimit = 30;
			break;
		case 3:
			$MemberLimit = 50;
			break;
		default:
			$MemberLimit = 0;
			break;
	}

	$getGroup = $db->prepare("SELECT UserGroup.ID, UserGroup.GroupCategory, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, UserGroup.IsVerified, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroup.CoinsVault, UserGroup.VaultDisplay, UserGroup.JoinType, UserGroup.NonMemberTab, UserGroup.MemberTab, UserGroup.MemberCount, UserGroup.WallCount, (SELECT CASE WHEN COUNT(*) > 0 THEN CONCAT(UserGroupMember.Rank, ':', UserGroupMember.IsFavorite) ELSE 0 END FROM UserGroupMember WHERE GroupID = UserGroup.ID AND UserID = ".$myU->ID.") AS IsMember, (SELECT COUNT(*) FROM UserGroupJoinRequest WHERE GroupID = UserGroup.ID AND UserID = ".$myU->ID.") AS RequestPending, (SELECT COUNT(*) FROM UserGroupOutboundRequest WHERE GroupID = UserGroup.ID AND UserID = ".$myU->ID.") AS InvitePending, GROUP_CONCAT(UserGroupRank.Name, '%', UserGroupRank.Rank, '%', UserGroupRank.MemberCount, '%', UserGroupRank.PermissionViewWall, '%', UserGroupRank.PermissionPostWall, '%', UserGroupRank.PermissionModerateWall, '%', UserGroupRank.PermissionChangeRank, '%', UserGroupRank.PermissionKickUser, '%', UserGroupRank.PermissionInviteUser, '%', UserGroupRank.PermissionAcceptRequests, '%', UserGroupRank.PermissionAnnouncements, '%', UserGroupRank.PermissionEvents, '%', UserGroupRank.PermissionGroupFunds SEPARATOR '^') AS GroupRanks, (CASE UserGroup.OwnerType WHEN 0 THEN UserGroup.OwnerID WHEN 1 THEN (SELECT User.ID FROM UserGroup AS UGG JOIN User ON UGG.OwnerID = User.ID WHERE UGG.ID = UserGroup.OwnerID) END) AS FlexOwnerID, (CASE UserGroup.OwnerType WHEN 0 THEN User.VIP WHEN 1 THEN (SELECT UV.VIP FROM User UV WHERE UV.ID = (SELECT User.ID FROM UserGroup AS UGG JOIN User ON UGG.OwnerID = User.ID WHERE UGG.ID = UserGroup.OwnerID)) END) AS VIP, UserGroup.DivisionCount FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) JOIN UserGroupRank FORCE INDEX(UserGroupRank_GroupID_FK_idx) ON UserGroup.ID = UserGroupRank.GroupID WHERE UserGroup.ID = ? AND UserGroup.SEOName = ? AND UserGroup.IsDisabled = 0");
	$getGroup->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getGroup->bindValue(2, $SEO, PDO::PARAM_STR);
	$getGroup->execute();

	if ($getGroup->rowCount() == 0) {

		header("Location: ".$serverName."/groups/");
		die;

	}

	$gG = $getGroup->fetch(PDO::FETCH_OBJ);

	if ($gG->ID == NULL) {

		header("Location: ".$serverName."/groups/");
		die;

	}

	$TempGroupRanks = explode('^', $gG->GroupRanks);
	$GroupRanks = array();

	if ($gG->IsMember != 0) {
		$MemberData = explode(':', $gG->IsMember);
		$MemberRankNum = $MemberData[0];
		$IsFavorited = $MemberData[1];
		$gG->IsMember = 1;
	} else {
		$MemberRankNum = -1;
	}

	foreach ($TempGroupRanks as $GroupRank) {
		$GroupRank = explode('%', $GroupRank);
		$GroupRanks[$GroupRank[1]] = array($GroupRank[0], $GroupRank[2], $GroupRank[3], $GroupRank[4], $GroupRank[5], $GroupRank[6], $GroupRank[7], $GroupRank[8], $GroupRank[9], $GroupRank[10], $GroupRank[11], $GroupRank[12]);
	}
	ksort($GroupRanks);

	if ($AUTH && !empty($_POST['wall']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $myU->AccountVerified > 0) {

		if ($myU->UserFlood > time()) {

			$returnWallError = 'You are posting too fast, please wait <b>'.($myU->UserFlood - time()).'</b> more seconds before posting again.';

		} else if (strlen($_POST['wall']) < 3 || strlen($_POST['wall']) > 512) {

			$returnWallError = 'Your message must be between 3 and 512 characters.';

		} else if (isProfanity($_POST['wall']) == 1) {

			$returnWallError = 'One or more words in your post has triggered our profanity filter. Please update and try again.';

		} else {

			$db->beginTransaction();

			$WallPost = htmlentities(strip_tags($_POST['wall']));

			$Post = $db->prepare("INSERT INTO UserGroupWall (GroupID, UserID, Message, TimePosted) VALUES(".$gG->ID.", ".$myU->ID.", ?, ".time().")");
			$Post->bindValue(1, $WallPost, PDO::PARAM_STR);
			$Post->execute();
			
			$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
			$InsertUserActionLog->bindValue(1, 'Posted on group wall (Group ID: '.$gG->ID.')', PDO::PARAM_STR);
			$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
			$InsertUserActionLog->execute();

			$Count = $db->prepare("SELECT COUNT(*) FROM UserGroupWall WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID." AND Message = ? AND TimePosted = ".time()."");
			$Count->bindValue(1, $WallPost, PDO::PARAM_STR);
			$Count->execute();

			if ($Count->fetchColumn() > 1) {
				$db->rollBack();
			} else {
				$db->commit();
			}

			header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
			die;

		}

	}

	if ($AUTH && isset($_POST['delete_wall']) && !empty($_POST['wall_id']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

		$getPost = $db->prepare("SELECT UserID FROM UserGroupWall WHERE ID = ?");
		$getPost->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
		$getPost->execute();
		$gP = $getPost->fetch(PDO::FETCH_OBJ);

		if ($getPost->rowCount() > 0 && ($myU->ID == $gG->FlexOwnerID || $myU->ID == $gP->UserID || $myU->Admin > 0 || $GroupRanks[$MemberRankNum][4] == 1)) {

			$Delete = $db->prepare("DELETE FROM UserGroupWall WHERE ID = ? AND GroupID = ".$gG->ID."");
			$Delete->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
			$Delete->execute();

		}

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && isset($_POST['pin_wall']) && !empty($_POST['wall_id']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $GroupRanks[$MemberRankNum][4] == 1) {

		$Pin = $db->prepare("UPDATE UserGroupWall SET IsPinned = 1 WHERE ID = ? AND GroupID = ".$gG->ID."");
		$Pin->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
		$Pin->execute();

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && isset($_POST['unpin_wall']) && !empty($_POST['wall_id']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $GroupRanks[$MemberRankNum][4] == 1) {

		$Unpin = $db->prepare("UPDATE UserGroupWall SET IsPinned = 0 WHERE ID = ? AND GroupID = ".$gG->ID."");
		$Unpin->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
		$Unpin->execute();

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && isset($_POST['report_wall']) && !empty($_POST['wall_id']) && $gG->IsMember == 1) {

		$count = $db->prepare("SELECT ID FROM UserGroupWall WHERE UserGroupWall.ID = ? AND UserGroupWall.GroupID = ".$gG->ID."");
		$count->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
		$count->execute();

		if ($count->rowCount() > 0) {

			$_SESSION['Report_ReferenceType'] = 7;
			$_SESSION['Report_ReferenceID'] = $count->fetchColumn();

			header("Location: ".$serverName."/report/");
			die;

		}

	}

	if ($AUTH && !empty($_POST['join_group']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 0 && $gG->JoinType == 0 && $myU->NumGroups < $MemberLimit) {

		$Add = $db->prepare("INSERT INTO UserGroupMember (GroupID, UserID) VALUES(".$gG->ID.", ".$myU->ID.")");
		$Add->execute();
		
		$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
		$InsertUserActionLog->bindValue(1, 'Joined group (Group ID: '.$gG->ID.')', PDO::PARAM_STR);
		$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
		$InsertUserActionLog->execute();

		$cache->delete($myU->ID.'Cache_Groups');

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && !empty($_POST['request_join_group']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 0 && $gG->JoinType == 1 && $gG->RequestPending == 0 && $myU->NumGroups < $MemberLimit) {

		$Add = $db->prepare("INSERT INTO UserGroupJoinRequest (GroupID, UserID, TimeRequest) VALUES(".$gG->ID.", ".$myU->ID.", ".time().")");
		$Add->execute();
		
		$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
		$InsertUserActionLog->bindValue(1, 'Joined group (Group ID: '.$gG->ID.')', PDO::PARAM_STR);
		$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
		$InsertUserActionLog->execute();

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && !empty($_POST['accept_join_request']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 0 && $gG->JoinType == 2 && $gG->InvitePending == 1 && $myU->NumGroups < $MemberLimit) {

		$Add = $db->prepare("INSERT INTO UserGroupMember (GroupID, UserID) VALUES(".$gG->ID.", ".$myU->ID.")");
		$Add->execute();
		
		$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
		$InsertUserActionLog->bindValue(1, 'Joined group (Group ID: '.$gG->ID.')', PDO::PARAM_STR);
		$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
		$InsertUserActionLog->execute();

		$Remove = $db->prepare("DELETE FROM UserGroupOutboundRequest WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID."");
		$Remove->execute();

		$cache->delete($myU->ID.'Cache_Groups');

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && !empty($_POST['leave_group']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 1 && $gG->FlexOwnerID != $myU->ID) {

		$Remove = $db->prepare("DELETE FROM UserGroupMember WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID."");
		$Remove->execute();
		
		$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
		$InsertUserActionLog->bindValue(1, 'Left group (Group ID: '.$gG->ID.')', PDO::PARAM_STR);
		$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
		$InsertUserActionLog->execute();

		$cache->delete($myU->ID.'Cache_Groups');

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && !empty($_POST['claim_ownership']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 1 && $gG->OwnerID == -1) {

		$Update = $db->prepare("UPDATE UserGroup SET OwnerID = ".$myU->ID.", OwnerType = 0 WHERE ID = ".$gG->ID."");
		$Update->execute();

		$Update = $db->prepare("UPDATE UserGroupMember SET Rank = 100 WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID."");
		$Update->execute();
		
		$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
		$InsertUserActionLog->bindValue(1, 'Claimed group (Group ID: '.$gG->ID.')', PDO::PARAM_STR);
		$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
		$InsertUserActionLog->execute();

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && isset($_POST['favorite_group']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 1 && $myU->FavoriteGroup != $gG->ID) {

		$UpdateUserGroupMember = $db->prepare("UPDATE UserGroupMember SET IsFavorite = 0 WHERE UserID = ".$myU->ID."");
		$UpdateUserGroupMember->execute();
	
		$UpdateUserGroupMember = $db->prepare("UPDATE UserGroupMember SET IsFavorite = 1 WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID."");
		$UpdateUserGroupMember->execute();

		$cache->delete($myU->ID.'Cache_Groups');
		$cache->delete($myU->ID);

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && isset($_POST['unfavorite_group']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->IsMember == 1 && $myU->FavoriteGroup == $gG->ID) {

		$Update = $db->prepare("UPDATE UserGroupMember SET IsFavorite = 0 WHERE UserID = ".$myU->ID."");
		$Update->execute();

		$cache->delete($myU->ID.'Cache_Groups');
		$cache->delete($myU->ID);

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if ($AUTH && isset($_POST['report_group'])) {

		$_SESSION['Report_ReferenceType'] = 6;
		$_SESSION['Report_ReferenceID'] = $gG->ID;

		header("Location: ".$serverName."/report/");
		die;

	}

	if ($AUTH) {
		if (isset($_SESSION['Search_RecordNextPage'])) {
			$logSearchHistory = $db->prepare("INSERT INTO UserSearchHistory (UserID, ContentType, ContentID, TimeSearch) VALUES(".$myU->ID.", 3, ".$gG->ID.", ".time().")");
			$logSearchHistory->execute();
			if ($logSearchHistory->rowCount() == 0) {
				$update = $db->prepare("UPDATE UserSearchHistory SET TimeSearch = ".time()." WHERE UserID = ".$myU->ID." AND ContentType = 3 AND ContentID = ".$gG->ID."");
				$update->execute();
			}
			unset($_SESSION['Search_RecordNextPage']);
			header("Location: ".$serverName . $_SERVER['REQUEST_URI']."");
			die;
		}
	}

	echo '
	<meta property="og:title" content="'.htmlentities($gG->Name).'">
	<meta property="og:type" content="website">
	<meta property="og:url" content="'.$serverName.'/groups/'.$gG->ID.'/'.$gG->SEOName.'/">
	<meta property="og:image" content="https://cdn.brickcreate.com/'.$gG->LogoImage.'">
	<meta property="og:site_name" content="Brick Planet">
	<meta property="og:description" content="\''.$gG->Name.'\' is a group on Brick Planet, a user generated content sandbox game with tens of thousands of active players. Play today!">
	<script>
		document.title = "'.htmlentities($gG->Name).' - Brick Planet";

		function switchRank(rankId, Page) {
			if (Page === undefined) {
				Page = 1;
			}
			var request = new XMLHttpRequest();
			request.open("GET", "'.$serverName.'/groups/'.$gG->ID.'/get-members/" + rankId + "/" + Page + "/", true);
			request.onload = function(e) {
				if (request.readyState == 4 && request.status == 200) {
					var response = request.responseText;
					document.getElementById("MembersDiv").innerHTML = response;
				}
			}
			request.send(null);
		}

		function getDivisions(Page) {
			if (Page === undefined) {
				Page = 1;
			}
			var request = new XMLHttpRequest();
			request.open("GET", "'.$serverName.'/groups/'.$gG->ID.'/get-divisions/" + Page + "/", true);
			request.onload = function(e) {
				if (request.readyState == 4 && request.status == 200) {
					var response = request.responseText;
					document.getElementById("DivisionsDiv").innerHTML = response;
				}
			}
			request.send(null);
		}

		function getStoreItems(Page) {
			if (Page === undefined) {
				Page = 1;
			}
			var request = new XMLHttpRequest();
			request.open("GET", "'.$serverName.'/groups/'.$gG->ID.'/get-store/" + Page + "/", true);
			request.onload = function(e) {
				if (request.readyState == 4 && request.status == 200) {
					var response = request.responseText;
					document.getElementById("StoreDiv").innerHTML = response;
				}
			}
			request.send(null);
		}

		window.onload = function() {
			switchRank(1, 1);
			getDivisions();
			getStoreItems();
		}
	</script>
	<div class="grid-x grid-margin-x view-group">
		<div class="large-3 medium-4 small-12 cell">
			<div class="container md-padding border-r" style="position:relative;">
				<img src="'.$cdnName . $gG->LogoImage.'" class="group-logo">
			</div>
			<div class="group-name"><span>'.$gG->Name.'</span>'; if ($gG->IsVerified == 1) { echo '<a href="https://helpme.brickcreate.com/hc/en-us/articles/115003048633" target="_BLANK"><div style="display:inline;padding-left:7px;"><span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" title="This group is verified."><img src="/assets/images/groups/verified-ico32x32.png" style="height:25px;width:25px;"></span></div></a>'; } echo '</div>
			<div class="group-creator">Owner: '; if ($gG->OwnerID == -1) { echo '<strong>No One</strong>'; } else if ($gG->OwnerType == 0) { echo '<a href="'.$serverName.'/users/'.$gG->OwnerName.'/">'.$gG->OwnerName.'</a>'; } else { echo '<a href="'.$serverName.'/groups/'.$gG->OwnerID.'/'.str_replace(' ', '-', $gG->OwnerName).'/">'.$gG->OwnerName.'</a>'; } echo '</div>
			';

			if ($gG->IsMember == 0 && $myU->NumGroups >= $MemberLimit) {

				echo '
				<div class="text-center"><strong>You can only join up to '.$MemberLimit.' groups.</strong></div>
				<div class="push-10"></div>
				';

			}

			if ($gG->IsMember == 1 && $AUTH && $gG->OwnerID == -1 && $myU->NumGroups < $MemberLimit) {

				echo '
				<form action="" method="POST">
					<input type="submit" class="button button-blue groups-button" name="claim_ownership" value="Claim Ownership">
					<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
				</form>
				';

			}

			if ($gG->IsMember == 0 && $gG->JoinType == 0 && $AUTH && $myU->NumGroups < $MemberLimit) {

				echo '
				<form action="" method="POST">
					<input type="submit" class="button button-green groups-button" name="join_group" value="Join Group">
					<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
				</form>
				';

			} else if ($gG->IsMember == 0 && $gG->JoinType == 1 && $gG->RequestPending == 0 && $AUTH && $myU->NumGroups < $MemberLimit) {

				echo '
				<form action="" method="POST">
					<input type="submit" class="button button-green groups-button" name="request_join_group" value="Request to Join">
					<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
				</form>
				';

			} else if ($gG->IsMember == 0 && $gG->JoinType == 1 && $gG->RequestPending == 1 && $AUTH) {

				echo '
				<input type="button" class="button button-grey groups-button" value="Join Request Pending">
				';

			} else if ($gG->IsMember == 0 && $gG->JoinType == 2 && $gG->InvitePending == 1 && $AUTH) {

				echo '
				<form action="" method="POST">
					<input type="submit" class="button button-green groups-button" name="accept_join_request" value="Accept Join Request">
					<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
				</form>
				';

			} else if ($gG->IsMember == 1 && $AUTH && $gG->FlexOwnerID != $myU->ID) {

				echo '
				<input type="button" class="button button-red groups-button" value="Leave Group" data-open="LeaveModal">
				<div class="reveal item-modal" id="LeaveModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Confirm Action</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="bc-modal-contentText">
						<p>Are you sure you wish to leave this group? This action can not be undone.</p>
						<div align="center" style="margin-top:15px;">
							<form action="" method="POST">
								<input type="submit" class="button button-red store-button inline-block" name="leave_group" value="Leave Group">
								<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							</form>
						</div>
					</div>
				</div>
				';

			}

			if ($gG->IsMember == 1 && $gG->FlexOwnerID == $myU->ID && $AUTH || $AUTH && $gG->IsMember == 1 && ($GroupRanks[$MemberRankNum][5] == 1 || $GroupRanks[$MemberRankNum][6] == 1 || $GroupRanks[$MemberRankNum][7] == 1 || $GroupRanks[$MemberRankNum][8] == 1 || $GroupRanks[$MemberRankNum][9] == 1 || $GroupRanks[$MemberRankNum][10] == 1 || $GroupRanks[$MemberRankNum][11] == 1)) {

				echo '
				<a href="'.$serverName.'/groups/'.$gG->ID.'/settings/" class="button button-grey groups-button">Group Settings</a>
				';

			}

			echo '
			<ul class="tabs view-group-tabs" data-tabs id="tabs">
				<li class="tabs-title '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 1 || $gG->IsMember == 1 && $gG->MemberTab == 1) { echo 'is-active'; } echo '"><a href="#home" aria-selected="true">Home</a></li>
				<li class="tabs-title '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 2 || $gG->IsMember == 1 && $gG->MemberTab == 2) { echo 'is-active'; } echo '"><a href="#members">Members</a></li>
				';
				if ($gG->OwnerType == 0 && ($gG->VIP == 0 && $gG->DivisionCount > 0 || $gG->VIP > 0)) {
					echo '
					<li class="tabs-title '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 3 || $gG->IsMember == 1 && $gG->MemberTab == 3) { echo 'is-active'; } echo '"><a href="#divisions">Divisions</a></li>
					';
				}
				echo '
				<li class="tabs-title '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 4 || $gG->IsMember == 1 && $gG->MemberTab == 4) { echo 'is-active'; } echo '"><a href="#store">Store</a></li>
			</ul>
			<div class="push-25"></div>
			<div class="container border-r md-padding">
				';

				if ($gG->IsMember == 1) {

					echo '
					<div class="group-info-content">'.$GroupRanks[$MemberRankNum][0].'</div>
					<div class="group-info-title">My Rank</div>
					<div class="push-15"></div>
					';

				}

				echo '
				<div class="group-info-content">'.number_format($gG->MemberCount).'</div>
				<div class="group-info-title">Members</div>
				';

				if ($gG->IsMember == 1 && $gG->VaultDisplay == 1 || $gG->VaultDisplay == 2) {

					echo '
					<div class="push-15"></div>
					<div class="group-info-content coins-text" style="color:#f0be1d;">'.shortNum($gG->CoinsVault).' Bits</div>
					<div class="group-info-title">Group Vault</div>
					';

				}

				echo '
			</div>
			<div class="push-25"></div>
		</div>
		<div class="large-9 medium-8 small-12 cell">
			<div class="tabs-content" data-tabs-content="tabs">
				<div id="home" class="tabs-panel '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 1 || $gG->IsMember == 1 && $gG->MemberTab == 1) { echo 'is-active'; } echo '">
					<div class="grid-x grid-margin-x">
						<div class="auto cell no-margin">
							<h5>About</h5>
						</div>
						<div clas="shrink cell no-margin right">
						';
						
						if ($AUTH) {
							
							echo '
							<div>
								<span class="group-settings" style="cursor:pointer;" data-toggle="group-'.$gG->ID.'-dropdown"><i class="material-icons">more_vert</i></span>
								<div class="dropdown-pane creator-area-dropdown wall-post-header" id="group-'.$gG->ID.'-dropdown" data-dropdown data-hover="false" data-hover-pane="true">
								';

								if ($AUTH && $gG->IsMember == 1 && $myU->FavoriteGroup != $gG->ID) {
									
									echo '
									<ul>
										<li>
											<form action="" method="POST">
												<span>
													<button type="submit" name="favorite_group" style="color:#ffffff;cursor:pointer;" title="Favorite this group">Favorite Group</button>
													<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												</span>
											</form>
										</li>
									</ul>
									<div class="creator-area-dropdown-divider"></div>
									';
									
								} else if ($AUTH && $gG->IsMember == 1 && $myU->FavoriteGroup == $gG->ID) {
									
									echo '
									<ul>
										<li>
											<form action="" method="POST">
												<span>
													<button type="submit" name="unfavorite_group" style="color:#ffffff;cursor:pointer;" title="Unfavorite this group">Unfavorite Group</button>
													<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												</span>
											</form>
										</li>
									</ul>
									<div class="creator-area-dropdown-divider"></div>
									';
								
								}

								echo '
								<ul>
									<li><form action="" method="POST"><button name="report_group" style="color:#ffffff;cursor:pointer;">Report Abuse</button></form></li>
								</ul>
								';

								echo '
								</div>
							</div>
							';
							
						}
						
						echo '
						</div>
					</div>
					<div class="container border-r md-padding">
						<div class="group-description">'.nl2br($gG->Description).'</div>
					</div>
					';

					if (!$AUTH || $AUTH && $GroupRanks[$MemberRankNum][2] == 1 || $AUTH && $myU->Admin > 0) {

						echo '
						<div class="push-25"></div>
						<div class="container md-padding border-r">
						<h5>Group Wall</h5>
						';

						//if (iss-
							//echo $returnWallError;

						//}

						if ($AUTH && $GroupRanks[$MemberRankNum][3] == 1) {

							echo '
							<form action="" method="POST">
								<textarea class="normal-input wall-textarea" name="wall" '; if ($myU->AccountVerified == 0) { echo 'disabled placeholder="Please verify your account to post on the group\'s wall."'; } else { echo 'placeholder="Write a message to the group\'s wall"'; } echo '></textarea>
								<div class="wall-options clearfix">
									<div class="float-right">
										<input type="submit" class="button button-green" value="Post"'; if ($myU->AccountVerified == 0) { echo ' disabled'; } echo '>
										<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
									</div>
								</div>
							</form>
							<div class="push-15"></div>
							';

						}

						$limit = 10;

						$pages = ceil($gG->WallCount / $limit);

						$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
							'options' => array(
								'default'   => 1,
								'min_range' => 1,
							),
						)));

						$offset = ($page - 1)  * $limit;
						if ($offset < 0) { $offset = 0; }

						$getWall = $db->prepare("SELECT User.ID AS UserID, User.Username, User.AvatarURL, User.TimeLastSeen, UserGroupWall.ID, UserGroupWall.Message, UserGroupWall.TimePosted, UserGroupWall.IsPinned FROM UserGroupWall JOIN User ON User.ID = UserGroupWall.UserID WHERE UserGroupWall.GroupID = ".$gG->ID." ORDER BY UserGroupWall.IsPinned DESC, UserGroupWall.TimePosted DESC LIMIT ? OFFSET ?");
						$getWall->bindValue(1, $limit, PDO::PARAM_INT);
						$getWall->bindValue(2, $offset, PDO::PARAM_INT);
						$getWall->execute();

						while ($gW = $getWall->fetch(PDO::FETCH_OBJ)) {

							$UserOnlineColor = ($gW->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
							$StatusSpan = '<span class="user-online-status" style="background:#'.$UserOnlineColor.';"></span>';

							echo '
							<div class="wall-post">
								<div class="wall-post-header">
									<div class="grid-x grid-margin-x align-middle">
										';
										if ($gW->IsPinned == 1) {

											echo '
											<div class="shrink cell no-margin">
												<i class="material-icons group-pin" title="This is a pinned post">pin_drop</i>
											</div>
											';

										}
										echo '
										<div class="shrink cell no-margin">
											<div style="background-image:url(https://cdn.brickcreate.com/975289c5-1c08-463c-bdf5-0b49d35c933b.png);background-size:cover;" class="wall-post-avatar"></div>
										</div>
										<div class="auto cell no-margin">
											'.$StatusSpan.'
											<a href="'.$serverName.'/users/'.$gW->Username.'/" class="wall-post-username">'.$gW->Username.'</a>
										</div>
										<div class="shrink cell no-margin right">
											<span class="wall-post-time">'.get_timeago($gW->TimePosted).'</span>
											<span class="wall-settings" data-toggle="wall-'.$gW->ID.'-dropdown"><i class="material-icons">settings</i></span>
											<div class="dropdown-pane creator-area-dropdown" id="wall-'.$gW->ID.'-dropdown" data-dropdown data-hover="true" data-hover-pane="true">
											';

											if ($AUTH && ($gW->UserID == $myU->ID || $myU->Admin > 0 || $GroupRanks[$MemberRankNum][4] == 1)) {

												echo '<ul>';

												if ($gW->IsPinned == 0) {

													echo '
													<li><form action="" method="POST" style="display:inline;"><button type="submit" name="pin_wall">Pin Post</button><input type="hidden" name="wall_id" value="'.$gW->ID.'"><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></form></li>
													';

												} else if ($gW->IsPinned == 1) {

													echo '
													<li><form action="" method="POST" style="display:inline;"><button type="submit" name="unpin_wall">Unpin Post</button><input type="hidden" name="wall_id" value="'.$gW->ID.'"><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></form></li>
													';

												}

												echo '
												<form action="" method="POST" style="display:inline;"><button type="submit" name="delete_wall">Delete Post</button><input type="hidden" name="wall_id" value="'.$gW->ID.'"><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></form>
												';

												echo '</ul><div class="creator-area-dropdown-divider"></div>';

											}

											if ($AUTH) {

												echo '<ul>';

												echo '
												<li><form action="" method="POST" style="display:inline;"><button type="submit" name="report_wall">Report Post</button><input type="hidden" name="wall_id" value="'.$gW->ID.'"><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></form></li>
												';

												echo '</ul>';

											}

											echo '
											</div>
										</div>
									</div>
								</div>
								<div class="wall-post-main">
									'.nl2br($gW->Message).'
								</div>
							</div>
							';

						}

						if ($pages > 1) {

							echo '
							<div class="push-25"></div>
							<ul class="pagination" role="navigation" aria-label="Pagination">
								<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/'.str_replace(' ', '-', $gG->Name).'/?page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
								';

								for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

									if ($i <= $pages) {

										echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups/'.$gG->ID.'/'.str_replace(' ', '-', $gG->Name).'/?page='.($i).'">'.$i.'</a></li>';

									}

								}

								echo '
								<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/'.str_replace(' ', '-', $gG->Name).'/?page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
							</ul>
							';

						}

						echo '
						</div>
						';

					}

					echo '
				</div>
				<div id="members" class="tabs-panel '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 2 || $gG->IsMember == 1 && $gG->MemberTab == 2) { echo 'is-active'; } echo '">
					<div class="container border-r md-padding">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell">
								<h5>Members</h5>
							</div>
							<div class="shrink cell right">
								<select class="normal-input" onchange="switchRank(this.value)">
								';

								foreach ($GroupRanks as $key => $value) {

									echo '<option value="'.$key.'">'.htmlentities(strip_tags($value[0])).' ('.number_format($value[1]).')</option>';

								}

								echo '
								</select>
							</div>
						</div>
						<div class="push-10"></div>
						<div id="MembersDiv"></div>
					</div>
				</div>
				';

				if ($gG->OwnerType == 0) {

					echo '
					<div id="divisions" class="tabs-panel '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 3 || $gG->IsMember == 1 && $gG->MemberTab == 3) { echo 'is-active'; } echo '">
						<h5>Divisions</h5>
						<div class="container border-r md-padding">
							<div id="DivisionsDiv"></div>
						</div>
					</div>
					';

				}

				echo '
				<div id="store" class="tabs-panel '; if ($gG->IsMember == 0 && $gG->NonMemberTab == 4 || $gG->IsMember == 1 && $gG->MemberTab == 4) { echo 'is-active'; } echo '">
					<h5>Store</h5>
					<div class="container border-r md-padding">
						<div id="StoreDiv"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
