<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die(header("location: /account/login"));
}
$localInfo = $bop->local_info();
if(isset($_GET['id'])) {
  if(!is_string($_GET['id'])) {
    require("/var/www/html/error/404.php");
    die();
  }
  $id = $_GET['id'];
  $invite = $bop->look_for("invites", ["uniq" => $_GET['id']]);
  if(!is_bool($invite))
  {
    require("/var/www/html/site/header.php");
    $invited = $bop->look_for("invites_used", ["uid" => $localInfo->id]);
    if(!is_bool($invited))
    {
      ?>
      <div class="banner danger">
        You have redeemed this invite!
      </div>
      <a href="/invites" style="color:#8973f9">
      	<i class="fas fa-chevron-left"></i> Return to invites
      </a>
      <?php
      $bop->footer();
      die();
    }
    if($invite->uses >= 3) {
      ?>
      <div class="banner danger">
        This invite has been used too many times.
      </div>
      <a href="/invites" style="color:#8973f9">
      	<i class="fas fa-chevron-left"></i> Return to invites
      </a>
      <?php
      $bop->footer();
      die();
    }
    $lookIp = $bop->query("SELECT * FROM login INNER JOIN invites_used ON login.user_id = invites_used.uid WHERE login.ip_address = ? AND invites_used.invite = ?", [$_SERVER['REMOTE_ADDR'], $invite->id], true);
    $lookOwner = $bop->query("SELECT * FROM login INNER JOIN invites ON invites.uid = login.user_id WHERE login.ip_address=? AND invites.id=?", [$_SERVER['REMOTE_ADDR'], $invite->id], true);
    if(count($lookIp) > 0 || count($lookOwner) > 0)
    {
      ?>
      <div class="banner danger">
        You have already redeemed a invite already, or this is your invite.
      </div>
      <a href="/invites" style="color:#8973f9">
      	<i class="fas fa-chevron-left"></i> Return to invites
      </a>
      <?php
      $bop->footer();
      die();
    }
    if($invite->uid == $localInfo->id)
    {
      ?>
      <div class="banner danger">
        Bad request.
      </div>
      <a href="/invites" style="color:#8973f9">
      	<i class="fas fa-chevron-left"></i> Return to invites
      </a>
      <?php
      $bop->footer();
      die();
    }
    $userThing = $bop->get_user($invite->uid);
    $bop->insert("invites_used", ["uid" => $localInfo->id, "when" => time(), "invite" => $invite->id]);
    $bop->update_("invites", ["uses" => $invite->uses + 1], ["id" => $invite->id]);
    $bop->update_("users", ["bop" => $localInfo->bop + 5], ["id" => $localInfo->id]);
    $bop->update_("users", ["bop" => $userThing->bop + 5], ["id" => $invite->uid]);
    ?>
    <div class="banner success">
      You have redeemed this invite!
    </div>
    <a href="/invites" style="color:#8973f9">
    	<i class="fas fa-chevron-left"></i> Return to invites
    </a>
    <?php
    $bop->footer();
  } else {
    require("/var/www/html/error/404.php");
    die();
  }
} else {
  require("/var/www/html/site/header.php");
  $invite = $bop->look_for("invites", ["uid" => $localInfo->id]);
  $inviteUsed = $bop->look_for("invites_used", ["uid" => $localInfo->id]);
  ?>
  <div class="page-title">Invite Friends</div>
  <div class="card border">
    Invite your friends to get rewards! 1 invite = you both get 5 bopibits! 3 Maximum uses for your invite, one invite per account.
  </div>
  <?php
  if(is_bool($invite))
  {
    ?>
    <div class="card border">
      It currently looks like you did not create an invite. Create one now and start receiving rewards!
    </div>
    <a href="/invites/create.php" class="button success">Create</a>
    <?php
  } else {
    $invitesUsed = $bop->query("SELECT * FROM invites_used WHERE invite=?", [$invite->id], true);
    ?>
    <div class="page-title">Your invite status</div>
    <input type="text" class="width-100" value="https://www.bopimo.com/invite/<?=$invite->uniq?>">
    <div class="col-1-1">
      <div class="col-4-12 card border centered">
        <h2>Uses</h2>
        <h3><?=$invite->uses?> users have used your invite.</h3>
      </div>
      <div class="col-4-12 card border centered">
        <h2>Total Made</h2>
        <h3>You have made B<?=$invite->uses * 5?></h3>
      </div>
      <div class="col-4-12 card border centered">
        <h2>Logs</h2>
        <?php
        if(is_bool($invitesUsed)) {
          ?>
          No one has used your invite yet!
          <?php
        } else {
          foreach($invitesUsed as $row)
          {
            $user = $bop->get_user($row['uid']);

            ?>
            <div class="col-1-1">
              <a href="/profile/<?=$user->id?>" style="color:black;"><?=htmlentities($user->username)?></a>
            </div>
            <?php
          }
        }
        ?>
      </div>
    </div>
    <?php
  }

  if(is_bool($inviteUsed))
  {
    ?>
    <div class="page-title"><font color="red">You have not used an invite yet.</font></div>
    <?php
  } else {
    ?>
    <div class="page-title"><font color="green">You have used an invite already.</font></div>
    <?php
  }
  $bop->footer();
}
?>
