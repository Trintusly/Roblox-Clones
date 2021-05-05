<?php 

	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header('Location: index'); die();}

	$userID = $_SESSION['id'];
	$boardID = $_GET['id'];
	$boardIDSafe = mysqli_real_escape_string($conn, $boardID);
	
	$BoardSQL = "SELECT * FROM `forum_boards` WHERE `id`='$boardIDSafe'";
	$Board = $conn->query($BoardSQL);
	$BoardRow = $Board->fetch_assoc();
	$BoardName = $BoardRow['name'];
	if (empty($BoardName)) {
		header("Location: /forum/");
	}
	
	$error = array();
	if (isset($_POST['title']) && isset($_POST['body'])) {
		$lastPostSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$userID' ORDER BY `id` DESC";
		$lastPost = $conn->query($lastPostSQL);
		$lastPostRow = $lastPost->fetch_assoc();
		
		$lastThreadSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$userID' ORDER BY `id` DESC";
		$lastThread = $conn->query($lastThreadSQL);
		$lastThreadRow = $lastThread->fetch_assoc();
		
		$last = max(strtotime($lastPostRow['date']),strtotime($lastThreadRow['date']));
		
		if(time()-$last >= 30) {
			if (strlen(str_replace(" ","",$_POST['title'])) > 60 || strlen(str_replace(array(" ","\r", "\n"), '',$_POST['title'])) < 2) {$error[] = "Title must be between 2 and 60 characters";}
			if (strlen(str_replace(" ","",$_POST['body'])) > 3000 || strlen(str_replace(array(" ","\r", "\n"), '',$_POST['body'])) < 10) {$error[] = "Body must be between 10 and 3,000 characters";}
			if(empty($error)) {
				$time = time();
				$title = mysqli_real_escape_string($conn, $_POST['title']);
				$body = mysqli_real_escape_string($conn, $_POST['body']);
				$postThreadSQL = "INSERT INTO `forum_threads` (`id`, `author_id`, `board_id`, `title`, `body`, `locked`, `pinned`, `deleted`, `date`, `latest_post`) VALUES (NULL, '$userID', '$boardIDSafe', '$title', '$body', 'no', 'no', 'no', '$curDate', '$time')";
				$postThread = $conn->query($postThreadSQL);
				$newThreadID = $conn->insert_id;
				
				header("Location: /forum/thread?id=$newThreadID");
			}
		} else {
			$error[] = "You are posting too fast";
		}
	}
	
?>
<!DOCTYPEhtml>
<html>
	<head>
		<title>Create - Brick Hill</title>
	</head>
	
	<body>
		<div id="body">
					<p style="color: white;"><a style="color: white;text-decoration:underline;" href="/forum">Forum</a> >> <a style="color: white;text-decoration:underline;"  href="board?id=<?php echo $BoardRow['id']; ?>"><?php echo $BoardName; ?></a></p>
			<div id="box" style="padding:10px;">
				<?php
				if(!empty($error)) {
					echo '<div style="background-color:#EE3333;margin:10px;padding:5px;color:white;">';
					foreach($error as $errno) {
						echo $errno."<br>";
					} 
					echo '</div>';
				}
				?>
				<h4>Create Thread in <?php echo $BoardName; ?></h4>
				<form action="" method="POST" id="createThread">
					<input type="text" name="title" id="tT" style="width: 873px;margin-top: 0px;margin-bottom: 0px;resize: none;border: 1px solid black;font-size: 16px;padding: 5px 0px 5px 5px;" placeholder="Title (max 60 characters)">
					<textarea name="body" id="tB" style="width: 869px; height: 200px; margin: 10px 0px 0px; font-size: 16px; border: 1px solid black; resize: vertical;padding: 5px 0px 5px 5px;" placeholder="Body (max 3,000 characters)"></textarea>
					<input type="submit" value="Create Thread" style="float:right;margin:10px;">
				</form>
			</div>
		</div>
		<?php
		include("../SiT_3/footer.php");
		?>
	</body>
	
</html>