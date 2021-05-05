<?php
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");

	if (empty($_GET['u'])) {
		
		header("Location: /search/");
		die;
		
	}
	
	$getUser = $db->prepare("SELECT Username FROM User WHERE Username = ?");
	$getUser->bindValue(1, $_GET['u'], PDO::PARAM_STR);
	$getUser->execute();
	
	if ($getUser->rowCount() == 0) {
		
		header("Location: /search/");
		die;
		
	}
	
	$gU = $getUser->fetch(PDO::FETCH_OBJ);
	
	echo '
	<script>document.title = "'.$gU->Username.'\'s Backpack - Brick Create";</script>
	<div class="grid-x grid-margin-x align-middle">
		<div class="auto cell no-margin">
			<h4>'.$gU->Username.'\'s Backpack</h4>
		</div>
		<div class="shrink cell right no-margin">
			<a href="'.$serverName.'/users/'.$gU->Username.'/" class="button button-grey" style="padding: 8px 15px;font-size:13px;line-height:1.25;">Return to Profile</a>
		</div>
	</div>
	<div class="push-10"></div>
	<div class="container border-r md-padding">
		<div class="grid-x grid-margin-x">
			<div class="large-2 cell no-margin">
				<script>
					var currentTab = 1;
					function userbackpack(Id, Page) {
						if (Page === undefined) {
							Page = 1;
						}
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								document.getElementById("UserbackpackDiv").innerHTML = xhttp.responseText;
								if (Id != currentTab) {
									document.getElementById("tab"+Id).classList.add("active");
									document.getElementById("tab"+currentTab).classList.remove("active");
									currentTab = Id;
								}
							}
						};
						xhttp.open("GET", "'.$serverName.'/users/'.$gU->Username.'/backpack/fetch/" + Id +"/" + Page + "/", true);
						xhttp.send();
					}
					
					window.onload = function() {
						userbackpack(1);
					}
				</script>
				<ul class="user-backpack-side-menu">
					<li id="tab7" onclick="userbackpack(7)">Crates</li>
					<li id="tab1" onclick="userbackpack(1)" class="active">Hats</li>
					<li id="tab2" onclick="userbackpack(2)">Faces</li>
					<li id="tab3" onclick="userbackpack(3)">Accessories</li>
					<li id="tab5" onclick="userbackpack(5)">Shirts</li>
					<li id="tab6" onclick="userbackpack(6)">Pants</li>
				</ul>
			</div>
			<div class="large-10 cell no-margin">
				<div id="UserbackpackDiv"></div>
			</div>
		</div>
	</div>
	';

require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");