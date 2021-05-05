$(document).ready(function(){
  function error(msg)
  {
    $(".danger").text(msg);
    $(".danger").removeClass("hidden");
    window.setTimeout(function(){
      $(".danger").addClass("hidden");
    }, 3000);
  }
  function success(msg)
  {
    $(".banner.success").text(msg);
    $(".banner.success").removeClass("hidden");
    window.setTimeout(function(){
      $(".banner.success").addClass("hidden");
    }, 3000);
  }
  $(".declineMember").click(function(){
    $.post("/community/js/approvedecline.php",
    {
      "req": "decline",
      "tid": $(this).attr("pid")
    }, function(reply){
      if(reply.status == "ok")
      {
        success(reply[0]);
      } else {
        error(reply.error);
      }
    });
  });
  $(".approveMember").click(function(){
    $.post("/community/js/approvedecline.php",
    {
      "req": "approve",
      "tid": $(this).attr("pid")
    }, function(reply){
      if(reply.status == "ok")
      {
        success(reply[0]);
      } else {
        error(reply.error);
      }
    });
  });
});
