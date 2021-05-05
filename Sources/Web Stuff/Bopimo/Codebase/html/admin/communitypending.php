<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("/var/www/html/site/bopimo.php");
if(!isset($_POST['req']))
{
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
	$communities = $bop->query("SELECT * FROM community WHERE pending=0", [], true);
	foreach($communities as $community)
	{
	  ?>
	  <div class="card border" id="main<?=$community['id']?>">
		<div class="col-2-12">
			<img class="image" src="https://storage.bopimo.com/community/<?=$community['cache']?>.png">
		</div>
		<div class="col-6-12">
			<div class="page-title"><?=htmlentities($community['name'])?></div>
		</div>
		<div class="col-4-12">
			<button class="button success" id="approve" cid="<?=$community['id']?>">Approve</button><br><button class="button danger" id="decline" cid="<?=$community['id']?>">Decline</button>
		</div>
	  </div>
	  <?php
	}
	?>
	<script>
		$(document).ready(function(){
			$("#approve").click(function(){
				$.post("/admin/communitypending.php", {
					"cid": $(this).attr("cid"),
					"req": "true",
					"type": "approve"
				}, function(reply){
					$("#main"+$(this).attr("cid")).remove();
				});
			});

			$("#decline").click(function(){
				$.post("/admin/communitypending.php", {
					"cid": $(this).attr("cid"),
					"req": "true",
					"type": "decline"
				}, function(reply){
					$("#main"+$(this).attr("cid")).remove();
				});
			});
		});
	</script>
	<?php
} else {
	require("/var/www/html/api/rest.php");
	if(!isset($_POST['cid']) || !isset($_POST['type']))
	{
		$rest->error("Invalid request.");
		die();
	}
	if(!is_numeric($_POST['cid']) || !is_string($_POST['type']))
	{
		$rest->error("Invalid request.");
		die();
	}
	$cid = (int) $_POST['cid'];
	require("/var/www/html/api/community/class.php");
	$community = $com->get($cid);
	if(is_bool($community))
	{
		$rest->error("Invalid request.");
		die();
	}
	if($_POST['type'] == "approve")
	{
		$bop->update_("community", [
			"pending" => "1"
		], [
			"id" => $cid
		]);
	} elseif($_POST['type'] == "decline") {
		$owner = $com->getOwner($community->id);
		$bop->update_("users", ["bop" => $owner->bop + 25], ["id" => $owner->id]);
		$com->deleteCommunity($community->id);
	} else {
		$rest->error("Bad request.");
		die();
	}
	$rest->success(["Successfully approved community."]);
}
?>
