<html><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        
        <!-- Babylon.js -->
        <script src="https://www.babylonjs.com/hand.minified-1.2.js"></script>
        <script src="https://preview.babylonjs.com/babylon.js"></script>
        <script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>
        <script src="https://preview.babylonjs.com/cannon.js"></script>
        <script src="https://preview.babylonjs.com/oimo.js"></script>
        
        
    </head>
<body>
    <canvas id="renderCanvas" width="1800" height="800" tabindex="1"></canvas>
    <script>
        var canvas = document.getElementById("renderCanvas");
        var engine = new BABYLON.Engine(canvas, true);

        var createScene = function () {
            var scene = new BABYLON.Scene(engine);
        
            // Setup environment
            var light0 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(0, 2, 8), scene);
            var camera = new BABYLON.ArcRotateCamera("ArcRotateCamera", 1, 0.8, 20, new BABYLON.Vector3(0, 0, 0), scene);
            camera.attachControl(canvas, true);
        
            // Fountain object
            var fountain = BABYLON.Mesh.CreateBox("foutain", 1.0, scene);
        
            // Create a particle system
            var particleSystem = new BABYLON.ParticleSystem("particles", 2000, scene);
        
            //Texture of each particle
            particleSystem.particleTexture = new BABYLON.Texture("Assets/flare.png", scene);
        
            // Where the particles come from
            particleSystem.emitter = fountain; // the starting object, the emitter
            particleSystem.minEmitBox = new BABYLON.Vector3(-1, 0, 0); // Starting all from
            particleSystem.maxEmitBox = new BABYLON.Vector3(1, 0, 0); // To...
        
            // Colors of all particles
            particleSystem.color1 = new BABYLON.Color4(0.7, 0.8, 1.0, 1.0);
            particleSystem.color2 = new BABYLON.Color4(0.2, 0.5, 1.0, 1.0);
            particleSystem.colorDead = new BABYLON.Color4(0, 0, 0.2, 0.0);
        
            // Size of each particle (random between...
            particleSystem.minSize = 0.1;
            particleSystem.maxSize = 0.5;
        
            // Life time of each particle (random between...
            particleSystem.minLifeTime = 0.3;
            particleSystem.maxLifeTime = 1.5;
        
            // Emission rate
            particleSystem.emitRate = 1500;
        
            // Blend mode : BLENDMODE_ONEONE, or BLENDMODE_STANDARD
            particleSystem.blendMode = BABYLON.ParticleSystem.BLENDMODE_ONEONE;
        
            // Set the gravity of all particles
            particleSystem.gravity = new BABYLON.Vector3(0, -9.81, 0);
        
            // Direction of each particle after it has been emitted
            particleSystem.direction1 = new BABYLON.Vector3(-7, 8, 3);
            particleSystem.direction2 = new BABYLON.Vector3(7, 8, -3);
        
            // Angular speed, in radians
            particleSystem.minAngularSpeed = 0;
            particleSystem.maxAngularSpeed = Math.PI;
        
            // Speed
            particleSystem.minEmitPower = 1;
            particleSystem.maxEmitPower = 3;
            particleSystem.updateSpeed = 0.005;
        
            // Start the particle system
            particleSystem.start();
        
            // Fountain's animation
            var keys = [];
            var animation = new BABYLON.Animation("animation", "rotation.x", 30, BABYLON.Animation.ANIMATIONTYPE_FLOAT,
                                                                            BABYLON.Animation.ANIMATIONLOOPMODE_CYCLE);
            // At the animation key 0, the value of scaling is "1"
            keys.push({
                frame: 0,
                value: 0
            });
        
            // At the animation key 50, the value of scaling is "0.2"
            keys.push({
                frame: 50,
                value: Math.PI
            });
        
            // At the animation key 100, the value of scaling is "1"
            keys.push({
                frame: 100,
                value: 0
            });
        
            // Launch animation
            animation.setKeys(keys);
            fountain.animations.push(animation);
            scene.beginAnimation(fountain, 0, 100, true);
        
            return scene;
        }
        
        
        var scene = createScene()

        engine.runRenderLoop(function () {
            scene.render();
        });

        // Resize
        window.addEventListener("resize", function () {
            engine.resize();
        });
    </script>






<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" async="" src="http://avatarsquare.ga/Style/javascript.js"></script>
<link rel="stylesheet" href="http://avatarsquare.ga/Style/default.css">
<link rel="stylesheet" href="http://avatarsquare.ga/Style/style.css">
<title>AvatarSquare | Landing</title>
        <script src="https://www.babylonjs.com/hand.minified-1.2.js"></script>
        <script src="https://preview.babylonjs.com/babylon.js"></script>
        <script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>
        <script src="https://preview.babylonjs.com/cannon.js"></script>
        <script src="https://preview.babylonjs.com/oimo.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    
    <nav style="box-shadow:none;" class="main-nav">
<div class="nav-wrapper light-blue darken-2">
<a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

<ul id="more-links" class="dropdown-content">
<li><a href="/Players/" style="font-size:16px;">Users</a></li>
<li><a href="/Groups/" style="font-size:16px;">Groups</a></li>
<li><a href="https://blog.bloxcity.co.uk/" style="font-size:16px;">Blog</a></li>
</ul>
<ul class="right hide-on-med-and-down">
<script>
						$(document).ready(function(){
							$('.tooltipped').tooltip({delay: 50});
							$(".dropdown-button2").dropdown({belowOrigin: true});
						});
					</script>
<ul class="right hide-on-med-and-down">

<li><a href="/Login">Login</a></li>
<li><a href="/Register">Register</a></li>

<ul class="right hide-on-med-and-down">
<li><a href="/user/logout.php"></a></li>
<ul class="side-nav" id="mobile-demo" style="transform: translateX(-100%);">
<li><a href="/Games/">Games</a></li>
<li><a href="/Market/">Market</a></li>
<li><a href="/Players">Users</a></li>
<li><a href="/Groups">Groups</a></li>
<li><a href="/Forum">Forum</a></li>
<li><a href="/Upgrades">Upgrade</a></li>
<li><a href="/Blog">Blog</a></li>
</ul></ul></ul></ul></div>
</nav>



<div class="entire-page-wrapper">

<script>
		$(".button-collapse").sideNav();
		$(".dropdown-button1").dropdown({belowOrigin: true});
		</script>
<style>body {
    overflow:hidden;
} @import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300");body{no-repeat center center fixed;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;width:100%;height:100%;position:relative;}.light-blue.darken-2,.nav-wrapper,nav{background:transparent!important;}.welcome-registration{font-family:"Source Sans Pro",sans-serif;font-weight:300;font-size:18px;color:#f1f1f1;padding-bottom:5px;}.registration-box{width:75%;}.general-textarea{border:0!important;}@media only screen and (min-width: 993px) {.welcome-header{font-family:"Source Sans Pro",sans-serif;font-weight:300;font-size:45px;color:white;}.major-push{position:absolute;top:50%;transform:translateY(-50%);}}@media only screen and (max-width: 993px) {.welcome-header{font-family:"Source Sans Pro",sans-serif;font-weight:300;font-size:24px;color:white;}.major-push{position:absolute;top:15%;transform:translateY(-15%);text-align:center;margin:0 auto;}.registration-box{margin:0 auto;}}</style>
<div class="row">
<div class="col s12 l4 offset-l8 major-push">
<div class="welcome-header">AvatarSquare</div>
<div class="welcome-registration">Reserve your account</div>
<div class="registration-box">
<form action="#" method="POST">
<input type="email" name="email" class="general-textarea" placeholder="Enter Your Email">
<div style="height:10px;"></div>
<input type="text" name="username" class="general-textarea" placeholder="Choose a username">
<div style="height:10px;"></div>
<input type="password" name="password" class="general-textarea" placeholder="Create a password">
<div style="height:10px;"></div>
<input type="password" name="confirmpassword" class="general-textarea" placeholder="Type password again">
<div style="height:10px;"></div>
<input type="submit" name="submit" class="groups-blue-button" value="Sign Up" style="width:100%;font-size:16px;">
</form>
</div>
</div>
</div>
<div class="row" style="margin-bottom:0;">
<div class="col s12 m3 l2 hide-on-med-and-down" style="text-align: right;">&nbsp;</div>
<div class="col s12 m9 l8">
<div class="container" style="width:100%;">
</div></div></div></div><div class="drag-target" style="left: 0px; touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div><div class="drag-target" style="left: 0px; touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>


<div class="hiddendiv common"></div>
</body></html>