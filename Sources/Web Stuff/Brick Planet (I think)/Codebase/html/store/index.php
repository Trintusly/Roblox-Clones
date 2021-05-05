<?php
$page = 'store';
require_once($_SERVER['DOCUMENT_ROOT']."/../private/header.php");
	
	echo '
	<script>
		document.title = "Store - Brick Planet";
		
		var selectedTab, selectedTabElement, currentPage = 1;
		
		window.onload = function() {
			switchCategory(\'recent\');
			
			document.getElementById("store-search").onkeypress = function(e) {
				if (!e) e = window.event;
				var keyCode = e.keyCode || e.which;
				if (keyCode == "13") {
					if (document.getElementById("store-search").value != "") {
						$.get("'.$serverName.'/store/search/" + selectedTab + "/" + document.getElementById("store-search").value + "/" + 1 + "/", function(data, status) {
							document.getElementById("items-div").innerHTML = data;
						});
					} else {
						$.get("'.$serverName.'/store/fetch/" + selectedTab + "/" + 1 + "/", function(data, status) {
							document.getElementById("items-div").innerHTML = data;
						});

					}
				}
			}
		}
		
		function switchCategory(Id, Page) {
			if (Page === undefined) {
				Page = 1;
			}
			if (selectedTab != Id || currentPage != Page) {
				if (!selectedTab) {
					selectedTab = Id;
				}
				currentPage = Page;
				document.getElementById(selectedTab).classList.remove("active");
				document.getElementById(Id).classList.add("active");
				selectedTab = Id;
				$.get("'.$serverName.'/store/fetch/" + Id + "/" + Page + "/", function(data, status) {
					document.getElementById("items-div").innerHTML = data;
				});
			}
		}
	</script>
	';
	
	if ($SiteSettings->CatalogPurchases == 0) {
		
		echo '
		<div class="error-message">
			<span><i class="material-icons" style="vertical-align:middle;margin-right:5px;font-size:20px;">report_problem</i></span><span><strong>Oops!</strong> Store purchases are currently down. We will have them back up soon!</span>
		</div>
		';
	}
	
	echo '
	<div class="grid-x grid-margin-x">
		<div class="auto cell no-margin">
			<h4>Store</h4>
		</div>
		<div class="shrink cell right no-margin">
			';
			
			if ($AUTH) {
			
				echo '
				<button class="button button-green" type="button" data-toggle="dropdown">Create</button>
				<div class="dropdown-pane creator-area-dropdown" id="dropdown" data-dropdown data-hover="true" data-hover-pane="true">
					<ul>
						<li><a href="'.$serverName.'/creator-area/create/shirt/">Create Shirt</a></li>
						<li><a href="'.$serverName.'/creator-area/create/pants/">Create Pants</a></li>
					</ul>
				</div>
				';
			
			}
			
			echo '
		</div>
	</div>
	<div class="store-topbar">
		<div class="grid-x align-middle grid-margin-x">
			<div class="auto cell no-margin">
				<ul>
					<li id="recent" onclick="switchCategory(\'recent\')" class="active">RECENT</li>
					<li id="hats" onclick="switchCategory(\'hats\')">HATS</li>
					<li id="faces" onclick="switchCategory(\'faces\')">FACES</li>
					<li id="accessories" onclick="switchCategory(\'accessories\')">ACCESSORIES</li>
					<li id="shirts" onclick="switchCategory(\'shirts\')">SHIRTS</li>
					<li id="pants" onclick="switchCategory(\'pants\')" class="no-right-border">PANTS</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="items-div"></div>
	';
	
require_once($_SERVER['DOCUMENT_ROOT']."/../private/footer.php");