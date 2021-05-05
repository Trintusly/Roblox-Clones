<?php
include($_SERVER['DOCUMENT_ROOT']."/Header.php");
if($User) { ?>
<div class="col s12 m12 l8">
<div style="padding-top:50px;"></div>
<div class="container" style="width:100%;">
<div class="center-align">
<div style="padding-bottom:50px;">
<div class="text-center">
<script async="" src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
 
<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5035877450680880" data-ad-slot="8645193052" data-ad-format="auto"></ins>
<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
</div>
</div>
</div>
<style>.new-blue-button{border:0;background:#2b90d9;color:white;padding:10px 15px;font-size:14px;font-weight:600;text-decoration:none;}.new-blue-button:hover{background:#2A87C9;}</style>
<div class="row">
<div class="col s6">
<div class="bc-content">
<h5 style="padding-bottom:20px;">Upload Shirt</h5>
<form action="" method="post" enctype="multipart/form-data">
<div class="input-field">
<input type="text" name="uploadShirtName" id="uploadShirtName" style="">
<label for="uploadShirtName">Title</label>
</div>
<div class="input-field">
<textarea name="uploadShirtDescription" id="uploadShirtDescription" class="materialize-textarea" style="height:125px;"></textarea>
<label for="uploadShirtDescription">Description</label>
</div>
<div class="input-field">
<input type="text" name="uploadShirtPrice" id="uploadShirtPrice" style="">
<label for="uploadShirtPrice">Price</label>
</div>
<div class="input-field">
<input type="file" name="uploaded" id="file" style="font-size:14px;">
</div>
<div class="input-field">
<i class="waves-effect waves-light btn blue waves-input-wrapper" style="">&nbsp;<input type="submit" name="uploadShirtSubmit" id="uploadShirtSubmit" class="waves-button-input" value="UPLOAD">&nbsp;</i>
</div>
</form>
</div>
</div>
<div class="col s6">
<div class="bc-content" style="font-size:14px;">
<h5 style="padding-bottom:20px;">Template</h5>
<a href="/Store/Dir/ShirtTemplate.png" target="_blank" title="Template (Click to Enlarge)" alt="Template (Click to Enlarge)"><img src="/Store/Dir/ShirtTemplate.png" class="responsive-img"></a>
</div>
</div>
</div>
</div></div><br><br><br><br><br><br><br><br></div>
 <?php 
 $itemname = mysql_real_escape_string(strip_tags(stripslashes($_POST['uploadShirtName'])));
 $itemprice = mysql_real_escape_string(strip_tags(stripslashes($_POST['uploadShirtPrice'])));
 $filename = mysql_real_escape_string(strip_tags(stripslashes($_POST['filename'])));
 $itemtype = "regular";
 date_default_timezone_set('EDT');
 $time = date("F jS, Y, g:i a");
  if($itemprice < 0)
 {
	$itemprice = "0";
 }
 $selectype = mysql_real_escape_string($_POST['type1']);
 if($_POST['uploadShirtSubmit'])
 {
 //Filter
$itemname = filter($itemname);
	 if($itemprice < 0)
 {
	$itemprice = "0";
 }
 if(!is_numeric($itemprice))
 {
	$itemprice = "0";
 } 


 $FileName = "".$_FILES['uploaded']['name']."";
 $_FILES['uploaded']['name'] = sha1("".$FileName."".time().".png"); 
 $target = "../Store/Dir/";
 $target = $target . basename( $_FILES['uploaded']['name']) ; 
 $ok=1; 
 
if ($_FILES["uploaded"]["type"] == "image/png")

{

  $ok=0;
 if ($uploaded_size > 100000)
 {
 echo "Your file is too large.<br>"; 
 die();
 $ok=0;
 }
     else if (file_exists("../Store/Dir/" . $_FILES["uploaded"]["name"]))
      {
      echo $_FILES["uploaded"]["name"] . " already exists. ";
	  die();
      } 
else
{ 
if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
 {
 echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
 mysql_query("INSERT INTO UserStore (Name, File, Type, Price, CreatorID, saletype, numbersales, numberstock, CreationTime)
 VALUES ('$itemname','".$_FILES['uploaded']['name']."','Top','$itemprice','$myU->ID','regular','$_POST[numbersold]','$_POST[numbersold]', '$time')");
  mysql_query("INSERT INTO userLog (User, Action) VALUES ('".$User."','Uploaded an item')");
 mysql_query("INSERT INTO Logs (UserID, Message, Page) VALUES('".$myU->ID."','uploaded ".$itemname."','".$_SERVER['PHP_SELF']."')");
 header("Location: /store/user");
 die();
 }
  else {
 echo "Sorry, there was a problem uploading your file.";
 die();
 }
}
}
else
{

	echo "Invalid file";

} 

 }

 }

 echo "";
include($_SERVER['DOCUMENT_ROOT']."/Footer.php");
 ?>