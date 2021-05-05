<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$req = $_POST['req'];
$tid = $_POST['thread'];

if(!isset($req) || !isset($tid))
{
  die("bad request (no request)");
}

require("/var/www/html/site/bopimo.php");

if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {

		$localUser = $bop->local_info();
		$upvote = $bop->look_for("upvotes", ["author" => $localUser->id, "thread" => $tid]);
		$thread = $bop->look_for("threads", ["id" => $tid]);

    if($bop->isBanned($localUser->id))
    {
      die();
    }

		if($thread == false)
		{
		  die("bad request (thread not found)");
		}

		if($thread->author == $localUser->id)
		{
		  die("bad request (cannot upvote / downvote own post)");
		}

		if ($bop->tooFast(5)) {
		  die("You are upvoting/liking too fast (try waiting a few seconds)");
		}

		$threadAuthor = $bop->look_for("users", ["id" => $thread->author]);
		if($upvote != false)
		{
		  if($upvote->author != $localUser->id)
		  {
			die("bad request");
		  }

		  $bop->query("DELETE FROM upvotes WHERE id=?", [$upvote->id]);
		  switch($upvote->type)
		  {
			case "0": //thread was liked
			  $bop->update_("threads", ["upvotes" => $thread->upvotes - 1], ["id" => $thread->id]);
			  $bop->update_("users", ["upvotes" => $threadAuthor->upvotes - 1], ["id" => $threadAuthor->id]);
			  break;
		  }
		  $bop->updateFast();
		} else {
		  switch($req)
		  {
			case "0": //upvote the thread
			  $bop->update_("threads", ["upvotes" => $thread->upvotes + 1], ["id" => $thread->id]);
			  $bop->update_("users", ["upvotes" => $threadAuthor->upvotes + 1], ["id" => $threadAuthor->id]);
			  $upvote = $bop->insert("upvotes", [
				"author" => $localUser->id,
				"thread" => $thread->id,
				"time" => time(),
				"type" => "0"
			  ]);
			  break;
			case "1": //downvote the thread
			  $bop->update_("threads", ["upvotes" => $thread->upvotes + 1], ["id" => $thread->id]);
			  $bop->update_("users", ["upvotes" => $threadAuthor->upvotes + 1], ["id" => $threadAuthor->id]);
			  $upvote = $bop->insert("upvotes", [
				"author" => $localUser->id,
				"thread" => $thread->id,
				"time" => time(),
				"type" => "0"
			  ]);
			  break;
		  }
		  var_dump($upvote);
		  $bop->updateFast();
		}
	}
}
?>
