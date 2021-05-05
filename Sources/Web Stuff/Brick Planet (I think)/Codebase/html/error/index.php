<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	$errorcode = $_GET['errorcode'];
	
	if (empty($errorcode) OR !isset($errorcode)) {
		
		header("Location: ".$serverName."/error/?errorcode=404");
		die;
		
	} else if ($errorcode == 404) {
		
		//$last_page = $_SERVER['HTTP_REFERER'];
		
		/* if (substr($last_page, 0, 28) == 'https://www.brickcreate.com/') {
			
			function generateRandomString($length = 10) {
				return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
			}
			
			$random_string = strtoupper(generateRandomString(20));
			
			$insert = $db->prepare("INSERT INTO IncidentLogs (UserID, LastPage, CurrentPage, Time, IP, ErrorType, ReferenceCode) VALUES(?, ?, ?, ?, ?, ?, ?)");
			$insert->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$insert->bindValue(2, $last_page, PDO::PARAM_STR);
			$insert->bindValue(3, $serverName . $_SERVER['PHP_SELF'], PDO::PARAM_STR);
			$insert->bindValue(4, time(), PDO::PARAM_INT);
			$insert->bindValue(5, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$insert->bindValue(6, 404, PDO::PARAM_INT);
			$insert->bindValue(7, $random_string, PDO::PARAM_STR);
			$insert->execute(); 
			
		} */
		
		echo '
		<script type="text/javascript">
			document.title = "Error 404 - Brick Create";
		</script>
		<div class="container lg-padding border-r">
			<div class="grid-x grid-margin-x">
				<div class="small-3 cell text-left error-border-right show-for-large">
					<p><h5>Helpful Links</h5></p>
					<li><a href="'.$serverName.'/">Return Home</a></li>
					<li><a href="'.$serverName.'/forum/">Community Forum</a></li>
					<li><a href="'.$serverName.'/games/">Popular Games</a></li>
					<li><a href="'.$serverName.'/upgrade/">Account Upgrades</a></li>
					<li><a href="'.$serverName.'/account/settings/">Account Settings</a></li>
				</div>
				<div class="small-2 cell text-left hide-for-large"></div>
				<div class="small-9 cell text-center">
					<h1 class="error-messageLarge">404, not found</h1>
					<div class="error-divider"></div>
					<p class="error-subErrorText">The page or resource you have requested could not be found or never existed.</p>
					<p class="error-contactText">If you continue to experience this error and believe it is a mistake, please <a href="'.$serverName.'/about/contact-us/">contact us</a>.</p>
				</div>
			</div>
		</div>
		';
		
		if (isset($random_string)) {
		
			echo '
			<div style="padding-top:25px;">
				<b>Error Code:</b> '.$random_string.'
			</div>
			';
		
		}
		
	} else if ($errorcode == 403) {
		
		//$last_page = $_SERVER['HTTP_REFERER'];
		
		/* if (substr($last_page, 0, 28) == 'https://www.brickcreate.com/') {
			
			function generateRandomString($length = 10) {
				return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
			}
			
			$random_string = strtoupper(generateRandomString(20));
			
			$insert = $db->prepare("INSERT INTO IncidentLogs (UserID, LastPage, CurrentPage, Time, IP, ErrorType, ReferenceCode) VALUES(?, ?, ?, ?, ?, ?, ?)");
			$insert->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$insert->bindValue(2, $last_page, PDO::PARAM_STR);
			$insert->bindValue(3, $serverName . $_SERVER['PHP_SELF'], PDO::PARAM_STR);
			$insert->bindValue(4, time(), PDO::PARAM_INT);
			$insert->bindValue(5, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$insert->bindValue(6, 404, PDO::PARAM_INT);
			$insert->bindValue(7, $random_string, PDO::PARAM_STR);
			$insert->execute(); 
			
		} */
		
		echo '
		<script type="text/javascript">
			document.title = "Error 403 - Brick Create";
		</script>
		<div class="container lg-padding border-r">
			<div class="grid-x grid-margin-x">
				<div class="small-3 cell text-left error-border-right show-for-large">
					<p><h5>Helpful Links</h5></p>
					<li><a href="'.$serverName.'/">Return Home</a></li>
					<li><a href="'.$serverName.'/forum/">Community Forum</a></li>
					<li><a href="'.$serverName.'/games/">Popular Games</a></li>
					<li><a href="'.$serverName.'/upgrade/">Account Upgrades</a></li>
					<li><a href="'.$serverName.'/account/settings/">Account Settings</a></li>
				</div>
				<div class="small-2 cell text-left hide-for-large"></div>
				<div class="small-9 cell text-center">
					<h1 class="error-messageLarge">403, forbidden</h1>
					<div class="error-divider"></div>
					<p class="error-subErrorText">You do not have permission to access the file or resource requested.</p>
					<p class="error-contactText">If you continue to experience this error and believe it is a mistake, please <a href="'.$serverName.'/about/contact-us/">contact us</a>.</p>
				</div>
			</div>
		</div>
		';
		
		if (isset($random_string)) {
		
			echo '
			<div style="padding-top:25px;">
				<b>Error Code:</b> '.$random_string.'
			</div>
			';
		
		}
		
	} else if ($errorcode == 500) {
		
		//$last_page = $_SERVER['HTTP_REFERER'];
		
		/* if (substr($last_page, 0, 28) == 'https://www.brickcreate.com/') {
			
			function generateRandomString($length = 10) {
				return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
			}
			
			$random_string = strtoupper(generateRandomString(20));
			
			$insert = $db->prepare("INSERT INTO IncidentLogs (UserID, LastPage, CurrentPage, Time, IP, ErrorType, ReferenceCode) VALUES(?, ?, ?, ?, ?, ?, ?)");
			$insert->bindValue(1, $myU->ID, PDO::PARAM_INT);
			$insert->bindValue(2, $last_page, PDO::PARAM_STR);
			$insert->bindValue(3, $serverName . $_SERVER['PHP_SELF'], PDO::PARAM_STR);
			$insert->bindValue(4, time(), PDO::PARAM_INT);
			$insert->bindValue(5, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$insert->bindValue(6, 404, PDO::PARAM_INT);
			$insert->bindValue(7, $random_string, PDO::PARAM_STR);
			$insert->execute(); 
			
		} */
		
		echo '
		<script type="text/javascript">
			document.title = "Error 500 - Brick Create";
		</script>
		<div class="container lg-padding border-r">
			<div class="grid-x grid-margin-x">
				<div class="small-3 cell text-left error-border-right show-for-large">
					<p><h5>Helpful Links</h5></p>
					<li><a href="'.$serverName.'/">Return Home</a></li>
					<li><a href="'.$serverName.'/forum/">Community Forum</a></li>
					<li><a href="'.$serverName.'/games/">Popular Games</a></li>
					<li><a href="'.$serverName.'/upgrade/">Account Upgrades</a></li>
					<li><a href="'.$serverName.'/account/settings/">Account Settings</a></li>
				</div>
				<div class="small-2 cell text-left hide-for-large"></div>
				<div class="small-9 cell text-center">
					<h1 class="error-messageLarge">500, internal error</h1>
					<div class="error-divider"></div>
					<p class="error-subErrorText">Oops! Looks like something is going wrong on our end. Press back and try again in a few moments.</p>
					<p class="error-contactText">If you continue to experience this error and believe it is a mistake, please <a href="'.$serverName.'/about/contact-us/">contact us</a>.</p>
				</div>
			</div>
		</div>
		';
		
		if (isset($random_string)) {
		
			echo '
			<div style="padding-top:25px;">
				<b>Error Code:</b> '.$random_string.'
			</div>
			';
		
		}
		
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");