<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");
?>
<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">
	<head>
		<title>Brick Create</title>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Brick Create is a user generated content sandbox game with tens of thousands of active players. Play today!">
		<meta name="keywords" value="BrickCreate, Brick Create, brick game, create game">
		<meta name="author" content="BrickCreate Inc.">
		<link rel="stylesheet" href="<?=$serverName?>/assets/css/foundation.css?r=2">
		<link rel="stylesheet" href="<?=$serverName?>/assets/css/<?=$CSSFile?>">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="<?=$serverName?>/assets/css/font-awesome.min.css" rel="stylesheet">
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-78458167-1', 'auto');
		  ga('send', 'pageview');

		</script>
		<script src="<?=$serverName?>/assets/js/vendor/jquery.js"></script>
		<?php if ($DisplayAds == true) echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>'; ?>
		<?php if ($AUTH) echo '<input type="hidden" id="csrf_token" value="'.$_SESSION['csrf_token'].'">'; ?>
	</head>
	<body>
	<div class="site-wrap">
	<?php
		$page = !isset($page) ? 'none' : $page;

		echo '
		<div class="top-bar">
			<div class="top-bar-left">
				<div class="grid-x align-middle grid-margin-x">
					<div class="shrink cell hide-for-large">
						<button class="menu-icon sidebar-menu-icon" type="button" data-toggle="side-bar"></button>
					</div>
					<div class="shrink cell menu-logo">
						<a href="'.$serverName.'">
							<img src="https://i.imgur.com/IudLQky.png" class="show-for-large" width="175" height="18">
							<img src="'.$cdnName.'assets/images/bp-headerBrandLogo1.png" class="hide-for-large" style="height:30px;">
						</a>
					</div>
					<div class="auto cell no-margin">
						<input type="text" class="menu-search" id="menu-search" placeholder="Search" onkeyup="searchSite(this.value)">
						<div class="search-dropdown-parent">
							<div id="search-dropdown" class="search-dropdown fast" data-toggler data-animate="fade-in fade-out" style="display:none;z-index: 100;">
								<div id="show-recent">
								';

								if ($AUTH) {

									if (!$cache->get($myU->ID.'SearchHistory')) {

										$getUserSearchHistory = $db->prepare("
											SELECT
												USH.ContentType,
												USH.ContentID,
												CASE
													WHEN USH.ContentType = 0 THEN UserGame.Thumbnail
													WHEN USH.ContentType = 1 THEN CONCAT(User.AvatarURL, '-thumb.png')
													WHEN USH.ContentType = 2 THEN Item.PreviewImage
													WHEN USH.ContentType = 3 THEN UserGroup.LogoImage
												END AS Image,
												CASE
													WHEN USH.ContentType = 0 THEN UserGame.Name
													WHEN USH.ContentType = 1 THEN User.Username
													WHEN USH.ContentType = 2 THEN Item.Name
													WHEN USH.ContentType = 3 THEN UserGroup.Name
												END AS Name
											FROM UserSearchHistory AS USH
												JOIN game.UserGame ON UserGame.ID = CASE WHEN USH.ContentType != 0 THEN 1 ELSE USH.ContentID END
												JOIN User ON User.ID = CASE WHEN USH.ContentType != 1 THEN 1 ELSE USH.ContentID END
												JOIN Item ON Item.ID = CASE WHEN USH.ContentType != 2 THEN 1 ELSE USH.ContentID END
												JOIN UserGroup ON UserGroup.ID = CASE WHEN USH.ContentType != 3 THEN 1 ELSE USH.ContentID END
											WHERE USH.UserID = ".$myU->ID."
											ORDER BY USH.TimeSearch DESC LIMIT 8
										");
										$getUserSearchHistory->execute();

										$cache->set($myU->ID.'SearchHistory', $getUserSearchHistory->fetchAll(PDO::FETCH_OBJ), 600);
										$cache->set($myU->ID.'SearchHistoryCount', $getUserSearchHistory->rowCount(), 600);

									}

									$SearchHistory = $cache->get($myU->ID.'SearchHistory');
									$SearchHistoryCount = $cache->get($myU->ID.'SearchHistoryCount');

									if ($SearchHistoryCount > 0) {

										echo '
										<div class="search-dropdown-title">RECENT SEARCHES</div>
										<ul>
											';

											foreach ($SearchHistory as $gS) {

												switch ($gS->ContentType) {
													case 0:
														$URL = '/games/view/'.$gS->ContentID.'/'; # To change, depending on final URL link
														break;
													case 1:
														$URL = '/users/'.$gS->Name.'/';
														break;
													case 2:
														$URL = '/store/view/'.$gS->ContentID.'/';
														break;
													case 3:
														$URL = '/groups/'.$gS->ContentID.'/'.str_replace(' ', '-', $gS->Name).'/';
														break;
												}

												echo '
												<li>
													<a href="'.$serverName . $URL.'">
														<div class="grid-x grid-margin-x align-middle">
															<div class="shrink cell no-margin">
																<span><img src="'.$cdnName . $gS->Image .'"></span>
															</div>
															<div class="auto cell no-margin">
																<span class="name">'.$gS->Name.'</span>
															</div>
															<div class="shrink cell no-margin right">
																<span class="name"><i class="material-icons">chevron_right</i></span>
															</div>
														</div>
													</a>
												</li>
												';

											}

											echo '
										</ul>
										';

									} else {

										echo '<div style="padding:5px 15px;">Search by username, games, store items, and groups</div>';

									}

								}

								echo '
								</div>
								<div id="search-dropdown-content"></div>
							</div>
						</div>
					</div>
					<div class="shrink cell">
						<ul class="menu align-middle">
							';
							if (!$AUTH) {
								echo '
								<li class="menu-login show-for-medium">
									<div class="menu-log-in">
										<a href="'.$serverName.'/log-in/">Log In</a>
									</div>
								</li>
								<li class="menu-createaccount show-for-medium">
									<div class="menu-create-account">
										<a href="'.$serverName.'/sign-up/">Create Account</a>
									</div>
								</li>
								';
							} else if ($AUTH) {
								echo '
								<li class="menu-link show-for-medium">
									<a data-toggle="user-notifications">
										<span class="icon relative">
											<i class="material-icons">notifications_none</i>
											';
											if ($myU->NumNotifications > 0) {
												echo '<div class="notification-badge badge-header" id="notifications-count">'.shortNum($myU->NumNotifications).'</div>';
											} else {
												echo '<div class="notification-badge badge-header" id="notifications-count" style="display:none;">0</div>';
											}
											echo '
										</span>
									</a>
								</li>
								<li class="menu-link">
									<a title="'.number_format($myU->CurrencyCredits).' Credits" href="'.$serverName.'/upgrade/credits">
										<span class="icon"><img src="'.$serverName.'/assets/images/credits-sm.png" width="20"></span>
										<span class="show-for-medium">'.number_format($myU->CurrencyCredits).'</span>
										<span class="show-for-small-only">'.shortNum($myU->CurrencyCredits).'</span>
									</a>
								</li>
								<li class="menu-link">
									<a title="'.number_format($myU->CurrencyCoins).' Bits" href="'.$serverName.'/upgrade/bits">
										<span class="icon"><img src="'.$serverName.'/assets/images/bits-sm.png" width="20"></span>
										<span class="show-for-medium">'.number_format($myU->CurrencyCoins).'</span>
										<span class="show-for-small-only">'.shortNum($myU->CurrencyCoins).'</span>
									</a>
								</li>
								<li class="menu-link avatar-preview">
									<a data-toggle="user-dropdown-all"><div class="menu-avatar-preview-thumbnail" style="background-image:url(https://cdn.brickcreate.com/975289c5-1c08-463c-bdf5-0b49d35c933b.png);background-size:cover;"></div></a>
								</li>
								';
							}
							echo '
						</ul>
					</div>
				</div>
			</div>
		</div>
		';

		if ($AUTH) {

			echo '
			<!-- User Dropdown -->
			<div id="user-dropdown-all" data-toggler data-animate="fade-in fade-out" style="display:none;z-index: 100;" class="fast">
				<i class="material-icons user-dropdown-arrow">arrow_drop_up</i>
				<div class="user-dropdown" id="user-dropdown">
					<div class="dropdown-header">
						<div class="grid-x align-middle grid-margin-x">
							<div class="shrink cell no-margin">
								<div class="avatar-preview-thumbnail" style="background-image:url(https://cdn.brickcreate.com/975289c5-1c07-461c-baf5-0b49d35c933b-thumb.png);background-size:cover;"></div>
							</div>
							<div class="auto cell">
								<div class="dropdown-username"><a href="'.$serverName.'/users/'.$myU->Username.'/">'.$myU->Username.'</a></div>
							</div>
						</div>
					</div>
					<div class="dropdown-body">
						<ul>
							<li><a href="'.$serverName.'/users/'.$myU->Username.'/">Profile</a></li>
							<li><a href="'.$serverName.'/account/character/">Character</a></li>
						</ul>
						<div class="ddivider"></div>
						<ul>
							<li><a href="'.$serverName.'/account/settings/">Settings</a></li>
							<li><a href="'.$serverName.'/account/logout/">Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="user-notifications" data-toggler data-animate="fade-in fade-out" style="display:none;z-index: 100;" class="fast">
				<i class="material-icons user-notifications-arrow">arrow_drop_up</i>
				<div class="user-notifications">
					<div class="user-notifications-header">
						<div class="grid-x grid-margin-x align-middle">
							<div class="auto cell no-margin">
								Notifications
							</div>
							<div class="shrink cell no-margin right">
								<a href="'.$serverName.'/inbox/notifications">See All</a>
							</div>
						</div>
					</div>
					<div class="user-chat-row-divider"></div>
					<div id="user-notifications-html">
						';
						if ($myU->NumNotifications == 0) {
							echo '
							<div class="user-notifications-none">
								<i class="material-icons">notifications_none</i>
								<span>You have no unread notifications.</span>
							</div>
							';
						}
						echo '
					</div>
					<div class="push-5"></div>
				</div>
			</div>
			';

		}

		/* Side Bar Code */

		$MobileDesktopHTML = '';

		$MobileDesktopHTML .= '
		<ul>
			<li><a href="'.$serverName.'/games/"'; if ($page == 'games') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">games</i><span>Games</span></a></li>
			<li><a href="'.$serverName.'/store/"'; if ($page == 'store') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">store</i><span>Store</span></a></li>
			<li><a href="'.$serverName.'/groups/"'; if ($page == 'groups') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">group</i><span>Communities</span></a></li>
			<li><a href="'.$serverName.'/forum/"'; if ($page == 'forum') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">forum</i><span>Forum</span></a></li>
			';
			if ($AUTH) {
				$MobileDesktopHTML .= '
				<li><a href="'.$serverName.'/creator-area/"'; if ($page == 'creator-area') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">insert_photo</i><span>Creations</span></a></li>
				<li><a href="'.$serverName.'/account/my-money"'; if ($page == 'creator-area') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">monetization_on</i><span>Money</span></a></li>
				<li><a href="'.$serverName.'/upgrade/"'; if ($page == 'upgrade') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">shopping_basket</i><span>Upgrades</span></a></li>
				';
			}
			echo '
		</ul>
		';

		if ($AUTH) {

			$MobileDesktopHTML .= '
			<div class="sbdivider"></div>
			<ul>
				<li>
					<a href="'.$serverName.'/inbox"'; if ($page == 'inbox') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '>
						<i class="material-icons">inbox</i><span>Inbox</span>
						'; if ($myU->NumChats > 0) { $MobileDesktopHTML .= '<span class="right">'.number_format($myU->NumChats).'</span>'; } $MobileDesktopHTML .= '
					</a>
				</li>
				<li><a href="'.$serverName.'/account/friends/"'; if ($page == 'friends') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">person_add</i><span>Friends</span>'; if ($myU->NumFriendRequests > 0) { $MobileDesktopHTML .= '<span class="right">'.number_format($myU->NumFriendRequests).'</span>'; } $MobileDesktopHTML .= '</a></li>
				<li><a href="'.$serverName.'/account/trades/"'; if ($page == 'trades') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '><i class="material-icons">swap_vert</i><span>Trades</span>'; if ($myU->NumTradeRequests > 0) { $MobileDesktopHTML .= '<span class="right">'.number_format($myU->NumTradeRequests).'</span>'; } $MobileDesktopHTML .= '</a></li>
			</ul>
			';

			if (!$cache->get($myU->ID.'Cache_FavoriteFriends')) {
				$getFavoriteFriends = $db->prepare("SELECT User.Username, User.TimeLastSeen, User.AvatarURL FROM FavoriteFriend JOIN User ON FavoriteFriend.TargetID = User.ID WHERE FavoriteFriend.UserID = ".$myU->ID."");
				$getFavoriteFriends->execute();
				$cache->set($myU->ID.'Cache_FavoriteFriends', $getFavoriteFriends->fetchAll(PDO::FETCH_OBJ), 300);
				$cache->set($myU->ID.'Cache_FavoriteFriends_Count', $getFavoriteFriends->rowCount(), 300);
			}

			$getFavoriteFriends = $cache->get($myU->ID.'Cache_FavoriteFriends');
			$getFavoriteFriendsCount = $cache->get($myU->ID.'Cache_FavoriteFriends_Count');

			if ($getFavoriteFriendsCount > 0) {

				$MobileDesktopHTML .= '
				<div class="sbdivider"></div>
				<div class="sbtitle">FRIENDS</div>
				<ul>
				';

				foreach ($getFavoriteFriends as $gF) {

					$UserOnlineColor = (($gF->TimeLastSeen + 600) > time()) ? '56A902' : 'AAAAAA';
					$StatusSpan = '<span class="user-friend-activity-status" style="background:#'.$UserOnlineColor.';"></span>';

					$MobileDesktopHTML .= '
					<li>
						<a href="'.$serverName.'/users/'.$gF->Username.'/" title="'.$gF->Username.'"'; if ($_SERVER['REQUEST_URI'] == '/users/'.$gF->Username.'/') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '>
							<div class="user-avatar relative" style="background-image:url('.$cdnName . $gF->AvatarURL.'-thumb.png);background-size:cover;">
							'.$StatusSpan.'
							</div>
							'.LimitTextByCharacters($gF->Username, 16).'
						</a>
					</li>
					';

				}

				$MobileDesktopHTML .= '</ul>';

			}

			if (!$cache->get($myU->ID.'Cache_Groups')) {
				$getFavoriteGroups = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroup.SEOName, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroupMember.IsFavorite FROM UserGroup JOIN UserGroupMember ON UserGroup.ID = UserGroupMember.GroupID WHERE UserGroupMember.UserID = ".$myU->ID." AND UserGroup.IsDisabled = 0 ORDER BY UserGroupMember.IsFavorite DESC, UserGroupMember.ID DESC");
				$getFavoriteGroups->execute();
				$cache->set($myU->ID.'Cache_Groups', $getFavoriteGroups->fetchAll(PDO::FETCH_OBJ), 300);
				$cache->set($myU->ID.'Cache_Groups_Count', $getFavoriteGroups->rowCount(), 300);
			}

			$getFavoriteGroups = $cache->get($myU->ID.'Cache_Groups');
			$getFavoriteGroupsCount = $cache->get($myU->ID.'Cache_Groups_Count');

			if ($getFavoriteGroupsCount > 0) {

				$MobileDesktopHTML .= '
				<div class="sbdivider"></div>
				<div class="sbtitle">GROUPS</div>
				<ul>
				';

				foreach ($getFavoriteGroups as $gF) {

					$MobileDesktopHTML .= '
					<li>
						<a href="'.$serverName.'/groups/'.$gF->ID.'/'.$gF->SEOName.'/" title="'.$gF->Name.'"'; if ($_SERVER['REQUEST_URI'] == '/groups/'.$gF->ID.'/'.$gF->SEOName.'/') { $MobileDesktopHTML .= ' class="active"'; } $MobileDesktopHTML .= '>
							<div class="user-avatar relative" style="background-image:url('.$cdnName . $gF->LogoImage.');background-size:cover;">
							';

							if ($gF->IsFavorite == 1) {

								$MobileDesktopHTML .= '<i class="material-icons favorite-group-icon">star</i>';

							}

							$MobileDesktopHTML .= '
							</div>
							<span>'.LimitTextByCharacters($gF->Name, 16).'</span>
						</a>
					</li>
					';

				}

				$MobileDesktopHTML .= '</ul>';

			}

		}

		/* End Side Bar Code */

		echo '
		<div class="top-bar-push"></div>
		<div class="grid-x grid-margin-x">
			<div class="sidebar-shrink shrink cell no-margin">
				<!-- Mobile / Tablet -->
				<div class="side-bar hide-for-large" id="side-bar" data-toggler data-animate="fade-in fade-out" style="display:none;">
					<div class="side-bar-inner">
						';
						if (!$AUTH) {
							echo '
							<ul class="hide-for-medium">
								<li><a href="'.$serverName.'/log-in/"'; if ($page == 'log-in') { echo ' class="active"'; } echo '><i class="material-icons">person</i><span>Log In</span></a></li>
								<li><a href="'.$serverName.'/sign-up/"'; if ($page == 'sign-up') { echo ' class="active"'; } echo '><i class="material-icons">person_add</i><span>Create Account</span></a></li>
							</ul>
							<div class="sbdivider hide-for-medium"></div>
							';
						}
						echo '
						'.$MobileDesktopHTML.'
					</div>
				</div>
				';

				if (!$AUTH && $_SERVER['SCRIPT_NAME'] != '/index.php' || $AUTH) {

				echo '
				<!-- Desktop -->
				<div class="side-bar show-for-large" id="side-bar-desktop">
					<div class="side-bar-inner">
					'.$MobileDesktopHTML.'
					</div>
				</div>
				';

				}

			echo '</div>';

			if (!$AUTH && $_SERVER['SCRIPT_NAME'] != '/index.php' || $AUTH && $_SERVER['SCRIPT_NAME'] != '/store/new/index.php') {

			echo '
				<div class="auto cell no-margin">
					<div class="grid-container site-container-margin">
					';

					if ($AUTH && $myU->AccountVerified == 0) {

						echo '
						<div class="site-announcement">
							<div class="grid-x align-middle grid-margin-x">
								<div class="shrink cell">
									<i class="material-icons">error_outline</i>
								</div>
								<div class="auto cell">
								';

								if ($myU->LastAccountVerifiedAttempt == 0) {

									echo '
									We need to verify your email at <b>'.preg_replace('/[^@]+@([^\s]+)/', ''.substr($myU->Email, 0, 3).'********@$1', $myU->Email).'</b> to keep your account in good standing. <a href="'.$serverName.'/account/verify?action=send">Send Email</a>
									';

								} else {

									echo '
									We\'ve sent an email at <b>'.preg_replace('/[^@]+@([^\s]+)/', ''.substr($myU->Email, 0, 3).'********@$1', $myU->Email).'</b> with instructions on how to activate your account.
									';

									if ($myU->LastAccountVerifiedAttempt+3600 < time()) {

										echo '
										&nbsp;
										<a href="'.$serverName.'/account/verify?action=send">Send New Request</a>
										';

									}

								}

								echo '
								</div>
								<div class="shrink cell right">
									<i class="material-icons">error_outline</i>
								</div>
							</div>
						</div>
						';

					} else if (true) {

						echo '
						<div class="site-announcement">
							<div class="grid-x align-middle grid-margin-x">
								<div class="shrink cell">
									<i class="material-icons">error_outline</i>
								</div>
								<div class="auto cell">
								Please read this important update regarding this website by clicking <a href="http://brickcreate.com/forum/thread/2/">Here</a>
								</div>
								<div class="shrink cell right">
									<i class="material-icons">error_outline</i>
								</div>
							</div>
						</div>
						';

					} else {
						echo '<div class="main-site-push"></div>';
					}

					if ($DisplayAds == true) {

						echo '
						<div class="advert-container-horizontal">
							<!-- Responsive -->
							<ins class="adsbygoogle"
								 style="display:block"
								 data-ad-client="ca-pub-5035877450680880"
								 data-ad-slot="8645193052"
								 data-ad-format="auto"></ins>
							<script>
							(adsbygoogle = window.adsbygoogle || []).push({});
							</script>
						</div>
						';

					}

			}
