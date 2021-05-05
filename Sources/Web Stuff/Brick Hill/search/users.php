<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	echo '<head><title>Users - Brick Hill</title></head>';
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
					$sqlSearch = "SELECT * FROM `beta_users";
					$result = $conn->query($sqlSearch);
					echo '<table width="100%"cellspacing="0"cellpadding="4"border="0"style="background-color:#000;"><tbody>';
					while($searchRow=$result->fetch_assoc()){ 
						$lastonline = strtotime($curDate)-strtotime($searchRow['last_online']);
						echo '<tr class="searchColumn"><td><img style="vertical-align:middle; width:40px;" src="http://storage.brick-hill.com/images/avatars/'?><?php echo $searchRow["id"]; ?><?php echo '.png?c='?><?php echo $searchRow['avatar_id']; ?><?php echo '">';
						echo '<a style="color:black;" href="http://www.brick-hill.com/user?id=' . $searchRow['id'] . '">' . $searchRow['username'] . '</a></td>';
						echo '<td style="text-align:center;"><p>'; if($searchRow['description'] > null) {echo substr(htmlentities($searchRow['description']),0,50) , str_repeat("...",(strlen(htmlentities($searchRow['description'])) >= 50)); } echo'</p></td>';
						if ($lastonline >= 300) {
							$timedif = $lastonline . " seconds";
							if ($lastonline >= 300) {$timedif = (int)gmdate('i',$lastonline) . " minutes";}
							if ($lastonline >= 3600) {$timedif = (int)gmdate('H',$lastonline) . " hours";}
							if ($lastonline >= 86400) {$timedif = (int)gmdate('d',$lastonline) . " days";}
							if ($lastonline >= 2592000) {$timedif = (int)gmdate('m',$lastonline) . " months";}
							if ($lastonline >= 31536000) {$timedif = (int)gmdate('Y',$lastonline) . " years";}
							echo '<td style="text-align:center;"><span style="color:#333; font-weight: bold;">' . $timedif . ' ago</span></td>';}
						else {
							echo '<td style="text-align:center;"><span style="color:#333; font-weight: bold;">Now</span></td>';}
						if ($lastonline <= 300) {echo '<td style="text-align:center;"><i style="color:Green;font-size:15px;" class="fa fa-circle"></i></td>';}
						else {echo '<td style="text-align:center;"><i style="color:#DD0000;font-size:15px;" class="fa fa-circle"></i></td>';}
					}
				echo '</tbody></table>';
				?>
				<span>
					<a href="http://www.brick-hill.com/search/online" style="color: #09bd00;font-size: 12px;float: right;margin-right: 20px;padding-top: 3px;">Online Users</a>
					<a href="http://www.brick-hill.com/search/users" style="color: #000;font-size: 12px;float: right;margin-right: 20px;margin-left:20px;padding-top: 3px;">Users</a>
				</span>
				</dv>
			</div>
		</div>
		<?php 
		include("../SiT_3/footer.php");
		?>
	</body>
</html>