<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	requireLogin();

    if ($SiteSettings->AllowEditCharacter == 0) {

		echo '
		<script>
			document.title = "Edit Character - Brick Planet";
		</script>
		<div class="container border-r lg-padding text-center games-construction">
			<i class="material-icons">warning</i>
			<div>This area is under maintenance</div>
			<p>We\'re working on improving this feature. Check back soon!</p>
		</div>
		';

		die;

	}

	else {

		echo '
		<script>
			document.title = "Edit Character - Brick Planet";

			var lastType;
			var lastPage;
			var lastSearch;
			var isChanging = 0;
			var avatarOrientation = '.$myU->AvatarOrientation.';

			window.onload = function() {
				updateInventory("hat", 1);

				var xmlHttp = new XMLHttpRequest();
				xmlHttp.open( "GET", "'.$serverName.'/account/GetWearing.php", false);
				xmlHttp.send(null);
				document.getElementById("wearing-box").innerHTML = xmlHttp.responseText;
			}

			function updateInventory(type, page, search) {
				lastType = type;
				lastPage = page;
				lastSearch = search;
				var xmlHttp = new XMLHttpRequest();
				xmlHttp.open( "GET", "'.$serverName.'/account/GetInventory.php?type=" + type + "&Page=" + page + "&Search=" + search, false);
				xmlHttp.send(null);
				document.getElementById("inventory-box").innerHTML = xmlHttp.responseText;

				document.getElementById("hat-link").style.fontWeight = "normal";
				document.getElementById("faces-link").style.fontWeight = "normal";
				document.getElementById("accessories-link").style.fontWeight = "normal";
				document.getElementById("shirts-link").style.fontWeight = "normal";
				document.getElementById("pants-link").style.fontWeight = "normal";
				document.getElementById(type + "-link").style.fontWeight = "bold";
			}

			function updateWearing() {
				var xmlHttp = new XMLHttpRequest();
				xmlHttp.open( "GET", "'.$serverName.'/account/GetWearing.php", false);
				xmlHttp.send(null);
				document.getElementById("wearing-box").innerHTML = xmlHttp.responseText;
				isChanging = 0;
			}

			function refreshAvatar() {
				if (isChanging == 0) {
					isChanging = 1;
					document.getElementById("avatar").src = "'.$serverName.'/assets/images/spinners/three-brick-svgSpinner.svg";
					document.getElementById("avatar").style.margin = "0 auto";
					var http = new XMLHttpRequest();
					http.open( "POST", "'.$serverName.'/account/character/process", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.send("action=refresh&csrf_token='.$_SESSION['csrf_token'].'");
					document.getElementById("data-response").innerHTML = http.responseText;
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							var xmlHttp = new XMLHttpRequest();
							xmlHttp.open( "GET", "'.$serverName.'/account/getAvatar.php", false);
							xmlHttp.send(null);
							document.getElementById("avatar").src = xmlHttp.responseText+".png";
							updateWearing();
						}
					}
				}
			}

			function changeAvatarOrientation(OrientationType) {
				if (isChanging == 0) {
					console.log("orientation-" + avatarOrientation);
					document.getElementById("orientation-" + avatarOrientation).classList.remove("lr-active");
					document.getElementById("orientation-" + OrientationType).classList.add("lr-active");
					avatarOrientation = OrientationType;
					isChanging = 1;
					document.getElementById("avatar").src = "'.$serverName.'/assets/images/spinners/three-brick-svgSpinner.svg";
					document.getElementById("avatar").style.margin = "0 auto";
					var http = new XMLHttpRequest();
					http.open( "POST", "'.$serverName.'/account/character/process", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.send("action=orientation&orientation=" + OrientationType + "&csrf_token='.$_SESSION['csrf_token'].'");
					document.getElementById("data-response").innerHTML = http.responseText;
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							var xmlHttp = new XMLHttpRequest();
							xmlHttp.open( "GET", "'.$serverName.'/account/getAvatar.php", false);
							xmlHttp.send(null);
							document.getElementById("avatar").src = xmlHttp.responseText+".png";
							updateWearing();
						}
					}
				}
			}

			function wearItem(id) {
				if (isChanging == 0) {
					isChanging = 1;
					document.getElementById("avatar").src = "'.$serverName.'/assets/images/spinners/three-brick-svgSpinner.svg";
					document.getElementById("avatar").style.margin = "0 auto";
					var http = new XMLHttpRequest();
					http.open( "POST", "'.$serverName.'/account/character/process", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.send("action=wear&id=" + id + "&csrf_token='.$_SESSION['csrf_token'].'");
					document.getElementById("data-response").innerHTML = http.responseText;
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							var xmlHttp = new XMLHttpRequest();
							xmlHttp.open( "GET", "'.$serverName.'/account/getAvatar.php", false);
							xmlHttp.send(null);
							document.getElementById("avatar").src = xmlHttp.responseText+".png";
							updateWearing();
						}
					}
				}
			}

			function removeItem(id) {
				if (isChanging == 0) {
					isChanging = 1;
					document.getElementById("avatar").src = "'.$serverName.'/assets/images/spinners/three-brick-svgSpinner.svg";
					document.getElementById("avatar").style.margin = "0 auto";
					var http = new XMLHttpRequest();
					http.open( "POST", "'.$serverName.'/account/character/process", true);
					http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					http.send("action=remove&id=" + id + "&csrf_token='.$_SESSION['csrf_token'].'");
					http.onreadystatechange = function() {
						if (http.readyState == 4 && http.status == 200) {
							var xmlHttp = new XMLHttpRequest();
							xmlHttp.open( "GET", "'.$serverName.'/account/getAvatar.php", false);
							xmlHttp.send(null);
							document.getElementById("avatar").src = xmlHttp.responseText+".png";
							updateWearing();
						}
					}
				}
			}

			var paletteType;

			function showPalette(type) {
				paletteType = type;
				$("#palette").show(function() {
					document.body.addEventListener("click", closePalette, false);
				});
			}

			function changeColor(hex) {
				document.getElementById("avatar").src = "'.$serverName.'/assets/images/spinners/three-brick-svgSpinner.svg";
				document.getElementById("avatar").style.margin = "0 auto";
				document.getElementById(paletteType).style.backgroundColor = hex;
				var http = new XMLHttpRequest();
				http.open( "POST", "'.$serverName.'/account/character/process", true);
				http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				http.send("action=color&type=" + paletteType + "&hex=" + hex + "&csrf_token='.$_SESSION['csrf_token'].'");
				http.onreadystatechange = function() {
					if (http.readyState == 4 && http.status == 200) {
						var xmlHttp = new XMLHttpRequest();
						xmlHttp.open( "GET", "'.$serverName.'/account/getAvatar.php", false);
						xmlHttp.send(null);
						document.getElementById("avatar").src = xmlHttp.responseText+".png";
					}
				}
			}

			function closePalette(e) {
				if (e.target.id != "palette" && e.target.id != "palette-text") {
					document.body.removeEventListener("click", closePalette, false);
					$("#palette").hide();
				}
			}
		</script>
		<div id="data-response"></div>
		<div class="palette" id="palette">
			<div class="palette-header-text" id="palette-text">Choose a color</div>
			<div style="background:#ffe0bd;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#ffe0bd\')" id="ffe0bd"></div>
			<div style="background:#ffcd94;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ffcd94\')"></div>
			<div style="background:#eac086;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#eac086\')"></div>
			<div style="background:#ffad60;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ffad60\')"></div>
			<div style="background:#ffe39f;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ffe39f\')"></div>
			<div style="clear:both;padding-top:5px;"></div>
			<div style="background:#9c7248;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#9c7248\')"></div>
			<div style="background:#926a2d;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#926a2d\')"></div>
			<div style="background:#876127;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#876127\')"></div>
			<div style="background:#7c501a;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#7c501a\')"></div>
			<div style="background:#6f4f1d;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#6f4f1d\')"></div>
			<div style="clear:both;padding-top:5px;"></div>
			<div style="background:#000000;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#000000\')"></div>
			<div style="background:#191919;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#191919\')"></div>
			<div style="background:#323232;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#323232\')"></div>
			<div style="background:#4c4c4c;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#4c4c4c\')"></div>
			<div style="background:#666666;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#666666\')"></div>
			<div style="clear:both;padding-top:5px;"></div>
			<div style="background:#7f7f7f;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#7f7f7f\')"></div>
			<div style="background:#999999;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#999999\')"></div>
			<div style="background:#b2b2b2;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#b2b2b2\')"></div>
			<div style="background:#cccccc;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#cccccc\')"></div>
			<div style="background:#e5e5e5;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#e5e5e5\')"></div>
			<div style="clear:both;padding-top:5px;"></div>
			<div style="background:#fbe8b0;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#fbe8b0\')"></div>
			<div style="background:#e1d98f;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#e1d98f\')"></div>
			<div style="background:#b5ba63;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#b5ba63\')"></div>
			<div style="background:#7f9847;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#7f9847\')"></div>
			<div style="background:#40832b;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#40832b\')"></div>
			<div style="clear:both;padding-top:5px;"></div>
			<div style="background:#0076b6;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#0076b6\')"></div>
			<div style="background:#0e325b;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#0e325b\')"></div>
			<div style="background:#7f6ab6;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#7f6ab6\')"></div>
			<div style="background:#610059;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#610059\')"></div>
			<div style="background:#9a003f;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#9a003f\')"></div>
			<div style="clear:both;padding-top:5px;"></div>
			<div style="background:#ff8d00;width:50px;height:50px;display:inline-block;cursor:pointer;" onclick="changeColor(\'#ff8d00\')"></div>
			<div style="background:#ff05c1;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ff05c1\')"></div>
			<div style="background:#ab0000;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ab0000\')"></div>
			<div style="background:#ffadb9;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ffadb9\')"></div>
			<div style="background:#ffbf00;width:50px;height:50px;display:inline-block;cursor:pointer;margin-left:15px;" onclick="changeColor(\'#ffbf00\')"></div>
		</div>
		<div class="grid-x grid-margin-x">
			<div class="large-4 cell">
				<div class="grid-x grid-margin-x align-middle">
					<div class="auto cell no-margin">
						<h5>Avatar</h5>
					</div>
					<div class="shrink cell right no-margin">
						<input type="button" class="button button-grey" value="Refresh" style="margin:0 auto;padding:3px 15px;font-size:12px;line-height:1.25;" onclick="refreshAvatar()">
					</div>
				</div>
				<div class="push-5"></div>
				<div class="container border-r lg-padding text-center relative">
					<img src="'.$cdnName.''.$myU->AvatarURL.'.png" id="avatar">
					<div class="edit-character-lr">
						<span class="lr-left'; if ($myU->AvatarOrientation == 1) { echo ' lr-active'; } echo '" title="Change avatar orientation to face left" onclick="changeAvatarOrientation(1)" id="orientation-1">L</span>
						<span class="lr-right'; if ($myU->AvatarOrientation == 0) { echo ' lr-active'; } echo '" title="Change avatar orientation to face right" onclick="changeAvatarOrientation(0)" id="orientation-0">R</span>
					</div>
				</div>
				<div class="push-15"></div>
				<h5>Colors</h5>
				<div class="container border-r lg-padding text-center">
					<div style="background:#'.strtoupper($myU->HexHead).';width:35px;height:35px;margin:0 auto;cursor:pointer;" onclick="showPalette(\'head\')" id="head"></div>
					<div style="height:5px;"></div>
					<div style="background:#'.strtoupper($myU->HexRightArm).';width:35px;height:75px;margin:0 auto;cursor:pointer;display:inline-block;" onclick="showPalette(\'rightarm\')" id="rightarm"></div>
					<div style="background:#'.strtoupper($myU->HexTorso).';width:75px;height:75px;margin:0 auto;cursor:pointer;display:inline-block;" onclick="showPalette(\'torso\')" id="torso"></div>
					<div style="background:#'.strtoupper($myU->HexLeftArm).';width:35px;height:75px;margin:0 auto;cursor:pointer;display:inline-block;" onclick="showPalette(\'leftarm\')" id="leftarm"></div>
					<div style="clear:both;display:block;"></div>
					<div style="margin-top:-3px;">
					<div style="background:#'.strtoupper($myU->HexRightLeg).';width:35px;height:75px;margin:0 auto;display:inline-block;" onclick="showPalette(\'rightleg\')" id="rightleg"></div>
					<div style="background:#'.strtoupper($myU->HexLeftLeg).';width:35px;height:75px;margin:0 auto;display:inline-block;" onclick="showPalette(\'leftleg\')" id="leftleg"></div>
					</div>
				</div>
			</div>
			<div class="large-8 cell">
				<h5>Backpack</h5>
				<div class="container border-r lg-padding">
					<div class="edit-character-categories text-center">
						<a onclick="updateInventory(\'hat\',1)" id="hat-link">Hats</a>
						&nbsp;|&nbsp;
						<a onclick="updateInventory(\'faces\',1)"id="faces-link">Faces</a>
						&nbsp;|&nbsp;
						<a onclick="updateInventory(\'accessories\',1)" id="accessories-link">Accessories</a>
						&nbsp;|&nbsp;
						<a onclick="updateInventory(\'shirts\',1)" id="shirts-link">Shirts</a>
						&nbsp;|&nbsp;
						<a onclick="updateInventory(\'pants\',1)" id="pants-link">Pants</a>
					</div>
					<input type="text" id="search" class="edit-character-search" onchange="updateInventory(lastType, lastPage, this.value)" placeholder="Search">
					<div style="height:15px;"></div>
					<div id="inventory-box"></div>
				</div>
				<div style="height:25px;"></div>
				<h5>Wearing</h5>
				<div class="container border-r lg-padding">
					<div id="wearing-box"></div>
				</div>
			</div>
		</div>
		';

	}

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");
