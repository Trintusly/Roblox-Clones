<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireLogin();
	
	if ($myU->AccountRestricted == 0) {
		
		header("Location: ".$serverName."/"); 
		die; 
		
	} else {
		
		$getBan = $db->prepare("SELECT * FROM UserBanHistory WHERE UserID = ".$myU->ID." ORDER BY TimeBan DESC LIMIT 1");
		$getBan->execute();
		$gB = $getBan->fetch(PDO::FETCH_OBJ);
		
		if ($gB->TimeUnban == 0 || $gB->TimeUnban == 1) {
			$TimeUnban = $gB->TimeUnban;
		} else {
			$TimeUnban = $gB->TimeUnban - $gB->TimeBan;
		}
		
		switch ($TimeUnban) {
			case 0:
				$phrase = 'Account Closed';
				$terminology = 'Your account has been permanently closed.';
				break;
			case 1:
				$phrase = 'Reminder';
				$terminology = 'Suspensions are serious, and multiple violations of rules we expect our community to adhere to may result in permanent closure of your account.';
				break;
			case 43200:
				$phrase = '12 Hours';
				$terminology = 'Suspensions are serious, and multiple violations of rules we expect our community to adhere to may result in permanent closure of your account.';
				break;
			case 86400:
				$phrase = '1 Day';
				$terminology = 'Suspensions are serious, and multiple violations of rules we expect our community to adhere to may result in permanent closure of your account.';
				break;
			case 259200:
				$phrase = '3 Days';
				$terminology = 'Suspensions are serious, and multiple violations of rules we expect our community to adhere to may result in permanent closure of your account.';
				break;
			case 604800:
				$phrase = '7 Days';
				$terminology = 'Suspensions are serious, and multiple violations of rules we expect our community to adhere to may result in permanent closure of your account.';
				break;
			case 1209600:
				$phrase = '14 Days';
				$terminology = 'Suspensions are serious, and multiple violations of rules we expect our community to adhere to may result in permanent closure of your account.';
				break;
		}
		
		switch ($gB->BanCategory) {
			case 1:
				$BanCategory = 'Spam';
				break;
			case 2:
				$BanCategory = 'Profanity';
				break;
			case 3:
				$BanCategory = 'Sensitive Topics';
				break;
			case 4:
				$BanCategory = 'Offsite Links';
				break;
			case 5:
				$BanCategory = 'Harassment';
				break;
			case 6:
				$BanCategory = 'Discrimination';
				break;
			case 7:
				$BanCategory = 'Exploiting';
				break;
			case 8:
				$BanCategory = 'Sexual Content';
				break;
			case 9:
				$BanCategory = 'Inappropriate Content';
				break;
			case 10:
				$BanCategory = 'Other';
				break;
		}
		
		echo '
		<style>
			.suspended-header-icon i {
				font-size: 18px;
				margin-right: 10px;
				vertical-align: middle;
			}
			
			.suspended-divider {
				margin: 15px 0;
				background: #373840;
				width: 100%;
				height: 1px;
			}
			
			.suspended-content {
				background: #383945;
				box-shadow: 0 1px 1px #121721;
				padding: 15px;
				border-radius: 5px;
			}
		</style>
		<div class="grid-x grid-margin-x">
			<div class="large-8 large-offset-2 cell">
				<div class="container-header md-padding">
					<strong><span class="suspended-header-icon"><i class="material-icons">gavel</i></span><span>Suspension issued against account</span></strong>
				</div>
				<div class="container border-wh md-padding">
					<div>A suspension has been issued against your account for violating our community guidelines and/or terms and conditions. '.$terminology.'</div>
					<div class="suspended-divider"></div>
					<div class="grid-x grid-margin-x">
						<div class="large-4 cell"><p>Length: <strong>'.$phrase.'</strong></p></div>
						<div class="large-4 cell"><p>Reason provided: <strong>'.$BanCategory.'</strong></p></div>
						<div class="large-4 cell"><p>Issued on: <strong>'.date('m/d/y g:iA', $gB->TimeBan).'</strong></p></div>
					</div>
					';
					
					if (!empty($gB->Content)) {
						echo '
						<div class="push-15"></div>
						<div class="grid-x grid-margin-x">
							<div class="auto cell">
								<div class="suspended-content">
									<strong>You said:</strong>
									<div><i>'.nl2br($gB->Content).'</i></div>
								</div>
							</div>
						</div>
						';
					}
					
					if (!empty($gB->ModNote)) {
						echo '
						<div class="push-15"></div>
						<div class="grid-x grid-margin-x">
							<div class="auto cell">
								From Website Staff: <strong>'.$gB->ModNote.'</strong>
							</div>
						</div>
						';
					}
					
					echo '
					<div class="suspended-divider"></div>
					';
					
					if ($gB->TimeUnban > 1 && $gB->TimeUnban > time()) {
						
						echo '
						<form action="" method="POST" style="margin-top:10px;">
							Your suspension may be lifted on or after <strong>'.date('m/d/y g:iA', $gB->TimeUnban).'</strong>
						</form>
						';
						
					} else if ($gB->TimeUnban == 0) {
						
						echo '
						<form action="" method="POST" style="margin-top:10px;">
							Your account has been closed. Please contact moderation@brickcreate.com if you feel that this suspension was issued in error.
						</form>
						';
						
					} else {
						
						echo '
						<form action="" method="POST">
							<input type="checkbox" class="filled-in" name="iagree" id="iagree"> <label for="iagree">I agree to follow the <a href="'.$serverName.'/about/terms-of-service/" target="_blank" style="color:#efefef;font-weight:bold;">terms and conditions</a>.</label>
							<div class="push-15"></div>
							<input type="submit" class="button button-green" name="reactivateAccount" id="reactivateAccount" value="Reactivate Account" style="width:100%;display:none;">
						</form>
						';
						
					}
					
					echo '
				</div>
				<div class="push-25"></div>
				<form action="" method="POST">
					<input type="submit" class="button button-grey right" name="logoutButton" value="Logout Here">
				</form>
			</div>
		</div>
		';
		
		if (isset($_POST['logoutButton'])) { 
			unset($_SESSION['UserID']); 
			unset($_SESSION['password']); 
			unset($_SESSION['useragent']); 
			unset($_SESSION['ip']); 
			if (isset($_SESSION['GlobalSecurityToken'])) {
				unset($_SESSION['GlobalSecurityToken']);
			}
			
			header("Location: /"); 
			die; 
		}
		
		if (isset($_POST['reactivateAccount'])) {
			if ($gB->TimeUnban > 0) {
				if ($gB->TimeUnban < time()) {
					$changeStatus = $db->prepare("UPDATE UserBanHistory SET `Status` = 1 WHERE ID = ".$gB->ID."");
					$changeStatus->execute();
					$unbanUser = $db->prepare("UPDATE User SET AccountRestricted = 0 WHERE ID = ".$myU->ID."");
					if ($unbanUser->execute()) {
						$cache->delete($myU->ID);
						
						header("Location: /");
						die();
					}
				}
			}
		}
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
?>
	<script type="text/javascript">
	$(document).ready(function() {

		var $submit = $("#reactivateAccount").hide(),
			$cbs = $('input[name="iagree"]').click(function() {
				$submit.toggle( $cbs.is(":checked") );
			});

	});
	</script>