<? include "../header.php";
$items = $handler->query("SELECT * FROM items ORDER BY id DESC");
?>
<div class="container" style="width:100%;">
<div class="row">
<div class="col s12 m2 l2">
<select class="browser-default market-dropdown" onchange="updateSelect(this.value)">
<option value="all">All</option>
<option value="head">Heads</option>
<option value="hat" selected="">Hats</option>
<option value="face">Faces</option>
<option value="accessory">Accessories</option>
<option value="tshirt">T-Shirts</option>
<option value="shirt">Shirts</option>
<option value="pants">Pants</option>
</select>
</div>
<div class="col s12 m10 l10">
<input type="text" class="market-searchbar" placeholder="Search and press enter" onchange="updateSearch(this.value)">
</div>
</div>
<div id="search-market" style="display:none;">
<div class="header-text">Search Results</div>
<div style="height:10px;"></div>
<div class="content-box">
<div class="row">
<div class="search-waiting" id="search-waiting">
<i class="material-icons" style="font-size:75px;margin-top:15px;">access_time</i>
<div>Fetching results...</div>
</div>
<div id="search-results"></div>
</div>
</div>
</div>
<div id="parent-market">
<div class="header-text">Recent</div>
<div style="height:10px;"></div>
<div class="content-box">
<div class="row" style="margin-bottom:0;">

<? while($gI = $items->fetch(PDO::FETCH_OBJ)){ ?>
<div class="col s12 m2 l2" style="margin-bottom:25px;">
<a href="/Market/Items?id=<?echo "$gI->id"; ?>"><img src="<?echo "$gI->image"; ?>" width="100" height="100" class="img item-view item-view-padding"></a>
<a href="/Market/Items?id=<?echo "$gI->id"; ?>"><div class="item-name"><?echo "$gI->name"; ?></div></a>
<div class="item-creator">
Created By: <a href="#"><? echo " $gI->creator"; ?>
</div>
<div class="item-creator">
Price: <? echo " $gI->price"; ?>
</div>
</div>
<? } ?>
</div>
</div>
<? include "../footer.php"; ?>