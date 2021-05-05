<? include "../../header.php"; ?>
</center>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
<script>
		document.title = "My Trades | BLOXCreate";
	</script>
<style>.gray-h:hover{background:#F0F0F0!important;}</style>
<div style="display: inline-block; padding: 5px 15px; text-align: center; background: rgb(255, 255, 255); border-width: 1px 1px 0px; border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: rgb(221, 221, 221); border-right-color: rgb(221, 221, 221); border-left-color: rgb(221, 221, 221); border-image: initial; border-bottom-style: initial; border-bottom-color: initial; font-size: 16px; cursor: pointer; font-weight: bold;" onclick="incoming()" class="gray-h" id="incoming-tab">Incoming</div>
<div style="display: inline-block; padding: 5px 15px; text-align: center; background: rgb(255, 255, 255); border-width: 1px 1px 0px; border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: rgb(221, 221, 221); border-right-color: rgb(221, 221, 221); border-left-color: rgb(221, 221, 221); border-image: initial; border-bottom-style: initial; border-bottom-color: initial; font-size: 16px; cursor: pointer; font-weight: normal;" onclick="sent()" class="gray-h" id="sent-tab">Sent</div>
<div style="display: inline-block; padding: 5px 15px; text-align: center; background: rgb(255, 255, 255); border-width: 1px 1px 0px; border-top-style: solid; border-right-style: solid; border-left-style: solid; border-top-color: rgb(221, 221, 221); border-right-color: rgb(221, 221, 221); border-left-color: rgb(221, 221, 221); border-image: initial; border-bottom-style: initial; border-bottom-color: initial; font-size: 16px; cursor: pointer; font-weight: normal;" onclick="history()" class="gray-h" id="history-tab">History</div>
<div class="bc-content" id="Incoming" style="display: block; padding: 0px;">
<style>.hover{padding:5px;}.hover:hover{background:#fafafa;}</style>
<div style="padding:25px;">You do not have any incoming trades.</div>
</div>
<div class="bc-content" id="Sent" style="display: none; padding: 0px;">
<div style="padding:25px;">You do not have any outbound trades.</div>
</div>
<div class="bc-content" id="History" style="display: none; padding: 0px;">
<div style="padding:25px;">You do not have any trade history.</div>
</div>
<script>
		function incoming() {
			document.getElementById("Incoming").style.display = "block";
			document.getElementById("incoming-tab").style.fontWeight = "bold";
			document.getElementById("Sent").style.display = "none";
			document.getElementById("sent-tab").style.fontWeight = "normal";
			document.getElementById("History").style.display = "none";
			document.getElementById("history-tab").style.fontWeight = "normal";
		}
		
		function sent() {
			document.getElementById("Sent").style.display = "block";
			document.getElementById("sent-tab").style.fontWeight = "bold";
			document.getElementById("Incoming").style.display = "none";
			document.getElementById("incoming-tab").style.fontWeight = "normal";
			document.getElementById("History").style.display = "none";
			document.getElementById("history-tab").style.fontWeight = "normal";
		}
		
		function history() {
			document.getElementById("History").style.display = "block";
			document.getElementById("history-tab").style.fontWeight = "bold";
			document.getElementById("Sent").style.display = "none";
			document.getElementById("sent-tab").style.fontWeight = "normal";
			document.getElementById("Incoming").style.display = "none";
			document.getElementById("incoming-tab").style.fontWeight = "normal";
		}
	</script>
</div>
</div>
<? include "../../footer.php"; ?>