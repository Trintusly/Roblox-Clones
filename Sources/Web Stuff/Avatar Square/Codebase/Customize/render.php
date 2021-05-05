<?
include ('../core/init.php');
?>
<?
$id = mysql_real_escape_string(strip_tags(stripslashes($_GET['id'])));
$userName = mysql_real_escape_string(strip_tags(stripslashes($_GET['userName'])));
if (!$userName) {
$getUser = mysql_query("SELECT * FROM users WHERE userID='".$id."'");
}
else {
$getUser = mysql_query("SELECT * FROM users WHERE uName='".$uName."'");
}
$gU = mysql_fetch_object($getUser);

//stuff

$Head = $gU->HeadPath;
if (empty($Head)) {
$Head = "thingTransparent.png";
}

$Face = $gU->FacePath;
if (empty($Face)) {
$Face = "thingTransparent.png";
}

$Bottom = $gU->PantsPath;
if (empty($Pants)) {
$Bottom = "thingTransparent.png";
}

$Shirt = $gU->ShirtPath;
if (empty($Shirt)) {
$Shirt = "thingTransparent.png";
}

$Hat = $gU->HatPath;
if (empty($Hat)) {
$Hat = "thingTransparent.png";
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
$Image = new StackImage("images/avatar.png");
$Image->AddLayer("images/Items/".$Shirt."");
$Image->AddLayer("images/Items/".$Head."");
$Image->AddLayer("images/Items/".$Face."");
$Image->AddLayer("images/Items/".$Hat."");

$Image->Output();
?>