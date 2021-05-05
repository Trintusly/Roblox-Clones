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
$getall = mysql_query("select * from UserStore");
$all = mysql_num_rows($getall);
//query
$allusers = mysql_query("SELECT * FROM UserStore ORDER BY ID DESC");
$num = mysql_num_rows($allusers);
$i = 0;
$Num = ($Page+8);
$a = 1;
$Log = 0;
?>
		<?php
			if ($User) {
				if ($myU->Premium == 0) {
				echo "
				<div style='top:300;left:50px;position:fixed;'>
				<a href='http://social-paradise.net/upgrades.php' border='0'><img src='http://social-paradise.net/Images/upgrade_promo.png' width='125' border='0'></a>
				</div>
				";
				}
			
			}
		?>
<?
echo "
			<form action='' method='POST'>

<table cellspacing='0' cellpadding='0' width='100%'>
	<tr>
		<td width='50%'>
		<div id='LargeText'>
			User Store
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
			if ($myU->Rank >= 0) {
			echo "
				<a href='UserUpload.php'>Upload Item</a>
			<br />
			";
			}
			echo "
				<table>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Eyes' style='font-weight:bold;color:#777;'>Eyes</a> 
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Mouths' style='font-weight:bold;color:#777;'>Mouths</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Hair' style='font-weight:bold;color:#777;'>Hair</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Pants' style='font-weight:bold;color:#777;'>Pants</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Shirts' style='font-weight:bold;color:#777;'>Shirts</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Hats' style='font-weight:bold;color:#777;'>Hats</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Shoes' style='font-weight:bold;color:#777;'>Shoes</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href='/Store/http://social-paradise.net/UserShop/?Sort=Accessories' style='font-weight:bold;color:#777;'>Accessories</a>
						</td>
					</tr>
				</table>
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
			
				$getItems = mysql_query("SELECT * FROM UserStore WHERE Active='1' AND itemDeleted='0' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			
			}
			elseif ($s) {
			
				$getItems = mysql_query("SELECT * FROM UserStore  WHERE Name LIKE '%$q%' AND Active='1' AND itemDeleted='0' ORDER BY ID DESC");
			
			}
			}
			else {
			$getItems = mysql_query("SELECT * FROM UserStore WHERE Active='1' AND itemDeleted='0' AND Type='$Sort' ORDER BY ID DESC LIMIT {$Minimum},  ". $Setting["PerPage"]);
			}
	
		$counter = 0;
	
		while ($gI = mysql_fetch_object($getItems)) {
		
			$counter++;
		
			$getCreator = mysql_query("SELECT * FROM Users WHERE ID='".$gI->CreatorID."'");
			$gC = mysql_fetch_object($getCreator);
		
			echo "
			
			<td style='font-size:11px;' align='left' width='100' valign='top'><a href='../Store/UserItem.php?ID=".$gI->ID."' border='0' style='color:black;'>
				<div style='border:1px solid #ccc;border-radius:5px;padding:5px;'>
					<img src='/Store/Dir/".$gI->File."' width='100' height='200'>
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
echo '<a href="http://social-paradise.net/UserShop/?Page='.($Page-1).'">Prev</a> - ';
}
echo ''.$Page.'/'.(ceil($num / $Setting["PerPage"]));
if ($Page < ($amount)) {
echo ' - <a href="http://social-paradise.net/UserShop/?Page='.($Page+1).'">Next</a>';
}
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");
?>