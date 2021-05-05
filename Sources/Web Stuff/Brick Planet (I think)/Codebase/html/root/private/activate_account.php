<?php

		if (isset($_SESSION['username']) && $myU->AccountActivated == 0) {
			
			function generateRandomString($length = 10) {
				return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
			}
			
			$blacklist = array(
			'guerrillamail.com',
			'sharklasers.com',
			'grr.la',
			'guerrillamail.biz',
			'guerrillamail.de',
			'guerrillamail.net',
			'guerrillamail.org',
			'guerrillamailblock.com',
			'pokemail.net',
			'spam4.me',
			'projectvintous.com',
			'mailinator.com',
			'superrito.com',
			'armyspy.com',
			'cuvox.de',
			'dayrep.com',
			'einrot.com',
			'fleckens.hu',
			'gustr.com',
			'jourrapide.com',
			'rhyta.com',
			'superrito.com',
			'teleworm.us',
			'ass.pp.ua',
			'loh.pp.ua',
			'get.pp.ua',
			'add3000.pp.ua',
			'ip6.pp.ua',
			'jetable.pp.ua',
			'web-mail.pp.ua',
			'eml.pp.ua',
			'stop-my-spam.pp.ua',
			'mox.pp.ua',
			'ip4.pp.ua',
			'fake-email.pp.ua',
			'yopmail.pp.ua',
			'housat.com',
			'yopmail.com',
			'haribu.net',
			'polyfaust.com',
			'cartelera.org',
			'hostcalls.com'
			);
			
			if (!isset($_SESSION['FailedPasswords'])) {
				$_SESSION['FailedPasswords'] = 0;
			}
			
			if (arrayInString($blacklist, strtolower($myU->Email)) > 0) {
				// do nothing
			}
			
			else {
			
				if (($myU->EmailSent+600) < time()) {
					
					$key = generateRandomString(20);
					
					$url = 'https://api.sendgrid.com/';
					$user = 'bloxcity';
					$pass = 'Id4vogj0GTrP8lobnWns';

					$params = array(
						'api_user'  => $user,
						'api_key'   => $pass,
						'to'        => $myU->Email,
						'subject'   => 'Verify Your Email - BLOX City',
						'html'      => 
'
Hi '.$myU->Username.',<br /><br />
You have registered an account on BLOX City. Please click the following link to verify your email address:
<br /><br />
<a href="'.$serverName.'/?verify='.$key.'">'.$serverName.'/?verify='.$key.'</a>
<br /><br />
Once you verify, you will be able to login.
<br /><br />
If you have any questions or issues, please do not hesitate to email us at <a href="mailto:helpme@bloxcity.com">helpme@bloxcity.com</a>.
<br />
<br />
BLOX City, Inc.
',
						'from'      => 'no_reply@bloxcity.com',
						'fromname'      => 'BLOX City',
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
						
						$setSent = $db->prepare("UPDATE Users SET EmailSent = ".time()." WHERE ID = ".$myU->ID."");
						$setSent->execute();
						
						$setKey = $db->prepare("UPDATE Users SET AccountActivateCode = '".$key."' WHERE ID = ".$myU->ID."");
						$setKey->execute();
						
						$query = $db->prepare("SELECT * FROM `Users` WHERE `Username` = ?");
						$query->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
						$query->execute();
						
						$cache->delete($_SESSION['username']);
						$cache->set($_SESSION['username'], $query->fetch(PDO::FETCH_OBJ), 86400);
						$myU = $cache->get($_SESSION['username']);
						$_SESSION['NextF5'] = time() + 600;
					
				}
			
			}
			
			if (isset($_POST['submit']) && isset($_POST['new_email']) && isset($_POST['account_password']) && $_POST['csrf_token'] == $_SESSION['csrf_token'] && $myU->EmailChangedPrompt == 0) {
				
				if (!filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL)) {
					
					$errorMessage = 'The email you provided is not valid.';
					
				}
			
				else if (!password_verify($_POST['account_password'], $myU->Password)) {
					
					$_SESSION['FailedPasswords']++;
					
					$errorMessage = 'The password you provided was incorrect.';
					
				}
				
				else {
					
					// Let's check if the email is linked to more than three accounts.
					
					$query = $db->prepare("SELECT COUNT(Users.ID) FROM Users WHERE Email = ? AND AccountActivated = 1");
					$query->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
					$query->execute();
					
					$getBan = $db->prepare("SELECT COUNT(*) FROM EmailBans WHERE Email = ?");
					$getBan->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
					$getBan->execute();
					$IsEmailBanned = $getBan->fetchColumn();
					
					if ($query->fetchColumn() >= 1 || $IsEmailBanned > 0) {
						
						$errorMessage = 'We\'re sorry, you can not use this email to verify your account.';
						
					}
					
					else {
						
						$updateEmail = $db->prepare("UPDATE Users SET Email = ? WHERE ID = ".$myU->ID."");
						$updateEmail->bindValue(1, $_POST['new_email'], PDO::PARAM_STR);
						$updateEmail->execute();
						
						$prompt = $db->prepare("UPDATE Users SET EmailChangedPrompt = 1 WHERE ID = ".$myU->ID."");
						$prompt->execute();
						
						$prompt = $db->prepare("UPDATE Users SET EmailSent = 0 WHERE ID = ".$myU->ID."");
						$prompt->execute();
						
						$CurrentEmail = $myU->Email;
						$OneDay = time() + 86400;
						
						$log = $db->prepare("INSERT INTO `UserEmailChanges` (UserID, PreviousEmail, NewEmail, RevertCode, Expire, IP) VALUES(?, ?, ?, ?, ?, ?)");
						$log->bindValue(1, $myU->ID, PDO::PARAM_INT);
						$log->bindValue(2, $CurrentEmail, PDO::PARAM_STR);
						$log->bindValue(3, $_POST['NewEmail'], PDO::PARAM_STR);
						$log->bindValue(4, md5(microtime() + $myU->ID), PDO::PARAM_STR);
						$log->bindValue(5, $OneDay, PDO::PARAM_INT);
						$log->bindValue(6, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
						$log->execute();
						
						$query = $db->prepare("SELECT * FROM `Users` WHERE `Username` = ?");
						$query->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
						$query->execute();
						
						$cache->delete($_SESSION['username']);
						$cache->set($_SESSION['username'], $query->fetch(PDO::FETCH_OBJ), 86400);
						$myU = $cache->get($_SESSION['username']);
						$_SESSION['NextF5'] = time() + 600;
						
						header("Location: /");
						die;
						
					}
					
				}
			
			}
			
			if (isset($_GET['verify'])) {
				
				if ($_GET['verify'] != $myU->AccountActivateCode) {
					
					$errorMessage = 'Invalid Code';
					
				}
				
				else {
					
					$update = $db->prepare("UPDATE Users SET AccountActivated = 1 WHERE ID = ".$myU->ID."");
					$update->execute();
					
					$query = $db->prepare("SELECT * FROM `Users` WHERE `Username` = ?");
					$query->bindValue(1, $_SESSION['username'], PDO::PARAM_STR);
					$query->execute();
					
					$cache->delete($_SESSION['username']);
					$cache->set($_SESSION['username'], $query->fetch(PDO::FETCH_OBJ), 86400);
					$myU = $cache->get($_SESSION['username']);
					$_SESSION['NextF5'] = time() + 600;
					
					header("Location: /");
					die;
					
				}
				
			}
			
			echo '
			<script>$(document).ready(function(){$(".modal-trigger").leanModal();});</script>
			<div id="InformationPopup" class="modal" style="width:500px;">
				<div class="modal-content">
					<h4>Troubles?</h4>
					<p>If you are having trouble receiving the email, try the following things below.</p>
					<p>
					<ul>
						<li>Check if the email is in your Spam/Junk folder.</li>
						<li>Try adding no_reply@bloxcity.com to your Address Book.</li>
					</ul>
					</p>
					<p>If you still can not receive emails from us, shoot us an email at <a href="mailto:helpem@bloxcity.com">helpme@bloxcity.com</a> and we\'ll try our best to help you.</p>
				</div>
				<div class="modal-footer">
					<a href="#!" class=" modal-action modal-close waves-effect waves-blue btn-flat">CLOSE</a>
				</div>
			</div>
			';
			
			if ($myU->EmailChangedPrompt == 0) {
			
				echo '
				<form action="" method="POST">
					<div id="ChangeEmail" class="modal" style="width:500px;">
						<div class="modal-content">
							<h4>Change Email Address</h4>
							<p>If you entered an incorrect email address during sign up, do not worry. This form allows you to change your email.<br /><b>You can only change your email once before activating your account.</b></p>
							<input type="text" name="new_email" placeholder="New Email Address" style="border:0;padding:0;box-sizing:border-box;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;background:#fff;">
							<div style="height:5px;"></div>
							<input type="password" name="account_password" placeholder="Current Account Password" style="border:0;padding:0;box-sizing:border-box;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;background:#fff;">
							<input type="hidden" name="csrf_token" value="'.$_SESSION['csrf_token'].'">
						</div>
						<div class="modal-footer">
							<a href="#!" class=" modal-action modal-close waves-effect waves-blue btn-flat">CLOSE</a>
							<input type="submit" name="submit" class="waves-effect waves-blue btn-flat" value="CHANGE">
						</div>
					</div>
				</form>
				';
			
			}
			
			echo '
			<div class="content-box" style="width:75%;margin:0 auto;">
				<div class="header-text" style="padding-bottom:15px;">Please verify your email address</div>
				';
				
				if (isset($errorMessage)) {
					
					echo '<div style="color:red;padding-bottom:15px;">'.$errorMessage.'</div>';
					
				}
				
				if (arrayInString($blacklist, strtolower($myU->Email)) > 0) {
					
					echo '
					<div>Before you can use BLOX City, you need to verify an email address with your account.</div>
					<div>The email linked to your account is on our blacklist. Please change your email address before proceeding.</div>
					';
					
				}
				
				else {
				
					echo '
					<div>Before you can use BLOX City, you need to link an email address with your account.</div>
					<div style="height:10px;"></div>
					<div>We\'ve sent an email to <b>'.$myU->Email.'</b> at <b>'.date('F dS Y,', $myU->EmailSent).' at '.date('g:iA', $myU->EmailSent).'</b> Central Standard Time (CST).<br />Please see the email for further instructions.</div>
					';
				
				}
				
				echo '
				<div style="height:10px;"></div>
				<a href="#InformationPopup" class="modal-trigger">Problems receiving the email?</a>
				';
				
				if ($myU->EmailChangedPrompt == 0) {
				
					echo '
					<a href="#ChangeEmail" class="modal-trigger" style="margin-left:25px;">Change Email Address</a>
					';
				
				}
				
				echo '
				<style>
					.submit-hover:hover {
						background: #1DA11F !important;
					}
				</style>
			</div>
			';
			
			require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
			
			die;
			
		}