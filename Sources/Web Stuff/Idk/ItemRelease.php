<?php
	include "Header.php";
	
		if ($myU->PowerAdmin == "true") {
		$counter = 0;
			$getDrafts = mysql_query("SELECT * FROM ItemDrafts");
			echo "<font color='red'><B>DO NOT RANDOMLY APPROVE ITEMS, AS THEY MAY BE IN THE BACKLOG FOR SEVERAL DAYS BEFORE COMPLETION.<br /><br />3 regular items before a limited can be uploaded/approved.</b>
			<script>alert('NOTE: 3 regular items before a limited can be uploaded/approved');</script></FONT><table><tr>";
			while ($gD = mysql_fetch_object($getDrafts)) {
				$counter++;
				echo "
				<td id='unApproveditem' width='215'>
				<center>
					";
					if ($gD->Type != "Background") {
					echo "
					<div style='width:100px;height:200px;background-image:url(../Dir/Avatar.png);'>
					<img src='../Store/Dir/".$gD->File."' width='100' height='200'></div>
					";
					}
					else {
					echo "
					<div style='width:100px;height:200px;background-image:url(../Store/Dir/".$gD->File.");'>
					<img src='../Store/Dir/Avatar.png' width='100' height='200'>
					</div>
					";
					}
					echo "
					<br />
					<form action='' method='POST'>
					<table width='75%'>
						<tr>
							<td>
								Name:
							</td>
							<td>
								<input type='text' name='Name' value='".$gD->Name."'>
							</td>
						</tr>
						<tr>
							<td>
								Price:
							</td>
							<td>
								<input type='text' name='Price' value='".$gD->Price."'>
							</td>
						</tr>
						<tr>
							<td>
								Type:
							</td>
							<td>
								<input type='text' name='saletype' value='".$gD->saletype."'>
							</td>
						</tr>
						<tr>
							<td>
								Stock:
							</td>
							<td>
								<input type='text' name='numberstock' value='".$gD->numberstock."'>
							</td>
						</tr>
						<tr>
							<td>
								Creator:
							</td>
							<td>
								";
								$getCreator = mysql_query("SELECT * FROM Users WHERE ID='$gD->CreatorID'");
								$gC = mysql_fetch_object($getCreator);
								echo "
								$gC->Username
							</td>
						";
						echo "
						</tr>
					";
					echo "
					</table>
					<br />
					<input type='submit' name='Submit' value='Update Item'>
					<input type='hidden' name='ItemID' value='".$gD->ID."'>
					<br /><br />
					<a href='../ItemRelease.php?Release=yes&ReleaseID=$gD->ID'><b>Release</b></a> / <a href='../ItemRelease.php?Release=no&ReleaseID=$gD->ID'><b>Delete</b></a>
					</form>
				</center>
				</td>
				";
						if ($counter >= 4) {
						echo "</tr><tr>";
						$counter = 0;
						}
				
			
			}
				$Name = mysql_real_escape_string(strip_tags(stripslashes($_POST['Name'])));
				$Price = mysql_real_escape_string(strip_tags(stripslashes($_POST['Price'])));
				$saletype = mysql_real_escape_string(strip_tags(stripslashes($_POST['saletype'])));
				$numberstock = mysql_real_escape_string(strip_tags(stripslashes($_POST['numberstock'])));
				$ItemID = mysql_real_escape_string(strip_tags(stripslashes($_POST['ItemID'])));
				$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
				$Release = mysql_real_escape_string(strip_tags(stripslashes($_GET['Release'])));
				$ReleaseID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ReleaseID'])));
				if ($Submit) {
				
					mysql_query("UPDATE ItemDrafts SET Name='$Name' WHERE ID='$ItemID'");
					mysql_query("UPDATE ItemDrafts SET Price='$Price' WHERE ID='$ItemID'");
					mysql_query("UPDATE ItemDrafts SET saletype='$saletype' WHERE ID='$ItemID'");
					mysql_query("UPDATE ItemDrafts SET numberstock='$numberstock' WHERE ID='$ItemID'");
					header("Location: ItemRelease.php");
				
				}
				if ($Release == "yes") {
					
					$getItem = mysql_query("SELECT * FROM ItemDrafts WHERE ID='$ReleaseID'");
					$gI = mysql_fetch_object($getItem);
					mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','approved $gD->Name in the main store','".$_SERVER['PHP_SELF']."')");
					mysql_query("INSERT INTO Items (Name, File, Type, Price, CreatorID, saletype, numbersales, numberstock, sell, Description, CreationTime, store, timemake, itemDeleted, SalePrices, NumberSold)
					VALUES ('$gI->Name','$gI->File','$gI->Type','$gI->Price','$gI->CreatorID','$gI->saletype','$gI->numbersales','$gI->numberstock','$gI->sell','$gI->Description','$gI->CreationTime','$gI->store','$gI->timemake','$gI->itemDeleted','$gI->SalePrices','$gI->NumberSold')");
					mysql_query("DELETE FROM ItemDrafts WHERE ID='$ReleaseID'");
					header("Location: ItemRelease.php");					
				
				}
				elseif ($Release == "no") {
				mysql_query("DELETE FROM ItemDrafts WHERE ID='$ReleaseID'");
					$getItem = mysql_query("SELECT * FROM ItemDrafts WHERE ID='$ReleaseID'");
					$gI = mysql_fetch_object($getItem);
					unlink("/Store/Dir/$gI->File");
				mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','denied $gI->Name in the main store','".$_SERVER['PHP_SELF']."')");
				header("Location: ItemRelease.php");
				}
			echo "</tr></table>";
		
		}
		else {
		
			header("Location: index.php");
		
		}
	
	include "Footer.php";
?>