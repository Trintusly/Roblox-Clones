<? include "../header.php"; if ($user){
$items = $handler->query("SELECT * FROM inventory WHERE user='".$myu->id."'"); ?>
<div class="entire-page-wrapper">


<div class="col s12 m9 l8">
<div class="container" style="width:100%;">

<div id="data-response"></div>
<div style="background:#FFF;position:absolute;margin-left:300px;margin-top:308px;padding:15px;border:1px solid #CCCCCC;z-index:1337;display:none;" id="palette">
<div class="header-text" style="font-size:18px;padding-bottom:15px;" id="palette-text">Choose a color</div>
<div style="background:#ffe0bd;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#ffe0bd')" id="ffe0bd"></div>
<div style="background:#ffcd94;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ffcd94')"></div>
<div style="background:#eac086;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#eac086')"></div>
<div style="background:#ffad60;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ffad60')"></div>
<div style="background:#ffe39f;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ffe39f')"></div>
<div style="clear:both;padding-top:5px;"></div>
<div style="background:#9c7248;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#9c7248')"></div>
<div style="background:#926a2d;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#926a2d')"></div>
<div style="background:#876127;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#876127')"></div>
<div style="background:#7c501a;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#7c501a')"></div>
<div style="background:#6f4f1d;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#6f4f1d')"></div>
<div style="clear:both;padding-top:5px;"></div>
<div style="background:#000000;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#000000')"></div>
<div style="background:#191919;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#191919')"></div>
<div style="background:#323232;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#323232')"></div>
<div style="background:#4c4c4c;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#4c4c4c')"></div>
<div style="background:#666666;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#666666')"></div>
<div style="clear:both;padding-top:5px;"></div>
<div style="background:#7f7f7f;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#7f7f7f')"></div>
<div style="background:#999999;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#999999')"></div>
<div style="background:#b2b2b2;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#b2b2b2')"></div>
<div style="background:#cccccc;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#cccccc')"></div>
<div style="background:#e5e5e5;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#e5e5e5')"></div>
<div style="clear:both;padding-top:5px;"></div>
<div style="background:#fbe8b0;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#fbe8b0')"></div>
<div style="background:#e1d98f;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#e1d98f')"></div>
<div style="background:#b5ba63;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#b5ba63')"></div>
<div style="background:#7f9847;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#7f9847')"></div>
<div style="background:#40832b;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#40832b')"></div>
<div style="clear:both;padding-top:5px;"></div>
<div style="background:#0076b6;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#0076b6')"></div>
<div style="background:#0e325b;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#0e325b')"></div>
<div style="background:#7f6ab6;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#7f6ab6')"></div>
<div style="background:#610059;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#610059')"></div>
<div style="background:#9a003f;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#9a003f')"></div>
<div style="clear:both;padding-top:5px;"></div>
<div style="background:#ff8d00;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor('#ff8d00')"></div>
<div style="background:#ff05c1;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ff05c1')"></div>
<div style="background:#ab0000;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ab0000')"></div>
<div style="background:#ffadb9;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ffadb9')"></div>
<div style="background:#ffbf00;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor('#ffbf00')"></div>
</div>
<div class="row" style="margin-bottom:0;">
<div class="col s12 l4">
<div class="header-text" style="font-size:18px;padding-bottom:5px;">Avatar</div>
<div class="content-box center-align">
<iframe frameborder="0" src="/avatar.php?id=<? echo $myu->id ?>" scrolling="no" style=" width: 200px; height: 200px"></iframe>
</div>
<div style="height:15px;"></div>
<div class="header-text" style="font-size:18px;padding-bottom:5px;">Avatar</div>
<div class="content-box center-align">
<div style="background:#FFE0BD;width:35px;height:35px;margin:0 auto;cursor:pointer;" onclick="showPalette('head')" id="head"></div>
<div style="height:5px;"></div>
<div style="background:#FFE0BD;width:35px;height:75px;margin:0 auto;cursor:pointer;display:inline-block;" onclick="showPalette('leftarm')" id="leftarm"></div>
<div style="background:#FFE0BD;width:75px;height:75px;margin:0 auto;cursor:pointer;display:inline-block;" onclick="showPalette('torso')" id="torso"></div>
<div style="background:#FFE0BD;width:35px;height:75px;margin:0 auto;cursor:pointer;display:inline-block;" onclick="showPalette('rightarm')" id="rightarm"></div>
<div style="clear:both;display:block;"></div>
<div style="margin-top:-3px;">
<div style="background:#FFE0BD;width:35px;height:75px;margin:0 auto;display:inline-block;" onclick="showPalette('leftleg')" id="leftleg"></div>
<div style="background:#FFE0BD;width:35px;height:75px;margin:0 auto;display:inline-block;" onclick="showPalette('rightleg')" id="rightleg"></div>
</div>
</div>
</div>
<div class="col s12 l8">
<div class="header-text" style="font-size:18px;padding-bottom:5px;">Inventory</div>
<div class="content-box">
<div style="text-align:center;color:#999;font-size:14px;">
<a onclick="updateInventory('head',1)" style="cursor: pointer; font-weight: normal;" id="head-link">Heads</a>
&nbsp;|&nbsp;
<a onclick="updateInventory('hat',1)" style="cursor: pointer; font-weight: bold;" id="hat-link">Hats</a>
&nbsp;|&nbsp;
<a onclick="updateInventory('faces',1)" style="cursor: pointer; font-weight: normal;" id="faces-link">Faces</a>
&nbsp;|&nbsp;
<a onclick="updateInventory('accessories',1)" style="cursor: pointer; font-weight: normal;" id="accessories-link">Accessories</a>
&nbsp;|&nbsp;
<a onclick="updateInventory('tshirts',1)" style="cursor: pointer; font-weight: normal;" id="tshirts-link">T-Shirts</a>
&nbsp;|&nbsp;
<a onclick="updateInventory('shirts',1)" style="cursor: pointer; font-weight: normal;" id="shirts-link">Shirts</a>
&nbsp;|&nbsp;
<a onclick="updateInventory('pants',1)" style="cursor: pointer; font-weight: normal;" id="pants-link">Pants</a>
</div>
<div style="height:15px;"></div>
<div class="center-align">
<input type="text" id="search" onchange="updateInventory(lastType, lastPage, this.value)" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;width:300px;" placeholder="Search and press enter">
</div>

<div style="height:15px;"></div>
<div id="inventory-box"><div class="row" style="margin-bottom:0;">

<? while($gN = $items->fetch(PDO::FETCH_OBJ)){ 
$inventory = $handler->query("SELECT * FROM items WHERE id='".$gN->item."'");
$gI = $inventory->fetch(PDO::FETCH_OBJ)
?>

<div class="col s3 center-align" style="padding:15px;">
<div style="position:relative;">
<img src="<?echo "$gI->image"; ?>" style="display:block;margin:0 auto;width:108.047px;height:108.047px;">
<a href="#" target="_blank"><div style="padding-top:10px;font-size:12px;"><?echo "$gI->name"; ?></div></a>
<div style="position:absolute;top:0;right:-5px;">
</div>

<a href="../Market/Items/render.php?id=<?echo "$gI->id"; ?>" class="btn waves-effect waves-light" style="background-color: #00C853"></a>
<a href="../Market/Items/remove.php?id=<?echo "$gI->id"; ?>" class="btn waves-effect waves-light" style="background-color: #F44336"></a>

</div>
</div>

<? } ?>

</div></div>

</div>
<div style="height:25px;"></div>
<div class="header-text" style="font-size:18px;padding-bottom:5px;">Wearing</div>
<div class="content-box">
<div id="wearing-box"><div class="row" style="margin-bottom:0;">
<div class="col s3 center-align" style="padding:15px;">
<div style="position:relative;">
</div>
</div>
</div>
</div></div>
</div>
</div>
</div>
</div>
</div>
<? } ?>