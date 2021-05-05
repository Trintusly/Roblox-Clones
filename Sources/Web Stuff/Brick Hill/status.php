<?php 
	include('SiT_3/config.php');
	include('SiT_3/header.php');

	if (isset($_GET['id'])) {
		$id = mysqli_real_escape_string($conn,$_GET['id']);
	} else {
		header("location: ../");
	}
	
	$statusReq = mysqli_query($conn,"SELECT * FROM `statuses` WHERE `id`='$id'");
	$statusReqData = mysqli_fetch_assoc($statusReq);
	$currStatusBody = $statusReqData['body'];
	$currStatusOwnerID = $statusReqData['owner_id'];
	
	$ownerReq = mysqli_query($conn,"SELECT * FROM `beta_users` WHERE `id`='$currStatusOwnerID'");
	$ownerReqData = mysqli_fetch_assoc($ownerReq);
	$currStatusOwner = $ownerReqData['username'];
	
	if (isset($_GET['scrub']) && $power >= 1) {
		$scrubSQL = "UPDATE `statuses` SET `body`='[Content Removed]' WHERE `id` ='$id'";
		$scrub = $conn->query($scrubSQL);
	}
?>
<!DOCTYPE html>
	<head>
		<title>Status - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box" style="padding:10px;">
				<?php
					if (empty($currStatusBody)) {echo "Status does not exist!";}
					else {echo $currStatusBody;
						echo '<p style="font-size:12px;color:#000;margin:2px 0px 0px 0px;" href="">'.$statusReqData['date']."</p>";
						echo '<a style="font-size:12px;color:#000;" href="/user?id='.$currStatusOwnerID.'">'.$currStatusOwner."</a>";
						if($power >= 1) {
							echo '<div><a class="label" href="status?id='.$id.'&scrub">Scrub</a></div>';
						}
					}
				?>
			</div>
		</div>
	</body>
</html>