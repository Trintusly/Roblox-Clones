<?php
$no_header = true;
$new_header = true;
$new_header_text = 'Sign up';
$page = 'sign-up';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireVisitor();
	error_reporting( E_ALL);
	ini_set("display_errors",1);
	if (!isset($_SESSION['FailureAttempts'])) {
		$_SESSION['FailureAttempts'] = 0;
	}

	if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm-password'])) {

		$errors = array();

		/*require $_SERVER['DOCUMENT_ROOT'] . '/account/vendor/autoload.php';

		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

		if (empty($errors)) {
			array_push($errors, 'Invalid captcha submission, please try again.');

		}

		$domain_name = substr(strrchr($_POST['email'], "@"), 1);
*/
		/*$checkEmail = $db->prepare("SELECT COUNT(*) FROM EmailBlacklist WHERE Email = ?");
		$checkEmail->bindValue(1, $domain_name, PDO::PARAM_STR);
		$checkEmail->execute();

		if ($checkEmail->fetchColumn() > 0) {

			array_push($errors, 'Sorry, this email cannot be used. Please try another.');

		}*/

		if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false || strlen($_POST['email'] > 128)) {

			array_push($errors, 'Invalid email address format.');

		}

		if (empty($_POST['username']) || strlen($_POST['username']) < 3 || strlen($_POST['username']) > 20 || !preg_match('/^[A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $_POST['username'])) {

			array_push($errors, 'Invalid username. A username can only have 3-20 alphanumeric characters.');

		}

		if (empty($_POST['password']) || strlen($_POST['password']) < 8 || !preg_match('~[0-9]~', $_POST['password'])) {

			array_push($errors, 'Invalid password. A password should have at least 8 characters with a number.');

		}

		if ($_POST['password'] != $_POST['confirm-password']) {

			array_push($errors, 'Your password and password confirmation do not match. Please try again.');

		}

		if (true) {

			$checkUsernameBlocked = $db->prepare("SELECT COUNT(*) FROM BlockedUsername WHERE Username = ?");
			$checkUsernameBlocked->bindValue(1, $_POST['username'], PDO::PARAM_STR);
			$checkUsernameBlocked->execute();

			$checkEmailBlocked = $db->prepare("SELECT COUNT(*) FROM BlockedEmail WHERE Email = ?");
			$checkEmailBlocked->bindValue(1, $_POST['email'], PDO::PARAM_STR);
			$checkEmailBlocked->execute();

			$checkUsername = $db->prepare("SELECT COUNT(*) FROM User WHERE Username = ?");
			$checkUsername->bindValue(1, $_POST['username'], PDO::PARAM_STR);
			$checkUsername->execute();

			$checkOkUsername = $db->prepare("SELECT COUNT(*) FROM UsernameHistory WHERE Username = ?");
			$checkOkUsername->bindValue(1, $_POST['username'], PDO::PARAM_STR);
			$checkOkUsername->execute();

			$Count = $db->prepare("SELECT COUNT(*) FROM User WHERE Email = ? AND AccountVerified = 1");
			$Count->bindValue(1, $_POST['email'], PDO::PARAM_STR);
			$Count->execute();
			$CountUserEmail = $Count->fetchColumn();

			$Count = $db->prepare("SELECT COUNT(*) FROM UserEmailChange WHERE OldEmail = ? AND OldWasVerified = 1 AND Changed = 1");
			$Count->bindValue(1, $_POST['email'], PDO::PARAM_STR);
			$Count->execute();
			$CountChangeEmail = $Count->fetchColumn();

			$checkIP = $db->prepare("SELECT COUNT(*) FROM User WHERE LastIP = ?");
			$checkIP->bindValue(1, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
			$checkIP->execute();

			if ($checkUsername->fetchColumn() > 0 || $checkOkUsername->fetchColumn() > 0) {

				array_push($errors, 'This username has already been taken.');

			}

			else if ($checkUsernameBlocked->fetchColumn() > 0) {

				array_push($errors, 'This username is not available.');

			}

			else if ($checkEmailBlocked->fetchColumn() > 0) {

				array_push($errors, 'This email is not available.');

			}

			else if ($CountUserEmail > 0 || $CountChangeEmail > 3) {

				array_push($errors, 'This email is already associated with a user account. Did you <a href="/account/forgot-password/" style="font-weight:600;color:#ffffff;">forget your password</a>?');

			}

			else if ($checkIP->fetchColumn() > 5) {

				array_push($errors, 'This IP address is associated with too many accounts.');

			}

			else if (isProfanity($_POST['username']) == 1) {

				array_push($errors, 'This username is not available.');

			}

			if (empty($errors)) {

				$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

				$db->beginTransaction();

				$insert = $db->prepare("INSERT INTO User (Username, Email, Password, TimeRegister, TimeLastSeen, LastIP, AvatarURL) VALUES(?, ?, ?, ?, ?, ?, ?)");
				$insert->bindValue(1, $_POST['username'], PDO::PARAM_STR);
				$insert->bindValue(2, $_POST['email'], PDO::PARAM_STR);
				$insert->bindValue(3, $hash, PDO::PARAM_STR);
				$insert->bindValue(4, time(), PDO::PARAM_INT);
				$insert->bindValue(5, time(), PDO::PARAM_INT);
				$insert->bindValue(6, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
				$insert->bindValue(7, '8ca17bec-0320-4293-90e5-dfc5b8690156', PDO::PARAM_STR);
				$insert->execute();

				$UserID = $db->lastInsertId();

				$count = $db->prepare("SELECT COUNT(*) FROM User WHERE Username = ?");
				$count->bindValue(1, $_POST['username'], PDO::PARAM_STR);
				$count->execute();

				if ($count->fetchColumn() > 1) {

					$db->rollBack();

					header("Location: ".$serverName."/sign-up/");
					die;

				}

				else {
					$db->commit();
				}

				$insert = $db->prepare("INSERT INTO UserIP (UserID, IP, TimeFirstUse) VALUES(?, ?, ?)");
				$insert->bindValue(1, $UserID, PDO::PARAM_INT);
				$insert->bindValue(2, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
				$insert->bindValue(3, time(), PDO::PARAM_INT);
				$insert->execute();

				$GetUser = $db->prepare("SELECT ID, Username, Email FROM User WHERE ID = ".$UserID."");
				$GetUser->execute();
				$gU = $GetUser->fetch(PDO::FETCH_OBJ);

				$key = generateRandomString(20);

				$Insert = $db->prepare("INSERT INTO UserVerifyEmail (UserID, TimeSent, VerifyType, VerifyCode) VALUES(".$gU->ID.", ".time().", 0, '".$key."')");
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
								<div class="bp-text"><strong>'.$gU->Username.'</strong>, thank you for registering an account with Brick Create. In order to activate your account, we need to verify your email address. Please proceed by following the instructions below.</div>
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
					$user = 'bloxcity';
					$pass = 'Id4vogj0GTrP8lobnWns';

					$params = array(
						'api_user'  => $user,
						'api_key'   => $pass,
						'to'        => $gU->Email,
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

				}

				$_SESSION['UserID'] = $UserID;
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION['password'] = $hash;

				header("Location: /");
				die;

			}

		}

	}

	echo '
	<div class="grid-x grid-margin-x">
		<div class="large-6 large-offset-3 medium-12 small-12 cell">
			<h4>Sign up for an account</h4>
			';

			if (!empty($errors)) {

				echo '
				<div class="error-message">
				';

				foreach ($errors as $error) {
					echo '<div style="padding: 3px 0;">'.$error.'</div>';
				}

				echo '
				</div>
				';

			}

			echo '
			<div class="container lg-padding border-r login-form">
				<form action="" method="POST">
					<input type="text" name="email" placeholder="Email Address"'; if (!empty($_POST['email'])) { echo ' value="'.htmlentities(strip_tags($_POST['email'])).'"'; } echo '>
					<input type="text" name="username" placeholder="Username"'; if (!empty($_POST['username'])) { echo ' value="'.htmlentities(strip_tags($_POST['username'])).'"'; } echo '>
					<input type="password" name="password" placeholder="Password"'; if (!empty($_POST['password'])) { echo ' value="'.htmlentities(strip_tags($_POST['password'])).'"'; } echo '>
					<input type="password" name="confirm-password" placeholder="Confirm Password"'; if (!empty($_POST['confirm-password'])) { echo ' value="'.htmlentities(strip_tags($_POST['confirm-password'])).'"'; } echo '>
					<script src="https://www.google.com/recaptcha/api.js"></script>
					<div class="g-recaptcha" data-sitekey="6Lf80UoUAAAAAJPaMaPoSSagvR2KDB0VddeTFB5D" data-theme="dark"></div>
					<input type="submit" value="Sign up">
				</form>
				<font class="text-left">By signing up to brickcreate.com, you acknowledge that you have read and agree to our <a href="'.$serverName.'/about/terms-of-service/" target="_BLANK">terms of service</a>.</font>
			</div>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");