<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
echo "</div>";
		$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
		$getTopic = mysql_query("SELECT * FROM Topics WHERE ID='$ID'");
		$TopicExist = mysql_num_rows($getTopic);
			$Setting = array(
				"PerPage" => 20
			);
			$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
			if ($Page < 1) { $Page=1; }
			if (!is_numeric($Page)) { $Page=1; }
			$Minimum = ($Page - 1) * $Setting["PerPage"];
			//query
			$num = mysql_num_rows($allusers = mysql_query("SELECT * FROM Threads WHERE tid='$ID'"));
			$Num = ($Page+8);
		
			if ($TopicExist == "0") {
			
				echo "<b>This topic doesn't exist!</b>";
				exit;
			
			}
				if ($User) {
				
					echo "<div style='text-align:right;'><a href='NewThread.php?ID=$ID'>New Thread</a></div>";
				
				}
				echo "
					<table width='100%'>
						<tr>
							<td width='500'>
								<b>Title:</b>
							</td>
							<td width='150'>
								<b>Creator:</b>
							</td>
							<td width='150'>
								<b>Last Reply:</b>
							</td>
							<td width='75'>
								<b>Replies:</b>
							</td>
						</tr>
					</table>
				";
				echo "<div style='-webkit-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); -moz-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);'>";
			$getStickies = mysql_query("SELECT * FROM Threads WHERE tid='$ID' AND Type='sticky'");
			$s_counter = 0;
				while ($gS = mysql_fetch_object($getStickies)) {
				$s_counter++;
				if($s_counter%2 == 0)
				{
				$scss = 'background:#F0F0F0;';
				}
				else
				{
				$scss = 'background:#F3F3F3;';
				}
					echo "
					<table width='100%' cellspacing='0' cellpadding='0' style='border-top:0;padding:10px; padding-right:0px; border-collapse:collapse;border-spacing:0;'>
						<tr style='".$scss."height:50px; border:0; padding:0;'>
							<td width='500'>
								<a href='ViewThread.php?ID=".$gS->ID."'><div style='margin-left:10px;color:blue;font-weight:bold;'>$gS->Title</div></a>
							</td>
							<td width='150'>
								";
								$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gS->PosterID'");
								$gP = mysql_fetch_object($getPoster);
								echo "<a href='/User.php?ID=$gP->ID'>$gP->Username</a>";
								echo "
							</td>
							<td width='150'>
								";
								$lastReply = mysql_query("SELECT * FROM Replies WHERE tid='$gS->ID' ORDER BY ID DESC LIMIT 1");
								$lR = mysql_num_rows($lastReply);
								if ($lR == 0) {
								$LastReply = "No One";
								}
								else {
									
									$lR = mysql_fetch_object($lastReply);
								$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$lR->PosterID'");
								$gP = mysql_fetch_object($getPoster);
								
									$LastReply = "<a href='../user.php?ID=$gP->ID'>$gP->Username</a>123";
								
								}
								echo "
								$LastReply
								";
								$lR = mysql_num_rows($lastReply);
								echo "
							</td>
							<td width='75'>
								$lR
							</td>
						</tr>
					</table>
					";
				}
				echo "</div>";
				echo "<div style='width:100%;border-bottom:1px solid #bbb;'></div><br />";
				echo "<div style='-webkit-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); -moz-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75); box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);'>";
			$getThreads = mysql_query("SELECT * FROM Threads WHERE tid='$ID' AND Type='regular' ORDER BY bump DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
				$t_counter = 0;
				while ($gT = mysql_fetch_object($getThreads)) {
				$t_counter++;
					if($t_counter%2 == 0)
					{
					$extracss = 'background:#E6E6E6;';
					}
					else
					{
					$extracss = 'background:#DBDBDB;';
					}
					echo "
					<table id='aBForum' width='100%' cellspacing='0' cellpadding='0' style='border-top:0;padding:10px; padding-right:0px; border-collapse:collapse;border-spacing:0;'>
						<tr style='".$extracss."height:50px; border:0; padding:0;'>
							<td width='500' style='padding-left:10px;'>
								<a href='ViewThread.php?ID=".$gT->ID."'>$gT->Title</a>
							</td>
							<td width='150'>
								";
								$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gT->PosterID'");
								$gP = mysql_fetch_object($getPoster);
								echo "<a href='/User.php?ID=$gP->ID'>$gP->Username</a>";
								echo "
							</td>
							<td width='150'>
								";
								$lastReply = mysql_query("SELECT * FROM Replies WHERE tid='$gT->ID' ORDER BY ID DESC LIMIT 1");
								$lR = mysql_num_rows($lastReply);
								if ($lR == 0) {
								$LastReply = "No One";
								}
								else {
									
									$lR = mysql_fetch_object($lastReply);
								$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$lR->PosterID'");
								$gP = mysql_fetch_object($getPoster);
								
									$LastReply = "<a href='../user.php?ID=$gP->ID'>$gP->Username</a>";
								
								}
								echo "
								$LastReply
								";
								$lastReply1 = mysql_query("SELECT * FROM Replies WHERE tid='$gT->ID' ORDER BY ID DESC");
								$lR = mysql_num_rows($lastReply1);
								if ($lR > 0) {
								$R = mysql_query("SELECT * FROM Replies WHERE tid='$gT->ID' ORDER BY ID DESC LIMIT 1");
								$R = mysql_fetch_object($R);
								}
								echo "
							</td>
							<td width='75'>
								";
								if ($lR == 0) {
								echo "
								$lR
								";
								}
								else {
								echo "
								<a href='../Forum/ViewThread.php?ID=$gT->ID#$R->ID'>$lR</a>
								";
								}
								echo "
							</td>
						</tr>
					</table>
					";
				
				}
				
	echo "</tr></table></div><center>";
$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="ViewTopic.php?ID='.$ID.'&Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="ViewTopic.php?ID='.$ID.'&Page='.($Page+1).'">Next</a>';
}
			
	
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");
?>