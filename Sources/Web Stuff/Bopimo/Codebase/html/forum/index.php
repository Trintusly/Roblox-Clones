<?php
$pageName = "Forum";
$ads = true;
require("/var/www/html/site/header.php");
?>
<style>
a {
  text-decoration: none;
  color: black;
}
</style>
<div class="content">

      <div class="forum-topic">
		<div class="title">
			<div class="col-9-12">
			SUBFORUM NAME
			</div>
			<div class="centered col-1-12">
				THREADS
			</div>
			<div class="centered col-1-12">
				REPLIES
			</div>
      <div class="centered col-1-12">
				UPVOTES
			</div>
		</div>
		<?php

		$forums = (object) $bop->query("SELECT * FROM sub_forums")->fetchAll();
		foreach ($forums as $a)
		{
		$forum = (object) $a;

    $threads = $bop->query("SELECT COUNT(*) FROM threads WHERE subforum=?", [$forum->id])->fetchColumn();
    $replies = $bop->query("SELECT COUNT(*) FROM replies WHERE subforum=?", [$forum->id])->fetchColumn();
		?>
		<div class="subforum">
			<div class="col-9-12">
				<div class="subforum-title">
					<a href="/forum/b/<?=htmlentities($forum->id)?>/1"><?=htmlentities($forum->name)?></a>
				</div>
				<div class="subforum-description">
					<?=htmlentities($forum->about)?>
				</div>
			</div>
			<div class="centered col-1-12">
				<?=$threads?>
			</div>
			<div class="centered col-1-12">
				<?=$replies?>
			</div>
      <div class="centered col-1-12">
				0
			</div>
		</div>
		<?php
		}
		?>
	  </div>

</div>

<?php $bop->footer(); ?>
