<?php /*
ini_set("SMTP","brick-hill.com" ); 
ini_set('sendmail_from', 'cards@brick-hill.com');
include('../SiT_3/config.php');

$emails = file_get_contents('email.txt');
$emailArray = explode("\n", $emails);
	
	function genKey() {
		return rand(1,9) . rand(10000,99999) . range(1,9);
	}
	
foreach ($emailArray as $email) {
	
	
				
	$key = substr(hash('sha256', genKey()), 0, 10);
				
	$createKeySQL = "INSERT INTO `reg_keys` (`id`,`key_content`,`used`) VALUES (NULL, '$key', '0') ";
	$createKey = $conn->query($createKeySQL);
	
	$img = "http://storage.brick-hill.com/keys/card.php?key=$key&card=" . rand(1,3);
	
	$message = "We are happy to inform you we have received your request to beta test Brick Hill!\n <br> You can sign up at <a href='http://alpha.brick-hill.com/register/'>here</a>! \n <div style='padding-top:10px;padding-bottom:10px;text-align:center;'><img src=\"$img\"><br><i>This is your beta card. You can only use it once.</i></div>";
	$message = wordwrap($message, 70, "\r\n");
	
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=iso-8859-1';
	
	mail($email, '(Beta) Brick Hill Invitation', $message, implode("\r\n", $headers),
   '-f cards@brick-hill.com');
	
}
*/
?>