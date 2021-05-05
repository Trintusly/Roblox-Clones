<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (!$AUTH) { $myU = new StdClass(); $myU->ID = -1; }
	$UserProfileCache = $cache->get($_GET['username'] . '_Profile');

	if (!$UserProfileCache) {

		$getUsers = $db->prepare("SELECT User.*, (SELECT SUM(Recurring) FROM UserProfileView WHERE TargetID = User.ID) AS ProfileViews, (SELECT COUNT(*) FROM BlockedUser WHERE (RequesterID = User.ID AND BlockedID = 0) OR (RequesterID = 0 AND BlockedID = User.ID)) AS BlockedStatus, (SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.UserID = 0 AND UserInventory.CanTrade = 1) AS MyNumCollectibles, (SELECT COUNT(*) FROM UserInventory JOIN Item ON UserInventory.ItemID = Item.ID WHERE (Item.IsCollectible = 1 OR Item.ItemType = 7) AND Item.TradeLock = 0 AND UserInventory.UserID = User.ID AND UserInventory.CanTrade = 1) AS UserNumCollectibles, UserGroup.ID AS FavoriteGroupID, UserGroup.Name AS FavoriteGroupName, UserGroup.SEOName AS FavoriteGroupSEOName, UserGroup.LogoStatus AS FavoriteGroupLogoStatus, UserGroup.LogoImage AS FavoriteGroupLogoImage, UserGroup.IsVerified AS FavoriteGroupIsVerified FROM User LEFT JOIN UserGroup ON User.FavoriteGroup = UserGroup.ID WHERE User.Username = ?");
		//$getUsers->bindValue(1, $_GET['username'], PDO::PARAM_INT);
		$getUsers->execute([$_GET["username"]]);
		if ($getUsers->rowCount() == 0) {
			header("Location: ".$serverName."/search/");
			die;
		}

		$gU = $getUsers->fetch(PDO::FETCH_OBJ);

		$getFriends = $db->prepare("SELECT User.Username, User.AvatarURL, User.PersonalStatus, User.TimeLastSeen FROM Friend JOIN User ON Friend.ReceiverID = User.ID WHERE Friend.SenderID = ".$gU->ID." AND Friend.Accepted = 1 ORDER BY Friend.TimeSent DESC LIMIT 6");
		$getFriends->execute();

		$getBadges = $db->prepare("SELECT Name, Image FROM UserBadge JOIN Achievement ON UserBadge.AchievementID = Achievement.ID WHERE UserBadge.UserID = ".$gU->ID." ORDER BY UserBadge.ID LIMIT 12");
		$getBadges->execute();

		$getGroups = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroup.SEOName, UserGroup.IsVerified, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName FROM UserGroupMember JOIN UserGroup ON UserGroupMember.GroupID = UserGroup.ID JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE UserGroupMember.UserID = ".$gU->ID." ORDER BY UserGroupMember.ID DESC LIMIT 6");
		$getGroups->execute();

		$getGames = $db->prepare("SELECT UserGame.ID, UserGame.Name, UserGame.SEOName, UserGame.Description, UserGame.ThumbnailMicro, UserGame.ThumbnailSuccess, UserGame.AdminLocked FROM game.UserGame WHERE UserGame.UserID = ".$gU->ID."");
		$getGames->execute();

		$cache->set($_GET['username'] . '_Profile', array('user' => $gU, 'friends' => array('count' => $getFriends->rowCount(), 'data' => $getFriends->fetchAll(PDO::FETCH_OBJ)), 'badges' => array('count' => $getBadges->rowCount(), 'data' => $getBadges->fetchAll(PDO::FETCH_OBJ)), 'groups' => array('count' => $getGroups->rowCount(), 'data' => $getGroups->fetchAll(PDO::FETCH_OBJ)), 'games' => array('count' => $getGames->rowCount(), 'data' => $getGames->fetchAll(PDO::FETCH_OBJ))), 60);
		$UserProfileCache = $cache->get($_GET['username'] . '_Profile');

	}

	$gU = $UserProfileCache['user'];
	if (empty($gU->ProfileViews)) { $gU->ProfileViews = 0; }
	$FriendCount = $gU->NumFriends;
	$FriendsWithUsers = 0;

	if ($AUTH) {

		if (isset($_SESSION['Search_RecordNextPage'])) {
			$logSearchHistory = $db->prepare("INSERT INTO UserSearchHistory (UserID, ContentType, ContentID, TimeSearch) VALUES(".$myU->ID.", 1, ".$gU->ID.", ".time().")");
			$logSearchHistory->execute();
			if ($logSearchHistory->rowCount() == 0) {
				$update = $db->prepare("UPDATE UserSearchHistory SET TimeSearch = ".time()." WHERE UserID = ".$myU->ID." AND ContentType = 1 AND ContentID = ".$gU->ID."");
				$update->execute();
			}
			unset($_SESSION['Search_RecordNextPage']);
			header("Location: ".$serverName . $_SERVER['REQUEST_URI']."");
			die;
		}

		if ($myU->ID != $gU->ID) {
			$checkProfileView = $db->prepare("SELECT COUNT(*) FROM UserProfileView WHERE UserID = ".$myU->ID." AND TargetID = ".$gU->ID."");
			$checkProfileView->execute();

			if ($checkProfileView->fetchColumn() == 0) {
				$insert = $db->prepare("INSERT INTO UserProfileView (UserID, TargetID, Recurring) VALUES(".$myU->ID.", ".$gU->ID.", 1)");
				$insert->execute();
			}

			else {
				$update = $db->prepare("UPDATE UserProfileView SET Recurring = Recurring + 1 WHERE UserID = ".$myU->ID." AND TargetID = ".$gU->ID."");
				$update->execute();
			}
		}

		$checkFriendStatus = $db->prepare("SELECT Accepted FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = ".$gU->ID."");
		$checkFriendStatus->execute();

		if ($checkFriendStatus->rowCount() == 0) {
			$FriendsWithUsers = 0;
		}
		else if ($checkFriendStatus->rowCount() > 0 && $checkFriendStatus->fetchColumn() == 1) {
			$FriendsWithUsers = 1;
		}
		else {
			$PendingType = 1;
			$FriendsWithUsers = 2;
		}

		if ($FriendsWithUsers == 0) {
			$checkFriendStatus = $db->prepare("SELECT Accepted FROM Friend WHERE SenderID = ".$gU->ID." AND ReceiverID = ".$myU->ID."");
			$checkFriendStatus->execute();

			if ($checkFriendStatus->rowCount() > 0 && $checkFriendStatus->fetchColumn() == 0) {
				$FriendsWithUsers = 2;
				$PendingType = 2;
			}
		}

		if (isset($_POST['report_user'])) {

			$_SESSION['Report_ReferenceType'] = 3;
			$_SESSION['Report_ReferenceID'] = $gU->ID;

			header("Location: ".$serverName."/report/");
			die;

		}

		if (isset($_POST['report_wall']) && !empty($_POST['wall_id'])) {

			$count = $db->prepare("SELECT ID FROM UserWall WHERE ID = ? AND UserID = ".$gU->ID."");
			$count->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
			$count->execute();

			if ($count->rowCount() > 0) {

				$_SESSION['Report_ReferenceType'] = 4;
				$_SESSION['Report_ReferenceID'] = $count->fetchColumn();

				header("Location: ".$serverName."/report/");
				die;

			}

		}

		if (isset($_POST['delete_wall']) && !empty($_POST['wall_id']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && ($gU->ID == $myU->ID || $myU->Admin > 0)) {

			$remove = $db->prepare("DELETE FROM UserWall WHERE ID = ? AND UserID = ".$gU->ID."");
			$remove->bindValue(1, $_POST['wall_id'], PDO::PARAM_INT);
			$remove->execute();

			header("Location: ".$serverName."/users/".$gU->Username."/");
			die;

		}

	}

	$UsernameHTML = '';

	$UsernameHTML .= '
	<div class="grid-x grid-margin-x align-middle">
		<div class="shrink cell no-margin">
			<div class="profile-username">
				'.$gU->Username.'
			</div>
		</div>
		<div class="auto cell no-margin">
		';

		if ($gU->InGame == 1) {
			$UsernameHTML .= '
			<span class="profile-ingame">Playing: <a href="'.$serverName.'/games/viewGame.php?GameId='.$gU->GameID.'">'.$gU->GameName.'</a></span>
			';
		} else if (($gU->TimeLastSeen+600) > time()) {
			$UsernameHTML .= '
			<span class="profile-online">ONLINE</span>
			';
		} else {
			$UsernameHTML .= '
			<span class="profile-offline">OFFLINE</span>
			';
		}

		if ($AUTH && $myU->ID != $gU->ID && $FriendsWithUsers == 1) {

			$checkFavorite = $db->prepare("SELECT COUNT(*) FROM FavoriteFriend WHERE UserID = ".$myU->ID." AND TargetID = ".$gU->ID."");
			$checkFavorite->execute();

			if ($checkFavorite->fetchColumn() == 0) {

				if (isset($_POST['favorite_user']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

					$insert = $db->prepare("INSERT INTO FavoriteFriend (UserID, TargetID) VALUES(".$myU->ID.", ".$gU->ID.")");
					$insert->execute();

					$cache->delete($myU->ID.'Cache_FavoriteFriends');

					header("Location: ".$serverName."/users/".$gU->Username."/");
					die;

				}

				$UsernameHTML .= '
				<form action="" method="POST" style="display:inline-block;">
					<form action="" method="POST" style="display:inline;"><span><button type="submit" name="favorite_user" class="group-favorite" title="Favorite user"><i class="material-icons">star_border</i></button><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></span></form>
				</form>
				';

			}

			else {

				if (isset($_POST['unfavorite_user']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

					$delete = $db->prepare("DELETE FROM FavoriteFriend WHERE UserID = ".$myU->ID." AND TargetID = ".$gU->ID."");
					$delete->execute();

					$cache->delete($myU->ID.'Cache_FavoriteFriends');

					header("Location: ".$serverName."/users/".$gU->Username."/");
					die;

				}

				$UsernameHTML .= '
				<form action="" method="POST" style="display:inline;"><span><button type="submit" name="unfavorite_user" class="group-favorite" title="Unfavorite user"><i class="material-icons">star</i></button><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></span></form>
				';

			}

		}

		$UsernameHTML .= '
		</div>
		<div class="shrink show-for-medium cell no-margin right">
			<div class="push-15 hide-for-large"></div>
			<div class="container border-r profile-info-box">
				<div class="number-stat">
					<span>'.shortNum($gU->NumGameVisits).'</span>
					Game Visits
				</div>
				<div class="number-stat">
					<span>'.shortNum($FriendCount).'</span>
					Friends
				</div>
				<div class="number-stat">
					<span>'.shortNum($gU->ProfileViews).'</span>
					Profile Views
				</div>
			</div>
		</div>
	</div>
	<div class="push-25 hide-for-medium"></div>
	';

	echo '
	<meta property="og:title" content="'.$gU->Username.'\'s Profile">
	<meta property="og:type" content="profile">
	<meta property="og:url" content="'.$serverName.'/users/'.$gU->Username.'/">
	<meta property="og:image" content="https://cdn.brickcreate.com/'.$gU->AvatarURL.'-thumb.png">
	<meta property="og:site_name" content="Brick Create">
	<meta property="og:description" content="'.$gU->Username.' is a player on Brick Create, a user generated content sandbox game with tens of thousands of active players. Play today!">
	<script src="https://twemoji.maxcdn.com/2/twemoji.min.js"></script>
	<script>
		document.title = "'.$gU->Username.' - Brick Create";

		';

		if ($AUTH) {

			echo '
			function Friend(method) {
				var http = new XMLHttpRequest();
				var url = "'.$serverName.'/users/'.$gU->Username.'/";
				var params = "friendchange=" + method + "&csrf_token='.$_SESSION['csrf_token'].'";
				http.open("POST", url, true);

				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				http.onreadystatechange = function() {
					if(http.readyState == 4 && http.status == 200) {
						window.location.assign("'.$serverName.'/users/'.$gU->Username.'/");
					}
				}
				http.send(params);
			}

			function TradeUser() {
				window.location.assign("'.$serverName.'/user/trade/'.$gU->Username.'/");
			}
			';

		}

		echo '
	</script>
	<div class="show-for-small-only">
		'.$UsernameHTML.'
	</div>
	';

	if (!empty($gU->PersonalStatus) && $gU->PersonalStatus != ' ') {

		echo '
		<div class="grid-x grid-margin-x">
			<div class="profile-speechBubble" style="width:auto;max-width:100%;">
				<div class="user-profile-status">
					<i class="fa fa-quote-left" style="color:#595E6E;"></i>
					<font style="padding:10px;font-weight:600;">'.$gU->PersonalStatus.'</font>
					<i class="fa fa-quote-right" style="color:#595E6E;"></i>
				</div>
			</div>
		</div>
		';

	}

	if (empty($gU->FavoriteGroupID)) {
		$AvatarContainerClassName = 'border-r';
	} else {
		$AvatarContainerClassName = 'avatar-container-br';
	}

	echo '
	<div class="grid-x grid-margin-x">
		<div class="profile-left medium-5 cell">
			<div class="container md-padding '.$AvatarContainerClassName.'">
			';

			if ($AUTH && $gU->Admin == 0 && $gU->ID != -1 && $myU->ID != $gU->ID) {

				echo '
				<form action="" method="POST" class="report-abuse-profileForm"><button class="report-abuse report-abuse-profile" name="report_user" title="Report user"></button></form>
				';

			}

			echo '
				<img src="'.$cdnName . $gU->AvatarURL.'.png" class="avatar-profile">
			</div>
			';

			if (!empty($gU->FavoriteGroupID)) {

				switch ($gU->FavoriteGroupLogoStatus) {
					case 0:
						$gU->FavoriteGroupLogoImage = 'pending.png';
						break;
					case 2:
						$gU->FavoriteGroupLogoImage = 'rejected.png';
						break;
				}

				echo '
				<div class="user-profile-main-group">
					<div class="grid-x grid-margin-x align-middle">
						<div class="shrink cell no-margin">
							<div class="up-main-group-logo" style="background:url('.$cdnName . $gU->FavoriteGroupLogoImage.');background-size:cover;">
							</div>
						</div>
						<div class="shrink cell no-margin">
							<a href="'.$serverName.'/groups/'.$gU->FavoriteGroupID.'/'.$gU->FavoriteGroupSEOName.'/" class="up-main-group-name">'.$gU->FavoriteGroupName.'</a>
							';

							if ($gU->FavoriteGroupIsVerified == 1) {
								echo '<img src="/assets/images/groups/verified-ico32x32.png" style="height:16px;width:16px;" title="This group is verified">';
							}

							echo '
						</div>
					</div>
				</div>
				';

			}

			echo '
			<div class="push-25"></div>
			';

			if ($AUTH && $myU->ID != $gU->ID) {

				if (isset($_POST['friendchange']) && $_POST['friendchange'] == 'add' && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $FriendsWithUsers == 0 && $gU->AccountRestricted != 1 && $gU->FriendRequestSettings == 0) {

					$db->beginTransaction();

					$addFriend = $db->prepare("INSERT INTO Friend (SenderID, ReceiverID, TimeSent, Accepted) VALUES(".$myU->ID.", ".$gU->ID.", ".time().", 0)");
					$addFriend->execute();

					$count = $db->prepare("SELECT COUNT(*) FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = ".$gU->ID." AND TimeSent = ".time()."");
					$count->execute();

					if ($count->fetchColumn() > 1) {
						$db->rollBack();
					}
					else {
						$db->commit();
					}

				}

				else if (isset($_POST['friendchange']) && $_POST['friendchange'] == 'cancel' && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $FriendsWithUsers == 2) {

					if ($PendingType == 1) {
						$removeFriend = $db->prepare("DELETE FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = ".$gU->ID."");
						$removeFriend->execute();
					}
					else if ($PendingType == 2) {
						$removeFriend = $db->prepare("DELETE FROM Friend WHERE SenderID = ".$gU->ID." AND ReceiverID = ".$myU->ID."");
						$removeFriend->execute();
					}

				}

				else if (isset($_POST['friendchange']) && $_POST['friendchange'] == 'remove' && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $FriendsWithUsers == 1) {

					$removeFriendOne = $db->prepare("DELETE FROM Friend WHERE SenderID = ".$myU->ID." AND ReceiverID = ".$gU->ID."");
					$removeFriendOne->execute();

					$deleteFavorite = $db->prepare("DELETE FROM FavoriteFriend WHERE UserID = ".$myU->ID." AND TargetID = ".$gU->ID."");
					$deleteFavorite->execute();

					$deleteFavorite = $db->prepare("DELETE FROM FavoriteFriend WHERE UserID = ".$gU->ID." AND TargetID = ".$myU->ID."");
					$deleteFavorite->execute();

					$removeFriendTwo = $db->prepare("DELETE FROM Friend WHERE SenderID = ".$gU->ID." AND ReceiverID = ".$myU->ID."");
					$removeFriendTwo->execute();

					$cache->delete($myU->ID.'Cache_FavoriteFriends');
					$cache->delete($gU->ID.'Cache_FavoriteFriends');

				}

				if ($gU->ID != -1 && $gU->BlockedStatus == 0) {

					if ($myU->ID != $gU->ID && $gU->AccountRestricted != 1 && ($gU->PrivateMessageSettings == 0 || $gU->PrivateMessageSettings == 1 && $FriendsWithUsers == 1)) {

						echo '
						<a href="'.$serverName.'/inbox/user/'.$gU->Username.'" class="button button-blue text-center"><i class="material-icons">message</i><span>Open Chat</span></a>
						<div class="push-15"></div>
						';
					}

					if ($FriendsWithUsers == 0 && $myU->ID != $gU->ID && $gU->AccountRestricted == 0 && ($gU->FriendRequestSettings == 0)) {
						echo '
						<a onclick="Friend(\'add\')" class="button button-green text-center"><i class="material-icons">add_box</i><span>Add as Friend</span></a>
						<div class="push-15"></div>
						';
					}

					else if ($FriendsWithUsers == 2) {
						echo '
						<a onclick="Friend(\'cancel\')" class="button button-grey text-center" title="Press to cancel"><i class="material-icons">access_time</i><span>Friend Request Pending</span></a>
						<div class="push-15"></div>
						';
					}

					else if ($FriendsWithUsers == 1) {
						echo '
						<a onclick="Friend(\'remove\')" class="button button-red text-center"><i class="material-icons">delete_forever</i><span>Remove Friend</span></a>
						<div class="push-15"></div>
						';
					}

					if (($gU->TradeSettings == 0 || $gU->TradeSettings == 1 && $FriendsWithUsers == 1) && $gU->MyNumCollectibles > 0 && $gU->UserNumCollectibles > 0 && $gU->AccountRestricted == 0) {
						echo '
						<a onclick="TradeUser()" class="button button-grey text-center"><i class="material-icons">swap_vert</i><span>Trade User</span></a>
						<div class="push-15"></div>
						';
					}

				}

				if ($gU->AccountRestricted == 1) {
					echo '
					<div class="container border-r sm-padding text-center" style="background-color:#711c1c;">
						<div class="profile-info-line">
							<span><i class="material-icons" style="color:#f5f5f5;line-height:1;">info_outline</i></span><span style="color:#f5f5f5;"><strong>This player has been suspended.</strong></span>
						</div>
					</div>
					<div class="push-15"></div>
					';
				}

			}

			else if (!$AUTH && $gU->AccountRestricted == 1) {
				echo '
					<div class="container border-r md-padding text-center" style="background-color:#711c1c;">
						<div class="profile-info-line">
							<span><i class="material-icons" style="color:#f5f5f5;line-height:1;">info_outline</i></span><span style="color:#f5f5f5;"><strong>This player has been suspended.</strong></span>
						</div>
					</div>
					<div class="push-15"></div>
				';
			}

			if (!empty($gU->About)) {

			echo '
			<h5>About</h5>
			<style>
			.profile-description {
				word-wrap: break-word;
				overflow-wrap: break-word;
			}
			</style>
			<div class="container border-r md-padding">
				<div class="profile-description">
					'.nl2br($gU->About).'
				</div>
			</div>
			<div class="push-25"></div>
			';

			}

			echo '
			<h5>Statistics</h5>
			<div class="container border-r md-padding">
				';

				if ($gU->VIP == 1) {

					echo '
					<div class="profile-info-line">
						<img src="https://cdn.brickcreate.com/assets/images/profile/01cf8ba45a61b55fc6ca8b1d48d0c8fa.svg" width="20">
						<span style="color:#A35305;font-weight:700;">Brick Builder</span>
					</div>
					';

				} else if ($gU->VIP == 2) {

					echo '
					<div class="profile-info-line">
						<img src="https://cdn.brickcreate.com/assets/images/profile/5e1495b296b08ba947fcd310bd8bbca4.svg" width="20">
						<span style="color:#A6A2A2;font-weight:700;">Planet Constructor</span>
					</div>
					';

				} else if ($gU->VIP == 3) {

					echo '
					<div class="profile-info-line">
						<img src="https://cdn.brickcreate.com/assets/images/profile/975289c5-1c07-46333ceweexc-dsbcf5-0b49d35c934hn.png" width="20">
						<span style="color:#cc34eb;font-weight:700;">Nitro Membership</span>
					</div>
					';

				}

				echo '
				<div class="profile-info-line">
					<i class="material-icons">access_time</i>
					<span>Last seen '.get_timeago($gU->TimeLastSeen).'</span>
				</div>
				<div class="profile-info-line">
					<i class="material-icons">date_range</i>
					<span>Joined '.date('F jS', $gU->TimeRegister).', '.date('Y', $gU->TimeRegister).'</span>
				</div>
				<div class="profile-info-line">
					<i class="material-icons">forum</i>
					<span>'.number_format($gU->NumForumPosts).' forum posts</span>
				</div>
			</div>
			<div class="push-25"></div>
			<div class="grid-x grid-margin-x align-middle">
				<div class="auto cell no-margin">
					<h5 style="margin:0;">Friends</h5>
				</div>
				<div class="shrink cell right no-margin">
					<a href="'.$serverName.'/user/'.$gU->Username.'/friends/" class="button button-grey" style="padding: 3px 15px;font-size:13px;line-height:1.25;">View All</a>
				</div>
			</div>
			<div class="push-10"></div>
			';

			if ($UserProfileCache['friends']['count'] > 0) {

				echo '
				<div class="container border-r">
					<div class="grid-x grid-margin-x align-middle">
					';

					foreach ($UserProfileCache['friends']['data'] as $gF) {

						$UserOnlineColor = ($gF->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
						$StatusSpan = '<span class="user-friend-online-status" style="background:#'.$UserOnlineColor.';"></span>';

						echo '
						<div class="large-4 medium-4 small-4 cell profile-friend text-center">
							<a href="'.$serverName.'/users/'.$gF->Username.'/">
								<div class="profile-friend-preview relative" style="background-image:url('.$cdnName . $gF->AvatarURL.'-thumb.png);background-size:cover;">
								'.$StatusSpan.'
								</div>
							</a>
							<a href="'.$serverName.'/users/'.$gF->Username.'/" title="'.$gF->Username.'">'.LimitTextByCharacters($gF->Username, 9).'</a>
						</div>
						';

					}

					echo '
					</div>
					<div class="push-15"></div>
				</div>
				';

			}

			else {

				echo '
				<div class="container border-r md-padding text-center">
					<i class="material-icons user-friends-icon">sentiment_dissatisfied</i>
					<div class="user-friends-msg"><strong>'.$gU->Username.'</strong> hasn\'t added any friends yet.</div>
					';

					if ($FriendsWithUsers == 0 && $myU->ID != $gU->ID && $gU->AccountRestricted != 1 && ($gU->FriendRequestSettings == 0) && $gU->ID != -1) {

						echo '<div class="user-friends-add"><a onclick="Friend(\'add\')">Send a friend request</a></div>';

					}

					echo '
				</div>
				';

			}

			echo '
			<div class="push-25"></div>
			<div class="grid-x grid-margin-x align-middle">
				<div class="auto cell no-margin">
					<h5 style="margin:0;">Groups'; if ($gU->NumGroups > 0) { echo ' ('.number_format($gU->NumGroups).')'; } echo '</h5>
				</div>
				<div class="shrink cell right no-margin">
					<a href="'.$serverName.'/user/'.$gU->Username.'/groups/" class="button button-grey" style="padding: 3px 15px;font-size:13px;line-height:1.25;">View All</a>
				</div>
			</div>
			<div class="push-10"></div>
			<div class="container border-r md-padding">
				';

				if ($UserProfileCache['groups']['count'] == 0) {

					echo'
					<div style="margin:0 auto;text-align:center;"><i class="material-icons" style="font-size:38px;">sentiment_dissatisfied</i></div>
					<div style="font-size:13px;text-align:center;"><b>'.$gU->Username.'</b> is not a member of any groups yet.</div>
					';

				} else {

					$i = 0;

					foreach ($UserProfileCache['groups']['data'] as $gG) {

						$i++;

						if ($i > 1) {
							echo '<div class="profile-groups-divider"></div>';
						}

						echo '
						<div class="grid-x grid-margin-x align-middle">
							<div class="shrink cell">
								<a href="'.$serverName.'/groups/'.$gG->ID.'/'.$gG->SEOName.'/">
									<div class="profile-group-preview" style="background:url('.$cdnName . $gG->LogoImage.');background-size:cover;position:relative;">
									';

									if ($gG->IsVerified == 1) { echo '<img src="/assets/images/groups/verified-ico32x32.png" style="height:20px;width:20px;position:absolute;bottom:0;right:0;" title="This group is verified">'; }

									echo '
									</div>
								</a>
							</div>
							<div class="auto cell">
								<a href="'.$serverName.'/groups/'.$gG->ID.'/'.$gG->SEOName.'/" style="color:#E3E3E3;font-weight:600;word-break:break-word;">
									'.$gG->Name.'
								</a>
							</div>
						</div>
						';

					}

				}

				echo '
			</div>
			<div class="push-25"></div>
		</div>
		<div class="profile-right medium-7 cell">
			<div class="show-for-medium">
				'.$UsernameHTML.'
			</div>
			<div class="push-25"></div>
			<style>
			.achievement-image-profile {
				vertical-align: top;
				width: 70px;
				height: 70px;
				display: inline-block;
				background-size: 70px 70px;
			}

			.inline-block {
				display: inline-block;
			}

			.panel {
				margin-bottom: 7px;
				padding: 10px;
				border-radius: 5px;
				background: #1E2024;
			}
			</style>
			';

			if ($UserProfileCache['badges']['count'] > 0) {
				echo '
				<h5>Achievements</h5>
				<div class="container border-r md-padding">
					<div class="grid-x grid-margin-x align-middle">
				';

				foreach ($UserProfileCache['badges']['data'] as $gB) {

					echo '
					<div class="large-2 medium-2 small-4 cell text-center">
						<div class="panel text-left inline-block achievement-card">
							<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" title="'.$gB->Name.'">
								<a href="/user/achievements/"><div class="achievement-image-profile" style="background-image:url('.$cdnName.'assets/images/profile/'.$gB->Image.'"></div></a>
							</span>
						</div>
					</div>
					';

				}

				echo'
					</div>
				</div>
				<div class="push-25"></div>
				';

			}

			echo '
			<ul class="tabs profile-tabs" data-tabs id="tabs">
				<li class="tabs-title is-active"><a href="#wall" aria-selected="true">WALL</a></li>
				<li class="tabs-title"><a href="#games">GAMES</a></li>
				<li><a href="'.$serverName.'/users/'.$gU->Username.'/backpack/" class="no-right-border">BACKPACK</a></li>
			</ul>
			<div class="tabs-content" data-tabs-content="tabs">
				<div id="wall" class="tabs-panel is-active">
					';

					if ($gU->ViewWallSettings == 0 || $AUTH && $gU->ViewWallSettings == 1 && $FriendsWithUsers == 1 || $myU->ID == $gU->ID) {

						if ($AUTH && ($gU->PostWallSettings == 0 || $AUTH && $gU->PostWallSettings == 1 && $FriendsWithUsers == 1 || $myU->ID == $gU->ID)) {

							if (isset($_POST['wall']) && isset($_SESSION['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $gU->ID != -1 && $gU->AccountRestricted != 1 && $myU->AccountVerified == 1) {

								$wall = htmlentities(strip_tags($_POST['wall']));

								if ($myU->UserFlood > time()) {

									$error = 'You are posting too fast, please wait <b>'.($myU->UserFlood - time()).'</b> more seconds before posting again.';

								} else if (strlen($wall) < 3 || strlen($wall) > 256) {

									$error = 'A wall post can only have 3-256 alphanumeric characters.';

								} else if (isProfanity($wall) == 1) {

									$error = 'One or more words in your post has triggered our profanity filter. Please update and try again.';

								} else {

									$db->beginTransaction();

									$updateFlood = $db->prepare("UPDATE User SET UserFlood = ".(time() + 35)." WHERE ID = ".$myU->ID."");
									$updateFlood->execute();

									$Insert = $db->prepare("INSERT INTO UserWall (UserID, PosterID, Post, TimePosted) VALUES(".$gU->ID.", ".$myU->ID.", ?, ".time().")");
									$Insert->bindValue(1, $wall, PDO::PARAM_STR);
									$Insert->execute();
									$PostID = $db->lastInsertId();

									$Count = $db->prepare("SELECT COUNT(*) FROM UserWall WHERE UserID = ".$gU->ID." AND PosterID = ".$myU->ID." AND Post = ? AND TimePosted = ".time()."");
									$Count->bindValue(1, $wall, PDO::PARAM_STR);
									$Count->execute();

									if ($Count->fetchColumn() > 1) {
										$db->rollBack();
									} else {
										$db->commit();
										$cache->delete($gU->Username.'_Profile');
									}

								}

							}

							if (isset($error)) {

								echo '
								<div class="error-message" style="border-radius:0;margin-top:15px;">
									<div>'.$error.'</div>
								</div>
								';

							}

						}

						echo '<div class="container border-wh md-padding">';

						if ($AUTH && ($gU->PostWallSettings == 0 || $AUTH && $gU->PostWallSettings == 1 && $FriendsWithUsers == 1 || $myU->ID == $gU->ID)) {

							echo '
							<script>
								var wall;
								window.onload = function() {
									wall = document.getElementById("wall-textarea");
								}

								function placeCaretAtEnd(el) {
									el.focus();
									if (typeof window.getSelection != "undefined"
											&& typeof document.createRange != "undefined") {
										var range = document.createRange();
										range.selectNodeContents(el);
										range.collapse(false);
										var sel = window.getSelection();
										sel.removeAllRanges();
										sel.addRange(range);
									} else if (typeof document.body.createTextRange != "undefined") {
										var textRange = document.body.createTextRange();
										textRange.moveToElementText(el);
										textRange.collapse(false);
										textRange.select();
									}
								}

								function copyTextarea() {
									//var decoded = $("<div/>").html(wall.innerHTML).text();
									wall.innerHTML.replace("<div>", "");
									wall.innerHTML.replace("</div>", "");
									document.getElementById("wall-hidden").value = wall.innerHTML;
									console.log(document.getElementById("wall-hidden").value);
								}

								function addToTextBox(name, description) {
									wall.innerHTML += `<img src="https://twemoji.maxcdn.com/2/72x72/` + name + `.png" style="width:16px;height:16px;">`;
									wall.focus();
									placeCaretAtEnd(wall);
								}
							</script>
							<h5>User Wall</h5>
							<a name="UserWall"></a>
							<form action="" method="POST" onsubmit="return copyTextarea()">
								<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
								<input type="hidden" name="wall" id="wall-hidden">
								<div class="normal-input wall-textarea" id="wall-textarea" style="'; if ($myU->AccountVerified == 0 || $gU->ID == -1 || $gU->AccountRestricted == 1) { echo'pointer-events:none;opacity:0.4;'; } echo'" contenteditable="true" autofocus onfocus="this.value = this.value;">'; if ($myU->AccountVerified == 0) { echo 'Please verify your account to post on this user\'s wall.'; } else if ($gU->ID == -1 OR $gU->AccountRestricted == 1) { echo'Sorry, you cannot post to this wall.'; } echo'</div>
								<div class="wall-options">
									<div class="grid-x grid-margin-x align-middle">
										<div class="auto cell no-margin">
											<div class="wall-option"'; if ($gU->ID != -1 && $gU->AccountRestricted != 1) {echo ' data-toggle="EmojiDropdown" aria-controls="EmojiDropdown" onclick="handleEmojiDropDown()"';}echo'><i class="material-icons">sentiment_satisfied</i></div>
											<div id="EmojiDropdown" class="emoji-dropdown" data-toggler data-animate="fade-in fade-out" style="display:none;z-index: 100;">
												<input type="text" class="normal-input emoji-search" oninput="functionSearch(this.value)" placeholder="Search">
												<div id="emojis-body" class="emojis-body"></div>
											</div>
										</div>
										<div class="shrink cell no-margin right">
											<input type="submit" value="Post" class="button button-green" '; if ($myU->AccountVerified == 0) { echo 'disabled'; } else if ($gU->ID == -1 || $gU->AccountRestricted == 1) { echo'title="Unable to post to this wall" disabled'; } echo'>
										</div>
									</div>
								</div>
							</form>
							';

						}



						$limit = 8;

						$pages = ceil($gU->NumWallPosts / $limit);

						$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
							'options' => array(
								'default'   => 1,
								'min_range' => 1,
							),
						)));

						$offset = ($page - 1)  * $limit;
						if ($offset < 0) { $offset = 0; }

						$getWall = $db->prepare("SELECT User.Username, User.TimeLastSeen, User.AvatarURL, User.Admin, UserWall.ID, UserWall.Post, UserWall.TimePosted FROM UserWall JOIN User ON UserWall.PosterID = User.ID WHERE UserWall.UserID = ".$gU->ID." ORDER BY UserWall.TimePosted DESC LIMIT ? OFFSET ?");
						$getWall->bindValue(1, $limit, PDO::PARAM_INT);
						$getWall->bindValue(2, $offset, PDO::PARAM_INT);
						$getWall->execute();

						while ($gW = $getWall->fetch(PDO::FETCH_OBJ)) {
							$gW->Post = str_replace("&amp;nbsp;", " ", $gW->Post);
							// Temporarily remove emojis so we can count normal characters
							$stripped_post = htmlentities(strip_tags($gW->Post));
							$stripped_post = preg_replace('/(?<=\[:).*?(?=:\])/', '', $stripped_post);
							$stripped_post = str_replace("[::]", "", $stripped_post);
							preg_match_all('/(?<=\[:).*?(?=:\])/', $gW->Post, $matches);
							foreach ($matches as $matchs) {
								foreach ($matchs as $match) {
									if ($match == '') {
										continue;
									}
									if (strlen($match) == 5 || strlen($match) == 4) {
										if (strlen($stripped_post) == 0) {
											$gW->Post = str_replace('[:'.$match.':]', '<img src="https://twemoji.maxcdn.com/2/72x72/'.$match.'.png" style="width:64px;height:64px;padding:5px 12px;vertical-align:middle;">', $gW->Post);
										}
										else {
											$gW->Post = str_replace('[:'.$match.':]', '<img src="https://twemoji.maxcdn.com/2/72x72/'.$match.'.png" style="width:20px;height:20px;padding:0 2px;vertical-align:middle;">', $gW->Post);
										}
									}
								}
							}

							$UserOnlineColor = ($gW->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
							$StatusSpan = '<span class="user-online-status no-margin" style="background:#'.$UserOnlineColor.';">&nbsp;</span>';
							$AdminSpan = ($gW->Admin > 0) ? '<span class="wall-admin-tag">(Admin)</span>' : NULL;

							echo '
							<div class="wall-post">
								<div class="wall-post-header">
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell no-margin">
											<a href="'.$serverName.'/users/'.$gW->Username.'/"><div style="background-image:url(https://cdn.brickcreate.com/975289c5-1c07-461c-baf5-0b49d35c933b-thumb.png);background-size:cover;" class="wall-post-avatar"></div></a>
										</div>
										<div class="auto cell no-margin">
											'.$StatusSpan.'
											<a href="'.$serverName.'/users/'.$gW->Username.'/" class="wall-post-username">'.$gW->Username.'</a>
											'.$AdminSpan.'
										</div>
										<div class="shrink cell no-margin right">
											<span class="wall-post-time">'.get_timeago($gW->TimePosted).'</span>
											';

											if ($AUTH) {

												echo '
												<span class="wall-settings" data-toggle="wall-'.$gW->ID.'-dropdown"><i class="material-icons">settings</i></span>
												<div class="dropdown-pane creator-area-dropdown" id="wall-'.$gW->ID.'-dropdown" data-dropdown data-hover="true" data-hover-pane="true">
												';

												if ($AUTH && $gU->ID == $myU->ID || $AUTH && $myU->Admin > 0) {

													echo '
													<ul>
														<li><form action="" method="POST"><button type="submit" name="delete_wall">Delete Post</button><input type="hidden" name="wall_id" value="'.$gW->ID.'"><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></form></li>
													</ul>
													<div class="creator-area-dropdown-divider"></div>
													';

												}

												echo '
												<ul>
													<li><form action="" method="POST"><button type="submit" name="report_wall">Report Post</button><input type="hidden" name="wall_id" value="'.$gW->ID.'"><input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'"></form></li>
												</ul>
												</div>
												';

											}

										echo '
										</div>
									</div>
								</div>
								<div class="wall-post-main">
									'.nl2br($gW->Post).'
								</div>
							</div>
							';

						}

						echo '
						</div>
						';

						if ($pages > 1) {

							echo '
							<div class="push-25"></div>
							<ul class="pagination" role="navigation" aria-label="Pagination">
								<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/users/'.$gU->Username.'/?page='.($page-1).'#UserWall">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
								';

								for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

									if ($i <= $pages) {

										echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/users/'.$gU->Username.'/?page='.($i).'#UserWall">'.$i.'</a></li>';

									}

								}

								echo '
								<li class="pagination-next'; if ($page == $pages) { echo ' disabled'; } echo '" aria-label="Next page"><a href="'.$serverName.'/users/'.$gU->Username.'/?page='.($page+1).'#UserWall">Next <span class="show-for-sr">page</span></a></li>
							</ul>
							';

						}

					}

					echo '
				</div>
				<div id="games" class="tabs-panel">
					';

					if ($UserProfileCache['games']['count'] > 0) {

						echo '
						<script>
							var openDivs = [1];
							function toggleDiv(id) {
								$display = $("#game" + id).css("display");
								if ($display == "block") {
									$game = $("#game" + id);
									$game.slideToggle(500);
									openDivs.splice(i, 1);
								}
								else {
									for (var i=0, len = openDivs.length; i < len; i++) {
										$game = $("#game" + openDivs[i]);
										$game.slideToggle(500);
										openDivs.splice(i, 1);
									}
									$game = $("#game" + id);
									$game.slideToggle(500);
									openDivs.push(id);
								}
							}
						</script>
						';

						$i = 0;

						foreach ($UserProfileCache['games']['data'] as $gG) {

							$i++;

							$ThumbnailImg = ($gG->ThumbnailSuccess == 1 && $gG->AdminLocked == 0 && !empty($gG->ThumbnailMicro)) ? 'game/thumbnails/'.$gG->ThumbnailMicro : 'game-rejected-micro.png';

							echo '
							<div class="games-parent">
								<div class="games-header'; if ($i > 1) { echo ' games-header-remove-border'; } echo '" onclick="toggleDiv('.$gG->ID.')">'.$gG->Name.'</div>
								<div class="games-content" id="game'.$gG->ID.'"'; if ($i > 1) { echo ' style="display:none;"'; } echo '>
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell">
											<a href="'.$serverName.'/games/'.$gG->ID.'/'.$gG->SEOName.'/"><div style="width:256px;height:256px;background-color:#17171C;background-image:url('.$cdnName . $ThumbnailImg.');background-size:cover;"></div></a>
										</div>
										<div class="auto cell">
											<div class="grid-x grid-margin-x">
												<div class="shrink cell no-margin">
													<a href="'.$serverName.'/games/edit/'.$gG->ID.'" class="games-header-text">'.$gG->Name.'</a>
												</div>
												';
												if ($gU->ID == $myU->ID) {
													echo '
													<div class="shrink cell no-margin">
														<a href="'.$serverName.'/games/edit/'.$gG->ID.'" class="my-profile-game-settings"><i class="material-icons">settings</i></a>
													</div>
													';
												}
												echo '
											</div>
											<div class="games-creator-text">Created by: <a href="'.$serverName.'/users/'.$gU->Username.'/">'.$gU->Username.'</a></div>
											<div class="games-divider"></div>
											<div class="games-description-text">'.LimitTextByCharacters($gG->Description, 128).'</div>
											<div class="games-divider"></div>
											';

											if ($AUTH) {

												echo '
												<script>
												function playGame() {
													$.get("'.$serverName.'/API/Engine/generateGameAuthToken.php?gameId='.$gG->ID.'", function(res, status) {
														var token = res.token;
														window.location.assign("Brick Create:Client_" + token);
													});
												}
												</script>
												';

												if ($gG->AdminLocked == 0) {
													echo '
													<a onclick="playGame()" class="button button-green games-play-button">Play</a>
													';
												}

												if ($gU->ID == $myU->ID) {

													echo '
													<script>
													function editWorkshop() {
														$.get("'.$serverName.'/API/Engine/generateGameAuthToken.php?gameId='.$gG->ID.'", function(res, status) {
															var token = res.token;
															window.location.assign("Brick Create:Workshop_" + token);
														});
													}
													</script>
													&nbsp;&nbsp;<a onclick="editWorkshop()" class="button button-blue games-play-button">Edit in Workshop</a>
													';

												}

											}

											echo '
										</div>
									</div>
								</div>
							</div>
							';

						}

					} else {

						echo '
						<div class="container md-padding text-center">
							<div class="user-games-icon"><i class="material-icons">games</i></div>
							<div class="user-games-msg">This user does not have any games.</div>
						</div>
						';

					}

					echo '
				</div>
			</div>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
