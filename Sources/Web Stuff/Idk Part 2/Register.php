<?php
include "Header.php";
$Configuration = mysql_fetch_object($Configuration = mysql_query("SELECT * FROM Configuration"));
if ($Configuration->Register == "true") {

if (!$User) {
$UsernameIs = mysql_real_escape_string(strip_tags(stripslashes($_GET['UsernameIs'])));
echo '
			<div class="row">
<div class="col s12 m3 l2">&nbsp;</div>
<div class="col s12 m12 l8">
<div style="padding-top:50px;"></div>
<div class="container" style="width:100%;">
<div class="center-align">
<div style="padding-bottom:50px;">
<div class="text-center">
<script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 
<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5035877450680880" data-ad-slot="8645193052" data-ad-format="auto"></ins>
<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
</div>
</div>
</div>
<div class="row">
<div class="col s12 m12 l4">&nbsp;</div>
<div class="col s12 m12 l4">
<div class="bc-content center-align">
<h4 style="padding-bottom:25px;">Register</h4>
<form action="" method="POST">
<div class="input-field">
<input type="text" name="Email" id="Email">
<label for="email">Email Address</label>
</div>
<div class="input-field">
<input type="text" name="Username" id="Username">
<label for="username">Username</label>
</div>
<div class="input-field">
<input type="password" name="Password" id="Password">
<label for="password">Password</label>
</div>
<div class="input-field">
<input type="password" name="Confirm_Password" id="Confirm_Password">
<label for="confirm_password">Password (again)</label>
</div>
<div class="input-field">
<i class="waves-effect waves-light btn blue waves-input-wrapper" style="">&nbsp;<input type="submit" name="Submit" class="waves-button-input" value="REGISTER">&nbsp;</i>
</div>
</form>
</div>
</div>
</div></div></div></div>
';
$Username = mysql_real_escape_string(strip_tags(stripslashes($_POST['Username'])));
$Password = mysql_real_escape_string(strip_tags(stripslashes($_POST['Password'])));
$ConfirmPassword = mysql_real_escape_string(strip_tags(stripslashes($_POST['Confirm_Password'])));
$Email = mysql_real_escape_string(strip_tags(stripslashes($_POST['Email'])));
$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
$ref = mysql_real_escape_string(strip_tags(stripslashes($_GET['ref'])));
					function is_alphanumeric($username)
					{
						return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $username);
						 
					}					
if ($Submit) {
$Username = filter($Username);
if (!$Username||!$Password||!$ConfirmPassword) {
echo "<b>Please fill in all required fields.</b>";
}
else {
$userExist = mysql_query("SELECT * FROM Users WHERE Username='$Username'");
$userExist = mysql_num_rows($userExist);
$userExist1 = mysql_query("SELECT * FROM Users WHERE OriginalName='$Username'");
$userExist1 = mysql_num_rows($userExist1);
if ($userExist > 0) {
echo "<div id='Error'>That username already exists.</div>";
}
elseif ($userExist1 > 0) {
echo "<div id='Error'>That username already exists.</div>";
}
else {
if ($ConfirmPassword != $Password) {
echo "<div id='Error'>Your password and confirm password does not match.</div>";
}
else {
if (strlen($Username) >= 15) {
echo "<div id='Error'>Your username is above fifteen (15) characters!</div>";
}
elseif (strlen($Username) < 3) {
echo "<div id='Error'>Your username is under three (3) characters!</div>";
}
elseif (!is_alphanumeric($Username)) {
echo "<div id='Error'>Only A-Z and 1-9 is allowed, or there is profanity in your username.</div>";
}
else {

	if ($ref) {
	
		$getRef = mysql_query("SELECT * FROM Users WHERE ID='$ref'");
		$gR = mysql_fetch_object($getRef);
		$RefExist = mysql_num_rows($getRef);
		
			if ($RefExist == 0) {
			
				//dont do anything lol
			
			}
			else {
			
				//if ($_SERVER['PHP_SELF'] == $gR->IP) {
				
					//dont do anything lol
				
				//}
				//else {
					$userExist = mysql_query("SELECT * FROM Users WHERE Username='$Username'");
					$userExist = mysql_fetch_object($userExist);
					mysql_query("UPDATE Users SET SuccessReferrer=SuccessReferrer + 1 WHERE ID='$ref'");
					mysql_query("INSERT INTO Referrals (ReferredID, UserID) VALUES('$ref','$userExist->ID')");
				
				//}
			
			}

	}

$_ENCRYPT = hash('sha512',$Password);
$IP = $_SERVER['REMOTE_ADDR'];
mysql_query("INSERT INTO Users (Username, Password, Email, IP) VALUES('$Username','$_ENCRYPT','$Email','$IP')");
$_SESSION['Username']=$Username;
$_SESSION['Password']=$_ENCRYPT;
header("Location: /index.php");
}
}
}
}
}
}
echo "
</td>
</tr>
</table>
";
}
else {
echo "<b>Register has been temporarily disabled.</b>";
}

include "Footer.php";