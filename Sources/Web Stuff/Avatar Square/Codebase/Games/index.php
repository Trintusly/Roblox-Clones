<? include"../header.php"; 
$game = $handler->query("SELECT * FROM games");
?>
</center>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<script>
		document.title = "Games | BLOXCreate";
	</script>
<div class="content-box">
<div class="header-text">Games have been released.</div></br>
<div style="font-size:16px;">We're working on finishing a few bugs, but this is our game system! Sometime in the near future we will create more interactive games where you and other players can interact with one another. You can join a game by clicking on the game you would like to join below and clicking the play button!</div>
</div>
<div style="height:25px;"></div>
<div class="header-text">Games</div><div style="height:10px;"></div>
<div class="content-box">
<div class="row">
<?
while($gT = $game->fetch(PDO::FETCH_OBJ)){ ?>
<div class="col s12 m12 l2">
<a href="../Games/Place?id=<?echo "$gT->id"; ?>"><img src="<? echo " $gT->image"; ?>" style="display:block;height:100px;width:100px;"></a>
<a href="../Games/Place?id=<?echo "$gT->id"; ?>"><div style="padding-top:3px;color:#444444;font-size:16px;"><? echo " $gT->title"; ?></div></a>
<div style="font-size:14px;color:#666666;"><a href="#"><? echo " $gT->owner"; ?></a></div>
<div style="color:#ED3737;font-size:13px;"><? echo " $gT->playing"; ?> playing</div>
</div>
<? } ?>
</div>
</div>
</div>
</div>
<? include "../footer.php"; ?>