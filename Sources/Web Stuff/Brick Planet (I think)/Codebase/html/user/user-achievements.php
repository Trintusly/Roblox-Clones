<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (empty($_GET['u'])) {
		
		header("Location: /search/");
		die;
		
	}
	
	$getUser = $db->prepare("SELECT ID, Username FROM User WHERE Username = ?");
	$getUser->bindValue(1, $_GET['u'], PDO::PARAM_STR);
	$getUser->execute();
	
	if ($getUser->rowCount() == 0) {
		
		header("Location: /search/");
		die;
		
	}
	
	$gU = $getUser->fetch(PDO::FETCH_OBJ);
	
	$getBadges = $db->prepare("SELECT * FROM UserBadge WHERE UserID = ".$gU->ID." ORDER BY ID LIMIT 8");
	$getBadges->execute();
	
	echo '
	<h4>'.$gU->Username.'\'s Achievements</h4>
	<div class="container border-r md-padding">
		<div class="grid-x grid-margin-x align-middle">
		';
	
		while ($gB = $getBadges->fetch(PDO::FETCH_OBJ)) {
			
			if ($gB->Name == "Admin") {
				$name = "Brick Create Staff";
				$description = "This achievement is for Brick Create's official employees.";
				$className = "employee"; 
			}
			
			if ($gB->Name == "RespectTheVet") {
				$name = "Respect The Veteran";
				$description = "You heard it, newbie! Respect your elders! This achievement is awarded to users 1 year or older.";
				$className = "respect-the-vet";
			}
			
			echo '
			<div class="large-2 cell achievement-container text-center">
				<div class="achievement-'.$className.'"></div>
				<div class="achievement-title">'.$name.'</div>
				<div class="achievement-info">
					<div class="achievement-title">'.$name.'</div>
					<div class="achievement-border"></div>
					<div class="achievement-description">
						'.$description.'
					</div>
				</div>
			</div>
			';

		}
		
		echo '
		</div>
	</div>
	';