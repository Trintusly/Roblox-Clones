<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("/var/www/html/site/bopimo.php");
if(!$bop->logged_in())
{
  die("not logged in");
}
$topic = $bop->look_for("sub_forums", ["id" => $_GET['id']]);
if(!$topic)
{
  die(header("location: /forum"));
}

if(!isset($_POST['title']))
{
  require("/var/www/html/site/header.php");
  ?>
  <style>
  	a {
  		text-decoration: none;
  		color: #7660E4;
  	}
  </style>
  <div class="content">
    <div class="col-1-1">
      <div class="banner danger hidden" id="status"><i class="fa fa-spinner fa-spin"></i> Loading</div>
      <div style="background-color:#f7f7f7;height:22.5px;border: 1px solid #7660E4; width:calc(100% - 12px); padding:5px; margin-bottom: 10px;border-radius:5px;">
  			<span style="float:left;margin:0px;"><a href="/forum">Forum</a> / <a href="/forum/b/<?=$topic->id?>/1"><?=$topic->name?></a> / <a href="#">Create Thread</a></span>
  		</div>
      <div class="label-title">
        Create Thread in <a href="/forum/b/<?=$topic->id?>/1" style="color:white;"><?=$topic->name?></a>
      </div>
      <div class="dotted-body">

          <input class="width-100" placeholder="Thread Title" id="title">
          <textarea class="width-100" placeholder="Thread Description" id="desc" style="height:200px;"></textarea>
          <input class="button success" type="submit" value="Create Thread">

      </div>
    </div>
  </div>

  <script>
  $(document).ready(function(){
    $("input[type=submit]").click(function(e){
  		e.preventDefault();
      $("#status").removeClass("hidden");
      $.post("/forum/create_thread.php?id=<?=$topic->id?>", {
        title: $("#title").val(),
        desc: $("#desc").val(),
		token: $("meta[name=token]").attr("content")
      }, function(reply){
        switch(reply)
        {
          case "1_err":
            $("#status").html("Thread title must be 3-40 characters long.");
            break;
          case "2_err":
            $("#status").html("Description must be 5-4000 characters long.");
            break;
          case "3_err":
            $("#status").html("You are posting too fast!");
            break;
		  case "4_err":
			 $("#status").html("Invalid CSRF Token");
			 break;
          default:
            $("#status").html("Redirecting...");
           document.location = "/forum/t/"+reply+"/1";
            break;
        }
      });
    });
  });
  </script>

  <?php
} else {
	if (isset($_POST["token"])) {
		if ($bop->checkToken($_POST["token"])) {
		  $title = $_POST['title'];
		  $desc = $_POST['desc'];


      if(!isset($title) || !isset($desc) || !is_string($title) || !is_string($desc))
      {
        die();
      }
		  if(strlen($title) < 3 || strlen($title) > 40)
		  {
			die("1_err"); //Title must be 3 - 40 Characters
		  }
		  if(strlen($desc) < 5 || strlen($desc) > 4000)
		  {
			die("2_err"); //Description must be 5 - 4000 Characters
		  }

		  $user = $bop->local_info();
      if($bop->isBanned($user->id))
      {
        die();
      }
		  if($bop->tooFast()){
			die("3_err");
		  }
		  $time = time();
		  //everything checks out, create the thread
		  $thread = $bop->insert("threads", [
			"title" => $title,
			"body" => $desc,
			"author" => $user->id,
			"created" => $time,
			"updated" => $time,
			"subforum" => $topic->id
		  ]);
		  $bop->update_("users", ["lastaction" => $time, "posts" => $user->posts + 1], ["id" => $user->id]);
		  die($thread->id);
		} else {
			die("4_err");
		}
	} else {
		die("4_err");
	}

}
?>
<?php $bop->footer(); ?>
