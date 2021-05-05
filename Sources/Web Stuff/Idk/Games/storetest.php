<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
$Setting = array(
	"PerPage" => 21
);
$Page = $_GET['Page'];
if ($Page < 1) { $Page=1; }
if (!is_numeric($Page)) { $Page=1; }
$Minimum = ($Page - 1) * $Setting["PerPage"];
//for
$getall = mysql_query("select * from Items");
$all = mysql_num_rows($getall);
//query
$allusers = mysql_query("SELECT * FROM Items WHERE itemDeleted='0' ORDER BY ID DESC");
$num = mysql_num_rows($allusers);
$i = 0;
$Num = ($Page+8);
$a = 1;
$Log = 0;
echo "
<table cellspacing='0' cellpadding='0' width='100%'><tr><td valign='top'>
<div id='LargeText'>
	Store
</div>
<table width='98%'>
	<tr>
		<td width='40%' style='background-color:#ddd; padding:20px;'>
			";
			if ($myU->PowerArtist == "true") {
			echo "
				<div id='SeeWrap'>
					<div id='ProfileText'>
						Upload Item
					</div>
					<a href='StoreUpload.php' style='color:gray;'>Upload Item</a>
				</div>
			<br />
			";
			}
			echo "
			<div id='SeeWrap'>
				<div id='ProfileText'>
					Search
				</div>
				<form action='' method='POST'>
				<input type='text' name='q'>
				<br />
				<input type='submit' name='s' id='style_button' value='Search' style='cursor:pointer; color: rgb(255, 255, 255);font-size: 15px;padding: 10px;text-shadow: 0px 7px 9px rgba(30, 30, 30, 0.8);-webkit-border-radius: 10.790904131802646px;-moz-border-radius: 10.790904131802646px;border-radius: 10.790904131802646px;background: rgb(88, 93, 93);background: -moz-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: -webkit-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: -o-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: -ms-linear-gradient(78deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);background: linear-gradient(348deg, rgb(88, 93, 93) 20%, rgb(255, 255, 255) 100%);-webkit-box-shadow: 0px 4px 6px rgba(50, 50, 50, 0.75);-moz-box-shadow:    0px 4px 6px rgba(50, 50, 50, 0.75);box-shadow:         0px 4px 6px rgba(50, 50, 50, 0.75);'>
				</form>
			</div>
			<br />
			<div id='SeeWrap'>
				<div id='ProfileText'>
				Sort Items
				</div>
				<div align='left'>
				&nbsp; <a href='?all' style='font-weight:bold;color:black;'>All</a>
				<br />
				 &nbsp; <a href='?Sort=Eyes' style='font-weight:bold;color:black;'>Eyes</a> 
				<br />
				 &nbsp; <a href='?Sort=Mouths' style='font-weight:bold;color:black;'>Mouths</a>
				<br />
				 &nbsp; <a href='?Sort=Hair' style='font-weight:bold;color:black;'>Hair</a>
				<br />
				 &nbsp; <a href='?Sort=Pants' style='font-weight:bold;color:black;'>Pants</a>
				<br />
				 &nbsp; <a href='?Sort=Shirts' style='font-weight:bold;color:black;'>Shirts</a>
				<br />
				 &nbsp; <a href='?Sort=Hats' style='font-weight:bold;color:black;'>Hats</a>
				<br />
				 &nbsp; <a href='?Sort=Shoes' style='font-weight:bold;color:black;'>Shoes</a>
				<br />
				 &nbsp; <a href='?Sort=Accessories' style='font-weight:bold;color:black;'>Accessories</a>
				<br />
				 &nbsp; <a href='?Sort=Limiteds' style='font-weight:bold;color:black;'>Limiteds</a>
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
	</tr>
</table>
</td><td align='center'>
";

echo "<center><table><tr>";
	
	
		$q = mysql_real_escape_string(strip_tags(stripslashes($_POST['q'])));
		$s = mysql_real_escape_string(strip_tags(stripslashes($_POST['s'])));
		$pricemin = mysql_real_escape_string(strip_tags(stripslashes($_GET['min'])));
		$pricemax = mysql_real_escape_string(strip_tags(stripslashes($_GET['max'])));
		
			if (!$s && !$pricemin && !$pricemax) {
			
				$getItems = mysql_query("SELECT * FROM Items WHERE itemDeleted='0' ORDER BY UpdateTime DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			
			}
			elseif ($s) {
			
				$getItems = mysql_query("SELECT * FROM Items WHERE Name LIKE '%$q%' AND itemDeleted='0' ORDER BY ID DESC");
			
			}
			
			$Sort = mysql_real_escape_string(strip_tags(stripslashes($_GET['Sort'])));
			
			if ($Sort) {
			
				$getItems = mysql_query("SELECT * FROM Items WHERE Name LIKE '%$q%' AND itemDeleted='0' AND Type='$Sort' ORDER BY ID DESC");
			
			}
			if($Sort=='Limiteds')
			{
				$getItems = mysql_query("SELECT * FROM Items WHERE Name LIKE '%$q%' AND itemDeleted='0' AND saletype='limited' ORDER BY ID DESC");
			}
			if($pricemin && $pricemax)
			{
			if(is_numeric($pricemin) && is_numeric($pricemax)){}else{echo "<script>alert('Your minimum and max prices must be numbers only');</script>"; return false;}
			if($pricemin < $pricemax){}else{echo "<script>alert('Your max price must be greater than your minimum');</script>"; return false;}
			if($pricemin >= 0 && $pricemax >= 0){}else{echo "<script>alert('Your minimum and max prices must be greater than or equal to 0');</script>"; return false;}
			$getItems = mysql_query("SELECT * FROM Items WHERE itemDeleted='0' AND saletype!='limited' AND Price>=$pricemin AND Price<=$pricemax ORDER BY ID DESC");
			}
	
		$counter = 0;
		$total_counter = 0;
		
		if(mysql_num_rows($getItems) < 1)
		{
		echo "No ".$Sort." to display";
		}
	
		while ($gI = mysql_fetch_object($getItems)) {
		
			$counter++;
			$total_counter++;
			$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gI->CreatorID."'");
			$gC = mysql_fetch_object($getCreator);
			if ($counter%2 == 0) {$extra_css="background-color:#ddd;";}else{$extra_css='';}
			echo "
			
			<td style='font-size:13px;' align='left' width='100' valign='top'><a href='../Store/Item.php?ID=".$gI->ID."' border='0' style='color:black;'>
				<div style='".$extra_css." -webkit-box-shadow: 0px 0px 8px rgba(50, 50, 50, 0.5);-moz-box-shadow:    0px 0px 8px rgba(50, 50, 50, 0.5);box-shadow: 0px 0px 8px rgba(50, 50, 50, 0.5);border-radius:5px;padding:5px;'>
				";
				if ($gI->saletype == "limited") {
				echo "
					
					<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(http://social-paradise.net/Store/Dir/".$gI->File.");'>
					<div style='width: 100px; height: 200px; z-index: 3;  background-image: url(/Imagess/LimitedWatermark.png);'>
					</div></div>
				";
				}
				else {
					echo "<img src='http://social-paradise.net/Store/Dir/".$gI->File."' width='100' height='200'>";
				}
				echo "
				</div>
				<b>".$gI->Name."</b>
				</a>
				<br />
				<font style='font-size:10px;'>Creator: <a href='/user.php?ID=".$gC->ID."'>".$gC->Username."</a>
				<br />
				";
				if ($gI->sell == "yes") {
				if ($gI->saletype == "limited" && $gI->numberstock == "0") {
				echo "
				<font color='green'><b>Was Bux: ".number_format($gI->Price)."</b></font>
				";
				}
				else {
				echo "
				<font color='green'><b>Bux: ".number_format($gI->Price)."</b></font>
				";
				}
				}
				echo "
			</td>
			
			";
			
			if ($counter >= 7) {
			
				echo "</tr><tr>";
				
				$counter = 0;
			
			}
		
		}
		while($total_counter < $Setting['PerPage'])
		{
		$total_counter++;
		if($total_counter%7 == 0)
		{
		echo "</tr><tr>";
		}
		echo  "<td style='font-size:13px;' align='left' width='100' valign='top'>";
		}

		echo "</tr></table></td></tr></table><center>";
if (!$Sort) {
		$amount=ceil($num / $Setting["PerPage"]);
if ($Page > 1) {
echo '<a href="?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="?Page='.($Page+1).'">Next</a>';
}
}
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");
?>