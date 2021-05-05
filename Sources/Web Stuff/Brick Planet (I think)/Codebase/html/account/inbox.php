<?php
$page = 'inbox';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	if (isset($_POST['MarkAsRead'])) {
		
		$success = 0;
		
		foreach ($_POST['message'] as $MessageID) {
			
			$checkAuth = $db->prepare("SELECT COUNT(*) FROM UserMessage WHERE ID = ? AND UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.IsRead = 0 AND UserMessage.Archived = 0");
			$checkAuth->bindValue(1, $MessageID, PDO::PARAM_INT);
			$checkAuth->execute();
			
			if ($checkAuth->rowCount() == 1) {
				
				$success++;
				
				$update = $db->prepare("UPDATE UserMessage SET UserMessage.IsRead = 1 WHERE UserMessage.ID = ?");
				$update->bindValue(1, $MessageID, PDO::PARAM_INT);
				$update->execute();
				
			}
			
		}
		
		if ($success > 0) {
			
			$getUnreadMessages = $db->prepare("SELECT COUNT(*) FROM UserMessage WHERE UserMessage.ReceiverID = ? AND UserMessage.IsRead = 0 AND UserMessage.Archived = 0");
			$getUnreadMessages->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$getUnreadMessages->execute();
			$getUnreadMessages = $getUnreadMessages->fetchColumn();
			
		}
		
		header("Location: ".$serverName."/account/inbox/");
		die;
		
	}
	
	if (isset($_POST['MarkAsUnread'])) {
		
		$success = 0;
		
		foreach ($_POST['message'] as $MessageID) {
			
			$checkAuth = $db->prepare("SELECT COUNT(*) FROM UserMessage WHERE UserMessage.ID = ? AND UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.IsRead = 1 AND UserMessage.Archived = 0");
			$checkAuth->bindValue(1, $MessageID, PDO::PARAM_INT);
			$checkAuth->execute();
			
			if ($checkAuth->rowCount() == 1) {
				
				$success++;
				
				$update = $db->prepare("UPDATE UserMessage SET UserMessage.IsRead = 0 WHERE UserMessage.ID = ?");
				$update->bindValue(1, $MessageID, PDO::PARAM_INT);
				$update->execute();
				
			}
			
		}
		
		if ($success > 0) {
			
			$getUnreadMessages = $db->prepare("SELECT COUNT(*) FROM UserMessage WHERE UserMessage.ReceiverID = ? AND UserMessage.IsRead = 0 AND UserMessage.Archived = 0");
			$getUnreadMessages->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$getUnreadMessages->execute();
			$getUnreadMessages = $getUnreadMessages->fetchColumn();
			
		}
		
		header("Location: ".$serverName."/account/inbox/");
		die;
		
	}
	
	if (isset($_POST['Archive'])) {
		
		$success = 0;
		
		foreach ($_POST['message'] as $MessageID) {
			
			$checkAuth = $db->prepare("SELECT COUNT(*) FROM UserMessage WHERE UserMessage.ID = ? AND UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.Archived = 0");
			$checkAuth->bindValue(1, $MessageID, PDO::PARAM_INT);
			$checkAuth->execute();
			
			if ($checkAuth->rowCount() == 1) {
				
				$success++;
				
				$update = $db->prepare("UPDATE UserMessage SET UserMessage.Archived = 1 WHERE UserMessage.ID = ?");
				$update->bindValue(1, $MessageID, PDO::PARAM_INT);
				$update->execute();
				
			}
			
		}
		
		header("Location: ".$serverName."/account/inbox/");
		die;
		
	}
	
	echo '
	<script>
	document.title = "Inbox - Brick Create";
	function toggle(reference) {
		checkbox = document.getElementsByName("message[]");
		
		for (var i = 0, n = checkbox.length; i<n; i++) {
			checkbox[i].checked = reference.checked;
		}
	}
	
	function OpenMessage(Id) {
		window.location.assign("'.$serverName.'/account/message/" + Id +"/");
	}
	</script>
	<h4>Messages</h4>
	<ul class="tabs inbox-tabs" data-tabs id="tabs">
		<li class="tabs-title is-active"><a href="#received" aria-selected="true" id="received-tab" onclick="received()">Received</a></li>
		<li class="tabs-title"><a href="#sent" id="sent-tab" onclick="sent()">Sent</a></li>
		<li class="tabs-title"><a href="#archive" id="archive-tab" onclick="archive()" class="no-right-border">Archived</a></li>
	</ul>
	<div class="tabs-content" data-tabs-content="tabs">
		<div class="tabs-panel is-active" id="received">
		<div class="container border-wh">
			<form action="" method="POST">
			<div class="grid-x grid-margin-x align-middle inbox-header-block">
				<div class="large-shrink medium-shrink small-12 cell">
					<input type="checkbox" id="select_all" class="filled-in" onclick="toggle(this)">
					<label for="select_all" style="" onclick="toggle(this)">Select All</label>
				</div>
				<div class="shrink cell">
					<input type="submit" name="MarkAsRead" class="button button-grey inbox-button" value="Mark As Read">
				</div>
				<div class="shrink cell">
					<input type="submit" name="MarkAsUnread" class="button button-grey inbox-button" value="Mark As Unread">
				</div>
				<div class="shrink cell">
					<input type="submit" name="Archive" class="button button-grey inbox-button" value="Archive">
				</div>
			</div>
			';
			
			$receivedlimit = 10;
			
			$receivedgetCount = $db->prepare("SELECT COUNT(UserMessage.ID) FROM UserMessage WHERE UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.Archived = 0");
			$receivedgetCount->execute();
			$ReceivedCount = $receivedgetCount->fetchColumn();
			
			$receivedpages = ceil($ReceivedCount / $receivedlimit);
				
			$receivedpage = min($receivedpages, filter_input(INPUT_GET, 'ReceivedPage', FILTER_VALIDATE_INT, array(
				'options' => array(
					'default'   => 1,
					'min_range' => 1,
				),
			)));
				
			$receivedoffset = ($receivedpage - 1)  * $receivedlimit;
			
			$getReceivedMessages = $db->prepare("SELECT UserMessage.ID, UserMessage.Title, UserMessage.Message, UserMessage.TimeSent, UserMessage.IsRead, User.Username, User.AvatarURL FROM UserMessage JOIN User ON User.ID = UserMessage.SenderID WHERE UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.Archived = 0 ORDER BY UserMessage.TimeSent DESC LIMIT ? OFFSET ?");
			$getReceivedMessages->bindValue(1, $receivedlimit, PDO::PARAM_INT);
			$getReceivedMessages->bindValue(2, $receivedoffset, PDO::PARAM_INT);
			$getReceivedMessages->execute();

			if ($ReceivedCount == 0) {
				
				echo '
				<div style="padding:50px 0;text-align: center;font-size:18px;">
				No messages here.
				</div>
				';
				
			}
			
			while ($gRM = $getReceivedMessages->fetch(PDO::FETCH_OBJ)) {
				
				$NewMessage = substr($gRM->Message, 0, 128);
				
				if (substr($NewMessage, -1) == " ") {
					
					$NewMessage = substr($NewMessage, 0, 127);
					
				}
				
				echo '
				<div class="grid-x grid-margin-x align-middle inbox-block'; if ($gRM->IsRead == 1) { echo ' inbox-active'; } echo '">
					<div class="shrink cell">
						<input type="checkbox" name="message[]" id="label'.$gRM->ID.'" value="'.$gRM->ID.'" style="margin:0 auto;">
					</div>
					<div class="shrink cell" onclick="OpenMessage('.$gRM->ID.')">
					';
					
					if ($gRM->Username == "Brick Create") {
						echo '
						<div class="inbox-avatar-official" style="background:url('.$cdnName.'web/BCIconPadding.png);background-size:cover;"></div>
						';
					}
					else {
						echo '
						<div class="inbox-avatar" style="background:url('.$cdnName . $gRM->AvatarURL.'-thumb.png);background-size:cover;"></div>
						';
					}
					
					echo '
					</div>
					<div class="auto cell" onclick="OpenMessage('.$gRM->ID.')">
						<div class="inbox-block-header">
							<span class="sender-username"><a href="'.$serverName.'/users/'.$gRM->Username.'/">'.$gRM->Username.'</a></span>
							&nbsp;-&nbsp;
							<span class="message-time">Received '.date('m/d/Y g:iA', $gRM->TimeSent).' CST</span>
						</div>
						<div class="inbox-block-body">
							<span class="message-title">'.$gRM->Title.'</span>
							&nbsp;-&nbsp;
							<span class="message-contents">'.LimitTextByCharacters($gRM->Message, 150).'</span>
						</div>
					</div>
				</div>
				';
				
			}
			
			echo '</div>';
			
			if ($receivedpages > 1) {
				
				echo '
				<div class="push-25"></div>
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous'; if ($receivedpage == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/inbox/?ReceivedPage='.($receivedpage-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
					';

					for ($i = max(1, $receivedpage - 5); $i <= min($receivedpage + 5, $receivedpages); $i++) {
						
						if ($i <= $receivedpages) {
						
							echo '<li'; if ($receivedpage == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/inbox/?ReceivedPage='.($i).'">'.$i.'</a></li>';

						}
						
					}

					echo '
					<li class="pagination-next'; if ($receivedpage == $receivedpages) { echo ' disabled">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/inbox/?ReceivedPage='.($receivedpage+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
				</ul>
				<div class="push-25"></div>
				';
			
			}
			
			echo '
			</form>
		</div>
		<div class="tabs-panel" id="sent">
		<div class="container border-wh">
			';
			
			$sentlimit = 10;
			
			$sentgetCount = $db->prepare("SELECT COUNT(UserMessage.ID) FROM UserMessage WHERE UserMessage.SenderID = ".$myU->ID."");
			$sentgetCount->execute();
			$SentCount = $sentgetCount->fetchColumn();
			
			$sentpages = ceil($SentCount / $sentlimit);
				
			$sentpage = min($sentpages, filter_input(INPUT_GET, 'SentPage', FILTER_VALIDATE_INT, array(
				'options' => array(
					'default'   => 1,
					'min_range' => 1,
				),
			)));
				
			$sentoffset = ($sentpage - 1)  * $sentlimit;
			
			$getSentMessages = $db->prepare("SELECT UserMessage.ID, UserMessage.Title, UserMessage.Message, UserMessage.TimeSent, UserMessage.IsRead, User.Username, User.AvatarURL FROM UserMessage JOIN User ON User.ID = UserMessage.ReceiverID WHERE UserMessage.SenderID = ".$myU->ID." ORDER BY UserMessage.TimeSent DESC LIMIT ? OFFSET ?");
			$getSentMessages->bindValue(1, $sentlimit, PDO::PARAM_INT);
			$getSentMessages->bindValue(2, $sentoffset, PDO::PARAM_INT);
			$getSentMessages->execute();
			
			if ($SentCount == 0) {
				
				echo '
				<div class="inbox-block-error">
				No messages here.
				</div>
				';
				
			}
			
			while ($gRM = $getSentMessages->fetch(PDO::FETCH_OBJ)) {
				
				$NewMessage = substr($gRM->Message, 0, 150);
				
				if (substr($NewMessage, -1) == " ") {
					
					$NewMessage = substr($NewMessage, 0, 149);
					
				}
				
				echo '
				<div class="grid-x grid-margin-x align-middle inbox-block'; if ($gRM->IsRead == 1) { echo ' inbox-active'; } echo '" onclick="OpenMessage('.$gRM->ID.')">
					<div class="shrink cell">
						<div class="inbox-avatar" style="background:url('.$cdnName . $gRM->AvatarURL.'-thumb.png);background-size:cover;"></div>
					</div>
					<div class="auto cell">
						<div class="inbox-block-header">
							<span class="sender-username"><a href="'.$serverName.'/users/'.$gRM->Username.'/">'.$gRM->Username.'</a></span>
							&nbsp;-&nbsp;
							<span class="message-time">Sent '.date('m/d/Y g:iA', $gRM->TimeSent).' CST</span>
						</div>
						<div class="inbox-block-body">
							<span class="message-title">'.$gRM->Title.'</span>
							&nbsp;-&nbsp;
							<span class="message-contents">'.LimitTextByCharacters($gRM->Message, 150).'</span>
						</div>
					</div>
				</div>
				';
				
			}
		
		echo '</div>';
		
		if ($sentpages > 1) {
			
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($sentpage == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/inbox/?SentPage='.($sentpage-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $sentpage - 5); $i <= min($sentpage + 5, $sentpages); $i++) {
					
					if ($i <= $sentpages) {
					
						echo '<li'; if ($sentpage == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/inbox/?SentPage='.($i).'">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($sentpage == $sentpages) { echo ' disabled">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/inbox/?SentPage='.($sentpage+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			<div class="push-25"></div>
			';
		
		}
			
		echo '
		</div>
		<div class="tabs-panel" id="archive">
		<div class="container border-wh">
		';
		
		$archivelimit = 10;
		
		$archivegetCount = $db->prepare("SELECT COUNT(UserMessage.ID) FROM UserMessage WHERE UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.Archived = 1");
		$archivegetCount->execute();
		$ArchiveCount = $archivegetCount->fetchColumn();
		
		$archivepages = ceil($ArchiveCount / $archivelimit);
			
		$archivepage = min($archivepages, filter_input(INPUT_GET, 'ArchivePage', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$archiveoffset = ($archivepage - 1)  * $archivelimit;
		
		$getArchiveMessages = $db->prepare("SELECT UserMessage.ID, UserMessage.Title, UserMessage.Message, UserMessage.TimeSent, UserMessage.IsRead, User.Username, User.AvatarURL FROM UserMessage JOIN User ON User.ID = UserMessage.SenderID WHERE UserMessage.ReceiverID = ".$myU->ID." AND UserMessage.Archived = 1 ORDER BY UserMessage.TimeSent DESC LIMIT ? OFFSET ?");
		$getArchiveMessages->bindValue(1, $archivelimit, PDO::PARAM_INT);
		$getArchiveMessages->bindValue(2, $archiveoffset, PDO::PARAM_INT);
		$getArchiveMessages->execute();
		
		if ($ArchiveCount == 0) {
			
			echo '
			<div class="inbox-block-error">
			No messages here.
			</div>
			';
			
		}
		
		while ($gRM = $getArchiveMessages->fetch(PDO::FETCH_OBJ)) {
			
			$NewMessage = substr($gRM->Message, 0, 150);
			
			if (substr($NewMessage, -1) == " ") {
				
				$NewMessage = substr($NewMessage, 0, 149);
				
			}
			
			echo '
			<div class="grid-x grid-margin-x align-middle inbox-block'; if ($gRM->IsRead == 1) { echo ' inbox-active'; } echo '" onclick="OpenMessage('.$gRM->ID.')">
				<div class="shrink cell">
					<div class="inbox-avatar" style="background:url('.$cdnName . $gRM->AvatarURL.'-thumb.png);background-size:cover;"></div>
				</div>
				<div class="auto cell">
					<div class="inbox-block-header">
						<span class="sender-username"><a href="'.$serverName.'/users/'.$gRM->Username.'/">'.$gRM->Username.'</a></span>
						&nbsp;-&nbsp;
						<span class="message-time">Received '.date('m/d/Y g:iA', $gRM->TimeSent).' CST</span>
					</div>
					<div class="inbox-block-body">
						<span class="message-title">'.$gRM->Title.'</span>
						&nbsp;-&nbsp;
						<span class="message-contents">'.LimitTextByCharacters($gRM->Message, 150).'</span>
					</div>
				</div>
			</div>
			';
			
		}
		
		echo '</div>';
		
		if ($archivepages > 1) {
			
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($archivepage == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/inbox/?ArchivePage='.($archivepage-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $archivepage - 5); $i <= min($archivepage + 5, $archivepages); $i++) {
					
					if ($i <= $archivepages) {
					
						echo '<li'; if ($archivepage == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/inbox/?ArchivePage='.($i).'">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($archivepage == $archivepages) { echo ' disabled">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/inbox/?ArchivePage='.($archivepage+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			<div class="push-25"></div>
			';
		
		}
		
		echo '
		</div>
	</div>
	<script>
		var receivednum = "'.number_format($ReceivedCount).'";
		var sentnum = "'.number_format($SentCount).'";
		var archivenum = "'.number_format($ArchiveCount).'";
		
		window.onload = function() {
			document.getElementById("received-tab").innerHTML = "Received (" + receivednum + ")";
			';
			
			if (isset($_GET['SentPage'])) {
				
				echo '
				sent();
				$("#tabs").foundation("selectTab", "sent");
				';
				
			}
			
			else if (isset($_GET['ArchivePage'])) {
				
				echo '
				archive();
				$("#tabs").foundation("selectTab", "archive");
				';
				
			}
			
			echo '
		}
		
		function received() {
			document.getElementById("received-tab").innerHTML = "Received (" + receivednum + ")";
			document.getElementById("sent-tab").innerHTML = "Sent";
			document.getElementById("archive-tab").innerHTML = "Archived";
		}
		
		function sent() {
			document.getElementById("sent-tab").innerHTML = "Sent (" + sentnum + ")";
			document.getElementById("received-tab").innerHTML = "Received";
			document.getElementById("archive-tab").innerHTML = "Archived";
		}
		
		function archive() {
			document.getElementById("archive-tab").innerHTML = "Archived (" + archivenum + ")";
			document.getElementById("received-tab").innerHTML = "Received";
			document.getElementById("sent-tab").innerHTML = "Sent";
		}
	</script>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");