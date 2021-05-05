<?
	include($_SERVER['DOCUMENT_ROOT'].'/Header.php');
	
	$view = SecurePost($_GET['view']);
?>
<div style='padding-left:40px;'>
	<h1>Advertising</h1>
	<div id='AssetsMenu' style='margin-right:0;border:0;'>
		<div class='verticaltab'>
			<a href='index.aspx?view=1'>
				My Running Ads
			</a>
			<a href='index.aspx?view=2'>
				My Inactive Ads
			</a>
			<a href='index.aspx?view=3'>
				My Pending Ads
			</a>
			
					
		</div>
	</div>
	<div class='divider-right' style='width:654px;float:left;border-left:1px solid #ccc;padding:10px;'>
	
<?
if(!$view) {
header("Location:index.aspx?view=1");
die();
}
if($view == 1) {
echo"<font size='5'>Running Ads <a href='Create.aspx'><b>(Create New)</b></a></font><br><br>";
$getAds = mysql_query("SELECT * FROM UserAdvertisments WHERE UserID='$myU->ID' AND Running='1' AND Approved='1' ORDER BY ID DESC");
$numAds = mysql_num_rows($getAds);
if($numAds == 0){
echo"<br>You have no running ads. <a href='Create.aspx'><b>Create an advertisement</b></a>";
}
else {
while($gA = mysql_fetch_object($getAds)) {
$BuxEarned = number_format($gA->BuxEarned);
$ExpireToDate = date("F j, Y g:iA",$gA->Expire);
echo"
$gA->Name (<a href='https://www.world2build.net/user.aspx?ID=$myU->ID'>Profile Advertisement</a>)<br>
<table width='600px'>
<tr>
<td width='100px'><img src='https://www.world2build.net/Advertising/Dir/$gA->Image' height='50' width='100'></td>
<td width='100px'><b>Bid:</b> $gA->Bid</td>
<td width='250px'><b>Expires:</b> $ExpireToDate</td>
<td width='150px'><b><font color='green'>Bux</font> earned:</b>$BuxEarned </td>

</tr>
</table>

<a href='index.aspx?view=1&StopRunning=$gA->ID' class='btn-best' style='font-size:13px;padding:3px;'>Stop Running</a>


<br><br>
";
$DeleteAd = SecurePost($_GET['StopRunning']);
if($DeleteAd){
mysql_query("DELETE FROM UserAdvertisments WHERE ID='$DeleteAd'");
header("Location: index.aspx");
die();

}

}
}





}
if($view == 2) {
echo"</table><font size='5'>Inactive Advertisements</font><br><br>";
$getAds = mysql_query("SELECT * FROM UserAdvertisments WHERE UserID='$myU->ID' AND Running='0' AND Approved='1' ORDER BY ID DESC");
$numAds = mysql_num_rows($getAds);
if($numAds == 0){
echo"<br>You have no inactive advertisements.";
}
else {
while($gA = mysql_fetch_object($getAds)) {
$BuxEarned = number_format($gA->BuxEarned);
$ExpireToDate = date("F j, Y g:iA",$gA->Expire);
echo"
$gA->Name (<a href='https://www.world2build.net/user.aspx?ID=$myU->ID'>Profile Advertisement</a>)<br>
<table width='600px'>
<tr>
<td width='100px'><img src='https://www.world2build.net/Advertising/Dir/$gA->Image' height='50' width='100'></td>
<td width='100px'><b>Bid:</b> $gA->Bid</td>
<td width='250px'><b>Expired:</b> $ExpireToDate</td>
<td width='150px'><b><font color='green'>Bux</font> earned:</b>$BuxEarned </td>

</tr>
</table>



<br><br>";
}
}
}
if($view == 3) {
echo"</table><font size='5'>Pending Advertisements</font><br><br>";
$getAds = mysql_query("SELECT * FROM UserAdvertisments WHERE UserID='$myU->ID' AND Approved='0' ORDER BY ID DESC");
$numAds = mysql_num_rows($getAds);
if($numAds == 0){
echo"<br>You have no Pending advertisements.";
}
else {
while($gA = mysql_fetch_object($getAds)) {
$BuxEarned = number_format($gA->BuxEarned);
$ExpireToDate = date("F j, Y g:iA",$gA->Expire);
echo"
$gA->Name (<a href='https://www.world2build.net/user.aspx?ID=$myU->ID'>Profile Advertisement</a>)<br>
<table width='200px'>
<tr>
<td width='100px'><img src='https://www.world2build.net/Advertising/Dir/$gA->Image' height='50' width='100'></td>
<td width='100px'><b>Bid:</b> $gA->Bid</td>
</tr>
</table>



<br><br>";
}
}
}
echo"</div>
<br style='clear:both;'>";
	include($_SERVER['DOCUMENT_ROOT'].'/Footer.php');
?>