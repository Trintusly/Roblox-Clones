<?php
	
	include "../Header.php";
	
		
		
		$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
		
		if (!$User) {
		header("Location: ../index.php");
		}
		
		if (!$ID) {
		
			die("<b>This group does not exist.</b>");
		
		}
		
			$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='".$ID."'");
			$gG = mysql_fetch_object($getGroup);
			
			$GroupExist = mysql_num_rows($getGroup);
			
			if ($GroupExist == 0) {
			
				die("<b>This group does not exist.</b>");
			
			}
			
			
		
		echo "
		<form action='' method='POST'>
		<table width='98%'>
			<tr>
				<td>
					<div id='ProfileText'>
						<table cellspacing='0' cellpadding='0'>
							<tr>
								<td width='95%'>
									<b>".$gG->Name."</b>
								</td>
								<td width='10%' style='text-align:left;'>
								<div align='right'>
								
								";
								$checkInGroup = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='".$ID."' AND UserID='".$myU->ID."'");
								$InGroup = mysql_num_rows($checkInGroup);
								
									if ($InGroup == 0) {
								echo "
								<input type='submit' id='buttonsmall' value='Join' name='Join'>
								";
								
								$Join = mysql_real_escape_string(strip_tags(stripslashes($_POST['Join'])));
								
								if ($Join) {
								
									$getMe = mysql_query("SELECT * FROM GroupMembers WHERE UserID='$myU->ID'");
									$gM = mysql_num_rows($getMe);
									if ($myU->Premium == "1") {
									$Groups = 100;
									}
									else {
									$Groups = 5;
									}
									if ($gM < $Groups) {
								
									if ($InGroup == 0) {
									
										mysql_query("INSERT INTO GroupMembers (GroupID, UserID) VALUES('$ID','$myU->ID')");
										header("Location: Group.php?ID=$ID");
									
									}
									
									}
									else {
									
										//die, in more than 5 groups
										
										echo "<b>Sorry, but you can only be in 5 groups at once.</b>";
									
									}
								
								}
								
								}
								else {
								if ($myU->ID != $gG->OwnerID) {
								echo "
								<input type='submit' id='buttonsmall' value='Leave' name='Leave'>
								";
								$Leave = mysql_real_escape_string(strip_tags(stripslashes($_POST['Leave'])));
								
								if ($Leave) {
								
									if ($InGroup == 1) {
									
										mysql_query("DELETE FROM GroupMembers WHERE GroupID='$ID' AND UserID='$myU->ID'");
										header("Location: Group.php?ID=$ID");
									
									}
								
								}
								}
								else {
								echo "<input type='submit' id='buttonsmall' value='?' style='visibility:hidden;'>";
								}
								}
								echo "
								
								</div>
								
								</td>
							</tr>
						</table>
					</div>
					<div id=''>
						<table>
							<tr>
								<td valign='top' width='100'>
									<div style='border:1px solid #ddd;width:100px;height:100px;padding:5px;'>
									<img src='../Groups/GL/".$gG->Logo."' height='100' width='100'>
									</div>
									<br />
									<Center><b>Group Owner:</b>
									<br />
										<a href='../user.php?ID=".$gG->OwnerID."'>
										<div style='height:50px;width:100px;overflow-y:hidden;'>
											<img src='../Avatar.php?ID=".$gG->OwnerID."' height='100'>
										</div>
										";
										$getOwner = mysql_query("SELECT * FROM Users WHERE ID='$gG->OwnerID'");
										$gP = mysql_fetch_object($getOwner);
										echo "
										<b>".$gP->Username."</b>
										</a>
								</td>
								<td valign='top' style=''>
								<div style='width:300px;height:100px;font-size:12px;color:#777;background:#f5f5f5;border:1px solid #ccc;padding:5px;max-height:100px;overflow-y:auto;'>
									".nl2br($gG->Description)."
									";
									$Number = mysql_num_rows($getMembers = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='".$ID."' ORDER BY ID DESC"));
									echo "
								</div>
								";
								if ($myU->ID == $gG->OwnerID) {
								
									echo "<br /><input type='submit' name='RedirectToAdmin' value='Edit Group' id='buttonsmall'>";
								
									$RedirectToAdmin = mysql_real_escape_string(strip_tags(stripslashes($_POST['RedirectToAdmin'])));
									if ($RedirectToAdmin) {
									
										header("Location: EditGroup.php?ID=$ID");
									
									}
								echo "<br />";
								}
								if ($InGroup == 1) {
								
								if ($myU->MainGroupID == $ID) {
								echo "
								<div style='padding-top:3px;'></div>
								<input type='submit' name='RemoveMain' value='Remove Main' id='buttonsmall'>
								";
								$RemoveMain = mysql_real_escape_string(strip_tags(stripslashes($_POST['RemoveMain'])));
								if ($RemoveMain) {
								mysql_query("UPDATE Users SET MainGroupID='' WHERE ID='$myU->ID'");
								header("Location: Group.php?ID=$ID");
								}
								}
								else {
								echo "
								<div style='padding-top:3px;'></div>
								<input type='submit' name='MakeMain' value='Make Main' id='buttonsmall'>
								";
								$MakeMain = mysql_real_escape_string(strip_tags(stripslashes($_POST['MakeMain'])));
								if ($MakeMain) {
								mysql_query("UPDATE Users SET MainGroupID='$ID' WHERE ID='$myU->ID'");
								header("Location: Group.php?ID=$ID");
								}
								}
								}
								echo "
								</td>
								<td valign='top' style='padding-left:30px;width:400px;'>
									<div id='ProfileText'>
										Members (".$Number.")
									</div>
									<div id=''>
										";
										
										//get the nmembers
										$Setting = array(
											"PerPage" => 8
										);
										$Page = mysql_real_escape_string(strip_tags(stripslashes($_GET['Page'])));
										if ($Page < 1) { $Page=1; }
										if (!is_numeric($Page)) { $Page=1; }
										$Minimum = ($Page - 1) * $Setting["PerPage"];
										//query
										$num = mysql_num_rows(mysql_query("SELECT * FROM GroupMembers WHERE GroupID='".$ID."' ORDER BY ID DESC"));
										$Num = ($Page+8);
										$getMembers = mysql_query("SELECT * FROM GroupMembers WHERE GroupID='".$ID."' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
										echo "<table><tr>";

										while ($gM = mysql_fetch_object($getMembers)) {
											$counter++;
											$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$gM->UserID."'");
											$gU = mysql_fetch_object($getUser);
											echo "
											<td width='100'>
												<center>
												<a href='../user.php?ID=".$gM->UserID."'>
												<div style='height:50px;width:100px;overflow-y:hidden;'>
													<img src='../Avatar.php?ID=".$gM->UserID."' height='100'>
												</div>
												<b>".$gU->Username."</b>
												</a>
											</td>
											";
											
											if ($counter >= 4) {
											echo "</tr><tr>";
											$counter = 0;
											}
										
										}
										echo "</tr></table><center>";
											$amount=ceil($num / $Setting["PerPage"]);
											if ($Page > 1) {
											echo '<a href="Group.php?ID='.$ID.'&Page='.($Page-1).'">Prev</a> - ';
											}
											echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
											if ($Page < ($amount)) {
											echo ' - <a href="Group.php?ID='.$ID.'&Page='.($Page+1).'">Next</a>';
											}
										echo "
									</div>
									<br />
									<div id='ProfileText'>
										Allies
									</div>
									<div id=''>
										<table><tr>
										";
										$getAllies = mysql_query("SELECT * FROM GroupAllies WHERE GroupID='$ID' AND Status='1'");
											$group_count = 0;
											while ($gA = mysql_fetch_object($getAllies)) {
												$group_count++;
												$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$gA->OtherGroupID'");
												$gGG = mysql_fetch_object($getGroup);
											
												echo "
												<td width='100' valign='top'>
													<center>
													<a href='../Groups/Group.php?ID=".$gGG->ID."'>
													<div style='width:50px;height:50px;border:1px solid #ddd;padding:5px;'>
														<img src='../Groups/GL/".$gGG->Logo."' width='50' height='50'>
													</div>
													<b>$gGG->Name</b>
													</a>
												</td>
												";
												if ($group_count >= 4) {
												
													echo "</tr><tr>";
													$group_count = 0;
												
												}
											
											}
										echo "
										</tr></table>
									</div>
									<br />
									<div id='ProfileText'>
										Enemies
									</div>
									<div id=''>
										<table><tr>
										";
										$getEnemies = mysql_query("SELECT * FROM GroupEnemies WHERE GroupID='$ID'");
											while ($gA = mysql_fetch_object($getEnemies)) {
												$group_count++;
												$getGroup = mysql_query("SELECT * FROM Groups WHERE ID='$gA->OtherGroupID'");
												$gGG = mysql_fetch_object($getGroup);
											
												echo "
												<td width='100' valign='top'>
													<center>
													<a href='../Groups/Group.php?ID=".$gGG->ID."'>
													<div style='width:50px;height:50px;border:1px solid #ddd;padding:5px;'>
														<img src='../Groups/GL/".$gGG->Logo."' width='50' height='50'>
													</div>
													<b>$gGG->Name</b>
													</a>
												</td>
												";
												if ($group_count >= 4) {
												
													echo "</tr><tr>";
													$group_count = 0;
												
												}
											
											}
										echo "
										</tr></table>
									</div>
								</td>
							</tr>
						</table>
					</div>
					";
					
					if ($InGroup == 1) {
					
						echo "
						<br />
						<div id='ProfileText'>
							Comments<a name='comments'></a>
						</div>
							";
							
								$getComments = mysql_query("SELECT * FROM GroupWall WHERE GroupID='".$ID."' ORDER BY ID DESC");
								
								while ($gC = mysql_fetch_object($getComments)) {
								
									echo "
									<table id=''>
											<tr>
												<td valign='top'>
													<center>
													<div style='height:50px;width:100px;overflow-y:hidden;'>
														<img src='../Avatar.php?ID=".$gC->PosterID."' height='100'>
													</div>
													";
													$getPoster = mysql_query("SELECT * FROM Users WHERE ID='$gC->PosterID'");
													$gP = mysql_fetch_object($getPoster);
													echo "
													".$gP->Username."
												</td>
												<td valign='top' style='width:900px;'>
													".$gC->Message."
													";
													if ($myU->ID == $gG->OwnerID) {
													
														echo "
														<br /><br />
														<a href='?ID=$ID&WallAction=Delete&WallID=$gC->ID'><font color='red'><b>Delete</b></font></a>
														";
													
													}
													else {
													
														//echo "no";
													
													}
													echo "
												</td>
											</tr>
									</table>
									<br />
									";
								
								}
								if ($myU->ID == $gG->OwnerID) {
														$WallAction = mysql_real_escape_string(strip_tags(stripslashes($_GET['WallAction']))); 
														$WallID = mysql_real_escape_string(strip_tags(stripslashes($_GET['WallID']))); 
														
														if ($WallAction == "Delete") {
														
															mysql_query("DELETE FROM GroupWall WHERE ID='$WallID'");
															header("Location: Group.php?ID=".$ID."#comments");
														
														}
														
														}
							
							echo "
						";
						
						echo "
						<center>
						<form action='' method='POST'>
							<table>
								<tr>
									<td>
										<textarea name='Message' style='width:950px;height:50px;'></textarea>
										<br />
										<input type='submit' value='Post' name='Submit'>
									</td>
								</tr>
							</table>
						</form>
						";
						$Message = mysql_real_escape_string(strip_tags(stripslashes($_POST['Message'])));
						$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
						
							if ($Submit) {
							
								if (!$Message) {
								
									echo "<b>Please include a post.</b>";
								
								}
								else {
								
									$Message = filter($Message);
									
									$Flood = 15 + time();
									
									$now = time();
									
									if ($now > $myU->CommentFlood) {
									
										mysql_query("UPDATE Users SET CommentFlood='$Flood' WHERE ID='$myU->ID'");
										mysql_query("INSERT INTO GroupWall (GroupID, PosterID, Message) VALUES('".$ID."','".$myU->ID."','".$Message."')");
										header("Location: Group.php?ID=$ID#comments");
									
									}
									
									else {
									
										echo "<b>You are posting too fast.</b>";
									
									}
								}
							
							}
					
					}
					echo "
				</td>
			</tr>
		</table>
		</form>
		";
		
		if ($myU->PowerAdmin == "true" || $myU->PowerMegaModerator == "true") {
		
			echo "
			<div id='cA'>
				<center>
					<a href='?ID=$ID&Scrub=Name'>Scrub Group Name</a> &nbsp; &nbsp; &nbsp; <a href='?ID=$ID&Scrub=Description'>Scrub Group Description</a>
				</center>
			</div>
			";
			$Scrub = mysql_real_escape_string(strip_tags(stripslashes($_GET['Scrub'])));
			
				if ($Scrub == "Name") {
				
					mysql_query("UPDATE Groups SET Name='[ Content Deleted $ID ]' WHERE ID='$ID'");
					header("Location: Group.php?ID=$ID");
				
				}
				if ($Scrub == "Description") {
				
					mysql_query("UPDATE Groups SET Description='[ Content Deleted ]' WHERE ID='$ID'");
					header("Location: Group.php?ID=$ID");
				
				}
		
		}
	
	include "../Footer.php";