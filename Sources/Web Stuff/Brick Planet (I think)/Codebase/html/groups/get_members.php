<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");

	$GroupID = (int)$_GET['id'];
	$Rank = (is_numeric((int)$_GET['rank']) && is_int((int)$_GET['rank']) && (int)$_GET['rank'] >= 1 && (int)$_GET['rank'] <= 100) ? (int)$_GET['rank'] : 1;
	
	$countMembers = $db->prepare("SELECT UserGroupRank.MemberCount FROM UserGroupRank JOIN UserGroup ON UserGroupRank.GroupID = UserGroup.ID WHERE UserGroupRank.GroupID = ? AND UserGroupRank.Rank = ? AND UserGroup.IsDisabled = 0");
	$countMembers->bindValue(1, $GroupID, PDO::PARAM_INT);
	$countMembers->bindValue(2, $Rank, PDO::PARAM_INT);
	$countMembers->execute();
	$countMember = $countMembers->fetch(PDO::FETCH_OBJ);
	
	if ($countMembers->rowCount() == 0 || $countMember->MemberCount == 0) {
		
		echo '
		<div class="grid-x grid-margin-x">
			<div class="auto cell">
				No members found in this rank.
			</div>
		</div>
		';
		
	} else {
		
		$limit = 8;
		
		$pages = ceil($countMember->MemberCount / $limit);
			
		$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
			'options' => array(
				'default'   => 1,
				'min_range' => 1,
			),
		)));
			
		$offset = ($page - 1)  * $limit;
		if ($offset < 0) { $offset = 0; }
		
		$getMembersByRank = $db->prepare("SELECT User.Username, User.AvatarURL, User.TimeLastSeen FROM UserGroupMember JOIN User ON UserGroupMember.UserID = User.ID WHERE UserGroupMember.GroupID = ? AND UserGroupMember.Rank = ? ORDER BY UserGroupMember.ID DESC LIMIT ? OFFSET ?");
		$getMembersByRank->bindValue(1, $GroupID, PDO::PARAM_INT);
		$getMembersByRank->bindValue(2, $Rank, PDO::PARAM_INT);
		$getMembersByRank->bindValue(3, $limit, PDO::PARAM_INT);
		$getMembersByRank->bindValue(4, $offset, PDO::PARAM_INT);
		$getMembersByRank->execute();
		
		echo '<div class="grid-x grid-margin-x view-group-member">';
		
		while ($gM = $getMembersByRank->fetch(PDO::FETCH_OBJ)) {
			
			$UserOnlineColor = ($gM->TimeLastSeen + 600 > time()) ? '56A902' : 'AAAAAA';
			$StatusSpan = '<span class="user-online-status" style="background:#'.$UserOnlineColor.';"></span>';
			
			echo '
			<div class="large-3 cell">
				<a href="'.$serverName.'/users/'.$gM->Username.'/"><img src="'.$cdnName . $gM->AvatarURL.'.png"></a>
				<a href="'.$serverName.'/users/'.$gM->Username.'/" class="no-text-decoration"><div class="view-group-member-name">'.$StatusSpan.'<span>'.$gM->Username.'</span></div></a>
			</div>
			';
			
		}
		
		echo '</div>';
		
		if ($pages > 1) {
		
			echo '
			<div class="push-25"></div>
			<ul class="pagination" role="navigation" aria-label="Pagination">
				<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="#" onclick="switchRank('.$Rank.', '.($page-1).')">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
				';

				for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
					
					if ($i <= $pages) {
					
						echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="#" onclick="switchRank('.$Rank.', '.($i).')">'.$i.'</a></li>';

					}
					
				}

				echo '
				<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="#" onclick="switchRank('.$Rank.', '.($page+1).')">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
			</ul>
			';
		
		}
		
	}