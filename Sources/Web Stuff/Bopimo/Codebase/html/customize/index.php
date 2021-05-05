<?php
$ads = true;
require("/var/www/html/site/bopimo.php");
require("/var/www/html/site/header.php");

if(!$bop->logged_in())
{
	die("<script>window.location = '/login/'</script>");
}

error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
$avatar = $bop->avatar($_SESSION['id']);
?>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
(adsbygoogle = window.adsbygoogle || []).push({
google_ad_client: "ca-pub-9016364683167219",
enable_page_level_ads: true
});
</script>

<style>
.item-img img {
	visibility: hidden;
	border-radius: 5px;
}
.item-img {
	background-position: center;
	background-size: cover;
}
.item-img:hover img.x {
	visibility: visible;
}
.item-img:hover .x-btn {
	visibility: visible;
}
.color-btn {
	padding: 15px;
	border:none;
	float:left;
	margin:0px;
}

.color-btn:hover {
	cursor: pointer;
}

a.selected {
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#FFFFFF;
  border:1px solid #999999;
  cursor:default;
  margin-top: 15px;
  position:absolute;
  text-align:left;
  z-index:50;
  width:50%;
  margin-left:2.5%;
  padding-bottom: 5px;
}
.grey-out {
	position: absolute;
	cursor:default;
	z-index: 9999999;
	margin:0px;
	padding:0px;
	width:100%;
	height:100%;
	background:black;
	left:0px;
	right:0px;
	top:0px;
	bottom:0px;
	opacity: 0.5;
    filter: alpha(opacity=50); /* For IE8 and earlier */
}


.currently-wearing, .limb-colors {
	min-height: 353.28;
	transition: min-height 1s;
}
.avatar .body{
	min-height: 342;
}

.currently-wearing .body .category {
	overflow: auto;
	border-radius: 10px;
}

.currently-wearing .body .category .box {
	height: 25%;
	border: 0.5px solid #fff;
	background-color: #E0E0E0;
	padding: 5px;
	width: calc(25% - 11px);
	float: left;
	text-align:center;
}

.currently-wearing .body .category .box img {
	height: 65px;
}

.grey-box {
	background-color: #E0E0E0;
	padding: 5px;
}

.border-r {
	border-radius: 5px;
	overflow: auto;
}
.color-holder {
	overflow: auto;
	display: inline-block;
}

.border.color {
	display: inline-block;
	background-color: #d0d0d0;
}

.color-holder .color-btn:last-child {
	margin-right: 0px !important;
}
.color-holder:last-child .color-btn {
	margin-bottom: 0px !important;
}
.name {
	text-overflow: ellipsis;
	overflow: hidden;
	white-space: nowrap;

}
#wearing .centered img:hover {
	cursor: pointer;
}
</style>

<div class="messagepop pop card b hidden" style="z-index: 999999999;">
    <div class="top centered">
		<span id="editing-name"></span>
		<button class="close button" style="float:right;margin:0px;float:right;border:none;padding:0;background:none;" onclick="close()"><img id="close" src="/emojis/exit-200.png" height="25"></button>
	</div>
	<div class="body centered">
		<button class="color-btn" style="background-color: #F9EBEA" color="#F9EBEA"></button>
		<button class="color-btn" style="background-color: #F4ECF7" color="#F4ECF7"></button>
		<button class="color-btn" style="background-color: #EBF5FB" color="#EBF5FB"></button>
		<button class="color-btn" style="background-color: #E8F6F3" color="#E8F6F3"></button>
		<button class="color-btn" style="background-color: #EAFAF1" color="#EAFAF1"></button>
		<button class="color-btn" style="background-color: #FEF5E7" color="#FEF5E7"></button>
		<button class="color-btn" style="background-color: #FBEEE6" color="#FBEEE6"></button>
		<button class="color-btn" style="background-color: #FDFEFE" color="#FDFEFE"></button>
		<button class="color-btn" style="background-color: #EAECEE" color="#EAECEE"></button>
		<br><br>
		<button class="color-btn" style="background-color: #CD6155" color="#CD6155"></button>
		<button class="color-btn" style="background-color: #A569BD" color="#A569BD"></button>
		<button class="color-btn" style="background-color: #85C1E9" color="#85C1E9"></button>
		<button class="color-btn" style="background-color: #73C6B6" color="#73C6B6"></button>
		<button class="color-btn" style="background-color: #82E0AA" color="#82E0AA"></button>
		<button class="color-btn" style="background-color: #F8C471" color="#F8C471"></button>
		<button class="color-btn" style="background-color: #E59866" color="#E59866"></button>
		<button class="color-btn" style="background-color: #F4F6F7" color="#F4F6F7"></button>
		<button class="color-btn" style="background-color: #808B96" color="#808B96"></button>
		<br><br>
		<button class="color-btn" style="background-color: #A93226" color="#A93226"></button>
		<button class="color-btn" style="background-color: #7D3C98" color="#7D3C98"></button>
		<button class="color-btn" style="background-color: #2E86C1" color="#2E86C1"></button>
		<button class="color-btn" style="background-color: #138D75" color="#138D75"></button>
		<button class="color-btn" style="background-color: #28B463" color="#28B463"></button>
		<button class="color-btn" style="background-color: #D68910" color="#D68910"></button>
		<button class="color-btn" style="background-color: #BA4A00" color="#BA4A00"></button>
		<button class="color-btn" style="background-color: #D0D3D4" color="#D0D3D4"></button>
		<button class="color-btn" style="background-color: #273746" color="#273746"></button>
		<br><br>
	</div>
</div>
<div class="hidden">
</div>
<?php
$colors = ["B50600", "C63901", "A8A801", "18AF01", "00D3BE", "000DA0", "A00088",
"FD0D00", "FF4C01", "FFFF01","26FC06","00FFE7","0014FF","FF00D9",
"FD5043","FF7E47","FFFF47","5FFF47","47FEF0","4657FF","FF48E1",
"FFB5B6","FFC8B4","FFFAB5","C3FFB5","B6FFF4","B1C2FF","FFB5F8",
"F4F6F7","C4C6C6", "808282", "626363", "0C1216", "273746", "000000"];
?>
<div class="hidden">
<div class="card border color" id="colors">

	<?php $count = 0; foreach ($colors as $color) { echo "<!-- ".$count % 7 ." -->"; echo ($count %7 == 0 ) ? ($count == count($colors) -1) ? "</div>" : ($count == 0) ? "<div class='color-holder'>" : "</div><br><div class='color-holder'>" : ""; ?>
		<?php if ($color !== "rainbow") { ?>
			<div class="color-btn" color="<?=$color?>" style="float:left;padding: 10px; margin-bottom: 3px;margin-right: 3px;border-radius: 5px;background-color:#<?=$color?>;"></div>
		<?php } else { ?>
			<label class="color-btn" for="customColor" color="pick" style="float:left;padding: 10px; margin-bottom: 3px;margin-right: 3px;border-radius: 5px;background: url('/images/rainbow-square.png');background-size: 100% 100%;" ></label>
		<?php }
			$count++;
			} ?>
			<div style="color:#626363;margin: 1px 0px 1px 0px;font-size:0.8rem;font-weight:600;text-align:center;">Custom Hex Color</div>
			<input id="customColor" class="width-100 not-default" style="border: 1px solid #fff;padding: 3px;border-radius:5px;font-weight:600;background-color:#fff;font-family:quicksand;outline:none;" placeholder="000000" type="text"></input>
		</div>

</div>
</div>
<div class="grey-out hidden"></div>


<div class="content">
	<div class="col-4-12">
		<div class="card b">
			<div class="top centered">
				Currently Wearing
			</div>
			<div class="body">
				<div class="image-custom" id="wearing">
					<div class="col-1-3">
						<fieldset>
							<legend>
								Hats
							</legend>
							<div class="centered" id="hat1">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
							<div class="centered" id="hat2">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
							<div class="centered" id="hat3">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>
								Tool
							</legend>
							<div class="centered" id="tool">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-1-3">
						<fieldset>
							<legend>
								Face
							</legend>
							<div class="centered" id="face">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>

							</div>
						</fieldset>
						<fieldset>
							<legend>
								T-Shirt
							</legend>
							<div class="centered" id="tshirt">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-1-3">
						<fieldset>
							<legend>
								Shirt
							</legend>
							<div class="centered" id="shirt">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
						</fieldset>
						<fieldset>
							<legend>
								Pants
							</legend>
							<div class="centered" id="pants">
								<div class="item-img" style="background-image: url('https://storage.bopimo.com/thumbnails/1.png');">
									<img style="width:100%;" src="remove.png" />
								</div>
							</div>
						</fieldset>
					</div>
					<div class="col-3-12">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-4-12">
		<div class="card b avatar">
			<div class="top centered">
				Avatar
			</div>
			<div class="body centered" id="avatar-container">
				<span id="avr" style="overflow:auto;"></span>
			</div>
		</div>
	</div>
	<div class="col-4-12">
		<div class="card b limb-colors">
			<div class="top centered">
				Limb Colors
			</div>
			<div class="body" id="limbs" style="overflow:auto;min-height:300px;">
				<style>
					.head {
						padding: 25px;
						border:none;

					}
					.torso {
						width: 100%;
						height:100%;
						margin-top: 2.5px;
						border:none;
						margin-left:-20px;
					}
					.left-arm {
						width: 100%;
						height: 100%;
						margin-top: 2.5px;
						border:none;

					}
					.color button {
						border-radius: 10px;
						border: 1px solid lightgrey;
					}
					.color button:focus {
						outline:none;
					}
				</style>
				<div class="color" style="width: 300px;margin-top:10px;text-align:center;position: relative;">
					<div style=" position: absolute; left: 47.5%; top: 10px;">
						<button class="body-part button tooltip" data-tooltip-content="#colors" id="head_color" part="head" true-name="Head" style="background-color: #<?=$avatar->head_color?>;padding: 25px;margin-top: -1px;"></button>
					</div>
					<div style=" position: absolute; left: 40.1%; top: 62px;">
						<button class="body-part button tooltip" data-tooltip-content="#colors" id="torso_color" part="torso" true-name="Torso" style="background-color: #<?=$avatar->torso_color?>;padding: 50px;"></button>
					</div>
					<div style=" position: absolute; left: 23.1%; top: 62px;">
						<button id="left_arm_color" class="body-part button tooltip" data-tooltip-content="#colors" part="left_arm" true-name="Left Arm" style="background-color: #<?=$avatar->left_arm_color?>;padding: 50px;padding-right: 0px;"></button>
					</div>
					<div style=" position: absolute; left: 73.7%; top: 62px;">
						<button class="body-part button tooltip" data-tooltip-content="#colors" id="right_arm_color" part="right_arm" true-name="Right Arm" style="background-color: #<?=$avatar->right_arm_color?>;padding: 50px;padding-right: 0px;"></button>
					</div>
					<div style="position: absolute;left: 40.2%;top: 165px;">
						<button class="body-part button tooltip" data-tooltip-content="#colors" id="left_leg_color" part="left_leg" true-name="Left Leg" class="colorPallete" style="background-color: #<?=$avatar->left_leg_color?>;padding: 50px;padding-right: 0px;padding-left: 47px;"></button>
					</div>
					<div style="position: absolute;left: 57.0%;top: 165px;margin-left: -2px;">
						<button class="body-part button tooltip" data-tooltip-content="#colors" id="right_leg_color" part="right_leg" true-name="Right Leg" style="background-color: #<?=$avatar->right_leg_color?>;padding: 50px;padding-right: 0px;padding-left: 47px;"></button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-1-1" style="width:100%;">
		<div class="tab-container" style="margin-bottom: 6px;">
			<?php
			$categories = [
			"Hats" => 1,
			"Tools" => 2,
			"Shirts" => 4,
			"Pants" => 5,
			"T-Shirts" => 6,
			"Faces" => 3
			];
			$categoryCount = count($categories);
			foreach ($categories as $name => $id) {
				?>
				<div class="tab col-1-<?=$categoryCount?>" data-category="<?=$id?>">
					<?=$name?>
				</div>
				<?php
			}
			?>

		</div>
		<div class="col-1-1">
			<div id="content-3" style="min-height: 300px;"></div>
		</div>
	</div>

</div>
<script>
/*
$(document).ready(function(){
	//$('.tooltip').tooltipster({contentCloning: true, trigger: 'click'});
	function reload(req1)
	{
		$("#content-1").load("load-equipped.php");
		loadTab($(".tab[data-category=hat]"));
		$("#content-3").load("fetch_inventory.php?req="+req1);
	}

	var curRequest = "hat";

	reload(curRequest);

	function deselect(e) {
	  $('.pop').slideFadeToggle(function() {
		e.removeClass('selected');
	  });
	}
	function updateAvatar(){
		$("#avr").html("<img src='/css/loading.gif' class='image'>");
		$("#avr").load("get_avatar.php", function(){
			console.log("yes");
			$("#avr img").one('load', function () {

			w = $("#avr img").height();
			$(".currently-wearing .body").css("min-height", w);
			$(".limb-colors .body").css("min-height", w);

			})

		});
	}
	updateAvatar();
	var editing;
	$(".body-part").click(function(){
		/*$(".grey-out").removeClass("hidden");
		$('.pop').removeClass("hidden");*//*
		$("#editing-name").html("Editing " + $(this).attr("true-name") + ":");
		editing = $(this).attr("part");
	});

	function loadTab ( tab ) {
		console.log($(tab).hasClass("current"))
		$(".tab-container .current").removeClass("current");
		$(tab).addClass("current");
	}

	$(".color-btn").click(function(){
		color = $(this).attr("color");
		if (color !== "pick") {
			console.log(editing + " would have changed to " +color);
			$("#"+editing).css("background-color", color);
			$(".grey-out").addClass("hidden");
			$('.pop').addClass("hidden");
			$("#avr").html("<img src='/css/loading.gif' class='image'>");
			$.post("change-color.php", {part: editing, color: color}, function(reply){
				$("#avr").load("get_avatar.php");
			});
		}
	});

	/*$('.close').click(function(){
		$(".grey-out").addClass("hidden");
		$('.pop').addClass("hidden");
	});*//*

	$.fn.slideFadeToggle = function(easing, callback) {
		return this.animate({ opacity: 'toggle', height: 'toggle' }, 'fast', easing, callback);
	};

	$(".tab[data-category]").click(function(){
		if(!$(this).hasClass("current"))
		{
			loadTab($(this));
			$("#content-2").html("Viewing: Your "+$(this).html());
			$(".current").removeClass("current");
			$(this).addClass("current");
			$("#content-3").load("fetch_inventory.php?req="+$(this).attr("data-category"));
		}
	});


});*/
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinycolor/1.4.1/tinycolor.min.js"></script>
<script src="/js/tooltipster.bundle.min.js"></script>
<script src="/js/avatar.js?c=<?=rand(0,100000)?>"></script>


<?php $bop->footer(); ?>
