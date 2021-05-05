$(document).ready(function(){
	uid = $("#uid").data('id');

  $(".body").on("click", "#friend", function(){
    friend("add", uid)
  });

  $(".body").on("click", "#cancel", function(){
    friend("cancel", uid)
  });

  $("#unfriend").click(function(){
    friend("remove", uid)
  });
  
  
});
  function success ( msg )
  {
    $(".banner.success").text(msg);
    $(".banner.success").removeClass("hidden");
    window.setTimeout(function(){
      $(".banner.success").addClass("hidden");
    }, 3000);
  }
  function fail ( msg )
  {
    $(".banner.danger").text(msg);
    $(".banner.danger").removeClass("hidden");
    window.setTimeout(function(){
      $(".banner.danger").addClass("hidden");
    }, 3000);
  }

function changeButton ( action ) {
	switch (action) {
		case "add":
			$("#buttonHolder").html("<div class='button warning' id='cancel'>Cancel</div>");
			break;
		case "remove":
		case "cancel":
			$("#buttonHolder").html("<div class='button success' id='friend'>Friend</div>");
			break;
	}
}

function friend (action,userId) {
	response("/api/friends/friendRequest.php").success(function (data) {
			changeButton(action);
			success();
		}).fail(function (error) {
			fail();
		}).post({action: action,userId: userId, token: null});
}