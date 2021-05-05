<? include "../header.php"; 
$getGroup = $handler->query("SELECT * FROM groups ORDER by members DESC");
?>

<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<div class="header-text" style="font-size:18px;padding-bottom:5px;">Top Groups</div>

<? while($gG = $getGroup->fetch(PDO::FETCH_OBJ)){ 
$getusers = $handler->query("SELECT * FROM groupmembers WHERE groupid='$gG->id'"); 
$all = ($getusers->rowCount()); ?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<div class="content-box" style="padding:0;border-radius:0;border-top:0;">
<div class="row valign-wrapper" style="border:1px solid #e8e8e8;padding:15px 0;margin-bottom:0;margin-left:0;margin-right:0;">
<div class="col s2 valign center-align">
<a href="/Groups/Club?id=<?echo "$gG->id"; ?>"><img src="<? echo " $gG->image"; ?>" style="margin:0 auto;height:125px;width:125px;margin:0 auto;"></a>
</div>
<div class="col s8 valign">
<a href="/Groups/Club?id=<?echo "$gG->id"; ?>"><div style="font-size:22px;color:#666666;display:inline-block;"><? echo " $gG->title"; ?></div></a>
<div style="font-size:14px;color:#888888;"><? echo " $gG->description"; ?></div>
</div>
<div class="col s2 valign center-align">
<div style="font-size:18px;"><? echo " $all"; ?></div>
<div style="font-size:14px;color:#777777;">MEMBERS</div>
</div>
</div>
</div>
</div>
</div>
</br>
<? } include "../footer.php"; ?>