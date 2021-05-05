<?
mysql_connect("localhost","buildcit_user","2M6a2gqeF6");
		mysql_select_db("buildcit_main");
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
$Username = mysql_real_escape_string(strip_tags(stripslashes($_GET['Username'])));
if (!$Username) {
$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'");
}
else {
$getUser = mysql_query("SELECT * FROM Users WHERE Username='".$Username."'");
}
$gU = mysql_fetch_object($getUser);

        $data = $_POST['base'];
	list($type, $data) = explode(';', $data);
	list(, $data)      = explode(',', $data);
	$data = base64_decode($data);
        $filename = uniqid();

	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/Avatars/".$filename.'.png', $data);
        mysql_query("UPDATE `Users` SET `Avatar3D`='".$filename.".png' WHERE ID='".$ID."'");
        die;
?>