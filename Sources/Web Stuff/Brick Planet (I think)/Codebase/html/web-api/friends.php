<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	$getUser = $db->prepare("SELECT User.ID, User.Username, User.NumFriends FROM User WHERE Username = ?");
	$getUser->bindValue(1, $_GET['username'], PDO::PARAM_STR);
	$getUser->execute();
	
	if ($getUser->rowCount() == 0) {
		
		header("Location: ".$serverName."");
		die;
		
	}
	
	$gU = $getUser->fetch(PDO::FETCH_OBJ);
	
	$limit = 12;
	
	$pages = ceil($gU->NumFriends / $limit);
	
	if (!isset($_GET['page'])) { $page = 1; }
	
	$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
		
	$offset = ($page - 1)  * $limit;

	$getFriends = $db->prepare("SELECT User.Username, User.AvatarURL, User.PersonalStatus, User.TimeLastSeen FROM Friend JOIN User ON Friend.ReceiverID = User.ID WHERE Friend.SenderID = ".$gU->ID." AND Friend.Accepted = 1 ORDER BY Friend.TimeSent DESC LIMIT ? OFFSET ?");
	$getFriends->bindValue(1, $limit, PDO::PARAM_INT);
	$getFriends->bindValue(2, $offset, PDO::PARAM_INT);
	$getFriends->execute();

	echo '
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4 style="margin:0;">'.$gU->Username.'\'s Friends ('.number_format($gU->NumFriends).')</h4>
		</div>
		<div class="shrink cell right no-margin">
			<a href="'.$serverName.'/users/'.$gU->Username.'/" class="button button-grey" style="padding: 8px 15px;font-size:13px;line-height:1.25;">Return to Profile</a>
		</div>
	</div>
	<div class="push-10"></div>
	<div class="container border-r md-padding">
		';
		
		if ($getFriends->rowCount() == 0) {
			
			echo '
			<div class="grid-x grid-margin-x">
				<div class="auto cell">
					Looks like this user does not have any friends on Brick Create...yet.
				</div>
			</div>
			';
			
		} else {
			
			echo '<div class="grid-x grid-margin-x">';
			
			while ($gF = $getFriends->fetch(PDO::FETCH_OBJ)) {
				
				$UserOnlineColor = ($gF->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
				$StatusSpan = '<span class="user-online-status" style="background:#'.$UserOnlineColor.';"></span>';
				
				echo '
				<div class="large-2 medium-3 small-4 cell text-center friend-card">
					<a href="'.$serverName.'/users/'.$gF->Username.'/">
						<img src="'.$cdnName.''.$gF->AvatarURL.'.png">
					</a>
					'.$StatusSpan.'
					<span>
						<a href="'.$serverName.'/users/'.$gF->Username.'/" style="color:#E3E3E3;font-weight:600;">
							'.$gF->Username.'
						</a>
					</span>
				</div>
				';
				
			}
			
			echo '</div>';
			
		}
		
		echo '
	</div>
	<div class="push-25"></div>
	';
	
	if ($pages > 1) {
		
		echo '
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/user/'.$gU->Username.'/friends/?page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
				
				if ($i <= $pages) {
				
					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/user/'.$gU->Username.'/friends/?page='.($i).'">'.$i.'</a></li>';

				}
				
			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/user/'.$gU->Username.'/friends/?page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';
	
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");