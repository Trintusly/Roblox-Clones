<?php
$ads = true;
if (!isset($_GET["id"]) || !is_numeric($_GET['id']) || empty($_GET['id']) || empty($_GET['p'])) {
	require("/var/www/html/error/404.php");
	die();
}
require("/var/www/html/site/bopimo.php");
/*if(!$bop->logged_in())
{
	die(header("location: /account/login"));
}*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!is_numeric($_GET['id']) || !is_numeric($_GET['p']))
{
	die();
}

$id = (int) $_GET["id"];
$page = (int) $_GET['p'];
$limit = 7;
if($page <= 1)
{
  $trueP = 0;
} else {
  $trueP = $page * $limit - $limit;
}
$sql = "LIMIT {$trueP}," . $limit;
$thread = $bop->query("SELECT * FROM threads WHERE id = ?", [$id]);
if($thread->rowCount() == 0){
	require("/var/www/html/error/404.php");
	die();
}
$thread = (object) $thread->fetchAll(PDO::FETCH_ASSOC)[0];
$owner = $bop->get_user($thread->author, ["username", "id", "posts", "joined", "upvotes"]);
$localUser = $bop->local_info();
if($bop->isBanned($owner->id) && !$bop->isAllowed($localUser->id))
{
	require("/var/www/html/error/404.php");
	die();
}
$pageName = htmlentities($thread->title) . " - Thread";
$avatar = $bop->avatar($thread->author);
?>
<meta charset="UTF-8">
<meta property="og:site_name" content="bopimo.com">
<meta property="og:image" content="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png">
<meta name="description" content="<?=htmlentities(substr($thread->body, 0, 200))?>">
<meta name="keywords" content="Bopimo, Bopimo thread, Bopimo Game">
<meta name="author" content="<?=htmlentities($owner->username)?>">
<?php
require("/var/www/html/site/header.php");
$topic = $bop->look_for("sub_forums", [
	"id" => $thread->subforum
]);
$avatar = $bop->avatar($thread->author);
?>
<style>
	a {
		text-decoration: none;
		color: #7660E4;
	}
</style>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>
<div class="content">
  <div class="col-1-1">
		<div style="background-color:#f7f7f7;height:22.5px;border: 1px solid #7660E4; width:calc(100% - 12px); padding:5px; margin-bottom: 10px;border-radius:5px;">
			<span style="float:left;margin:0px;"><a href="/forum">Forum</a> / <a href="/forum/b/<?=$topic->id?>/1"><?=$topic->name?></a> / "<a href="#"><?=($thread->deleted == "0") ? htmlentities($thread->title) : "[Deleted]"?></a>" by <a href="/profile/<?=$owner->id?>"><?=$bop->trueUsername($owner->id)?></a></span>
		</div>
		<div class="forum-topic">
			<div class="title">
				<?=($thread->deleted == "0") ? htmlentities($thread->title) : "[Deleted]"?>
				<?php
				if($bop->logged_in())
				{
					$upvote = $bop->look_for("upvotes", [
						"author" => $localUser->id,
						"thread" => $thread->id
					]);
					?>
					<span style="float:right;">
					<?php
					if(!$upvote && $thread->author != $localUser->id)
					{
						?>
						<i class="fa fa-thumbs-o-up upvote hover" aria-hidden="true" title="Upvote this post" req="0"></i>
						<?php
					} elseif($thread->author == $localUser->id){

					} elseif($upvote->type == 0) { //
						?>
						<i class="fa fa-thumbs-up upvote hover" aria-hidden="true" title="You upvoted this post <?=$bop->timeAgo($upvote->time)?>." req="0"></i>
						<?php
					} elseif($upvote->type == 1) {
						?>

						<?php
					}
					?>
					 <span title="The number of upvotes for this thread.">(<?=$thread->upvotes?>)</span>
					</span>
					<?php
				}
				?>
			</div>
			<div class="card border" style="margin-bottom:0px;">
				<div class="col-3-12">
					<div class="centered">
						<a href="/profile/<?=$owner->id?>">
							<img src="https://storage.bopimo.com/avatars/<?=$avatar->cache?>.png" style="margin-top:10px;width:100%;" />
							<br><br>
							<?=htmlentities($owner->username)?>
						</a>
						<br>
						Posts: <?=$owner->posts?>
						<br>
						Total Upvotes: <?=$owner->upvotes?>
						<br>
						Joined: <?=substr($owner->joined, 5, 2) . "/" . substr($owner->joined, 8, 2) . "/" . substr($owner->joined, 0, 4)?>
					</div>
				</div>
				<div class="col-9-12">
					<div style="color:#333;font-size:0.9rem;">Posted <?=$bop->timeAgo($thread->created)?></div>
					<div style="float:left;word-wrap: break-word;margin-top:5px;line-height:25px;">
						<?=($thread->deleted == "0") ? nl2br($bop->bbCode($thread->body)) : "[Deleted]"?>
					</div>
				</div>
				<?php
				if($bop->logged_in()) {
					if(intval($localUser->admin) > 0)
					{
						?>
						<div class="col-1-1">
							<button class="button danger" id="delete"><?=($thread->deleted == "0") ? "Delete" : "Undelete"?></button>
						</div>
						<script>
						$(document).ready(function(){
							$("#delete").click(function(){
								$.post("/admin/delete_thread.php", {id: <?=$thread->id?>}, function(reply){
									location.reload();
								});
							});
						});
						</script>
						<?php
					}
				}
				?>
			</div>
		</div>

		<?php
		$deleted = $thread->deleted;
		$replies = $bop->query("SELECT * FROM replies WHERE thread=? ORDER BY id ASC {$sql}", [$thread->id]);
		$replyCount = $replies->rowCount();
		if($replyCount == 0)
		{
			?>
			<div class="banner danger">No replies</div>
			<?php
		} else {
			foreach($replies as $reply)
			{
				$reply = (object) $reply;
				$user = $bop->get_user($reply->author);
				$user_avatar = $bop->avatar($user->id);
				?>
				<div class="forum-topic">
					<div class="card border" style="margin-bottom:0px;">
						<div class="col-3-12">
							<div class="centered">
								<a href="/profile/<?=$user->id?>">
									<img src="https://storage.bopimo.com/avatars/<?=$user_avatar->cache?>.png" style="margin-top:10px;width:100%;" />
									<br><br>
									<?=$bop->trueUsername($user->id)?>
								</a>
								<br>
								Posts: <?=$user->posts?>
								<br>
								Total Upvotes: <?=$user->upvotes?>
								<br>
								Joined: <?=substr($user->joined, 5, 2) . "/" . substr($user->joined, 8, 2) . "/" . substr($user->joined, 0, 4)?>
							</div>
						</div>
						<div class="col-9-12">
							<div style="color:#333;font-size:0.9rem;">Posted <?=$bop->timeAgo($reply->created)?></div>
							<div style="float:left;margin-top:5px;word-wrap: break-word;line-height:25px;">
								<?=($reply->deleted == "0") ? nl2br($bop->bbCode($reply->desc)) : "[Deleted]"?>
							</div>
						</div>
						<?php
						if($bop->logged_in())
						{
							if(intval($localUser->admin) > 0)
							{
								?>
								<div class="col-1-1">
									<button class="button danger deleteR" reply="<?=$reply->id?>"><?=($reply->deleted == "0") ? "Delete" : "Undelete"?></button>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
				<?php
			}
		}
		if($bop->logged_in()) {
			if(intval($localUser->admin) > 0)
			{
				?>
				<script>
				$(document).ready(function(){
					$(".deleteR").click(function(){
						$.post("/admin/delete_reply.php", {id: $(this).attr("reply")}, function(reply){
							location.reload();
						});
					});
				});
				</script>
				<?php
			}
		}
		if($bop->logged_in() && (($thread->deleted == "0" && intval($localUser->admin) == 0) || intval($localUser->admin) >= 1)){
			?>
			<div class="banner danger hidden" id="status"><i class="fa fa-spinner fa-spin"></i> Loading</div>
			<div class="col-1-1">
				<div class="col-4-12">
					<?php
					if($page > 1 && $replyCount > 1)
					{
						?>
						<a href="/forum/t/<?=$thread->id?>/<?=$page - 1?>" class="button success">Previous Page</a>
						<?php
					}
					?>
				</div>
				<div class="col-4-12 centered">
					<input type="submit" class="button success" id="start_reply" value="Reply To This Thread">
				</div>
				<div class="col-4-12">
					<?php
					if($replyCount >= $limit)
					{
						?>
						<a href="/forum/t/<?=$thread->id?>/<?=$page + 1?>" class="button success" style="float:right;">Next Page</a>
						<?php
					}
					?>
				</div>
			</div>
			<div class="dotted-body hidden">
				<form id="form">
					<textarea class="width-100" id="desc" placeholder="Reply Here" style="height:200px;"></textarea>
					<input type="submit" class="button success" value="Reply">
				</form>
			</div>
			<?php
		}
		?>
	</div>
</div>

<script>
$(document).ready(function(){
	$("#start_reply").click(function(){
		$("#start_reply").addClass("hidden");
		$(".dotted-body").removeClass("hidden");
	});
	$("#form").submit(function(e){
		e.preventDefault();
		$("#status").removeClass("hidden");
		$.post("/forum/reply.php", {
			desc: $("#desc").val(),
			tid: <?=$thread->id?>,
			token: $("meta[name=token]").attr("content")
		}, function(reply){
			switch(reply)
			{
				case "1":
					$("#status").html("A reply must be 5-4000 characters long.");
					break;
				case "2":
					$("#status").html("You are posting too fast!");
					break;
				case "3":
					$("#status").html("Missing or invalid csrf token");
					break;
				case "yes":
					$("#status").html('<i class="fa fa-spinner fa-spin"></i> Reloading...');
					location.reload();
					break;
				default:
					$("#status").html('Unknown Error');
					//alert($("meta[name=token]").attr("content"));
					//location.reload();
					break;
			}
		});
	});


	$(".upvote").click(function(){
		$.post("/forum/upvote.php", {
			req: $(this).attr("req"),
			thread: <?=$thread->id?>,
			token: $("meta[name=token]").attr("content")
		}, function(reply){
			location.reload();
		});
	});
});
</script>
<?php $bop->footer(); ?>
