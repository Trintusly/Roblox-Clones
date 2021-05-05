<?php
$page = 'updates';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	echo '
	<script>document.title = "Updates - Brick Create";</script>
	<h4>Updates</h4>
	<div class="push-15"></div>
	';
	
	$getWebUpdates = $db->prepare("SELECT UpdateChangelog.Version, UpdateChangelog.Content, UpdateChangelog.TimeUpdate, User.Username FROM updates.UpdateChangelog JOIN new.User ON UpdateChangelog.UserID = User.ID WHERE UpdateChangelog.ProductID = 0 ORDER BY UpdateChangelog.TimeUpdate DESC");
	$getWebUpdates->execute();
	
	while ($gW = $getWebUpdates->fetch(PDO::FETCH_OBJ)) {
		
		echo '
		<div class="container-header strong md-padding">
			<div class="grid-x grid-margin-x align-middle">
				<div class="auto cell no-margin">
					Web Update - '.$gW->Version.' ('.$gW->Username.')
				</div>
				<div class="shrink cell no-margin">
					'.date('m/d/Y', $gW->TimeUpdate).'
				</div>
			</div>
		</div>
		<div class="container border-wh md-padding">
			'.nl2br($gW->Content).'
		</div>
		<div class="push-25"></div>
		';
		
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");