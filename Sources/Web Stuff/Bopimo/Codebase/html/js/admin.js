$(function() {
	$("#comments").on("click", "span[data-delete-comment]", function () {
		console.log($(this));
		deleteComment($(this).data("delete-comment"));
	});
});

function deleteComment(commentId) {
	response("/api/admin/deleteComment.php").success(function (data) {
		loadComments();
		$("#responce").html("<div class='banner success'>Deleted Comment</div>");
	}).fail(function (error) {
		$("#responce").html("<div class='banner danger'>Error deleting comment ("+error+")</div>");
	}).post({commentId: commentId, token: null});
}

function declineItemYes (itemId) {
	response("/api/admin/pending.php").success(function (data) {
		$("#responce").html("<div class='banner success'>Declined Item</div>");
	}).fail(function (error) {
		$("#responce").html("<div class='banner danger'>Error ("+error+")</div>");
	}).post({item_id: itemId,action:"decline", token: null});
}

function approveItemYes (itemId) {
	response("/api/admin/pending.php").success(function (data) {
		$("#responce").html("<div class='banner success'>Accepted Item</div>");
	}).fail(function (error) {
		$("#responce").html("<div class='banner danger'>Error ("+error+")</div>");
	}).post({item_id: itemId,action:"approve", token: null});
}

function censorItem (itemId) {
	response("/api/admin/censorItem.php").success(function (data) {
		$("#responce").html("<div class='banner success'>Censored Item</div>");
	}).fail(function (error) {
		$("#responce").html("<div class='banner danger'>Error ("+error+")</div>");
	}).post({itemId: itemId, token: null});
}