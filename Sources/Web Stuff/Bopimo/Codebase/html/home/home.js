$(document).ready(function(){
  $("#statusUpdate").click(function(){
    function success ( msg )
    {
      $(".success").text(msg);
      $(".success").removeClass("hidden");
      window.setTimeout(function(){
        $(".success").addClass("hidden");
      }, 3000);
    }
    function fail ( msg )
    {
      $(".danger").text(msg);
      $(".danger").removeClass("hidden");
      window.setTimeout(function(){
        $(".danger").addClass("hidden");
      }, 3000);
    }

    $.post("/account/status.php", {status: $("#statusText").val()}, function(reply){
      if(reply.status == "ok")
      {
        success("Successfully changed status.");
      } else {
        fail(reply.error);
      }
    })
  });
});
