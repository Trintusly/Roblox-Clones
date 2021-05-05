<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(!$loggedIn) {header('Location: ../'); die();}
	
	$userID = $userRow->{'id'};
?>
<!DOCTYPE>
<html>

	<head>
		<title>Friends - Brick Hill</title>
	</head>
	
	<body>
		<div id="body">
			<div id="box">
				<div id="friendsPending">
				<?php 
					// Get Pending Friend Requests
					$requests = mysqli_query($conn, "SELECT * FROM `friends` WHERE `to_id`='$userID' AND `status`='pending' ORDER BY `id` DESC");
					$requestsCount = mysqli_num_rows($requests);
					
					echo '<h3>Friend Requests ('.$requestsCount.')</h3>';
					echo '<div id="subsect">';
					if (mysqli_num_rows($requests) > 0) {
    					// output data of each row
    					while($requestsData = mysqli_fetch_assoc($requests)) {
    						// Get other user details
    						$otherUserDetails = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$requestsData[from_id]'");
    						$otherUser = mysqli_fetch_array($otherUserDetails);

        					echo "
        					<div style='margin:10px;'>
        						<div style='padding:2px;float: left;'>
        							<img src='http://storage.brick-hill.com/images/avatars/$otherUser[id].png?c=".$otherUser['avatar_id']."' width='130px'><br>
        							<a style='color:black;text-decoration:none;' href='/user?id=$otherUser[id]'>$otherUser[username]</a>
        						<form action='add' method='post' style='margin:0px'>
        							<input type='hidden' name='accept'>
        							<input type='hidden' name='OtherUserId' value='$otherUser[id]'>
        							<button style='float:left;margin-right:3px;'>Accept</button>
        						</form>
        						
        						<form action='add' method='post' style='margin:0px'>
        							<input type='hidden' name='decline'> 
        							<input type='hidden' name='OtherUserId' value='$otherUser[id]'>
        							<button style='float:left;'>Decline </button>
        						</form>
        						</div>
        					</div>";
    						}
					} else {
    					echo "<h5>You have no pending friend requests<h5>";
					}
				
					$friendsList = mysqli_query($conn, "SELECT * FROM `friends` WHERE  `to_id` = '$userID' AND `status`='accepted' OR `from_id` = '$userID' AND `status`='accepted' ORDER BY `id` DESC");
					$friendCount = mysqli_num_rows($friendsList);
					
					echo '</div></div><div id="friends">
					<h3>Friends ('.$friendCount.')</h3>
					<div id="subsect">';
					
					if (mysqli_num_rows($friendsList) > 0) {
	    					while($friendsListRow = mysqli_fetch_assoc($friendsList)) {
							$friendRowQ = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE (`id`='$friendsListRow[from_id]' OR `id`='$friendsListRow[to_id]') AND `id`!='$userID'");
	    						$friendRow = mysqli_fetch_array($friendRowQ);
	    						
		    					echo "
		    						<div style='margin:10px;'>
		        						<div style='padding:2px;float: left;'>
		        							<img src='http://storage.brick-hill.com/images/avatars/$friendRow[id].png?c=".$friendRow['avatar_id']."' width='130px'><br>
		        							<a style='color:black;text-decoration:none;' href='/user?id=$friendRow[id]'>$friendRow[username]</a>
		        						</div>
		        				</div>";
						}
					} else {
						echo "<h5>You have no friends<h5>";
					}
					echo "</div>";
					?>
			</div>
		</div>
		</div>
		<?php 
		include("../SiT_3/footer.php");
		?>
	</body>
	
</html>