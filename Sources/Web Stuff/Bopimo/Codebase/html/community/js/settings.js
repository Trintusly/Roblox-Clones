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


  $("#updateDesc").click(function(){
    $.post("/community/update.php",
    {
      "req": "update description",
      "desc": $("#desc").val(),
      "cid": $(this).attr("cid"),
      "tid": 0
    }, function(reply){
      if(reply.status == "ok")
      {
        success(reply[0]);
      } else {
        error(reply.error);
      }
    });
  });

  $(".updateTagName").click(function(){
    $.post("/community/update.php",
    {
      "req": "update tag name",
      "desc": $("#title_"+$(this).attr("tid")).val(),
      "cid": $(this).attr("cid"),
      "tid": $(this).attr("tid")
    }, function(reply){
      if(reply.status == "ok")
      {
        success(reply[0]);
      } else {
        error(reply.error);
      }
    });
  });

  $(".member-tags").change(function(b){
    var selected = $(this).find(":selected");
    console.log(selected.attr("tid")+" "+selected.attr("cid")+" "+selected.attr("perm"));
    $.post("/community/update.php",
    {
      "req": "up",
      "desc": selected.attr("perm"),
      "cid": selected.attr("cid"),
      "tid": selected.attr("tid")
    }, function(reply){
      if(reply.status == "ok")
      {
        success(reply[0]);
        if(selected.attr("perm") == "del")
        {
          $("#tag_"+selected.attr("tid")).remove();
        }
      } else {
        error(reply.error);
      }
    });
  });

  $("#createNewTag").click(function(){
    $.post("/community/update.php",
    {
      "req": "create tag",
      "desc": $("#tagTitleNew").val(),
      "cid": $(this).attr("cid"),
      "tid": $("#newTagThing").find(":selected").attr("perm")
    }, function(reply){
      if(reply.status == "ok")
      {
        location.reload();
      } else {
        error(reply.error);
      }
    });
  });
  function search(string, cid)
  {
    $.post("/community/search.php",
    {
      "desc": string,
      "cid": cid
    }, function(reply){
      $("#searchHtmlPending").html(reply);
    });
  }
  search("", $("#search").attr("cid"));
  $("#search").click(function(){
    search($("#searchPending").val(), $(this).attr("cid"));
  });
});
