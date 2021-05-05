<? include 'Header.php'; ?>
<?
$getShout = mysql_query("SELECT * FROM Shout");
$getConfig = mysql_query("SELECT * FROM Configuration");
$gC = mysql_fetch_object($getConfig);
if($myU->PowerAdmin == "true"){
while ($gB = mysql_fetch_object($getShout)) {
echo"
<form action='' method='POST'>
						<b>Public Banner</b>
						<br />
						<textarea name='BannerText' rows='5' cols='40'>".$gB->Text."</textarea>
						<br />
                                                <b>Avatars(Temp) Avatars = 2D/3D</b>
						<br />
						<textarea name='Avatars' rows='5' cols='40'>".$gC->Avatars."</textarea>
						<br />
                                                <b>Register(Temp) Register = true/false</b>
						<br />
						<textarea name='Register' rows='5' cols='40'>".$gC->Register."</textarea>
						<br />
                                                <b>Maintenance(Temp) Maintenance = true/false</b>
						<br />
						<textarea name='Maintenance' rows='5' cols='40'>".$gC->Maintenance."</textarea>
						<br />
						<input type='submit' name='Submit' value='Change' />
</form>";
$BannerText = $_POST['BannerText'];
$Reg = $_POST['Register'];
$Av = $_POST['Avatars'];
$Work = $_POST['Maintenance'];
$Submit = $_POST['Submit'];
if ($Submit) {
					
					
		mysql_query("UPDATE `Shout` SET `Text`='".$BannerText."'");
                mysql_query("UPDATE Configuration SET Register='".$Reg."'");
                mysql_query("UPDATE Configuration SET Avatars='".$Av."'");
                mysql_query("UPDATE Configuration SET Maintenance='".$Work."'");
		
		header("Location: /Admin/Panel?Changed=True");
		die();
		
	};
 };
}elseif($myU->PowerAdmin == "false"){
echo"<h1>Sorry, But you're not a admin</h1>";
};
if(!$User){
echo"<h1>Sorry, But you're not a admin</h1>";
};
?>

<? include 'Footer.php'; ?>