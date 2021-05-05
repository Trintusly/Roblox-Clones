<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header('Location: ../'); die();}
	
	if(isset($_GET['page'])) {$page = mysqli_real_escape_string($conn,intval($_GET['page']));}
	$page = max($page,1);
	$limit = ($page-1)*20;
	
	$mID = $_SESSION['id'];
	$sqlCount = "SELECT * FROM `messages` WHERE  `recipient_id` = '$mID'";
	$countQ = $conn->query($sqlCount);
	$count = $countQ->num_rows;
	
	$sqlSearch = "SELECT * FROM `messages` WHERE  `recipient_id` = '$mID' ORDER BY `id` DESC LIMIT $limit,20";
	$result = $conn->query($sqlSearch);
?>

<!DOCTYPE html>
	<head>
		<title>Messages - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<table width="100%" cellspacing="1" cellpadding="4" border="0" style="background-color:#000;">
				<tbody>
					<tr>
						<th width="20%">
							<p class="title" style="color:#FFF;">Title</p>
						</th>
						<th width="50%">
							<p class="title" style="color:#FFF;">Message</p>
						</th>
						<th width="15%">
							<p class="title" style="color:#FFF;">From</p>
						</th>
						<th width="15%">
							<p class="title" style="color:#FFF;">Sent</p>
						</th>
					</tr>
					<?php
						while($messageRow=$result->fetch_assoc()) {
							if (!$messageRow['read']) {$weight = "bold";} else {$weight = "normal";}
							$senderID = $messageRow['author_id'];
							$sqlSender = "SELECT * FROM `beta_users` WHERE  `id` = '$senderID'";
							$sendResult = $conn->query($sqlSender);
							$senderRow=$sendResult->fetch_assoc();
							?>
							<tr>
								<td>
									<a style="font-weight: <?php echo $weight; ?> ; color:#000;" href="message?id=<?php echo $messageRow['id']; ?>"><?php echo htmlentities($messageRow['title']); ?></a></td>
							<td>
								<a style="font-weight:<?php echo $weight; ?>; color:#000;" href="message?id=<?php echo $messageRow['id']; ?>"> <?php echo htmlentities(substr($messageRow['message'],0,100)); ?></a></td>
							<td><a style="<?php echo 'font-weight:'.$weight; ?>; color:#000;" href="/user?id=<?php echo $messageRow['author_id']; ?>">
							<img width="40px;" src="http://storage.brick-hill.com/images/avatars/<?php echo $senderRow['id'].'.png?c='.$senderRow['avatar_id']; ?>"><?php echo $senderRow['username'] ?></a></td>
							<td style="font-weight: <?php echo $weight; ?> ;"><?php echo $messageRow['date']; ?></td>
							</tr>
							<?php
						}
					?>
					
					
					
				</tbody>
			</table>
			
			<?php
			echo '</div><div class="numButtonsHolder">';
			
			if($count/20 > 1) {
				for($i = 0; $i < ($count/20); $i++)
				{
					echo '<a href="?page='.$i.'">'.($i+1).'</a> ';
				}
			}
			
			echo '</div>';
			?>
		</div>
	</body>
	<?php
		include("../SiT_3/footer.php");
	?>
</html>

