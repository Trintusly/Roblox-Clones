inuse = [];
inuseWant = [];
$(function () {
	myId = $("#myInvSearch").data('user-id');
	userId = $("#userInvSearch").data('user-id');
	
	myPage = 1;
	userPage = 1;
	
	tradeables(myId,1,'#myInv', '#myPages')
	tradeables(userId,1,'#userInv', "#userPages")
	
	$('#sendTrade').click(function () {
		var giving = [];
		$("#giving .trade-item").each(function () {
			var obj = {}
			obj["id"] = $(this).data('id')
			obj["serial"] = $(this).data('serial')
			giving.push(obj);
			count++;
		});
		
		var want = [];
		$("#want .trade-item").each(function () {
			var obj = {}
			obj["id"] = $(this).data('id')
			obj["serial"] = $(this).data('serial')
			want.push(obj);
			count++;
		});
		
		sendTrade(myId, userId, giving, want);
	})
	
	
	$('#myInvSearch').keypress(function (event){
		if (event.which  == 13) {
			myPage=1;
			tradeables(myId,1,'#myInv','#myPages', $('#myInvSearch').val());
		}
	})
	
	$('#userPages').on('click', '.next', function () {
		userPage += 1;
		tradeables(userId,userPage,'#userInv','#userPages', $('#userInvSearch').val());
	});
	
	$('#userPages').on('click', '.back', function () {
		userPage -= 1;
		tradeables(userId,userPage,'#userInv','#userPages', $('#userInvSearch').val());
	});
	
	$('#myPages').on('click', '.next', function () {
		myPage += 1;
		tradeables(myId,myPage,'#myInv','#myPages', $('#myInvSearch').val());
	});
	
	$('#myPages').on('click', '.back', function () {
		myPage -= 1;
		tradeables(myId,myPage,'#myInv','#myPages', $('#myInvSearch').val());
	});
	
	$('#userInvSearch').keypress(function (event){
		if (event.which  == 13) {
			userPage=1;
			tradeables(userId,1,'#userInv', '#userPages',$('#userInvSearch').val());
		}
	})
	
	$('#myInv').on('click', '.tradeable:not(.disabled)', function () {
		inuse.push($(this).data('id').toString() + $(this).data('serial').toString());
		addMiniItem('#giving', $(this).data('id'), $(this).data('serial'))
		$(this).addClass('disabled');
	})
	
	$('#userInv').on('click', '.tradeable:not(.disabled)', function () {
		inuseWant.push($(this).data('id').toString() + $(this).data('serial').toString());
		addMiniItem('#want', $(this).data('id'), $(this).data('serial'))
		$(this).addClass('disabled');
	})
	
	$('#giving, #myInv, #userInv, #want').on('click', '.trade-item, .tradeable.disabled', function () {

		removeMiniItem($(this).data('id'), $(this).data('serial'));
	})
});

function sendTrade( fromId, toId, sending, wantingE ) {
	response("https://www.bopimo.com/api/trade/trade.php").success(function (data) {
		window.location = "/trades/"
	})
	.post({token: null, giving: sending, wanting: wantingE, to: toId});
}

function tradeables(uid,page,target,pageTarget,searchQuery = "") {
	response("https://www.bopimo.com/api/shop/inventory.php?page="+page+"&category=tradeable&userId=" + uid + "&query=" + searchQuery)
	.success(function (data) {
		$(target).html("");
		count = 1;
		$.each(data.data, function (index, item) {
			noMargin = false;
			if (count%4 == 0 && count != 0) {
				noMargin = true;
			}
			addItem(target, item.id, item.name, item.serial, noMargin)
			count++
		});
		togglePages(pageTarget, page, data.totalPages)
	}).fail (function (error) {
		$(target).html("<div style='color:grey;font-weight:600;text-align:center;color: #808080;'>" + error + "</div>");
	})
	.get()
}

function addItem(target, id, name, serial, noMargin = false) {
	$(target).append('<div class="shop-item-container '+((noMargin) ? 'no-margin' : '')+'">\
			<div class="shop-item tradeable '+((inuse.includes(id.toString() + serial.toString()) || inuseWant.includes(id.toString() + serial.toString())) ? 'disabled' : '')+' " data-id="'+id+'" data-serial="'+serial+'">\
				<div class="preview">\
					<img src="https://storage.bopimo.com/thumbnails/'+id+'.png">\
				</div>\
				<div class="name" style="padding:5px;text-overflow: ellipsis;">'+name+'</div>\
				<div class="serial" style="padding-left:5px;color: grey;">#'+serial+'</div>\
			</div>\
		</div>');
}

function addMiniItem(target, id, serial) {
	$(target).append('<div class="col-1-4 trade-item" data-id="'+id+'" data-serial="'+serial+'">\
				<div class="serial">#'+serial+'</div>\
				<img class="width-100" src="https://storage.bopimo.com/thumbnails/'+id+'.png">\
			</div>');
}

function removeMiniItem(id, serial) {
	inuse.splice($.inArray(id.toString() + serial.toString(), inuse), 1);
	inuseWant.splice($.inArray(id.toString() + serial.toString(), inuseWant), 1);
	$('#giving .trade-item[data-id='+id+'][data-serial='+serial+'], #want .trade-item[data-id='+id+'][data-serial='+serial+']').remove();
	$('.tradeable.disabled[data-id='+id+'][data-serial='+serial+']').removeClass('disabled');
}

function togglePages(target, currentPage, totalPages) {
	if (currentPage == 1 && totalPages == 1) {
		//show nothing
	} else if (currentPage == totalPages) {
		//show only back button
		$(target).html('<button style="float: left; width: auto;" class="shop-search-button back"><i class="fas fa-chevron-left"></i></button>');
	} else if (currentPage == 1) {
		//show only the forward button
		$(target).html('<button style="float: right; width: auto;" class="shop-search-button next"><i class="fas fa-chevron-right"></i></button>');
	} else {
		//show both buttons
		$(target).html('<button style="float: left; width: auto;" class="shop-search-button back"><i class="fas fa-chevron-left"></i></button><button style="float: left; width: auto;" class="shop-search-button next"><i class="fas fa-chevron-right"></i></button>');
	}
}