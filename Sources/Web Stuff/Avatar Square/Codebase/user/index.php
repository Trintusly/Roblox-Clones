<?php
$pagename = 'Home';
$pagelink = 'www.dimensious.com';
include('header.php');
?>
<? if (!$user){ ?>
<p>Welcome to SimpleBuild! This page will be reconstructed soon</p>
<? } else { ?>
<div class="row">

<div class="col s4 m4">
          <div class="card">
            <div class="card-image">
              <iframe frameborder="0" src="/avatar.php?id=<? echo $myu->id ?>" scrolling="no" style=" width: 200px; height: 200px"></iframe>
              
            </div>
            <div class="card-content">
              <p><? echo $myu->username ?></p>
            </div>
            <div class="card-action">
						  <a href="/Games">Play</a>
			              </div>
          </div>
</div>

<div class="row">
      <div class="col s7 m7">
        

<div class="card-panel white">
<input placeholder="Update Status" id="first_name" type="text" class="validate">
          
</div>
      </div>
    </div>
</div> <? } ?>