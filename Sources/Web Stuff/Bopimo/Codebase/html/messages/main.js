$(document).ready(function(){
  var page = 1;
  var category = "unread";
  var limit = 10;
  function time2TimeAgo(ts) {
    // This function computes the delta between the
    // provided timestamp and the current time, then test
    // the delta for predefined ranges.

    var d=new Date();  // Gets the current time
    var nowTs = Math.floor(d.getTime()/1000); // getTime() returns milliseconds, and we need seconds, hence the Math.floor and division by 1000
    var seconds = nowTs-ts;

    // more that two days
    if (seconds > 2*24*3600) {
       return "a few days ago";
    }
    // a day
    if (seconds > 24*3600) {
       return "yesterday";
    }

    if (seconds > 3600) {
       return "a few hours ago";
    }
    if (seconds > 1800) {
       return "Half an hour ago";
    }
    if (seconds > 60) {
       return Math.floor(seconds/60) + " minutes ago";
    }
}
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
  function getPage(page, category)
  {
    $(".banner.danger").addClass("hidden");
    $.post("get.php", {
      "page": page,
      "category": category
    }, function(reply){
      switch(reply.status)
      {
        case "error":
          fail(reply.error);
          break;
        default:
        console.log(reply.count);
          $("#content").html("");
          if(page == 1 && reply.count == limit)
          {
            $("#page-left").addClass("hidden");
            $("#page-right").removeClass("hidden");
          } else if(page > 1 && reply.count < limit) {
            $("#page-left").removeClass("hidden");
            $("#page-right").addClass("hidden");
          } else if(page > 1 && reply.count == limit) {
            $("#page-left").removeClass("hidden");
            $("#page-right").removeClass("hidden");
          }
          if(reply.count == 0) {
            fail("No results");
          }
          reply.res.forEach(function(item, index){
            if(item.read == "0")
            {
              title = "<b>"+item.title+"</b>";
            } else {
              title = item.title;
            }
            console.log(item);
            $("#content").append("<div class='card border'><div class='col-2-12'><a href='/profile/"+item.uid+"' style='color:black;'><img src='https://storage.bopimo.com/avatars/"+item.cache+".png' class='image'></a></div><div class='col-10-12'><a href='/message/view/"+item.id+"' style='color:black'>"+title+"</a></div><div class='col-10-12' style='color:grey;font-size:14px;'><i>"+item.username+" "+time2TimeAgo(item.time)+"</i></div></div>");
          });
      }
    });
  }
  getPage(page, category);
  $(".shop-button").click(function(){
    var categoryNew = $(this).attr("data-category");
    page = 1;
    category = categoryNew;
    getPage(page, category);
    $(".current").removeClass("current");
    $(this).addClass("current");
  });
  $("#page-left").click(function(){
    page = page - 1;
    getPage(page, category);
  });
  $("#page-right").click(function(){
    page = page + 1;
    getPage(page, category);
  });
});
