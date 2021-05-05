<?php
$page = 'groups';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();

	if (!isset($_GET['id'])) {

		header("Location: ".$serverName."/groups/");
		die;

	}

	$getGroup = $db->prepare("SELECT UserGroup.ID, UserGroup.GroupCategory, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroup.CoinsVault, UserGroup.VaultDisplay, UserGroup.JoinType, UserGroup.NonMemberTab, UserGroup.MemberTab, UserGroup.MemberCount, UserGroup.WallCount, (SELECT CASE WHEN COUNT(*) > 0 THEN CONCAT(UserGroupMember.Rank, ':', UserGroupRank.PermissionViewWall, ':', UserGroupRank.PermissionPostWall, ':', UserGroupRank.PermissionModerateWall, ':', UserGroupRank.PermissionChangeRank, ':', UserGroupRank.PermissionKickUser, ':', UserGroupRank.PermissionInviteUser, ':', UserGroupRank.PermissionAcceptRequests, ':', UserGroupRank.PermissionAnnouncements, ':', UserGroupRank.PermissionEvents, ':', UserGroupRank.PermissionGroupFunds, ':', UserGroupRank.PermissionGroupStore) ELSE 0 END FROM UserGroupMember JOIN UserGroupRank ON UserGroupMember.Rank = UserGroupRank.Rank WHERE UserGroupMember.GroupID = UserGroup.ID AND UserGroupMember.UserID = ".$myU->ID." AND UserGroupRank.GroupID = UserGroup.ID) AS IsMember, GROUP_CONCAT(UserGroupRank.Name, '%', UserGroupRank.Rank, '%', UserGroupRank.MemberCount, '%', UserGroupRank.PermissionViewWall, '%', UserGroupRank.PermissionPostWall, '%', UserGroupRank.PermissionModerateWall, '%', UserGroupRank.PermissionChangeRank, '%', UserGroupRank.PermissionKickUser, '%', UserGroupRank.PermissionInviteUser, '%', UserGroupRank.PermissionAcceptRequests, '%', UserGroupRank.PermissionAnnouncements, '%', UserGroupRank.PermissionEvents, '%', UserGroupRank.PermissionGroupFunds ,'%', UserGroupRank.PermissionGroupStore SEPARATOR '^') AS GroupRanks, UserGroup.StoreCount, UserGroup.JoinRequestCount, UserGroup.OutboundRequestCount, UserGroup.TotalEarningsCount, UserGroup.TotalEarningsRank, UserGroup.SalesCount, UserGroup.EarningsCount, (CASE UserGroup.OwnerType WHEN 0 THEN UserGroup.OwnerID WHEN 1 THEN (SELECT User.ID FROM UserGroup AS UGG JOIN User ON UGG.OwnerID = User.ID WHERE UGG.ID = UserGroup.OwnerID) END) AS FlexOwnerID, (CASE UserGroup.OwnerType WHEN 0 THEN User.VIP WHEN 1 THEN (SELECT UV.VIP FROM User UV WHERE UV.ID = (SELECT User.ID FROM UserGroup AS UGG JOIN User ON UGG.OwnerID = User.ID WHERE UGG.ID = UserGroup.OwnerID)) END) AS VIP, UserGroup.DivisionCount FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) JOIN UserGroupRank FORCE INDEX(UserGroupRank_GroupID_FK_idx) ON UserGroup.ID = UserGroupRank.GroupID WHERE UserGroup.ID = ? AND UserGroup.IsDisabled = 0");
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
		$GroupRanks[$GroupRank[1]] = array($GroupRank[0], $GroupRank[2], $GroupRank[3], $GroupRank[4], $GroupRank[5], $GroupRank[6], $GroupRank[7], $GroupRank[8], $GroupRank[9], $GroupRank[10], $GroupRank[11], $GroupRank[12], $GroupRank[13]);
	}
	krsort($GroupRanks);

	if ($GroupRanks[$MemberRankNum][5] == 0 && $GroupRanks[$MemberRankNum][6] == 0 && $GroupRanks[$MemberRankNum][7] == 0 && $GroupRanks[$MemberRankNum][8] == 0 && $GroupRanks[$MemberRankNum][9] == 0 && $GroupRanks[$MemberRankNum][10] == 0 && $GroupRanks[$MemberRankNum][11] == 0) {

		header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
		die;

	}

	if (isset($_POST['general_save']) && $gG->FlexOwnerID == $myU->ID) {

		if (!empty($_FILES['general_logo']['name'])) {

			if (exif_imagetype($_FILES['general_logo']['tmp_name']) != 2 && exif_imagetype($_FILES['general_logo']['tmp_name']) != 3) {

				$errorMessage = 'Invalid logo file.';

			} else if (!getimagesize($_FILES['general_logo']['tmp_name'])) {

				$errorMessage = 'Invalid logo file.';

			} else {

				$FileName = uniqid(md5(microtime()));

				require $_SERVER['DOCUMENT_ROOT'].'/../private/class.upload.php';

				$modify_file = new Upload($_FILES['general_logo']);

				if ($modify_file->uploaded) {

					$modify_file->image_resize = true;
					$modify_file->image_x = 512;
					$modify_file->image_ratio_x = true;
					$modify_file->image_y = 512;
					$modify_file->file_overwrite = true;
					$modify_file->image_convert = 'png';
					$modify_file->Process('/tmp/');

					if ($modify_file->processed) {

						uploadAsset($FileName.'.png', '/tmp/'.$modify_file->file_dst_name);
						$modify_file->clean();

					}

				}

				$Update = $db->prepare("UPDATE UserGroup SET LogoImage = '".$FileName.".png', LogoStatus = 0 WHERE ID = ".$gG->ID."");
				$Update->execute();

				$_SESSION['JumpToTab'] = 'general';

				header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
				die;
			}

		}

		if ($_POST['general_description'] != $gG->Description) {

			if (strlen($_POST['general_description']) < 3 || strlen($_POST['general_description']) > 5000) {

				$errorMessage = 'Your description is either too short or too long; it must be between 3 and 5,000 characters.';

			} else if (isProfanity($_POST['general_description']) == 1) {

				$errorMessage = 'One or more words in your group description has triggered our profanity filter. Please correct and try again.';

			} else {

				$Description = htmlentities(strip_tags($_POST['general_description']));

				$UpdateContent = $db->prepare("UPDATE UserGroup SET Description = ? WHERE ID = ".$gG->ID."");
				$UpdateContent->bindValue(1, $Description, PDO::PARAM_STR);
				$UpdateContent->execute();

				$_SESSION['JumpToTab'] = 'general';

				header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
				die;

			}

		}

	}

	if (isset($_POST['roles_save']) && $gG->FlexOwnerID == $myU->ID) {

		$Ranks = $_POST['rank'];
		ksort($Ranks);
		$Names = $_POST['name'];
		$Permissions = $_POST['permission'];

		foreach ($Permissions as $Key => $Value) {

			$Value = array_map(function($v) {
				return strip_tags($v);
			}, $Value);

			if (array_key_exists($Key, $GroupRanks) && $Key != 100) {

				$SQL = '';

				if ($Value[1] == '' || !is_numeric($Value[1])) { $Value[1] = 0; }
				if ($Value[2] == '' || !is_numeric($Value[2])) { $Value[2] = 0; }
				if ($Value[3] == '' || !is_numeric($Value[3])) { $Value[3] = 0; }
				if ($Value[4] == '' || !is_numeric($Value[4])) { $Value[4] = 0; }
				if ($Value[5] == '' || !is_numeric($Value[5])) { $Value[5] = 0; }
				if ($Value[6] == '' || !is_numeric($Value[6])) { $Value[6] = 0; }
				if ($Value[7] == '' || !is_numeric($Value[7])) { $Value[7] = 0; }
				if ($Value[8] == '' || !is_numeric($Value[8])) { $Value[8] = 0; }
				if ($Value[9] == '' || !is_numeric($Value[9])) { $Value[9] = 0; }
				if ($Value[10] == '' || !is_numeric($Value[10])) { $Value[10] = 0; }
				if ($Value[11] == '' || !is_numeric($Value[11])) { $Value[11] = 0; }

				if ((int)$Value[1] != $GroupRanks[$Key][2]) {
					$SQL .= 'PermissionViewWall = '.$Value[1].', ';
				}

				if ((int)$Value[2] != $GroupRanks[$Key][3]) {
					$SQL .= 'PermissionPostWall = '.$Value[2].', ';
				}

				if ((int)$Value[3] != $GroupRanks[$Key][4]) {
					$SQL .= 'PermissionModerateWall = '.$Value[3].', ';
				}

				if ((int)$Value[4] != $GroupRanks[$Key][5]) {
					$SQL .= 'PermissionChangeRank = '.$Value[4].', ';
				}

				if ((int)$Value[5] != $GroupRanks[$Key][6]) {
					$SQL .= 'PermissionKickUser = '.$Value[5].', ';
				}

				if ((int)$Value[6] != $GroupRanks[$Key][7]) {
					$SQL .= 'PermissionInviteUser = '.$Value[6].', ';
				}

				if ((int)$Value[7] != $GroupRanks[$Key][8]) {
					$SQL .= 'PermissionAcceptRequests = '.$Value[7].', ';
				}

				if ((int)$Value[8] != $GroupRanks[$Key][9]) {
					$SQL .= 'PermissionAnnouncements = '.$Value[8].', ';
				}

				if ((int)$Value[9] != $GroupRanks[$Key][10]) {
					$SQL .= 'PermissionEvents = '.$Value[9].', ';
				}

				if ((int)$Value[10] != $GroupRanks[$Key][11]) {
					$SQL .= 'PermissionGroupFunds = '.$Value[10].', ';
				}

				if ((int)$Value[11] != $GroupRanks[$Key][12]) {
					$SQL .= 'PermissionGroupStore = '.$Value[1].', ';
				}

				if (!empty($SQL)) {

					$SQL = substr($SQL, 0, -2);

					$Update = $db->prepare("UPDATE UserGroupRank SET ".$SQL." WHERE GroupID = ".$gG->ID." AND Rank = ?");
					$Update->bindValue(1, $Key, PDO::PARAM_INT);
					$Update->execute();

				}

			}

		}

		foreach ($Names as $Key => $Value) {

			if (array_key_exists($Key, $GroupRanks)) {

				if ($Value != $GroupRanks[$Key][0]) {

					$Update = $db->prepare("UPDATE UserGroupRank SET Name = ? WHERE GroupID = ".$gG->ID." AND Rank = ?");
					$Update->bindValue(1, htmlentities(strip_tags($Value)), PDO::PARAM_STR);
					$Update->bindValue(2, $Key, PDO::PARAM_INT);
					$Update->execute();

				}

			}

		}

		foreach ($Ranks as $Key => &$Value) {

			if (array_key_exists($Key, $GroupRanks) && $Key != 100 && $Key != 1) {

				if ($Value != $Key) {

					if ($Value < 100 && $Value > 1) {

						if (array_key_exists($Value, $GroupRanks)) {
							
							// Switch the existing rank (by role) to a placeholder
							$Update = $db->prepare("UPDATE UserGroupRank SET Rank = 101 WHERE GroupID = ".$gG->ID." AND Rank = ?");
							$Update->bindValue(1, $Value, PDO::PARAM_INT);
							$Update->execute();
							
						}
					
						$Update = $db->prepare("UPDATE UserGroupRank SET Rank = ? WHERE GroupID = ".$gG->ID." AND Rank = ?");
						$Update->bindValue(1, $Value, PDO::PARAM_INT);
						$Update->bindValue(2, $Key, PDO::PARAM_INT);
						$Update->execute();
						
						if (array_key_exists($Value, $GroupRanks)) {
							
							// Switch the existing rank (by role)
							$Update = $db->prepare("UPDATE UserGroupRank SET Rank = ? WHERE GroupID = ".$gG->ID." AND Rank = 101");
							$Update->bindValue(1, $Key, PDO::PARAM_INT);
							$Update->execute();
							
							unset($Ranks[$Value]);
							
						}
						
					}

				}

			}

		}

		$_SESSION['JumpToTab'] = 'roles';

		header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
		die;

	}

	if (isset($_POST['addrole']) && $gG->FlexOwnerID == $myU->ID) {

		$RoleName = $_POST['addrole_name'];
		$RoleNum = (is_numeric($_POST['addrole_rolenum'])) ? floor($_POST['addrole_rolenum']) : 0;
		$RoleNum = (int)$RoleNum;

		$RoleName = str_replace(['^', '%'], '', $RoleName);
		$RoleName = htmlentities(strip_tags($RoleName));

		if ($myU->CurrencyCoins < 100) {

			$errorMessage = 'You need <strong>'.(100-$myU->CurrencyCoins).'</strong> more Bits to purchase a role, which costs <strong>100</strong> Bits.';

			$_SESSION['JumpToTab'] = 'roles';

		} else if (strlen($RoleName) < 3 || strlen($RoleName) > 45) {

			$errorMessage = 'Your new role name is either too long or too short. It must be between 3 and 45 characters.';

			$_SESSION['JumpToTab'] = 'roles';

		} else if (isProfanity($RoleName) == 1) {

			$errorMessage = 'Your new role name has triggered our profanity filter. Please correct and try again.';

			$_SESSION['JumpToTab'] = 'roles';

		} else if (!is_numeric($RoleNum) || $RoleNum < 2 || $RoleNum > 99 || array_key_exists($RoleNum, $GroupRanks)) {

			$errorMessage = 'Invalid role number, it must be between 2-99 and currently not used by another role.';

			$_SESSION['JumpToTab'] = 'roles';

		} else {
			
			$db->beginTransaction();
			
			$AddRole = $db->prepare("INSERT INTO UserGroupRank (GroupID, Name, Rank) VALUES(".$gG->ID.", ?, ?)");
			$AddRole->bindValue(1, $RoleName, PDO::PARAM_STR);
			$AddRole->bindValue(2, $RoleNum, PDO::PARAM_INT);
			$AddRole->execute();

			$Update = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins - 100 WHERE ID = ".$myU->ID."");
			$Update->execute();
			
			if ($AddRole->rowCount() == 1 && $Update->rowCount() == 1) {
				$db->commit();
			} else {
				$db->rollBack();
			}

			$cache->delete($myU->ID);

			$_SESSION['JumpToTab'] = 'roles';

			header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
			die;

		}

	}

	if (isset($_POST['members_save']) && isset($_POST['new_role']) && isset($_POST['csrf_token']) && isset($_POST['member_id']) && $GroupRanks[$MemberRankNum][5] == 1) {

		$_POST['member_id'] = (int)$_POST['member_id'];
		$_POST['new_role'] = (int)$_POST['new_role'];

		if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {

			$errorMessage = 'Invalid CSRF token, try refreshing the page before continuing.';

			$_SESSION['JumpToTab'] = 'members';

		} else if (!is_numeric($_POST['new_role']) || $_POST['new_role'] < 1 || $_POST['new_role'] > 99 || !array_key_exists($_POST['new_role'], $GroupRanks)) {

			$errorMessage = 'Invalid role number';

			$_SESSION['JumpToTab'] = 'members';

		} else if ($_POST['new_role'] >= $MemberRankNum) {

			$errorMessage = 'You can not change the role of a member to a role equal or higher than yours.';

			$_SESSION['JumpToTab'] = 'members';

		} else {

			$GetMember = $db->prepare("SELECT Rank FROM UserGroupMember WHERE ID = ? AND GroupID = ".$gG->ID."");
			$GetMember->bindValue(1, $_POST['member_id'], PDO::PARAM_INT);
			$GetMember->execute();
			$MemberRank = $GetMember->fetchColumn();

			if ($GetMember->rowCount() == 0 || $MemberRank >= $MemberRankNum) {

				$errorMessage = 'You can not change the role of a member to a role equal or higher than yours.';

				$_SESSION['JumpToTab'] = 'members';

			} else {

				$Update = $db->prepare("UPDATE UserGroupMember SET Rank = ? WHERE ID = ? AND GroupID = ".$gG->ID."");
				$Update->bindValue(1, $_POST['new_role'], PDO::PARAM_INT);
				$Update->bindValue(2, $_POST['member_id'], PDO::PARAM_INT);
				$Update->execute();

				$_SESSION['JumpToTab'] = 'members';

				header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
				die;

			}

		}

	}

	if (isset($_POST['kick_user']) && isset($_POST['confirm_username']) && isset($_POST['csrf_token']) && isset($_POST['member_id']) && $GroupRanks[$MemberRankNum][6] == 1) {

		$GetMember = $db->prepare("SELECT UserGroupMember.Rank, User.Username FROM UserGroupMember JOIN User ON UserGroupMember.UserID = User.ID WHERE UserGroupMember.ID = ? AND UserGroupMember.GroupID = ".$gG->ID."");
		$GetMember->bindValue(1, $_POST['member_id'], PDO::PARAM_INT);
		$GetMember->execute();
		$gM = $GetMember->fetch(PDO::FETCH_OBJ);

		if ($_POST['csrf_token'] != $_SESSION['csrf_token']) {

			$errorMessage = 'Invalid CSRF token, try refreshing the page before continuing.';

			$_SESSION['JumpToTab'] = 'members';

		}

		else if ($gM->Username == $myU->Username) {

			$errorMessage = 'You can not kick yourself.';

			$_SESSION['JumpToTab'] = 'members';

		} else if ($GetMember->rowCount() == 0 || $gM->Rank >= $MemberRankNum) {

			$errorMessage = 'You can not kick a member that has a role equal or higher than yours.';

			$_SESSION['JumpToTab'] = 'members';

		} else if ($gM->Username != $_POST['confirm_username']) {

			$errorMessage = 'The username you provided in the confirm text box does not match the username of the member you are attempting to kick.';

			$_SESSION['JumpToTab'] = 'members';

		} else {

			$Kick = $db->prepare("DELETE FROM UserGroupMember WHERE ID = ? AND GroupID = ".$gG->ID."");
			$Kick->bindValue(1, $_POST['member_id'], PDO::PARAM_INT);
			$Kick->execute();

			$cache->delete($_POST['member_id'].'Cache_Groups');

			$_SESSION['JumpToTab'] = 'members';

			header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
			die;

		}

	}

	if (isset($_POST['accept_join_request']) && isset($_POST['request_id']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $GroupRanks[$MemberRankNum][8] == 1) {

		$validateRequest = $db->prepare("SELECT UserID FROM UserGroupJoinRequest WHERE ID = ? AND GroupID = ".$gG->ID."");
		$validateRequest->bindValue(1, $_POST['request_id'], PDO::PARAM_INT);
		$validateRequest->execute();

		if ($validateRequest->rowCount() > 0) {

			$Insert = $db->prepare("INSERT INTO UserGroupMember (GroupID, UserID, Rank) VALUES(".$gG->ID.", ".$validateRequest->fetchColumn().", 1)");
			$Insert->execute();

			$Delete = $db->prepare("DELETE FROM UserGroupJoinRequest WHERE ID = ? AND GroupID = ".$gG->ID."");
			$Delete->bindValue(1, $_POST['request_id'], PDO::PARAM_INT);
			$Delete->execute();

			$_SESSION['JumpToTab'] = 'members';

			header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
			die;

		}

	}

	if (isset($_POST['deny_join_request']) && isset($_POST['request_id']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $GroupRanks[$MemberRankNum][8] == 1) {

		$Delete = $db->prepare("DELETE FROM UserGroupJoinRequest WHERE ID = ? AND GroupID = ".$gG->ID."");
		$Delete->bindValue(1, $_POST['request_id'], PDO::PARAM_INT);
		$Delete->execute();

		$_SESSION['JumpToTab'] = 'members';

		header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
		die;

	}

	if (isset($_POST['invite_user_submit']) && isset($_POST['invite_username']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $GroupRanks[$MemberRankNum][7] == 1) {

		$checkMember = $db->prepare("SELECT COUNT(UserGroupMember.ID) FROM UserGroupMember JOIN User ON UserGroupMember.UserID = User.ID WHERE UserGroupMember.GroupID = ".$gG->ID." AND User.Username = ?");
		$checkMember->bindValue(1, $_POST['invite_username'], PDO::PARAM_STR);
		$checkMember->execute();

		if ($checkMember->fetchColumn() == 0) {

			$Insert = $db->prepare("INSERT INTO UserGroupOutboundRequest (GroupID, UserID, TimeRequest) VALUES(".$gG->ID.", (SELECT ID FROM User WHERE Username = ?), ".time().")");
			$Insert->bindValue(1, $_POST['invite_username'], PDO::PARAM_STR);
			$Insert->execute();

			$_SESSION['JumpToTab'] = 'members';

			header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
			die;

		}

	}

	if (isset($_POST['revoke_invite']) && isset($_POST['request_id']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $GroupRanks[$MemberRankNum][7] == 1) {

		$Delete = $db->prepare("DELETE FROM UserGroupOutboundRequest WHERE ID = ? AND GroupID = ".$gG->ID."");
		$Delete->bindValue(1, $_POST['request_id'], PDO::PARAM_INT);
		$Delete->execute();

		$_SESSION['JumpToTab'] = 'members';

		header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
		die;

	}

	if (isset($_POST['options_save']) && isset($_POST['join_type']) && isset($_POST['tab_nonmembers']) && isset($_POST['tab_members']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

		if ($_POST['join_type'] != $gG->JoinType && is_numeric($_POST['join_type']) && $_POST['join_type'] >= 0 && $_POST['join_type'] <= 2) {

			$Update = $db->prepare("UPDATE UserGroup SET JoinType = ? WHERE ID = ".$gG->ID."");
			$Update->bindValue(1, $_POST['join_type'], PDO::PARAM_INT);
			$Update->execute();

		}

		if ($_POST['tab_nonmembers'] != $gG->NonMemberTab && is_numeric($_POST['tab_nonmembers']) && $_POST['tab_nonmembers'] >= 1 && $_POST['tab_nonmembers'] <= 4) {

			$Update = $db->prepare("UPDATE UserGroup SET NonMemberTab = ? WHERE ID = ".$gG->ID."");
			$Update->bindValue(1, $_POST['tab_nonmembers'], PDO::PARAM_INT);
			$Update->execute();

		}

		if ($_POST['tab_members'] != $gG->MemberTab && is_numeric($_POST['tab_members']) && $_POST['tab_members'] >= 1 && $_POST['tab_members'] <= 4) {

			$Update = $db->prepare("UPDATE UserGroup SET MemberTab = ? WHERE ID = ".$gG->ID."");
			$Update->bindValue(1, $_POST['tab_members'], PDO::PARAM_INT);
			$Update->execute();

		}

		if ($_POST['group_vault'] != $gG->VaultDisplay && is_numeric($_POST['group_vault']) && $_POST['group_vault'] >= 0 && $_POST['group_vault'] <= 2) {

			$Update = $db->prepare("UPDATE UserGroup SET VaultDisplay = ? WHERE ID = ".$gG->ID."");
			$Update->bindValue(1, $_POST['group_vault'], PDO::PARAM_INT);
			$Update->execute();

		}

		$_SESSION['JumpToTab'] = 'options';

		header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
		die;

	}

	if (isset($_POST['abandon_group']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->FlexOwnerID == $myU->ID) {

		$Code = uniqid(md5(microtime()));

		$Insert = $db->prepare("INSERT INTO UserGroupAbandonRequest(GroupID, Code, TimeExpire) VALUES(".$gG->ID.", '".$Code."', ".(time()+10800).")");
		$Insert->execute();

		if ($Insert->rowCount() > 0) {

			$message = '
			Hello <b>'.$myU->Username.'</b>,
			<br /><br />
			You are receiving this mail because we have received a request from your Brick Create account to abandon (leave) your group <b>'.$gG->Name.'</b>.
			<br /><br />
			If you would like to proceed, use this link to finish your request: <a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?action=abandon&code='.$Code.'">'.$serverName.'/groups/'.$gG->ID.'/settings/?action=abandon&code='.$Code.'</a>
			<br /><br />
			The above link will expire in three (3) hours.
			<br /><br />
			Please note that if your group is verified through our group verification program, abandoning ownership will cause your group to lose verification status.
			<br /><br />
			Accordingly, if you did not authorize this request, please contact us at <a href="mailto:hello@brickcreate.com">hello@brickcreate.com</a>.
			<br /><br />
			&dash; Your friends at Brick Create
			';

			sendEmail($myU->Email, 'Confirm Action: Abandoning group '.$gG->Name.'', $message);

			$successMessage = 'An email has been successfully dispatched to your inbox. Please follow the instructions to complete the process.';

			$_SESSION['JumpToTab'] = 'options';

		} else {

			$errorMessage = 'There is already a pending code to abandon your group. Try checking your email, and your spam/junk folder if you did not receive it.';

			$_SESSION['JumpToTab'] = 'options';

		}

	}

	if (isset($_POST['change_ownership']) && !empty($_POST['new_owner_type']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->FlexOwnerID == $myU->ID) {

		if ($_POST['new_owner_type'] == 1 && !empty($_POST['new_owner_username'])) {

			$validateMember = $db->prepare("SELECT User.ID, User.Username FROM UserGroupMember JOIN User ON UserGroupMember.UserID = User.ID WHERE User.Username = ? AND UserGroupMember.GroupID = ".$gG->ID."");
			$validateMember->bindValue(1, $_POST['new_owner_username'], PDO::PARAM_STR);
			$validateMember->execute();

			if ($validateMember->rowCount() == 0) {

				$errorMessage = 'The user must be in your group in order to change ownership to them.';

			} else {

				$vM = $validateMember->fetch(PDO::FETCH_OBJ);

				$Code = uniqid(md5(microtime()));

				$Insert = $db->prepare("INSERT INTO UserGroupChangeOwnershipRequest(GroupID, UserID, Code, NewOwnerType, TimeExpire) VALUES(".$gG->ID.", ".$vM->ID.", '".$Code."', 0, ".(time()+10800).")");
				$Insert->execute();

				if ($Insert->rowCount() > 0) {

					$message = '
					Hello <b>'.$myU->Username.'</b>,
					<br /><br />
					You are receiving this mail because we have received a request from your Brick Create account to change ownership for your group <b>'.$gG->Name.'</b>.
					<br /><br />
					You have requested to change ownership to (User) <b>'.$vM->Username.'</b>.
					<br /><br />
					If you would like to proceed, use this link to finish your request: <a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?action=ownership&code='.$Code.'">'.$serverName.'/groups/'.$gG->ID.'/settings/?action=abandon&code='.$Code.'</a>
					<br /><br />
					The above link will expire in three (3) hours.
					<br /><br />
					Please note that if your group is verified through our group verification program, changing ownership will cause your group to lose verification status.
					<br /><br />
					Accordingly, if you did not authorize this request, please contact us at <a href="mailto:hello@brickcreate.com">hello@brickcreate.com</a>.
					<br /><br />
					&dash; Your friends at Brick Create
					';

					sendEmail($myU->Email, 'Confirm Action: Change ownership for group '.$gG->Name.'', $message);

					$successMessage = 'An email has been successfully dispatched to your inbox. Please follow the instructions to complete the process.';

					$_SESSION['JumpToTab'] = 'options';

				} else {

					$errorMessage = 'There is already a pending code to change your group ownership. Try checking your email, and your spam/junk folder if you did not receive it.';

					$_SESSION['JumpToTab'] = 'options';

				}

			}

		} else if ($_POST['new_owner_type'] == 2 && !empty($_POST['new_owner_group'])) {

			$validateGroup = $db->prepare("SELECT UserGroup.ID, UserGroup.Name FROM UserGroup WHERE UserGroup.ID = ? AND UserGroup.OwnerID = ".$myU->ID." AND UserGroup.OwnerType = 0");
			$validateGroup->bindValue(1, $_POST['new_owner_group'], PDO::PARAM_STR);
			$validateGroup->execute();

			if ($validateGroup->rowCount() == 0) {

				$errorMessage = 'Invalid group, please try again.';

			} else {

				$vG = $validateGroup->fetch(PDO::FETCH_OBJ);

				$Code = uniqid(md5(microtime()));

				$Insert = $db->prepare("INSERT INTO UserGroupChangeOwnershipRequest(GroupID, UserID, Code, NewOwnerType, NewGroupID, TimeExpire) VALUES(".$gG->ID.", ".$myU->ID.", '".$Code."', 1, ".$vG->ID.", ".(time()+10800).")");
				$Insert->execute();

				if ($Insert->rowCount() > 0) {

					$message = '
					Hello <b>'.$myU->Username.'</b>,
					<br /><br />
					You are receiving this mail because we have received a request from your Brick Create account to change ownership for your group <b>'.$gG->Name.'</b>.
					<br /><br />
					You have requested to change ownership to (Group) <b>'.$vG->Name.'</b>.
					<br /><br />
					If you would like to proceed, use this link to finish your request: <a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?action=ownership&code='.$Code.'">'.$serverName.'/groups/'.$gG->ID.'/settings/?action=abandon&code='.$Code.'</a>
					<br /><br />
					The above link will expire in three (3) hours.
					<br /><br />
					Please note that if your group is verified through our group verification program, changing ownership will cause your group to lose verification status.
					<br /><br />
					Accordingly, if you did not authorize this request, please contact us at <a href="mailto:hello@brickcreate.com">hello@brickcreate.com</a>.
					<br /><br />
					&dash; Your friends at Brick Create
					';

					sendEmail($myU->Email, 'Confirm Action: Change ownership for group '.$gG->Name.'', $message);

					$successMessage = 'An email has been successfully dispatched to your inbox. Please follow the instructions to complete the process.';

					$_SESSION['JumpToTab'] = 'options';

				} else {

					$errorMessage = 'There is already a pending code to change your group ownership. Try checking your email, and your spam/junk folder if you did not receive it.';

					$_SESSION['JumpToTab'] = 'options';

				}

			}

		}

	}

	if (isset($_GET['action']) && isset($_GET['code']) && $_GET['action'] == 'abandon' && $gG->FlexOwnerID == $myU->ID) {

		$verifyRequest = $db->prepare("SELECT COUNT(*) FROM UserGroupAbandonRequest WHERE GroupID = ".$gG->ID." AND Code = ? AND TimeExpire > ".time()."");
		$verifyRequest->bindValue(1, $_GET['code'], PDO::PARAM_STR);
		$verifyRequest->execute();

		if ($verifyRequest->fetchColumn() > 0) {

			$Delete = $db->prepare("DELETE FROM UserGroupAbandonRequest WHERE GroupID = ".$gG->ID." AND Code = ?");
			$Delete->bindValue(1, $_GET['code'], PDO::PARAM_STR);
			$Delete->execute();

			$Delete = $db->prepare("DELETE FROM UserGroupChangeOwnershipRequest WHERE GroupID = ".$gG->ID."");
			$Delete->execute();

			$Delete = $db->prepare("DELETE FROM UserGroupMember WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID."");
			$Delete->execute();

			$Update = $db->prepare("UPDATE UserGroup SET OwnerID = '-1', OwnerType = 0, IsVerified = 0 WHERE ID = ".$gG->ID."");
			$Update->execute();

			if ($gG->OwnerType == 1) {

				$Update = $db->prepare("UPDATE UserGroup SET DivisionCount = DivisionCount - 1 WHERE ID = ".$gG->OwnerID."");
				$Update->execute();

			}

			$cache->delete($myU->ID.'Cache_Groups');

			header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
			die;

		}

	}

	if (isset($_GET['action']) && isset($_GET['code']) && $_GET['action'] == 'ownership' && $gG->FlexOwnerID == $myU->ID) {

		$verifyRequest = $db->prepare("SELECT UserID, NewOwnerType, NewGroupID FROM UserGroupChangeOwnershipRequest WHERE GroupID = ".$gG->ID." AND Code = ? AND TimeExpire > ".time()."");
		$verifyRequest->bindValue(1, $_GET['code'], PDO::PARAM_STR);
		$verifyRequest->execute();

		if ($verifyRequest->rowCount() > 0) {

			$vR = $verifyRequest->fetch(PDO::FETCH_OBJ);

			$Delete = $db->prepare("DELETE FROM UserGroupChangeOwnershipRequest WHERE GroupID = ".$gG->ID." AND Code = ?");
			$Delete->bindValue(1, $_GET['code'], PDO::PARAM_STR);
			$Delete->execute();

			if ($vR->NewOwnerType == 0) {

				$Update = $db->prepare("UPDATE UserGroup SET OwnerID = ".$vR->UserID.", OwnerType = 0, IsVerified = 0 WHERE ID = ".$gG->ID."");
				$Update->execute();

				if ($gG->OwnerType == 1) {

					$Update = $db->prepare("UPDATE UserGroup SET DivisionCount = DivisionCount - 1 WHERE ID = ".$gG->OwnerID."");
					$Update->execute();

				}

				if ($myU->ID != $vR->UserID) {

					$Update = $db->prepare("UPDATE UserGroupMember SET Rank = 1 WHERE GroupID = ".$gG->ID." AND UserID = ".$myU->ID."");
					$Update->execute();

					$Update = $db->prepare("UPDATE UserGroupMember SET Rank = 100 WHERE GroupID = ".$gG->ID." AND UserID = ".$vR->UserID."");
					$Update->execute();

				}

			} else if ($vR->NewOwnerType == 1){

				$Update = $db->prepare("UPDATE UserGroup SET OwnerID = ".$vR->NewGroupID.", OwnerType = 1, IsVerified = 0 WHERE ID = ".$gG->ID."");
				$Update->execute();

				$Update = $db->prepare("UPDATE UserGroup SET DivisionCount = DivisionCount + 1 WHERE ID = ".$vR->NewGroupID."");
				$Update->execute();

			}

			header("Location: ".$serverName."/groups/".$gG->ID."/".$gG->SEOName."/");
			die;

		}

	}

	if (isset($_POST['withdraw_amount']) && is_numeric($_POST['withdraw_amount']) && !empty($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gG->FlexOwnerID == $myU->ID) {

		$_POST['withdraw_amount'] = floor(str_replace(',', '', $_POST['withdraw_amount']));

		if ($_POST['withdraw_amount'] < 1 || $_POST['withdraw_amount'] > $gG->CoinsVault) {

			$errorMessage = 'Invalid withdrawal amount, please try again.';

			$_SESSION['JumpToTab'] = 'vault';

		} else {

			$db->beginTransaction();

			$Update = $db->prepare("UPDATE UserGroup SET CoinsVault = CoinsVault - ? WHERE ID = ".$gG->ID."");
			$Update->bindValue(1, $_POST['withdraw_amount'], PDO::PARAM_INT);
			$Update->execute();

			$Check = $db->prepare("SELECT CoinsVault FROM UserGroup WHERE ID = ".$gG->ID."");
			$Check->execute();

			if ($Check->fetchColumn() < 0) {

				$db->rollBack();

			} else {

				$db->commit();

				$Update = $db->prepare("UPDATE User SET CurrencyCoins = CurrencyCoins + ? WHERE ID = ".$myU->ID."");
				$Update->bindValue(1, $_POST['withdraw_amount'], PDO::PARAM_INT);
				$Update->execute();

				$_SESSION['SuccessMessage'] = 'You have successfully withdrawn <strong>'.$_POST['withdraw_amount'].'</strong> Bits from your group vault.';
				$_SESSION['JumpToTab'] = 'vault';

				$cache->delete($myU->ID);

				header("Location: ".$serverName."/groups/".$gG->ID."/settings/");
				die;

			}

		}

	}

	echo '
	<script>
		document.title = "Group Settings - Brick Create";

		function uploadLogo(file) {
			document.getElementById("group-settings-update-logo").innerHTML = "<div class=\"push-25\"></div>" + file.files[0].name;
		}

		function LoadMembersByRank(Rank, Page = 1) {
			var request = new XMLHttpRequest();
			request.open("GET", "'.$serverName.'/groups/'.$gG->ID.'/settings/members/" + Rank +"/" + Page +"/", true);
			request.onload = function(e) {
				if (request.readyState == 4 && request.status == 200) {
					var response = request.responseText;
					document.getElementById("MembersDiv").innerHTML = response;
				}
			}
			request.send(null);
		}
		';

		if ($GroupRanks[$MemberRankNum][5] == 1) {

			echo '
			function OpenConfigureModal(MemberID) {
				$("#Configure"+MemberID+"").foundation();
				$("#Configure"+MemberID+"").foundation("open");
			}
			';

		}

		if ($GroupRanks[$MemberRankNum][6] == 1) {

			echo '
			function OpenKickModal(MemberID) {
				$("#Kick"+MemberID+"").foundation();
				$("#Kick"+MemberID+"").foundation("open");
			}
			';

		}

		echo '

		window.onload = function() {
			LoadMembersByRank(1, 1);
			';

			if (isset($_GET['p']) || isset($_GET['q'])) {
				echo '
				$("#tabs").foundation("selectTab", "members");
				';
				$jumped = 1;
			} else if (isset($_SESSION['JumpToTab'])) {
				echo '
				$("#tabs").foundation("selectTab", "'.$_SESSION['JumpToTab'].'");
				';
				$jumped = 1;
				unset($_SESSION['JumpToTab']);
			}

			echo '
		}
	</script>
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4 class="group-settings-title">Settings for <a href="'.$serverName.'/groups/'.$gG->ID.'/'.$gG->SEOName.'/">'.$gG->Name.'</a></h4>
		</div>
		<div class="shrink cell right no-margin">
			<span>Group Vault: </span><span class="coins-text">$'.number_format($gG->CoinsVault).'</span>
		</div>
	</div>
	<ul class="tabs grid-x grid-margin-x group-settings-tabs" data-tabs id="tabs">
		<li class="no-margin tabs-title cell'; if (!isset($jumped)) { echo ' is-active'; } echo '" aria-selected="true"><a href="#general">General</a></li>
		<li class="no-margin tabs-title cell"><a href="#roles">Roles</a></li>
		<li class="no-margin tabs-title cell"><a href="#members">Members</a></li>
		<li class="no-margin tabs-title cell"><a href="#options">Options</a></li>
		<li class="no-margin tabs-title cell"><a href="#vault" class="no-right-border">Vault</a></li>
	</ul>
	';

	if (!empty($_SESSION['SuccessMessage'])) {

		echo '<div class="success-message">'.$_SESSION['SuccessMessage'].'</div>';
		unset($_SESSION['SuccessMessage']);

	}

	if (!empty($successMessage)) {

		echo '<div class="success-message">'.$successMessage.'</div>';

	} else if (!empty($errorMessage)) {

		echo '<div class="error-message">'.$errorMessage.'</div>';

	}

	echo '
	<div class="tabs-content large-12 cell" data-tabs-content="tabs">
		<div id="general" class="tabs-panel'; if (!isset($jumped)) { echo ' is-active'; } echo '">
			<form action="" method="POST" enctype="multipart/form-data">
				<h5>Logo</h5>
				<div class="container border-r lg-padding text-center">
					<div class="group-settings-logo" style="background:url('.$cdnName . $gG->LogoImage.');background-size:cover;">
						';

						if ($gG->FlexOwnerID == $myU->ID) {

							echo '
							<label for="update-logo">
								<div class="group-settings-logo-edit">
									<i class="material-icons">edit</i>
								</div>
								<input type="file" id="update-logo" class="input-update-logo" name="general_logo" onchange="uploadLogo(this)">
							</label>
							';

						}

						echo '
					</div>
					<div id="group-settings-update-logo"></div>
				</div>
				<div class="push-25"></div>
				<h5>About</h5>
				<div class="container border-r md-padding">
					<textarea class="normal-input" name="general_description" placeholder="Enter a description for your group" style="height:125px;font-size:14px;"'; if ($gG->OwnerID != $myU->ID) { echo ' disabled'; } echo '>'.$gG->Description.'</textarea>
				</div>
				';

				if ($gG->FlexOwnerID == $myU->ID) {

					echo '
					<div class="push-25"></div>
					<input type="submit" class="button button-green" name="general_save" value="Save" style="margin: 0 auto;">
					';

				}

				echo '
			</form>
		</div>
		<div id="roles" class="tabs-panel">
			<div class="grid-x grid-margin-x align-middle">
				<div class="auto cell no-margin">
					<h5>Roles</h5>
				</div>
				<div class="shrink cell right no-margin">
					';

					if ($gG->FlexOwnerID == $myU->ID) {

						echo '
						<button type="button" class="button button-blue group-settings-add" data-open="AddRole"><i class="material-icons">add</i><span>Add</span></button>
						';

					}

					echo '
				</div>
			</div>
			';

			if ($gG->FlexOwnerID == $myU->ID) {

				echo '
				<div class="reveal item-modal" id="AddRole" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
					<form action="" method="POST">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								<div class="modal-title">Add Role</div>
							</div>
							<div class="shrink cell no-margin">
								<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
						</div>
						<div class="push-15"></div>
						<input type="text" class="normal-input" name="addrole_name" placeholder="Role Name">
						<div class="push-15"></div>
						<input type="text" class="normal-input" name="addrole_rolenum" placeholder="Role # (2-99)">
						<div class="push-15"></div>
						<div>Creating a new role will cost <font class="coins-text">100 Bits</font></div>
						<div align="center" style="margin-top:15px;">
							<input type="submit" class="button button-green store-button inline-block" name="addrole" value="Add Role">
							<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
							<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						</div>
					</form>
				</div>
				';

			}

			echo '
			<div class="push-10"></div>
			<form action="" method="POST">
				<div class="container border-r md-padding">
					<div class="push-15"></div>
					<div class="grid-x grid-margin-x align-middle group-settings-roles-titles">
						<div class="large-2 medium-2 small-6 cell">
							<strong>Role #</strong>
						</div>
						<div class="large-3 medium-3 small-6 cell">
							<strong>Name</strong>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to view the group wall"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to post on the group wall"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to moderate (delete or pin) posts in the group wall"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to change other member\'s ranks below their rank"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to remove members from the group below their rank"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to send membership invites to non-group members"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to handle group member join requests"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to send out group announcements to participating group members"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to manage group events"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) in rank to manage the group vault"><i class="material-icons">info_outline</i></div>
						</div>
						<div class="shrink cell text-center">
							<div class="group-settings-tooltip has-tip top" data-tooltip aria-haspopup="true" data-disable-hover="false" tabindex="2" title="Allow member(s) to manage the group store"><i class="material-icons">info_outline</i></div>
						</div>
					</div>
					';

					foreach ($GroupRanks as $key => $value) {

						echo '
						<div class="grid-x grid-margin-x align-middle group-settings-roles">
							<div class="large-2 medium-2 small-6 cell">
								<input type="text" name="rank['.$key.']" class="normal-input" value="'.$key.'"'; if ($key == 1 || $key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } echo '>
							</div>
							<div class="large-3 medium-3 small-6 cell">
								<input type="text" name="name['.$key.']" class="normal-input" value="'.$value[0].'"'; if ($gG->OwnerID != $myU->ID) { echo ' disabled'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][1]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[2] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][2]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[3] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][3]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[4] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][4]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[5] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][5]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[6] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][6]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[7] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][7]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[8] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][8]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[9] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][9]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[10] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][10]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[11] == 1) { echo ' checked'; } echo '>
							</div>
							<div class="shrink cell text-center">
								<input type="checkbox" name="permission['.$key.'][11]" value="1"'; if ($key == 100 || $gG->OwnerID != $myU->ID) { echo ' disabled'; } if ($value[12] == 1) { echo ' checked'; } echo '>
							</div>
						</div>
						';

					}

					echo '
				</div>
				';

				if ($gG->FlexOwnerID == $myU->ID) {

					echo '
					<div class="push-25"></div>
					<input type="submit" class="button button-green" name="roles_save" value="Save">
					';

				}

				echo '
			</form>
		</div>
		<div id="members" class="tabs-panel">
			<div class="container border-r md-padding">
				<div class="grid-x grid-margin-x align-middle">
					<div class="auto cell">
						<h5>Members</h5>
					</div>
					<div class="shrink cell right">
						<select class="normal-input" onchange="LoadMembersByRank(this.value)">
							';
							ksort($GroupRanks);
							foreach ($GroupRanks as $Key => $Value) {
								echo '<option value="'.$Key.'">'.htmlentities(strip_tags($Value[0])).' ('.number_format($Value[1]).')</option>';
							}

							echo '
						</select>
					</div>
				</div>
				<div class="push-25"></div>
				<div class="grid-x grid-margin-x">
					<div class="auto cell">
						<div id="MembersDiv"></div>
					</div>
				</div>
			</div>
			';

			if ($gG->JoinType == 1 && $GroupRanks[$MemberRankNum][8] == 1) {

				$limit = 10;

				if (empty($_GET['q']) || $_GET['q'] == ' ') {

					$pages = ceil($gG->JoinRequestCount / $limit);

				} else {

					$count = $db->prepare("SELECT UserGroupJoinRequest.ID, UserGroupJoinRequest.TimeRequest, User.Username, User.AvatarURL FROM UserGroupJoinRequest JOIN User ON UserGroupJoinRequest.UserID = User.ID WHERE UserGroupJoinRequest.GroupID = ".$gG->ID." AND User.Username = ?");
					$count->bindValue(1, $_GET['q'], PDO::PARAM_STR);
					$count->execute();

					$pages = ceil($count->rowCount() / $limit);

					$gG->JoinRequestCount = $count->rowCount();

				}

				$page = min($pages, filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT, array(
					'options' => array(
						'default'   => 1,
						'min_range' => 1,
					),
				)));

				$offset = ($page - 1)  * $limit;
				if ($offset < 0) { $offset = 0; }

				echo '
				<div class="push-25"></div>
				<h5>Join Requests</h5>
				<div class="container border-r md-padding">
					';

					if ($gG->JoinRequestCount > 0) {

						echo '
						<form action="" method="GET">
							<div class="text-center"><input type="text" class="normal-input group-settings-search" name="q" placeholder="Search"'; if (!empty($_GET['q'])) { echo ' value="'.strip_tags($_GET['q']).'"'; } echo '></div>
							<input type="hidden" name="p" value="'.$page.'">
						</form>
						';

					}

					if ($gG->JoinRequestCount == 0) {

						echo 'No requests.';

					} else {

						if (empty($_GET['q']) || $_GET['q'] == ' ') {

							$getRequests = $db->prepare("SELECT UserGroupJoinRequest.ID, UserGroupJoinRequest.TimeRequest, User.Username, User.AvatarURL FROM UserGroupJoinRequest JOIN User ON UserGroupJoinRequest.UserID = User.ID WHERE UserGroupJoinRequest.GroupID = ".$gG->ID." ORDER BY UserGroupJoinRequest.TimeRequest DESC LIMIT ? OFFSET ?");
							$getRequests->bindValue(1, $limit, PDO::PARAM_INT);
							$getRequests->bindValue(2, $offset, PDO::PARAM_INT);
							$getRequests->execute();

						} else {

							$getRequests = $db->prepare("SELECT UserGroupJoinRequest.ID, UserGroupJoinRequest.TimeRequest, User.Username, User.AvatarURL FROM UserGroupJoinRequest JOIN User ON UserGroupJoinRequest.UserID = User.ID WHERE UserGroupJoinRequest.GroupID = ".$gG->ID." AND User.Username = ? ORDER BY UserGroupJoinRequest.TimeRequest DESC LIMIT ? OFFSET ?");
							$getRequests->bindValue(1, $_GET['q'], PDO::PARAM_STR);
							$getRequests->bindValue(2, $limit, PDO::PARAM_INT);
							$getRequests->bindValue(3, $offset, PDO::PARAM_INT);
							$getRequests->execute();

						}

						$i = 0;

						while ($gR = $getRequests->fetch(PDO::FETCH_OBJ)) {

							$i++;

							if ($i > 1) {
								echo '<div class="group-settings-join-request-divider"></div>';
							}

							echo '
							<div class="grid-x grid-margin-x align-middle group-settings-join-request">
								<div class="shrink cell">
									<a href="'.$serverName.'/users/'.$gR->Username.'/"><div class="request-avatar" style="background:url('.$cdnName . $gR->AvatarURL.'-thumb.png);background-size:cover;"></div></a>
								</div>
								<div class="auto cell">
									<a href="'.$serverName.'/users/'.$gR->Username.'/">'.$gR->Username.'</a>&nbsp;&dash;&nbsp;<span>'.get_timeago($gR->TimeRequest).'</span>
								</div>
								<div class="shrink cell right">
									<form action="" method="POST">
										<button type="submit" class="button button-green" name="accept_join_request">Accept</button>
										<button type="submit" class="button button-red" name="deny_join_request">Deny</button>
										<input type="hidden" name="request_id" value="'.$gR->ID.'">
										<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
									</form>
								</div>
							</div>
							';

						}

					}

					echo '
				</div>
				';

				if ($gG->JoinRequestCount > 0 && $pages > 1) {

					echo '
					<div class="push-25"></div>
					<ul class="pagination" role="navigation" aria-label="Pagination">
						<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?p='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
						';

						for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

							if ($i <= $pages) {

								echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?p='.($i).'">'.$i.'</a></li>';

							}

						}

						echo '
						<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?p='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
					</ul>
					';

				}

			} else if ($gG->JoinType == 2 && $GroupRanks[$MemberRankNum][7] == 1) {

				echo '
				<div class="push-25"></div>
				<div class="grid-x grid-margin-x align-middle">
					<div class="auto cell no-margin">
						<h5>Outbound Invite Requests</h5>
					</div>
					<div class="shrink cell right no-margin">
						<button type="button" class="button button-blue group-settings-add" data-open="InviteModal"><i class="material-icons">add</i><span>Add</span></button>
					</div>
				</div>
				<div class="push-10"></div>
				<div class="container border-r md-padding">
					';

					if ($gG->OutboundRequestCount > 0) {

						echo '
						<form action="" method="GET">
							<div class="text-center"><input type="text" class="normal-input group-settings-search" name="q" placeholder="Search"'; if (!empty($_GET['q'])) { echo ' value="'.strip_tags($_GET['q']).'"'; } echo '></div>
							<input type="hidden" name="p" value="'.$page.'">
						</form>
						';

					}

					$limit = 10;

					if (empty($_GET['q']) || $_GET['q'] == ' ') {

						$pages = ceil($gG->OutboundRequestCount / $limit);

					} else {

						$count = $db->prepare("SELECT UserGroupOutboundRequest.ID, UserGroupOutboundRequest.TimeRequest, User.Username, User.AvatarURL FROM UserGroupOutboundRequest JOIN User ON UserGroupOutboundRequest.UserID = User.ID WHERE UserGroupOutboundRequest.GroupID = ".$gG->ID." AND User.Username = ?");
						$count->bindValue(1, $_GET['q'], PDO::PARAM_STR);
						$count->execute();

						$pages = ceil($count->rowCount() / $limit);

						$gG->OutboundRequestCount = $count->rowCount();

					}

					$page = min($pages, filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT, array(
						'options' => array(
							'default'   => 1,
							'min_range' => 1,
						),
					)));

					$offset = ($page - 1)  * $limit;
					if ($offset < 0) { $offset = 0; }

					if ($gG->OutboundRequestCount == 0) {

						echo 'No requests.';

					} else {

						if (empty($_GET['q']) || $_GET['q'] == ' ') {

							$getRequests = $db->prepare("SELECT UserGroupOutboundRequest.ID, UserGroupOutboundRequest.TimeRequest, User.Username, User.AvatarURL FROM UserGroupOutboundRequest JOIN User ON UserGroupOutboundRequest.UserID = User.ID WHERE UserGroupOutboundRequest.GroupID = ".$gG->ID." ORDER BY UserGroupOutboundRequest.TimeRequest DESC LIMIT ? OFFSET ?");
							$getRequests->bindValue(1, $limit, PDO::PARAM_INT);
							$getRequests->bindValue(2, $offset, PDO::PARAM_INT);
							$getRequests->execute();

						} else {

							$getRequests = $db->prepare("SELECT UserGroupOutboundRequest.ID, UserGroupOutboundRequest.TimeRequest, User.Username, User.AvatarURL FROM UserGroupOutboundRequest JOIN User ON UserGroupOutboundRequest.UserID = User.ID WHERE UserGroupOutboundRequest.GroupID = ".$gG->ID." AND User.Username = ? ORDER BY UserGroupOutboundRequest.TimeRequest DESC LIMIT ? OFFSET ?");
							$getRequests->bindValue(1, $_GET['q'], PDO::PARAM_STR);
							$getRequests->bindValue(2, $limit, PDO::PARAM_INT);
							$getRequests->bindValue(3, $offset, PDO::PARAM_INT);
							$getRequests->execute();

						}

						$i = 0;

						while ($gR = $getRequests->fetch(PDO::FETCH_OBJ)) {

							$i++;

							if ($i > 1) {
								echo '<div class="group-settings-join-request-divider"></div>';
							}

							echo '
							<div class="grid-x grid-margin-x align-middle group-settings-join-request">
								<div class="shrink cell">
									<a href="'.$serverName.'/users/'.$gR->Username.'/"><div class="request-avatar" style="background:url('.$cdnName . $gR->AvatarURL.'-thumb.png);background-size:cover;"></div></a>
								</div>
								<div class="auto cell">
									<a href="'.$serverName.'/users/'.$gR->Username.'/">'.$gR->Username.'</a>&nbsp;&dash;&nbsp;<span>'.get_timeago($gR->TimeRequest).'</span>
								</div>
								<div class="shrink cell right">
									<form action="" method="POST">
										<button type="submit" class="button button-grey" name="revoke_invite">Revoke</button>
										<input type="hidden" name="request_id" value="'.$gR->ID.'">
										<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
									</form>
								</div>
							</div>
							';

						}

					}

					echo '
				</div>
				';

				if ($gG->OutboundRequestCount > 0 && $pages > 1) {

					echo '
					<div class="push-25"></div>
					<ul class="pagination" role="navigation" aria-label="Pagination">
						<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?p='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
						';

						for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

							if ($i <= $pages) {

								echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?p='.($i).'">'.$i.'</a></li>';

							}

						}

						echo '
						<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?p='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
					</ul>
					';

				}

				echo '
				<div class="reveal item-modal" id="InviteModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
					<form action="" method="POST">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								<div class="modal-title">Invite User to Group</div>
							</div>
							<div class="shrink cell no-margin">
								<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
							</div>
						</div>
						<div class="push-15"></div>
						<input type="text" class="normal-input" name="invite_username" placeholder="Username">
						<div class="push-25"></div>
						<div align="center">
							<input type="submit" class="button button-green store-button inline-block" name="invite_user_submit" value="Invite User">
							<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
							<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						</div>
					</form>
				</div>
				';

			}

			echo '
		</div>
		<div id="options" class="tabs-panel">
			<h5>Options</h5>
			<form action="" method="POST">
				<div class="container border-r md-padding">
					<div class="grid-x grid-margin-x">
						<div class="auto cell">
							<label for="JoinType"><strong>Join Type</strong></label>
							<select class="normal-input" name="join_type" id="JoinType">
								<option value="0"'; if ($gG->JoinType == 0) { echo ' selected'; } echo '>Public</option>
								<option value="1"'; if ($gG->JoinType == 1) { echo ' selected'; } echo '>Request to Join</option>
								<option value="2"'; if ($gG->JoinType == 2) { echo ' selected'; } echo '>Invite Only</option>
							</select>
							<div class="push-15"></div>
							<label for="TabNonMembers"><strong>Default Tab (Non-Members)</strong></label>
							<select class="normal-input" name="tab_nonmembers" id="TabNonMembers">
								<option value="1"'; if ($gG->NonMemberTab == 1) { echo ' selected'; } echo '>Home</option>
								<option value="2"'; if ($gG->NonMemberTab == 2) { echo ' selected'; } echo '>Members</option>
								<option value="3"'; if ($gG->NonMemberTab == 3) { echo ' selected'; } echo '>Divisions</option>
								<option value="4"'; if ($gG->NonMemberTab == 4) { echo ' selected'; } echo '>Store</option>
							</select>
							<div class="push-15"></div>
							<label for="TabMembers"><strong>Default Tab (Members)</strong></label>
							<select class="normal-input" name="tab_members" id="JoinType">
								<option value="1"'; if ($gG->MemberTab == 1) { echo ' selected'; } echo '>Home</option>
								<option value="2"'; if ($gG->MemberTab == 2) { echo ' selected'; } echo '>Members</option>
								<option value="3"'; if ($gG->MemberTab == 3) { echo ' selected'; } echo '>Divisions</option>
								<option value="4"'; if ($gG->MemberTab == 4) { echo ' selected'; } echo '>Store</option>
							</select>
							<div class="push-15"></div>
							<label for="GroupVault"><strong>Group Vault Display</strong></label>
							<select class="normal-input" name="group_vault" id="GroupVault">
								<option value="0"'; if ($gG->VaultDisplay == 0) { echo ' selected'; } echo '>Hidden</option>
								<option value="1"'; if ($gG->VaultDisplay == 1) { echo ' selected'; } echo '>Visible to Members only</option>
								<option value="2"'; if ($gG->VaultDisplay == 2) { echo ' selected'; } echo '>Visible to Public</option>
							</select>
						</div>
					</div>
				</div>
				';

				if ($gG->FlexOwnerID == $myU->ID) {

					echo '
					<div class="push-25"></div>
					<input type="submit" class="button button-green" name="options_save" value="Save" style="margin: 0 auto;">
					<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
					</form>
					<div class="push-25"></div>
					<h5>Abandon Group</h5>
					<div class="container border-r md-padding">
						<input type="button" class="button button-red" value="Abandon Group" data-open="AbandonGroupModal">
					</div>
					<div class="reveal item-modal" id="AbandonGroupModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
						<form action="" method="POST">
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">Abandon Group</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="push-15"></div>
							<div>Are you sure you wish to abandon your group? You will be removed from the group and <b>anyone</b> will be able to claim your group.<br />This action can not be undone.</div>
							<div class="push-25"></div>
							<div align="center">
								<input type="submit" class="button button-red store-button inline-block" name="abandon_group" value="Abandon Group">
								<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							</div>
						</form>
					</div>
					<div class="push-25"></div>
					<script>
						function switchOwnerType(Id) {
							if (Id == 1) {
								document.getElementById("new_owner_username").style.display = "block";
								document.getElementById("new_owner_group").style.display = "none";
							} else if (Id == 2) {
								document.getElementById("new_owner_username").style.display = "none";
								document.getElementById("new_owner_group").style.display = "block";
							}
						}
					</script>
					';

					$getOwnedGroups = $db->prepare("SELECT UserGroup.ID, UserGroup.Name FROM UserGroup WHERE UserGroup.ID != ".$gG->ID." AND UserGroup.OwnerID = ".$myU->ID." AND UserGroup.OwnerType = 0 ORDER BY UserGroup.MemberCount DESC");
					$getOwnedGroups->execute();

					echo '
					<h5>Change Ownership</h5>
					<div class="container border-r md-padding">
						<input type="button" class="button button-blue" value="Change Ownership" data-open="ChangeOwnershipModal">
					</div>
					<div class="reveal item-modal" id="ChangeOwnershipModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
						<form action="" method="POST">
							<div class="grid-x grid-margin-x align-middle">
								<div class="auto cell no-margin">
									<div class="modal-title">Change Ownership</div>
								</div>
								<div class="shrink cell no-margin">
									<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
								</div>
							</div>
							<div class="push-15"></div>
							<div>Please enter the username of the member or select which group you wish to change ownership of the group to. This action can not be undone.</div>
							<div class="push-15"></div>
							<select class="normal-input" name="new_owner_type" onchange="switchOwnerType(this.value)">
								<option value="1">User (Individual)</option>
								';

								if ($myU->VIP > 0 && $getOwnedGroups->rowCount() > 0) {

									echo '
									<option value="2">Group Entity</option>
									';

								}

								echo '
							</select>
							<div class="push-15"></div>
							<input type="text" class="normal-input" name="new_owner_username" id="new_owner_username" placeholder="Username">
							';

							if ($myU->VIP > 0 && $getOwnedGroups->rowCount() > 0) {

								echo '
								<select class="normal-input" name="new_owner_group" id="new_owner_group" style="display:none;">
									';

									while ($gO = $getOwnedGroups->fetch(PDO::FETCH_OBJ)) {
										echo '<option value="'.$gO->ID.'">'.$gO->Name.'</option>';
									}

									echo '
								</select>
								';

							}

							echo '
							<div class="push-25"></div>
							<div align="center">
								<input type="submit" class="button button-blue store-button inline-block" name="change_ownership" value="Change Ownership">
								<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
								<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							</div>
						</form>
					</div>
					';

				}

				echo '
			</div>
			<div id="vault" class="tabs-panel">
				<script>
				';

				if ($GroupRanks[$MemberRankNum][5] == 1) {

					$getTodayEarnings = $db->prepare("SELECT Coins, TransactionsCount FROM UserGroupDailyEarning WHERE GroupID = ".$gG->ID." AND TimeStart = UNIX_TIMESTAMP(CURDATE()) AND TimeEnd = UNIX_TIMESTAMP(DATE_ADD(CURDATE(),INTERVAL +1 DAY))");
					$getTodayEarnings->execute();

					$getYesterdayEarnings = $db->prepare("SELECT Coins, TransactionsCount FROM UserGroupDailyEarning WHERE GroupID = ".$gG->ID." AND TimeEnd = UNIX_TIMESTAMP(CURDATE())");
					$getYesterdayEarnings->execute();

					if ($getTodayEarnings->rowCount() == 0) {
						$TodayEarnings = 0;
						$TodaySales = 0;
					} else {
						$gT = $getTodayEarnings->fetch(PDO::FETCH_OBJ);
						$TodayEarnings = $gT->Coins;
						$TodaySales = $gT->TransactionsCount;
					}

					if ($getYesterdayEarnings->rowCount() == 0) {
						$YesterdayEarnings = 0;
						$YesterdaySales = 0;
					} else {
						$gY = $getYesterdayEarnings->fetch(PDO::FETCH_OBJ);
						$YesterdayEarnings = $gY->Coins;
						$YesterdaySales = $gY->TransactionsCount;
					}

					$ClothingCategory = (!isset($_GET['clothing_category']) && $_GET['clothing_category'] != 1 && $_GET['clothing_category'] != 2) ? 0 : $_GET['clothing_category'];
					$DBClothingCategory = ($ClothingCategory == 1) ? 5 : 6;
					$ClothingQuery = strip_tags($_GET['clothing_query']);

					if (isset($_GET['sales_page'])) {
						echo '
						window.onload = function() {
							$("#tabs").foundation("selectTab", "vault");
							$("#tabs_vault").foundation("selectTab", "sales");
						}
						';
						$jumped = 1;
					} else if (isset($_GET['earnings_page'])) {
						echo '
						window.onload = function() {
							$("#tabs").foundation("selectTab", "vault");
							$("#tabs_vault").foundation("selectTab", "earnings");
						}
						';
						$jumped = 1;
					} else if (isset($_GET['clothing_page']) || !empty($_GET['clothing_category']) || !empty($_GET['clothing_query'])) {
						echo '
						window.onload = function() {
							$("#tabs").foundation("selectTab", "vault");
							$("#tabs_vault").foundation("selectTab", "clothing");
						}
						';
						$jumped = 1;
					}
					echo '
					</script>
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<h4>Creator Area</h4>
						</div>
						<div class="shrink cell right no-margin">
							<button class="button button-green" type="button" data-toggle="dropdown">Create</button>
							<div class="dropdown-pane creator-area-dropdown" id="dropdown" data-dropdown data-hover="true" data-hover-pane="true">
								<ul>
									<li><a href="'.$serverName.'/groups/'.$gG->ID.'/create/shirt/">Create Shirt</a></li>
									<li><a href="'.$serverName.'/groups/'.$gG->ID.'/create/pants/">Create Pants</a></li>
								</ul>
							</div>
						</div>
						';

						if ($gG->CoinsVault > 0 && $gG->FlexOwnerID == $myU->ID) {

							echo '
							<div class="shrink cell right no-margin">
								<button class="button button-red" type="button" data-toggle="WithdrawVault" style="margin-left:15px;">Withdraw</button>
								<div class="reveal item-modal" id="WithdrawVault" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
									<form action="" method="POST">
										<div class="grid-x grid-margin-x align-middle">
											<div class="auto cell no-margin">
												<div class="modal-title">Withdraw from Group Vault</div>
											</div>
											<div class="shrink cell no-margin">
												<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
											</div>
										</div>
										<div class="push-15"></div>
										<label for="WithdrawAmount"><strong>Amount you wish to withdraw (Bits)</strong></label>
										<input type="text" class="normal-input" name="withdraw_amount">
										<div class="push-25"></div>
										<div align="center">
											<input type="submit" class="button button-green store-button inline-block" value="Withdraw">
											<input type="button" data-close class="button button-grey store-button inline-block" value="Go back">
											<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
										</div>
									</form>
								</div>
							</div>
							';

						}

						echo '
					</div>
					<div class="push-10"></div>
					<ul class="tabs grid-x grid-margin-x settings-tabs" data-tabs id="tabs_vault">
						<li class="no-margin tabs-title cell'; if (!isset($jumped)) { echo ' is-active'; } echo '" aria-selected="true"><a href="#dashboard">Dashboard</a></li>
						<li class="no-margin tabs-title cell"><a href="#sales">Sales</a></li>
						<li class="no-margin tabs-title cell"><a href="#earnings">Earnings</a></li>
						<li class="no-margin tabs-title cell"><a href="#clothing" class="no-right-border">Clothing</a></li>
					</ul>
					<div class="tabs-content" data-tabs-content="tabs_vault">
						<div id="dashboard" class="tabs-panel'; if (!isset($jumped)) { echo ' is-active'; } echo '">
							<div class="grid-x grid-margin-x">
								<div class="large-4 medium-4 small-6 cell">
									<div class="container border-r md-padding text-center">
										<div class="creator-area-info-title">Earnings Today</div>
										<div class="creator-area-info-info creator-area-info-price">'.number_format($TodayEarnings).' Bits</div>
										<div class="creator-area-trending trending-flat">
											';

											if ($TodayEarnings == 0 && $YesterdayEarnings == 0 || $TodayEarnings == $YesterdayEarnings) {

												echo '
												<i class="material-icons trending-flat">trending_flat</i><span class="trending-flat">+0 Bits (+0%) vs yesterday</span>
												';

											} else if ($YesterdayEarnings == 0 && $TodayEarnings > 0) {

												$Difference = $TodayEarnings - $YesterdayEarnings;

												echo '
												<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' Bits (+100%) vs yesterday</span>
												';

											} else if ($TodayEarnings > $YesterdayEarnings) {

												$Difference = $TodayEarnings - $YesterdayEarnings;
												$PercentChange = (($TodayEarnings - $YesterdayEarnings)/$YesterdayEarnings)*100;

												echo '
												<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' Bits (+'.number_format($PercentChange, 2).'%) vs yesterday</span>
												';

											} else if ($TodayEarnings < $YesterdayEarnings) {

												$Difference = $YesterdayEarnings - $TodayEarnings;
												if ($TodayEarnings > 0) {
													$PercentChange = (($YesterdayEarnings - $TodayEarnings)/$TodayEarnings)*100;
												} else {
													$PercentChange = '-100';
												}

												echo '
												<i class="material-icons trending-down">arrow_drop_down</i><span class="trending-down">-'.number_format($Difference).' Bits ('.number_format($PercentChange, 2).'%) vs yesterday</span>
												';

											}

											echo '
										</div>
									</div>
								</div>
								<div class="large-4 medium-4 small-6 cell">
									<div class="container border-r md-padding text-center">
										<div class="creator-area-info-title"># Of Sales Today</div>
										<div class="creator-area-info-info">'.number_format($TodaySales).'</div>
										<div class="creator-area-trending trending-flat">
										';

										if ($TodaySales == 0 && $YesterdaySales == 0 || $TodaySales == $YesterdaySales) {

											echo '
											<i class="material-icons trending-flat">trending_flat</i><span class="trending-flat">+0 Bits (+0%) vs yesterday</span>
											';

										} else if ($YesterdayEarnings == 0 && $TodayEarnings > 0) {

											$Difference = $TodaySales - $YesterdaySales;

											echo '
											<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' (+100%) vs yesterday</span>
											';

										} else if ($TodaySales > $YesterdaySales) {

											$Difference = $TodaySales - $YesterdaySales;
											$PercentChange = (($TodaySales - $YesterdaySales)/$YesterdaySales)*100;

											echo '
											<i class="material-icons trending-up">arrow_drop_up</i><span class="trending-up">+'.number_format($Difference).' (+'.number_format($PercentChange, 2).'%) vs yesterday</span>
											';

										} else if ($TodaySales < $YesterdaySales) {

											$Difference = $YesterdaySales - $TodaySales;
											if ($TodaySales > 0) {
												$PercentChange = (($YesterdaySales - $TodaySales)/$TodaySales)*100;
											} else {
												$PercentChange = '-100';
											}

											echo '
											<i class="material-icons trending-down">arrow_drop_down</i><span class="trending-down">-'.number_format($Difference).' ('.number_format($PercentChange, 2).'%) vs yesterday</span>
											';

										}

										echo '
										</div>
									</div>
									<div class="push-25"></div>
								</div>
								<div class="large-4 medium-4 small-12 cell">
									<div class="container border-r md-padding text-center">
										<div class="creator-area-info-title">Total Earnings</div>
										<div class="creator-area-info-info creator-area-info-price">'.number_format($gG->TotalEarningsCount).' Bits</div>
										<div class="creator-area-trending"><span class="trending-flat">#'.number_format($gG->TotalEarningsRank).' Globally</span></div>
									</div>
								</div>
							</div>
						</div>
						<div id="sales" class="tabs-panel">
							<h5>Sales</h5>
							<div class="container border-r md-padding">
								';

								if ($gG->SalesCount == 0) {

									echo 'No sales found. When your group sell things, logs will show here.';

								} else {

									$limit = 10;

									$pages = ceil($gG->SalesCount / $limit);

									$page = min($pages, filter_input(INPUT_GET, 'sales_page', FILTER_VALIDATE_INT, array(
										'options' => array(
											'default'   => 1,
											'min_range' => 1,
										),
									)));

									$offset = ($page - 1)  * $limit;
									if ($offset < 0) { $offset = 0; }

									$getSales = $db->prepare("SELECT Item.ID, Item.Name, Item.PreviewImage, (UTL.PreviousBalance-UTL.NewBalance) AS Amount, UTL.TimeTransaction, User.Username FROM UserTransactionLog AS UTL JOIN Item ON UTL.ReferenceID = Item.ID JOIN User ON UTL.UserID = User.ID WHERE UTL.EventID = 2 AND Item.CreatorID = ".$gG->ID." AND CreatorType = 1 ORDER BY UTL.TimeTransaction DESC LIMIT ? OFFSET ?");
									$getSales->bindValue(1, $limit, PDO::PARAM_INT);
									$getSales->bindValue(2, $offset, PDO::PARAM_INT);
									$getSales->execute();

									$i = 0;

									while ($gS = $getSales->fetch(PDO::FETCH_OBJ)) {

										$i++;

										if ($i > 1) {
											echo '<div class="creator-area-trans-divider"></div>';
										}

										echo '
										<div class="grid-x grid-margin-x align-middle creator-area-trans">
											<div class="shrink cell">
												<a href="'.$serverName.'/store/view/'.$gS->ID.'/"><div class="creator-area-trans-pic" style="background:url('.$cdnName . $gS->PreviewImage.') no-repeat;background-size:48px 48px;background-position: center center;"></div></a>
											</div>
											<div class="auto cell">
												<a href="'.$serverName.'/users/'.$gS->Username.'/">'.$gS->Username.'</a> purchased <a href="'.$serverName.'/store/view/'.$gS->ID.'/">'.$gS->Name.'</a> for <font class="coins-text">'.$gS->Amount.' Bits</font>
											</div>
											<div class="shrink cell right">
												'.date('m/d/Y g:iA', $gS->TimeTransaction).'
											</div>
										</div>
										';

									}

								}

								echo '
							</div>
							';

							if ($gG->SalesCount > 0 && $pages > 1) {

								echo '
								<div class="push-25"></div>
								<ul class="pagination" role="navigation" aria-label="Pagination">
									<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?sales_page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
									';

									for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

										if ($i <= $pages) {

											echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?sales_page='.($i).'">'.$i.'</a></li>';

										}

									}

									echo '
									<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?sales_page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
								</ul>
								';

							}

							echo '
						</div>
						<div id="earnings" class="tabs-panel">
							<h5>Earnings, by day</h5>
							<div class="container border-r md-padding">
								';

								if ($gG->EarningsCount == 0) {

									echo 'No results found.';

								} else {

									echo '
									<div class="grid-x grid-margin-x">
										<div class="large-5 medium-5 small-5 cell">
											<strong>Date</strong>
										</div>
										<div class="large-2 medium-2 small-2 cell">
											<strong># Of Sales</strong>
										</div>
										<div class="large-2 medium-2 small-2 cell">
											<strong>Gross</strong>
										</div>
										<div class="large-2 medium-2 small-2 cell">
											<strong>Final</strong>
										</div>
										<div class="large-1 medium-1 small-1 cell text-right">
											<strong>Status</strong>
										</div>
									</div>
									<div class="creator-area-trans-divider"></div>
									';

									$limit = 10;

									$pages = ceil($gG->EarningsCount / $limit);

									$page = min($pages, filter_input(INPUT_GET, 'earnings_page', FILTER_VALIDATE_INT, array(
										'options' => array(
											'default'   => 1,
											'min_range' => 1,
										),
									)));

									$offset = ($page - 1)  * $limit;
									if ($offset < 0) { $offset = 0; }

									$getEarnings = $db->prepare("SELECT Coins, TimeStart, TimeEnd, TransactionsCount, Status FROM UserGroupDailyEarning WHERE GroupID = ".$gG->ID." ORDER BY TimeEnd DESC LIMIT ? OFFSET ?");
									$getEarnings->bindValue(1, $limit, PDO::PARAM_INT);
									$getEarnings->bindValue(2, $offset, PDO::PARAM_INT);
									$getEarnings->execute();

									$i = 0;

									while ($gE = $getEarnings->fetch(PDO::FETCH_OBJ)) {

										$i++;

										if ($i > 1) {
											echo '<div class="creator-area-trans-divider"></div>';
										}

										switch ($gE->Status) {
											case 0:
												$Status = '-';
												break;
											case 1:
												$Status = '<div class="status-paid">Paid</div>';
												break;
											case 2:
												$Status = '<div class="status-held">Held</div>';
												break;
										}

										switch (true) {
											case $gE->Coins <= 500:
												$Bracket = '0';
												$Math = 1;
												break;
											case $gE->Coins <= 5000:
												$Bracket = '10';
												$Math = 0.9;
												break;
											case $gE->Coins <= 10000:
												$Bracket = '15';
												$Math = 0.85;
												break;
											case $gE->Coins <= 50000:
												$Bracket = '22.5';
												$Math = 0.775;
												break;
											case $gE->Coins > 50000:
												$Bracket = '30';
												$Math = 0.7;
												break;
										}

										echo '
										<div class="grid-x grid-margin-x">
											<div class="large-5 medium-5 small-5 cell">
												<span class="show-for-large">'.date('F dS, Y', $gE->TimeStart).'&nbsp;&dash;&nbsp;'.date('F dS, Y', $gE->TimeEnd).'</span>
												<span class="hide-for-large">'.date('m/d/Y', $gE->TimeStart).'&nbsp;&dash;&nbsp;'.date('m/d/Y', $gE->TimeEnd).'</span>
											</div>
											<div class="large-2 medium-2 small-2 cell">
												'.number_format($gE->TransactionsCount).'
											</div>
											<div class="large-2 medium-2 small-2 cell">
												<font class="coins-text">'.number_format($gE->Coins).' Bits</font>
											</div>
											<div class="large-2 medium-2 small-2 cell">
												<font class="coins-text">'.number_format((floor($gE->Coins*$Math))).' Bits</font> <font class="earnings-tax">(-'.$Bracket.'%)</font>
											</div>
											<div class="large-1 medium-1 small-1 cell text-right">
												'.$Status.'
											</div>
										</div>
										';

									}

								}

								echo '
							</div>
							';

							if ($gG->EarningsCount > 0 && $pages > 1) {

								echo '
								<div class="push-25"></div>
								<ul class="pagination" role="navigation" aria-label="Pagination">
									<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?earnings_page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
									';

									for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

										if ($i <= $pages) {

											echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?earnings_page='.($i).'">'.$i.'</a></li>';

										}

									}

									echo '
									<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/?earnings_page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
								</ul>
								';

							}

							echo '
						</div>
						<div id="clothing" class="tabs-panel">
						';

						$limit = 10;

						if ($ClothingCategory == 0) {
							$pages = ceil($gG->StoreCount / $limit);
							$ClothingCount = $gG->StoreCount;
						} else if (empty($ClothingQuery)) {
							$countCreations = $db->prepare("SELECT COUNT(*) FROM Item WHERE ItemType = ".$DBClothingCategory." AND CreatorID = ".$gG->ID." AND CreatorType = 1");
							$countCreations->execute();
							$ClothingCount = $countCreations->fetchColumn();
							$pages = ceil($ClothingCount / $limit);
						} else if (!empty($ClothingQuery)) {
							$countCreations = $db->prepare("SELECT COUNT(*) FROM Item WHERE ItemType = ".$DBClothingCategory." AND MATCH(Name) AGAINST(?) AND CreatorID = ".$gG->ID." AND CreatorType = 1");
							$countCreations->bindValue(1, $ClothingQuery, PDO::PARAM_STR);
							$countCreations->execute();
							$ClothingCount = $countCreations->fetchColumn();
							$pages = ceil($ClothingCount / $limit);
						}

						$page = min($pages, filter_input(INPUT_GET, 'clothing_page', FILTER_VALIDATE_INT, array(
							'options' => array(
								'default'   => 1,
								'min_range' => 1,
							),
						)));

						$offset = ($page - 1)  * $limit;
						if ($offset < 0) { $offset = 0; }

						echo '
							<h5>Clothing</h5>
							<div class="container border-r md-padding">
								';

								if ($ClothingCount == 0) {

									echo 'No results found.';

								} else {

									echo '
									<form action="" method="GET">
										<div class="grid-x grid-margin-x">
											<div class="shrink cell">
												<label for="clothing_category"><strong>Category</strong></label>
												<select name="clothing_category" class="normal-input clothing-input">
													<option value="0">All</option>
													<option value="1"'; if ($ClothingCategory == 1) { echo ' selected'; } echo '>Shirts</option>
													<option value="2"'; if ($ClothingCategory == 2) { echo ' selected'; } echo '>Pants</option>
												</select>
											</div>
											<div class="auto cell">
												<label for="clothing_query"><strong>Search</strong></label>
												<input type="text" name="clothing_query" class="normal-input clothing-input"'; if (!empty($ClothingQuery)) { echo ' value="'.$ClothingQuery.'"'; } echo '>
											</div>
											<div class="shrink cell">
												<label><strong>&nbsp;</strong></label>
												<input type="submit" class="button button-blue" value="Search">
											</div>
										</div>
										<input type="hidden" name="clothing_page" value="'.$page.'">
									</form>
									<div class="push-15"></div>
									<div class="grid-x grid-margin-x">
										<div class="large-1 medium-1 small-3 cell">
											<strong>Picture</strong>
										</div>
										<div class="large-3 medium-3 small-5 cell">
											<strong>Name</strong>
										</div>
										<div class="large-2 medium-2 small-2 cell text-center">
											<strong>Price</strong>
										</div>
										<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
											<strong>Views</strong>
										</div>
										<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
											<strong>Sales</strong>
										</div>
										<div class="large-2 medium-2 small-2 cell show-for-medium">
											<strong><span class="show-for-large">Last</span> Updated</strong>
										</div>
										<div class="large-2 medium-2 small-2 cell text-right">
											<strong>Actions</strong>
										</div>
									</div>
									<div class="creator-area-trans-divider"></div>
									';

									if ($ClothingCategory == 0) {
										$getCreations = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.PreviewImage AS Image, Item.Cost, Item.SaleActive, Item.NumberCopies, Item.ImpressionCount FROM Item WHERE CreatorID = ".$gG->ID." AND CreatorType = 1 ORDER BY TimeUpdated DESC LIMIT ? OFFSET ?");
										$getCreations->bindValue(1, $limit, PDO::PARAM_INT);
										$getCreations->bindValue(2, $offset, PDO::PARAM_INT);
										$getCreations->execute();
									} else if (empty($ClothingQuery)) {
										$getCreations = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.PreviewImage AS Image, Item.Cost, Item.SaleActive, Item.NumberCopies, Item.ImpressionCount FROM Item WHERE ItemType = ".$DBClothingCategory." AND CreatorID = ".$gG->ID." AND CreatorType = 1 ORDER BY TimeUpdated DESC LIMIT ? OFFSET ?");
										$getCreations->bindValue(1, $limit, PDO::PARAM_INT);
										$getCreations->bindValue(2, $offset, PDO::PARAM_INT);
										$getCreations->execute();
									} else if (!empty($ClothingQuery)) {
										$getCreations = $db->prepare("SELECT Item.ID, Item.ItemType, Item.Name, Item.TimeUpdated, Item.PreviewImage AS Image, Item.Cost, Item.SaleActive, Item.NumberCopies, Item.ImpressionCount FROM Item WHERE ItemType = ".$DBClothingCategory." AND MATCH(Name) AGAINST(?) AND CreatorID = ".$gG->ID." AND CreatorType = 1 ORDER BY TimeUpdated DESC LIMIT ? OFFSET ?");
										$getCreations->bindValue(1, $ClothingQuery, PDO::PARAM_STR);
										$getCreations->bindValue(2, $limit, PDO::PARAM_INT);
										$getCreations->bindValue(3, $offset, PDO::PARAM_INT);
										$getCreations->execute();
									}

									$i = 0;

									while ($gC = $getCreations->fetch(PDO::FETCH_OBJ)) {

										$i++;

										if ($i > 1) {
											echo '<div class="creator-area-trans-divider"></div>';
										}

										echo '
										<div class="grid-x grid-margin-x align-middle creator-area-trans">
											<div class="large-1 medium-1 small-3 cell text-center">
												<a href="'.$serverName.'/store/view/'.$gC->ID.'/"><div class="creator-area-trans-pic" style="background:url('.$cdnName . $gC->Image.') no-repeat;background-size:48px 48px;background-position: center center;"></div></a>
											</div>
											<div class="large-3 medium-3 small-5 cell">
												<a href="'.$serverName.'/store/view/'.$gC->ID.'/">'.$gC->Name.'</a>
												 - <font class="sub">('; if ($gC->ItemType == 5) { echo 'shirt'; } else { echo 'pants'; } echo ')</font>
												';

												if ($gC->SaleActive == 0) {
													echo ' - <font class="sub">(off sale)</font>';
												}

												echo '
											</div>
											<div class="large-2 medium-2 small-2 cell text-center">
												<font class="coins-text"><span>'.number_format($gC->Cost).'</span> <span class="show-for-medium">Bits</span></font>
											</div>
											<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
												'.number_format($gC->ImpressionCount).'
											</div>
											<div class="large-1 medium-1 small-1 cell text-center show-for-medium">
												'.number_format($gC->NumberCopies).'
											</div>
											<div class="large-2 medium-2 small-2 cell show-for-medium">
												'.date('m/d/Y g:iA', $gC->TimeUpdated).'
											</div>
											<div class="large-2 medium-2 small-2 cell text-right">
												<a href="'.$serverName.'/store/edit/'.$gC->ID.'/" class="button button-grey" style="color:#FFF;display:inline;">Edit</a>
											</div>
										</div>
										';

									}

								}

								echo '
							</div>
							';

							if ($gG->StoreCount > 0 && $pages > 1) {

								if ($ClothingCategory == 0 && empty($ClothingQuery)) {
									$Link = '?clothing_page=';
								} else {
									$Link = '?clothing_category='.$ClothingCategory.'&clothing_query='.$ClothingQuery.'&clothing_page=';
								}

								echo '
								<div class="push-25"></div>
								<ul class="pagination" role="navigation" aria-label="Pagination">
									<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/'.$Link . ($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
									';

									for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

										if ($i <= $pages) {

											echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/'.$Link . ($i).'">'.$i.'</a></li>';

										}

									}

									echo '
									<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups/'.$gG->ID.'/settings/'.$Link . ($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
								</ul>
								';

							}

							echo '
						</div>
					</div>
					';

				}

				echo '
			</div>
			</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
