<?php
$bannedPage = true;
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$user = $bop->local_info("id");
$banned = $bop->isBanned($user->id);
if(!$banned)
{
  die(header("locaiton: /"));
}
$rules = array(
  1 => "Other",
  2 => "Sexual / Pornographic Content",
  3 => "Too personal information",
  4 => "Harassment",
  5 => "Off-Site Link"
);

$levels = array (
  1 => "1st Warning",
  2 => "2nd Warning",
  3 => "3rd Warning",
  4 => "1st 1 Day Ban",
  5 => "2nd 1 Day Ban",
  6 => "3rd 1 Day Ban",
  7 => "1st 1 Week Ban",
  8 => "2nd 1 Week Ban",
  9 => "3rd 1 Week Ban",
  10 => "1 Month Ban",
  11 => "Termination"
);
require("/var/www/html/site/header.php");
?>
<div class="col-1-1">
  <div class="card b">
    <div class="top">You have been punished.</div>
    <div class="body centered">
      <h1>Punish Level: <?=$levels[$banned->level]?></h1>
      <b>Moderator Note:</b>
      <br><br>
      <?=nl2br(htmlentities($banned->msg))?>
      <?php
      if(($banned->expires - time()) <= 0)
      {
        ?>
        <br>
        <a class="button success" href="/home/agree.php">I acknowledge</a>
        <?php
      } else {
        ?>
        <br>
        <i>You have <?=$bop->timeLeft($banned->expires)?></i>
        <?php
      }
      ?>
    </div>
  </div>
</div>
<?php require("/var/www/html/site/footer.php"); ?>
