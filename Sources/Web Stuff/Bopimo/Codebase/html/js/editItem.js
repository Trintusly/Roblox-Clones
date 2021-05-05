$(function() {
	
	itemId = $("#update").data("item-id");
	
	$("#sale").change( function () {
		if ($("#sale").val() == 1) {
			$("#price").prop("disabled", true);
			$("#notUpdateHolder").html("");
			$("#updateHolder").removeClass("col-1-2");
		} else if ($("#sale").val() == "tradeable") {
			$("#updateHolder").addClass("col-1-2");
			$("#notUpdateHolder").addClass("col-1-2");
			$("#notUpdateHolder").html('<input id="stock" class="width-100" type="number" placeholder="Stock" />');
		} else {
			$("#updateHolder").removeClass("col-1-2");
			$("#notUpdateHolder").html("");
			$("#price").prop("disabled", false);
		}
	});
		
	$("#title").on("input",function () {
		if ($(this).val().length > 30) {
			$("#titleError").html("Title must be shorter than 30 characters (" + $(this).val().length + ")");
			$(this).addClass('invalid');
		} else if ($(this).val().length <= 30) {
			$("#titleError").html("");
			$(this).removeClass('invalid');
		}
	});
	
	$("#description").on("input",function () {
		if ($(this).val().length > 750) {
			$("#descriptionError").html("Description must be shorter than 750 characters  (" + $(this).val().length + ")");
			$(this).addClass('invalid');
		} else if ($(this).val().length <= 750) {
			$("#descriptionError").html("");
			$(this).removeClass('invalid');
		}
	});
	
	$("#update").click(function () { update(); });
	
	function update() {
		stockNum = 0;
		tradeable = 0;
		if($("#stock").length > 0 && $("#sale").val() == "tradeable") {
			stockNum = $("#stock").val();
		}
		response("/api/shop/edit.php").success(function (data) {
			$("#response").html("<div class='banner success'>Item has been updated</div>");
		}).fail(function (error) {
			$("#response").html("<div class='banner danger'>"+error+"</div>");
		}).post({ itemId: $("#update").data("item-id"), stock: stockNum, title: $("#title").val(), description: $("#description").val(), saleType: $("#sale").val(), price: $("#price").val(), token: null });
	}
	
	if ($("#epiccontainer").length > 0) {
		getBundles($("#update").data("item-id"));
	}
	
	
	$('#addBundle').click(function () {
		addToBundle($('#addId').val(), itemId)
	})
	
	$('#epiccontainer').on('click', '.fa-minus', function () {
		removeFromBundle($(this).data('item-id'), itemId);
	});
	

	
	function addToBundle(itemId, id) {
		$.post("/api/shop/configureBundle.php?id=" + id, {add: itemId}, function (data) {
			getBundles(id);
		});
	}
	
	function removeFromBundle(itemId, id) {
		$.post("/api/shop/configureBundle.php?id=" + id, {remove: itemId}, function (data) {
			getBundles(id);
		});
	}
	
	function getBundles(id) {
		$("#epiccontainer").html("");
		$.get("/api/shop/configureBundle.php?id=" + id, function (data) {
			if (data.data) {
				$.each(data.data, function (i, item) {
					$("#epiccontainer").append('<div class="card border" style="font-size: 1.2rem;line-height:56px;">\
				<div class="col-3-12" >\
					<img class="width-100" src="https://storage.bopimo.com/thumbnails/'+item.item_id+'.png">\
				</div>\
				<div class="col-7-12" style="text-overflow: ellipsis;font-size:1.2rem;white-space:no-wrap;overflow:hidden;">'+item.name+'</div>\
				<div class="col-2-12 text-center" style="text-align:center;">\
					<i class="fas fa-minus delete" data-item-id="'+item.item_id+'" style="font-size:2rem;line-height:63px;"></i>\
				</div>\
			</div>');
				})
				
			}
		});
	}
	
})