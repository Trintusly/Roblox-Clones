<? include "../../header.php"; 
$id = $_GET['id'];
$thread = $handler->query("SELECT * FROM threads WHERE threadId=" . $id);
$replies = $handler->query("SELECT * FROM replies WHERE threadId=" . $id);
$gT = $thread->fetch(PDO::FETCH_OBJ);
?> <div class="container" style="width:100%;">

<? if ($myu->admin == "true"){ ?>
<a href="/Forum/Thread/delete.php?id=<? echo $id?>" class="waves-effect waves-light btn">Delete Thread</a>
<div style="padding-top:5px;">
<? } ?>

<div class="light-blue lighten-1" style="color:white;padding:15px 25px;">
<div style="font-size:18px;"><? echo $gT->threadTitle ?></div>
</div>
<div class="content-box" style="background:#ffffff; border:1px solid #e8e8e8; border-top:0;border-radius:0;"></br>
<div class="row">
<div class="col s3 center-align">
<div title="Last seen 1 day ago" style="background:#c2c2c2;width:10px;height:10px;border-radius:10px;display:inline-block;"></div>
&nbsp;<a href="/Profile?username=<? echo $gT->threadAdmin ?>"><? echo $gT->threadAdmin ?><br></a>
<? $adminn = $handler->query("SELECT * FROM users WHERE username='$gT->threadAdmin'"); 
$admin = $adminn->fetch(PDO::FETCH_OBJ); ?>
<a href="/Profile?username=<? echo $gT->threadAdmin ?>">
<iframe frameborder="0" src="/avatar.php?id=<? echo $admin->id ?>" scrolling="no" style=" width: 200px; height: 200px"></iframe>
</a>
</div>
<div class="col s9">
<div class="row" style="margin-bottom:0;">
<div class="col s6">
</div>
</div>
<div style="word-break:break-word;"><? echo $gT->threadBody ?></div>
</div>
</div></br>
</div>

<? while($gR = $replies->fetch(PDO::FETCH_OBJ)){ ?>
<div class="content-box" style="background:#ffffff; border:1px solid #e8e8e8; border-top:0;border-radius:0;"></br>
<div class="row">
<div class="col s3 center-align">
<div title="Last seen 1 day ago" style="background:#c2c2c2;width:10px;height:10px;border-radius:10px;display:inline-block;"></div>
&nbsp;<a href="/Profile?username=<? echo $gR->postBy ?>"><? echo $gR->postBy ?><br></a>
<? $poster = $handler->query("SELECT * FROM users WHERE username='$gR->postBy'"); 
$postby = $poster->fetch(PDO::FETCH_OBJ); ?>
<a href="/Profile?username=<? echo $gR->postBy ?>">
<iframe frameborder="0" src="/avatar.php?id=<? echo $postby->id ?>" scrolling="no" style=" width: 200px; height: 200px"></iframe>
</a>
</div>
<div class="col s9">
<div class="row" style="margin-bottom:0;">
<div class="col s6">
</div>
</div>
<div style="word-break:break-word;"><? echo $gR->postText ?></div>
</div>
</div></br>
</div>
<? } ?>

<center></br><a href="reply.php?id=<? echo $id ?>" class="waves-effect waves-light btn grey darken-2" style="display:block; width:150px;">Reply</a></br>
<? include "../../footer.php"; ?>