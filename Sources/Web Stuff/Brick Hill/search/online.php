<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if (isset($_GET['search'])) {
		echo '<head><title>\'' . $_GET['search'] . '\' Search - Brick Hill</title></head>';}
	else {
		echo '<head><title>Search - Brick Hill</title></head>';}
?>

<!DOCTYPE html>
	<body>
		<div id="body">
			<div id="box" style="text-align:center;">
				<div id="subsect">
					<form action="index" method="GET" style="margin:15px;">
						<input style="width:500px; height:20px;" type="text" name="search" placeholder="I'm looking for...">
						<input style="height:24px;" type="submit" value="Submit">
					</form>
				</div>
				<?php
					if(isset($_GET['search'])) {$query = mysqli_real_escape_string($conn,strtolower($_GET['search']));} else {$query = '';}
					
					$sqlSearch = "SELECT * FROM `beta_users` WHERE  `usernameL` LIKE '%$query%'";
					$result = $conn->query($sqlSearch);
					echo '<table width="100%"cellspacing="0"cellpadding="4"border="0"style="background-color:#000;"><tbody>';
					while($searchRow=$result->fetch_assoc()){ 
						$lastonline = strtotime($curDate)-strtotime($searchRow['last_online']);
						if ($lastonline <= 300) {
						echo '<tr class="searchColumn"><td><img style="vertical-align:middle; width:40px;" src="http://storage.brick-hill.com/images/avatars/'?><?php echo $searchRow["id"];
						echo '.png?c=';
						echo $searchRow['avatar_id']; 
						echo '">';
						echo '<a style="color:black;" href="http://www.brick-hill.com/user?id=' . $searchRow['id'] . '">' . $searchRow['username'] . '</a></td>';
						echo '<td style="text-align:center;"><p>'; if($searchRow['description'] > null) {echo substr(htmlentities($searchRow['description']),0,75) , str_repeat("...",(strlen($searchRow['description']) >= 75)); }
						echo'</p></td>';
						//echo '<span style="padding-left:15px; color:#333; font-size:12px; font-weight: bold;">Online Now</span>';
						if ($lastonline <= 300) {echo '</tbody>';}
						else {echo '</tbody>';}
					}
				}echo '</table>';
				?>
				<span>
					<a href="http://www.brick-hill.com/search/online" style="color: #09bd00;font-size: 12px;float: right;margin-right: 20px;padding-top: 3px;">Online Users</a>
					<a href="http://www.brick-hill.com/search/users" style="color: #000;font-size: 12px;float: right;margin-right: 20px;margin-left:20px;padding-top: 3px;">Users</a>
				</div>
				</span>
			</div>
		</div>
		<?php 
		include("../SiT_3/footer.php");
		?>
	</body>
</html>