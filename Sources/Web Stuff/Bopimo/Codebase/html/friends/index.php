<?php 

require "../site/header.php";

if(!$bop->logged_in())
{
	die(header("header: /account/login"));
}

$sentCount = $bop->query("SELECT COUNT(id) as total FROM friends WHERE friends.from = ? AND friends.status = 0;", [$_SESSION["id"]])->fetchColumn();
$pendingCount = $bop->query("SELECT COUNT(id) as total FROM friends WHERE friends.to = ? AND friends.status = 0;", [$_SESSION["id"]])->fetchColumn();
$totalFriends = $bop->query("SELECT COUNT(id) as total FROM friends WHERE (friends.from = :id OR friends.to = :id) AND friends.status = 1;", ["id" => $_SESSION["id"]])->fetchColumn();

?>

<div class="page-title">
	Friends
</div>
<div id="response">
</div>
<div class="tab-container" style="margin-bottom: 6px;">
	<div class="tab col-1-3 current" id="getPending">
		Recieved Requests (<span><?=$pendingCount?></span>)
	</div>
	<div class="tab col-1-3" id="getSent">
		Sent Requests (<span><?=$sentCount?></span>)
	</div>
	<div class="tab col-1-3" id="getFriends">
		Current Friends (<span><?=$totalFriends?></span>)
	</div>
</div>
<div class="card border" id="friendsHolder">
</div>
<script src="/js/friends.js"></script>
<?php 
require "../site/footer.php";
?>