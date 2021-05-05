<? include "../../header.php"; 
$getGroup = $handler->query("SELECT * FROM messages where receiver=" . $myu->id); ?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
</center><h5>Messages</h5>
<div class="bc-content">
<? while($gG = $getGroup->fetch(PDO::FETCH_OBJ)){ 
$user = $handler->query("SELECT * FROM users where id=" . $gG->sender); 
$gU = $user->fetch(PDO::FETCH_OBJ) ?>
<table width="100%">
<tbody><tr>
<td width="50" class="center-align">
<input type="checkbox" name="message[]" id="label318290" value="318290" class="filled-in" style="margin:0 auto;">
<label for="label318290" style="padding-left:0;margin-bottom:-5px;font-size:0;">&nbsp;</label>
</td>
<td width="75" class="center-align">
<div style="width:50px;height:50px;border:1px solid #dedede;margin:0 auto;overflow:hidden;" class="circle center-align">
<img src="/Market/Storage/Avatar.png" width="100" height="100" style="margin-left:-25px;">
</div>
</td>
<td>
<div>
<div style="font-size:14px;color:#666;display:inline-block;"><a href="#" style="color:#666;"><? echo $gU->username ?></a></div>
<div style="font-size:12px;color:#999;display:inline-block;"> - Received Today</div>
</div>
<div style="font-size:16px;color:#222;display:inline-block;"><? echo $gG->title ?></div>
<div style="font-size:14px;color:#999;display:inline-block;" class="hide-on-med-and-down">&nbsp;-&nbsp;</div>
<div style="font-size:14px;color:#666;display:inline-block;word-break:break-word;"><? echo $gG->message ?></div>
</td>
</tr>
</tbody></table>
<? } ?>

<? include "../../footer.php"; ?>