<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	/* Categories 
	
	1 = Community
	2 = Gameplay
	3 = Event

	*/

	$fetchCommunityAchievements = $db->prepare("SELECT * FROM Achievement WHERE Category = 1 ORDER BY ID ASC");
	$fetchCommunityAchievements->execute();
	
	$fetchMembershipAchievements = $db->prepare("SELECT * FROM Achievement WHERE Category = 2 ORDER BY ID ASC");
	$fetchMembershipAchievements->execute();
	
	$fetchGameplayAchievements = $db->prepare("SELECT * FROM Achievement WHERE Category = 3 ORDER BY ID ASC");
	$fetchGameplayAchievements->execute();
	
	$fetchEventAchievements = $db->prepare("SELECT * FROM Achievement WHERE Category = 4 ORDER BY ID ASC");
	$fetchEventAchievements->execute();
	
	echo '
	<h3>Achievements</h3>
	<h5>Community</h5>
	<div class="container border-r md-padding">
		<div class="grid-x grid-margin-x align-middle">
		<style>
			.achievement-special {
				color: gold!important;
			}
			.achievement-text-small {
				font-size: 13px!important;
			}
		</style>
		';
		
		while ($fCA = $fetchCommunityAchievements->fetch(PDO::FETCH_OBJ)) {
			
			if ($fCA->Special == 1) {
				$specialClass = " achievement-special";
				$subText = "<br /><font class='achievement-text-small'>(special)</font>";
			} else {
				$specialClass = "";
				$subText = "";
			}

			echo '
			<div class="large-2 cell achievement-container text-center">
				<div class="achievement-image" style="background-image:url('.$cdnName.'assets/images/profile/'.$fCA->Image.'"></div>
				<div class="achievement-title'.$specialClass.'">
					'.$fCA->Name.'
				</div>
				<div class="achievement-info">
					<div class="achievement-title'.$specialClass.'">
						'.$fCA->Name.'
						'.$subText.'
					</div>
					<div class="achievement-border"></div>
					<div class="achievement-description">
						<div class="padding-desc">
							'.$fCA->Description.'
						</div>
					</div>
				</div>
			</div>
			';
		
		}
	
		echo '
		</div>
	</div>
	<div class="push-25"></div>
	<h5>Membership</h5>
	<div class="container border-r md-padding">
		<div class="grid-x grid-margin-x align-middle">
		';
		
		if ($fetchMembershipAchievements->rowCount() == 0) {
			echo '
			No achievements have been added to this category. Check back later!
			';
		} else {
			while ($fMA = $fetchMembershipAchievements->fetch(PDO::FETCH_OBJ)) {

				if ($fMA->Special == 1) {
					$specialClass = " achievement-special";
					$subText = "<font class='achievement-text-small'>(special)</font>";
				} else {
					$specialClass = "";
					$subText = "";
				}

				echo '
				<div class="large-2 cell achievement-container text-center">
					<div class="achievement-image" style="background-image:url('.$cdnName.'assets/images/profile/'.$fMA->Image.'"></div>
					<div class="achievement-title'.$specialClass.'">
						'.$fMA->Name.'
					</div>
					<div class="achievement-info">
						<div class="achievement-title'.$specialClass.'">
							'.$fMA->Name.'
							'.$subText.'
						</div>
						<div class="achievement-border"></div>
						<div class="achievement-description">
							<div class="padding-desc">
								'.$fMA->Description.'
							</div>
						</div>
					</div>
				</div>
				';
			
			}
		}
	
		echo '
		</div>
	</div>
	<div class="push-25"></div>
	<h5>Gameplay</h5>
	<div class="container border-r md-padding">
		<div class="grid-x grid-margin-x align-middle">
		';
		
		if ($fetchGameplayAchievements->rowCount() == 0) {
			echo '
			No achievements have been added to this category. Check back later!
			';
		} else {
			while ($fGA = $fetchGameplayAchievements->fetch(PDO::FETCH_OBJ)) {

				if ($fGA->Special == 1) {
					$specialClass = " achievement-special";
					$subText = "<font class='achievement-text-small'>(special)</font>";
				} else {
					$specialClass = "";
					$subText = "";
				}

				echo '
				<div class="large-2 cell achievement-container text-center">
					<div class="achievement-image" style="background-image:url('.$cdnName.'assets/images/profile/'.$fGA->Image.'"></div>
					<div class="achievement-title'.$specialClass.'">
						'.$fGA->Name.'
					</div>
					<div class="achievement-info">
						<div class="achievement-title'.$specialClass.'">
							'.$fGA->Name.'
							'.$subText.'
						</div>
						<div class="achievement-border"></div>
						<div class="achievement-description">
							<div class="padding-desc">
								'.$fGA->Description.'
							</div>
						</div>
					</div>
				</div>
				';
			
			}
		}
	
		echo '
		</div>
	</div>
	<div class="push-25"></div>
	<h5>Event</h5>
	<div class="container border-r md-padding">
		<div class="grid-x grid-margin-x align-middle">
		';
		
		if ($fetchEventAchievements->rowCount() == 0) {
			echo '
			No achievements have been added to this category. Check back later!
			';
		} else {
			while ($fEA = $fetchEventAchievements->fetch(PDO::FETCH_OBJ)) {

				if ($fEA->Special == 1) {
					$specialClass = " achievement-special";
					$subText = "<font class='achievement-text-small'>(special)</font>";
				} else {
					$specialClass = "";
					$subText = "";
				}

				echo '
				<div class="large-2 cell achievement-container text-center">
					<div class="achievement-image" style="background-image:url('.$cdnName.'assets/images/profile/'.$fEA->Image.'"></div>
					<div class="achievement-title'.$specialClass.'">
						'.$fEA->Name.'
					</div>
					<div class="achievement-info">
						<div class="achievement-title'.$specialClass.'">
							'.$fEA->Name.'
							'.$subText.'
						</div>
						<div class="achievement-border"></div>
						<div class="achievement-description">
							<div class="padding-desc">
								'.$fEA->Description.'
							</div>
						</div>
					</div>
				</div>
				';
			
			}
		}
	
		echo '
		</div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");