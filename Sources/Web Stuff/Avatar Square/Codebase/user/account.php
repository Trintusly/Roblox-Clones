<?php
include('../header.php');
if (!$user) {
header('Location: ../');
} else {
?>
		<div class="account-pg">
			<div class="acc-left-side">
				<p class="chng-pw-txt basic-font">Change Password</p>
				<form method="post" class="chng-pw-form">
<?php
include('../api/user/change_password.php');
?>
					<input type="password" name="current_password" placeholder="Current Password..." class="basic-font chng-pw-inp" />
					<br />
					<input type="password" name="new_password" placeholder="New Password..." class="basic-font chng-pw-inp" />
					<br />
					<input type="password" name="new_password_again" placeholder="New Password Again..." class="basic-font chng-pw-inp" />
					<br />
					<input type="submit" name="pw_submit" value="Change Password" class="basic-font chng-pw-sbmt" />
				</form>
			</div>
		</div>
<?php
}
include('../footer.php');
?>