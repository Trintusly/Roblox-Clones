<?php
$no_header = true;
$new_header = true;
$new_header_text = 'Forgot your password?';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireVisitor();
	
	if (isset($_GET['code'])) {
		
		$query = $db->prepare("SELECT UserPassResetRequest.ID, UserPassResetRequest.UserID, User.Password FROM UserPassResetRequest JOIN User ON User.ID = UserPassResetRequest.UserID WHERE UserPassResetRequest.Code = ? AND UserPassResetRequest.TimeExpires > ".time()." AND UserPassResetRequest.Redeemed = 0");
		$query->bindValue(1, $_GET['code'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() == 0) {
			
			echo 'We\'re sorry, something went wrong. This password link is not active.';
			
		}
		
		else {
				
			$q = $query->fetch(PDO::FETCH_OBJ);
			
			if (isset($_POST['password'])) {
				
				if (empty($_POST['password']) || strlen($_POST['password']) < 8 || !preg_match('~[0-9]~', $_POST['password'])) {
					
					$error = 'Invalid password. A password should have at least 8 characters with a number.';
					
				}
				
				else if ($_POST['confirm_password'] != $_POST['password']) {
					
					$error = 'Confirm password is not the same as the new password, please try again.';
					
				}
				
				else if (password_verify($_POST['password'], $q->Password)) {
					
					$error = 'Your new password must be different than your old password, please try again. (That\'s awkward.)';
					
				}
				
				else {
					
					$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
					
					$update = $db->prepare("UPDATE User SET Password = ? WHERE ID = ".$q->UserID."");
					$update->bindValue(1, $hash, PDO::PARAM_STR);
					$update->execute();
					
					$update = $db->prepare("UPDATE UserPassResetRequest SET Redeemed = 1 WHERE ID = ".$q->ID."");
					$update->execute();
					
					$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$q->UserID.", ?, ".time().", ?)");
					$InsertUserActionLog->bindValue(1, 'Reset their account password (forgot password method)', PDO::PARAM_STR);
					$InsertUserActionLog->bindValue(2, $UserIP, PDO::PARAM_STR);
					$InsertUserActionLog->execute();
					
					$success = 'Your password has been changed! Please <a href="'.$serverName.'/log-in/">click here</a> to log in with your new account credentials.';
					
				}
				
			}
				
			echo '
			<div class="pure-g">
				<div class="pure-u-7-24"></div>
				<div class="pure-u-10-24">
					';
					
					if (!empty($error)) {
						echo '
						<div class="error-message">
							'.$error.'
						</div>
						<div style="height:15px;"></div>
						';
					}
					
					if (!empty($success)) {
						echo '
						<div class="success-message">
							'.$success.'
						</div>
						<div style="height:15px;"></div>
						';
					}
					
					echo '
					<div class="lg-container">
						<div class="site-text-md">Create a new password</div>
						<p>Choose a new password for your account. Make sure it has at least 8 characters and 1 number.</p>
						<form action="" method="POST">
							<input style="font-size:16px;" type="password" name="password" placeholder="New Password">
							<input style="font-size:16px;" type="password" name="confirm_password" placeholder="New Password (again)">
							<input style="font-size:16px;" type="submit" value="Submit" class="button-green">
						</form>
					</div>
				</div>
			</div>
			';
			
		}
		
	}
	
	else if (empty($_GET['code'])) {
	
		if (isset($_POST['continue'])) {
			
			if (!isset($_SESSION['PasswordAttempt'])) {
				$_SESSION['PasswordAttempt'] = time();
			}
			
			$query = $db->prepare("SELECT ID, Username, Email FROM User WHERE User.Username = ? AND User.Email = ?");
			$query->bindValue(1, $_POST['username'], PDO::PARAM_STR);
			$query->bindValue(2, $_POST['email-address'], PDO::PARAM_STR);
			$query->execute();
			$queryCount = $query->rowCount();
			
			if ($queryCount == 0) {
				
				$error = 'Either this account does not exist, or the account does not have that email associated with it.';
				
			}
			
			else {
				
				$queryObj = $query->fetch(PDO::FETCH_OBJ);
				
				$query = $db->prepare("SELECT COUNT(*) FROM UserPassResetRequest WHERE (UserID = ".$queryObj->ID.") AND TimeExpires > ".time()."");
				$query->execute();
				
				if ($query->fetchColumn() == 0) {
						
					$key = md5(microtime() + $q->ID);
					
					$insert = $db->prepare("INSERT INTO UserPassResetRequest (UserID, TimeRequest, TimeExpires, IP, Code) VALUES(".$queryObj->ID.", ".time().", ".(time()+21600).", '".$_SERVER['REMOTE_ADDR']."', '".$key."')");
					$insert->execute();
					
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
								<div class="bp-header">Password Reset Request</div>
								<div class="bp-text">We have received a password reset request for the account <strong>'.$queryObj->Username.'</strong>.</div>
								<div style="height:10px;"></div>
								<div class="bp-text">If you made this request, please click the button below to proceed with changing your password. The link will expire in 6 hours.</div>
								<div style="height:15px;"></div>
								<center><div class="reset-button"><a href="'.$serverName.'/account/forgot-password/?code='.$key.'">Change Password</a></div></center>
								<div style="height:15px;"></div>
								<div class="bp-text">If you did not initiate this password reset request, simply disregard this email. Alternatively, if you believe someone may be trying to gain unauthorized access to your account, please contact us at <a href="mailto:hello@brickcreate.com">hello@brickcreate.com</a>.</div>
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
						'to'        => $queryObj->Email,
						'subject'   => 'Password reset request on Brick Create',
						'html'      => $message,
						'from'      => 'security-alerts@brickcreate.com',
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
						
						$success = 'Email sent! Check your email within the next two minutes for instructions on how to reset your password.';
					
				}
				
				else {
					
					$error = 'There is already a pending password reset request - try checking your email\'s spam folder.';
					
				}
				
			}
			
		}
		
		echo '
		<div class="grid-x grid-margin-x">
			<div class="large-6 large-offset-3 medium-12 small-12">
				<h4>Forgot your password?</h4>
				';
				
				if (!empty($error)) {
					echo '
					<div class="error-message">
						'.$error.'
					</div>
					';
				}
				
				if (!empty($success)) {
					echo '
					<div class="success-message">
						'.$success.'
					</div>
					';
				}
					
				echo '
				<div class="container lg-padding border-r login-form">
					<p>Please enter your username and email address for your Brick Create account. We will send an email with instructions on how to reset your password.</p>
					<form action="" method="POST">
						<input type="text" name="username" placeholder="Username"'; if (!empty($_POST['username'])) { echo ' value="'.htmlentities(strip_tags($_POST['username'])).'"'; } echo '>
						<input type="text" name="email-address" placeholder="Email Address"'; if (!empty($_POST['email-address'])) { echo ' value="'.htmlentities(strip_tags($_POST['email-address'])).'"'; } echo '>
						<input type="submit" name="continue" value="Continue" class="no-margin">
					</form>
				</div>
			</div>
		</div>
		';
	
	}
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");