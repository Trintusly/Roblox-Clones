<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");

	if(!$loggedIn) {header('Location: ../'); die();}

	if (isset($_POST['send'])) {
		
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$message = mysqli_real_escape_string($conn, $_POST['message']);
		$uid = $_SESSION['id'];
		$date = date('Y-m-d');
		
		$rid = mysqli_real_escape_string($conn,intval($_POST['recipient']));
		
		
		if (empty($title) || empty($message)) {
			die('Missing Parameter');
		}
		
		$sendMessageSQL = "INSERT INTO `messages` (`id`, `author_id`, `recipient_id`, `date`, `title`, `message`, `read`) VALUES (NULL, '$uid', '$rid', '$date', '$title', '$message', '0')";
		$sendMessage = $conn->query($sendMessageSQL);

		if ($sendMessage) {
			header('Location: index');
		} else {
			echo $sendMessageSQL;
			die('There was an error trying to send your message');
		}
	}
	
	if (isset($_POST['recipient'])) {
		$recipient = mysqli_real_escape_string($conn,$_POST['recipient']);
	if(isset($_POST['title'])) {$title = mysqli_real_escape_string($conn,$_POST['title']);} else {$title = '';}
	if(isset($_POST['message'])) {$message = $_POST['message'];} else {$message = '';}
	} else {
		header('Location: index');
	}
?>

<!DOCTYPE html>
	<head>
		<title>Compose - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<form style="margin:10px;" action="?" method="POST">
					<h4>Title</h4>
					<input type="text" name="title" value="<?php echo $title; ?>"><br>
					<h4>To</h4>
					<?php 
						$id = $recipient;
						$sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$id'";
						$userResult = $conn->query($sqlUser);
						$userRow=$userResult->fetch_assoc();
						
						echo '<input type="hidden" name="recipient" value="' . $userRow['id'] . '">'.$userRow['username'];
					?><br>
					<h4>Message</h4>
					<textarea style="width: 540px; height: 150px;" name="message"><?php echo $message; ?></textarea><br>
					<input style="background-color:#77B9FF; color:#FFF; border:1px solid #000;" type="submit" name="send" value="Send">
				</form>
			</div>
		</div>
	</body>
	<?php
		include("../SiT_3/footer.php");
	?>
</html>