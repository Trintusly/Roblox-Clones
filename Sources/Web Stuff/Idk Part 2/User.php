<?php
include "Header.php";
$getConfig = mysql_query("SELECT * FROM Configuration");
$gC = mysql_fetch_object($getConfig);
$Profile = mysql_real_escape_string(strip_tags(stripslashes($_GET['Profile'])));
echo"<center>";
if (!$Profile) {
echo 'Please include an Username!';
}
else {
	$gU = mysql_fetch_object($getUser = mysql_query("SELECT * FROM Users WHERE Username='".$Profile."'"));
	$UserExist = mysql_num_rows($getUser = mysql_query("SELECT * FROM Users WHERE Username='".$Profile."'"));
	if ($UserExist == "0") {
	
		echo "<b>This user does not exist.</b>";
		exit;
	
	}
$Twiter = $gU->Twitter;
if ($gU->Premium == 1) {

	echo "
	<style>
		body {
		background:url(https://buildcity.ml/Images/PremiumBG.png);
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:center top; 
		background-size:cover;
		height:100%;
		}
	</style>
	";

}
echo"<h1>".$gU->Username."</h1>";
if($gC->Avatars == "3D"){
echo"<img src='https://avatars.buildcity.ml/$gU->Avatar3D' width='400' height='450'><br>";}elseif($gC->Avatars == "2D"){
echo"<img src='/GetCharacter2D?ID=$gU->ID'><br><br>";
};
if (empty($Twiter)) {
$Twiter = "";
}
else {
echo'<a href="https://twitter.com/@';echo"$Twiter";echo'"><img src="/Images/twitter.png" style="border-radius: 30px;"></a>';
};
if (!$gU->expireTime) {
$SS = "Error";
}
else {
if ($now < $gU->expireTime) {
$SS = "<font color='green'><h2>Right Now!</h2></font>";
}
else {
$SS = date("F j, Y g:iA", $gU->expireTime);
}
};
echo"<hr><div class='jumbotron hero-spacer' style='border-radius: 0px;'><h4>".$gU->Username."'s Description:</h4><h5>$gU->Description</h5><hr><h4>".$gU->Username."'s Statistics:</h4><h5>Last Seen: $SS</h5><hr>";
echo"<h4>".$gU->Username."'s Badges:</h4>";
$numBadges = mysql_num_rows($Badges = mysql_query("SELECT * FROM Badges WHERE UserID='$gU->ID'"));
					
					if ($numBadges > 0) {
					
						echo "<table><tr width='100%'>";
						$Badges = mysql_query("SELECT * FROM Badges WHERE UserID='$gU->ID' ORDER BY ID");
						$badge = 0;
						while ($Row = mysql_fetch_object($Badges)) {
							$badge++;
							echo "<td>
<div class='center'>
						<img src='/Badges/".$Row->Position.".png' height='72' width='72' style='margin-left: 20px;margin-right: 20px;'></div>
						<div style='padding-top:2px;'></div>
							<div class='center'>
								".$Row->Position."
							</div>
						</a>
					</td>
							";
							if ($badge >= 6) {
							echo "</tr><tr>";
							$badge = 0;
							}
						
						}
}
echo"</tr></table></div>";
}
?>