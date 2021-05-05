<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();

	if (!isset($_GET['id']) || !isset($_GET['rank'])) {
		
		header("Location: ".$serverName."/groups/");
		die;
		
	}
	
	$Rank = (int)$_GET['rank'];
	
	$getGroup = $db->prepare("SELECT UserGroup.ID, (SELECT CASE WHEN COUNT(*) > 0 THEN CONCAT(UserGroupMember.Rank, ':', UserGroupRank.PermissionViewWall, ':', UserGroupRank.PermissionPostWall, ':', UserGroupRank.PermissionModerateWall, ':', UserGroupRank.PermissionChangeRank, ':', UserGroupRank.PermissionKickUser, ':', UserGroupRank.PermissionInviteUser, ':', UserGroupRank.PermissionAcceptRequests, ':', UserGroupRank.PermissionAnnouncements, ':', UserGroupRank.PermissionEvents, ':', UserGroupRank.PermissionGroupFunds) ELSE 0 END FROM UserGroupMember JOIN UserGroupRank ON UserGroupMember.Rank = UserGroupRank.Rank WHERE UserGroupMember.GroupID = UserGroup.ID AND UserGroupMember.UserID = ".$myU->ID." AND UserGroupRank.GroupID = UserGroup.ID) AS IsMember, GROUP_CONCAT(UserGroupRank.Name, '%', UserGroupRank.Rank, '%', UserGroupRank.MemberCount, '%', UserGroupRank.PermissionViewWall, '%', UserGroupRank.PermissionPostWall, '%', UserGroupRank.PermissionModerateWall, '%', UserGroupRank.PermissionChangeRank, '%', UserGroupRank.PermissionKickUser, '%', UserGroupRank.PermissionInviteUser, '%', UserGroupRank.PermissionAcceptRequests, '%', UserGroupRank.PermissionAnnouncements, '%', UserGroupRank.PermissionEvents, '%', UserGroupRank.PermissionGroupFunds SEPARATOR '^') AS GroupRanks FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) JOIN UserGroupRank FORCE INDEX(UserGroupRank_GroupID_FK_idx) ON UserGroup.ID = UserGroupRank.GroupID WHERE UserGroup.ID = ? AND UserGroup.IsDisabled = 0");
	$getGroup->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getGroup->execute();
	
	if ($getGroup->rowCount() == 0) {
		
		header("Location: ".$serverName."/groups/");
		die;
		
	}
	
	$gG = $getGroup->fetch(PDO::FETCH_OBJ);
	
	$TempGroupRanks = explode('^', $gG->GroupRanks);
	$GroupRanks = array();
	
	if ($gG->IsMember != 0) {
		$MemberData = explode(':', $gG->IsMember);
		$MemberRankNum = $MemberData[0];
		$gG->IsMember = 1;
	}
	
	foreach ($TempGroupRanks as $GroupRank) {
		$GroupRank = explode('%', $GroupRank);
		$GroupRanks[$GroupRank[1]] = array($GroupRank[0], $GroupRank[2], $GroupRank[3], $GroupRank[4], $GroupRank[5], $GroupRank[6], $GroupRank[7], $GroupRank[8], $GroupRank[9], $GroupRank[10], $GroupRank[11], $GroupRank[12]);
	}
	ksort($GroupRanks);
	
	if (!array_key_exists($Rank, $GroupRanks)) {
		
		header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
		die;
		
	}
	
	echo '<div class="grid-x grid-margin-x">';
	
	$limit = 12;
	
	$pages = ceil($GroupRanks[$Rank][1] / $limit);
		
	$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
		
	$offset = ($page - 1)  * $limit;
	if ($offset < 0) { $offset = 0; }
	
	$getMembersByRank = $db->prepare("SELECT UserGroupMember.ID, UserGroupMember.UserID, UserGroupMember.Rank, User.Username, User.AvatarURL FROM UserGroupMember JOIN User ON UserGroupMember.UserID = User.ID WHERE UserGroupMember.GroupID = ".$gG->ID." AND UserGroupMember.Rank = ? ORDER BY UserGroupMember.ID DESC LIMIT ? OFFSET ?");
	$getMembersByRank->bindValue(1, $Rank, PDO::PARAM_INT);
	$getMembersByRank->bindValue(2, $limit, PDO::PARAM_INT);
	$getMembersByRank->bindValue(3, $offset, PDO::PARAM_INT);
	$getMembersByRank->execute();
	
	while ($gM = $getMembersByRank->fetch(PDO::FETCH_OBJ)) {
		
		echo '
		<div class="large-2 medium-3 small-6 cell text-center group-settings-members">
			<div class="relative">
				<img src="'.$cdnName . $gM->AvatarURL.'.png">
				<strong>'.$gM->Username.'</strong>
				';
				
				if ($myU->ID != $gM->UserID && $MemberRankNum > $gM->Rank && $GroupRanks[$MemberRankNum][5] == 1) {
					
					echo '
					<div class="group-settings-members-settings-icon" onclick="OpenConfigureModal(\''.$gM->ID.'\')"><i class="material-icons">settings</i></div>
					';
					
				}
				
				echo '
			</div>
		</div>
		';
		
		if ($myU->ID != $gM->UserID && $MemberRankNum > $gM->Rank && $GroupRanks[$MemberRankNum][5] == 1) {
			
		echo '
			<div class="reveal item-modal" id="Configure'.$gM->ID.'" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
				<form action="" method="POST">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Manage '.$gM->Username.'</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<div class="push-15"></div>
					<label for="new_role"><strong>Change member\'s rank</strong></label>
					<select class="normal-input" id="new_role" name="new_role">
						';
						
						foreach ($GroupRanks as $Key => $Value) {
							if ($Key != 100 && $Key < $MemberRankNum) {
								echo '<option value="'.$Key.'"'; if ($Key == $gM->Rank) { echo ' selected'; } echo '>'.htmlentities(strip_tags($Value[0])).'</option>';
							}
						}
						
						echo '
					</select>
					';
					
					if ($GroupRanks[$MemberRankNum][6] == 1) {
					
						echo '
						<div class="push-25"></div>
						<button type="button" class="button button-red" onclick="OpenKickModal(\''.$gM->ID.'\')">Kick User</button>
						';
					
					}
					
					echo '
					<div class="push-25"></div>
					<div align="center">
						<input type="submit" class="button button-green store-button inline-block" name="members_save" value="Save">
						<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						<input type="hidden" name="member_id" value="'.$gM->ID.'">
					</div>
				</form>
			</div>
			';
			
			if ($GroupRanks[$MemberRankNum][6] == 1) {
				
				echo '
				<div class="reveal item-modal" id="Kick'.$gM->ID.'" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
					<form action="" method="POST">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								<div class="modal-title">Kick '.$gM->Username.'</div>
							</div>
							<div class="shrink cell no-margin">
								<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
						</div>
						<p>
							Are you sure you wish to kick this member from the group?
							<br />
							To confirm this action, please type the member\'s username below.
						</p>
						<input type="text" class="normal-input" name="confirm_username">
						<div class="push-25"></div>
						<div align="center">
							<input type="submit" class="button button-red store-button inline-block" name="kick_user" value="Yes, kick">
							<input type="button" data-close class="button button-grey store-button inline-block" value="No, go back">
							<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							<input type="hidden" name="member_id" value="'.$gM->ID.'">
						</div>
					</form>
				</div>
				';
				
			}
			
		}
		
	}
	
	echo '
	</div>
	';
	
	if ($pages > 1) {
		
		echo '
		<div class="push-25"></div>
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a onclick="LoadMembersByRank('.$Rank.', '.($page-1).')">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
				
				if ($i <= $pages) {
				
					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a onclick="LoadMembersByRank('.$Rank.', '.($i).')">'.$i.'</a></li>';

				}
				
			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a onclick="LoadMembersByRank('.$Rank.', '.($page+1).')">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';
	
	}
	
	
	