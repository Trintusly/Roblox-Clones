<?php
//connect to the database
//load up database
$connection = mysql_connect("localhost","brickpla_usr","2zqKKQQ*bZF&+_+") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");
mysql_select_db("brickpla_db") or die("We are currently overloaded with users. Please try again in 1-5 minutes. Do not constantly refresh the page.");

//retrieve user info from request
//example: Avatar.php?ID=1 (page will load avatar for user with ID of 1)
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
$Username = mysql_real_escape_string(strip_tags(stripslashes($_GET['Username'])));
if (!$Username) {
$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'");
}
else {
$getUser = mysql_query("SELECT * FROM Users WHERE Username='".$Username."'");
}
$gU = mysql_fetch_object($getUser);

//load clothing
$Body = $gU->Body;
if (empty($Body)) {
$Body = "/Avatars/Avatar.png";
}

$Background = $gU->Background;
if (empty($Background)) {
$Background = "thingTransparent.png";
}

$Eyes = $gU->Eyes;
if (empty($Eyes)) {
$Eyes = "thingTransparent.png";
}

$Mouth = $gU->Mouth;
if (empty($Mouth)) {
$Mouth = "thingTransparent.png";
}

$Hair = $gU->Hair;
if (empty($Hair)) {
$Hair = "thingTransparent.png";
}

$Bottom = $gU->Bottom;
if (empty($Bottom)) {
$Bottom = "thingTransparent.png";
}

$Top = $gU->Top;
if (empty($Top)) {
$Top = "thingTransparent.png";
}

$TShirt = $gU->TShirt;
if (empty($TShirt)) {
$TShirt = "thingTransparent.png";
}

$Hat3 = $gU->Hat3;
if (empty($Hat3)) {
$Hat3 = "thingTransparent.png";
}

$Hat2 = $gU->Hat2;
if (empty($Hat2)) {
$Hat2 = "thingTransparent.png";
}

$Hat = $gU->Hat;
if (empty($Hat)) {
$Hat = "thingTransparent.png";
}

$Shoes = $gU->Shoes;
if (empty($Shoes)) {
$Shoes = "thingTransparent.png";
}

$Accessory = $gU->Accessory;
if (empty($Accessory)) {
$Accessory = "thingTransparent.png";
}


//render the avatar image
class StackImage
{
	private $image;
	private $width;
	private $height;
	
	public function __construct($Path)
	{
		if(!isset($Path) || !file_exists($Path))
			return;
		$this->image = imagecreatefrompng($Path);
		imagesavealpha($this->image, true);
		imagealphablending($this->image, true);
		$this->width = imagesx($this->image);
		$this->height = imagesy($this->image);
	}
	
	public function AddLayer($Path)
	{
		if(!isset($Path) || !file_exists($Path))
			return;
		$new = imagecreatefrompng($Path);
		imagesavealpha($new, true);
		imagealphablending($new, true);
		imagecopy($this->image, $new, 0, 0, 0, 0, imagesx($new), imagesy($new));
	}
	
	public function Output($type = "image/png")
	{
		header("Content-Type: {$type}");
		imagepng($this->image);
		imagedestroy($this->image);
	}
	
	public function GetWidth()
	{
		return $this->width;
	}
	
	public function GetHeight()
	{
		return $this->height;
	}
}
//add layer to image for the items that the user is wearing
//must be in specific order so you don't have unnecessary items overlapping each other incorrectly
//don't touch the bottom code
$Image = new StackImage("Imagess/thingTransparent.png");
$Image->AddLayer("Store/Dir/".$Background."");
$Image->AddLayer("Store/Dir/".$Body."");
$Image->AddLayer("Store/Dir/".$Eyes."");
$Image->AddLayer("Store/Dir/".$Mouth."");
$Image->AddLayer("Store/Dir/".$Bottom."");
$Image->AddLayer("Store/Dir/".$Top."");
$Image->AddLayer("Store/Dir/".$TShirt."");
$Image->AddLayer("Store/Dir/".$Hair."");
$Image->AddLayer("Store/Dir/".$Hat."");
$Image->AddLayer("Store/Dir/".$Shoes."");
$Image->AddLayer("Store/Dir/".$Accessory."");


//if the user is online, show online symbol
	if (time() < $gU->expireTime) {
	$Image->AddLayer("Imagess/Online.png");
	}
//or else if the user is offline, show offline symbol
	else {
	$Image->AddLayer("Imagess/Offline.png");
	}
//if the user is premium, show a little premium icon to the bottom left of their avatar
	if ($gU->Premium == 1) {
	$Image->AddLayer("Imagess/pw.png");
	}
//load up the rendered image
$Image->Output();
?>