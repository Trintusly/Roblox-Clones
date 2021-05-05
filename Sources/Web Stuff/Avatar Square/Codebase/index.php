<?php
$pagename = 'Home';
$pagelink = 'www.dimensious.com';
include('header.php');
?>
<? if (!$user){ 
header('Location: /Landing');
} else { ?>

<div class="row">

<div class="col s4 m4">
          <div class="card">
            <div class="card-image">
              <iframe frameborder="0" src="/avatar.php?id=<? echo $myu->id?>" scrolling="no" style=" width: 200px; height: 200px"></iframe>
              
            </div>
            <div class="card-content">
              <p>AvatarSquare</p>
            </div>
            <div class="card-action">
						  <a href="/Games">Play</a>
			              </div>
          </div>
</div>

<div class="row">
      <ul class="collection">
    
    <div class="card-panel white">
<input placeholder="Update Status" id="first_name" type="text" class="validate">
          
</div>
              <li class="collection-item avatar">
                <img src="/Market/Storage/Avatar.png" alt="" class="circle">
                <p>AvatarSquare<br>We recently changed our site name to AvatarSquare!</p>
                <a href="#!" class="secondary-content"><i class="material-icons">grade</i></a>
</li><br>
            </ul>
    </div>
</div>

<? } ?>