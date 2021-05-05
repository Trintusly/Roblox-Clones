<? include"../../header.php"; if ($user){ ?>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<style>.link-side{display:block;padding:5px;cursor:pointer;color:#666666;border-bottom:1px solid #DEDEDE;}.link-side:hover{background:#F2F2F2!important;}</style>
<script>
		
		function game() {
			document.getElementById("game").style.backgroundColor = "#F2F2F2";
			document.getElementById("group").style.backgroundColor = "#FFFFFF";
			document.getElementById("advertisement").style.backgroundColor = "#FFFFFF";
			document.getElementById("tshirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("shirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("pants").style.backgroundColor = "#FFFFFF";
			
			document.getElementById("create-game").style.display = "block";
			document.getElementById("create-group").style.display = "none";
			document.getElementById("create-advertisement").style.display = "none";
			document.getElementById("create-tshirt").style.display = "none";
			document.getElementById("create-shirt").style.display = "none";
			document.getElementById("create-pants").style.display = "none";
		}
		
		function group() {
			document.getElementById("game").style.backgroundColor = "#FFFFFF";
			document.getElementById("group").style.backgroundColor = "#F2F2F2";
			document.getElementById("advertisement").style.backgroundColor = "#FFFFFF";
			document.getElementById("tshirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("shirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("pants").style.backgroundColor = "#FFFFFF";
			
			document.getElementById("create-game").style.display = "none";
			document.getElementById("create-group").style.display = "block";
			document.getElementById("create-advertisement").style.display = "none";
			document.getElementById("create-tshirt").style.display = "none";
			document.getElementById("create-shirt").style.display = "none";
			document.getElementById("create-pants").style.display = "none";
		}
		
		function advertisement() {
			document.getElementById("game").style.backgroundColor = "#FFFFFF";
			document.getElementById("group").style.backgroundColor = "#FFFFFF";
			document.getElementById("advertisement").style.backgroundColor = "#F2F2F2";
			document.getElementById("tshirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("shirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("pants").style.backgroundColor = "#FFFFFF";
			
			document.getElementById("create-game").style.display = "none";
			document.getElementById("create-group").style.display = "none";
			document.getElementById("create-advertisement").style.display = "block";
			document.getElementById("create-tshirt").style.display = "none";
			document.getElementById("create-shirt").style.display = "none";
			document.getElementById("create-pants").style.display = "none";
		}
		
		function tshirt() {
			document.getElementById("game").style.backgroundColor = "#FFFFFF";
			document.getElementById("group").style.backgroundColor = "#FFFFFF";
			document.getElementById("advertisement").style.backgroundColor = "#FFFFFF";
			document.getElementById("tshirt").style.backgroundColor = "#F2F2F2";
			document.getElementById("shirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("pants").style.backgroundColor = "#FFFFFF";
			
			document.getElementById("create-game").style.display = "none";
			document.getElementById("create-group").style.display = "none";
			document.getElementById("create-advertisement").style.display = "none";
			document.getElementById("create-tshirt").style.display = "block";
			document.getElementById("create-shirt").style.display = "none";
			document.getElementById("create-pants").style.display = "none";
		}
		
		function shirt() {
			document.getElementById("game").style.backgroundColor = "#FFFFFF";
			document.getElementById("group").style.backgroundColor = "#FFFFFF";
			document.getElementById("advertisement").style.backgroundColor = "#FFFFFF";
			document.getElementById("tshirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("shirt").style.backgroundColor = "#F2F2F2";
			document.getElementById("pants").style.backgroundColor = "#FFFFFF";
			
			document.getElementById("create-game").style.display = "none";
			document.getElementById("create-group").style.display = "none";
			document.getElementById("create-advertisement").style.display = "none";
			document.getElementById("create-tshirt").style.display = "none";
			document.getElementById("create-shirt").style.display = "block";
			document.getElementById("create-pants").style.display = "none";
		}
		
		function pants() {
			document.getElementById("game").style.backgroundColor = "#FFFFFF";
			document.getElementById("group").style.backgroundColor = "#FFFFFF";
			document.getElementById("advertisement").style.backgroundColor = "#FFFFFF";
			document.getElementById("tshirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("shirt").style.backgroundColor = "#FFFFFF";
			document.getElementById("pants").style.backgroundColor = "#F2F2F2";
			
			document.getElementById("create-game").style.display = "none";
			document.getElementById("create-group").style.display = "none";
			document.getElementById("create-advertisement").style.display = "none";
			document.getElementById("create-tshirt").style.display = "none";
			document.getElementById("create-shirt").style.display = "none";
			document.getElementById("create-pants").style.display = "block";
		}
		
		window.onload = function() {
			document.getElementById("tshirt").style.backgroundColor = "#F2F2F2";
		}
	</script>
<div class="content-box">
<div class="row">
<div class="col s12 m2 l2">
<div style="border-bottom: 1px solid #DEDEDE;"></div>
<a class="link-side" onclick="game()" id="game">Game</a>
<a class="link-side" onclick="group()" id="group">Group</a>
<a class="link-side" onclick="advertisement()" id="advertisement">Advertisement</a>
<a class="link-side" onclick="tshirt()" id="tshirt" style="background-color: rgb(242, 242, 242);">T-Shirt</a>
<a class="link-side" onclick="shirt()" id="shirt">Shirt</a>
<a class="link-side" onclick="pants()" id="pants">Pants</a>
</div>
<div class="col s12 m10 l10">
<div id="create-game" style="display:none;">
<div class="header-text">Create Game</div>
<p>This feature is coming soon.</p>
</div>
<div id="create-group" style="display:none;">
<div class="header-text">Create Group</div>
<div style="height:15px;"></div>
<form action="" method="POST" enctype="multipart/form-data">
<label for="GroupName">Group Name</label>
<input type="text" class="general-textarea" name="GroupName" id="GroupName">
<div style="height:15px;"></div>
<label for="GroupDescription">Group Description</label>
<textarea class="general-textarea" name="GroupDescription" id="GroupDescription" style="height:125px !important;"></textarea>
<div style="height:15px;"></div>
<input type="file" name="Logo" id="Logo" style="width:186px;font-size:14px;">
<div style="height:15px;"></div>
<input type="submit" name="CreateGroup" class="groups-blue-button" value="Create Group">
<div style="height:15px;"></div>
<div style="font-size:14px;">Creating a group will cost <font style="color:#15BF6b;">$50 Cash</font>.</div>
</form>
</div>
<div id="create-advertisement" style="display:none;">
<div class="header-text">Create Advertisement</div>
<p>This feature is coming soon.</p>
</div>
<div id="create-tshirt">
<div class="row">
<div class="col s6">
<div class="header-text">Create T-Shirt</div>
<div style="height:15px;"></div>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="WoE7KcrBGH8AByRxI22MZSc/IzB0FJ6AVVtFgZOJLbI=">
<input type="text" name="uploadTShirtName" id="uploadTShirtName" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Title">
<div style="height:15px;"></div>
<textarea name="uploadTShirtDescription" id="uploadTShirtDescription" style="margin:0;border:0;box-sizing:border-box;padding:0;height:125px;border:2px solid #ddd !important;font-size:15px;padding:6px 12px;outline:none;" placeholder="Description"></textarea>
<div style="height:15px;"></div>
<input type="text" name="uploadTShirtPrice" id="uploadTShirtPrice" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Price (Coins)">
<div style="height:15px;"></div>
<input type="text" name="uploadTShirtPriceCash" id="uploadTShirtPriceCash" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Price (Cash)">
<div style="height:15px;"></div>
<input type="file" name="file" id="file" style="font-size:14px;">
<div style="height:15px;"></div>
<style>.edit-hover:hover{background:#1F89DE!important;}</style>
<input type="submit" name="uploadTShirtSubmit" id="uploadTShirtSubmit" value="Upload" style="display:inline-block;background:#2196F3;color:white;padding:5px 15px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="edit-hover">
</form>
</div>
<div class="col s6">
<div style="font-size:14px;">
<div class="header-text">Tips</div>
<div style="height:15px;"></div>
Uploading a item may be confusing at first, but we've answered the most common questions below for your convenience. Need more help? Send an email to <a href="support@bloxcreate.site">support@bloxcreate.site</a> and we can assist you further.<br><br>
<strong>What is an item?</strong>
A item is a virtual asset on BloxCreate which you create and upload to BloxCreate.
<br><br>
<strong>What is the best size for an item?</strong>
The power of two is best; for example, 128x128, 256x256, or 512x512 will be optimal when uploading a T-Shirt.
</div>
</div>
</div>
</div>
<div id="create-shirt" style="display:none;">
<div class="row">
<div class="col s6">
<div class="header-text">Create Shirt</div>
<div style="height:15px;"></div>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="WoE7KcrBGH8AByRxI22MZSc/IzB0FJ6AVVtFgZOJLbI=">
<input type="text" name="uploadShirtName" id="uploadShirtName" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Title">
<div style="height:15px;"></div>
<textarea name="uploadShirtDescription" id="uploadShirtDescription" style="margin:0;border:0;box-sizing:border-box;padding:0;height:125px;border:2px solid #ddd !important;font-size:15px;padding:6px 12px;outline:none;" placeholder="Description"></textarea>
<div style="height:15px;"></div>
<input type="text" name="uploadShirtPrice" id="uploadShirtPrice" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Price (Coins)">
<div style="height:15px;"></div>
<input type="text" name="uploadShirtPriceCash" id="uploadShirtPriceCash" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Price (Cash)">
<div style="height:15px;"></div>
<input type="file" name="file" id="file" style="font-size:14px;">
<div style="height:15px;"></div>
<style>.edit-hover:hover{background:#1F89DE!important;}</style>
<input type="submit" name="uploadShirtSubmit" id="uploadShirtSubmit" value="Upload" style="display:inline-block;background:#2196F3;color:white;padding:5px 15px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="edit-hover">
</form>
</div>
<div class="col s6">
<div style="font-size:14px;">
<div class="header-text">Template</div>
<div style="height:15px;"></div>
<a href="https://storage.googleapis.com/bloxcity-file-storage/templates/ClothingTemplate.png" target="_blank" title="Template (Click to Enlarge)" alt="Template (Click to Enlarge)"><img src="https://storage.googleapis.com/bloxcity-file-storage/templates/ClothingTemplate.png" class="responsive-img"></a>
</div>
</div>
</div>
</div>
<div id="create-pants" style="display:none;">
<div class="row">
<div class="col s6">
<div class="header-text">Create Pants</div>
<div style="height:15px;"></div>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="csrf_token" value="WoE7KcrBGH8AByRxI22MZSc/IzB0FJ6AVVtFgZOJLbI=">
<input type="text" name="uploadPantsName" id="uploadPantsName" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Title">
<div style="height:15px;"></div>
<textarea name="uploadPantsDescription" id="uploadPantsDescription" style="margin:0;border:0;box-sizing:border-box;padding:0;height:125px;border:2px solid #ddd !important;font-size:15px;padding:6px 12px;outline:none;" placeholder="Description"></textarea>
<div style="height:15px;"></div>
<input type="text" name="uploadPantsPrice" id="uploadPantsPrice" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Price (Coins)">
<div style="height:15px;"></div>
<input type="text" name="uploadPantsPriceCash" id="uploadPantsPriceCash" style="margin:0;border:0;box-sizing:border-box;padding:0;height:35px;border:2px solid #ddd !important;font-size:15px;padding:0 12px;" placeholder="Price (Cash)">
<div style="height:15px;"></div>
<input type="file" name="file" id="file" style="font-size:14px;">
<div style="height:15px;"></div>
<style>.edit-hover:hover{background:#1F89DE!important;}</style>
<input type="submit" name="uploadPantsSubmit" id="uploadPantsSubmit" value="Upload" style="display:inline-block;background:#2196F3;color:white;padding:5px 15px;font-size:14px;font-weight:500;border:0;border-radius:2px;border-bottom:1px solid #207FC9;outline:none;" class="edit-hover">
</form>
</div>
<div class="col s6">
<div style="font-size:14px;">
<div class="header-text">Template</div>
<div style="height:15px;"></div>
<a href="https://storage.googleapis.com/bloxcity-file-storage/templates/ClothingTemplate.png" target="_blank" title="Template (Click to Enlarge)" alt="Template (Click to Enlarge)"><img src="https://storage.googleapis.com/bloxcity-file-storage/templates/ClothingTemplate.png" class="responsive-img"></a>
</div>
</div>
</div>
</div>
</div>
</center>
<? } include "../../footer.php"; ?>