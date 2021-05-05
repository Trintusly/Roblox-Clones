<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
if($User) { if($myU->PowerArtist == "false") { echo "Please login or have the correct ranks!"; }  else { ?>
<table width='100%'>
	<tr>
		<td width='75%' valign='top'>
			<div id='LargeText'>
				Upload Item
			</div>
			<div id=''>
				<div align='left'>
					<form enctype="multipart/form-data" action="" method="POST">
						<table>
							<tr>
								<td style='padding-right:20px;'>
									<b>Item File</b>
								</td>
								<td>
									<input name="uploaded" type="file" />
								</td>
							</tr>
							<tr>
								<td style='padding-right:20px;'>
									<b>Item Name</b>
								</td>
								<td>
									<input type='text' name='name'>
								</td>
							</tr>
							<tr>
								<td style='padding-right:20px;'>
									<b>Type</b>
								</td>
								<td>
									<select name='type1'>
										<option value='Background'>Background</option>
										<option value='Body'>Body</option>
										<option value='Eyes'>Eyes</option>
										<option value='Mouth'>Mouth</option>
										<option value='Hair'>Hair</option>
										<option value='Hat'>Hat</option>
										<option value='Top'>Top</option>
										<option value='Bottom'>Bottom</option>
										<option value='Shoes'>Shoes</option>
										<option value='Accessory'>Accessory</option>
									</select>
								</td>
							</tr>
							<tr>
								<td style='padding-right:20px;'>
									<b>Price (BUX)</b>
								</td>
								<td>
									<input type='text' name='price'>
								</td>
							</tr>
							<tr>
								<td style='padding-right:20px;'>
									<b>Item Type</b>
								</td>
								<td>
									<select name='itemtype'>
										<option value='regular'>Regular</option>
										<option value='limited'>Limited</option>
										
									</select>
								</td>
							</tr>
							<tr>
								<td style='padding-right:20px;'>
									<b>Item Stock</b>
								</td>
								<td>
									<input type='text' name='numbersold'>
								</td>
							</tr>
							<tr>
								<td style='padding-right:20px;'>
									<b>On Sale</b>
								</td>
								<td>
									<select name='ifsale'>
										<option value='yes'>Yes</option>
										<option value='no'>No</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>
									<input type="submit" value="Upload" name='submit' />
								</td>
							</tr>
						</table>
						<font color='black' style='font-size:10pt;'>If you upload content from another website that owns the rights to such content, the content will be removed from BrickPlanet and your account will be terminated.</font>
					</form>  
 <?php 
 $itemname = mysql_real_escape_string(strip_tags(stripslashes($_POST['name'])));
 $itemtype = mysql_real_escape_string(strip_tags(stripslashes($_POST['type'])));
 $itemprice = mysql_real_escape_string(strip_tags(stripslashes($_POST['price'])));
 $filename = mysql_real_escape_string(strip_tags(stripslashes($_POST['filename'])));
 $numbersold = mysql_real_escape_string(strip_tags(stripslashes($_POST['numbersold'])));
 $itemtype = mysql_real_escape_string(strip_tags(stripslashes($_POST['itemtype'])));
 $selectype = mysql_real_escape_string(strip_tags(stripslashes($_POST['type1'])));
 $ifsale = mysql_real_escape_string(strip_tags(stripslashes($_POST['ifsale'])));
 date_default_timezone_set('EDT');
 $time = date("F jS, Y, g:i a");
 $submit = mysql_real_escape_string(strip_tags(stripslashes($_POST['submit'])));

 if($submit)
 {
$itemname = filter($itemname);
	 if($itemprice <= 0)
 {
	$itemprice = "0";
 }

 if(!is_numeric($itemprice))
 {
	$itemprice = "0";
 }
 if ($itemtype == "limited")
 {
 if ($numbersold < 1) {
 echo "<b>Error, must be at least 1 in stock.</b>";
 exit;
 }
 }
 $target = "".$_SERVER['DOCUMENT_ROOT']."/Store/Dir/";
 $target = $target . basename( $_FILES['uploaded']['name']) ; 
 $ok=1; 
if (($_FILES["uploaded"]["type"] == "image/png")
&& ($_FILES["uploaded"]["size"] < 1000000000000000))
{
  $ok=0;

//
  //
 if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
 {
function findexts ($filename) 
 { 
 $filename = strtolower($filename) ; 
 $exts = split("[/\\.]", $filename) ; 
 $n = count($exts)-1; 
 $exts = $exts[$n]; 
 return $exts; 
 }
 $Name = $_FILES['uploaded']['name'];
$R_NUM = RAND(1,50);
$ext = findexts($_FILES['uploaded']['name']);

$time = time();
	$okay = md5("$time$Name");
	$replace = "" . $R_NUM . "_" . $okay . "." . $ext . "";

rename(''.$_SERVER['DOCUMENT_ROOT'].'/Store/Dir/'.$_FILES['uploaded']['name'].'','' . $_SERVER['DOCUMENT_ROOT'] . '/Store/Dir/'.$replace.'') or die("This is erroring. Fix it, noob.");
 echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
 mysql_query("INSERT INTO ItemDrafts (Name, File, Type, Price, CreatorID, saletype, numbersales, numberstock, CreationTime)
 VALUES ('$itemname','$replace','$selectype','$itemprice','1','$itemtype','$_POST[numbersold]','$_POST[numbersold]', '$time')");
 mysql_query("UPDATE Items SET sell='$ifsale' WHERE Name='$itemname'");
mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','uploaded ".$itemname."','".$_SERVER['PHP_SELF']."')");
 header("Location: /Store/Store.php");
 } 
 else {
 echo "Sorry, there was a problem uploading your file.";
 }
  //

 }
 else
 {
	echo "<b>Error</b>";
 }
}

 echo "</td><td width='25%' valign='top'><div id='TextWrap'>Template</div><div id=''><center><img src='https://brickplanet.gq/Store/Dir/Avatar.png'></div></td></tr></table>";
 }
 }
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");
 ?>