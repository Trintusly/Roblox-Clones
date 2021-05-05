$(document).ready(function(){
  $("#mainForm").submit(function(event){
    event.preventDefault();
    var search = $("#searchQuery").val();
    $.post("look_for.php", {"search": search}, function(reply){
      $("#searches").html("");
      reply.res.forEach(function(item, index){
        $("#searches").append("<div class='col-2-12' style='padding-right:0px;'><a href='#' class='clickSelect' username='"+item.username+"' uid='"+item.id+"' style='color:black;'><center><img src='https://storage.bopimo.com/avatars/"+item.cache+".png' class='image'>"+item.username+"</center></a></div>");
      });
    });
  });

  $("#searches").on("click", ".clickSelect", function(){
    var username = $(this).attr("username");
    var id = $(this).attr("uid");
    $("#username").val(username);
    $("#username").attr("username", username);
    $("#username").attr("uid", id);
    $("#username").css("color", "green");
    $("#composeTo").html("Compose a message to "+username);
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
  $("#messageForm").submit(function(event){
    event.preventDefault();
    var body = $("#body").val();
    var title = $("#title").val();
    $.post("send.php", {
      "body": body,
      "title": title,
      "uid": $("#username").attr("uid"),
      "token": $("meta[name=token]").attr("content")
    }, function(reply){
      console.log(reply);
      if(reply.status == "ok") {
        document.location = "https://www.bopimo.com/message/view/"+reply.msg.id;
      } else {
        fail(reply.error);
      }
    });
  });
});
