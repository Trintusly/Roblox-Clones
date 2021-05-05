<?
$connection = mysql_connect("localhost","brickpla_usr","2zqKKQQ*bZF&+_+");
mysql_select_db("brickpla_db");
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
$Username = mysql_real_escape_string(strip_tags(stripslashes($_GET['Username'])));
if (!$Username) {
$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'");
}
else {
$getUser = mysql_query("SELECT * FROM Users WHERE Username='".$Username."'");
}
$gU = mysql_fetch_object($getUser);

//stuff


$Body = $gU->Body;
if (empty($Body)) {
$Body = "thingTransparent.png";
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
$Image = new StackImage("Imagess/thingTransparent.png");
$Image->AddLayer("Store/Dir/".$Background."");
$Image->AddLayer("Store/Dir/".$Body."");
$Image->AddLayer("Store/Dir/".$Eyes."");
$Image->AddLayer("Store/Dir/".$Mouth."");
$Image->AddLayer("Store/Dir/".$Bottom."");
$Image->AddLayer("Store/Dir/".$Top."");
$Image->AddLayer("Store/Dir/".$Hair."");
$Image->AddLayer("Store/Dir/".$Hat."");
$Image->AddLayer("Store/Dir/".$Shoes."");
$Image->AddLayer("Store/Dir/".$Accessory."");



	if (time() < $gU->expireTime) {
	$Image->AddLayer("Imagess/Online.png");
	}
	if ($gU->Premium == 1) {
	$Image->AddLayer("Imagess/pw.png");
	}
$Image->Output();
?>