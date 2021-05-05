<?php
$page = 'groups';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	echo '
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4>Groups</h4>
		</div>
		<div class="shrink cell right no-margin">
			';

			if ($AUTH) {

				echo '
				<a href="'.$serverName.'/creator-area/create/group/" class="button button-green">Create</a>
				';

			}

			echo '
		</div>
	</div>
	<div class="push-15"></div>
	<div class="container md-padding border-r">
		';

		if (!isset($_GET['category']) && !isset($_GET['search'])) {

			$limit = 10;

			$countGroups = $db->prepare("SELECT COUNT(*) FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE UserGroup.IsDisabled = 0");
			$countGroups->execute();

			$pages = ceil($countGroups->fetchColumn() / $limit);

			$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
				'options' => array(
					'default'   => 1,
					'min_range' => 1,
				),
			)));

			$offset = ($page - 1)  * $limit;
			if ($offset < 0) { $offset = 0; }

			$getGroups = $db->prepare("SELECT UserGroup.ID, UserGroup.GroupCategory, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, UserGroup.IsVerified, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroup.JoinType, UserGroup.MemberCount FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE UserGroup.IsDisabled = 0 ORDER BY UserGroup.MemberCount DESC LIMIT ? OFFSET ?");
			$getGroups->bindValue(1, $limit, PDO::PARAM_INT);
			$getGroups->bindValue(2, $offset, PDO::PARAM_INT);
			$getGroups->execute();

		} else {

			$Category = (is_int((int)$_GET['category']) && (int)$_GET['category'] >=0 && (int)$_GET['category'] <= 4) ? (int)$_GET['category'] : 0;

			$countGroups = $db->prepare("SELECT COUNT(*) FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE UserGroup.GroupCategory = ? AND MATCH(UserGroup.Name) AGAINST(?) AND UserGroup.OwnerID != 1 AND UserGroup.IsDisabled = 0");
			$countGroups->execute();

			$limit = 1;

			$pages = ceil($countGroups->fetchColumn() / $limit);

			$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
				'options' => array(
					'default'   => 1,
					'min_range' => 1,
				),
			)));

			$offset = ($page - 1)  * $limit;
			if ($offset < 0) { $offset = 0; }

			$getGroups = $db->prepare("SELECT UserGroup.ID, UserGroup.Name, UserGroup.SEOName, UserGroup.Description, UserGroup.IsVerified, (CASE WHEN UserGroup.OwnerType = 0 THEN User.Username ELSE UG.Name END) AS OwnerName, UserGroup.OwnerID, UserGroup.OwnerType, (CASE UserGroup.LogoStatus WHEN 0 THEN 'pending.png' WHEN 1 THEN UserGroup.LogoImage WHEN 2 THEN 'rejected.png' END) AS LogoImage, UserGroup.JoinType, UserGroup.MemberCount FROM UserGroup JOIN User ON UserGroup.OwnerID = User.ID JOIN UserGroup UG ON UG.ID = (CASE WHEN UserGroup.OwnerType = 0 THEN UserGroup.ID ELSE UserGroup.OwnerID END) WHERE UserGroup.GroupCategory = ? AND MATCH(UserGroup.Name) AGAINST(?) AND UserGroup.IsDisabled = 0 ORDER BY UserGroup.MemberCount DESC");
			$getGroups->bindValue(1, $Category, PDO::PARAM_INT);
			$getGroups->bindValue(2, $_GET['search'], PDO::PARAM_STR);
			$getGroups->execute();

		}

		if ($getGroups->rowCount() == 0) {

			echo '<div class="grid-x grid-margin-x"><div class="auto cell">No results found. Try refining your search.</div></div>';

		} else {

			$i = 0;

			while ($gG = $getGroups->fetch(PDO::FETCH_OBJ)) {

				$i++;

				if ($i > 1) {
					echo '<div class="group-divider"></div>';
				}

				echo '
				<div class="grid-x grid-margin-x group-table">
					<div class="large-2 medium-3 small-4 cell center-text">
						<a href="'.$serverName.'/groups/'.$gG->ID.'/'.str_replace(' ', '-', $gG->Name).'/" class="gt-link">
							<img src="'.$cdnName . $gG->LogoImage.'">
						</a>
						<div class="clearfix gt-info">
							<div class="left">
								<strong>Owner:</strong>
							</div>
							<div class="right">
								';

								if ($gG->OwnerID == -1) {

									echo '<strong>No One</strong>';

								} else if ($gG->OwnerType == 0) {

									echo '<a href="'.$serverName.'/users/'.$gG->OwnerName.'/">'.$gG->OwnerName.'</a>';

								} else {

									echo '<a href="'.$serverName.'/groups/'.$gG->OwnerID.'/'.str_replace(' ', '-', $gG->OwnerName).'/">'.$gG->OwnerName.'</a>';

								}

								echo '
							</div>
						</div>
						<div class="clearfix gt-info">
							<div class="left">
								<strong>Members:</strong>
							</div>
							<div class="right">
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

	echo '</div>';

	if ($pages > 1) {

		echo '
		<div class="push-25"></div>
		<ul class="pagination" role="navigation" aria-label="Pagination">
			<li class="pagination-previous'; if ($page == 1) { echo ' disabled">Previous <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups?page='.($page-1).'">Previous <span class="show-for-sr">page</span></a>'; } echo '</li>
			';

			for ($i = max(1, $page - 5); $i <= min($page + 5, $pages); $i++) {

				if ($i <= $pages) {

					echo '<li'; if ($page == $i) { echo ' class="current"'; } echo ' aria-label="Page '.$i.'"><a href="'.$serverName.'/groups?page='.($i).'">'.$i.'</a></li>';

				}

			}

			echo '
			<li class="pagination-next'; if ($page == $pages) { echo ' disabled" aria-label="Previous page">Next <span class="show-for-sr">page</span>'; } else { echo '"><a href="'.$serverName.'/groups?page='.($page+1).'">Next <span class="show-for-sr">page</span></a>'; } echo '</li>
		</ul>
		';

	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
