<?php
	include "../Header.php";
	
		if ($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerImageModerator == "true"||$gI->CreatorID == $myU->ID) {
		
			$ID = SecurePost($_GET['ID']);
			
			if (!$ID) {
			
			echo "Error. Check your ID.";
			include "../Footer.php";
			die;
			}
			
			
			$getItem = mysql_query("SELECT * FROM Items WHERE ID='$ID'");
			
			$numItem = mysql_num_rows($getItem);
			
			if ($numItem == 0) {
			
				echo" Error. Check your ID.";
				include "../Footer.php";
				die;
			
			}
			
			$gI = mysql_fetch_object($getItem);
			
			$getInventory = mysql_query("SELECT * FROM Inventory WHERE ItemID='$gI->ID' AND File='$gI->File' ORDER BY ID");
		 	
		
			echo "
			<table width='100%'>
				<tr>
					<td>
						<div id='TextWrap'>
							List of who purchased this item
						</div>
						<b style='font-size:8pt;'>ASCENDING ORDER</b>
						<br />
						";
						while ($gI2 = mysql_fetch_object($getInventory)) {
						
							echo "
							<table width='95%'>
								<tr>
									<td width='50%'>
										";
										
											$getUsername = mysql_query("SELECT * FROM Users WHERE ID='$gI2->UserID' ORDER BY ID");
											$gU = mysql_fetch_object($getUsername);
										
										echo "
										<a href='http://social-paradise.net/user.php?ID=$gU->ID'>$gU->Username</a>
									</td>
									<td>
										Serial Number: $gI2->SerialNum
									</td>
								</tr>
							</table>
							";
						
						}
						echo "
					</td>
				</tr>
			</table>
			";
		
		}
		
		else {
		header("Location: index.php");
		}
	
	include "../Footer.php";
?>