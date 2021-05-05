<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	if (!$AUTH) {
	
		echo '
		<link href="https://fonts.googleapis.com/css?family=Baloo+Tammudu" rel="stylesheet">
		<div class="landing-box">
			<div class="grid-container site-container-margin">
				<div class="grid-x grid-margin-x">
					<div class="large-7 cell">
						<div class="lb-title">Welcome to Brick Create!</div>
						<div class="lb-text">Brick Create is an online 3D gaming platform where users can collaborate to create awesome games, clothing, and participate in a virtual economy. Join us to create an online virtual world where the possibilities are endless.</div>
					</div>
					<div class="large-4 large-offset-1 cell">
						<div class="landing-signup">
							<div class="ls-title">Get started for free</div>
							<form action="'.$serverName.'/sign-up/" method="POST">
								<input type="email" name="email" class="ls-input" placeholder="Email Address">
								<div class="push-15"></div>
								<input type="text" name="username" class="ls-input" placeholder="Username">
								<div class="push-15"></div>
								<input type="password" name="password" class="ls-input" placeholder="Password">
								<div class="push-15"></div>
								<input type="password" name="confirm-password" class="ls-input" placeholder="Confirm Password">
								<div class="push-15"></div>
								<script src="https://www.google.com/recaptcha/api.js"></script>
								<div class="g-recaptcha" data-sitekey="6Ld6c50UAAAAAGbtBHEYqzNQINauJSHt7MRBbSQ-"></div>
								<div class="push-15"></div>
								<input type="submit" class="button button-green" value="Sign up">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		';
	
	} else {
		
		$Status = (!empty($_POST['status'])) ? $_POST['status'] : NULL;
		$errorMessage = null;
		
		if (!empty($Status) && $Status != $myU->PersonalStatus) {
			
			if ($myU->NextStatus > time()) {
				
				$errorMessage = 'Please wait '.($myU->NextStatus - time()).' more seconds until updating your status again.';
				
			} else if (strlen($Status) > 128) {
				
				$errorMessage = 'Your status is too long, please shorten it to 128 alphanumeric characters.';
				
			} else if (isProfanity($Status) == 1) {
				
				$errorMessage = 'One or more words in your status has triggered our profanity filter. Please correct and try again.';
			
			} else {
				
				$Status = htmlentities($Status);
				
				$UpdateUser = $db->prepare("UPDATE User SET PersonalStatus = ? WHERE ID = " . $myU->ID);
				$UpdateUser->bindValue(1, $Status, PDO::PARAM_STR);
				$UpdateUser->execute();
				
				if (!empty($Status)) {
					
					$InsertNotification = $db->prepare("INSERT INTO Notification (PosterID, Message, Time) VALUES(".$myU->ID.", ?, UNIX_TIMESTAMP())");
					$InsertNotification->bindValue(1, 'Updated their status to "'.$Status.'"', PDO::PARAM_STR);
					$InsertNotification->execute();
					
				}
				
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/");
				die;
				
			}
			
		}
		
		echo '
		<script>
		document.title = "Dashboard - Brick Create";
		</script>
		<div class="grid-x grid-margin-x">
			<div class="large-4 cell">
				<div class="dashboard-user-splash-color relative" style="background-color: #0A69BB; background: repeating-linear-gradient(45deg, #0A69BB, #0A69BB 10px, #034884 10px, #034884 20px);">
					<a href="'.$serverName.'/users/'.$myU->Username.'/">
						<div class="dashboard-user-avatar-thumb" style="background-image:url(https://cdn.brickcreate.com/975289c5-1c08-463c-bdf5-0b49d35c933b.png);background-size:cover;"></div>
					</a>
				</div>
				<div class="dashboard-user-container">
					<a href="'.$serverName.'/users/'.$myU->Username.'/" class="dashboard-user-name">'.$myU->Username.'</a>
					<div class="grid-x grid-margin-x">
						<div class="large-4 cell text-center">
							<div class="dashboard-stat-large">0</div>
							<div class="dashboard-stat-name">GAME VISITS</div>
						</div>
						<div class="large-4 cell text-center">
							<div class="dashboard-stat-large">'.number_format($myU->NumFriends).'</div>
							<div class="dashboard-stat-name">FRIENDS</div>
						</div>
						<div class="large-4 cell text-center">
							<div class="dashboard-stat-large">'.number_format($myU->NumForumPosts).'</div>
							<div class="dashboard-stat-name">FORUM POSTS</div>
						</div>
					</div>
				</div>
				<div class="push-25"></div>
				<h6>BLOG UPDATES</h6>
				<div class="dashboard-container">
				
				
				</div>
			</div>
			<div class="large-8 cell">
				<form action="" method="POST">
					';
					
					if ($errorMessage) {
						echo '<div class="error-message">'.$errorMessage.'</div>';
					}
					
					$myU->PersonalStatus = preg_replace("~<a href=\"(.*)\" target=\"_blank\">(.*)</a>~si", "$1", $myU->PersonalStatus);
					
					echo '
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<input type="text" name="status" id="status" class="dashboard-status-input" placeholder="How\'s it going, '.$myU->Username.'?" value="'.$myU->PersonalStatus.'">
						</div>
						<div class="shrink cell no-margin">
							<input type="submit" class="dashboard-status-submit" value="Post">
						</div>
					</div>
				</form>
				<div class="push-25"></div>
				<div class="dashboard-container">
					';
					
					if (!$cache->get($myU->ID.'Notifications')) {
					
						$getNotifications = $db->prepare("SELECT Notification.Message, Notification.Time, User.ID, User.Username, User.AvatarURL, User.TimeLastSeen, UserGroup.ID AS GroupID, UserGroup.Name, UserGroup.SEOName FROM Notification JOIN User ON User.ID = Notification.PosterID LEFT JOIN UserGroup ON User.FavoriteGroup = UserGroup.ID WHERE Notification.PosterID IN(SELECT Friend.SenderID FROM Friend WHERE Friend.ReceiverID = ".$myU->ID." AND Friend.Accepted = 1) ORDER BY Notification.Time DESC LIMIT 15");
						$getNotifications->execute();
						$getNotifications = $getNotifications->fetchAll(PDO::FETCH_OBJ);
					
						$cache->set($myU->ID.'Notifications', $getNotifications, 300);
					
					}
					
					$getNotifications = $cache->get($myU->ID.'Notifications');
					
					if (count($getNotifications) == 0) {
						
						echo '
						<h5 style="margin:0;padding:0;padding-bottom:15px;font-size:20px;">You have no notifications.</h5>
						<div style="font-size:14px;">Why not try <a href="'.$serverName.'/search/">searching for users</a> or <a href="'.$serverName.'/forum/">chatting with users</a> in our forum?</div>
						';
						
					} else {
						
						foreach ($getNotifications as $key => $gN) {
							
							if ($key > 0) {
								echo '<div class="status-card-divider"></div>';
							}
					
							$UserOnlineColor = ($gN->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
					
							echo '
							<div class="grid-x grid-margin-x align-middle">
								<div class="shrink cell no-margin">
									<a href="'.$serverName.'/users/'.$gN->Username.'/">
										<div class="status-card-user-avatar-thumb relative" style="background-image:url('.$cdnName . $gN->AvatarURL.'-thumb.png);background-size:cover;">
											<div class="status-card-user-activity" style="background-color:#'.$UserOnlineColor.';"></div>
										</div>
									</a>
								</div>
								<div class="auto cell no-margin">
									<a href="'.$serverName.'/users/'.$gN->Username.'/" class="status-card-user-name">'.$gN->Username.'</a>
									';
									
									if (!empty($gN->GroupID)) {
									
									echo '
									<div></div>
									<a href="'.$serverName.'/groups/'.$gN->GroupID.'/'.$gN->SEOName.'/" class="status-card-user-favorite-group">'.$gN->Name.'</a>
									';
									
									}
									
									echo '
								</div>
								<div class="shrink cell right no-margin">
									<div class="status-card-time"><span><i class="fa fa-clock-o" aria-hidden="true"></i></span><span>'.get_timeago($gN->Time).'</span></div>
								</div>
							</div>
							<div class="push-15"></div>
							<div class="status-card-post">
								'.$gN->Message.'
							</div>
							';
							
						}
						
					}
					
					echo '
				</div>
			</div>
		</div>
		';

	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
