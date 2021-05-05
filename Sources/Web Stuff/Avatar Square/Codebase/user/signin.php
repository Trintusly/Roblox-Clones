<?php
$pagename = "Sign In";
$pagelink = "http://www.dimensious.com/user/signin.php";
include('../header.php');
?>
		<div class="signin-hold">
<?php
include('../api/user/sign_in_account.php');
?>
			<form method="post" class="sign-form basic-font">
				<h1 class="sign-name basic-font">Sign in your account</h1>
				<div class="mini-sign-hold">
					<label for="username" class="sign-txt">Username:</label>
					<input type="text" name="username" class="sign-inp" placeholder="Username..." />
				</div>
				<div class="mini-sign-hold">
					<label for="password" class="sign-txt">Password:</label>
					<input type="password" name="password" class="sign-inp" placeholder="Password..." />
				</div>
				<input type="submit" class="sign-submit basic-font" name="submit" value="Sign In" />
			</form>
		</div>
<?php
include('../footer.php');
?>