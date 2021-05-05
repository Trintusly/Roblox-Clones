<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/var/www/html/site/bopimo.php");
if (isset($_POST["token"])) {
	if ($bop->checkToken($_POST["token"])) {
		if(!$bop->logged_in())
		{
		  die("no");
		}

		$desc = $_POST["desc"];
		$tid = $_POST['tid'];
		$user = $bop->local_info();

		if($bop->isBanned($user->id))
		{
			die();
		}

		/*if($bop->antiJake($desc) || !is_numeric($tid))
		{
			die();
		}*/

		if(strlen($desc) < 5 || strlen($desc) > 4000)
		{
		  die("1");
		}

		if($bop->tooFast())
		{
		  die("2");
		}

		$thread = $bop->look_for("threads", ["id" => $tid]);

		if(!$thread)
		{
		  die("Bad request");
		}

		if($thread->deleted == "1")
		{
			die("Bad request");
		}

		$time = time();

		$bop->update_("users", ["lastaction" => $time, "posts" => $user->posts + 1], ["id" => $user->id]);

		$reply = (array) $bop->insert("replies", [
		  "desc" => $desc,
		  "created" => time(),
		  "thread" => $thread->id,
		  "author" => $user->id,
		  "subforum" => $thread->subforum
		]);

		$bop->update_("threads", ["latest_reply" => $reply['id'], "updated" => $time], ["id" => $reply[0]['thread']]);
		$otherAvatar = $bop->avatar($user->id);
		$bop->notify($thread->author, $user->username." replied to your thread.", "https://storage.bopimo.com/avatars/".$otherAvatar->cache.".png", "/forum/t/".$thread->id."/1");
		die("yes");
	}
}
die("3");
?>
