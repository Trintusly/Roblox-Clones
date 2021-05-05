<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");

	if (!$User) {
	
		header("Location: /index.php");
		exit;
	}
	
		$getTopics = mysql_query("SELECT * FROM Topics ORDER BY ID");
		
			echo "
			<table style='padding:10px;width:100%;padding:10px;background:#ECECEC;-webkit-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); -moz-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);'>
				<tr>
					<td width='850'>
						<b>Topic Name</b>
					</td>
					<td>
						<b>Number of Posts</b>
					</td>
				</tr>
			</table>
			";
		
			while ($gT = mysql_fetch_object($getTopics)) {
			
				echo "
			<table style='width:100%;padding:10px;background:#F3F3F3;-webkit-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); -moz-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);'>
				<tr>
					<td width='850'>
						<a href='/Forum/ViewTopic.php?ID=$gT->ID' style='font-size:13px;'><b>".$gT->TopicName."</b></a>
						<br />
						<font style='font-size:8pt'>".$gT->TopicDescription."</font>
					</td>
					<td style='padding-left:40px;'>
						";
						$Posts = mysql_num_rows($Posts = mysql_query("SELECT * FROM Threads WHERE tid='".$gT->ID."'"));
						echo "
						$Posts
					</td>
				</tr>
				<tr height='20px;'></tr>
			</table>
				";
			
			}
			

include($_SERVER['DOCUMENT_ROOT']."/Footer.php");