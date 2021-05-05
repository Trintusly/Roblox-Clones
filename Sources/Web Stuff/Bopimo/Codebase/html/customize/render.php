<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->loggedIn())
{
  die();
}

$user = $bop->local_info();
$avatar = $bop->avatar($user->id);

$blender = new blender;
$blender->renderAvatar($user->id);
$newAvatar = $bop->avatar($user->id);
?>
<img src="https://storage.bopimo.com/avatars/<?=$newAvatar->cache?>.png" class="image">
