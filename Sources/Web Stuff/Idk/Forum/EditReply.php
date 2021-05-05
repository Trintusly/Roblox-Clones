<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
$getItems = mysql_query("SELECT * FROM Replies WHERE ID='$ID'");
$gI = mysql_fetch_object($getItems);
$getcheck = mysql_query("SELECT * FROM Inventory WHERE File='$gI->File'");
$gC = mysql_fetch_object($getcheck);
		if (!$User) {
		
			header("Location: /index.php");
		
		}
	if($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$gI->CreatorID == $myU->ID)
	{


		echo "
		<center><table width='100%'><tr><td>
						<div id='TopBar' style='width:99%;'>Edit Reply
			</div>
			<div id='aB'>
		<form action='' method='POST'>
						Description: <br><textarea name='description' rows='15' cols='150'>".$gI->Body."</textarea>";
						if ($myU->Rank >= 3) {
						
						
							};
									echo "
						<br>
					<br>
					";
					if($gI->sell == "yes")
					{
					echo "
					";
					}
					
					else
					{
					echo "
					";
					}
					echo "";
					
					if($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerImageModerator == "true"||$gI->CreatorID == $myU->ID)
					
					{
					echo "
						<input type='submit' name='Submit' value='Update'>
					";
					}
					if ($myU->PowerAdmin == "true") {
					echo "
					";
					
					}
					echo ""; 
		$ItemName = mysql_real_escape_string(strip_tags(stripslashes($_POST['ItemName'])));
		$Type = mysql_real_escape_string(strip_tags(stripslashes($_POST['Type'])));
		$Submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit'])));
		$Description = mysql_real_escape_string(strip_tags(stripslashes($_POST['description'])));
		$Submit1 = mysql_real_escape_string(strip_tags(stripslashes($_POST['Submit1'])));
		$itemtype = mysql_real_escape_string(strip_tags(stripslashes($_POST['itemtype'])));
		
		$getNumber = mysql_query("SELECT * FROM Inventory WHERE File='$gI->File' AND ItemID='$gI->ID' AND UserID !='".$gC->ID."'");
		$gN = mysql_num_rows($getNumber);
		if ($gI->numbersales == 0) {
			$gN = $gN;
		} 
		else {
			$gN = $gI->numbersales;
		}
		
		if($movetus)
		{
			$code1 = sha1($gI->File);
			$code2 = sha1($myU->ID);
			mysql_query("INSERT INTO Items (Name, File, Type, Price, CreatorID, saletype, numbersales, numberstock)
			VALUES ('$gI->Name','$gI->File','$gI->Type','$gI->Price','$gI->CreatorID','$gI->saletype','$gI->numbersales','$gI->numberstock')") or die("error1");
			mysql_query("DELETE FROM UserStore WHERE Name='$gI->Name' AND File='$gI->File' AND ID='$ID'") or die("error2");
			header("Location: Store.php");
		}
		
		if($Submit)
		{
		
		$ItemName = filter($ItemName);
			mysql_query("UPDATE Replies SET Title='$ItemName' WHERE ID='$ID'");
			mysql_query("UPDATE UserStore SET Name='$ItemName' WHERE ID='$ID'");
			mysql_query("UPDATE UserStore SET Price='$Price' WHERE ID='$ID'");
			mysql_query("UPDATE Replies SET Body='$Description' WHERE ID='$ID'");
			mysql_query("UPDATE UserStore SET sell='$ifsale' WHERE ID='$ID'");
			mysql_query("UPDATE UserStore SET saletype='$itemtype' WHERE ID='$ID'");
			mysql_query("UPDATE UserStore SET numbersales='$gN' WHERE ID='$ID'");
			mysql_query("UPDATE Threads SET Type='$Type' WHERE ID='$ID'");
mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','modified $ItemName in user store','".$_SERVER['PHP_SELF']."')");
			header("Location: ../Forum/ViewThread.php?ID=$ID");
		
		}
		

					if($myU->PowerAdmin == "true"||$myU->PowerMegaModerator == "true"||$myU->PowerImageModerator == "true"||$gI->CreatorID == $myU->ID)
					{
					
						
						$DeleteItem = mysql_real_escape_string(strip_tags(stripslashes($_POST['DeleteItem'])));
						if($DeleteItem)
						{
						
							$getRefunds = mysql_query("SELECT * FROM Inventory WHERE ItemID='".$gI->ID."'");
							
								while ($gRR = mysql_fetch_object($getRefunds)) {
								
									mysql_query("UPDATE Members SET Bux=Bux + ".$gI->Price." WHERE ID='".$gRR->UserID."'");
								
								}
						
							mysql_query("DELETE FROM Inventory WHERE ItemID='".$gI->ID."'");
							mysql_query("INSERT INTO ItemActions (Words, time) VALUES ('".$Name." deleted ".$gI->ID."!','".time()."')");
							mysql_query("DELETE FROM UserStore WHERE ID='$ID'");
							
							$Type = $gI->Type;
							$FileName = $gI->File;
mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','deleted $ItemName in user store','".$_SERVER['PHP_SELF']."')");
							mysql_query("update Users set $Type='' where $Type='$FileName'");
							$Path = "Dir/$FileName";
							
							unlink($Path);
							
							
							
							
							header("Location: ../Forum/ViewThread?ID=".$gI->ID."");
						}
						
					}
					}
					else {
					echo "insufficient powers<br />get out noob";
					exit;
					}