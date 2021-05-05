<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
?>
<html>
	<head>
		<title>Forum - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<table width="100%" cellspacing="1" cellpadding="4" border="0" style="background-color:#000;">
				<tbody>
					<tr>
						<th width="50%">
							<p class="title" style="color:#FFF;">Forum</p>
						</th>
						<th width="12%">
							<p class="title" style="color:#FFF;">Topics</p>
						</th>
						<th width="12%">
							<p class="title" style="color:#FFF;">Posts</p>
						</th>
						<th width="26%">
							<p class="title" style="color:#FFF;">Latest Post</p>
						</th>
					</tr>
					
					
					<?php
					if(!$loggedIn || $power <= 0) {$sqlForum = "SELECT * FROM `forum_boards` WHERE `id` >= 1 ORDER BY `id` ASC";}
					else {$sqlForum = "SELECT * FROM `forum_boards` ORDER BY `id` ASC";}
					$boardResult = $conn->query($sqlForum);
					$table = '';
					
					while($forumRow=$boardResult->fetch_assoc()) {
						$forumID = $forumRow['id'];
						
						$sqlThread = "SELECT * FROM `forum_threads` WHERE  `board_id` = '$forumID' AND `deleted` = 'no' ORDER BY `latest_post` DESC";
						$threadResult = $conn->query($sqlThread);
						$threadRow = $threadResult->fetch_assoc();
						$threadID = $threadRow['id'];
						
						$sqlPost = "SELECT * FROM `forum_posts` WHERE  `thread_id` = '$threadID' ORDER BY `id` DESC";
						$postResult = $conn->query($sqlPost);
						$postRow = $postResult->fetch_assoc();
						if ($postResult->num_rows == 0) {//($postRow['author_id']->num_rows == 0) {
							$sqlPost = "SELECT * FROM `forum_threads` WHERE  `id` = '$threadID' ORDER BY `id` DESC";
							$postResult = $conn->query($sqlPost);
							$postRow = $postResult->fetch_assoc();
						}
						
						$authorID = $postRow['author_id'];
						$sqlUser = "SELECT * FROM `beta_users` WHERE  `id` = '$authorID'";
						$forumUserResult = $conn->query($sqlUser);
						$forumUserRow=$forumUserResult->fetch_assoc();
						
						$topicsSQL = "SELECT * FROM `forum_threads` WHERE `board_id` = '$forumID'";
						$topicsResult = $conn->query($topicsSQL);
						
						$postsSQL = "SELECT * FROM `forum_posts`";
						$postsResult = $conn->query($postsSQL);
						$count = 0;
						while ($postsRow=$postsResult->fetch_assoc()) {
							$threadParent = $postsRow['thread_id'];
							$threadsSQL = "SELECT * FROM `forum_threads` WHERE `id` = '$threadParent' AND `board_id` = '$forumID'";
							$threadsResult = $conn->query($threadsSQL);
							if ($threadsResult->num_rows != 0) {$count += 1;}
						}
						
						//this is where is slows down
						$table .= '<tr class="forumColumn">
						<td>
							<a class="title" href="board?id=' . $forumID .'">' . $forumRow['name'] . '</a>
							<p class="description">' . $forumRow['description'] . '</p>
						</td>
						<td style="text-align:center;">
							<p class="description">' . $topicsResult->num_rows . '</p>
						</td>
						<td style="text-align:center;">
							<p class="description">' . ($count+$topicsResult->num_rows) . '</p>
						</td>
						<td>
							<p class="description"><strong>' . $postRow['date'] . '</strong> in <a class="description" href="thread?id=' . $threadRow['id'] . '"><strong>' . htmlentities($threadRow['title']) . '</strong></a><br>by <a class="description" href="/user?id=' . $authorID . '"><strong>' . $forumUserRow['username'] . '</strong></a></p>
						</td>
						</tr>';
						}
						echo $table;
					?>
					
					
					
					
				</tbody>
			</table>

		</div>
		<?php
		include("../SiT_3/footer.php");
		?>
	</body>
</html>