<? include "../../header.php"; $id = $_GET['id']; 
$getTopic = $handler->query("SELECT * FROM topics WHERE id='$id'"); 
$topic = $getTopic->fetch(PDO::FETCH_OBJ) ?>

<div class="col s12 m12 l6 hide-on-med-and-down">
<a href="/Forum/Create?id=<? echo $id ?>" style="color:#323a45;font-weight:600;">Create Thread</a>
</div>
<div class="container" style="width:100%;">

<div class="light-blue lighten-1" style="color:white;padding:15px 25px;">
<div class="row valign-wrapper" style="margin-bottom:0;">
<div class="col s8 m8 l8 valign">
<div style="font-size:16px;"><? echo $topic->name ?></div>
</div>
<div class="col s2 m2 l1 center-align valign">
<div style="font-size:16px;">Views</div>
</div>
<div class="col s2 m2 l1 center-align valign">
<div style="font-size:16px;">Replies</div>
</div>
<div class="col s12 m12 l2 valign right-align hide-on-med-and-down">
<div style="font-size:16px;">Last Reply</div>
</div>
</div>
</div>

<? $getThreads = $handler->query("SELECT * FROM threads WHERE topicId='$id' ORDER BY threadId DESC LIMIT 10");
while($gT = $getThreads->fetch(PDO::FETCH_OBJ)){ 
$getReplies = $handler->query("SELECT * FROM replies WHERE threadId='$gT->threadId'"); ?>

<div style="background:#ffffff;padding:15px 25px;border:1px solid #e8e8e8;border-top:0;font-size:14px;" class="gray-hover">
<div class="row valign-wrapper" style="margin-bottom:0;">
<div class="col s8 m8 l8 valign">
<a href="./Topic?id=1" style="color:#333;">
<div style="font-size:16px;font-weight:500;"><? echo $gT->threadTitle ?></div>
<div class="chip">
    <img src="/Market/Storage/Avatar.png" alt="Contact Person">
    <? echo $gT->threadAdmin ?>
    
  </div>
</a>
</div>
<div class="col s2 m2 l1 center-align valign" style="color:#777;">
<? echo $getReplies->rowCount(); ?></div>
<div class="col s2 m2 l1 center-align valign" style="color:#777;">
<? echo $getReplies->rowCount(); ?></div>
<div class="col s12 m12 l2 valign right-align hide-on-med-and-down">

<div class="chip">
    <img src="/Market/Storage/Avatar.png" alt="Contact Person">
    Username
    
  </div>
</div>
</div>
</div>

<? } ?>

</div>