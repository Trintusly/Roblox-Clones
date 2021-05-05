<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");

	
		$getTopics = mysql_query("SELECT * FROM Topics ORDER BY ID");
                        echo "<br><br>";
		        echo "<script>$('div[align=\"left\"]').css('display', 'table')</script>";
			echo "
			<table style='padding:10px;width:100%;padding:10px;background:#4d90ea;color:#fff'>
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
			<table style='width:100%;padding:10px;background:#fff;border-bottom:1px solid #eee;'>
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