<?php
	include("../SiT_3/config.php");
	include("../SiT_3/header.php");
	
	if(isset($_GET['page'])) {$page = mysqli_real_escape_string($conn,intval($_GET['page']));} else {$page = 0;}
	$page = max($page,1);
?>
<!DOCTYPE html>
	<head>
		<title>Clans - Brick Hill</title>
	</head>
	<body>
		<div id="body">
			<div id="box" style="text-align:center;">
				<div id="subsect">
					<form action="" method="GET" style="margin:15px;">
						<input style="width:500px; height:20px;" type="text" name="search" placeholder="I'm looking for...">
						<input style="height:24px;" type="submit" value="Submit">
						<?php
						if($loggedIn) {
							echo '<a href="/clans/create" style="font-size:12px;background-color: #03c303;padding:4px 5px 4px 5px;text-decoration:none;" class="button-style">Create Clan</a>';
						}
						?>
					</form>
				</div>
				
				<?php
				if (isset($_GET['search'])) {
					$query = mysqli_real_escape_string($conn,$_GET['search']);
				} else {
					$query = '';
				}
				
					$sqlCount = "SELECT * FROM `clans` WHERE  `name` LIKE '%$query%' ORDER BY `members`";
					$countQ = $conn->query($sqlCount);
					$count = $countQ->num_rows;
					
					$page = min($page,max((round)($count/10),1));
	
					$limit = ($page-1)*10;
					
					$sqlSearch = "SELECT * FROM `clans` WHERE  `name` LIKE '%$query%' ORDER BY `members` DESC LIMIT $limit,10";
					$result = $conn->query($sqlSearch);
					
					while($searchRow=$result->fetch_assoc()){ 
						$group_id = $searchRow['id'];
						$memCount = $searchRow['members'];
						
						
						if ($searchRow['approved'] == 'yes') {$thumbnail = $searchRow['id'];}
						elseif ($searchRow['approved'] == 'declined') {$thumbnail = 'declined';}
						else {$thumbnail = 'pending';}
					
						echo '<div id="subsect" style="overflow:auto;">';
						echo '<div style="width:20%;text-align:center;float:left;"><img style="vertical-align:middle; width:100px; height:100px; margin: 0px 10px 10px 0px;" src="http://storage.brick-hill.com/images/clans/'.$thumbnail.'.png"></div>';
						echo '<div style="width:20%;text-align:center;float:left;"><a style="color:black;" href="http://www.brick-hill.com/clan?id=' . $group_id . '">' . $searchRow['name'] . '</a></div>';
						echo '<div style="width:45%;text-align:center;float:left;"><span style="padding-left:15px; color:#333; font-size:12px;">' . substr(htmlentities($searchRow['description']),0,100) . str_repeat("...",(strlen(htmlentities($searchRow['description'])) >= 100)) .'</span></div>';
						echo '<div style="width:15%;text-align:center;float:left;"><span style="padding-left:15px; color:#333; font-size:12px; font-weight: bold;">Members: ' . $memCount . '</span></div></div>';
						}
					/*} else {
						$topGroupsSQL = "SELECT * FROM `clans` ORDER BY `members` LIMIT 10";
						$topGroups = $conn->query($topGroupsSQL);
						while ($groupRow = $topGroups->fetch_assoc()) {
							$gID = $groupRow['id'];
						?>
						<div id="subsect">
						<img style="vertical-align:middle; width:100px; margin: 0px 10px 10px 0px;" src="http://storage.brick-hill.com/images/clans/<?php echo $gID; ?>.png">
						<a style="color:black;" href="http://www.brick-hill.com/clan?id=<?php echo $gID; ?>"> <?php echo $groupRow['name']; ?></a>
						<span style="padding-left:15px; color:#333; font-size:12px;"><?php echo substr($groupRow['description'],0,100) . str_repeat("...",(strlen($groupRow['description']) >= 100)); echo "</div>"; ?></span>
						<?php
						}
					}*/
				?>
				
				<?php
					echo '<div class="numButtonsHolder" style="margin-left:auto;margin-right:auto;margin-top:10px;">';
					if($page-2 > 0) {
					    echo '<a style="color:#333;" href="?search='.$query.'&page=0">1</a> ... ';
					}
					if($count/10 > 1) {
				          for($i = max($page-2,0); $i < min($count/10,$page+2); $i++)
				          {
				            echo '<a style="color:#333;" href="?search='.$query.'&page='.($i+1).'">'.($i+1).'</a> ';
				          }
				        }
				        if($count/10 > 4) {
				            echo '... <a style="color:#333;" href="?search='.$query.'&page='.(int)($count/10).'">'.(int)($count/10).'</a> ';
				        }
					
					echo '</div>';
				?>
			</div>
		</div>
	</body>
	<?php 
	include("../SiT_3/footer.php");
	?>
</html>