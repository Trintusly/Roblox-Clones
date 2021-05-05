<?php
$ignore = true;
require("/var/www/html/site/bopimo.php");
if($bop->logged_in())
{
  die(header("location: /home"));
}
require("/var/www/html/site/header.php");
?>
<center><h1>Welcome to Bopimo!</h1></center>
<div class="content">
  <div class="col-1-1">
    <div class="card b">
      <div class="top centered">
        This page is under construction
      </div>
      <div class="body centered">
        For now, you can go here:
        <br>
        <a href="/account/login" class="button success">Login</a><a class="button danger" href="/account/login" style="margin-left:5px;">Register</a>
      </div>
    </div>
  </div>
</div>
