<?php
	include "Header.php";
	if (!$User) {
	
		header("Location: index.php");
	
	}
	$view = mysql_real_escape_string(strip_tags(stripslashes($_GET['view'])));
	
		if (!$view) {
		header("Location: ItemLogs.php?view=all");
		}
		
		if ($view == "all") {
		
			echo "<div id='LargeText'>Item Purchases</div><div id=''>";
		
			$getLogs = mysql_query("SELECT * FROM PurchaseLog WHERE UserID='$myU->ID' ORDER BY ID DESC");
			
				while ($gL = mysql_fetch_object($getLogs)) {
				
					$TypeStore = "";
					
					if ($gL->TypeStore == "store") {
					$TypeStore = "Store";
					}
					else {
					$TypeStore = "User Store";
					}
				
					if ($gL->Action == "store_purchase") {
					
						$Message = "Purchased";
					
					}
					
					elseif ($gL->Action == "sold_limited") {
					
						$Message = "Sold";
					
					}
					
					elseif ($gL->Action == "purchased_limited") {
					
						$Message = "Purchased";
					
					}
				
					echo "
					<table style='padding:5px;background:#E1E1E1;border:1px solid #aaa;width:1100px;'>
						<tr>
							<td width='200'>
									".$Message." $gL->Item
							</td>
							<td width='100'>
								<font color='green'>
									".$gL->Price." BUX
								</font>
							</td>
							<td width='300'>
								In $gL->TypeStore
							</td>
							<td>
								";
								if ($gL->SellerID != $myU->Username) {
								echo "
								From $gL->SellerID
								";
								}
								else {
								echo "Automated";
								}
								echo "
							</td>
						</tr>
					</table>
					<br />
					";
				
				}
				echo "</div>";
		
		}
	include "Footer.php";
?>