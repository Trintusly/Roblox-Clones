<?php
$page = 'forum';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (!$AUTH) { $myU = new StdClass(); $myU->ID = -10; }

	$getThread = $db->prepare("SELECT (SELECT COUNT(*) FROM ForumThreadView WHERE ThreadID = ForumThread.ID AND UserID = ".$myU->ID.") AS CheckView, (SELECT COUNT(*) FROM ForumThreadLike WHERE ThreadID = ForumThread.ID AND UserID = ".$myU->ID.") AS CheckLike, (SELECT COUNT(*) FROM ForumThreadBookmark WHERE UserID = ".$myU->ID." AND ThreadID = ForumThread.ID) AS CheckBookmark, User.ID AS UserID, User.Username, User.TimeRegister, User.TimeLastSeen, User.AvatarURL, User.Admin, User.BetaTester, User.NumForumPosts, User.ForumEXP, User.ForumLevel, User.VIP, ForumThread.ID, ForumThread.Title, ForumThread.Post, ForumThread.TimePost, ForumThread.Likes, ForumThread.Locked, ForumThread.Pinned, ForumThread.Views, ForumThread.Replies, ForumTopic.CategoryID AS CategoryID, ForumTopic.ID AS ForumTopicID, ForumTopic.Name AS ForumTopicName, ForumCategory.Name AS CategoryName, UserGroup.ID AS GroupID, UserGroup.Name, UserGroup.SEOName, UserGroup.LogoImage, UserGroup.LogoStatus, UserGroup.IsVerified FROM ForumThread JOIN User ON ForumThread.UserID = User.ID LEFT JOIN UserGroup ON User.FavoriteGroup = UserGroup.ID JOIN ForumTopic ON ForumThread.TopicID = ForumTopic.ID JOIN ForumCategory ON ForumTopic.CategoryID = ForumCategory.ID WHERE ForumThread.ID = ?");
	$getThread->bindValue(1, $_GET['id'], PDO::PARAM_INT);
	$getThread->execute();

	if ($getThread->rowCount() == 0) {

		header("Location: ".$serverName."/forum/");
		die;

	}

	$gT = $getThread->fetch(PDO::FETCH_OBJ);

	echo '<script>document.title = "'.htmlentities($gT->Title).' - Brick Create";</script>';

	if ($AUTH) {

		if ($gT->CheckView == 0) {

			$insert = $db->prepare("INSERT INTO ForumThreadView (ThreadID, UserID, TimeView) VALUES(".$gT->ID.", ".$myU->ID.", ".time().")");
			$insert->execute();

		}

	}

	if (isset($_POST['LikeThread']) && $gT->CheckLike == 0 && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

		$db->beginTransaction();

		$insert = $db->prepare("INSERT INTO ForumThreadLike (ThreadID, UserID, TimeLike) VALUES(".$gT->ID.", ".$myU->ID.", ".time().")");
		$insert->execute();

		$query = $db->prepare("SELECT COUNT(*) FROM ForumThreadLike WHERE ThreadID = ".$gT->ID." AND UserID = ".$myU->ID." AND TimeLike = ".time()."");
		$query->execute();

		if ($query->rowCount() > 1) {
			$db->rollBack();
			die;
		} else {
			$db->commit();
		}

		if ($myU->ID != $gT->UserID) {

			$base = 1000;
			$power = pow(1.50, $gT->ForumLevel);
			$LevelMaxExp = $base*$power;

			$NewExp = $gT->ForumEXP + 25;

			if ($NewExp >= $LevelMaxExp) {

				$RemainingExp = $NewExp - $LevelMaxExp;

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel + 1 WHERE ID = ".$gT->UserID."");
				$update->execute();

			} else {

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$gT->UserID."");
				$update->execute();

			}

		}

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	if (isset($_POST['UnlikeThread']) && $gT->CheckLike == 1 && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

		$remove = $db->prepare("DELETE FROM ForumThreadLike WHERE ThreadID = ".$gT->ID." AND UserID = ".$myU->ID."");
		$remove->execute();

		if ($myU->ID != $gT->UserID) {

			$base = 1000;
			$power = pow(1.50, ($gT->ForumLevel-1));
			$PreviousLevelMaxExp = $base*$power;

			$NewExp = $gT->ForumEXP - 25;

			if ($NewExp < 0) {

				$RemainingExp = $PreviousLevelMaxExp + $NewExp;

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel - 1 WHERE ID = ".$gT->UserID."");
				$update->execute();

			} else {

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$gT->UserID."");
				$update->execute();

			}

		}

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	if (isset($_POST['LikeReply']) && isset($_POST['ReplyID']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

		$getReplyInfo = $db->prepare("SELECT ForumReply.ID, ForumReply.UserID, User.ForumEXP, User.ForumLevel FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ?");
		$getReplyInfo->bindValue(1, $_POST['ReplyID'], PDO::PARAM_INT);
		$getReplyInfo->execute();

		if ($getReplyInfo->rowCount() > 0) {

			$gRI = $getReplyInfo->fetch(PDO::FETCH_OBJ);

			$checkLike = $db->prepare("SELECT COUNT(*) FROM ForumReplyLike WHERE ReplyID = ? AND UserID = ".$myU->ID."");
			$checkLike->bindValue(1, $_POST['ReplyID'], PDO::PARAM_INT);
			$checkLike->execute();

			if ($checkLike->fetchColumn() == 0) {

				if ($myU->ID != $gRI->UserID) {

					$base = 1000;
					$power = pow(1.50, $gRI->ForumLevel);
					$LevelMaxExp = $base*$power;

					$NewExp = $gRI->ForumEXP + 25;

					if ($NewExp >= $LevelMaxExp) {

						$RemainingExp = $NewExp - $LevelMaxExp;

						$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel + 1 WHERE ID = ".$gRI->UserID."");
						$update->execute();

					}

					else {

						$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$gRI->UserID."");
						$update->execute();

					}

				}

				$insert = $db->prepare("INSERT INTO ForumReplyLike (ReplyID, UserID, TimeLike) VALUES(?, ".$myU->ID.", ".time().")");
				$insert->bindValue(1, $_POST['ReplyID'], PDO::PARAM_INT);
				$insert->execute();

				header("Location: ".$serverName."/forum/thread/".$gT->ID."/#".$gRI->ID."");
				die;

			}

		}

	}

	if (isset($_POST['UnlikeReply']) && isset($_POST['ReplyID']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {

		$getReplyInfo = $db->prepare("SELECT ForumReply.ID, ForumReply.UserID, User.ForumEXP, User.ForumLevel FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ?");
		$getReplyInfo->bindValue(1, $_POST['ReplyID'], PDO::PARAM_INT);
		$getReplyInfo->execute();

		if ($getReplyInfo->rowCount() > 0) {

			$gRI = $getReplyInfo->fetch(PDO::FETCH_OBJ);

			$checkLike = $db->prepare("SELECT COUNT(*) FROM ForumReplyLike WHERE ReplyID = ? AND UserID = ".$myU->ID."");
			$checkLike->bindValue(1, $_POST['ReplyID'], PDO::PARAM_INT);
			$checkLike->execute();

			if ($checkLike->fetchColumn() > 0) {

				if ($myU->ID != $gRI->UserID) {

					$base = 1000;
					$power = pow(1.50, ($gRI->ForumLevel-1));
					$PreviousLevelMaxExp = $base*$power;

					$NewExp = $gRI->ForumEXP - 25;

					if ($NewExp < 0) {

						$RemainingExp = $PreviousLevelMaxExp + $NewExp;

						$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel - 1 WHERE ID = ".$gRI->UserID."");
						$update->execute();

					}

					else {

						$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$gRI->UserID."");
						$update->execute();

					}

				}

				$delete = $db->prepare("DELETE FROM ForumReplyLike WHERE ReplyID = ? AND UserID = ".$myU->ID."");
				$delete->bindValue(1, $_POST['ReplyID'], PDO::PARAM_INT);
				$delete->execute();

				header("Location: ".$serverName."/forum/thread/".$gT->ID."/#".$gRI->ID."");
				die;

			}

		}

	}

	if ($AUTH && isset($_POST['report_thread'])) {

		$_SESSION['Report_ReferenceType'] = 1;
		$_SESSION['Report_ReferenceID'] = $gT->ID;

		header("Location: ".$serverName."/report/");
		die;

	}

	if ($AUTH && isset($_POST['report_reply']) && isset($_POST['reply_id'])) {

		$count = $db->prepare("SELECT ID FROM ForumReply WHERE ID = ? AND ThreadID = ".$gT->ID."");
		$count->bindValue(1, $_POST['reply_id'], PDO::PARAM_INT);
		$count->execute();

		if ($count->rowCount() > 0) {

			$_SESSION['Report_ReferenceType'] = 2;
			$_SESSION['Report_ReferenceID'] = $count->fetchColumn();

			header("Location: ".$serverName."/report/");
			die;

		}

	}

	/*
	Forum Logs
	0 = Remove Thread
	1 = Remove Reply
	2 = Switch Lock Thread
	3 = Switch Pin Thread
	4 = Move Thread
	*/

	if (isset($_GET['ModerateAction']) && $_GET['ModerateAction'] == 'RemoveThread' && isset($_GET['ActionID']) && $AUTH && $myU->Admin > 0) {

		/* Move Replies */

		if ($gT->Replies > 0) {
			
			$DeleteForumReplyLike = $db->prepare("DELETE ForumReplyLike FROM ForumReplyLike JOIN ForumReply ON ForumReplyLike.ReplyID = ForumReply.ID WHERE ForumReply.ThreadID = ".$gT->ID."");
			$DeleteForumReplyLike->execute();

			$moveReplies = $db->prepare("INSERT INTO archives.ForumReply SELECT * FROM ForumReply WHERE ThreadID = ".$gT->ID."");
			$moveReplies->execute();

			$delete = $db->prepare("DELETE FROM ForumReply WHERE ThreadID = ".$gT->ID."");
			$delete->execute();

		}

		/* (End) */

		$movePost = $db->prepare("INSERT INTO archives.ForumThread SELECT * FROM ForumThread WHERE ID = ?");
		$movePost->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$movePost->execute();

		$ThreadID = $db->lastInsertId();

		if ($movePost->rowCount() > 0) {

			$base = 1000;
			$power = pow(1.50, ($gT->ForumLevel-1));
			$PreviousLevelMaxExp = $base*$power;

			$IndExp = str_word_count($gT->Post);
			if ($IndExp > 10) { $IndExp = 10; }
			$NewExp = $gT->ForumEXP - $IndExp;

			if ($NewExp < 0) {

				$RemainingExp = $PreviousLevelMaxExp + $NewExp;

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel - 1 WHERE ID = ".$gT->UserID."");
				$update->execute();

			}

			else {

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$gT->UserID."");
				$update->execute();

			}

		}
		
		$delete = $db->prepare("DELETE FROM ForumThreadView WHERE ThreadID = ?");
		$delete->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$delete->execute();

		$delete = $db->prepare("DELETE FROM ForumThreadLike WHERE ThreadID = ?");
		$delete->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$delete->execute();

		$delete = $db->prepare("DELETE FROM ForumThread WHERE ID = ?");
		$delete->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$delete->execute();

		$log = $db->prepare("INSERT INTO ForumAdminLog (ForumType, ForumID, AdminID, UserID, TimeAction, ActionIP) VALUES(0, ?, ".$myU->ID.", (SELECT UserID FROM archives.ForumThread WHERE ID = ".$ThreadID."), ".time().", '".$_SERVER['REMOTE_ADDR']."')");
		$log->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$log->execute();

		ResetForumHomeCache();

		header("Location: ".$serverName."/forum/topic/".$gT->ForumTopicID."/");
		die;

	}

	if (isset($_GET['ModerateAction']) && $_GET['ModerateAction'] == 'RemoveReply' && isset($_GET['ActionID']) && $AUTH && $myU->Admin > 0) {

		$DeleteForumReplyLike = $db->prepare("DELETE FROM ForumReplyLike WHERE ForumReplyLike.ReplyID = ?");
		$DeleteForumReplyLike->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$DeleteForumReplyLike->execute();
	
		$movePost = $db->prepare("INSERT INTO archives.ForumReply SELECT * FROM ForumReply WHERE ID = ? AND ThreadID = ".$gT->ID."");
		$movePost->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
		$movePost->execute();

		$ReplyID = $db->lastInsertId();

		if ($movePost->rowCount() > 0) {

			$getReplyInformation = $db->prepare("SELECT ForumReply.UserID, ForumReply.Post, User.ForumEXP, User.ForumLevel FROM ForumReply JOIN User ON ForumReply.UserID = User.ID WHERE ForumReply.ID = ?");
			$getReplyInformation->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
			$getReplyInformation->execute();
			$gRI = $getReplyInformation->fetch(PDO::FETCH_OBJ);

			$base = 1000;
			$power = pow(1.50, ($gRI->ForumLevel-1));
			$PreviousLevelMaxExp = $base*$power;

			$NewExp = $gRI->ForumEXP - str_word_count($gRI->Post);

			if ($NewExp < 0) {

				$RemainingExp = $PreviousLevelMaxExp + $NewExp;

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$RemainingExp.", ForumLevel = ForumLevel - 1 WHERE ID = ".$gRI->UserID."");
				$update->execute();

			}

			else {

				$update = $db->prepare("UPDATE User SET ForumEXP = ".$NewExp." WHERE ID = ".$gRI->UserID."");
				$update->execute();

			}
			
			$delete = $db->prepare("DELETE FROM ForumReplyLike WHERE ReplyID = ?");
			$delete->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
			$delete->execute();

			$delete = $db->prepare("DELETE FROM ForumReply WHERE ID = ?");
			$delete->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
			$delete->execute();

			$log = $db->prepare("INSERT INTO ForumAdminLog (ForumType, ForumID, AdminID, UserID, TimeAction, ActionIP) VALUES(1, ?, ".$myU->ID.", (SELECT UserID FROM archives.ForumReply WHERE ID = ".$ReplyID."), ".time().", '".$_SERVER['REMOTE_ADDR']."')");
			$log->bindValue(1, $_GET['ActionID'], PDO::PARAM_INT);
			$log->execute();

		}

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	if (isset($_GET['ModerateAction']) && $_GET['ModerateAction'] == 'SwitchLockThread' && isset($_GET['ActionID']) && $AUTH && $myU->Admin > 0) {

		$switchLock = $db->prepare("UPDATE ForumThread SET Locked = (CASE WHEN Locked = 0 THEN '1' ELSE '0' END) WHERE ID = ".$gT->ID."");
		$switchLock->execute();

		$log = $db->prepare("INSERT INTO ForumAdminLog (ForumType, ForumID, AdminID, UserID, TimeAction, ActionIP, ActionDescription) VALUES(2, ".$gT->ID.", ".$myU->ID.", ".$gT->UserID.", ".time().", '".$_SERVER['REMOTE_ADDR']."', ".$gT->Locked.")");
		$log->execute();

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	if (isset($_GET['ModerateAction']) && $_GET['ModerateAction'] == 'SwitchPinThread' && isset($_GET['ActionID']) && $AUTH && $myU->Admin > 0) {

		$switchLock = $db->prepare("UPDATE ForumThread SET Pinned = (CASE WHEN Pinned = 0 THEN '1' ELSE '0' END) WHERE ID = ".$gT->ID."");
		$switchLock->execute();

		$log = $db->prepare("INSERT INTO ForumAdminLog (ForumType, ForumID, AdminID, UserID, TimeAction, ActionIP, ActionDescription) VALUES(3, ".$gT->ID.", ".$myU->ID.", ".$gT->UserID.", ".time().", '".$_SERVER['REMOTE_ADDR']."', ".$gT->Pinned.")");
		$log->execute();

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	if (isset($_GET['bookmark']) && $AUTH && $_GET['bookmark'] == 1 && $gT->CheckBookmark == 0) {

		$insert = $db->prepare("INSERT INTO ForumThreadBookmark (UserID, ThreadID) VALUES (".$myU->ID.", ".$gT->ID.")");
		$insert->execute();

		$cache->delete($myU->ID);

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	if (isset($_GET['bookmark']) && $AUTH && $_GET['bookmark'] == 0 && $gT->CheckBookmark == 1) {

		$delete = $db->prepare("DELETE FROM ForumThreadBookmark WHERE UserID = ".$myU->ID." AND ThreadID = ".$gT->ID."");
		$delete->execute();

		$cache->delete($myU->ID);

		header("Location: ".$serverName."/forum/thread/".$gT->ID."/");
		die;

	}

	echo '
	<meta property="og:title" content="'.htmlentities($gT->Title).'">
	<meta property="og:type" content="website">
	<meta property="og:url" content="'.$serverName.'/forum/thread/'.$gT->ID.'/">
	<meta property="og:image" content="https://cdn.brickcreate.com/'.$gT->AvatarURL.'-thumb.png">
	<meta property="og:site_name" content="Brick Create">
	<meta property="og:description" content="\''.htmlentities(strip_tags($gT->Title)).'\' is a forum post on Brick Create, a user generated content sandbox game with tens of thousands of active players. Play today!">
	<div class="grid-x grid-margin-x forum-top-links">
		<div class="large-10 large-offset-1 cell">
			<a href="'.$serverName.'/forum/">Forum</a>
			&nbsp;&raquo;&nbsp;
			<a href="'.$serverName.'/forum/topic/'.$gT->ForumTopicID.'/">'.$gT->ForumTopicName.'</a>
			&nbsp;&raquo;&nbsp;
			'.$gT->Title.'
		</div>
	</div>
		<div class="grid-x grid-margin-x">
			<div class="large-10 large-offset-1 cell">
				<div class="container md-padding border-r" style="word-break:break-word;">
				<div class="grid-x grid-margin-x align-middle forum-thread-title">
					<div class="auto cell no-margin">
						<span class="title">'.$gT->Title.'</span>
						';

						if ($AUTH && $gT->CheckBookmark == 0) {

							echo '
							<a title="Bookmark this post" href="'.$serverName.'/forum/thread/'.$gT->ID.'&bookmark=1/" style="color:#F6B352;"><i class="material-icons">bookmark_border</i></a>
							';

						} else if ($AUTH && $gT->CheckBookmark == 1) {

							echo '
							<a title="Unbookmark this post" href="'.$serverName.'/forum/thread/'.$gT->ID.'&bookmark=0/" style="color:#F6B352;"><i class="material-icons">bookmark</i></a>
							';

						}

						echo '
					</div>
					<div class="shrink cell right no-margin">
					';

					if ($AUTH && $gT->Locked == 0) {

					echo '
					<a href="'.$serverName.'/forum/reply/'.$gT->ID.'/" class="button button-green"><i class="material-icons">reply</i><span>Reply</span></a>
					';

					}

					echo '
					</div>
				</div>
				<a name="'.$gT->ID.'"></a>
				';

				$limit = 15;

				$pages = ceil($gT->Replies / $limit);

				$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
					'options' => array(
						'default'   => 1,
						'min_range' => 1,
					),
				)));
				if ($page == 0) { $page = 1; }

				$offset = ($page - 1)  * $limit;
				if ($offset < 0) { $offset = 0; }

				if ($page == 1) {

				echo '

				<div class="forum-thread-header">
					<div class="grid-x grid-margin-x align-middle">
						<div class="thread-header-adjustment large-shrink medium-shrink small-4 cell">
							';

							if (($gT->TimeLastSeen+600) > time()) {

								echo '
								<div class="user-online" title="'.$gT->Username.' is online"></div>
								';

							}

							else {

								echo '
								<div class="user-offline" title="'.$gT->Username.' is offline"></div>
								';

							}

							echo '
							<a href="'.$serverName.'/users/'.$gT->Username.'/">'.$gT->Username.'</a>
						</div>
						<div class="auto cell">
							<span class="show-for-medium">Posted on </span><span>'.date('M dS Y, g:iA', $gT->TimePost).'</span>
						</div>
						<div class="shrink cell right">
							<a href="'.$serverName.'/forum/reply/'.$gT->ID.'&Type=Thread&SourceID='.$gT->ID.'/" class="quote-a" title="Quote this post"><i class="material-icons">format_quote</i></a>
							';

							if ($AUTH) {

								echo '
								<form action="" method="POST" class="report-abuse-forumForm"><button type="submit" name="report_thread" class="report-abuse-forum-icon"><i class="material-icons" class="report-abuse-forum-icon">flag</i></button></form>
								';

							}

							echo '
						</div>
					</div>
				</div>
				<div class="forum-content-wrapper">
					<div class="grid-x grid-margin-x">
						<div class="large-shrink medium-shrink small-4 cell text-center">
							<a href="'.$serverName.'/users/'.$gT->Username.'/"><img src="https://cdn.brickcreate.com/DzIhMrw33xy.png"></a>
							';
							
							if (!empty($gT->GroupID)) {
								
								switch ($gT->LogoStatus) {
									case 0:
										$gT->LogoImage = 'pending.png';
										break;
									case 2:
										$gT->LogoImage = 'rejected.png';
										break;
								}
								
								echo '
								<div class="forum-user-favorite-group">
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell no-margin">
											<a href="'.$serverName.'/groups/'.$gT->GroupID.'/'.$gT->SEOName.'/"><div class="forum-user-favorite-group-logo" style="background:url('.$cdnName . $gT->LogoImage.');background-size:cover;"></div></a>
										</div>
										<div class="auto cell no-margin forum-user-favorite-group-name">
											<a href="'.$serverName.'/groups/'.$gT->GroupID.'/'.$gT->SEOName.'/">'.$gT->Name.'</a>
											';
											
											if ($gT->IsVerified == 1) {
												echo '<img src="/assets/images/groups/verified-ico32x32.png" style="height:16px;width:16px;" title="This group is verified">';
											}
											
											echo '
										</div>
									</div>
								</div>
								';
								
							}

							if ($gT->Admin > 0) {

								echo '
								<div class="forum-admin">
									<i class="fa fa-gavel show-for-medium"></i><span>Admin</span><span class="show-for-medium">istrator</span>
								</div>
								';

							} else if ($gT->VIP > 0) {

								switch ($gT->VIP) {
									case 1:
										$ClassName = 'brick-builder';
										$PlanName = 'Brick Builder';
										break;
									case 2:
										$ClassName = 'planet-constructor';
										$PlanName = 'Planet Constructor';
										break;
									case 3:
										$ClassName = 'master-architect';
										$PlanName = 'Master Architect';
										break;
								}

								echo '
								<div class="card-'.$ClassName.'"><div class="card-image"></div><span>'.$PlanName.'</span></div>
								';

							}

							echo '
							<div class="thread-user-stats show-for-medium">
								<div class="stat-left">Join Date:</div>
								<div class="stat-right">'.date('M d', $gT->TimeRegister).', '.date('Y', $gT->TimeRegister).'</div>
							</div>
							<div class="thread-user-stats">
								<div class="stat-left">Posts:</div>
								<div class="stat-right">'.number_format($gT->NumForumPosts).'</div>
							</div>
							<div class="thread-user-stats">
								<div class="stat-left">Level:</div>
								<div class="stat-right">'.number_format($gT->ForumLevel).'</div>
							</div>
						</div>
						<div class="large-auto medium-auto small-8 cell">
							<div class="forum-main-content">
								<div class="forum-thread-body">
									'.nl2br($gT->Post).'
								</div>
							</div>
							<div class="grid-x grid-margin-x align-middle thread-content-info">
								<div class="large-auto medium-6 small-12 cell">
									<div class="thread-content-info-part">
									';

									if ($AUTH) {

										if ($gT->CheckLike == 1) {

											echo '
											<form action="" method="POST" style="display:inline-block;">
												<button type="submit" name="UnlikeThread"><i class="material-icons" style="cursor:pointer;color:#56A902;">thumb_up</i></button>
												<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
											</form>
											';

										} else {

											echo '
											<form action="" method="POST" style="display:inline-block;">
												<button type="submit" name="LikeThread"><i class="material-icons" style="cursor:pointer;color:#E3E3E3;">thumb_up</i></button>
												<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
											</form>
											';

										}

									} else {

										echo '<i class="material-icons">thumb_up</i>';

									}

									echo '
									<span>'.number_format($gT->Likes).' LIKE'; if ($gT->Likes > 1 || $gT->Likes == 0) { echo 'S'; } echo '</span>
									</div>
									<div class="thread-content-info-part show-for-medium">
										<i class="material-icons">remove_red_eye</i>
										<span>'.number_format($gT->Views).' VIEW'; if ($gT->Views > 1 || $gT->Views == 0) { echo 'S'; } echo '</span>
									</div>
									<div class="thread-content-info-part">
										<i class="material-icons">forum</i>
										<span>'.$gT->Replies.' '; if ($gT->Replies == 1) { echo 'REPLY'; } else { echo 'REPLIES'; } echo '</span>
									</div>
								</div>
								<div class="large-shrink medium-6 small-12 cell text-right forum-thread-mods">
									';

									if ($myU->Admin > 0) {

										echo '
										<a href="'.$serverName.'/forum/thread/'.$gT->ID.'/&ModerateAction=RemoveThread&ActionID='.$gT->ID.'/">Remove</a>
										&nbsp;|&nbsp;
										<a href="'.$serverName.'/forum/thread/'.$gT->ID.'/&ModerateAction=SwitchLockThread&ActionID='.$gT->ID.'/">'; if ($gT->Locked == 0) { echo 'Lock'; } else { echo 'Unlock'; } echo '</a>
										&nbsp;|&nbsp;
										<a href="'.$serverName.'/forum/thread/'.$gT->ID.'/&ModerateAction=SwitchPinThread&ActionID='.$gT->ID.'/">'; if ($gT->Pinned == 0) { echo 'Pin'; } else { echo 'Unpin'; } echo '</a>
										&nbsp;|&nbsp;
										<a href="'.$serverName.'/forum/movethread/'.$gT->ID.'/">Move</a>
										&nbsp;|&nbsp;
										<a href="https://west.brickpla.net/users/ban-user?u='.$gT->Username.'&ThreadId='.$gT->ID.'" target="_blank">Ban</a>
										';

									}

									echo '
								</div>
							</div>
						</div>
					</div>
				</div>
				';

			}
			
			$getReplies = $db->prepare("SELECT User.ID AS UserID, User.Username, User.TimeRegister, User.TimeLastSeen, User.AvatarURL, User.Admin, User.BetaTester, User.NumForumPosts, User.ForumEXP, User.ForumLevel, User.VIP, ForumReply.ID, ForumReply.Post, ForumReply.TimePost, ForumReply.QuoteType, ForumReply.QuoteID, UserGroup.ID AS GroupID, UserGroup.Name, UserGroup.SEOName, UserGroup.LogoImage, UserGroup.LogoStatus, UserGroup.IsVerified, (SELECT COUNT(*) FROM ForumReplyLike WHERE ReplyID = ForumReply.ID AND UserID = ".$myU->ID.") AS CheckLike, (SELECT COUNT(*) FROM ForumReplyLike WHERE ReplyID = ForumReply.ID) AS Likes FROM ForumReply JOIN User ON ForumReply.UserID = User.ID LEFT JOIN UserGroup ON User.FavoriteGroup = UserGroup.ID WHERE ForumReply.ThreadID = ".$gT->ID." ORDER BY ForumReply.TimePost ASC LIMIT ".$limit." OFFSET ".$offset."");
			$getReplies->execute();

			while ($gR = $getReplies->fetch(PDO::FETCH_OBJ)) {

				echo '
				<a name="'.$gR->ID.'"></a>
				<div class="forum-thread-header">
					<div class="grid-x grid-margin-x align-middle">
						<div class="thread-header-adjustment large-shrink medium-shrink small-4 cell">
							';

							if (($gR->TimeLastSeen+600) > time()) {

								echo '
								<div class="user-online" title="'.$gR->Username.' is online"></div>
								';

							} else {

								echo '
								<div class="user-offline" title="'.$gR->Username.' is offline"></div>
								';

							}

							echo '
							<a href="'.$serverName.'/users/'.$gR->Username.'/">'.$gR->Username.'</a>
						</div>
						<div class="auto cell">
							<span class="show-for-medium">Posted on </span> <span>'.date('M dS Y, g:iA', $gR->TimePost).'</span>
						</div>
						<div class="shrink cell right">
							<a href="'.$serverName.'/forum/reply/'.$gT->ID.'&Type=Reply&SourceID='.$gR->ID.'/" class="quote-a" title="Quote this post"><i class="material-icons">format_quote</i></a>
							';

							if ($AUTH) {

								echo '
								<form action="" method="POST" class="report-abuse-forumForm"><button type="submit" name="report_reply" class="report-abuse-forum-icon"><i class="material-icons" class="report-abuse-forum-icon">flag</i></button><input type="hidden" name="reply_id" value="'.$gR->ID.'"></form>
								';

							}

							echo '
						</div>
					</div>
				</div>
				<div class="forum-content-wrapper">
					<div class="grid-x grid-margin-x">
						<div class="large-shrink medium-shrink small-4 cell text-center">
							<a href="'.$serverName.'/users/'.$gR->Username.'/"><img src="'.$cdnName . $gR->AvatarURL.'-forum.png"></a>
							';
							
							if (!empty($gR->GroupID)) {
								
								switch ($gR->LogoStatus) {
									case 0:
										$gR->LogoImage = 'pending.png';
										break;
									case 2:
										$gR->LogoImage = 'rejected.png';
										break;
								}
								
								echo '
								<div class="forum-user-favorite-group">
									<div class="grid-x grid-margin-x align-middle">
										<div class="shrink cell no-margin">
											<a href="'.$serverName.'/groups/'.$gR->GroupID.'/'.$gR->SEOName.'/"><div class="forum-user-favorite-group-logo" style="background:url('.$cdnName . $gR->LogoImage.');background-size:cover;"></div></a>
										</div>
										<div class="auto cell no-margin forum-user-favorite-group-name">
											<a href="'.$serverName.'/groups/'.$gR->GroupID.'/'.$gR->SEOName.'/">'.$gR->Name.'</a>
											';
											
											if ($gR->IsVerified == 1) {
												echo '<img src="/assets/images/groups/verified-ico32x32.png" style="height:16px;width:16px;" title="This group is verified">';
											}
											
											echo '
										</div>
									</div>
								</div>
								';
								
							}

							if ($gR->Admin > 0) {

								echo '
								<div class="forum-admin">
									<i class="fa fa-gavel show-for-medium"></i><span>Admin</span><span class="show-for-medium">istrator</span>
								</div>
								';

							} else if ($gR->VIP > 0) {

								switch ($gR->VIP) {
									case 1:
										$ClassName = 'brick-builder';
										$PlanName = 'Brick Builder';
										break;
									case 2:
										$ClassName = 'planet-constructor';
										$PlanName = 'Planet Constructor';
										break;
									case 3:
										$ClassName = 'master-architect';
										$PlanName = 'Master Architect';
										break;
								}

								echo '
								<div class="card-'.$ClassName.'"><div class="card-image"></div><span>'.$PlanName.'</span></div>
								';

							}

							echo '
							<div class="thread-user-stats show-for-medium">
								<div class="stat-left">Join Date:</div>
								<div class="stat-right">'.date('M d', $gR->TimeRegister).', '.date('Y', $gR->TimeRegister).'</div>
							</div>
							<div class="thread-user-stats">
								<div class="stat-left">Posts:</div>
								<div class="stat-right">'.number_format($gR->NumForumPosts).'</div>
							</div>
							<div class="thread-user-stats">
								<div class="stat-left">Level:</div>
								<div class="stat-right">'.number_format($gR->ForumLevel).'</div>
							</div>
						</div>
						<div class="large-auto medium-auto small-8 cell">
							<div class="forum-main-content">
								';

								if ($gR->QuoteType == 1) {

									$getThread = $db->prepare("SELECT ForumThread.Post, ForumThread.TimePost, User.Username FROM ForumThread JOIN User ON User.ID = ForumThread.UserID WHERE ForumThread.ID = ?");
									$getThread->bindValue(1, $gR->QuoteID, PDO::PARAM_INT);
									$getThread->execute();

									if ($getThread->rowCount() > 0) {

										$getT = $getThread->fetch(PDO::FETCH_OBJ);

										echo '
										<div class="forum-quote">
											<div class="forum-quote-info">Originally posted by <a href="'.$serverName.'/users/'.$getT->Username.'/">'.$getT->Username.'</a>&nbsp;-&nbsp;'.get_timeago($getT->TimePost).'</div>
											<div class="forum-quote-post"><div class="forum-thread-body">'.nl2br($getT->Post).'</div></div>
										</div>
										<div style="height:15px;"></div>
										';

									}

								}

								else if ($gR->QuoteType == 2) {

									$getReply = $db->prepare("SELECT ForumReply.Post, ForumReply.TimePost, User.Username FROM ForumReply JOIN User ON User.ID = ForumReply.UserID WHERE ForumReply.ID = ?");
									$getReply->bindValue(1, $gR->QuoteID, PDO::PARAM_INT);
									$getReply->execute();

									if ($getReply->rowCount() > 0) {

										$getR = $getReply->fetch(PDO::FETCH_OBJ);

										echo '
										<div class="forum-quote">
											<div class="forum-quote-info">Originally posted by <a href="'.$serverName.'/users/'.$getR->Username.'/">'.$getR->Username.'</a>&nbsp;-&nbsp;'.get_timeago($getR->TimePost).'</div>
											<div class="forum-quote-post">'.nl2br($getR->Post).'</div>
										</div>
										<div style="height:15px;"></div>
										';

									}

								}

								echo '
								<div class="forum-thread-body">
									'.nl2br($gR->Post).'
								</div>
							</div>
							<div class="grid-x grid-margin-x align-middle thread-content-info">
								<div class="large-auto medium-6 small-12 cell">
									<div class="thread-content-info-part">
										';

										if ($AUTH) {

											if ($gR->CheckLike == 1) {

												echo '
												<form action="" method="POST" style="display:inline-block;">
													<button type="submit" name="UnlikeReply"><i class="material-icons" style="cursor:pointer;color:#56A902;">thumb_up</i></button>
													<input type="hidden" name="ReplyID" value="'.$gR->ID.'">
													<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												</form>
												';

											}

											else {

												echo '
												<form action="" method="POST" style="display:inline-block;">
													<button type="submit" name="LikeReply"><i class="material-icons" style="cursor:pointer;color:#E3E3E3;">thumb_up</i></button>
													<input type="hidden" name="ReplyID" value="'.$gR->ID.'">
													<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
												</form>
												';

											}

										}

										else {

											echo '<i class="material-icons">thumb_up</i>';

										}

										echo '
										<span>'.number_format($gR->Likes).' LIKE'; if ($gR->Likes > 1 || $gR->Likes == 0) { echo 'S'; } echo '</span>
									</div>
								</div>
								<div class="large-shrink medium-6 small-12 cell text-right forum-thread-mods">
								';

								if ($AUTH && $myU->Admin > 0) {

									echo '
									<a href="'.$serverName.'/forum/thread/'.$gT->ID.'/&ModerateAction=RemoveReply&ActionID='.$gR->ID.'/">Remove</a>
									&nbsp;|&nbsp;
									<a href="https://west.brickpla.net/users/ban-user?u='.$gR->Username.'&ReplyId='.$gR->ID.'" target="_blank">Ban</a>
									';

								}

								echo '
								</div>
							</div>
						</div>
					</div>
				</div>
			';

	}

	echo '</div>';

	if ($AUTH && $gT->Locked == 0) {

		echo '
		<div class="push-25"></div>
		<div class="forum-thread-reply"><a href="'.$serverName.'/forum/reply/'.$gT->ID.'/" class="button button-green text-center"><i class="material-icons">reply</i><span>Reply</span></a></div>
		<div class="push-25"></div>
		';

	}

	if ($pages > 1) {

		echo '
		<div class="push-25"></div>
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/forum/thread/'.$gT->ID.'/'.($page-1).'/">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

				if ($i <= $pages) {

					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/forum/thread/'.$gT->ID.'/'.($i).'/">'.$i.'</a></li>';

				}

			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/forum/thread/'.$gT->ID.'/'.($page+1).'/">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';

	}
	
	echo '
	</div>
	</div>
	<div class="footer-push"></div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
