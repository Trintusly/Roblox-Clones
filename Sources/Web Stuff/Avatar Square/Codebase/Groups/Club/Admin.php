<?php
include($_SERVER['DOCUMENT_ROOT']."/header.php");
$id = $_GET['id'];
$getGroup = $handler->query("SELECT * FROM groups WHERE id='$id'");
$gG = $getGroup->fetch(PDO::FETCH_OBJ);
if($myu->username==$gG->owner){
?>
<div class="light-blue lighten-1" style="color:white;padding:15px 25px;">
<div style="font-size:18px;">Group Admin</div>
</div>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<div class="content-box"></br>
<form action="" method="post">
<input type="text" name="post" id="post" class="general-textbar" placeholder="Description">

<div style="height:15px;"></div>
<button type="submit" name="save" class="waves-effect waves-light btn light-blue lighten-1" style="display:block;">Post</button>
</form>
</div>
</div></div>

<? if(isset($_POST['save'])){
$body=$_POST["post"];
$hi = $handler->query("UPDATE groups SET description='$body' WHERE id='$id'");
header("Location: /Groups"); } } else { ?>
<h2>You're not allowed here</h2><? } ?>