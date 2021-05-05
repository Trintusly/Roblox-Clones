<?php
$id = $_GET['id'];
include($_SERVER['DOCUMENT_ROOT']."/header.php");
?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<script> document.title = "Send Message | BLOX Create"; </script>
<div class="content-box">
<form action="" method="post">
<input type="text" name="title" id="title" class="general-textbar" placeholder="Title">
<div style="height:15px;"></div>
<input type="text" name="post" id="post" class="general-textbar" placeholder="Body">

<div style="height:15px;"></div>
<button type="submit" name="save" class="waves-effect waves-light btn light-blue darken-2" style="display:block;">Send Message</button>
</form>
</div>
</div>
</div>

<?
if(isset($_POST['save'])){
$hi = $handler->query("INSERT INTO messages (sender, receiver, title, message) VALUES ('$myu->id','$id','".$_POST["title"]."','".$_POST["post"]."')");
} include($_SERVER['DOCUMENT_ROOT']."/footer.php");
?>