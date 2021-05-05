<?php
$no_header = true;
$new_header = true;
$new_header_text = 'Log in';
$page = 'log-in';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	requireVisitor();
	
	$GetUserLoginLog = $db->prepare("SELECT COUNT(UserLoginLog.ID) FROM UserLoginLog WHERE UserLoginLog.IP = ? AND UserLoginLog.TimeLog+1800 > ".time());
	$GetUserLoginLog->bindValue(1, $UserIP, PDO::PARAM_STR);
	$GetUserLoginLog->execute();
	$CountUserLoginLog = $GetUserLoginLog->fetchColumn();
	
	if (isset($_POST['username']) && isset($_POST['password'])) {
		
		if ($CountUserLoginLog > 0) {
			require $_SERVER['DOCUMENT_ROOT'] . '/account/vendor/autoload.php';
			$recaptcha = new \ReCaptcha\ReCaptcha('6Ld6c50UAAAAACBGL1WkS8IqwszCXyAH_NulNiy2');
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		}
		
		$GetUser = $db->prepare("SELECT User.ID, User.Password FROM User WHERE User.Username = ?");
		$GetUser->bindValue(1, $_POST['username'], PDO::PARAM_STR);
		$GetUser->execute();
		
		if ($CountUserLoginLog > 5) {
			
			$errorMessage = 'You have tried to log in too many times, please try again later.';
		
		} else if ($GetUser->rowCount() == 0) {
			
			$errorMessage = 'Invalid username or password';
			
			$InsertUserLoginLog = $db->prepare("INSERT INTO UserLoginLog (UserID, IP, TimeLog) VALUES(0, ?, ".time().")");
			$InsertUserLoginLog->bindValue(1, $UserIP, PDO::PARAM_STR);
			$InsertUserLoginLog->execute();
			$CountUserLoginLog++;
			
		} else if ($CountUserLoginLog > 0 && !$resp->isSuccess()) {
			
			$errorMessage = 'Invalid captcha submission, please try again.';
			
			$InsertUserLoginLog = $db->prepare("INSERT INTO UserLoginLog (UserID, IP, TimeLog) VALUES(0, ?, ".time().")");
			$InsertUserLoginLog->bindValue(1, $UserIP, PDO::PARAM_STR);
			$InsertUserLoginLog->execute();
			$CountUserLoginLog++;
			
		} else {
			
			$gU = $GetUser->fetch(PDO::FETCH_OBJ);
			
			if (!password_verify($_POST['password'], $gU->Password)) {
				
				$errorMessage = 'Invalid username or password';
				
				$InsertUserLoginLog = $db->prepare("INSERT INTO UserLoginLog (UserID, IP, TimeLog) VALUES(".$gU->ID.", ?, ".time().")");
				$InsertUserLoginLog->bindValue(1, $UserIP, PDO::PARAM_STR);
				$InsertUserLoginLog->execute();
				$CountUserLoginLog++;
				
			} else {
				
				$InsertUserActionLog = $db->prepare("INSERT INTO UserActionLog (UserID, Action, TimeLog, IP) VALUES(".$gU->ID.", 'Logged in', ".time().", ?)");
				$InsertUserActionLog->bindValue(1, $UserIP, PDO::PARAM_STR);
				$InsertUserActionLog->execute();
				
				$cache->delete($gU->ID);
				$_SESSION['UserID'] = $gU->ID;
				$_SESSION['ip'] = $UserIP;
				$_SESSION['useragent'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION['password'] = $gU->Password;
				
				if (isset($_SESSION['ReturnLocation'])) {
					
					header("Location: ".$serverName."" . $_SESSION['ReturnLocation']);
					unset($_SESSION['ReturnLocation']);
					
				} else {
					
					header("Location: /");
					die;
					
				}
				
			}
			
		}
		
	}

	echo '
	<div class="grid-x grid-margin-x align-middle">
		<div class="large-6 large-offset-3 medium-12 small-12 cell">
			';
			if (isset($errorMessage)) {
				echo '
				<div class="error-message">
					'.$errorMessage.'
				</div>
				';
			}
			echo '
			<h4>Login</h4>
			<div class="container lg-padding border-r login-form">
				<form action="" method="POST">
					<input type="text" name="username" placeholder="Username">
					<input type="password" name="password" placeholder="Password">
					';
					
					if ($CountUserLoginLog > 0) {
					
						echo '
						<script src="https://www.google.com/recaptcha/api.js"></script>
						<div class="g-recaptcha" data-sitekey="6Ld6c50UAAAAAGbtBHEYqzNQINauJSHt7MRBbSQ-" data-theme="dark"></div>
						';
					
					}
					
					echo '
					<input type="submit" value="Log in" class="button-green">
					<div class="text-center"><a href="'.$serverName.'/account/forgot-password/">Forgot password?</a></div>
				</form>
			</div>
		</div>
	</div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");