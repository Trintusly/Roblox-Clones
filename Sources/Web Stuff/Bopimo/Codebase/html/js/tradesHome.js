$(function () {
	loadNums();
	loadTrades("rec");
	$('#pendingTrades').click(function () {
		$('.tab.current').removeClass('current');
		$(this).addClass('current');
		loadTrades("rec");
	});
	$('#sentTrades').click(function () {
		$('.tab.current').removeClass('current');
		$(this).addClass('current');
		loadTrades("sent");
	});
	$('#historyTrades').click(function () {
		$('.tab.current').removeClass('current');
		$(this).addClass('current');
		loadTrades("history");
	});
});

function loadNums() {
	$.get("/api/trade/info.php", function (data) {
		$('#recievedNum').text(data.recieved);
		$('#sentNum').text(data.outgoing);
		$('#historyNum').text(data.history);
	})
}

function loadTrades(type) {
	$.get("/api/trade/load.php?type=" + type, function (data) {
		if (data.status == "error") {
			$("#trades").html("<div style='text-align:center;font-size:0.9rem;font-weight:600;color:#969696;'>"+data.error+"</div>");
		} else {
			$('#trades').html("");
			$.each(data.data, function (i,value) {
				appendTrade(value);
				
			});
		}
	});
}

function appendTrade(trade) {
	additionalText = "";
	color = "";
	switch (trade.status) {
		case "-2":
			color = "grey"
			additionalText = "(Canceled)"
			break;
		case "-1":
			color = "red"
			additionalText = "(Declined)"
			break;
		case "1":
			color = "green"
			additionalText = "(Accepted)"
			break;
	}
	
	$('#trades').append("<div style='margin-bottom:10px;' class='col-1-3'>\
		<div class='view-trade-box'>\
			<a class='profile' href='/profile/"+trade.oid+"'><div style='text-align:center;'>\
				<img src='https://storage.bopimo.com/avatars/"+trade.avatar+".png' style='width:70%;' />\
				<br>\
				"+trade.username+"\
			</div></a>\
			<a class='arrow-container "+color+"' href='/trade/view/"+trade.id+"'>\
				<div class='arrow' >\
					<i class='fas fa-arrow-right'></i>\
					<br>\
					<span style='font-size:0.8rem;'>View Trade "+((additionalText != "") ? "<br>" + additionalText : "")+"</span>\
				</div>\
			</a>\
		</div>\
	</div>");
}