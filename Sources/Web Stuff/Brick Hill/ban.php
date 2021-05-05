<?php
	include('SiT_3/config.php');
	include('SiT_3/header.php');
	
	if(!$loggedIn) {header("Location: index");}
	
	$error = array();
	if($power >= 1) {
		if(isset($_GET['id'])) {
			if(isset($_POST['submit'])) {
				if(isset($_POST['note']) && strlen($_POST['note']) > 1) {
					if(isset($_POST['length']) && $_POST['length'] >= 0 && $_POST['length'] != null) {
						$user = mysqli_real_escape_string($conn,$_GET['id']);
						$admin = $_SESSION['id'];
						$note = str_replace("'","\'",$_POST['note']);
						$length = mysqli_real_escape_string($conn,$_POST['length']);
						$banSQL = "INSERT INTO `moderation` (`id`,`user_id`,`admin_id`,`admin_note`,`issued`,`length`,`active`) VALUES (NULL ,'$user','$admin','$note', '$curDate','$length','yes')";
						$ban = $conn->query($banSQL);
						
						$action = 'Banned user'.$user.' for '.$length.' minutes';
						$date = date('d-m-Y H:i:s');
						$adminSQL = "INSERT INTO `admin` (`id`,`admin_id`,`action`,`time`) VALUES (NULL ,  '$admin',  '$action',  '$date')";
						$admin = $conn->query($adminSQL);
						
						header("location: index");
					} else {
						$error[] = "Invalid ban length";
					}
				} else {
					$error[] = "Please include a moderator note";
				}
			}
		} else {
			$error[] = 'Invalid user ID';
		}
	} else {
		header("location: index");
	}

?>
<!DOCTYPE html>
	<head>
		<title>Ban - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box" style="padding:10px;">
				<?php
				if(!empty($error)) {
					echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
					foreach($error as $errno) {
						echo $errno."<br>";
					} 
					echo '</div>';
				}
				if(isset($_POST['submit']) && empty($error)) {
					echo '<h3>User has been banned</h3>';
				}
				?>
				<form action="" method="POST">
					Ban user <?php echo $_GET['id']; ?><br>
					<label>Moderator Note:</label><br>
					<textarea name="note" style="width:300px;height:140px;"></textarea>
					<br>
					<label>Ban Length (Minutes):</label>
					<input type="text" name="length"><br>
					<input type="submit" name="submit" value="Ban User">
				</form>
			</div>
		</div>
	</body>
</html>