$(function () {
		$(document).on('change', '#image', function (e) {
		
			if ($("#image").val().length > 0) { 
				
				file = $("#image")[0].files[0];
				allowedType = /image.*/;
				
				if (file.type.match(allowedType)) {

					$("#label").text("File: " + $("#image").val().replace(/.*[\/\\]/, ''));
				} else {
					$('#error').html("File must be an image");
				}
			}
		});
		
		$("#create").click(function () {
			fd = new FormData();
			fd.append('name', $('#name').val());
			fd.append('description', $('#description').val());
			fd.append('tag', $('#tag').val());
			fd.append('postable', $('#postable option:selected').val());
			fd.append('type', $('#type option:selected').val());
			fd.append('logo', $("#image")[0].files[0]);
			fd.append('token', $("meta[name=token]").attr("content"));
			
			$.ajax({
					url: "/api/community/create.php",
					data: fd,
					processData: false,
					contentType: false,
					type: "POST",
					mimeType: 'multipart/form-data',
					success: function (data) {
							data = $.parseJSON(data);
							if (data.status == "ok") {
								alert('yay');
							} else {
								if (data.hasOwnProperty("error")) {
									$("#error").html(data.error);
								} 	else {
									$("#error").html("There was an error with handling your request.");
								}
							}
						}
				
			});
	
		})
})