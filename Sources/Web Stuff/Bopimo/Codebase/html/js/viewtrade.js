$(function () {
	tradeID = $('#tradeId').data('tradeid');
	$('#decline:not(.disabled)').click(function () {
		decline(tradeID);
	})
	$('#cancel:not(.disabled)').click(function () {
		cancel(tradeID);
	})
	$('#accept:not(.disabled)').click(function () {
		accept(tradeID);
	})
});

 function decline() {
	response("https://www.bopimo.com/api/trade/update.php?id=" + tradeID)
	.success(function () {
		location.reload();
	})
	.fail(function (error) {
		console.log(error);
	}).post({action: "decline", token: null});
}

 function cancel() {
	response("https://www.bopimo.com/api/trade/update.php?id=" + tradeID)
	.success(function () {
		location.reload();
	})
	.fail(function (error) {
		console.log(error);
	}).post({action: "cancel", token: null});
}

 function accept() {
	response("https://www.bopimo.com/api/trade/update.php?id=" + tradeID)
	.success(function () {
		location.reload();
	})
	.fail(function (error) {
		console.log(error);
	}).post({action: "accept", token: null});
}