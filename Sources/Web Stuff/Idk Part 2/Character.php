<?php
include_once "Header.php";
if($User) {
$Setting = array(
	"PerPage" => 10
);
$Page = $_GET['Page'];
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];

//query
$allusers = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' ORDER BY ID");
$num = mysql_num_rows($allusers);
$i = 0;
$Num = ($Page+8);
$a = 1;
$Log = 0;
$getConfig = mysql_query("SELECT * FROM Configuration");
$gC = mysql_fetch_object($getConfig);
if ($User)
{
echo "<center>
<table width='80%'>
	<tr>
		<td style='width:250px;' valign='top'>
			<div id='ProfileText'> 
				Wardrobe
			</div>
				<div id=''>
					<center>
					";
					if($gC->Avatars == "3D"){
echo"<img src='https://avatars.mine2build.eu/$myU->Avatar3D' width='300' height='340'>";}elseif($gC->Avatars == "2D"){
echo"<img src='/GetCharacter2D?ID=$myU->ID'>";
};
					echo "
				</div>
			<br />
			<div id='ProfileText'>
				What I'm Wearing
			</div>
			<div style='overflow-x:auto;width:348px;max-width:348px;'>
				<table><tr>
				";
				$counter = 0;
				if (!empty($myU->Background)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE File='".$myU->Background."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM 3DItems WHERE File='$myU->Background'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "#";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Background'");
						$gN = mysql_fetch_object($getName);
						$Link = "/UserShop/";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
					
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				}

								if (!empty($myU->Eyes)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE File='".$myU->Eyes."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM 3DItems WHERE File='$myU->Eyes'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Eyes'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
					
				
				}
				
								if (!empty($myU->Mouth)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM Items WHERE File='".$myU->Mouth."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM Items WHERE File='$myU->Mouth'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Mouth'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				}

								if (!empty($myU->Hair)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM Items WHERE File='".$myU->Hair."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM Items WHERE File='$myU->Hair'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Hair'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				
				}

								if (!empty($myU->Bottom)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM Items WHERE File='".$myU->Bottom."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM Items WHERE File='$myU->Bottom'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Bottom'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
					
				
				}

								if (!empty($myU->Top)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE File='".$myU->Top."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM 3DItems WHERE File='$myU->Top'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Top'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/3DStores/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM 3DItems WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				}

								if (!empty($myU->Hat)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM 3DItems WHERE File='".$myU->Hat."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM Items WHERE File='$myU->Hat'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Hat'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				}

								if (!empty($myU->Shoes)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM Items WHERE File='".$myU->Shoes."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM Items WHERE File='$myU->Shoes'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Shoes'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				}

								if (!empty($myU->Accessory)) {
						$counter++;
						$checkifitem = mysql_query("SELECT * FROM Items WHERE File='".$myU->Accessory."'");
						$check1 = mysql_num_rows($checkifitem);
				
					if ($check1 == "1") {
					
						$getName = mysql_query("SELECT * FROM Items WHERE File='$myU->Accessory'");
						$gN = mysql_fetch_object($getName);
					
						$Link = "/Store/Item.php";
					
					}
					else {
					
						$getName = mysql_query("SELECT * FROM UserStore WHERE File='$myU->Accessory'");
						$gN = mysql_fetch_object($getName);
						$Link = "/Store/UserItem.php";
					
					}
					
					$getID = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' AND File='$gN->File'");
					$gI = mysql_fetch_object($getID);
					$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
					$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
					echo "
					<td valign='top' align='center'>
						$echo1<img src='/Store/Dir/".$gI->File."'>
						<br />
						<a href='$Link'>".$TheItemName."</a>
						$echo
						";
							$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
							$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
							$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
							$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
							
							
							if ($gI->store == "regular") {
							$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							else {
							$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
							$gQ = mysql_fetch_object($getItemQ);
							}
							
							if($Page&&$Sess&&$Var&&$Wear)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
									
									
								
									$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
									
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
									
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									echo $code1;
									echo " " . $code2;
									echo "<br />".$gi->code1." then ".$gi->code2."";
									}
								
								}
							
							}
							if($Page&&$Sess&&$Var&&$Remove)
							{
							
								$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
								$gi = mysql_fetch_object($getitem);
								$gi1 = mysql_num_rows($getitem);
											$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
									$check1 = mysql_num_rows($checkifitem);
								
									if ($check1 == "1") {
									
										$cI = mysql_fetch_object($checkifitem);
									
									}
									else {
									
										$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
										$cI = mysql_fetch_object($checkifitem);
									
									}
								if($gi1 == 0)
								{
								
									echo "Error";
								
								}
								else if($gi1 >= 1)
								{
								
									$code1 = sha1($cI->File);
									$code2 = sha1($myU->ID);
									if($gi->code1 == $code1&&$gi->code2 = $code2)
									{
									
										mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
										header("Location: /Wardrobe/?Page=$Page");
									
									}
									else {
									
										header("Location: /Wardrobe/?Page=$Page");
									
									}
								
								}
							
								
							}
						echo "
					</td>
					";
				
				}				
				
				
				
				echo "
				</tr></table>
			</div>
		</td>
		<td style='width:400px;' valign='top'>
			<div id='ProfileText'>
				All My Items
			</div>
			<div id=''>
			<center>
					";

$getInventory = mysql_query("SELECT * FROM Inventory WHERE UserID='$myU->ID' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
echo "<table><tr>";
$counter = 0;
$Items = mysql_num_rows($getInventory);
if ($Items == 0) {
echo "Looks like you don't have any items! Why not look for some in the <a href='/Store/Store.php'>store</a> or <a href='/Store/UserStore.php'>user store</a>?";
}
while($gI = mysql_fetch_object($getInventory))
{
$Type = $gI->Type;
			$checkWear = mysql_query("SELECT * FROM Users WHERE ID='$myU->ID'");
			$cW = mysql_fetch_object($checkWear);
		
			$counter++;
			$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
			$check1 = mysql_num_rows($checkifitem);
			$cI = mysql_fetch_object($checkifitem);
			
			if ($check1 == "1") {
			
				$getName = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
				$gN = mysql_fetch_object($getName);
			
				$Link = "/Store/Item.php";
			
			}
			else {
			
				$getName = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
				$gN = mysql_fetch_object($getName);
				$Link = "/Store/UserItem.php";
			
			}
			$type = $gI->Type;
	if($myU->$type == $gI->File)
	{
	
		$echo = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'><font color='red'>Remove</font></a>";
		$echo1 = "</a><br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Remove=Yes' style='font-size:10pt;'>";
	
	}
	else
	{
	
		$echo = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Wear=Yes' style='font-size:10pt;'><font color='green'>Wear</font></a>";
		$echo1 = "<br><a href='?Page=$Page&Sess=".$gI->code1."&Var=".$gI->code2."&Wear=Yes' style='font-size:10pt;'>";
	
	}
	$TheItemName = $gN->Name;
	if (strlen($TheItemName) >= 10) {
	$TheItemName = substr($TheItemName, 0, 10);
	$TheItemName = $TheItemName . "...";
	}
	echo "<td align='center' valign='top'>$echo1<img src='/Store/Dir/".$gI->File."' width='100' height='200'></a><a href='".$Link."?ID=".$gI->ItemID."' border='0' title='".$gN->Name."'><br />".$TheItemName."<br><font size='2'>
	";
	echo "
	";
	
	echo $echo;
	
	$Wear = mysql_real_escape_string(strip_tags(stripslashes($_GET['Wear'])));
	$Remove = mysql_real_escape_string(strip_tags(stripslashes($_GET['Remove'])));
	$Sess = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sess'])));
	$Var = mysql_real_escape_string(strip_tags(stripslashes($_GET['Var'])));
	
	
	if ($gI->store == "regular") {
	$getItemQ = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."'");
	$gQ = mysql_fetch_object($getItemQ);
	}
	else {
	$getItemQ = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."'");
	$gQ = mysql_fetch_object($getItemQ);
	}
	
	if($Page&&$Sess&&$Var&&$Wear)
	{
	
		$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
		$gi = mysql_fetch_object($getitem);
		$gi1 = mysql_num_rows($getitem);
		if($gi1 == 0)
		{
		
			echo "Error";
		
		}
		else if($gi1 >= 1)
		{
			
			
		
			$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
			$check1 = mysql_num_rows($checkifitem);
			
			if ($check1 == "1") {
			
				$cI = mysql_fetch_object($checkifitem);
			
			}
			else {
			
				$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
				$cI = mysql_fetch_object($checkifitem);
			
			}
			
			$code1 = sha1($cI->File);
			$code2 = sha1($myU->ID);
			if($gi->code1 == $code1&&$gi->code2 = $code2)
			{
			
				mysql_query("UPDATE Users SET $gi->Type='$gi->File' WHERE ID='$myU->ID'");
				header("Location: /Wardrobe/?Page=$Page");
			
			}
			else {
			echo $code1;
			echo " " . $code2;
			echo "<br />".$gi->code1." then ".$gi->code2."";
			}
		
		}
	
	}
	if($Page&&$Sess&&$Var&&$Remove)
	{
	
		$getitem = mysql_query("SELECT * FROM Inventory WHERE code1='$Sess' AND code2='$Var'");
		$gi = mysql_fetch_object($getitem);
		$gi1 = mysql_num_rows($getitem);
					$checkifitem = mysql_query("SELECT * FROM Items WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
			$check1 = mysql_num_rows($checkifitem);
		
			if ($check1 == "1") {
			
				$cI = mysql_fetch_object($checkifitem);
			
			}
			else {
			
				$checkifitem = mysql_query("SELECT * FROM UserStore WHERE ID='".$gI->ItemID."' AND File='".$gI->File."'");
				$cI = mysql_fetch_object($checkifitem);
			
			}
		if($gi1 == 0)
		{
		
			echo "Error";
		
		}
		else if($gi1 >= 1)
		{
		
			$code1 = sha1($cI->File);
			$code2 = sha1($myU->ID);
			if($gi->code1 == $code1&&$gi->code2 = $code2)
			{
			
				mysql_query("UPDATE Users SET $gi->Type='' WHERE ID='$myU->ID'");
				header("Location: /Wardrobe/?Page=$Page");
			
			}
			else {
			
				header("Location: /Wardrobe/?Page=$Page");
			
			}
		
		}
	
		
	}
	echo "</td>";
	
	if ($counter >= 5) {
	echo "</tr><tr>";
	$counter = 0;
	}

}

echo "</tr></table>";

}

$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="/Wardrobe/?Page='.($Page-1).'">Previous</a> - ';
}
echo '   Page '.$Page.' of '.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="/Wardrobe/?Page='.($Page+1).'">Next</a>';
}
echo "<a name='bottom'></a>";
echo "</div></td></tr></table><br><br>";
}
include "Footer.php";