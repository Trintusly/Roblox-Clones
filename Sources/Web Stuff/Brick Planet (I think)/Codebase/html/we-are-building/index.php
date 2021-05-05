<?php
$wearebuilding = true;
require_once($_SERVER['DOCUMENT_ROOT']."/../private/config.php");
	if ($SiteSettings->Maintenance) {

		echo '
		<!DOCTYPE html>
			<head>
				<title>Maintenance - Brick Create</title>
				<meta charset="utf-8">
				<meta http-equiv="x-ua-compatible" content="ie=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<meta http-equiv="refresh" content="120;URL='.$serverName.'" />
				<link rel="stylesheet" href="'.$serverName.'/assets/css/foundation.css">
				<link rel="stylesheet" href="additives/css/css1_0fd5d35fafae7ac14d19e67c40141e5f.css">
			</head>
			<body>
				<div class="overlay"></div>
				<div class="container-wrapper">
					<div class="grid-container">
						<div class="bp-offline-container">
							<div class="grid-x align-middle grid-margin-x">
								<div class="shrink cell">
									<div class="bp-brickspinner"></div>
								</div>
								<div class="auto cell">
									<h1>Brick Create is offline.</h1>
								</div>
							</div>
							<div class="divider"></div>
							<p>Brick Create is offline while we perform upgrades to our platform. These updates shouldn\'t take long if all goes to plan. There\'s no need to keep checking in&mdash;we will redirect you back to your homepage when we are finished. Thank you for your patience!</p>
						</div>
					</div>
				</div>
				<div class="reveal item-modal" id="MaintenanceModal" data-reveal data-animation-in="fade-in" data-animation-out="fade-out">
					<div class="grid-x grid-margin-x align-middle">
						<div class="auto cell no-margin">
							<div class="modal-title">Brick Create Login</div>
						</div>
						<div class="shrink cell no-margin">
							<button class="close-button" data-close aria-label="Close modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
					</div>
					<form action="" method="post">
						<p><input type="password" class="normal-input" name="bp-devlogin" placeholder="Password"></p>
					</form>
				</div>
				<a class="devbutton" data-open="MaintenanceModal">&nbsp;</a>
				<script src="additives/js/9f6e6800cfae7749eb6c486619254b9c.js"></script>
				<script src="additives/js/camera_ba248c985ace94863880921d8900c53f.js"></script>
				<script src="'.$serverName.'/assets/js/vendor/jquery.js"></script>
				<script src="'.$serverName.'/assets/js/vendor/foundation.js"></script>
				<script>
				$(document).ready(function(){
					$(document).foundation();
				});
				</script>
			</body>
		</html>
		';

		if (isset($_POST['bp-devlogin']) && !empty($_POST['bp-devlogin'])) {

			$PassCodes = array('x5(F[sT7j?}g,Dk');

			if (in_array($_POST['bp-devlogin'], $PassCodes)) {

				$_SESSION['GlobalSecurityToken'] = 1;

				header("Location: ".$serverName."/log-in/");
				die;

			}
		}

	} else {

		header("Location: ".$serverName."/");
		die;

	}

	/*<div class="grid-x align-middle grid-margin-x">
		<div class="shrink cell">
			<div class="offline-downtime-text">Estimated Downtime:</div>
		</div>
		<div class="auto cell">
			<div id="countdown" class="offline-downtime-counter">
				<span class="days"></span> days
				&nbsp;
				<span class="hours"></span> hours
				&nbsp;
				<span class="minutes"></span> minutes
			</div>
		</div>
	</div>*/
?>