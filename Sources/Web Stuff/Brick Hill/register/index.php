<?php 
	include('../SiT_3/config.php');
	include('../SiT_3/header.php');
	
	if($loggedIn) {header("Location: /index"); die();}
	
	$error = array();
	if (isset($_POST['submit'])) {
		$username = str_replace(PHP_EOL, '', mysqli_real_escape_string($conn,$_POST['username']));
		$password = mysqli_real_escape_string($conn,$_POST['password']);
		$confirmPassword = $_POST['passwordConfirm'];
		$key = mysqli_real_escape_string($conn, $_POST['key']);
		$IP = $_SERVER['REMOTE_ADDR'];
		$curDate = date('Y-m-d');
		
		if(substr($username,-1) == " " || substr($username,0,1) == " ") {$error[] = "You cannot include a space at the beginning or end of your username.";}
		
		//If their username is less than 3 characters or not alnum
		$alnumUsername = str_replace(array('-','_','.',' '), '', $username);
		
		if(strlen($username) < 3 || strlen($username) > 26 || $username != ctype_alnum($alnumUsername)) {
			$error[] = 'Username must be 3-26 betanumeric characters (including [ , ., -, _]).';
		}
		
		if(strpos($username, '  ') !== false || strpos($username, '..') !== false || strpos($username, '--') !== false || strpos($username, '__') !== false) {
			$error[] = 'Spaces, periods, hyphens and underscores must be separated.';
		}
		//
		
		//If they have more than 5 accounts on this IP, no thank you
		$checkIPSQL = "SELECT * FROM `beta_users` WHERE `ip`='$IP'";
		$checkIP = $conn->query($checkIPSQL);
		if($checkIP->num_rows >= 5) {
			$error[] = 'You cannot make any more accounts.';
		}
		//
		
		
		if ( $password !== $confirmPassword ) {
			$error[] = 'Passwords do not match!';
		} 
		
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$error[] = 'Please enter a valid email!';
		}
		
		$mailCheckSQL = "SELECT * FROM `emails` WHERE `email`='$email'";
		$mailCheck = $conn->query($mailCheckSQL);
		if($mailCheck->num_rows >= 2) {
			$error[] = 'You can only associate 2 accounts with one email';
		}
		
		$birth_year = mysqli_real_escape_string($conn,intval($_POST['year']));
		$birth_month = mysqli_real_escape_string($conn,intval($_POST['month']));
		if (date('Y')-$birth_year >= 1 && date('Y')-$birth_year <= 124) {
			$birth_date = $birth_year."-".$birth_month."-01";
		} else {
			$error[] = "You must be between 1 and 124 years old to play Brick Hill.";
		}
		
		if(isset($_POST['gender'])) {$gender = mysqli_real_escape_string($conn,$_POST['gender']);} else {$gender = 'hidden';}
		if($gender != 'male' && $gender != 'female') {
			$gender = 'hidden';
		}
		
		
		
		$usernameL = strtolower(mysqli_real_escape_string($conn, $username));
		
		$checkUsernameSQL = "SELECT * FROM `bricflrb_login`.`beta_users` WHERE `beta_users`.`usernameL` = '$usernameL'";
		$checkUsername = $conn->query($checkUsernameSQL);
		
		if ($checkUsername->num_rows > 0) {
			$error[] = 'Username taken.';
		}
		
		
		/*$findKeySQL = "SELECT * FROM `reg_keys` WHERE `key_content` = '$key' AND `used` = 0";
			
		$findKey = $conn->query($findKeySQL);
		
		if(empty($error)) {
			if ($findKey->num_rows == 0) {
					$error[] = 'Invalid key!';
					
			} elseif($findKey->num_rows > 0) {
				
				$keyRow = $findKey->fetch_assoc();
				$keyID = $keyRow['id'];
				
				$updateKeySQL = "UPDATE `reg_keys` SET `used` = '1' WHERE `id` = '$keyID' ";
				$updateKey = $conn->query($updateKeySQL);
				
			}
		}*/
		
		if(empty($error)) {
			
			
		
			$password = password_hash($password, PASSWORD_BCRYPT);
			$username = mysqli_real_escape_string($conn, $username);
			
			do {    $uid = bin2hex(random_bytes(20));
				$uidCheckSQL = "SELECT * FROM `beta_users` WHERE `unique_key`='$uid'";
				$uidCheck = $conn->query($uidCheckSQL);
			} while ($uidCheck->num_rows > 0);
			
			$createUserSQL = "INSERT INTO `beta_users` (`id`, `username`, `usernameL`, `password`, `IP`, `birth`, `gender`, `date`, `last_online`, `daily_bits`, `views`, `description`, `bucks`, `bits`, `power`, `unique_key`, `theme`) VALUES (NULL, '$username', '$usernameL', '$password', '$IP', '$birth_date', '$gender', now(), '$curDate', '$curDate', '0', '', '1', '10', '0', '$uid','0')";
			
			$createUser = $conn->query($createUserSQL);
			if ($createUser) {
				$userID = $conn->insert_id;
				
				$emailSQL = "INSERT INTO `emails` (`id`, `user_id`, `email`, `verified`, `date`) VALUES (NULL, '$userID', '$email', 'no', CURRENT_TIMESTAMP)";
				$emailQ = $conn->query($emailSQL);
				
				do {    $uid = bin2hex(random_bytes(20));
					$uidCheckSQL = "SELECT * FROM `beta_users` WHERE `unique_key`='$uid'";
					$uidCheck = $conn->query($uidCheckSQL);
				} while ($uidCheck->num_rows > 0);
				
				if(substr($usernameL,-1) == 's') {$title = $username."' Set";}
				else {$title = $username."'s Set";}
				
				/*$gameSQL = "INSERT INTO `games` (`id`,`creator_id`,`name`,`description`,`playing`,`visits`,`date`,`last_updated`,`address`,`uid`,`active`) VALUES (NULL,  '$userID',  '$title',  '',  '0',  '0', CURRENT_TIME, CURRENT_TIME, '127.0.0.1', '$uid', '0')";
				$game = $conn->query($gameSQL);*/
				
				$tshirt = rand(1,8);
				$serialSQL = "SELECT * FROM `crate` WHERE `item_id`='$tshirt' ORDER BY `serial` DESC"; //find the serial SQL
				$serialQ = $conn->query($serialSQL); //
				$serialRow = $serialQ->fetch_assoc(); //
				$serial = $serialRow['serial']+1; //find the serial
				
				$addTshirtSQL = "INSERT INTO `crate` (`id`,`user_id`,`item_id`,`serial`) VALUES (NULL,'$userID','$tshirt','$serial')";
				$addTshirt = $conn->query($addTshirtSQL);
				
				$torsoColors = array('c60000','3292d3','85ad00','e58700');
				$legColors = array('650013','1c4399','1d6a19','76603f');
				$torso = $torsoColors[rand(0,3)];
				$leg = $legColors[rand(0,3)];
				$avatarSQL = "INSERT INTO `avatar` (`user_id`,`head_color`,`torso_color`,`right_arm_color`,`left_arm_color`,`right_leg_color`,`left_leg_color`,`face`,`shirt`,`pants`,`tshirt`,`hat1`,`hat2`,`hat3`,`hat4` ,`hat5`,`tool`,`head` ,`cache`) VALUES ('$userID',  'f3b700',  '$torso',  'f3b700',  'f3b700',  '$leg',  '$leg',  '0',  '0',  '0',  '$tshirt',  '0',  '0',  '0',  '0',  '0',  '0',  '0',  '0')";
				$avatar = $conn->query($avatarSQL);
				
				$_SESSION['id'] = $userID;
				header('Location: /customize/?regen');
			} else {
				$error[] = 'Database error';
			}
		}
			
		
		
	}
?>
<!DOCTYPE html>
	<head>
		<title>Brick Hill, the Online Playground</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<div id="subsect">
					<h3>Join Brick Hill</h3>
				</div>
				<?php
					if(!empty($error)) {
						echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
						foreach($error as $line) {
							echo $line.'<br>';
						}
						echo '</div>';
					}
				?>
				<form action="" method="POST" style="float:left;margin-left:10px;">
					<h4>Username:</h4>
					<h6>How will people recognize you?</h6>
					<input style="margin-left:5px;" type="text" name="username"><br>
					<h4 style="margin-top:10px;">Email:</h4>
					<h6>This must be valid so we can contact you!</h6>
					<input style="margin-left:5px;" type="text" name="email"><br>
					<h4 style="margin-top:10px;">Birthday:</h4>
					<h6>For your safety, please enter your date of birth.</h6>
					<select style="margin-left:5px;" name="year">
					<?php for($y = 1; $y <= 124; $y += 1) {echo '<option value="'.(date('Y')-$y).'">'.(date('Y')-$y).'</option>';} ?>
					</select>
					<select style="margin-left:5px;" name="month">
					<?php
					for($m = 1; $m <= 12; $m += 1) {
					$date   = DateTime::createFromFormat('!m', $m);
					$name = $date->format('F');
					echo '<option value="'.$m.'">'.$name.'</option>';} ?>
					</select><br>
					<h4 style="margin-top:10px;">Gender:</h4>
					<h6>Leave this blank if you don't want to say.</h6>
					<input type="radio" name="gender" value="male"><label>Male</label>
					<input type="radio" name="gender" value="female"><label>Female</label>
					<h4 style="margin-top:10px;">Password:</h4>
					<h6>Only you will know this!</h6>
					<input style="margin-left:5px;" type="password" name="password"><br>
					<h6>Please retype your password.</h6>
					<input style="margin-left:5px;" type="password" name="passwordConfirm"><br>
					<br><h6>By signing up, you agree to the <a href="/terms/">Terms</a></h6>
					<input style="margin:10px 0px 0px 5px;text-align:center;width:64px;height:24px;" type="submit" name="submit" value="Register">
				</form>
				<div style="margin:10px;border:1px solid #000;padding:10px;background-color:#FFF;clear:right;float:right;width:300px;">
					<h4>Under 13s...</h4>
					<p>If you are under 13, please get your parents' permission before creating your account!</p>
				</div>
				<div style="margin:10px;border:1px solid #000;padding:10px;background-color:#FFF;clear:right;float:right;width:300px;">
					<h4>Already have an account?</h4>
					<p>If you've forgotten your password, go to <a href="/forgot">forgot.</a><br>
					To login, go to <a href="/login">login</a>.<br>
					Can't play? Go to <a href="/download">download</a> and install the client!</p>
				</div>
				<div style="margin:10px;clear:right;float:right;width:300px;">
					<p style="font-size:14px;text-align:right;">Contact <a href="mailto:help@brick-hill.com">help@brick-hill.com</a> if you have any questions or queries!</p>
				</div>
			</div>
		</div>
		<?php
			include('../SiT_3/footer.php');
		?>
	</body>
</html>