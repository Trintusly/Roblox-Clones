<?php 

	include("../SiT_3/config.php");
	include("../SiT_3/header.php");

	$userID = $_SESSION['id'];
	$threads = array();
	
	if(isset($_GET['search'])) {
		$search = mysqli_real_escape_string($conn,$_GET['search']);
		
		$postsSQL = "SELECT * FROM `forum_posts` WHERE `body` LIKE '%$search%'";
		$posts = $conn->query($postsSQL);
		while($postRow = $posts->fetch_assoc()) {
			$threads[] = $postRow['thread_id'];
		}
		$postsSQL = "SELECT * FROM `forum_threads` WHERE `body` LIKE '%$search%' OR `title` LIKE '%$search%' AND `deleted`='no'";
		$posts = $conn->query($postsSQL);
		while($postRow = $posts->fetch_assoc()) {
			$threads[] = $postRow['id'];
		}
		$threadList = array_unique($threads);
	}
	
?>
<!DOCTYPE html>

<body>
	<head>
		<title>Search Forum - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div style="overflow:auto;">
			<p style="color: white; float:left;margin-top:0px;"><a style="color: white;text-decoration:underline;" href="/forum">Forum</a>>> <a style="color: white;text-decoration:underline;"  href="search">Search</a></p>
			<a class="nav" href="mythreads" style="float:right;padding-right: 4px;">My Threads</a>
			<span style="float:right;color:white;margin-top: -4px;padding-right: 8px;">|</span>
			<a class="nav" href="search" style="float:right;padding-right: 4px;">Search Forum</a> 
			</div>
			<div id="box" style="text-align:center;margin-bottom:10px;">
				<div id="subsect">
					<form action="" method="GET" style="margin:15px;">
						<input style="width:500px; height:20px;" type="text" name="search" placeholder="I'm looking for...">
						<input style="height:24px;" type="submit" value="Submit">
					</form>
				</div>
			</div>
			<table width="100%" cellspacing="1" cellpadding="4" border="0" style="background-color:#000;">
				<tbody>
					<tr>
						<th width="50%">
							<p class="title" style="color:#FFF;">Title</p>
						</th>
						<th width="12%">
							<p class="title" style="color:#FFF;">Replies</p>
						</th>
						<th width="12%">
							<p class="title" style="color:#FFF;">Views</p>
						</th>
						<th width="26%">
							<p class="title" style="color:#FFF;">Latest Post</p>
						</th>
					</tr>
					
					
					<?php
						foreach($threadList as $threadID) {
							$sqlPosts = "SELECT * FROM `forum_threads` WHERE  `id` = '$threadID' ORDER BY `latest_post` DESC";
							$postsResult = $conn->query($sqlPosts);
							$postRow = $postsResult->fetch_assoc();
							
							$postID = $postRow['id'];
							$authorID = $postRow['author_id'];
							
							$sqlAuthor = "SELECT * FROM `beta_users` WHERE `id`='$authorID'";
							$author = $conn->query($sqlAuthor);
							$authorRow = $author->fetch_assoc();
							
							$sqlReply = "SELECT * FROM `forum_posts` WHERE  `thread_id` = '$postID' ORDER BY `id` DESC";
							$replyResult = $conn->query($sqlReply);
							$replyRow=$replyResult->fetch_assoc();
							$lastReplyID = $replyRow['author_id'];
							if (empty($lastReplyID)) {
								$sqlReply = "SELECT * FROM `forum_threads` WHERE  `id` = '$postID' ORDER BY `id` DESC";
								$replyResult = $conn->query($sqlReply);
								$replyRow=$replyResult->fetch_assoc();
								$lastReplyID = $replyRow['author_id'];
							}
							
							$sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$lastReplyID'";
							$forumUserResult = $conn->query($sqlUser);
							$forumUserRow=$forumUserResult->fetch_assoc();
							
							echo '<tr class="forumColumn">
							<td>';
							
							if ($postRow['pinned'] == 'yes') {echo '<i class="fa fa-thumb-tack"></i> ';}
							if ($postRow['locked'] == 'yes') {echo '<i class="fa fa-lock"></i> ';}
							
							echo '<a class="title" href="thread?id=' . $postID .'">' . $postRow['title'] . '</a><br><a style="font-size:12px;color:#333;" href="/user?id='.$authorID.'">' . $authorRow['username'] . '</a>
							</td>
							<td style="text-align:center;">
								<p class="description">' . $replyResult->num_rows . '</p>
							</td>
							<td style="text-align:center;">
								<p class="description">' . $postRow['views'] . '</p>
							</td>
							<td>
								<p class="description"><strong>' . $replyRow['date'] . '</strong><br>by <a class="description" href="/user/' . $lastReplyID . '/"><strong>' . $forumUserRow['username'] . '</strong></a></p>
							</td>
							</tr>';
						
						
						}
					?>
				</tbody>
			</table>

		</div>
		<?php
		include("../SiT_3/footer.php");
		?>
	</body>