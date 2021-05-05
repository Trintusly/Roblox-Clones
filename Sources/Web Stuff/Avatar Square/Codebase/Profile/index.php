<?php
$id = $_GET['username'];
$pagename = "$id";
include('../header.php');
?>
</center>
<?php
if (!$id) {
echo "error";
} else {
$getUser = $handler->query("SELECT * FROM users WHERE username='".$id."'");
$gU = $getUser->fetch(PDO::FETCH_OBJ);
$id = $gU->id;
$username = $gU->username;
$userExist = ($getUser->rowCount());
if ($userExist == "0") {
header("Location: /");
} else {
?>
		<div class="profile-wrap">
			<div class="profile-frst-wrp">
				<div class="profile-ava-stacker">
<?php
}
}
?>
<div class="entire-page-wrapper">
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<script>
				document.title = "Profile | BLOXCreate"
			</script>
<div class="row">
<div class="col s12 m12 l3">

<div class="header-text" style="font-size:18px;"><? echo  $username ?></div>
<div class="content-box" style="padding:0;text-align:center;margin:0;">
<style>.fall-down{margin-top:35px!important;margin-left:175px!important;width:150px!important;}</style>
<ul class="right" style="margin-top:0;margin-bottom:0;margin-top:5px;"><li>
</ul>
<iframe frameBorder="0" src="/avatar.php?id=<? echo $id ?>" scrolling="no" style=" width: 200px; height: 200px"></iframe>
<a class="material-icons" href="/Profile/Send?id=<? echo $id ?>" title="Send a message" style="background:#2196F3;color:white;padding:4px 4px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;font-size:20px;">mail</a>
&nbsp;
<div style="height:10px;"></div>
</div>
<div class="content-box" style="padding:15px;font-size:14px;margin-top:15px;">
<center>
<table style="text-align:center;padding:0;margin:0;">
<tbody>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Profile Views:</td>
<td style="font-weight:normal;text-align:center;width:55%;">0</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Place Visits:</td>
<td style="font-weight:normal;text-align:center;width:55%;">0</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Date Joined:</td>
<td style="font-weight:normal;text-align:center;width:55%;">2017</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Friends Made:</td>
<td style="font-weight:normal;text-align:center;width:55%;">0</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;padding-bottom:0 !important;">Forum Posts:</td>
<td style="font-weight:normal;text-align:center;width:55%;padding-bottom:0 !important;">0</td>
</tr>
</tbody>
</table>
</center>
</div>

</div>
<div class="col s12 m12 l9" style="margin-bottom:15px;">
<div style="height:5px;"></div>
<div class="header-text" style="font-size:18px;">Description</div>
<div class="content-box" style="padding:15px;">
<div style="color:#555555;font-size:14px;"><? echo "
<p class='basic-font profile-name'>$gU->description</p>
"; ?></div>
</div>
<div style="height:25px"></div>
<div class="header-text" style="font-size:18px;">Games</div>
<div style="height:3px;"></div>
<div class="content-box" style="padding:15px;">

<a href="#"><img src=" http://i.imgur.com/tWj4Ohs.png" style="display:block;height:125px;width:125px;"></a>
<a href="#"><div style="padding-top:3px;color:#444444;font-size:16px;"><? echo $gU->username ?>'s Baseplate</div></a>

</div>
<div style="height:15px"></div>
<div class="header-text" style="float:left;font-size:18px;padding-top:10px;">Inventory</div>
<br style="clear:both;">
<div class="content-box" style="padding:15px;">
<div class="row" style="margin-bottom:0;">
<?$getinv = $handler->query("SELECT * FROM inventory WHERE user='$id' ORDER BY item DESC");
while($gIN = $getinv->fetch(PDO::FETCH_OBJ)){ 
$item = $handler->query("SELECT * FROM items WHERE id=" . $gIN->item); 
$gI = $item->fetch(PDO::FETCH_OBJ) ?>

<div class="col s3 center-align" style="padding:15px;">
<div style="position:relative;">
<a href="/Market/Items?id=<? echo $gI->id ?>"><img src="<? echo $gI->image ?>" style="display:block;height:125px;width:125px;"></a>
<a href="/Market/Items?id=<? echo $gI->id ?>"><div style="padding-top:3px;color:#444444;font-size:16px;"><? echo $gI->name ?></div></a>
</div></div>

<? } ?>
</div>
</div>

<div style="height:5px;"></div>
</font>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div style="height:100px"></div>
<? include "../footer.php"; ?>