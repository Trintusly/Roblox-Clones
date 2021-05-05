<?php
include($_SERVER['DOCUMENT_ROOT'].'/Header.php');
if(!$User){
header("Location: https://brickplanet.gq/");
die();
}



echo"
<div style='padding-left:40px;'>




<font size='5'>Create advertisement</font>
<br><br>You can create advertisements for profiles and items. Your ad will appear on the website so other users can see them.
<br><br>
&bull; Before you start, all ads must be  728 x 90. <a href='/Dir/AdBannerTemplate.png' class='btn-best' style='font-size:13px;padding:2px;'>Download</a>
<br><br>
&bull; Design an advertisement that will attract other users.
<br><br>
&bull; Minimum you can bid is <b>100</b> <font color='green'><b>Bux</b></font>, you get <b>1</b> <font color='green'><b>Bux</b></font> every time a user sees your ad.
<br><br>
<form action='' method='post' enctype='multipart/form-data'>
<table>
<tr>
<td><b>Ad Name:</b></td>
<td><input type='text' name='AdName'></td>
</tr>
<td><b>Link:</b></td>
<td><input type='text' name='LinkPlace'></td>
</tr>
<tr>
<td><b>Bid Amount:</b></td>
<td><input type='text' name='Bid'> <b>The more <font color='green'>Bux</font> you bid on an ad, the most likely it is to show up.</b></td>
</tr>
<tr>
<td><b>Image Link:</b></td>
<td><input type='text' name='ImageLink'></td>
</tr>
</table>
<br><input type='submit' name='Submit' class='btn-primary' value='Upload'>
</form>
</div>";

$Submit = SecurePost($_POST['Submit']);
$Name = SecurePost($_POST['AdName']);
$LinkPlace = SecurePost($_POST['LinkPlace']);
$ImageLink = SecurePost($_POST['ImageLink']);
$Bid = SecurePost($_POST['Bid']);
$target_dir = "Dir/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$Link = mysql_query("UPDATE Ads SET Link='$LinkPlace'");
$Link2 = mysql_query("UPDATE Ads SET Image='$ImageLink'");
$getmyAds = mysql_query("SELECT * FROM Ads WHERE Username='$myU->Username'");
$numAds = mysql_num_rows($getmyAds);

if($Submit) {
if(!$Name){
echo"<div id='error'>Your ad must have a name</div>";
die();
}
elseif($Bid < 100) {
echo"<div id='error'>Your bid must be at least 100 <font color='green'><b>Bux</b></font></div>";
die();
}
elseif($Bid > $myU->Bux){
echo"<div id='error'>You do not have enough <font color='green'><b>Bux</b></font></div>";
die();
}
elseif($numAds >= 2) {
echo"<div id='error'>You have too many ads running.</div>";
die();
}
if(!$gA->$LinkPlace){echo "<div id='success'>Your advertisement has been uploaded.</div>";
   mysql_query("INSERT INTO Ads (ID, Image, Link, TimeRun, Active, Username) VALUES ('', '$ImageLink','$LinkPlace','0','0','$myU->Username')");
   mysql_query("UPDATE Users SET Bux=Bux-$Bid WHERE ID='$myU->ID'");
} else {
echo"no";  die(); };
    }


	include($_SERVER['DOCUMENT_ROOT'].'/Footer.php');

?>