<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	requireLogin();
	
	if ($_GET['q'] == 'undefined') {
		
		unset($_GET['q']);
		
	} else {
		
		$_GET['q'] = htmlentities(strip_tags($_GET['q']));
		
	}
	
	if (!empty($_GET['q'])) {
		
		$Count = $db->prepare("SELECT COUNT(*) FROM BlockedUser JOIN User ON User.ID = BlockedUser.BlockedID WHERE BlockedUser.RequesterID = ".$myU->ID." AND MATCH(User.Username) AGAINST(?)");
		$Count->bindValue(1, $_GET['q'], PDO::PARAM_STR);
		$Count->execute();
		$Count = $Count->fetchColumn();
		
	} else {
		
		$Count = $db->prepare("SELECT COUNT(*) FROM BlockedUser JOIN User ON User.ID = BlockedUser.BlockedID WHERE BlockedUser.RequesterID = ".$myU->ID."");
		$Count->execute();
		$Count = $Count->fetchColumn();
		
	}
	
	if ($Count > 0) {
		
		$limit = 10;
			
		$pages = ceil($Count / $limit);
			
		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
		if ($page == 0) { $page = 1; }
			
		$offset = ($page - 1)  * $limit;
		if ($offset < 0) { $offset = 0; }
		
		if (!empty($_GET['q'])) {
			
			$getBlocked = $db->prepare("SELECT BlockedUser.ID AS BlockedID, User.ID, User.Username, User.AvatarURL, BlockedUser.Time FROM BlockedUser JOIN User ON User.ID = BlockedUser.BlockedID WHERE BlockedUser.RequesterID = ".$myU->ID." AND MATCH(User.Username) AGAINST(?) ORDER BY BlockedUser.Time DESC LIMIT ? OFFSET ?");
			$getBlocked->bindValue(1, $_GET['q'], PDO::PARAM_STR);
			$getBlocked->bindValue(2, $limit, PDO::PARAM_INT);
			$getBlocked->bindValue(3, $offset, PDO::PARAM_INT);
			$getBlocked->execute();
			
		} else {
			
			$getBlocked = $db->prepare("SELECT BlockedUser.ID AS BlockedID, User.ID, User.Username, User.AvatarURL, BlockedUser.Time FROM BlockedUser JOIN User ON User.ID = BlockedUser.BlockedID WHERE BlockedUser.RequesterID = ".$myU->ID." ORDER BY BlockedUser.Time DESC LIMIT ? OFFSET ?");
			$getBlocked->bindValue(1, $limit, PDO::PARAM_INT);
			$getBlocked->bindValue(2, $offset, PDO::PARAM_INT);
			$getBlocked->execute();
			
		}
	
		echo '
		<input type="text" class="normal-input" onchange="blockedUsers(this.value)" placeholder="Search" value="'.htmlentities($_GET['q']).'" style="margin:0 auto;">
		<div class="push-25"></div>
		';
	
		$i = 0;
		
		while ($gB = $getBlocked->fetch(PDO::FETCH_OBJ)) {
			
			$i++;
			
			if ($i > 1) {
				echo '<div class="settings-blocked-divider"></div>';
			}
			
			echo '
			<div class="grid-x grid-margin-x align-middle">
				<div class="shrink cell">
					<div class="settings-blocked-avatar" style="background:url('.$cdnName . $gB->AvatarURL.'-thumb.png);background-size:cover;"></div>
				</div>
				<div class="auto cell">
					'.$gB->Username.'
				</div>
				<div class="shrink cell right">
					<form action="" method="POST">
						<input type="submit" class="button button-red" value="Unblock">
						<input type="hidden" name="unblock_blocked_id" value="'.$gB->BlockedID.'">
						<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
					</form>
				</div>
			</div>
			';
			
		}
		
		if ($Count > 0 && $pages > 1) {
			
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '" onclick="blockedUsers(\''.$_GET['q'].'\', '.($page-1).')">Previous <span class="show-for-sr">page</span>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'" onclick="blockedUsers(\''.$_GET['q'].'\', '.($i).')">'.$i.'</li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '" onclick="blockedUsers(\''.$_GET['q'].'\', '.($page+1).')">Next <span class="show-for-sr">page</span>'; } echo '</li>
			</ul>
			';
		
		}
	
	} else {
		
		echo 'No results found.';
		
	}