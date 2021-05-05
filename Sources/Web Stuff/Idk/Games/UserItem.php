<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
	intval(mysql_real_escape_string($ID = $_GET['ID']));
	$getItem = mysql_query("SELECT * FROM UserStore WHERE ID='".$ID."' AND itemDeleted='0'");
	$gI = mysql_fetch_object($getItem);
	$numgI = mysql_num_rows($getItem);
	
	if ($numgI == 0) {
	
		echo "Item not found.";
		die;
	
	}
	$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gI->CreatorID."'");
	$gC = mysql_fetch_object($getCreator);
	$getSold = mysql_query("SELECT * FROM Inventory WHERE ItemID='".$ID."' AND File='".$gI->File."' AND Type='".$gI->Type."'");
	$gsold = mysql_num_rows($getSold);
	if ($gI->itemDeleted == "1") {
	echo "<b>This item has been deleted!</b>";
	}
		$checkOwn = mysql_query("SELECT * FROM Inventory WHERE UserID='$gI->CreatorID' AND ItemID='$ID'");
		$cO = mysql_num_rows($checkOwn);
		
			if ($cO == 0) {
			
					$code1 = sha1($gI->File);
					$code2 = sha1($myU->ID);
			
					mysql_query("INSERT INTO Inventory (UserID, ItemID, File, Type, code1, code2, SerialNum)
					VALUES ('".$gI->CreatorID."','".$ID."','".$gI->File."','".$gI->Type."','".$code1."','".$code2."','".$Output."')");
			
			}
	echo "
	<form action='' method='POST'>
	<table width='95%'>
		<tr>
			<td>
				<div id='ProfileText'>
					".$gI->Name."
				</div>
					<table width='100%'>
						<tr>
							<td align='center' width='100' valign='top'>
								<b>Item:</b>
								<div style='border: 1px solid #bbb;border-radius:5px;width:100px;height:200px;'>
									<img src='Dir/".$gI->File."' width='100' height='200'>
								</div>
							</td>
							<td width='500' valign='top'>
								<table>
									<tr>
										<td valign='top'><a href='/user.php?ID=".$gI->CreatorID."' border='0' style='color:black;'>
											<center><b>Creator:</b>
											";
											echo "<img src='/Avatar.php?ID=$gI->CreatorID'><br />";
											echo "
											<b>".$gC->Username."</b>
											</a>
										</td>
										<td align='left' valign='top'>
											<font color='green'><b>Bux: $".$gI->Price."</b></font> &nbsp; &nbsp; "; if ($gI->sell == "yes") { if ($Status->ItemStatus == 0) { echo "<input type='submit' id='buttonsmall' value='Buy' name='Buy'></form>"; } else { echo "<font color='red'>Sorry, we are not allowing purchases at this time. Please try again later.</font>"; } } 
											
											if ($gI->saletype == "limited") {
											
											echo "
											<br />
											<font color='red'><b>".$gI->numberstock." out of ".$gI->numbersales." remaining</B></FONT>
											";
											}
											else {
											echo "
											<br />
											<font color='purple'><b>".$gsold." copies sold</b></font>
											";
											}
											echo "
											<br />
											<br />
											<b>Description:</b>
											<br />
											<div style='border: 1px solid gray;border-radius:5px;padding:3px;width:300px;background:white;font-size:10pt;padding-top:5px;padding-bottom:5px;max-height:70px;overflow-y:auto;height:100px;'>
												".nl2br($gI->Description)."
											</div>
										</td>
										<td valign='top' align='left' width='300'>
											";
											if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerImageModerator == "true"||$gI->CreatorID == $myU->ID) {
											echo "
											<br />
											<div id='ProfileText'>
											Actions
											</div>
											<a href='UserConfigureItem.php?ID=".$ID."' style='color:black;'><b>Configure Item</b></a>
											";
											}
											echo "
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
			</td>
		</tr>
	</table>
	<br />
	<br />
	<table width='60%'>
		<tr>
			<td>
				<div id='ProfileText'><a name='Comments'></a>
					Comments
				</div>
					";
						
						$getComments = mysql_query("SELECT * FROM UserItemComments WHERE ItemID='".$ID."' ORDER BY time DESC");
						
						$counter = 0;
						
						while ($gC = mysql_fetch_object($getComments)) {
						
							$counter++;

							if ($counter%2===0){ 
							$class = "#eee"; 
							}else{ 
							$class = "#eee"; 
							}
						
							$getPoster = mysql_query("SELECT * FROM Users WHERE ID='".$gC->UserID."'");
							$gP = mysql_fetch_object($getPoster);
						
							echo "
							<table width='95%'>
								<tr>
									<td width='150' align='center'><a href='/user.php?ID=".$gP->ID."' border='0'><b>
										";
									$height = 100;
								$width = 100;
								echo "
						<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(/Dir/" . $gP->Background . ");'>
						<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Body . ");'>
							<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Eyes . ");'> 
								<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Mouth . ");'>
									<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Hair . ");'>
										<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Bottom . ");'>
											<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Top . ");'>
												<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Hat . ");'>
													<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Shoes . ");'>
														<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(Dir/" . $gP->Accessory . ");'>

														";
														if (time() < $gO->expireTime) {
														echo "<div style='width: ".$width."px; height: ".$height."px; z-index: 3;  background-image: url(/Imagess/OnlineWatermark.png);'>";
														}
														if (time() < $gO->expireTime) {
														echo "</div>";
														}
														echo "
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					";
										echo $gP->Username;
										echo "
										</b>
										</a>
									</td>
									<td valign='top'><div align='left'>
										".nl2br($gC->Post)."
										";
										if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true") {
										
											echo "
											<br /><br />
											<a href='UserItem.php?ID=$ID&CommentMethod=Scrub&CommentID=$gC->ID' style='color:blue;font-weight:bold'>Scrub</a> | <a href='UserItem.php?ID=$ID&CommentMethod=Delete&CommentID=$gC->ID' style='color:blue;font-weight:bold'>Delete</a>
											";
										
										}
										echo "
									</td>
								</tr>
							</table>
							<br />
							";
						
						}
											$CommentMethod = mysql_real_escape_string(strip_tags(stripslashes($_GET['CommentMethod'])));
											$CommentID = mysql_real_escape_string(strip_tags(stripslashes($_GET['CommentID'])));
											
											if ($CommentMethod == "Scrub") {
											
												mysql_query("UPDATE UserItemComments SET Post='[ Content Deleted ]' WHERE ID='".$CommentID."'");
												header("Location: UserItem.php?ID=$ID#Comments");
											
											}
											if ($CommentMethod == "Delete") {
											
												mysql_query("DELETE FROM UserItemComments WHERE ID='".$CommentID."'");
												header("Location: UserItem.php?ID=$ID#Comments");
										}	
					if ($User) {					
					echo "
					<form action='#comments' method='POST'>
						<textarea name='Reply' rows='5' style='width:90%;' placeholder='i.e This item is so cool!!!'></textarea>
						<br />
						<input type='submit' name='SubmitReply' value='Reply' />
					</form>
				";
						//replies ok
						
						$Reply = mysql_real_escape_string(strip_tags(stripslashes($_POST['Reply'])));
						$SubmitReply = mysql_real_escape_string(strip_tags(stripslashes($_POST['SubmitReply'])));
						
							if ($SubmitReply) {
							
								if (!$Reply) {
								
									echo "<font color='red'>ERROR: Please provide a reply!</font>";
								
								}
								elseif (strlen($Reply) > 250) {
								
									echo "<font color='red'>ERROR: Please keep your reply below 250 characters!</font>";
								
								}
								elseif (strlen($Reply) < 3) {
								
									echo "<font color='red'>ERROR: Please keep your reply above 2 characters!</font>";
								
								}
								if (time() >= $myU->comment_flood) {
								
									//go ahead and update the flood.
									
									$comment_flood = time() + 12;
									
									mysql_query("UPDATE Members SET comment_flood='".$comment_flood."' WHERE ID='".$myU->ID."'");
									
									//now that we've got that taken care of, let's finally insert the comment
									
									//filter
									
									$Reply = filter($Reply);
									
									mysql_query("INSERT INTO UserItemComments (UserID, ItemID, Post, time) VALUES ('".$myU->ID."','".$ID."','".$Reply."','".time()."')");
									
									//ok now redirect the client
									header("Location: UserItem.php?ID=".$ID."");
								
								}
								else {
								
									echo "Please wait ".time() - $myU->comment_flood." seconds before posting again!";
								
								}
							
							}
							}
					
					echo "
				</div>
			</td>
		</tr>
	</table>
	";
	
		$Buy = mysql_real_escape_string(strip_tags(stripslashes($_POST['Buy'])));
		
			if ($Buy && $gI->sell == "yes") {
			
				$Price = $gI->Price;
				
				if ($myU->Bux >= $Price) {
				
				
					if ($gI->saletype == "limited"&&$gI->numberstock == "0") {
					
							echo "
								<div style='background-image:url(/Images/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'>
									<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
									<div style='background:#ccc;border:1px solid gray;width:500px;padding:8px;text-align:left;'>
										This item is sold out.
										<br />
										<br />
										<a href='UserItem.php?ID=".$ID."' style='color:black;font-weight:bold;'>Return</a>
									</div>
								</div>
							";
					
					}
					else {
					
						$tryGet = mysql_query("SELECT * FROM Inventory WHERE UserID='".$myU->ID."' AND ItemID='".$ID."' AND File='$gI->File'");
						$tG = mysql_num_rows($tryGet);
						
						if ($tG >= 1) {
						
							echo "
								<div style='background-image:url(/Images/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'>
									<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
									<div style='background:#ccc;border:1px solid gray;width:500px;padding:8px;text-align:left;'>
										You own this item.
										<br />
										<br />
										<a href='UserItem.php?ID=".$ID."' style='color:black;font-weight:bold;'>Return</a>
									</div>
								</div>
							";
						
						}
						elseif ($tG == "0") {
						
							if ($gI->saletype == "limited" && $gI->numberstock != "0") {
							
								mysql_query("UPDATE Items SET numberstock=numberstock - 1 WHERE ID='".$ID."'");
							
							}
							
							$code1 = sha1($gI->File);
							$code2 = sha1($myU->ID);
							
							//take away bux
							
							mysql_query("UPDATE Users SET Bux=Bux - ".$Price." WHERE ID='".$myU->ID."'");
						
							
							//insert into inventory
							
							mysql_query("INSERT INTO Inventory (UserID, ItemID, File, Type, code1, code2)
							VALUES ('".$myU->ID."','".$ID."','".$gI->File."','".$gI->Type."','".$code1."','".$code2."')");
							
							//now give the money to the seller
							
							mysql_query("UPDATE Users SET Bux=Bux + ".$Price." WHERE ID='".$gI->CreatorID."'");
							
							mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','purchased ".$gI->Name." for ".$Price."','".$_SERVER['PHP_SELF']."')");
							
																mysql_query("INSERT INTO PurchaseLog (UserID, Item, Action, TypeStore, ItemType, SellerID, Price, time) VALUES('$myU->ID','$gI->Name','userstore_purchase','User Shop','regular','$myU->Username','$Price','".time()."')");
							
							
							header("Location: /character.php");
						
						}
					
					}
				
				}
			
			}
			
					if($myU->Rank >= 2)
					{
					
						
						$DeleteItem = mysql_real_escape_string(strip_tags(stripslashes($_POST['DeleteItem'])));
						if($DeleteItem)
						{
						
							mysql_query("DELETE FROM Inventory WHERE ItemName='".$gI->Name."'");
							mysql_query("DELETE FROM Items WHERE ID='$ID'");
							$Type = $gI->Type;
							$FileName = $gI->File;
							mysql_query("update Users set $Type='' where $Type='$FileName'");
							header("Location: UserStore.php");
						
						}
					
					}

include($_SERVER['DOCUMENT_ROOT']."/Footer.php");