<?php 

	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header('Location: index'); die();}

	$userID = $_SESSION['id'];
	$threadID = $_GET['id'];
	$threadIDSafe = mysqli_real_escape_string($conn, $threadID);
	
	$findThreadQuery = "SELECT * FROM `forum_threads` WHERE `id` = $threadIDSafe";
	$findThread = $conn->query($findThreadQuery);
	
	if ( $findThread->num_rows > 0 ) {
		$threadRow = (object) $findThread->fetch_assoc();
	} else {
		header("Location: /forum/");
		}
		
	if ($threadRow->{'locked'} == 'yes' || $threadRow->{'deleted'} == 'yes') {header("Location: /forum/thread?id=$threadID");}
	
	$error = array();
	if (isset($_POST['reply'])) {
		$lastPostSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$userID' ORDER BY `id` DESC";
		$lastPost = $conn->query($lastPostSQL);
		$lastPostRow = $lastPost->fetch_assoc();
		
		$lastThreadSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$userID' ORDER BY `id` DESC";
		$lastThread = $conn->query($lastThreadSQL);
		$lastThreadRow = $lastThread->fetch_assoc();
		
		$last = max(strtotime($lastPostRow['date']),strtotime($lastThreadRow['date']));
		
		if(time()-$last >= 30) {
			$reply = mysqli_real_escape_string($conn,$_POST['reply']);
			if(strlen(str_replace(array("\r", "\n"), '',$reply)) >= 2 && strlen(str_replace(array("\r", "\n"), '',$reply)) <= 1000) {
				$sendMessageSQL = "INSERT INTO `forum_posts` (`id`, `author_id`, `thread_id`, `body`, `date`) VALUES (NULL, '$userID', '$threadIDSafe', '$reply', '$curDate')";
				$sendMessage = $conn->query($sendMessageSQL);
				$newPostID = $conn->insert_id;
				
				$time = time();
				$updateReplySQL = "UPDATE `forum_threads` SET `latest_post` = '$time' WHERE `id` = '$threadID'";
				$updateReply = $conn->query($updateReplySQL);
				
				$sqlCount = "SELECT * FROM `forum_posts` WHERE `thread_id` = '$threadID'";
				$countQ = $conn->query($sqlCount);
				$count = $countQ->num_rows;
				$page = (int)($count/10)+1;
				
				header("Location: /forum/thread?id=$threadID&page=$page#post$newPostID");
			} else {
				$error[] = "Reply must be between 2 and 1,000 characters";
			}
		} else {
			$error[] = "You are posting too fast";
		}
		
	}
	if ( $findThread->num_rows > 0 ) {
		$boardID = $threadRow->{'board_id'};
		
		// Finding Board
		
		$boradSQL = "SELECT * FROM `forum_boards` WHERE `id` = '$boardID'";
		$board = $conn->query($boradSQL);
		$boardRow = (object) $board->fetch_assoc();
	}
	
?>
<!DOCTYPEhtml>
<html>
	<head>
		<title>Reply - Brick Hill</title>
	</head>
	
	<body>
		<div id="body">
			<p style="color: white;"><a style="color: white;text-decoration:underline;" href="/forum">Forum</a> >> <a style="color: white;text-decoration:underline;"  href="board?id=<?php echo $boardRow->{'id'} ?>"><?php echo $boardRow->{'name'}; ?></a> >> <a style="color: white;text-decoration:underline;" href="thread?id=<?php echo $threadRow->{'id'}; ?>"><?php echo $threadRow->{'title'}; ?></a></p>
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
				<h4>Reply to <?php echo htmlentities($threadRow->{'title'}); ?></h4>
				<form action="" method="POST" id="createReply">
					<textarea name="reply" style="width: 869px; height: 200px; margin: 10px 0px 0px; font-size: 16px; border: 1px solid black; resize: vertical;padding: 5px 0px 5px 5px;" placeholder="Body (max 3,000 characters)" id="rB"><?php
					
					if(isset($_GET['quote'])) {
						$quoteID = mysqli_real_escape_string($conn,$_GET['quote']);
						$findReplyQuery = "SELECT * FROM `forum_posts` WHERE `id` = '$quoteID'";
						$findReply = $conn->query($findReplyQuery);
						$threadRow = $findReply->fetch_assoc();
						
						$authorID = $threadRow['author_id'];
					
						// Finding Creator
						$findCreatorSQL = "SELECT * FROM `beta_users` WHERE `id` = '$authorID'";
						$findCreator = $conn->query($findCreatorSQL);
						$creatorRow = $findCreator->fetch_assoc();
						
						echo '[quote][i]Quote from [url=http://beta.brick-hill.com/user/'.$authorID.'/]'.$creatorRow['username'].'[/url], '.$threadRow['date'].'[/i]
'.$threadRow['body'].'[/quote]';
					}
					
					?></textarea>
					<input type="submit" value="Reply" style="float:right;margin:10px">
				</form>
			</div>
		</div>
	</body>
				<?php
			include("../SiT_3/footer.php");
			?>
</html>