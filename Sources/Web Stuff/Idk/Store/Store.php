<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
$Setting = array(
	"PerPage" => 18
);
$Page = $_GET['Page'];
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
//for
$getall = mysql_query("select * from Items");
$all = mysql_num_rows($getall);
//query
$allusers = mysql_query("SELECT * FROM Items ORDER BY ID DESC");
$num = mysql_num_rows($allusers);
$i = 0;
$Num = ($Page+8);
$a = 1;
$Log = 0;
?>

<?
echo "
			<form action='' method='POST'>

<table cellspacing='0' cellpadding='0' width='100%'>
	<tr>
		<td width='50%'>
		<div id='LargeText'>
			Store
		</div>	
		</td>
		<td>
				<table cellspacing='0' cellpadding='0'>
					<tr>
						<td>
							<input type='text' name='q' style='width:200px;'>
						</td>
						<td>
							<input type='submit' name='s' value='Search'>
						</td>
					</tr>
				</table>
		</td>
	</tr>
</table>
<table cellspacing='0' cellpadding='0' width='100%'><tr><td valign='top'>
<table width='98%'>
	<tr>
		<td width='40%'>
			";
			if ($myU->PowerArtist == "true") {
			echo "
				<a href='StoreUpload.php'>Upload Item</a>
			<br />
			";
			}
			echo "
				<div id='SeeWrap'>
				<div id='ProfileText'>
				Sort Items
				</div>
				<div align='left'>
				&nbsp; <a href='?all' style='font-weight:bold;color:black;'>All</a>
				<br />
				 &nbsp; <a href='?Sort=Eyes' style='font-weight:bold;color:black;'>Eyes</a> 
				<br />
				 &nbsp; <a href='?Sort=Mouth' style='font-weight:bold;color:black;'>Mouths</a>
				<br />
				 &nbsp; <a href='?Sort=Hair' style='font-weight:bold;color:black;'>Hair</a>
				<br />
				 &nbsp; <a href='?Sort=Bottom' style='font-weight:bold;color:black;'>Pants</a>
				<br />
				 &nbsp; <a href='?Sort=Top' style='font-weight:bold;color:black;'>Shirts</a>
				<br />
				 &nbsp; <a href='?Sort=Hat' style='font-weight:bold;color:black;'>Hats</a>
				<br />
				 &nbsp; <a href='?Sort=Shoes' style='font-weight:bold;color:black;'>Shoes</a>
				<br />
				 &nbsp; <a href='?Sort=Accessory' style='font-weight:bold;color:black;'>Accessories</a>
				<br />
				 &nbsp; <a href='?Sort=Background' style='font-weight:bold;color:black;'>Backgrounds</a>
				<br />
				 &nbsp; <a href='?Sort=Limiteds' style='font-weight:bold;color:black;'>Limiteds</a>
                                <br />
				 &nbsp; <a href='?Sort=Body' style='font-weight:bold;color:black;'>Bodys</a>
				<br /><br />
				<div id='ProfileText'>
				Price Range
				</div>
				<form action='' method='GET'>
				<b>Min: </b><input type='text' name='min' style='width:110px;'>
				<br />
				<b>Max:</b><input type='text' name='max' style='width:110px;'>
				<br />
				<input type='submit' name='' id='style_button' value='Sort Items' style='cursor:pointer; color: rgb(255, 255, 255);font-size: 15px;padding: 10px;text-shadow: 0px 7px 9px rgba(30, 30, 30, 0.8);-webkit-border-radius: 10.790904131802646px;-moz-border-radius: 10.790904131802646px;border-radius: 10.790904131802646px;background: rgb(88, 93, 93);background: -moz-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: -webkit-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: -o-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: -ms-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: linear-gradient(348deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);-webkit-box-shadow: 0px 4px 6px rgba(50, 50, 50, 0.75);-moz-box-shadow:    0px 4px 6px rgba(50, 50, 50, 0.75);box-shadow:         0px 4px 6px rgba(50, 50, 50, 0.75);'>
				</form>
			</div>
		</td>
		<td>
		
		</td>
	</tr>
</table>
</td><td align='center'>
";

echo "<center><table><tr>";
		$q = mysql_real_escape_string(strip_tags(stripslashes($_POST['q'])));
		$s = mysql_real_escape_string(strip_tags(stripslashes($_POST['s'])));
		$Sort = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sort'])));
		
		
			if (!$Sort) {
		
			if (!$s) {
			
				$getItems = mysql_query("SELECT * FROM Items WHERE itemDeleted='0' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			
			}
			elseif ($s) {
			
				$getItems = mysql_query("SELECT * FROM Items WHERE Name LIKE '%$q%' AND itemDeleted='0' ORDER BY ID DESC");
			
			}
			}
			else {
			$getItems = mysql_query("SELECT * FROM Items WHERE itemDeleted='0' AND Type='$Sort' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			}
                        if($Sort=='Limiteds')
			{
				$getItems = mysql_query("SELECT * FROM Items WHERE Name LIKE '%$q%' AND itemDeleted='0' AND saletype='limited' ORDER BY ID DESC");
			}
	
		$counter = 0;
	
		while ($gI = mysql_fetch_object($getItems)) {
		
			$counter++;
		
			$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gI->CreatorID."'");
			$gC = mysql_fetch_object($getCreator);
		
			echo "
			
			<td style='font-size:11px;' align='left' width='100' valign='top'><a href='../Store/Item.php?ID=".$gI->ID."' border='0' style='color:black;'>
				<div style='border:1px solid #ccc;border-radius:5px;padding:5px;'>
					<div style='".$extra_css." -webkit-box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.5);-moz-box-shadow:    0px 0px 8px rgba(50, 50, 50, 0.5);box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.5);border-radius:5px;padding:5px;'>
				";
				if ($gI->saletype == "limited") {
				echo "
					
					<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Store/Dir/".$gI->File.");'>
					<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Imagess/LimitedWatermark.png);'>
					</div></div>
				";
				}
				if ($gI->saletype == "exclusive") {
				echo "
					
					<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Store/Dir/".$gI->File.");'>
					<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Imagess/ExclusiveWatermark.png);'>
					</div></div>
				";
				}
				else {
					echo "<img src='/Store/Dir/".$gI->File."' width='100' height='200'>";
				}
				echo "
				</div>
				</div>
				<b>".$gI->Name."</b></a>
				<br />
				<font style='font-size:10px;'>Creator: <a href='/user.php?ID=".$gC->ID."'>".$gC->Username."</a>
				<br />
				<font color='green'><b>Bux: ".$gI->Price."</b></font>
			</td>
			
			";
			
			if ($counter >= 6) {
			
				echo "</tr><tr>";
				
				$counter = 0;
			
			}
		
		}

		echo "</tr></table></td></tr></table><center>";
		$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="?Page='.($Page+1).'">Next</a>';
}
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");
?>
			