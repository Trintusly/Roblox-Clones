<?php 
	include('../SiT_3/config.php');
	include('../SiT_3/header.php');
	
	if($loggedIn) {header("Location: /index"); die();}
	
	$error = array();
	if (isset($_POST['ln'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		
		$usernameL = strtolower(mysqli_real_escape_string($conn, $username));
		
		$checkUsernameSQL = "SELECT * FROM `beta_users` WHERE `beta_users`.`usernameL` = '$usernameL'";
		$checkUsername = $conn->query($checkUsernameSQL);
		
		if ($checkUsername->num_rows > 0) {
			
			$username = mysqli_real_escape_string($conn, $username);
			
			$userReqRow = (object) $checkUsername->fetch_assoc();
			
			$userPass = $userReqRow->{'password'};
			
			if (password_verify($password, $userPass)) { //logged in
				$_SESSION['id'] = $userReqRow->{'id'};
				$userID = $_SESSION['id'];
				$userIP = $_SERVER['REMOTE_ADDR'];
				$logSQL = "INSERT INTO `log` (`id`,`action`,`date`) VALUES (NULL,'User $userID logged in from $userIP',CURRENT_TIMESTAMP)";
				$log = $conn->query($logSQL);
				header('Location: ../ ');
				die();
			} else {
				$error[] = "Wrong password!";
			}
			
		} else {
			$error[] = "User does not exist!";
			
		}
		
	}
?>
<!DOCTYPE html>
	<head>
		<title>Brick Hill, the Online Playground</title>
	</head>
	<body>
		<div id="body">
			<div style="overflow:auto;">
				<div id="column" style="width:197px;float:left;">
					<div id="box" style="padding:10px;">
						<?php
						if(!empty($error)) {
							echo '<div style="color:#EE3333;">';
							foreach($error as $line) {
								echo $line.'<br>';
							}
							echo '</div>';
						}
						?>
						<form action="" method="POST">
							<strong>Username:</strong><br>
							<input style="margin-top:4px;margin-bottom:4px;" type="text" name="username"><br>
							<strong>Password:</strong><br>
							<input style="margin-top:4px;" type="password" name="password"><br>
							<center>
								<input style="text-align:center;margin-top:8px;width:64px;height:24px;" type="submit" name="ln" value="Login">
								<h5 onclick="alert('That\'s a shame');">Forgot password?</h5>
								<a href="/register/"><input style="text-align:center;width:64px;height:24px;" type="button" value="Register"></a>
							</center>
						</form>
					</div>
				</div>
				<div id="column" style="width:77%;float:right;">
					<div id="box">
						<h3>Brick Hill, the FREE Online Playground!</h3>
						<iframe style="float:left;margin:0px 10px 0px 10px;width:320px;height:180px;border:0px;" src="https://www.youtube.com/embed/WmNy5rH8U7A?showinfo=0&controls=0"></iframe>
						<h4>Play online</h4>
						<h5>There's lots of different games to choose from!</h5>
						<h4>Build a map!</h4>
						<h5>Stretch your imagination in our work in progress workshop!</h5>
						<h4>Make new friends!</h4>
						<h5>Meet tons of people on our social forum, clans and in-game chat!</h5>
					</div>
				</div>
			</div>
			<div id="box" style="margin-top:10px;">
				<h4>Awesome Sets!</h4>
				<?php
					$setsSQL = "SELECT * FROM `games` ORDER BY `visits` DESC LIMIT 6";
					$sets = $conn->query($setsSQL);
					while($setRow = $sets->fetch_assoc()) {
						echo '
						<a href="http://www.brick-hill.com/play/set?id='.$setRow['id'].'">
						<img style="margin:10px;width:120px;height:70px;" src="http://storage.brick-hill.com/images/games/'.$setRow['id'].'.png" title="'.$setRow['name'].'"></a>';
					}
				?>
			</div>
		</div>
		<?php
			include('../SiT_3/footer.php');
		?>
	</body>
</html>