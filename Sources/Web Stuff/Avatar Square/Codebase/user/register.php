<?php
$pagename = "Register";
$pagelink = "http://www.dimensious.com/user/register.php";
include('../header.php');
?>
		<div class="register-hold">
<?php
include('../api/user/create_account.php');
?>
<div class="bc-content" style="min-width:400px;width:400px;margin:0 auto;">
<h5 style="padding:0;margin:0;padding-bottom:25px;">Register</h5>
			<form method="post" class="reg-form basic-font">
				<div class="mini-reg-hold">
					<label for="username" class="reg-txt">Username:</label>
					<input type="text" name="username" class="reg-inp" placeholder="Username..." />
				</div>
				<div class="mini-reg-hold">
					<label for="password" class="reg-txt">Password:</label>
					<input type="password" name="password" class="reg-inp" placeholder="Password..." />
				</div>
				<div class="mini-reg-hold">
					<label for="confirm-password" class="reg-txt">Confirm Password:</label>
					<input type="password" name="confirmpassword" class="reg-inp" placeholder="Confirm Password..." />
				</div>
				<div class="mini-reg-hold">
					<label for="email" class="reg-txt">Email:</label>
					<input type="text" name="email" class="reg-inp" placeholder="Email..." />
				</div>
				<div class="fa fa-square fa-3x chk-box"></div>
				<input type="submit" name="submit" style="background:#2196F3;color:white;width:100px;padding:10px 8px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="edit-hover" value="Register">
			</form>
		</div>
<?php
include('../footer.php');
?>