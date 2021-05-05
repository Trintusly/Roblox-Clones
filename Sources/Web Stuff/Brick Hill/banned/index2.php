<?php

session_name("BRICK-SESSION");
session_start();
include('../SiT_3/config.php');

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
		<style>
			.lava-holder {
				width: 50%; 
				margin: auto;
				box-shadow: 0px 10px 20px rgba(0,0,0,0.5);
			}
			.lava-box {
				color: #fff;
				background-color: #3D120A;
				padding-top: 10px;
			}
			.lava-top {
				box-sizing: border-box;
				width: 100%;
				padding-top: 47px;
				background-image: url('lava-top.png');
				background-repeat: repeat-x;
			}
		</style>
		<link rel="stylesheet" href="/style.css" type="text/css">
		<title>Banned - Brick Hill</title>
	</head>
		<body>
			<div id="body">
				<div class="lava-holder pixel-font">
					<div class="lava-top"></div>
					<div class="lava-box">
						<div class="large-txt pixel-font center-text">
							Banned
						</div>
						<div class="pixel-font center-text">
							<?php echo $bannedRow['length']; ?> minutes
						</div>
						<div style="margin:10px" class="pixel-font center-text">
							Reviewed: <?php echo gmdate('m/d/Y',strtotime($bannedRow['issued'])); ?>
							<div style="margin-top:10px;margin-bottom: 5px;font-size: 1.3rem;" class="pixel-font">
								Moderator Note
							</div>
						<div style="margin:auto;box-shadow: 0px 0px 16px 0px #AD351D; width:400px;height:150px;background-color:#AD351D;padding: 2px;text-align:left;" class="pixel-font">
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
								?>
								<div style="padding: 10px;" class="pixel-font">
									(Release: <?php echo date('m/d/Y h:i:s A',$banEnd); ?>)
								</div>
								<?php
							}?>
						</div>
					</div>
				</div>
	<?php 
	}
	?>
	</div>

	</body>
</html>