$(function() {
	$(".shop-button[data-category]").click(function (){ tab($(this))})
	
	function tab ( category ) {

		if (category.data('category') == 1 || category.data('category') == 2) {
			$("#button2").html('<input name="model" type="file" id="model" class="upload" />	<label for="model" id="labelM" class="button upload centered"><i class="fas fa-upload"></i> Choose a file (model)</label>');
			$('#previewSection').show();
		} else if (category.data('category') == 7) {
			console.log("unepic");
			$("#button2").html('');
			$('#previewSection').hide();
			$("#upload").css("opacity", "1");
		} else {
			$("#button2").html('');
			$('#previewSection').show();
		}
		$.each($(".shop-buttons").children(),function(){ $(this).removeClass("current") })
		$(".shop-button[data-category="+category.data('category')+"]").addClass("current");
		$("#previewImg").attr( 'src', category.data('category')+ ".png");
	}
	
	$("#sale").change( function () {
		if ($("#sale").val() == 1) {
			$("#price").prop("disabled", true);
		} else {
			$("#price").prop("disabled", false);
		}
	});
	if (!$('[data-category="7"]').hasClass('current')) {
	$(document).on('change', '#image', function (e) {
		
		if ($("#image").val().length > 0) {
		
			go = true
			model = false
			
			if ($("#button2").find("#model").length > 0) {
				model = true
				if ($("#model").val().length == 0) {
					go = false
				}
			}
			
			file = $("#image")[0].files[0];
			allowedType = /image.*/;
			
			if (file.type.match(allowedType)) {
				
					$("#preview").html('Render Preview');
				if (go) {
					preview($(".shop-button.current[data-category]").data("category"), model)
				}
					$("#label").text("File: " + $("#image").val().replace(/.*[\/\\]/, ''));
			} else {
				$("#image").val("");
				$("#label").html('<i class="fas fa-upload"></i> Choose a file');
				$("#preview").html('<span style="color: #e08a7d;"><i class="fas fa-exclamation-circle"></i> File must be an image <i class="fas fa-exclamation-circle"></i></span>');
			}
			
			canUpload();
		}
	});
	}
	$(document).on('change', '#model',function (e) {
		if ($("#model").val().length > 0) {
			go = true
			img = $("#button2").has("#image");
			
			if (img.length > 0) {
				if ($("#image").val().length == 0) {
					go = false
				}
			}
			
			file = $("#model")[0].files[0];
			allowedType = "text/plain"

			$("#preview").html('Render Preview');
			$("#upload").css("opacity", "1");
			if (go) {
				preview($(".shop-button.current[data-category]").data("category"), true)
			}
			$("#labelM").text("File: " + $("#model").val().replace(/.*[\/\\]/, ''));
		}
		
	});
	
	function preview (category, model = false) {
		fd = new FormData();
		fd.append("category", category);
		fd.append('texture', $("#image")[0].files[0]);
		
		if (model == true) {
			fd.append('model', $("#model")[0].files[0]);
		}
			
		$.ajax({
				url: "/api/shop/render.php",
				data: fd,
				processData: false,
				contentType: false,
				type: "POST",
				mimeType: 'multipart/form-data',
				success: function (data) {
						data = $.parseJSON(data);
						if (data.status == "ok") {
							$("#previewImg").attr("src", data.image);
						} else {
							if (data.hasOwnProperty("error")) {
								$("#generalError").html(data.error);
							} 	else {
								$("#generalError").html("There was an error with handling your request.");
							}
						}
					}
				
			});
	}
	
	function upload ( category, title, description, sale, price, model = false ) {
		
		if ($("#upload").css("opacity") == 1) {
			$("#upload").css("opacity", 0.5);
			values = { "category": category,"title": title, "description": description, "saleType": sale, "price": price, "token": $("meta[name=token]").attr("content") };
			fd = new FormData();
			
			$.each(values, function (i,v) {
				fd.append (i, v);
			});
			
			fd.append('texture', $("#image")[0].files[0]);
			if (model == true) {
				fd.append('model', $("#model")[0].files[0]);
			}
			
			$.ajax({
				url: "/api/shop/create.php",
				data: fd,
				processData: false,
				contentType: false,
				type: "POST",
				mimeType: 'multipart/form-data'
			}).done(function (result) {
				result = $.parseJSON(result);
				if (result.status == "ok") {
					window.location = "/item/" + result.id
				} else {
					if (result.status == "error") {
						if (result.hasOwnProperty("error")) {
							$("#generalError").html(result.error);
						} else {
							$("#generalError").html("There was an error with handling your request.");
						}
					}
				}
			});
		}
		
	}
	
	function canUpload (  ) {
		if ($("#title").val().length <= 30 && $("#description").val().length <= 750) {
			if (!$('[data-category="7"]').hasClass('current') && $("#image").val().length > 0) {
			$("#upload").css("opacity", 1);
			}
		} else {
			$("#upload").css("opacity", 0.5);
		}
	}
	
	$("#upload").click(function() {
	category =   $(".shop-button.current[data-category]").data("category");
	 model = (category == 1 || category == 2) ? true : false;
	upload(
		category,
		  $("#title").val(),
		  $("#description").val(),
		  $("#sale").val(),
		  $("#price").val(),
		  model
		  );
	});
	tab($(".shop-buttons .shop-button:first-child"))
	
	$("#title").on("input",function () {
		if ($(this).val().length > 30) {
			$("#titleError").html("Title must be shorter than 30 characters (" + $(this).val().length + ")");
			$(this).addClass('invalid');
		} else if ($(this).val().length <= 30) {
			$("#titleError").html("");
			$(this).removeClass('invalid');
		}
		canUpload();
	});
	
	$("#description").on("input",function () {
		if ($(this).val().length > 750) {
			$("#descriptionError").html("Description must be shorter than 750 characters  (" + $(this).val().length + ")");
			$(this).addClass('invalid');
		} else if ($(this).val().length <= 750) {
			$("#descriptionError").html("");
			$(this).removeClass('invalid');
		}
		canUpload();
	});
	
})