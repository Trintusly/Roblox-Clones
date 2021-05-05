$(document).ready(function(){
  $(".shop-button").click(function(){
    if(!$(this).hasClass("current"))
    {
      $("#"+$(".current").attr("data-category")).addClass("hidden");
      $("#"+$(this).attr("data-category")).removeClass("hidden");
      $(".current").removeClass("current");
      $(this).addClass("current");
    }
  });

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
    }, 10000);
  }

  $("button").click(function(){
    $(this).prop("disabled", "true");
    if($(this).attr("req") == "bio") {
      $.post("/account/index.php", {
        req: "bio",
        bio: $("#bio").val()
      }, function(reply){
        if(reply.status == "ok")
        {
          success("Successfully changed bio.");
        } else {
          error(reply.error);
        }
      });
    }
  });

  $("#submitEmail").submit(function(event){
    event.preventDefault();
    console.log("submit");
    $.post("https://www.bopimo.com/verification/updateEmail.php", {
      "email": $("#email").val(),
      "token": $("meta[name=token]").attr("content")
    }, function(reply){
      if(reply.status == "ok")
      {
        location.reload();
      } else {
        error(reply.error);
      }
    });
  });

  $("#resetPassword").click(function(){
    $.post("changePassword.php", {
      "token": $("meta[name=token]").attr("content")
    }, function(reply){
      if(reply.status == "ok")
      {
        success(reply.msg);
      } else {
        error(reply.error);
      }
    });
  });
});
