<?php

session_name("BRICK-SESSION");
session_start();
include('SiT_3/config.php');

$currentID = $_SESSION['id'];

$bannedSQL = "SELECT * FROM `moderation` WHERE `active`='yes' AND `user_id`='$currentID'";
	$banned = $conn->query($bannedSQL);
	if($banned->num_rows != 0) {
		$bannedRow = $banned->fetch_assoc();
		$banID = $bannedRow['id'];
		$currentDate = strtotime($curDate);
		$banEnd = strtotime($bannedRow['issued'])+($bannedRow['length']*60);
		
		
	

?>
<html>
	<head>
		<link rel="stylesheet" href="/style.css" type="text/css">
		<title>Banned - Brick Hill</title>
	</head>
			<body>
				<div id="body">
					<div id="box">
						<h3>
						<?php echo$bannedRow['length']; ?> minutes
						</h3>
						<div style="margin:10px">
							Reviewed: <?php echo gmdate('m/d/Y',strtotime($bannedRow['issued'])); ?> <br>
							Moderator Note:<br>
							<div style="border:1px solid;width:400px;height:150px;background-color:#F9FBFF">
								<?php echo  $bannedRow['admin_note']; ?>
							</div>
		<?php 
		if($currentDate >= $banEnd) {
			if(isset($_POST['unban'])) {
				$unbanSQL = "UPDATE `moderation` SET `active`='no' WHERE `id`='$banID'";
				$unban = $conn->query($unbanSQL);
				header("Refresh:0");
			}
			?>You can now reactivate your account<br>
			<form action="" method="POST">
				<input type="submit" name="unban" value="Reactivate my account">
			</form>
			<?php
		} else {
			echo 'Your account will be unbanned on ' . date('d-m-Y H:i:s',$banEnd);
		}?>
						</div>
					</div>
				</div>
	<?php 
	}
	?>

	</body>
</html>