<!DOCTYPE html>
<?php 
session_start();
include('../SiT_3/config.php');
include('../SiT_3/PHP/helper.php');

$findAvatarSQL ="SELECT * FROM `avatar` WHERE `user_id` = '".$_SESSION['id']."' ";
$findAvatar = $conn->query($findAvatarSQL);
$avatar = (object) $findAvatar->fetch_assoc();

  	//Hat Camera Scaling (so it won't clip) 
  	//hat 1
  	
    $hat1ID = $avatar->{"hat4"};
    $shopSQL1 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat1ID."' ";
    $result1 = $conn->query($shopSQL1);
  	$shopRow1 = (object) $result1->fetch_assoc();

?>
<html>
  <head>
    
    
  
    <style>
    body {
      margin: 0;
      overflow: hidden;
      padding: 0px;
    }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  
  </head>
  
  <body>
    	<img src="http://nd24.ecar-manager.de/templates/nwd24/images/ani_load.gif">
		<canvas id="avatarCanvas" width="300" height="300" style="display:none;"></canvas>
		<script src="http://threejs.org/build/three.min.js"></script>
		<script src="http://threejs.org/examples/js/libs/tween.min.js"></script>
		<script src="http://threejs.org/examples/js/libs/stats.min.js"></script>
		<script src="https://threejs.org/examples/js/loaders/OBJLoader.js"></script>
		<script>
		var container;
      var camera, scene, renderer;
      var mouseX = 0, mouseY = 0;
      var renderer = new THREE.WebGLRenderer()
      //var windowHalfX = window.innerWidth / 2;
      //var windowHalfY = window.innerHeight / 2;
      init();
      animate();
      renderer.setClearColor( 0x000000 , 0 );
      var techLight = new THREE.AmbientLight(0xf4f4f4, 1);
      scene.add(techLight);
      function init() {
        container = document.createElement( 'div' );
        document.body.appendChild( container );
        // did you know luke, that this is    VV is the fov too
        camera = new THREE.PerspectiveCamera( 100, 500 / 500, 0.1, 1000 );
        //                   X   Y   Z
        //camera.position.set( 5 , 6 , 12.5 );
        camera.position.set( 2.5 , 3.8 , 5.3 );
        //camera.rotation.set( -13.36 , 15.81 , 8.48 );
        //camera.zoom = 2.3;
        camera.zoom = 4;
        //luke added this
        //camera.fov = 30;
        camera.updateProjectionMatrix();
        //end of lukes addition
        
        //camera.up = new THREE.Vector3(0,1,0);
        // scene
        scene = new THREE.Scene();

    var directionalLight = new THREE.DirectionalLight( 0x555555 );
    directionalLight.position.set( 0, 2, 1 );
    scene.add( directionalLight );
        // texture
        var manager = new THREE.LoadingManager();
        manager.onProgress = function ( item, loaded, total ) {
          console.log( item, loaded, total );
        };
		/*
			var container;
			var camera, scene, renderer;
			var mouseX = 0, mouseY = 0;
			
			//var windowHalfX = window.innerWidth / 2;
			//var windowHalfY = window.innerHeight / 2;
			init();
			animate();
			renderer.setClearColor( 0x000000 , 0 );
			var techLight = new THREE.AmbientLight(0xe8e8e8, 1);
			scene.add(techLight);
			function init() {
				container = document.createElement( 'div' );
				document.body.appendChild( container );
				// did you know luke, that this is    VV is the fov too
				camera = new THREE.PerspectiveCamera( 100, 500 / 500, 1, 2000 );
				//                   X   Y   Z
				camera.position.set( 2.5 , 3.8 , 5.3 );
				camera.zoom = 6;
				camera.angle = 22.5;
				//luke added this
				//camera.fov = 30;
				camera.updateProjectionMatrix();
				//end of lukes addition
				//controls = new THREE.OrbitControls( camera, renderer.domElement );
				//camera.up = new THREE.Vector3(0,1,0);
				// scene
				scene = new THREE.Scene();
    var directionalLight = new THREE.DirectionalLight( 0x555555 );
    directionalLight.position.set( 0, 2, 1 );
    scene.add( directionalLight );
    */
				// texture
				var manager = new THREE.LoadingManager();
				manager.onProgress = function ( item, loaded, total ) {
					console.log( item, loaded, total );
				};
				var texture = new THREE.Texture();
				var hat2 = new THREE.Texture();
				var onProgress = function ( xhr ) {
					if ( xhr.lengthComputable ) {
						var percentComplete = xhr.loaded / xhr.total * 100;
						console.log( Math.round(percentComplete, 2) + '% downloaded' );
					}
				};
				var onError = function ( xhr ) {
				};
				// TEX LOAD
				var loader = new THREE.ImageLoader( manager );
				loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat1"}); ?>.png' , function ( image ) {
					texture.image = image;
					texture.needsUpdate = true;
				} );
			
				var loader = new THREE.OBJLoader( manager );
				//MODEL
				        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat1"}); ?>.obj', function ( hat1 ) {
          hat1.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = texture;
            }
          } );
          hat1.position.y = -2.1<?php if ($shopRow1->{'zoom'} > 0) { echo ' - '; echo $shopRow1->{'zoom'};} ?>;
          hat1.position.z = 1.7;
          hat1.position.x = 0.98;
          camera.zoom = 4<?php if ($shopRow1->{'zoom'} > 0) { echo ' - '; echo $shopRow1->{'zoom'};} ?> - 1;
          camera.updateProjectionMatrix();
          scene.add( hat1 );
        }, onProgress, onError );
			
        //
        renderer = new THREE.WebGLRenderer( { alpha: true, canvas: document.getElementById('avatarCanvas'), antialias: true, preserveDrawingBuffer: true  } );
        //renderer.setPixelRatio( window.devicePixelRatio );
        //renderer.setSize( window.innerWidth, window.innerHeight );
        //renderer.setSize( 500, 300 );
        //container.appendChild( renderer.domElement );
        document.addEventListener( 'mousemove', onDocumentMouseMove, false );
      }
      /*function onWindowResize() {
        windowHalfX = window.innerWidth / 2;
        windowHalfY = window.innerHeight / 2;
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
      } */
      window.addEventListener( 'resize', onWindowResize, false );

      function onWindowResize(){

      }
      function onDocumentMouseMove( event ) {
        //mouseX = ( event.clientX - windowHalfX ) / 2;
      //  mouseY = ( event.clientY - windowHalfY ) / 2;
      }
      //

      function render() {
        camera.lookAt( new THREE.Vector3(0,2.2,0) );
        renderer.render( scene, camera);
      }
      function animate() {
        requestAnimationFrame( animate );
        render();
      }     
      //luke added this - loads image as png
      setTimeout(function(){
        var canvas = document.getElementById("avatarCanvas");
        dataimg = canvas.toDataURL("image/png");
        window.location = dataimg;
          },1500);
		</script>
		
	</body>
	
</html>