<?php 	
	require("adminOnly.php");
    include("../../SiT_3/config.php");
	
    if($power < 1) {header("Location: ../");die(); } 
	$logSQL = "SELECT * FROM `reports` WHERE `seen`='no'";
    $log = $conn->query($logSQL);
?>
<div id="box">
<table width="100%" cellspacing="1" cellpadding="4" border="0" style="background-color:#000;">
			<tbody>
				<tr>
					<th width="16%">
						<p class="title" style="color:#FFF;">User</p>
					</th>
					<th width="36%">
						<p class="title" style="color:#FFF;">URL</p>
					</th>
					<th width="40%">
						<p class="title" style="color:#FFF;">Reason</p>
					</th>
					<th width="8%">
						<p class="title" style="color:#FFF;">Seen</p>
					</th>
				</tr>
			<?php
			while($logRow=$log->fetch_assoc()){ 
				$reporterSQL = "SELECT * FROM `beta_users` WHERE `id`='".$logRow["user_id"]."'";
				$reporter = $conn->query($reporterSQL);
				$reporterRow = $reporter->fetch_assoc();
				
				if($logRow['r_type'] == 'post') {
					$postID = $logRow["r_id"];
					$postSQL = "SELECT * FROM `forum_posts` WHERE `id`='$postID'";
					$post = $conn->query($postSQL);
					$postRow = $post->fetch_assoc();
					$threadID = $postRow['thread_id'];
				} else {$threadID = 0;}
				$URLs = array('post'=>'/forum/thread?id='.$threadID.'#post[]','thread'=>'/forum/thread?id=[]','user'=>'/user?id=[]','game'=>'/play/set?id=[]','clan'=>'/clan?id=[]','item'=>'/shop/item?id=[]','message'=>'/messages/message?id=[]');
			
				echo '<tr class="forumColumn">
				<td>
					<a href="/user/'.$reporterRow["id"].'/">
					<img style="width:30%;" src="http://storage.brick-hill.com/images/avatars/'.$reporterRow["id"].'.png?c='.$reporterRow["avatar_id"].'">
					<br><span style="color:#333;">'.$reporterRow["username"].'</span>
					</a>
				</td>
				<td><a style="color:#333;" href="'.str_replace('[]',$logRow["r_id"],$URLs[$logRow["r_type"]]).'">'.$logRow["r_type"].'</a></td>
				<td>'.$logRow["r_reason"].'</td>
				<td><a class="blue-button" href="index?seen='.$logRow['id'].'">Seen</a></td>
				</tr>';
			}
			?>
			</tbody>
		</table>
		</div>