<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header('Location: ../'); die();}
	
	if (isset($_GET['id'])) {
		$mid = mysqli_real_escape_string($conn,intval($_GET['id']));
		$sqlMessage = "SELECT * FROM `messages` WHERE  `id` = '$mid'";
		$result = $conn->query($sqlMessage);
		$messageRow=$result->fetch_assoc();
		if ($messageRow['recipient_id'] != $userRow->{'id'} && $power < 1) {header("location: index");}
		
		$senderID = $messageRow['author_id'];
		$sqlSender = "SELECT * FROM `beta_users` WHERE  `id`='$senderID'";
		$sendResult = $conn->query($sqlSender);
		$senderRow=$sendResult->fetch_assoc();
		
		$sqlRead = "UPDATE `messages` SET `read` = 1 WHERE `id` = '$mid'";
		$result = $conn->query($sqlRead);
	} else {
		header("location: index");
	}
?>

<!DOCTYPE html>
	<head>
		<title><?php echo $messageRow['title']; ?> - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box">
				<span style="float:left;">
					<a style="color:#333" href="/user?id=<?php echo $senderRow['id']; ?>">
					<img style="width:225px;" src="http://storage.brick-hill.com/images/avatars/<?php echo $senderRow['id']; ?>.png?c=<?php echo $senderRow['avatar_id'] ?>"><br><?php echo $senderRow['username']; ?></a><br>
					<?php echo '<a href="/report?type=message&id='.$mid.'"><i style="color:#444;font-size:13px;" class="fa fa-flag"></i></a>'; ?>
				</span>
				<span>
					<h3><?php echo htmlentities($messageRow['title']); ?></h3>
					<p style="clear: right;padding-left: 230px;"><?php echo nl2br(htmlentities($messageRow['message'])); ?></p>
				</span>
				<form action="compose" method="POST">
					<input type="hidden" name="title" value="<?php echo 'RE: ' . $messageRow['title']; ?>">
					<input type="hidden" name="recipient" value="<?php echo $senderRow['id']; ?>">
					<input type="hidden" name="message" value="<?php $n = PHP_EOL; echo str_repeat($n,3) . str_repeat('-',24) . $senderRow['username'] . ' at ' . $messageRow['date'] . str_repeat('-',24) . $n . $messageRow['message']; ?>">
					<input style="background-color:#77B9FF; color:#FFF; border:1px solid #000;" type="submit" value="Reply">
				</form>
			</div>
		</div>
	</body>
	<?php
		include("../SiT_3/footer.php");
	?>
</html>