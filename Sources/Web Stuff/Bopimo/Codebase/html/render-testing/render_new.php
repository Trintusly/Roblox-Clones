<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
//require("/var/www/html/render-testing/render-class.php");
$count = $bop->query("SELECT COUNT(*) FROM avatar WHERE rendered='false' AND (hat1!=0 OR hat2!=0 OR hat3!=0 OR face!=0 OR shirt!=0 OR pants!=0 OR tshirt!=0)", [])->fetchColumn();
$now = $bop->query("SELECT avatar.user_id FROM avatar WHERE rendered='false' AND (hat1!=0 OR hat2!=0 OR hat3!=0 OR face!=0 OR shirt!=0 OR pants!=0 OR tshirt!=0) LIMIT 0,1", [], true)[0];
$blender = new blender;
$blender->renderAvatar($now['user_id']);
$newCount = $count - 1;
echo "done. {$newCount} to go.";
?>
<script>
location.reload();
</script>
