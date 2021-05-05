<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (isset($_GET['action']) && $_GET['action'] == 'send' && ($myU->LastAccountVerifiedAttempt == 0 || $myU->LastAccountVerifiedAttempt+3600 < time())) {
		
		$key = generateRandomString(20);
		
		if ($myU->LastAccountVerifiedAttempt != 0) {
			$Delete = $db->prepare("DELETE FROM UserVerifyEmail WHERE UserID = ".$myU->ID."");
			$Delete->execute();
		}
		
		$Insert = $db->prepare("INSERT INTO UserVerifyEmail (UserID, TimeSent, VerifyType, VerifyCode) VALUES(".$myU->ID.", ".time().", 0, '".$key."')");
		$Insert->execute();
		
		if ($Insert->rowCount() > 0) {
			
			$message = '
			<html>
				<head>
					<style>
						@import url("https://fonts.googleapis.com/css?family=Open+Sans:400,600,700");
						.email-body {
							width: 575px;
							height: 100%;
							background: #F1F1F1;
							margin: 0 auto;
							font-family: "Open Sans", sans-serif;
						}
						.bp-email-header {
							width: 100%;
							padding: 15px 0;
						}
						
						.bp-email-image {
							background:url(https://cdn.bp.com/web/01_logo_site_main.png) no-repeat;
							background-size: 154px 20px;
							width: 154px;
							height: 20px;
							margin: 0 auto;
							margin-top: 15px;
							margin-bottom: 15px;
						}
						
						.bp-container {
							width: 525px;
							padding: 25px;
							background: #FFFFFF;
							border: 1px solid #CCCCCC;
							border-radius: 2px;
						}
						
						.bp-header {
							font-size: 24px;
							padding-bottom:5px;
						}
						
						.bp-text, .bp-table td {
							font-size: 14px;
							color: #444;
						}
						
						.bp-text b {
							font-size: 18px;
						}
						
						.bp-text a {
							color: #039be5;
							text-decoration: none;
						}
						
						.bp-text a:hover {
							text-decoration: underline;
						}
						
						.bp-footer {
							font-size: 12px;
							color: #999;
							padding-top: 5px;
							text-align: center;
						}
						
						b, strong {
							font-weight: 500 !important;
						}
						
						.reset-button {
							color: white;
							font-size: 16px;
							background: #2196F3;
							border-radius: 3px;
							padding: 5px 50px;
							text-decoration: none;
							text-align: center;
							display:inline-block;
						}
						
						.reset-button a {
							color: white;
							text-decoration: none;
						}
					</style>
				</head>
				<body class="email-body">
					<div class="bp-email-header">
						<div class="bp-email-image"></div>
					</div>
					<div class="bp-container">
						<div class="bp-header">Verify Email Request</div>
						<div class="bp-text"><strong>'.$myU->Username.'</strong>, thank you for registering an account with Brick Create. In order to activate your account, we need to verify your email address. Please proceed by following the instructions below.</div>
						<div style="height:10px;"></div>
						<div class="bp-text">Please click the button below to proceed with verifying your email. The link will expire in 6 hours.</div>
						<div style="height:15px;"></div>
						<center><div class="reset-button"><a href="'.$serverName.'/account/verify?action=verify&code='.$key.'">Verify Email</a></div></center>
						<div style="height:10px;"></div>
						<div class="bp-text">We send you email notifications regarding account actions for your security. If you would like to stop receiving these email notifications, you may toggle them in your <a href="'.$serverName.'/account/settings/" target="_blank">account settings</a>.</div>
						<div style="height:10px;"></div>
						<div class="bp-text" style="color:#999;">	&ndash; Your friends at Brick Create</div>
					</div>
					<div class="bp-footer">
						&copy; Brick Create. &bullet; Made with love in Huntsville, Alabama
					</div>
				</body>
			</html>
			';
			
			$url = 'https://api.sendgrid.com/';
			$user = 'BrickCreate';
			$pass = 'AmeliaRose22';
			
			$params = array(
				'api_user'  => $user,
				'api_key'   => $pass,
				'to'        => $myU->Email,
				'subject'   => 'Verify your email at Brick Create',
				'html'      => $message,
				'from'      => 'noreply@brickcreate.com',
				'fromname'      => 'Brick Create',
				 );

			$request =  $url.'api/mail.send.json';

			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($session);
			curl_close($session);
			
			echo '
			<div class="grid-x grid-margin-x">
				<div class="large-6 large-offset-3">
					<div class="container md-padding border-r">
						<h4>Email sent</h4>
						<p>Thank you. We have successfully sent an email to your email registered on file. Please follow the instructions within to complete the process.</p>
					</div>
				</div>
			</div>
			';
			
			$cache->delete($myU->ID);
			
		}
		
	} else if (isset($_GET['action']) && $_GET['action'] == 'change_email' && !empty($_GET['code'])) {
		
		$Check = $db->prepare("SELECT * FROM UserEmailChange WHERE UserID = ".$myU->ID." AND ChangeKey = ? AND TimeChange+3600 > ".time()." AND Changed = 0");
		$Check->bindValue(1, $_GET['code'], PDO::PARAM_STR);
		$Check->execute();
		
		if ($Check->rowCount() > 0) {
			
			$C = $Check->fetch(PDO::FETCH_OBJ);
			
			$Count = $db->prepare("SELECT COUNT(*) FROM User WHERE Email = '".$C->NewEmail."' AND AccountVerified = 1");
			$Count->execute();
			$CountUser = $Count->fetchColumn();
			
			$Count = $db->prepare("SELECT COUNT(*) FROM UserEmailChange WHERE OldEmail = '".$C->NewEmail."' AND OldWasVerified = 1 AND Changed = 1");
			$Count->execute();
			$CountChange = $Count->fetchColumn();
			
			if ($CountUser > 3 || $CountChange > 3) {
				
				echo '
				<div class="grid-x grid-margin-x">
					<div class="large-6 large-offset-3">
						<div class="container md-padding border-r">
							We\'re sorry, that code is either invalid or no longer active.
						</div>
					</div>
				</div>
				';
				
			} else {
				
				$Update = $db->prepare("UPDATE User SET Email = ?, AccountVerified = 1 WHERE ID = ".$myU->ID."");
				$Update->bindValue(1, $C->NewEmail, PDO::PARAM_STR);
				$Update->execute();
				
				$Update = $db->prepare("UPDATE UserEmailChange SET Changed = 1 WHERE ID = ".$C->ID."");
				$Update->execute();
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
				$InsertUserActionLog->bindValue(1, 'Verified their account email address \''.$C->NewEmail.'\'', PDO::PARAM_STR);
				$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$cache->delete($myU->ID);
				
				header("Location: ".$serverName."/account/settings/");
				die;
				
			}
			
		}
		
	} else if (isset($_GET['action']) && $_GET['action'] == 'verify' && !empty($_GET['code'])) {
		
		$Count = $db->prepare("SELECT COUNT(*) FROM UserVerifyEmail WHERE UserID = ".$myU->ID." AND TimeSent+21600 > ".time()." AND VerifyType = 0 AND VerifyCode = ?");
		$Count->bindValue(1, $_GET['code'], PDO::PARAM_STR);
		$Count->execute();
		
		if ($Count->fetchColumn() == 0) {
			
			echo '
			<div class="grid-x grid-margin-x">
				<div class="large-6 large-offset-3">
					<div class="container md-padding border-r">
						We\'re sorry, that code is either invalid or no longer active.
					</div>
				</div>
			</div>
			';
			
		} else {
			
			$Count = $db->prepare("SELECT COUNT(*) FROM User WHERE Email = '".$myU->Email."' AND AccountVerified = 1");
			$Count->execute();
			$CountUser = $Count->fetchColumn();
			
			$Count = $db->prepare("SELECT COUNT(*) FROM UserEmailChange WHERE OldEmail = '".$myU->Email."' AND OldWasVerified = 1 AND Changed = 1");
			$Count->execute();
			$CountChange = $Count->fetchColumn();
			
			if ($CountUser > 3 || $CountChange > 3) {
				
				echo '
				<div class="grid-x grid-margin-x">
					<div class="large-6 large-offset-3">
						<div class="container md-padding border-r">
							We\'re sorry, that email can not be used to verify any more accounts.
						</div>
					</div>
				</div>
				';
				
			} else {
			
				$Delete = $db->prepare("DELETE FROM UserVerifyEmail WHERE UserID = ".$myU->ID." AND VerifyType = 0 AND VerifyCode = ?");
				$Delete->bindValue(1, $_GET['code'], PDO::PARAM_STR);
				$Delete->execute();
				
				$Update = $db->prepare("UPDATE User SET AccountVerified = 1, LastAccountVerifiedAttempt = ".time()." WHERE ID = ".$myU->ID."");
				$Update->execute();
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$myU->ID.", ?, ".time().", ?)");
				$InsertUserActionLog->bindValue(1, 'Verified their account email address \''.$myU->Email.'\'', PDO::PARAM_STR);
				$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$cache->delete($myU->ID);
				
				header("Location: /");
				die;
			
			}
			
		}
		
	} else {
		
		header("Location: /");
		die;
		
	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");