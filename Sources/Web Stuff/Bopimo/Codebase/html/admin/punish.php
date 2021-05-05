<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
require("/var/www/html/api/rest.php");
if(!$bop->logged_in())
{
  die();
}
$user = $bop->local_info(["id", "admin"]);
if(!$bop->isAllowed($user->admin, 1))
{
  $rest->error("Priveleges not high enough.");
  die();
}
if(!isset($_POST['req']))
{
  ?>
  <div class="banner success hidden">
    Test
  </div>
  <div class="banner danger hidden">
    Test
  </div>
  <form method="POST" style="text-align:center;" id="punish">
    <select id="rule" name="rule" style="width:100%;">
      <option value="1">Other</option>
      <option value="2">Sexual / Pornographic Content</option>
      <option value="3">Too personal information</option>
      <option value="4">Harrassment</option>
      <option value="5">Off-Site Link</option>
    </select>
    <input type="number" id="uid" placeholder="User ID" style="width:100%">
    <textarea id="note" style="resize:none;width:100%;height:300px;" placeholder='"Moderator says" (Be sure to include quotes, and other things.)'></textarea>
    <input type="checkbox" id="super" <?=($bop->isAllowed($user->id, 1)) ? '>Super Ban This User<br>' : 'class="hidden">'?>

    <input type="submit" class="button success" value="Punish">
  </form>
  <script>
  function error(msg)
  {
    $(".danger").text(msg);
    $(".danger").removeClass("hidden");
    window.setTimeout(function(){
      $(".danger").addClass("hidden");
    }, 3000);
  }
  function success(msg)
  {
    $(".banner.success").text(msg);
    $(".banner.success").removeClass("hidden");
    window.setTimeout(function(){
      $(".banner.success").addClass("hidden");
    }, 3000);
  }
  $("#punish").submit(function(event){
    event.preventDefault();
    $.post("punish.php", {req: true,
      rule: $("#rule").val(),
      uid: $("#uid").val(),
      super: $('#super').is(':checked'),
      note: $("#note").val()
    }, function(reply){
      if(reply.status == "ok")
      {
        success("Punished this user.");
      } else {
        error(reply.error);
      }
    });
  });
  </script>
  <?php
} else {
  if(empty($_POST['uid']) || empty($_POST['rule']))
  {
    $rest->error("All fields required.");
    die();
  }
  if(empty($_POST['note']))
  {
    $note = "Thank you for playing Bopimo!";
  } else {
    $note = (string) $_POST['note'];
  }
  if(!is_string($_POST['note']) || !is_numeric($_POST['uid']) || !is_numeric($_POST['rule']))
  {
    $rest->error("Bad request. #3");
    die();
  }

  if(empty($_POST['super']))
  {
    $rest->error("Bad request. #2");
    die();
  }
  $super = $_POST['super'];
  $uid = (int) $_POST['uid'];

  $rule = (int) $_POST['rule'];
  $localUser = $bop->local_info();
  $rules = array(
    1 => "Other",
    2 => "Sexual / Pornographic Content",
    3 => "Too personal information",
    4 => "Harassment",
    5 => "Off-Site Link"
  );
  if(!isset($rules[$rule]))
  {
    $rest->error("Bad request. #1");
    die();
  }
  $user = $bop->get_user($uid);
  if(!$user)
  {
    $rest->error("User does not exist.");
    die();
  }
  $lookFor = $bop->query("SELECT * FROM punishment WHERE user=? AND removed=0 ORDER BY level DESC LIMIT 0,1", [$uid]);
  if($lookFor->rowCount() == 0)
  {
    $level = 0;
    $nextLevel = 1;
  } elseif($lookFor->rowCount() == 1)
  {
    $punish = (object) $lookFor->fetchAll()[0];
    $count = (int) $punish->level;
    $level = $count;
    $nextLevel = $count + 1;
  }


  $time = time();

  $levels = array(
    1 => $time,
    2 => $time,
    3 => $time,
    4 => $time + 86400,
    5 => $time + 86400,
    6 => $time + 259200,
    7 => $time + 259200,
    8 => $time + 604800,
    9 => $time + 604800,
    10 => $time + 2592000,
    11 => 2147483647
  );

  if($super == "false")
  {
    $newPunish = $bop->insert("punishment", [
      "user" => $uid,
      "by" => $user->id,
      "msg" => $note,
      "created_unix" => $time,
      "level" => $nextLevel,
      "expires" => $levels[$nextLevel],
      "rule" => $rule
    ]);
  } else {
    $newPunish = $bop->insert("punishment", [
      "user" => $uid,
      "by" => $user->id,
      "msg" => $note,
      "created_unix" => $time,
      "level" => "11",
      "expires" => 2147483647,
      "rule" => $rule
    ]);
  }
  $bop->insert("admin_logs", [
    "user" => $localUser->id,
    "affected" => $uid,
    "msg" => "punished",
    "type" => "user"
  ]);
  $bop->update_("users", ["hidden" => 1], ["id" => $uid]);
  $rest->success();
}
?>
