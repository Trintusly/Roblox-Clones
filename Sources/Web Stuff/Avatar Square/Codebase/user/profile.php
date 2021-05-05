<?php
$id = $_GET['id'];
$pagename = "$id";
include('../header.php');
?>
</center>
<?php
if (!$id) {
echo "error";
} else {
$getUser = $handler->query("SELECT * FROM users WHERE id='".$id."'");
$gU = $getUser->fetch(PDO::FETCH_OBJ);
$userExist = ($getUser->rowCount());
if ($userExist == "0") {
echo "error user not found";
} else {
?>
		<div class="profile-wrap">
			<div class="profile-frst-wrp">
				<div class="profile-ava-stacker">
<?php
}
}
?>
<div class="entire-page-wrapper">

<div class="row">
<div class="col s12 m12 l3">
<? echo "
<p class='basic-font profile-name'>$gU->username</p>
"; ?>
<div class="content-box" style="padding:0;text-align:center;margin:0;">
<style>.fall-down{margin-top:35px!important;margin-left:175px!important;width:150px!important;}</style>
<ul class="right" style="margin-top:0;margin-bottom:0;margin-top:5px;"><li><a onclick="adjustPosition()" class="dropdown-button" id="user-dropdown2" href="#!" data-alignment="right" data-activates="user-dropdown" style="color:#666;font-weight:normal;"><i class="material-icons right">more_vert</i></a><ul id="user-dropdown" class="dropdown-content fall-down" style="width: 0px; position: absolute; top: 278px; left: 167.438px; opacity: 1; display: none;">
<li><a>Report</a></li>
<script>$(document).ready(function(){$(".modal-trigger").leanModal();});</script>
<li><a href="#TradeUser" onclick="clickTrade()" class="modal-trigger">Trade</a></li>
</ul></li>
</ul>
<? echo "
<img src='../Market/Storage/".$gU->body."' width='200' height='200'>
"; ?>
<a class="material-icons" href="#" title="Send a message" style="background:#2196F3;color:white;padding:4px 4px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;font-size:20px;">mail</a>
&nbsp;
<form action="#" method="POST" style="display:inline-block;">
<input type="hidden" name="ID" value="43701">
<input type="hidden" name="csrf_token" value="o2IUL6GpTJ5+sS9l6/AfyZDJGsuts0QA/slpJrzfoVA=">
<input type="submit" name="submit" value="add_circle" class="material-icons" title="Add as friend" style="background:#15BF6B;color:white;padding:4px 4px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #15BF6B;outline:none;font-size:20px;">
</form>
<div style="height:10px;"></div>
</div>
<div id="UserStatus" style="float:right;"><div class="user-offline" title="Last seen yesterday">&nbsp;</div></div>
<div class="content-box" style="padding:15px;font-size:14px;margin-top:15px;">
<center>
<table style="text-align:center;padding:0;margin:0;">
<tbody>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Profile Views:</td>
<td style="font-weight:normal;text-align:center;width:55%;">0</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Place Visits:</td>
<td style="font-weight:normal;text-align:center;width:55%;">0</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Date Joined:</td>
<td style="font-weight:normal;text-align:center;width:55%;">2017</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;">Friends Made:</td>
<td style="font-weight:normal;text-align:center;width:55%;">0</td>
</tr>
<tr>
<td style="font-weight:bold;text-align:right;width:45%;padding-bottom:0 !important;">Forum Posts:</td>
<td style="font-weight:normal;text-align:center;width:55%;padding-bottom:0 !important;">0</td>
</tr>
</tbody>
</table>
</center>
</div>

</div>
<div class="col s12 m12 l9" style="margin-bottom:15px;">
<div style="height:5px;"></div>
<div class="header-text" style="font-size:18px;">Games</div>
<div class="content-box" style="padding:15px;">
<div style="color:#555555;font-size:14px;">This user does not have any active games.</div>
</div>
<div style="height:25px"></div>
<div class="header-text" style="font-size:18px;">Achievements</div>
<div style="height:3px;"></div>
<div class="content-box" style="padding:15px;">
<div style="color:#555555;font-size:14px;">This user does not have any achievements.</div>
</div>
<div style="height:25px"></div>
<div class="header-text" style="font-size:18px;">Favorite Items</div>
<div class="content-box" style="padding:15px;">
<div style="color:#555555;font-size:14px;">This user does not have any favorite items.</div>
</div>
<div style="height:15px"></div>
<font style="float:right;">
<a href="#" class="groups-blue-button" style="padding:0;margin:0;font-size:14px;margin-bottom:5px;padding-left:5px;padding-right:5px;">View All</a>
<div style="height:5px;"></div>
</font>
<div class="header-text" style="float:left;font-size:18px;padding-top:10px;">Friends</div>
<br style="clear:both;">
<div class="content-box" style="padding:15px;">
<div style="color:#666;font-size:14px;">This user does not have any active friends.</div>
</div>
<div style="height:15px"></div>
<font style="float:right;">
<a href="#" class="groups-blue-button" style="padding:0;margin:0;font-size:14px;margin-bottom:5px;padding-left:5px;padding-right:5px;">View All</a>
<div style="height:5px;"></div>
</font>
<div class="header-text" style="float:left;font-size:18px;padding-top:10px;">Groups</div>
<br style="clear:both;">
<div class="content-box" style="padding:15px;">
<div style="color:#666;font-size:14px;">This user is not a member of any groups.</div>
</div>
<div style="height:15px"></div>
<font style="float:right;">
<a href="#" class="groups-blue-button" style="padding:0;margin:0;font-size:14px;margin-bottom:5px;padding-left:5px;padding-right:5px;">View All</a>
<div style="height:5px;"></div>
</font>
<div class="header-text" style="float:left;font-size:18px;padding-top:10px;">Inventory</div>
<br style="clear:both;">
<div class="content-box">
<style>.hover-items a:hover{color:#999999!important;}</style>
<a name="inventory"></a>
<div class="row" style="margin-bottom:0;">
<div class="col s12 m12 l2">
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('collectible','1')">Collectibles</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('head','1')">Heads</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('hat','1')">Hats</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('face','1')">Faces</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('accessory','1')">Accessories</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('tshirt','1')">T-Shirts</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('shirt','1')">Shirts</a>
</div>
<div class="hover-items" style="padding:8px 0;font-size:16px;">
<a id="item-type" href="#inventory" style="color:#343434;display:block;text-decoration:none;" onclick="displayItems('pants','1')">Pants</a>
</div>
</div>
<div class="col s12 m12 l10">
<div id="items"><div class="row"><input type="hidden" name="PageCount" value="0"></div></div>
</div>
</div>
<div id="InventoryContainerPagination" style="margin: 0 auto;text-align:center;"></div>
</div>
</div>
</div>
</div>

</div>

</div>