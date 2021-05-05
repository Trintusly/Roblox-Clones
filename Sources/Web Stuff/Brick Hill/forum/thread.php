<?php 

  include("../SiT_3/config.php");
  include("../SiT_3/header.php");

  $threadID = $_GET['id'];
  $threadIDSafe = mysqli_real_escape_string($conn, intval($threadID));
  $threadID = $threadIDSafe;
  if(isset($_GET['page'])) {$page = mysqli_real_escape_string($conn,intval($_GET['page']));} else {$page = 1;}
  $page = max($page,1);
  
  if($power >= 1) {
    if(isset($_GET['scrub'])) {
      $postID = mysqli_real_escape_string($conn,$_GET['scrub']);
      $scrubSQL = "UPDATE `forum_posts` SET `body`='[ Content Removed ]' WHERE `id`='$postID'";
      $scrub = $conn->query($scrubSQL);
      header("Location: thread?id=".$threadIDSafe);
    }
    if(isset($_GET['delete'])) {
      $deleteSQL = "UPDATE `forum_threads` SET `deleted`='yes' WHERE `id`='$threadIDSafe'";
      $delete = $conn->query($deleteSQL);
      header("Location: thread?id=".$threadIDSafe);
    }
    if(isset($_GET['lock'])) {
      $deleteSQL = "UPDATE `forum_threads` SET `locked`='yes' WHERE `id`='$threadIDSafe'";
      $delete = $conn->query($deleteSQL);
      header("Location: thread?id=".$threadIDSafe);
    }
    if(isset($_GET['pin'])) {
      $deleteSQL = "UPDATE `forum_threads` SET `pinned`='yes' WHERE `id`='$threadIDSafe'";
      $delete = $conn->query($deleteSQL);
      header("Location: thread?id=".$threadIDSafe);
    }
    if(isset($_GET['unlock'])) {
      $deleteSQL = "UPDATE `forum_threads` SET `locked`='no' WHERE `id`='$threadIDSafe'";
      $delete = $conn->query($deleteSQL);
      header("Location: thread?id=".$threadIDSafe);
    }
    if(isset($_GET['unpin'])) {
      $deleteSQL = "UPDATE `forum_threads` SET `pinned`='no' WHERE `id`='$threadIDSafe'";
      $delete = $conn->query($deleteSQL);
      header("Location: thread?id=".$threadIDSafe);
    }
  }
  
  $findThreadQuery = "SELECT * FROM `forum_threads` WHERE `id` = '$threadIDSafe'";
  $findThread = $conn->query($findThreadQuery);
  
  $sqlCount = "SELECT * FROM `forum_posts` WHERE `thread_id` = '$threadIDSafe'";
  $countQ = $conn->query($sqlCount);
  $count = $countQ->num_rows;
  
  $page = min(((int)($count/10)+1),$page);
  
  $limit = ($page-1)*10;
  $findReplyQuery = "SELECT * FROM `forum_posts` WHERE `thread_id` = '$threadIDSafe' ORDER BY `id` LIMIT $limit,10;";
  $findReply = $conn->query($findReplyQuery);
     
  $findViewsQuery = "SELECT * FROM `forum_threads` WHERE `id`='$threadIDSafe'";
  $findViews = $conn->query($findViewsQuery);
  $viewRow = $findViews->fetch_assoc();
  $views = $viewRow['views']+1;
  $addViewQuery = "UPDATE `forum_threads` SET `views`='$views' WHERE `id`='$threadIDSafe'";
  $addView = $conn->query($addViewQuery);
      
  if ( $findThread->num_rows > 0 ) {
      $threadRow = (object) $findThread->fetch_assoc();
      $boardID = $threadRow->{'board_id'};
      
      if($power <= 0 && $boardID <= 0) {header("Location /forum/");}
      
      // Finding Board
      
      $boradSQL = "SELECT * FROM `forum_boards` WHERE `id` = '$boardID'";
      $board = $conn->query($boradSQL);
      $boardRow = (object) $board->fetch_assoc();
  }
  
  function bbcode_to_html($bbtext){
    $bbtags = array(
      '[heading1]' => '<h1>','[/heading1]' => '</h1>',
      '[heading2]' => '<h2>','[/heading2]' => '</h2>',
      '[heading3]' => '<h3>','[/heading3]' => '</h3>',
      '[h1]' => '<h1>','[/h1]' => '</h1>',
      '[h2]' => '<h2>','[/h2]' => '</h2>',
      '[h3]' => '<h3>','[/h3]' => '</h3>',
  
      '[paragraph]' => '<p>','[/paragraph]' => '</p>',
      '[para]' => '<p>','[/para]' => '</p>',
      '[p]' => '<p>','[/p]' => '</p>',
      '[left]' => '<p style="text-align:left;">','[/left]' => '</p>',
      '[right]' => '<p style="text-align:right;">','[/right]' => '</p>',
      '[center]' => '<p style="text-align:center;">','[/center]' => '</p>',
      '[justify]' => '<p style="text-align:justify;">','[/justify]' => '</p>',
  
      '[bold]' => '<span style="font-weight:bold;">','[/bold]' => '</span>',
      '[italic]' => '<i>','[/italic]' => '</i>',
      '[underline]' => '<span style="text-decoration:underline;">','[/underline]' => '</span>',
      '[b]' => '<span style="font-weight:bold;">','[/b]' => '</span>',
      '[i]' => '<i>','[/i]' => '</i>',
      '[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
      '[s]' => '<s>','[/s]' => '</s>',
      '[break]' => '<br>',
      '[br]' => '<br>',
      '[newline]' => '<br>',
      '[nl]' => '<br>',
      
      '[unordered_list]' => '<ul>','[/unordered_list]' => '</ul>',
      '[ul]' => '<ul>','[/ul]' => '</ul>',
    
      '[ordered_list]' => '<ol>','[/ordered_list]' => '</ol>',
      '[ol]' => '<ol>','[/ol]' => '</ol>',
      '[list]' => '<li>','[/list]' => '</li>',
      '[li]' => '<li>','[/li]' => '</li>',
        
      '[*]' => '<li>','[/*]' => '</li>',
      '[code]' => '<pre>','[/code]' => '</pre>',
      '[quote]' => '<blockquote>','[/quote]' => '</blockquote>',
      '[preformatted]' => '<pre>','[/preformatted]' => '</pre>',
      '[pre]' => '<pre>','[/pre]' => '</pre>',  
      
      //Emojis
      //Created by Tech
      //I wouldn't brag about that, buddy - Luke
      
      ':)' => '<img src="/assets/emojis/smile.png"></img>',
      ':(' => '<img src="/assets/emojis/sad.png"></img>',
      ':P' => '<img src="/assets/emojis/tongue.png"></img>', ':p' => '<img src="/assets/emojis/tonuge.png"></img>',       
      ':*' => '<img src="/assets/emojis/kiss.png"></img>',    
      ':|' => '<img src="/assets/emojis/none.png"></img>',    
      ':^)' => '<img src="/assets/emojis/oops.png"></img>',   
      ':D' => '<img src="/assets/emojis/grin.png"></img>',


	// deleting links !!!
	'goatse.info' => '[ Link Removed ]',
	'pornhub.com' => '[ Link Removed ]',
    );
    
    $bbtext = str_ireplace(array_keys($bbtags), array_values($bbtags), $bbtext);
  
    $bbextended = array(
      "/\[url](.*?)\[\/url]/i" => "<a style=\"color:#444\" href=\"$1\">$1</a>",
      "/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a style=\"color:#444\" href=\"$1\">$2</a>", 
      "/\[email=(.*?)\](.*?)\[\/email\]/i" => "<a href=\"mailto:$1\">$2</a>",
      "/\[mail=(.*?)\](.*?)\[\/mail\]/i" => "<a href=\"mailto:$1\">$2</a>",
      "/\[youtube\]([^[]*)\[\/youtube\]/i" => "<iframe src=\"https://youtube.com/embed/$1\" width=\"560\" height=\"315\"></iframe>",
    );
    
    /*
      "/\[img\]([^[]*)\[\/img\]/i" => "<img class=\"forumImage\" src=\"$1\" alt=\" \" />",
      "/\[image\]([^[]*)\[\/image\]/i" => "<img src=\"$1\" alt=\" \" />",
      "/\[image_left\]([^[]*)\[\/image_left\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_left\" />",
      "/\[image_right\]([^[]*)\[\/image_right\]/i" => "<img src=\"$1\" alt=\" \" class=\"img_right\" />",*/
  
    foreach($bbextended as $match=>$replacement){
      $bbtext = preg_replace($match, $replacement, $bbtext);
    }
    return $bbtext;
  }
  
?>
<!DOCTYPE html>
<html>

  <head>
  <title> <?php echo htmlentities ( $threadRow->{'title'} ); ?> - Brick Hill </title>
  
  <meta charset="UTF-8">
  <meta name="description" content="<?php echo $threadRow->{'body'} ?>">
  <meta name="keywords" content="free,game">
 <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
  
  <meta property="og:title" content="<?php echo $threadRow->{'title'} ?>" />
  <meta property="og:description" content="<?php echo $threadRow->{'body'} ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="http://www.brick-hill.com/forum/thread?id=<?php echo $threadID ?>" />
  </head>

    
  <body>
  
    <div id="body">
    <?php
    if ( $findThread->num_rows > 0) {
      if($threadRow->{'deleted'} == 'no') {
      //$threadRow = (object) $findThread->fetch_assoc();
      $authorID = $threadRow->{'author_id'};
      
      // Finding Creator
      
      $findCreatorSQL = "SELECT * FROM `beta_users` WHERE `id` = '$authorID'";
      $findCreator = $conn->query($findCreatorSQL);
      $creatorRow = (object) $findCreator->fetch_assoc();
      
      //Find creator of thread
      $findCreatorThreadSQL = "SELECT * FROM `forum_posts` WHERE `id` = '$threadIDSafe'";
      $findCreatorThread = $conn->query($findCreatorThreadSQL);
      $creatorThreadRow = (object) $findCreatorThread->fetch_assoc();
    ?>
      <meta property="og:image" content="<?php echo 'http://storage.brick-hill.com/images/avatars/'; ?><?php echo $creatorRow->{'id'};?><?php echo ".png?c=";?><?php echo $creatorRow->{'avatar_id'}; ?>" />
      <span><p style="color: white;margin:0px;margin-top: -15px;"><a style="color: white;text-decoration:underline;" href="/forum">Forum</a> >> <a style="color: white;text-decoration:underline;"  href="board?id=<?php echo $boardRow->{'id'} ?>"><?php echo $boardRow->{'name'}; ?></a> >> <a style="color: white;text-decoration:underline;" href="thread?id=<?php echo $threadRow->{'id'}; ?>"><?php echo htmlentities($threadRow->{'title'}); ?></a></p></span>
      <div class="thread-title">
        <?php
          
          $threadTitle = htmlentities($threadRow->{'title'});
          $locked = $threadRow->{'locked'};
          if ( $threadRow->{'pinned'} == 'yes' ) {
            echo '<i tooltip="Pinned Thread" class="fa fa-thumb-tack"></i> ';}
          if ( $threadRow->{'locked'} == 'yes' ) {
            echo '<i tooltip="Locked Thread" class="fa fa-lock"></i> ';}
          echo $threadTitle;
          
        ?>
      </div>
      <?php
      // ok
      
      
      	  $threadCreator = $creatorRow->{'id'};
          $bannerSQL = "SELECT * FROM `forum_banners` WHERE `user_id` = '$threadCreator'";
      	  $banner = $conn->query($bannerSQL);
          $bannerRow = (object) $banner->fetch_assoc();
        if($page == 1) {
          echo '<div id="box" style="padding: 5px;border-top:0px;" class="forumPost">
          <div style="width:200px;text-align:center;float:left;">
            <div style="text-align:center" >
            <a href="/user?id='.$creatorRow->{'id'}.'" style="color: #000;">'.$creatorRow->{'username'}.'<br>
            <img style="width:150px;" src="http://storage.brick-hill.com/images/avatars/'.$creatorRow->{'id'}.'.png?c='.$creatorRow->{'avatar_id'}.'" /></a>
            </div>';
            //<img src="https://i.imgur.com/'.$bannerRow->{'url'}.'.png">
            //';
            
          if($creatorRow->{'power'} > '0'){
            echo '<br><span style="color: #bf0000;"><i class="fa fa-gavel" aria-hidden="true"></i> Moderator</span><br>';
          }
          
          $postCountSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$authorID'";
          $postCount = $conn->query($postCountSQL);
          $posts = $postCount->num_rows;
          
          $threadCountSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$authorID'";
          $threadCount = $conn->query($threadCountSQL);
          $threads = $threadCount->num_rows;
          
          $userPostCount = ($threads+$posts);
          echo '<span style="color: #000;"><span style="font-weight:bold;">Posts: </span>'.$userPostCount.'</span><br>';
          echo '<span style="color: #000;"><span style="font-weight:bold;">Joined: </span>'.$creatorRow->{'date'}.'</span><br>';
      
        ?>
        </div>
        <div style="width: 77%;float:left;word-wrap: break-word;">
          <span style="color: #444;">
          <?php

          /* -
          $findOPSQL = "SELECT * FROM `forum_posts` WHERE `author_id` = '$authorID'";
          $findOP = $conn->query($findOPSQL);
          $opRow = (object) $findOP->fetch_assoc();
          if($creatorRow->{'power'} > '0'){
              echo '<span style="color: #bf0000;padding: 0px;padding-bottom: 0px;"><i class="fa fa-gavel" aria-hidden="true"></i> Moderator</span>';
          }if($opRow->{'author_id'} == $authorID) {
              echo '<b title="Original Poster of this thread." style="padding-left: 5px;color: #77B9FF;">OP</b>';
              }*/
          ?>
          <?php
          echo '<span style="float:right;text-align:right;">';
          echo '<i style="font-size: 13px;"><i class="fa fa-clock-o" style="padding-right: 5px;"></i>'. $threadRow->{'date'} .'</i>';
          echo '<br><a href="/report?type=thread&id='.$threadID.'"><i style="color:#444;font-size:13px;" class="fa fa-flag"></i></a>';
          echo '</span>';
          echo '</span><br><div>'.bbcode_to_html(nl2br(htmlentities($threadRow->{'body'}))).'</div>';
          ?>
        
        <div style="margin-top:20px;float:left;">
          <?php 
          if($loggedIn) {
            if($power >= 1) {
              echo '<span><a class="label" href="scrub?id='.$threadID.'">Scrub</a></span>
              <span><a class="label" href="thread?id='.$threadID.'&delete">Delete</a></span>
              <span><a class="label" href="move?id='.$threadID.'">Move</a></span>';
              if($threadRow->{'pinned'} == 'no') {
                echo '<span><a class="label" href="?pin&id='.$threadID.'">Pin</a></span>';
              } else {
                echo '<span><a class="label" href="?unpin&id='.$threadID.'">Unpin</a></span>';
              }
              
              if($threadRow->{'locked'} == 'no') {
                echo '<span><a class="label" href="?lock&id='.$threadID.'">Lock</a></span>';
              } else {
                echo '<span><a class="label" href="?unlock&id='.$threadID.'">Unlock</a></span>';
              }
            }
          }
          echo '</div></div></div>';
        } else {

        }
          ?>
          

      <?php
        while ($threadRow = $findReply->fetch_assoc()) {
          $authorID = $threadRow['author_id'];
          
          // Finding Creator
          $findCreatorSQL = "SELECT * FROM `beta_users` WHERE `id` = '$authorID'";
          $findCreator = $conn->query($findCreatorSQL);
          $creatorRow = (object) $findCreator->fetch_assoc();
          
                    
          echo '<div id="box" style="padding: 5px;border-top:0px;" class="forumPost">
            <a name="post'.$threadRow['id'].'"></a>
            <div style="width:200px;text-align:center;float:left;">
              <div style="text-align:center" >
              <a href="/user?id='.$creatorRow->{'id'}.'" style="color: #000;">'.$creatorRow->{'username'}.'<br>
              <img style="width:150px;" src="http://storage.brick-hill.com/images/avatars/'.$creatorRow->{'id'}.'.png?c='. $creatorRow->{'avatar_id'} .'" /></a>';
          
          if($creatorRow->{'power'} > '0'){
            echo '<br><span style="color: #bf0000;"><i class="fa fa-gavel" aria-hidden="true"></i> Moderator</span><br>';
            }
          echo '</div>';
          $postCountSQL = "SELECT * FROM `forum_posts` WHERE `author_id`='$authorID'";
          $postCount = $conn->query($postCountSQL);
          $posts = $postCount->num_rows;
          
          $threadCountSQL = "SELECT * FROM `forum_threads` WHERE `author_id`='$authorID'";
          $threadCount = $conn->query($threadCountSQL);
          $threads = $threadCount->num_rows;
          
          $userPostCount = ($threads+$posts);
          echo '<span style="font-weight:bold;">Posts: </span><span>'.$userPostCount.'</span><br>';
          echo '<span style="font-weight:bold;">Joined: </span><span>'.$creatorRow->{'date'}.'</span><br>';
          
              
          echo '</div><div style="width: 77%;float:left;word-wrap: break-word;"><span style="color: #444;">';
          /*if($opRow->{'author_id'} == $authorID) {
          echo '<b title="" style="padding-left: 5px;color: #77B9FF;">OP</b>';
          }*/
          
          echo '<span style="float:right;text-align:right;">';
          echo '<i style="font-size: 13px;"><i class="fa fa-clock-o" style="padding-right: 5px;"></i>'.$threadRow['date'].'</i>';
          if($locked == 'no') {
            echo '<br><a href="reply?id='.$threadID.'&quote='.$threadRow['id'].'"><i style="color:#444; font-size: 13px;" class="fa fa-quote-right" style="padding-right: 5px;"></i></a>';
          }
          echo '<br><a href="/report?type=post&id='.$threadRow['id'].'"><i style="color:#444;font-size:13px;" class="fa fa-flag" style="padding-right: 5px;"></i></a>';
          echo '</span>';
          echo '</span><br>'.bbcode_to_html(nl2br(htmlentities($threadRow['body']))).'</div>';
          if($power >= 1) {
            echo '<div style="margin-top:20px;float:left;">
              <span><a class="label" href="?id='.$threadID.'&scrub='.$threadRow['id'].'">Scrub</a></span>
              </div>';
          }
          echo '</div>';
        }
        
        echo '<div style="height:10px;"></div>';
        if ($locked == 'no' && $loggedIn) {
          echo "<a href='/forum/reply?id=".$threadIDSafe."' class='button' style='width:50px;margin:auto;display:block;'>Reply</a>";
        }
        ?>
        
      <?php
      echo '</div><div class="numButtonsHolder" style="margin-left:auto;margin-right:auto;margin-top:10px;">';
      
      if($count/10 > 1) {
        for($i = 0; $i < min($count/10,4); $i++)
        {
          echo '<a href="thread?id='.$threadIDSafe.'&page='.($i+1).'">'.($i+1).'</a> ';
        }
      }
      if($count/20 > 4) {
          echo '... <a href="board?id='.$threadIDSafe.'&page='.(round($count/10)+1).'">'.(round($count/10)+1).'</a> ';
      }
      
      echo '</div>';
      ?>
    <?php 
      } else {
        echo '<div id="box" style="padding: 10px;tect-align:center;">
        Thread not found!
      </div>';
      }
    } else {
      ?>
      <div id="box" style="padding: 10px;tect-align:center;">
        Thread not found!
      </div>
      <?php
    }
    ?>
    </div>
    <?php
    include("../SiT_3/footer.php");
    ?>
  </body>
  
</html>