<?php 

require("/var/www/html/api/shop/shop.php");
require("../site/header.php");
?>
<style>
.view-trade-box {
	border-radius: 5px;
	background-color: #fff;
	display: flex;
	flex-direction: row;
}
.view-trade-box a.profile {
	color: #000;
	padding: 5px;
	width: 50%;
}
.view-trade-box .arrow-container {
	border-radius: 0px 5px 5px 0px;
	align-self: stretch;
	width: 50%;
	background-color: #7660E4;
	color: #fff;
	text-align: center;
	font-size: 2.5rem;
	display: flex;
	align-items: center;
	justify-content: center;
}

.view-trade-box .arrow-container.red {
	background-color: #de5656;
}

.view-trade-box .arrow-container.green {
	background-color: #4cce4a;
}

.view-trade-box .arrow-container.grey {
	background-color: #afafaf;
}

.view-trade-box .arrow-container .arrow {
	margin-left: -5px;
	transition: .2s;
}

.view-trade-box .arrow-container:hover .arrow {
	margin-left: 8px;
}
</style>
<div class='page-title'>
	Trades
</div>
<div class="tab-container" style="margin-bottom: 6px;">
	<div class="tab col-1-3 current" id="pendingTrades">
		Recieved (<span id='recievedNum'>0</span>)
	</div>
	<div class="tab col-1-3" id="sentTrades">
		Sent (<span id='sentNum'>0</span>)
	</div>
	<div class="tab col-1-3" id="historyTrades">
		History (<span id='historyNum'>0</span>)
	</div>
</div>
<div id="trades">
	
</div>
<script src="/js/tradesHome.js"></script>
<?php
require("../site/footer.php")
?>