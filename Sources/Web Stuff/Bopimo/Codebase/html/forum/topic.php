<?php
require("/var/www/html/site/bopimo.php");
if(!$bop->isInteger($_GET['id']) || !$bop->isInteger($_GET['p']))
{
  require("/var/www/html/error/404.php");
  die();
}

$topic = $bop->look_for("sub_forums", ["id" => $_GET['id']]);
$page = $_GET['p'];
if(!$bop->isInteger($page))
{
  die("fail lmao");
}
if(!$topic)
{
  require("/var/www/html/error/404.php");
  die();
}
$limit = 12;
if($page == 1)
{
  $trueP = 0;
} else {
  $trueP = $page * $limit - $limit;
}
$pageName = $topic->name;
$ads = true;
require("/var/www/html/site/header.php");
$sql = "LIMIT {$trueP}," . $limit;
$threads_pinned = $bop->query("SELECT * FROM threads WHERE subforum={$topic->id} AND pinned=1");
$threads_regular = $bop->query("SELECT * FROM threads WHERE subforum={$topic->id} AND pinned=0 AND deleted=0 ORDER BY updated DESC {$sql}");

$count = $threads_regular->rowCount();

$threads_regular = $threads_regular->fetchAll();
$threads_pinned = $threads_pinned->fetchAll();

$threads = array_merge($threads_pinned, $threads_regular);

?>
<style>
a {
	text-decoration: none;
  color: #7660E4;
}
</style>
<div class="content">
  <div class="col-1-1">
    <div style="background-color:#f7f7f7;height:22.5px;border: 1px solid #7660E4; width:calc(100% - 12px); padding:5px; margin-bottom: 10px;border-radius:5px;">
			<span style="float:left;margin:0px;"><a href="/forum">Forum</a> / <a href="#"><?=$topic->name?></a></span>
      <?php
      if($bop->logged_in())
      {
        ?>
        <span style="float:right;margin:0px;text-align:right;"><a href="/forum/create_thread.php?id=<?=$topic->id?>">Create Thread</a></span>
        <?php
      }
      ?>
		</div>
    <?php
    ?>
		<div class="forum-topic">
			<div class="title">
				<div class="col-8-12">
					<?=htmlentities($topic->name)?>
				</div>
				<div class="centered col-1-12">
					UPVOTES
				</div>
				<div class="centered col-1-12">
					REPLIES
				</div>
        <div class="centered col-2-12">
					LAST UPDATED
				</div>
			</div>


		<?php
    if($count == 0)
    {
      ?>
      <div class="banner danger centered">
        No results.
      </div>
      <?php
    }
            foreach($threads as $a)
            {
              $thread = (object) $a;
              $user = $bop->get_user($thread->author, ["username", "id"]);
              $avatar = $bop->avatar($user->id);
              $replies = $bop->query("SELECT COUNT(*) FROM replies WHERE thread=?", [$thread->id])->fetchColumn();

              if($thread->latest_reply == 0)
              {
                $newest = "<a href='/profile/{$user->id}'>" . $bop->trueUsername($user->id) . "</a> created this thread <b>" . $bop->timeAgo($thread->created) . "</b>";
              } else {
                $reply = $bop->look_for("replies", ["id" => $thread->latest_reply]);
                $replyUser = $bop->get_user($reply->author);
                $newest = "<a href='/profile/{$replyUser->id}'>" . $bop->trueUsername($replyUser->id) . "</a>  replied <b>" . $bop->timeAgo($reply->created) . "</b>";
              }
              ?>
              <div class="card border <?=($thread->pinned == 1) ? "pinned" : ""?> <?=($thread->locked == 1) ? "locked" : ""?>" style="margin-bottom:7px;">
				<div class="col-8-12">
          <img src="https://storage.bopimo.com/heads/<?=$avatar->headshot?>.png" height="50" style="float:left;margin-left:2.5px;margin-right:10px;border-radius:100px;">
					<div class="subforum-title">
						<?php
            if($thread->pinned == 1)
            {
              ?>
              <span style="color:#7660E4"><i class="fas fa-thumbtack" aria-hidden="true"></i></span>
              <?php
            }
            ?><a href="/forum/t/<?=$thread->id?>/1"><?=($thread->deleted == 0) ? htmlentities($thread->title) : "[Deleted]"?></a>
					</div>
					<div class="subforum-description">
						Posted by <a class="creator" href="/profile/<?=$user->id?>"><?=htmlentities($user->username)?></a> <?=$bop->timeAgo($thread->created)?>
					</div>
				</div>
				<div class="centered col-1-12">
					<?=$thread->upvotes?>
				</div>
				<div class="centered col-1-12">
					<?=$replies?>
				</div>
        <div class="centered col-2-12">
					<?=$newest?>
				</div>
			</div>
              <?php
            }
          ?>
          <?php
          if($page > 1)
          {
            ?>
            <span style="float:left;"><a href="/forum/b/<?=$topic->id?>/<?=$page - 1?>" class="button success">Previous Page</a></span>
            <?php
          }
          if($count == $limit) {
            ?>
            <span style="float:right;"><a href="/forum/b/<?=$topic->id?>/<?=$page + 1?>" class="button success">Next Page</a></span>
            <?php
          }
          ?>
		  </div>
  </div>
</div>
<?php $bop->footer(); ?>
