<? include"../../header.php"; 
$item = $handler->query("SELECT * FROM items WHERE id=" . $_GET['id']);
$gB = $item->fetch(PDO::FETCH_OBJ); ?>

<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<div class="content-box" style="border-radius:0;">
<div class="left-align">
</div>
<div class="row">
<div class="col s12 m6 l3 center-align">
<img src="<? echo "$gB->image"; ?>" class="responsive-img">
</div>
<div class="col s12 m6 l6">
<div style="padding-left:25px;overflow:hidden;">
<div style="font-size:26px;font-weight:300;"><? echo "$gB->name"; ?><b style="text-transform:uppercase;font-size:12px;"> <? if ($gB->collectable == "true"){ ?>Collectible<? } ?></b></div>
<div style="color:#777;font-size:14px;"><? echo "$gB->description"; ?></div>
</div>
</div>
<div class="col s12 m3 l3 center-align" style="padding-top:15px;">
<center>
<? if ($gB->onsale == 1){ ?>
<a href="/Market/purchase.php?id=<?echo "$gB->id"; ?>"; class="modal-trigger waves-effect waves-light btn ">Purchase</a>
<? } else { ?>
<a class="modal-trigger waves-effect waves-light btn grey darken-2">Sold Out</a>
<? } ?>
</center>
<div style="height:15px;"></div>
<center><a href="#" style="padding-top:12px;font-size:16px;display:inline-block;"><? echo "$gB->creator"; ?></a></center>
<div style="height:25px;"></div>
<center>
<a href="#" style="display:inline-block;margin-left:15px;"><div class="report-abuse"></div></a>
</center>
</div>
</div>
<div style="padding-top:25px;">
<div class="row" style="margin-bottom:0;">
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;"><? echo "$gB->created"; ?></div>
<div style="color:#999;font-size:14px;">Time Created</div>
</div>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;"><? echo "$gB->created"; ?></div>
<div style="color:#999;font-size:14px;">Last Updated</div>
</div>
<? $invv = $handler->query("SELECT * FROM inventory WHERE item=" . $_GET['id']);
$item = $handler->query("SELECT * FROM items WHERE id=" . $_GET['id']);
$limited = $item->fetch(PDO::FETCH_OBJ);
if($limited->collectable == "true"){ ?>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;"><? echo "$gB->amount"; ?></div>
<div style="color:#999;font-size:14px;">Remaining</div>
</div> <? } ?>
<div class="col s12 m12 l3 center-align">
<div style="font-size:20px;"><? echo $invv->rowCount(); ?></div>
<div style="color:#999;font-size:14px;">Owners</div>
</div>
</div>
</div>
</div>
</br>
<div id="Comments" style="display: block;">
<div class="content-box">
<a name="ViewComments"></a>
<form action="#ViewComments" method="POST">
<textarea name="post" id="post" style="outline:none;margin:0;border:0;box-sizing:border-box;padding:0;border:2px solid #ddd !important;font-size:15px;padding:6px 12px;height:75px;" placeholder="Write your comment here"></textarea>
<div style="height:10px;"></div>
<input type="hidden" name="csrf_token" value="MfNwTToCsKtinZch7YM1RXT1Ef/7y173Hqj04sOONHs=">
<input type="submit" name="submit_comment" value="Post Comment" style="background:#2196F3;color:white;padding:5px 6px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="blue-hover">
</form>
</div>
<div class="content-box" style="border-top:1px solid #eee;padding:0;padding:5px 15px;">
<table width="100%">
<tbody><tr>
<td width="10%" class="center-align">
<a href="#"><center><div style="width:75px;height:75px;border:1px solid #eee;overflow:hidden;" class="circle"><img src="Creator.png" width="150" style="margin-left:-40px;"></div></center></a>
<a href="#" style="padding-top:5px;display:inline-block;font-size:14px;"><? echo "$gB->creator"; ?></a>
</td>
<td width="80%">
<div style="word-break:break-word;">Testing!</div>
<div style="padding:3px 0;color:#999;font-size:12px;display:inline-block;"><? echo "$gB->created"; ?></div>
</td>
</tr>
</tbody></table>
</div>
</div>
<? include "../../footer.php"; ?>