<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();
	
	echo '
	<div class="grid-x grid-margin-x">
		<div class="large-2 cell">&nbsp;</div>
		<div class="large-8 cell">
			<div class="container-header strong md-padding">
				Verify Discord Account
			</div>
			<div class="container border-r lg-padding">
			';
			
			if ($myU->DiscordId == 0) {
				
				$CountPendingRequests = $db->prepare("SELECT `Key` FROM UserDiscordVerify WHERE UserID = ".$myU->ID." AND TimeInitiated+900 > ".time()."");
				$CountPendingRequests->execute();
				$PendingRequests = $CountPendingRequests->rowCount();
				
				if ($PendingRequests == 0) {
					
					if (isset($_POST['generate_code'])) {
						
						$GeneratedCode = generateRandomString(24);
						
						$InsertUserDiscordVerify = $db->prepare("INSERT INTO UserDiscordVerify (UserID, `Key`, TimeInitiated) VALUES(".$myU->ID.", '".$GeneratedCode."', ".time().")");
						$InsertUserDiscordVerify->execute();
						
						header("Location: ".$serverName."/account/discord-verify.php");
						die;
						
					}
					
					echo '
					<div class="discord-verification-ico"><i class="material-icons">verified_user</i></div>
					<div class="discord-verification-heading-text">Verify your account on our Discord</div>
					<div class="discord-verification-text">Click the \'Generate\' button below to generate a unique key which you will then DM to our bot.</div>
					<div class="discord-verification-button">
						<form action="" method="POST">
							<input type="submit" name="generate_code" value="Generate Code" class="button button-green">
						</form>
					</div>
					';
				
				} else {
					
					$RequestKey = $CountPendingRequests->fetchColumn();
					
					echo '
					<div class="discord-verification-ico"><i class="material-icons">timelapse</i></div>
					<div class="discord-verification-heading-text">Verify your account on our Discord</div>
					<div class="discord-verification-text">To finish this process, DM the code posted below to our verification bot.<br /><strong>Brick Create Verification#2870</strong></div>
					<div class="discord-verification-heading-text">'.$RequestKey.'</div>
					';
					
				}
				
			} else if ($myU->DiscordId > 0) {
				
				echo '
				<div class="discord-verified-ico"><i class="material-icons">verified_user</i></div>
				<div class="discord-verified-text">You have verified your account on our Discord</div>
				<div class="discord-verified-footnotes">If you would like to de-link your Discord account, contact us at <a href="mailto:hello@brickcreate.com">hello@brickcreate.com</a></div>
				';
				
			}
			
			echo '
			</div>
		</div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");