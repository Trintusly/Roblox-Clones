<?php
include 'func/avatarconnect.php';

$time = time();

if($user->banned != 1) {
    header("Location: ../index.php");
}

$findBan = $conn->query("SELECT * FROM `bans` WHERE `banned_user`='$user->id'");
$banInfo = mysqli_fetch_object($findBan); 
if($time > $banInfo->ban_time) {
$conn->query("UPDATE users SET banned='0' WHERE id='$user->id'");
echo"You are now unbanned. Please refresh your page";
//need to remove from ban table too (lazy)
}
echo "
<!doctype html>
<title>Site Maintenance</title>
<style>
  body { text-align: center; padding: 150px; }
  h1 { font-size: 50px; }
  body { font: 20px Helvetica, sans-serif; color: #333; }
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1>UH OH! Youve been banned ".$user->username."!</h1>
    <div>
        <p>reason: ".$banInfo->reason."</p>
        <p>You will been unbanned on ".date('m/d/y', $banInfo->ban_time).", thanks for playing! &mdash; <a href='logout.php?logout'>logout</a></p>
    </div>
</article>
";
?>