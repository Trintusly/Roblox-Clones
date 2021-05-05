<?php
$page = 'friends';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	echo '
	<script>
		document.title = "Friend Requests - Brick Create";
	</script>
	';
	
	$numPendingFriends = $myU->NumFriendRequests;
	
	if ($numPendingFriends == 0) {
		
		echo '
		<div class="container lg-padding border-r">
			<h4>Friend Requests</h4>
			You have no pending friend requests at this time.
		</div>
		';
	
	}
	
	else {
	
		echo '
		<div class="container lg-padding border-r">
		<div class="grid-x grid-margin-x align-middle">
			<div class="auto cell">
				<h4>Friend Requests ('.number_format($numPendingFriends).')</h4>
			</div>
			<div class="shrink cell right text-right">
				';
				
				if ($numPendingFriends > 0) {
				
					echo '
					<a href="?accept=all" class="button button-green">Accept All</a>
					';
				
				}
				
				echo '
			</div>
		</div>
		<div class="push-25"></div>
		<div class="grid-x grid-margin-x">
		';
	
		if (isset($_GET['accept']) && $_GET['accept'] == 'all') {
			
			$getPending = $db->prepare("SELECT Friend.ID, Friend.SenderID, User.Username FROM Friend JOIN User ON User.ID = Friend.SenderID WHERE Friend.ReceiverID = ".$myU->ID." AND Friend.Accepted = 0");
			$getPending->execute();
			
			while ($gP = $getPending->fetch(PDO::FETCH_OBJ)) {
				
				$update = $db->prepare("UPDATE Friend SET Accepted = 1 WHERE ID = ".$gP->ID."");
				$update->execute();
				
				$insertFriend = $db->prepare("INSERT INTO Friend (SenderID, ReceiverID, TimeSent, Accepted) VALUES(".$myU->ID.", ".$gP->SenderID.", ".time().", 1)");
				$insertFriend->execute();
				
				$message = $db->prepare("INSERT INTO UserMessage (SenderID, ReceiverID, Title, Message, TimeSent) VALUES(?, ?, ?, ?, ?)");
				$message->bindValue(1, -1, PDO::PARAM_INT);
				$message->bindValue(2, $gP->SenderID, PDO::PARAM_INT);
				$message->bindValue(3, 'Your friend request has been accepted', PDO::PARAM_STR);
				$message->bindValue(4, ''.$myU->Username.' has accepted your friend request.', PDO::PARAM_STR);
				$message->bindValue(5, time(), PDO::PARAM_INT);
				$message->execute();
				
			}
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			$cache->delete($gP->Username.'_Profile');
			
			header("Location: ".$serverName."/account/friends/");
			die;
			
		}
	
		if (isset($_POST['accept'])) {
			
			$getUser = $db->prepare("SELECT ID FROM User WHERE Username = ?");
			$getUser->bindValue(1, $_POST['accept'], PDO::PARAM_STR);
			$getUser->execute();
			
			if ($getUser->rowCount() == 0) {
				die;
			}
			
			$gU = $getUser->fetch(PDO::FETCH_OBJ);
			
			$validateID = $db->prepare("SELECT COUNT(ID) FROM Friend WHERE SenderID = ".$gU->ID." AND ReceiverID = ".$myU->ID." AND Accepted = 0");
			$validateID->execute();
			
			$numID = $validateID->fetchColumn();
			
			if ($numID == 1 && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
				
				$acceptRequest = $db->prepare("UPDATE Friend SET Accepted = 1 WHERE SenderID = ".$gU->ID." AND ReceiverID = ".$myU->ID."");
				$acceptRequest->bindValue(1, $_POST['accept'], PDO::PARAM_STR);
				$acceptRequest->execute();
				
				$insertFriend = $db->prepare("INSERT INTO Friend (SenderID, ReceiverID, TimeSent, Accepted) VALUES(".$myU->ID.", ".$gU->ID.", ".time().", 1)");
				$insertFriend->execute();
				
				$message = $db->prepare("INSERT INTO UserMessage (SenderID, ReceiverID, Title, Message, TimeSent) VALUES(-1, ?, ?, ?, ?)");
				$message->bindValue(1, $gU->ID, PDO::PARAM_INT);
				$message->bindValue(2, 'Your friend request has been accepted', PDO::PARAM_STR);
				$message->bindValue(3, ''.$myU->Username.' has accepted your friend request.', PDO::PARAM_STR);
				$message->bindValue(4, time(), PDO::PARAM_INT);
				$message->execute();
			
			}
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			
			header("Location: ".$serverName."/account/friends/");
			die;
		
		}
		
		else if (isset($_POST['deny'])) {
		
			$getUser = $db->prepare("SELECT ID FROM User WHERE Username = ?");
			$getUser->bindValue(1, $_POST['deny'], PDO::PARAM_STR);
			$getUser->execute();
			
			if ($getUser->rowCount() == 0) {
				die;
			}
			
			$gU = $getUser->fetch(PDO::FETCH_OBJ);
		
			$validateID = $db->prepare("SELECT COUNT(ID) FROM Friend WHERE SenderID = (SELECT ID FROM User WHERE Username = ?) AND ReceiverID = ".$myU->ID." AND Accepted = 0");
			$validateID->bindValue(1, $_POST['deny'], PDO::PARAM_STR);
			$validateID->execute();
			
			$numID = $validateID->fetchColumn();
			
			if ($numID == 1 && $_SESSION['csrf_token'] == $_POST['csrf_token']) {
			
				$deleteRequest = $db->prepare("DELETE FROM Friend WHERE SenderID = ".$gU->ID." AND ReceiverID = ".$myU->ID." AND Accepted = 0");
				$deleteRequest->bindValue(1, $_POST['deny'], PDO::PARAM_STR);
				$deleteRequest->execute();
				
				$message = $db->prepare("INSERT INTO UserMessage (SenderID, ReceiverID, Title, Message, TimeSent) VALUES(?, (SELECT ID FROM User WHERE Username = ?), ?, ?, ?)");
				$message->bindValue(1, -1, PDO::PARAM_INT);
				$message->bindValue(2, $gU->ID, PDO::PARAM_INT);
				$message->bindValue(3, 'Your friend request has been declined', PDO::PARAM_STR);
				$message->bindValue(4, ''.$myU->Username.' has declined your friend request.', PDO::PARAM_STR);
				$message->bindValue(5, time(), PDO::PARAM_INT);
				$message->execute();
			
			}
			
			$cache->delete($myU->ID);
			$cache->delete($myU->Username.'_Profile');
			
			header("Location: ".$serverName."/account/friends/");
			die;
		
		}
		
		$limit = 8;
		
		$pages = ceil($numPendingFriends / $limit);
		
		if (!isset($_GET['page'])) { $page = 1; }
		
		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$offset = ($page - 1)  * $limit;
		
		$fetchPendingFriends = $db->prepare("SELECT User.ID, User.Username, User.AvatarURL FROM Friend JOIN User ON User.ID = Friend.SenderID WHERE Friend.ReceiverID = ".$myU->ID." AND Friend.Accepted = 0 LIMIT ? OFFSET ?");
		$fetchPendingFriends->bindValue(1, $limit, PDO::PARAM_INT);
		$fetchPendingFriends->bindValue(2, $offset, PDO::PARAM_INT);
		$fetchPendingFriends->execute();
		$fetchPendingFriends = $fetchPendingFriends->fetchAll(PDO::FETCH_OBJ);
		
		foreach ($fetchPendingFriends as $gP) {
			
			echo '
			<div class="large-3 medium-3 small-3 cell text-center friend-card">
				<a href="'.$serverName.'/users/'.$gP->Username.'/">
					<img src="'.$cdnName.''.$gP->AvatarURL.'.png">
				</a>
				<a href="'.$serverName.'/users/'.$gP->Username.'/">
					'.$gP->Username.'
				</a>
				<div class="push-10"></div>
				<div class="grid-x grid-margin-x align-middle">
					<div class="large-auto medium-auto small-12 cell">
						<form action="" method="POST">
							<input type="hidden" name="accept" value="'.$gP->Username.'">
							<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							<input type="submit" name="submit" value="Accept" class="button button-green">
						</form>
					</div>
					<div class="large-auto medium-auto small-12 cell right">
						<form action="" method="POST">
							<input type="hidden" name="deny" value="'.$gP->Username.'">
							<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
							<input type="submit" name="submit" value="Decline" class="button button-red">
						</form>
					</div>
				</div>
			</div>
			';
			
		}
		
		echo '</div>';
		
		if ($pages > 1) {
			
			echo '
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/friends/?page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/account/friends/?page='.($i).'">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/account/friends/?page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			';
		
		}
		
		echo '</div>';
	
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
