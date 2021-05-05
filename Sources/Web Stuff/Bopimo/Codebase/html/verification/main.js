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

  $("#updateEmail").submit(function(event){
    event.preventDefault();
    $.post("updateEmail.php", {
      "token": $("meta[name=token]").attr("content"),
      "email": $("#email").val()
    }, function(reply){
      if(reply.status == "ok")
      {
        location.reload();
      } else {
        fail(reply.error);
      }
    });
  });
});
