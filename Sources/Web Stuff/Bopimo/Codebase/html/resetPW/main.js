$(document).ready(function(){
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
  var uuid = $("#uuid").val();
  $("#submitReset").submit(function(event){
    event.preventDefault();
    $.post("/resetPW/resetSubmit.php", {
      "id": uuid,
      "pw1": $("#pw1").val(),
      "pw2": $("#pw2").val()
    }, function(reply){
      if(reply.status == "ok")
      {
        document.location = "/account/login/?reset";
      } else {
        fail(reply.error);
      }
    });
    //$.post("/resetPW/resetSubmit.php", {})
  });
});
