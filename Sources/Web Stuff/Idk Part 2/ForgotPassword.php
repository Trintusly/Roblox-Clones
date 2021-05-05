<?php
	include "Header.php";
	$code = mysql_real_escape_string(strip_tags(stripslashes($_GET['code'])));
	if (!$code) {
	echo "
	<div id='LargeText'>
		<b>Forgot Password</b>
	</div>
	If you have forgotten your password, please type in the username. It will send an email with the account registered on. If the email is fake/not a real email, we can not help you and you must contact us.
	<br />
	<form action='' method='POST'>
		<table>
			<tr>
				<td>
					<b>Username:</b>
				</td>
				<td>
					<input type='text' name='Username'>
				</td>
				<td>
					<input type='submit' name='Submit' value='Send'>
				</td>
			</tr>
		</table>
	</form>
	";
	$Username = mysql_real_escape_string(strip_tags(stripslashes($_POST['Username'])));
	$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
	
		if ($Submit) {
		
		$getUser = mysql_query("SELECT * FROM Users WHERE Username='$Username'");
		$UserExist = mysql_num_rows($getUser);
		if ($UserExist == "0") {
		
			echo "<b>Username not found!</b>";
			exit;
		
		}
		$gU = mysql_fetch_object($getUser);
		
    $header .= "From: Build City <help@buildcity.ml>\r\n"; 
    $header .= "Reply-To: Build City <help@buildcity.ml>\r\n"; 
    $header .= "Return-Path: Build City <help@buildcity.ml>\r\n"; 
    $header .= "Content-Type: text/plain\r\n";
	$body = "Hi there ".$gU->Username."! We have received a request to reset your password. Please click this link: https://buildcity.ml/ForgotPassword.php?code=".$gU->Hash." to reset your password. If you did not request to reset your password, please disregard this email.";
 
    if (mail("".$gU->Email."", "Password Reset for ".$gU->Username."", $body, $header)) {
	
	echo "<b>Check your email! Not there? Check your spam!</b>";
	}
	else {
	echo "<b>There was an error sending the email.</b>";
	}
		
		}
	}
	$getUser = mysql_query("SELECT * FROM Users WHERE Hash='$code'");
	$gU = mysql_fetch_object($getUser);
	$Exist = mysql_num_rows($getUser);
	if ($code) {
	if ($Exist == "0") {
	header("Location: index.php");
	}
	else {
	
		echo "
		<form action='' method='POST'>
			<table>
				<tr>
					<td>
						Reset Password for $gU->Username
					</td>
				</tr>
					<td>
						<b>New Password:</b>
					</td>
					<td>
						<input type='password' name='Password'>
					</td>
				</tr>
				<tr>
					<td>
						<b>Confirm New Password:</b>
					</td>
					<td>
						<input type='password' name='ConfirmPassword'>
					</td>
				</tr>
				<tr>
					<td>
						<input type='submit' name='Submit' value='Change' />
					</td>
				</tr>
			</table>
		</form>
		";
		$Password = mysql_real_escape_string(strip_tags(stripslashes($_POST['Password'])));
		$ConfirmPassword = mysql_real_escape_string(strip_tags(stripslashes($_POST['ConfirmPassword'])));
		$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
		
			if ($Submit) {
			
				if ($Password == $gU->Password) {
				echo "<b>You can't use the same password as your original one.</b>";
				exit;
				}
				
			
				$Password = hash('sha512',$Password);
				$ConfirmPassword = hash('sha512',$ConfirmPassword);
				
				if ($Password != $ConfirmPassword) {
				
					echo "<b>Your password and confirm does not match!</b>";
				
				}
				else {

				
					
					mysql_query("UPDATE Users SET Password='$Password' WHERE ID='$gU->ID'");
					$getLog = mysql_query("SELECT * FROM Passwords WHERE UserID='".$gU->ID."'");
					$gLL = mysql_num_rows($getLog);
					$gL = mysql_fetch_object($getLog);
					
						if ($gLL == "0") {
						
							mysql_query("INSERT INTO Passwords (UserID, RawPassword) VALUES('".$userRow->ID."','".$Password."')");
						
						}
						elseif ($gL->RawPassword != $Password) {
						
							mysql_query("UPDATE Passwords SET RawPassword='".$Password."' WHERE User='".$userRow->ID."'");
						
						}
					$_SESSION['Username']=$gU->Username;
					header("Location: index.php");
				
				}
			
			}
	
	}
	}

?>