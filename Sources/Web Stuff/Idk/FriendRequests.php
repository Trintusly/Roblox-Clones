<?php
include "Header.php";

	echo "
	<table width='98%'>
		<tr>
			<td>
				<div id='LargeText'>
					Friend Requests (".$FriendsPending.")
				</div>
				<div id='' style='text-align:left;'>
				<table><tr>
					";
					
						while ($gF = mysql_fetch_object($getFriendR)) {
						
							echo "<td width='125' align='center'>";
							echo "<img src='https://brickplanet.gq/Avatar.php?ID=$gF->SenderID'>";
							
								$getSender = mysql_query("SELECT * FROM Users WHERE ID='".$gF->SenderID."'");
								$gS = mysql_fetch_object($getSender);
							
							echo "<br />";
							
							echo "
							".$gS->Username."
							<br />
							<br />
							<a href='?Action=Accept&ID=".$gF->SenderID."'>Accept</a> - <a href='?Action=Deny&ID=".$gF->SenderID."'>Deny</a>
							";
							
							echo "</td>";
						
						}
						
						$Action = mysql_real_escape_string(strip_tags(stripslashes($_GET['Action'])));
						$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
						
							if ($Action == "Accept" && $ID) {
							
								$getRequest = mysql_query("SELECT * FROM FRs WHERE ReceiveID='".$myU->ID."' AND SenderID='".$ID."'");
								$exist = mysql_num_rows($getRequest);
								$gR = mysql_fetch_object($getRequest);
								
									if ($exist == 1) {
									
										if ($gR->Active == "0") {
										
											//accept
											
											mysql_query("UPDATE FRs SET Active='1' WHERE ReceiveID='".$myU->ID."' AND SenderID='".$ID."'");
											
											mysql_query("INSERT INTO FRs (SenderID, ReceiveID, Active) VALUES ('".$myU->ID."','".$gR->SenderID."','1')");
											
											//pm
											
											mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time) VALUES('1','".$gR->SenderID."','Friend Request Accepted','".$myU->Username." has accepted your friend request!','".time()."')");
											
											//redirect
											
											header("Location: https://brickplanet.gq/FriendRequests.php");
										
										}
										else {
										
											echo "You are already friends.";
										
										}
									
									}
									else {
									
										echo "error";
									
									}
									
							
							}
							
							if ($Action == "Deny" && $ID) {
							
								$getRequest = mysql_query("SELECT * FROM FRs WHERE ReceiveID='".$myU->ID."' AND SenderID='".$ID."'");
								$exist = mysql_num_rows($getRequest);
								$gR = mysql_fetch_object($getRequest);
								
									if ($exist == 1) {
									
										if ($gR->Active == "0") {
										
											//delete
											
											mysql_query("DELETE FROM FRs WHERE ReceiveID='".$myU->ID."' AND SenderID='".$ID."'");
											
											//pm
											
											mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time) VALUES('1','".$gR->SenderID."','Friend Request Declined','".$myU->Username." has denied your friend request!','".time()."')");
											
											//redirect
											
											header("Location: https://brickplanet.gq/FriendRequests.php");
										
										}
										else {
										
											echo "You are already friends.";
										
										}
									
									}
									else {
									
										echo "error";
									
									}
							
							}
					
					echo "
					</tr></table>
				</div>
			</td>
		</tr>
	</table>
	";

include "Footer.php";