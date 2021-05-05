<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
	$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
	$getItem = mysql_query("SELECT * FROM Items WHERE ID='".$ID."' AND itemDeleted='0'");
	$gI = mysql_fetch_object($getItem);
	$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gI->CreatorID."'");
	$gC = mysql_fetch_object($getCreator);
	
		if (!$User) {
		
			header("Location: /index.php");
		
		}
		$Exist = mysql_num_rows($getItem);
		if ($Exist == "0") {
		echo "<b>This item does not exist.</b>";
		}
		else {
	

	$tryGet = mysql_query("SELECT * FROM Inventory WHERE UserID='".$myU->ID."' AND ItemID='".$ID."' AND File='".$gI->File."'");
	$tG = mysql_num_rows($tryGet);
	
	$getSold = mysql_query("SELECT * FROM Inventory WHERE ItemID='".$ID."' AND File='".$gI->File."'");
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
				<div id='TextWrap'>
					".$gI->Name."
				</div>
				<table width='100%'>
					<tr>
						<td width='50%'>
							<b style='text-transform:uppercase;font-size:8pt;'>SOCIAL-PARADISE $gI->Type</b>
						</td>
						<td>
																		<font color='green'><b>Bux: $".$gI->Price."</b></font> &nbsp; &nbsp; "; if ($gI->sell == "yes") { if ($Status->ItemStatus == 0) { echo "<input type='submit' id='buttonsmall' value='Buy Now' name='Buy'></form>"; } else { echo "<font color='red'>Sorry, we are not allowing purchases at this time. Please try again later.</font>"; } } if ($gI->saletype == "limited") { echo "<font color='red' style='padding-left:15px;'><b>$gI->numberstock/$gI->numbersales remaining</b></font>"; } else { echo "<font color='purple' style='padding-left:15px;'><b>".$gsold." sold</b></font>"; } echo "
						</td>
					</tr>
				</table>
					<table>
						<tr>
							<td valign='top'><center>
								<div style='border-radius:5px;width:100px;height:200px;'>
									
									";
									if ($gI->saletype == "limited") {
									echo "
										
										<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(Dir/".$gI->File.");'>
										<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Imagess/LimitedWatermark.png);'>
										</div></div>
									";
									}
									else {
										echo "<img src='Dir/".$gI->File."' width='100' height='200'>";
									}
									echo "
								</div>
							</td>
							<td valign='top'>
											<b style='font-size:8pt;'>Description</b>
											<br />
											<div style='background:white;border:1px solid #CCC;border-radius:5px;padding:3px;width:300px;font-size:10pt;padding-top:5px;padding-bottom:5px;max-height:70px;overflow-y:auto;height:100px;'>
												".nl2br($gI->Description)."
											</div>
											";
											if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerImageModerator == "true"||$gI->CreatorID == $myU->ID) {
											echo "<br /><a href='ConfigureItem.php?ID=$ID' style='font-size:8pt;'>Edit Item</a>";
											}
											echo "
							</td>
							<td valign='top' style='padding-left:50px;'><center>
											<b style='font-size:8pt;'>Creator</b><br /><a href='/user.php?ID=".$gI->CreatorID."' border='0' style='color:black;'>
											";
											
											echo "<img src='/Avatar.php?ID=".$gI->CreatorID."'><br>";
											$StatusTax = $Statux->tax;
											$tax = "0.$StatusTax";
											$userget = $gI->Price*$tax;
											$finish = $gI->Price;
											echo "
											<b>".$gC->Username."</b>
											</a>
							</td>
						</tr>
					</table>
			</td>
		</tr>
	</table>
	";
	if ($gI->saletype == "limited" && $gI->numberstock == "0") {
	
		echo "
		<table width='95%'>
			<tr>
				<td width='50%' valign='top'>
					<div id='TextWrap'>
						Private Sellers
					</div>
					<div style=''>
					";
						
						$getSales = mysql_query("SELECT * FROM Sales WHERE ItemID='".$ID."' ORDER BY Amount ASC");
						
							while ($getS = mysql_fetch_object($getSales)) {
							
								echo "
								<table width='100%' style=''>
									<tr>
										<td width='100'><center>
											";
											echo "<a href='../user.php?ID=$getS->UserID'><img src='../Avatar.php?ID=$getS->UserID' width='35'></a>";
											
												$getSeller = mysql_query("SELECT * FROM Users WHERE ID='".$getS->UserID."'");
												$gS = mysql_fetch_object($getSeller);
												
												if ($getS->SerialNum == "0") {
												
													$Serial_Num = "N/A";
												
												}
												else {
												
													$Serial_Num = $getS->SerialNum;
												
												}
												
											echo "
										</td>
										<td valign='top' align='left' width='60%'>
											<a href='../user.php?ID=$getS->UserID'><font style='font-size:15px;color:black;font-weight:bold;'>".$gS->Username."</font>
											</a>
											<br />
											<font color='green'><b>Bux: ".number_format($getS->Amount)."</b></font>
											<br /><div style='padding-top:3px;'></div>
											";
											if ($Serial_Num != "N/A") {
											echo "
											<font style='font-size:11px;color:#777;'>Number  #".$Serial_Num."/".$gI->numbersales."</font>
											";
											}
											
											
											echo "
										</td>
										<td width='200'>
											";
											if ($tG == 0) {
											
												echo "</form><form action='Item.php?ID=".$ID."&SaleID=".$getS->ID."' method='POST'><input type='submit' name='PurchaseSale' value='Purchase' style='cursor:pointer;' id='buttonsmall'></form>";
											
											}
											else {
											
												echo "</form><form action='Item.php?ID=".$ID."&SaleID=".$getS->ID."' method='POST'><input type='submit' name='PurchaseSale' value='Purchase' disabled='disabled'  id='buttonsmall' title='You already own this item'></form>";
											
											
											}
											

											
											echo "
										</td>
									</tr>
								</table>
								<br />
								";
							
							}
						
											$Purchase = mysql_real_escape_string(strip_tags(stripslashes($_POST['PurchaseSale'])));
											$SaleID = mysql_real_escape_string(strip_tags(stripslashes($_GET['SaleID'])));
											
											
											if ($Purchase && $tG == "0" && $SaleID) {
														$getRow = mysql_query("SELECT * FROM Sales WHERE ID='".$SaleID."'");
														$row = mysql_fetch_object($getRow);					
												$num_row = mysql_num_rows($getRow);
												$SalePrice = $row->Amount;
												if($num_row == 0)
												{

													echo "Error";

												}

												else
												{
												 if ($num_row == 1 && $myU->Bux >= $SalePrice && $row->UserID != $myU->ID) {

												 
													$getpastowner = mysql_query("SELECT * FROM Users WHERE ID='".$row->UserID."'");
													$gpo = mysql_fetch_object($getpastowner);
													$getSerial = mysql_query("SELECT * FROM Inventory WHERE UserID='$gpo->ID' AND File='$gI->File'");
													$Serial = mysql_fetch_object($getSerial);
												 
													$code1 = sha1($gI->File);
													$code2 = sha1($myU->ID);
													mysql_query("UPDATE Users SET Bux=Bux + $SalePrice WHERE ID='".$row->UserID."'");
													mysql_query("INSERT INTO Inventory (UserID, ItemID, File, Type, code1, code2, SerialNum)
													VALUES ('$myU->ID','$ID','$gI->File','$gI->Type','$code1','$code2','$Serial->SerialNum')");
													$getpastowner = mysql_query("SELECT * FROM Users WHERE ID='".$row->UserID."'");
													$gpo = mysql_fetch_object($getpastowner);

													mysql_query("DELETE FROM Inventory WHERE ItemID='".$ID."' AND UserID='".$row->UserID."' AND File='".$gI->File."' AND Type='".$gI->Type."'");
													mysql_query("UPDATE Users SET Bux=Bux - $SalePrice WHERE ID='".$myU->ID."'");
													mysql_query("DELETE FROM Sales WHERE ID='".$SaleID."' AND UserID='".$row->UserID."'");
													mysql_query("UPDATE Users SET ".$gI->Type."='' WHERE ID='".$row->UserID."' AND $gI->Type='$gI->File'");
													mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','purchased ".$gI->Name." from ".$gpo->Username." for ".$SalePrice."','".$_SERVER['PHP_SELF']."')");
													mysql_query("INSERT INTO PMs (SenderID, ReceiveID, Title, Body, time, LookMessage) VALUES('0','$row->UserID','$myU->Username just bought one of your limiteds!','$myU->Username just bought $gI->Name for $SalePrice!','0')");
													mysql_query("INSERT INTO PurchaseLog (UserID, Item, TypeStore) VALUES('$myU->ID','Purchased $gI->Name for $SalePrice successfully in a sale from $gpo->Username','store')");
													mysql_query("INSERT INTO PurchaseLog (UserID, Item, TypeStore) VALUES('$row->UserID','Sold $gI->Name for $SalePrice successfully in a sale from $myU->Username','store')");
													mysql_query("UPDATE Items SET SalePrices=SalePrices + ".$SalePrice." WHERE ID='$ID'");
													mysql_query("UPDATE Items SET NumberSold=NumberSold + 1 WHERE ID='$ID'");
													header("Location: /character.php");


												}
												else
												{
													$getpastowner = mysql_query("SELECT * FROM Users WHERE ID='".$row->UserID."'");
													$gpo = mysql_fetch_object($getpastowner);
													
													$MoreMoney = $SalePrice - $myU->Bux;
													echo "<br /><font color='red'>Error: You do not have enough money. You will need ".number_format($MoreMoney)." or more bux to buy this item from ".$gpo->Username."!</font>";
												}
												}
											
											}
					
					echo "
					
				</td>
				<td valign='top'>
					<div id='TextWrap'>
						Sales Statistics
					</div>
						<table width='100%'>
							<tr>
								<td width='50%'>
									<b>Average Price:</b>
								</td>
								<td>
									";
									if ($gI->NumberSold != "0") {
									$SalePrices = $gI->SalePrices/$gI->NumberSold;
									$SalePrices = "<font color='green'><b>$".number_format($SalePrices)."</b></green>";
									}
									else {
									$SalePrices = "<b>N/A</b>";
									}
									echo "
									$SalePrices
								</td>
							</tr>
						</table>
				";
											if ($gI->saletype == "limited" && $gI->numberstock == "0"&&$tG >= "1" && $myU->ID != $gC->ID) {
											
												$PriceSell = mysql_real_escape_string(strip_tags(stripslashes($_POST['PriceSell'])));
												$SubmitSell = mysql_real_escape_string(strip_tags(stripslashes($_POST['SubmitSell'])));
											
												echo "
												<br />
												<div id='TextWrap'>
													Sell Item
												</div>
												<div id='' style='padding-left:8px;'><div align='left'>
												<form action='' method='POST'>
													";
													
														$ifSelling = mysql_query("SELECT * FROM Sales WHERE ItemID='".$ID."' AND UserID='".$myU->ID."'");
														$ifS = mysql_num_rows($ifSelling);
														
													if ($ifS == "0") {
													
													$action = "create";
													
													echo "
													
													<input type='text' placeholder='Enter your price here...' name='PriceSell'>
													<input type='submit' name='SubmitSell' id='buttonsmall' />
													
													
													";
													}
													else {
													$iS = mysql_fetch_object($ifSelling);
													
													$action = "update";
													
													echo "
													<input type='text' placeholder='Enter your price here...' name='PriceSell' value='".$iS->Amount."'>
													
													<input type='submit' name='SubmitSell' />
													<br />
													<a href='Item.php?ID=".$ID."&RemoveMySale=T'><b>( remove )</b></a>
													<br />
													";
													
													$RemoveMySale = mysql_real_escape_string(strip_tags(stripslashes($_GET['RemoveMySale'])));
													
													if ($RemoveMySale == "T") {
													
														if ($ifS == "1") {
														
															mysql_query("DELETE FROM Sales WHERE UserID='".$myU->ID."' AND ItemID='".$ID."'");
															
															header("Location: Item.php?ID=".$ID."");
														
														}
														
														echo "k";
													
													}
													echo "</form>";
													}
													if ($action == "create" && $SubmitSell) {
													
														if ($PriceSell < 0) {
														
															echo "<font color='red'>ERROR: Your price is below 0 Bux! Please try again...</font>";
														
														}
														else {
														
														$getFromInventory = mysql_query("SELECT * FROM Inventory WHERE UserID='".$myU->ID."' AND ItemID='".$ID."'");
														$gFI = mysql_fetch_object($getFromInventory);
														mysql_query("INSERT INTO Sales (UserID, Amount, ItemID, SerialNum) VALUES ('".$myU->ID."','".$PriceSell."','".$ID."','".$gFI->SerialNum."')");
			
			
															
															header("Location: Item.php?ID=".$ID."");
														
														}
													
													}
													
													if ($action == "update" && $SubmitSell) {
													
														if ($PriceSell < 0) {
														
															echo "<font color='red'>ERROR: Your price is below 0 Bux! Please try again...</font>";
														
														}
														else {
														
														mysql_query("UPDATE Sales SET Amount='".$PriceSell."' WHERE UserID='".$myU->ID."' AND ItemID='".$ID."'");
														
														}
													
													}
													
													
													echo "
												</div>
												";
												
											
											}
				echo "
				</div>
				</td>
			</tr>
		</table>
		";
	
	}
	echo "
	<br />
	<table width='95%'>
		<tr>
			<td width='60%' valign='top'>
				<a name='comments'></a>
				<div id='TextWrap'>
					Comments
				</div>
				<center><a name='Comments'></a>
					";
						
						$getComments = mysql_query("SELECT * FROM ItemComments WHERE ItemID='".$ID."' ORDER BY time DESC");
						
						$counter = 0;
						
						while ($gC = mysql_fetch_object($getComments)) {
						
							$counter++;

						
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
											<a href='Item.php?ID=$ID&CommentMethod=Scrub&CommentID=$gC->ID' style='color:blue;font-weight:bold'>Scrub</a> | <a href='Item.php?ID=$ID&CommentMethod=Delete&CommentID=$gC->ID' style='color:blue;font-weight:bold'>Delete</a>
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
											
												mysql_query("UPDATE ItemComments SET Post='[ Content Deleted ]' WHERE ID='".$CommentID."'");
												header("Location: Item.php?ID=$ID#Comments");
											
											}
											if ($CommentMethod == "Delete") {
											
												mysql_query("DELETE FROM ItemComments WHERE ID='".$CommentID."'");
												header("Location: Item.php?ID=$ID#Comments");
											
											}
					if ($User) {
					echo "
				</div>
					<form action='#comments' method='POST'>
						<textarea name='Reply' rows='5' style='width:90%;' placeholder='i.e This item is so cool!!!'></textarea>
						<br />
						<input type='submit' name='SubmitReply' value='Reply' id='buttonsmall' />
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
									
									mysql_query("INSERT INTO ItemComments (UserID, ItemID, Post, time) VALUES ('".$myU->ID."','".$ID."','".$Reply."','".time()."')");
									
									//ok now redirect the client
									
									header("Location: Item.php?ID=".$ID."");
								
								}
								else {
								
									echo "Please wait ".time() - $myU->comment_flood." seconds before posting again!";
								
								}
							
							}
							}
				echo "
			</td>
			<td valign='top'>
				<div id='TextWrap'>
					Featured Items
				</div>
					<div align='left'>
						";
						
						
							$getRandom = mysql_query("SELECT * FROM Items ORDER BY RAND() LIMIT 3");
							
						while ($gR = mysql_fetch_object($getRandom)) {
						
						echo "
						<table width='100%' cellspacing='0' cellpadding='0'>
							<tr>
								<td width='50'>
									<a href='/Item.aspx?ID=".$gR->ID."' border='0'>
									<img src='Dir/".$gR->File."' height='100'>
									</a>
								</td>
								<td valign='top' align='left'>
									<a href='Item.php?ID=".$gR->ID."' border='0'>
									<b>".$gR->Name."</b></a>
									<br />
									<br />
									<b><font color='green'><b>Bux: $".number_format($gR->Price)."</b></font></b>
									
									
								</td>
							</tr>
						</table>
						";
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
				$Diamonds = $gI->Diamonds;
				
				if ($myU->Bux >= $Price) {
				
				
					if ($gI->saletype == "limited"&&$gI->numberstock == "0") {
					
							echo "
								<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'>
									<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><center>
									<div style='background:#ccc;border:1px solid gray;width:500px;padding:8px;text-align:left;'>
										This item is sold out.
										<br />
										<br />
										<a href='Item.php?ID=".$ID."' style='color:black;font-weight:bold;'>Return</a>
									</div>
								</div>
							";
					
					}
					else {
					
						$tryGet = mysql_query("SELECT * FROM Inventory WHERE UserID='".$myU->ID."' AND ItemID='".$ID."' AND File='".$gI->File."'");
						$tG = mysql_num_rows($tryGet);
						
						if ($tG >= 1) {
						
							echo "
								<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'>
									<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><center>
									<div style='background:#ccc;border:1px solid gray;width:500px;padding:8px;text-align:left;'>
										You own this item.
										<br />
										<br />
										<a href='Item.php?ID=".$ID."' style='color:black;font-weight:bold;'>Return</a>
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
							
							//serial number
							
							if ($gI->saletype == "limited") {
							
								$Equation = $gI->numbersales + 1;
								
								$Output = $Equation - $gI->numberstock;
								
								//check if in stock already if lag
								
								$getStock = mysql_query("SELECT * FROM Inventory WHERE ItemID='$ID' AND File='$gI->File' AND SerialNum='$Output'");
								$Stock = mysql_num_rows($getStock);
								if ($Stock >= 1) {
								
								//close
								
								echo "Lag Purchase, error.";
								exit;
								
								}
							
							}
							else {
							
								$Output = 0;
							
							}
							
							mysql_query("UPDATE Users SET Bux=Bux - ".$Price." WHERE ID='".$myU->ID."'");
							
							
							//insert into inventory
							
							mysql_query("INSERT INTO Inventory (UserID, ItemID, File, Type, code1, code2, SerialNum)
							VALUES ('".$myU->ID."','".$ID."','".$gI->File."','".$gI->Type."','".$code1."','".$code2."','".$Output."')");
							
							//now give the money to the seller
							
							mysql_query("UPDATE Users SET Bux=Bux + ".$Price." WHERE ID='".$gI->CreatorID."'");
							
							mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','purchased ".$gI->Name." for ".$Price."','".$_SERVER['PHP_SELF']."')");
							
							mysql_query("INSERT INTO PurchaseLog (UserID, Item, TypeStore) VALUES('$myU->ID','Purchased $gI->Name for $Price','store')");
							
							header("Location: /character.php");
						
						}
					
					}
				
				}
				else {
				echo "
								<div style='background-image:url(/Imagess/menuhover.png);width:100%;height:100%;top:0;left:0;position:fixed;'>
									<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><center>
									<div style='background:#ccc;border:1px solid gray;width:500px;padding:8px;text-align:left;'>
										Insufficient funds.
										<br />
										<br />
										<a href='Item.php?ID=".$ID."' style='color:black;font-weight:bold;'>Return</a>
									</div>
								</div>
				";
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
							header("Location: store.php");
						
						}
					
					}
					
			}

include($_SERVER['DOCUMENT_ROOT']."/Footer.php");