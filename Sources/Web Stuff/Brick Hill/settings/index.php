<?php 
include('../SiT_3/config.php');
include('../SiT_3/header.php');

if(!$loggedIn) {header("Location: ../"); die();}

//update desc

	$userID = $userRow->{'id'};
	
	if(isset($_POST['newBirth'])) {
		$birth_year = mysqli_real_escape_string($conn,intval($_POST['year']));
		$birth_month = mysqli_real_escape_string($conn,intval($_POST['month']));
		if (date('Y')-$birth_year >= 1 && date('Y')-$birth_year <= 124) {
			$birth_date = $birth_year."-".$birth_month."-01";
			$updateDescSQL = "UPDATE `beta_users` SET `birth` = '$birth_date' WHERE `id` = '$userID'";
			$updateDesc = $conn->query($updateDescSQL);
			header("Location: index");
		} else {
			$error[] = "You must be between 1 and 124 years old to play Brick Hill.";
		}
	}
	
	if (isset($_POST['desc'])) {
	$newDesc = mysqli_real_escape_string($conn,$_POST['desc']);
	$userID = $userRow->{'id'};
	$updateDescSQL = "UPDATE `beta_users` SET `description` = '$newDesc' WHERE `id` = '$userID'";
	$updateDesc = $conn->query($updateDescSQL);	
	}
	//old theme table update
	if (isset($_POST['oldtheme'])) {
	$userID = $userRow->{'id'};
	$updateOldThemeSQL = "UPDATE `themes` SET `old-theme` = 'yes' WHERE `id` = '$userID'";
	$updateOldTheme = $conn->query($updateOldThemeSQL);	
	}
	////change password
	if(isset($_POST['changePass'])) {
		
		$curPass = $_POST['curPass'];
		
		$newP1 = $_POST['newPass'];
		$newP2 = $_POST['newPassConfirm'];
		
		if (password_verify($curPass, $userRow->{'password'}) && $newP1 == $newP2) {
			
			$newPass = password_hash($_POST['newPass'], PASSWORD_BCRYPT);
			
			$changePassSQL = "UPDATE `beta_users` SET `password` = '".$newPass."' WHERE `id` = '".$_SESSION['id']."'";
			$changePass = $conn->query($changePassSQL);
			
			if ($changePass) {
				header("Location: ?msg=pc");
			} else {
				header("Location: ?msg=ue");
			}
			
		} else {
			
			header('Location: ?msg=ip');  
			die();
			
		}
		
	}
	
	if(isset($_POST['changeTheme'])) {
		
		$theme = $_POST['theme'];
		
		if ($theme != 0) {
			if (!intval($theme) || $theme < -1 || $theme > 5) {
				die("Invalid Theme");
			}
		}
		$theme = mysqli_real_escape_string($conn , $theme); // just incase check fails
		
		$changeThemeSQL = "UPDATE `beta_users` SET `theme` = '$theme' WHERE `id` = '" . $_SESSION['id'] . "'";
		$changeThemeQuery = $conn->query($changeThemeSQL);
		
		if($changeThemeQuery) {
			header("Location: /settings/");
			die();
		}
		
	}
	
	if(isset($_POST['sendEmail'])) {
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailSQL = "INSERT INTO `emails` (`id`, `user_id`, `email`, `verified`, `date`) VALUES (NULL, '$userID', '$email', 'no', CURRENT_TIMESTAMP)";
			$emailQ = $conn->query($emailSQL);
		}
		header("Location: index");
	}
	
?>
<style>
#settingsInfo, #settingsTheme, #settingsBlurb, #changePassword {
	padding: 10px;
}

#changePassword input[type='password'] {
	margin-top:5px;
	width:100%;
}

#changePassword input[type='submit'] { 
	margin-top:5px;
}

#settingsUpperThird {
font-size: 14px;
margin-top: -10px;
}
</style>
<!DOCTYPE html>
	<head>
		<title>Settings - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box" style="width:100%;">
				<div id="subsect">
					<h4 style="padding-left:10px;">Settings</h4>
				</div>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Account Information</h6>
					<?php /*
					$id = $_SESSION['id'];
					$sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
					$userResult = $conn->query($sqlUser);
					$userRow=$userResult->fetch_assoc(); */
					?>
					<span style="font-weight:bold;">Username: </span><span><?php echo $userRow->{'username'}; ?></span>
					<br>
					<span style="font-weight:bold;">Joined: </span><span><?php echo $userRow->{'date'}; ?></span>
					<br>
					<span style="font-weight:bold;">Email:</span> <span><?php 
					$emailSQL = "SELECT * FROM `emails` WHERE `user_id` = '$userID' ORDER BY `id` DESC";
					$emailQ = $conn->query($emailSQL);
					if($emailQ->num_rows > 0) {
						$emailRow = $emailQ->fetch_assoc();
						$email = $emailRow['email'];
						$email = $email[0].$email[1].preg_replace('/[^@]+@([^\s]+)/', '***@$1', $email);
						echo $email; 
					} else {
						echo '<em>You have no email</em>';
					}
					
					?></span>
					<br>
					<span style="font-weight:bold;">Date of Birth: </span><span><?php echo date('m/Y',strtotime($userRow->{'birth'})); ?></span><br>
					<span style="font-weight:bold;">Gender: </span><span><?php echo ucfirst($userRow->{'gender'}); ?></span><br>
					<span style="font-weight:bold;">Membership: </span><span><?php
					$membershipSQL = "SELECT * FROM `membership` WHERE `user_id`='$currentUserID' AND `active`='yes'";
					$membership = $conn->query($membershipSQL);
					$m = 0;
					while($membershipRow = $membership->fetch_assoc()) {
						if($m > 0) {
							echo ', ';
						}
						$memPow = $membershipRow['membership'];
						$memSQL = "SELECT * FROM `membership_values` WHERE `value`='$memPow'";
						$mem = $conn->query($memSQL);
						$memRow = $mem->fetch_assoc();
						echo $memRow['name'];
						$m += 1;
					}
					if($membership->num_rows == 0) {echo '<em>You have no memberships</em>';}
					?></span><br>
					<span style="font-weight:bold;">Next Payout:</span> <span><?php echo date("Y-m-d H:i:s",strtotime($userRow->{'daily_bits'}.' + 1 day')); ?></span>
					
				</div>
				<hr>
				<div id="settingsInfo">
				<h6 id="settingsUpperThird">Themes</h6>
				<form action="" method="POST">
  					<input id="default" type="radio" name="theme" value="0" checked>
  					<label for="default">Default</label></input>
  					<?php
  					//<input id="oldtheme" type="radio" name="theme" value="0" disabled>
  					//<label for="oldtheme">Old Theme</label></input>
  					//<input id="wintertheme" type="radio" name="theme" value="1">
  					//<label for="wintertheme">Winter Theme</label></input>
  					?>
  					<span></span>
  					<input id="night" type="radio" name="theme" value="2">
  					<label for="night">Night Theme</label></input>
  					<?php
  					//<input id="summertheme" type="radio" name="theme" value="4">
					//<label for="summertheme">Summer Theme</label></input>
  					//<input id="falltheme" type="radio" name="theme" value="5">
					//<label for="falltheme">Fall Theme</label></input>
					?>
					<br>
  					<input id="disable-night" type="radio" name="theme" value="3">
  					<label for="disable-night">Disable Night Theme</label></input>
  					<br>
  					<input type="submit" value="Save" name="changeTheme"></input>
  					<input type="submit" value="Preview"></input>
				</form>
				</div>
				<hr>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Blurb</h6>
					<form action="" method="POST">
						<textarea name="desc" style="width: 97.3%;height:120px;resize: none;padding: 5px;font-size: 16px;"<?php
						echo 'placeholder="Hi, my name is ' . $userRow->{'username'} . '">' . $userRow->{'description'} . '</textarea>';
						?>
						<br>
						<input type="submit">
					</form>
				</div>
				<hr>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Change Email</h6>
					<form action="" method="POST">
						<span style="font-weight:bold;">Email: </span><br>
						<input style="margin:4px 0px 4px 0px;" name="email" type="text" placeholder="New email"
						<?php
						if($emailQ->num_rows > 0) {
						echo 'value="'.$email.'"';
						}
						?>
						><br>
						<input type="submit" name="sendEmail" value="Send">
						<input style="background-color: #03c303" type="submit" name="verifyEmail" value="Verify">
					</form>
				</div>
				<hr>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Date of Birth</h6>
					<form action="" method="POST">
						<span style="font-weight:bold;">Birthday: </span><br>
						<select name="year">
						<?php for($y = 1; $y <= 124; $y += 1) {echo '<option value="'.(date('Y')-$y).'">'.(date('Y')-$y).'</option>';} ?>
						</select>
						<select style="margin-left:5px;" name="month">
						<?php
						for($m = 1; $m <= 12; $m += 1) {
						$date   = DateTime::createFromFormat('!m', $m);
						$name = $date->format('F');
						echo '<option value="'.$m.'">'.$name.'</option>';} ?>
						</select><br>
						<input style="margin-top:5px;" type="submit" name="newBirth" value="Send">
					</form>
				</div>
				<hr>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Change Password</h6>
					<form action="" method="POST">
						<input style="margin-bottom:4px;" name="curPass" type="password" placeholder="Current password"><br>
						<input style="margin-bottom:4px;" name="newPass" type="password" placeholder="New password"><br>
						<input style="margin-bottom:4px;" name="newPassConfirm" type="password" placeholder="Confirm new password">
						<br>
						<input type="submit" name="changePass">
					</form>
				</div>
				<?php 
				/*<hr>
				<div id="settingsInfo">
					<h6 id="settingsUpperThird">Security Question</h6>
					<form action="" method="POST">
						<input style="margin-bottom:4px;" name="curPass" type="password" placeholder="Current password"><br>
						<input style="margin-bottom:4px;" name="newPass" type="password" placeholder="New password"><br>
						<input style="margin-bottom:4px;" name="newPassConfirm" type="password" placeholder="Confirm new password">
						<br>
						<input type="submit" name="changePass">
					</form>
				</div>*/
				?>
			</div>
		</div>
		<?php
		include("../SiT_3/footer.php");
		?>
	</body>
</html>