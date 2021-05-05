<?php
include('../SiT_3/config.php');
include('../SiT_3/header.php');
include('../SiT_3/PHP/helper.php');
 
 if($userRow->{'power'} < 4) {
	 header('Location: /');
	 die();
 }
 
?>
<!DOCTYPE html>
<html>

	<head>
	</head>
	
	<body>
		<div id="body">
			<div id="box" style="box-sizing: border-box;padding:5px;">
			<?php 
			
			if (isset($_POST['genKey'])) {
				
				function genKey() {
					return rand(1,9) . rand(10000,99999) . range(1,9);
				}
				
				$key = substr(hash('sha256', genKey()), 0, 10);
				
				$createKeySQL = "INSERT INTO `reg_keys` (`id`,`key_content`,`used`) VALUES (NULL, '$key', '0') ";
				$createKey = $conn->query($createKeySQL);
				
				if($createKey) {
				
				?>
				Key ID: <b><?php echo $conn->insert_id; ?></b>
				<br>
				Key: <b><?php echo $key; ?></b>
				<br>
				Card:<br>
				<div style="text-align:center;">
					<img src="card_night.php?key=<?php echo $key; ?>" />
					<img src="card_winter.php?key=<?php echo $key; ?>" />
					<br>
					<img src="card_grass.php?key=<?php echo $key; ?>" />
				</div>
				</div>
				<?php
				die();
				} else {
					die('error');
				}
			}
			
			?>
				<div> 
				<form action="" method="POST">
				<input type="submit" style="width:50%;margin:auto;display:block;text-align:center;" name="genKey" value="Generate New Key">
				</form>
				</div>
				<div>
					<div>
						<b>
							Active Keys
						</b>
					</div>
						<?php 
						
						$findActiveKeysSQL = "SELECT * FROM `reg_keys` WHERE `used` = '0'";
						$findActiveKeys = $conn->query($findActiveKeysSQL);
						
						if ($findActiveKeys->num_rows > 0) {
							while ($keyRow = $findActiveKeys->fetch_assoc()) {
								$keyRow = (object) $keyRow;
								?>
								<div style="width:73%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'key_content'} ; ?>
								</div>
								<div style="width:23%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'id'} ; ?>
								</div>
								<?php
							}
						} else {
							?>
							<div style="color:grey;text-align:center;">
								There are no active keys!
							</div>
							<?php
						}
						
						?>
					
				</div>
				<div>
					<div>
						<b>
							Used Keys
						</b>
					</div>
						<?php 
						
						$findActiveKeysSQL = "SELECT * FROM `reg_keys` WHERE `used` = '1'";
						$findActiveKeys = $conn->query($findActiveKeysSQL);
						
						if ($findActiveKeys->num_rows > 0) {
							?>
							<div style="width:73%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<b> Key </b>
							</div>
							<div style="width:23%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<b> ID </b>
							</div>
							<?php
							while ($keyRow = $findActiveKeys->fetch_assoc()) {
								$keyRow = (object) $keyRow;
								?>
								<div style="width:73%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'key_content'} ; ?>
								</div>
								<div style="width:23%;margin-left:1%;margin-right:1%;float:left;text-align:center;">
								<?php echo $keyRow->{'id'} ; ?>
								</div>
								<?php
							}
						} else {
							?>
							<div style="color:grey;text-align:center;">
								There are no used keys!
							</div>
							<?php
						}
						
						?>
					
				</div>
			</div>
		<?php 
		include("../SiT_3/footer.php");
		?>
	</body>
	
</html>