<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	$forumID = mysqli_real_escape_string($conn, intval($_GET['id']));
	
	if($power <= 0 && $forumID <= 0) {header("board?id=1");}
	
	if(isset($_GET['page'])) {$page = mysqli_real_escape_string($conn,intval($_GET['page']));} else {$page = 0;}
	$page = max($page,1);
	
	$sqlCount = "SELECT * FROM `forum_threads` WHERE `board_id` = '$forumID' AND `deleted` = 'no'";
	$countQ = $conn->query($sqlCount);
	$count = $countQ->num_rows;
	
	$page = min($page,max((int)($count/20),1));
	
	$limit = ($page-1)*20;
	$sqlPosts = "SELECT * FROM `forum_threads` WHERE  `board_id` = '$forumID' AND `deleted` = 'no' ORDER BY `pinned` ASC, `latest_post` DESC LIMIT $limit,20";
	$postsResult = $conn->query($sqlPosts);
		
	
	$BoardSQL = "SELECT * FROM `forum_boards` WHERE `id` = '$forumID'";
	$Board = $conn->query($BoardSQL);
	$BoardRow = $Board->fetch_assoc();
	$BoardName = $BoardRow['name'];
	
?>

<title> <?php echo $BoardName ?> - Brick Hill</title>
  <meta charset="UTF-8">
  <meta name="description" content="<?php echo $BoardRow['description'] ?>">
  <meta name="keywords" content="free,game">
  
  <meta property="og:title" content="<?php echo $BoardRow['name'] ?>" />
  <meta property="og:description" content="<?php echo $BoardRow['description'] ?>" />
  <meta property="og:type" content="website" />
<body>
		<div id="body">
			<span>
			<p style="color: white; float:left;margin-top:0px;"><a style="color: white;text-decoration:underline;" href="/forum">Forum</a> >> <a style="color: white;text-decoration:underline;"  href="board?id=<?php echo $forumID; ?>"><?php echo $BoardName; ?></a></p>
			<?php 
			if($loggedIn) {
				echo '<a class="nav" style="float:right;" href="create?id='.$forumID.'">Create</a>';
			}
			?>
			<span class="nav" style="float:right;color:white;margin-top: -4px;padding-right: 8px;">|</span>
			<a class="nav" href="mythreads" style="float:right;padding-right: 4px;">My Threads</a>
			<span class="nav" style="float:right;color:white;margin-top: -4px;padding-right: 8px;">|</span>
			<a class="nav" href="search" style="float:right;padding-right: 4px;">Search Forum</a> 
			</span>
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
						while($postRow=$postsResult->fetch_assoc()) {
							$postID = $postRow['id'];
							$authorID = $postRow['author_id'];
							
							$sqlAuthor = "SELECT * FROM `beta_users` WHERE `id`='$authorID'";
							$author = $conn->query($sqlAuthor);
							$authorRow = $author->fetch_assoc();
							
							$sqlReply = "SELECT * FROM `forum_posts` WHERE  `thread_id` = '$postID' ORDER BY `id` DESC";
							$replyResult = $conn->query($sqlReply);
							$replyRow=$replyResult->fetch_assoc();
							$replyNum=$replyResult->num_rows;
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
							
							$postViews = $postRow['views'] -1;
							echo '<tr class="forumColumn">
							<td>';
							
							if ($postRow['pinned'] == 'yes') {echo '<i class="fa fa-thumb-tack"></i> ';}
							if ($postRow['locked'] == 'yes') {echo '<i class="fa fa-lock"></i> ';}
							echo '<a class="title" href="thread?id=' . $postID .'">' . htmlentities($postRow['title']) . '</a><br><a style="font-size:12px;color:#333;" href="/user?id='.$authorID.'">' . $authorRow['username'] . '</a>
							</td>
							<td style="text-align:center;">
								<p class="description">' . $replyNum . '</p>
							</td>
							<td style="text-align:center;">
								<p class="description">' . $postViews . '</p>
							</td>
							<td>
								<p class="description"><strong>' . $replyRow['date'] . '</strong><br>by <a class="description" href="/user?id=' . $lastReplyID . '"><strong>' . $forumUserRow['username'] . '</strong></a></p>
							</td>
							</tr>';
						}
					?>
				</tbody>
			</table>
			<?php
			echo '</div><div class="numButtonsHolder" style="margin-left:auto;margin-right:auto;margin-top:10px;">';
			if($page-2 > 0) {
			    echo '<a href="board?id='.$forumID.'&page=0">1</a> ... ';
			}
			if($count/20 > 1) {
		          for($i = max($page-2,0); $i < min($count/20,$page+2); $i++)
		          {
		            echo '<a href="board?id='.$forumID.'&page='.($i+1).'">'.($i+1).'</a> ';
		          }
		        }
		        if($count/20 > 4) {
		            echo '... <a href="board?id='.$forumID.'&page='.(int)($count/20).'">'.(int)($count/20).'</a> ';
		        }
			
			echo '</div>';
			?>

		</div>
		<?php
		include("../SiT_3/footer.php");
		?>
	</body>