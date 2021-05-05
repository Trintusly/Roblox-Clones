<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	$getUser = $db->prepare("SELECT User.ID, User.Username, User.NumGroups FROM User WHERE Username = ?");
	$getUser->bindValue(1, $_GET['username'], PDO::PARAM_STR);
	$getUser->execute();
	
	if ($getUser->rowCount() == 0) {
		
		header("Location: ".$serverName."");
		die;
		
	}
	
	$gU = $getUser->fetch(PDO::FETCH_OBJ);
	
	$limit = 10;
	
	$pages = ceil($gU->NumGroups / $limit);
	
	if (!isset($_GET['page'])) { $page = 1; }
	
	$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
		'options' => array(
			'default'   => 1,
			'min_range' => 1,
		),
	)));
		
	$offset = ($page - 1)  * $limit;

	$getGroups = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, UserGroup.IsVerified, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.MemberCount FROM UserGroupMember JOIN UserGroup ON UserGroupMember.GroupID = UserGroup.ID JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE UserGroupMember.UserID = ".$gU->ID." ORDER BY UserGroupMember.ID DESC LIMIT ? OFFSET ?");
	$getGroups->bindValue(1, $limit, PDO::PARAM_INT);
	$getGroups->bindValue(2, $offset, PDO::PARAM_INT);
	$getGroups->execute();

	echo '
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4 style="margin:0;"><strong>'.$gU->Username.'</strong> is a member of '.number_format($gU->NumGroups).' group'; if ($gU->NumGroups != 1) { echo 's'; } echo '</h4>
		</div>
		<div class="shrink cell right no-margin">
			<a href="'.$serverName.'/users/'.$gU->Username.'/" class="button button-grey" style="padding: 8px 15px;font-size:13px;line-height:1.25;">Return to Profile</a>
		</div>
	</div>
	<div class="push-10"></div>
	<div class="container border-r md-padding">
		';
		
		if ($getGroups->rowCount() == 0) {
			
			echo '
			<div class="grid-x grid-margin-x">
				<div class="auto cell">
					This user is not a member of any groups.
				</div>
			</div>
			';
			
		} else {
			
			$i = 0;
			
			while ($gG = $getGroups->fetch(PDO::FETCH_OBJ)) {
				
				$i++;
				
				if ($i > 1) {
					echo '<div class="group-divider"></div>';
				}
				
				switch ($gG->JoinType) {
					case 0:
						$JoinType = 'Public';
						break;
					case 1:
						$JoinType = 'Private';
						break;
					case 2:
						$JoinType = 'Invite Only';
						break;
				}
				
				echo '
				<div class="grid-x grid-margin-x group-table">
					<div class="large-2 medium-3 small-4 cell center-text">
						<a href="'.$serverName.'/groups/'.$gG->ID.'/'.$gG->SEOName.'/" class="gt-link"><img src="'.$cdnName . $gG->LogoImage.'"></a>
						<div class="grid-x grid-margin-x align-middle gt-info">
							<div class="large-6 medium-6 small-6 cell">
								<strong>Owner:</strong>
							</div>
							<div class="large-6 medium-6 small-6 cell text-right">
								'; if ($gG->OwnerID == -1) { echo '<strong>No One</strong>'; } else if ($gG->OwnerType == 0) { echo '<a href="'.$serverName.'/users/'.$gG->OwnerName.'/">'.$gG->OwnerName.'</a>'; } else { echo '<a href="'.$serverName.'/groups/'.$gG->OwnerID.'/'.str_replace(' ', '-', $gG->OwnerName).'/">'.$gG->OwnerName.'</a>'; } echo '
							</div>
							<div class="large-6 medium-6 small-6 cell">
								<strong>Members:</strong>
							</div>
							<div class="large-6 medium-6 small-6 cell text-right">
								'.number_format($gG->MemberCount).'
							</div>
						</div>
					</div>
					<div class="large-10 medium-9 small-8 cell">
						<div class="gt-title"><a href="'.$serverName.'/groups/'.$gG->ID.'/'.$gG->SEOName.'/"><span>'.$gG->Name.'</span>'; if ($gG->IsVerified == 1) { echo '<span><a href="https://helpme.brickcreate.com/hc/en-us/articles/115003048633" target="_BLANK"><div style="display:inline;padding-left:7px;"><span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" title="This group is verified."><img src="/assets/images/groups/verified-ico32x32.png" style="height:20px;width:20px;"></span></div></a></span>'; } echo '</a></div>
						<div class="gt-description">'.LimitTextByWords($gG->Description, 100).'</div>
					</div>
				</div>
				';
				
			}
			
		}
		
		echo '
	</div>
	<div class="push-25"></div>
	';
	
	if ($pages > 1) {
		
		echo '
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/user/'.$gU->Username.'/groups/?page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {
				
				if ($i <= $pages) {
				
					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/user/'.$gU->Username.'/groups/?page='.($i).'">'.$i.'</a></li>';

				}
				
			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/user/'.$gU->Username.'/groups/?page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';
	
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");