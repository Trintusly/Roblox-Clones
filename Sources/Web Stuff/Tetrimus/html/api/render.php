<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['avimg'])){
	$renderedav = imagecreatefrompng($_POST['avimg']); 
	if($renderedav !== false){
		imageAlphaBlending($renderedav, true);
		imageSaveAlpha($renderedav, true);
		$white = imagecolorallocate($renderedav, 255, 255, 255);
		imagecolortransparent($renderedav);
		$target = ($_SERVER['DOCUMENT_ROOT'] . "/storage/avatars/");
		$newname = md5($_POST['avimg']);
		$target = "$target 55.png";
		imagepng($renderedav,$target,0,NULL);
		imagedestroy($renderedav);
		 die("<center><h3>Your avatar has been rendered.</h3><img src='".$_POST['avimg']."' width='300' height='300'></center>");
	}else{
		die("ERROR RENDERING AVATAR");
	}
	
}
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!--iOS -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<script src="js/vendor/modernizr-2.6.2.min.js"></script>
	<style type="text/css">
	.back-link a {
		color: #4ca340;
		text-decoration: none; 
		border-bottom: 1px #4ca340 solid;
	}
	.back-link a:hover,
	.back-link a:focus {
		color: #408536; 
		text-decoration: none;
		border-bottom: 1px #408536 solid;
	}
	h1 {
		height: 100%;
		/* The html and body elements cannot have any padding or margin. */
		margin: 0;
		font-size: 14px;
		font-family: 'Open Sans', sans-serif;
		font-size: 32px;
		margin-bottom: 3px;
	}
	.entry-header {
		text-align: left;
		margin: 0 auto 50px auto;
		width: 80%;
        max-width: 978px;
		position: relative;
		z-index: 10001;
	}
	#demo-content {
		padding-top: 100px;
	}
	</style>
</head>
<body class="">
				
	<div id="" style='padding-top: 0px;'>

		<div id="">
			<div id=""></div>

			<div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

		</div>

		<div id="content" style="padding-bottom: 0px;">
		</div>

	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
	<form name="avat" id="avat" method="post" action="">
	  <label for="avimg"></label>
      <input name="avimg" type="hidden" id="avimg" value="" readonly="">
    </form>
	<script src="js/main.js"></script>

</body>
</html>


<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body {
				font-family: Arial;
				background-color: white;
				color: #fff;
				margin: 0px;
				overflow: hidden;
			}
			#info {
				color: #fff;
				position: absolute;
				top: 10px;
				width: 100%;
				text-align: center;
				z-index: 100;
				display:block;
			}
			#info a, .button { color: #f00; font-weight: bold; text-decoration: underline; cursor: pointer }
		</style>
	</head>

	<body>
		<div id="info">
		<a href="../" target="_blank"></a>
		</div>
		<script src="https://threejs.org//build/three.js"></script>
		<script src="https://threejs.org/examples/js/loaders/OBJLoader.js"></script>
		<script>
var shouldwait = true;
			var container;
			var camera, scene, renderer;
			var mouseX = 0, mouseY = 0;
			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;
			var object;
			init();
			animate();
			function init() {
				container = document.createElement( 'div' );
				document.body.appendChild( container );
				camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
				camera.position.z = 250;
				// scene
				scene = new THREE.Scene();
	renderer = new THREE.WebGLRenderer({
		antialias: true,
		alpha: true,
		preserveDrawingBuffer: true
	});
	renderer.setClearColor(0x000000, 0); //transparent unless alpha is changed
	container = document.createElement('div');
	document.body.appendChild(container);
	camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 1, 2000);

	camera.position.set(2.5, 3.8, 5.3);
	camera.position.y = 4;
	camera.rotation.y = 10;
	// scene
	scene = new THREE.Scene();

	var ambient = new THREE.AmbientLight(0xf4f4f4, 1);
	scene.add(ambient);

	var ambient = new THREE.AmbientLight(0x666666);

	// texture
	var manager = new THREE.LoadingManager();
	manager.onProgress = function (item, loaded, total) {
		//console.log( item, loaded, total );
	};
	var hat2Texture = new THREE.Texture();
	var hatTexture = new THREE.Texture();
	var face = new THREE.Texture();
	var LegsTexture = new THREE.Texture();
	var GearTexture = new THREE.Texture();
	var texture4 = new THREE.Texture();
	var texture3 = new THREE.Texture();
	var texture2 = new THREE.Texture();

	var head = new THREE.Texture();
	var onProgress = function (xhr) {
		if (xhr.lengthComputable) {
			var percentComplete = xhr.loaded / xhr.total * 100;
			console.log(Math.round(percentComplete, 2) + '% downloaded');
		}
	};
	var onError = function (xhr) {};
	var loader = new THREE.ImageLoader(manager);

	loader.load('Textures/skin.png', function (image) {
		LegsTexture.image = image;

		LegsTexture.needsUpdate = true;
	});
	loader.load('Textures/skin.png', function (image) {
		GearTexture.image = image;

		GearTexture.needsUpdate = true;
	});
	loader.load('Textures/skin.png', function (image) {
		texture3.image = image;

		texture3.needsUpdate = true;
	});
	loader.load('Textures/skin.png', function (image) {
		texture4.image = image;

		texture4.needsUpdate = true;
	});
	loader.load('Textures/skin.png', function (image) {
		texture3.image = image;
		texture3.needsUpdate = true;
	});
	loader.load('Textures/skin.png', function (image) {
		texture2.image = image;
		texture2.needsUpdate = true;
	});
	loader.load('Textures/face4.png', function (image) {
		head.image = image;
		head.needsUpdate = true;
	});
	// model
	var loader = new THREE.OBJLoader(manager);

	loader.load('Models/Legs.obj', function (object) {
		object.traverse(function (child) {
			if (child instanceof THREE.Mesh) {
				child.material.map = LegsTexture;
			}
		});
		                  
                	object.position.y = - 2;
					scene.add( object );
				}, onProgress, onError );
				/*  
                                        loader.load( 'Models/', function ( object ) {
					object.traverse( function ( child ) {
						if ( child instanceof THREE.Mesh ) {
							child.material.map = hatTexture;
						}
					} );
					
                    object.position.y = - 2;
					scene.add( object );
				}, onProgress, onError );
				
                                        loader.load( 'Models/', function ( object ) {
					object.traverse( function ( child ) {
						if ( child instanceof THREE.Mesh ) {
							child.material.map = hat2Texture;
						}
					} );
					
					object.position.y = - 2;
					scene.add( object );
				}, onProgress, onError );
				*/
		loader.load('Models/Torso.obj', function (object) {
			object.traverse(function (child) {
				if (child instanceof THREE.Mesh) {
					child.material.map = texture3;
				}
			});
			object.position.y = -2;
			scene.add(object);
		}, onProgress, onError);
		loader.load('Models/Arms.obj', function (object) {
			object.traverse(function (child) {
				if (child instanceof THREE.Mesh) {
					child.material.map = texture2;
				}
			});
			object.position.y = -2;
			scene.add(object);
		}, onProgress, onError);
		loader.load('Models/Head.obj', function (object) {
			object.traverse(function (child) {
				if (child instanceof THREE.Mesh) {
					// child.material.map = face;
					child.material.map = head;
				}
			});
			object.position.y = -2;
			scene.add(object);
		}, onProgress, onError);
		//
		renderer = new THREE.WebGLRenderer({
			antialias: true,
			alpha: true,
			preserveDrawingBuffer: true
		});
		renderer.setClearColor(0x000000, 0); //transparent unless alpha is changed
		renderer.setPixelRatio(window.devicePixelRatio);
		//renderer.setSize( 5000, 5000 );
		renderer.setSize(window.innerWidth, window.innerHeight);
		renderer.domElement.id = 'myCanvas';
		renderer.domElement.display = 'none';
		//renderer.setClearColor(new THREE.Color("hsl(0, 5%, 100%)"));
		container.appendChild(renderer.domElement);
		document.addEventListener('mousemove', onDocumentMouseMove, false);
		//
		window.addEventListener('resize', onWindowResize, false);
		setTimeout(function () {
			shouldwait = false;
		}, 5750);
	}

	function onWindowResize() {
		windowHalfX = window.innerWidth / 2;
		windowHalfY = window.innerHeight / 2;
		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
		//renderer.setSize( 5000, 5000 );
		renderer.setSize(window.innerWidth, window.innerHeight);
	}

	function onDocumentMouseMove(event) {
		mouseX = (event.clientX - windowHalfX) / 2;
		mouseY = (event.clientY - windowHalfY) / 2;
	}
	//
	var created = false;

	function animate() {

		requestAnimationFrame(animate);

		function renderimg() {
			if (shouldwait == true) {
				if (created == false) {
					setTimeout(renderimg, 175); //wait 50 millisecnds then recheck
					return;
				} else {
					return;
				}
			}
			var img = document.getElementById("myCanvas").toDataURL("image/png");

			if (shouldwait == true) {
				console.log("saving avatar...");
				/*$.ajax({
						url: '../saveav.php',
						type: 'POST',
						dataType: "json",
						data: {
							csf: "<?php function generateSalt($max = 18) {
								$tacoList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
								$i = 0;
								$salt = "";
								while ($i < $max) {
									$salt .= $tacoList{mt_rand(0, (strlen($tacoList) - 1))};
									$i++;
								}
								return $salt;
							}
							//echo(generateSalt());
							?>",
							avimg: img,
							usrnm: "<?php //echo($Name); ?>"
						}
					 
					})*/
			}
			document.getElementById('avimg').value = img;
			//console.log(img);
			created = true;
			//window.location.href = img;
			shouldwait = true;
			document.getElementById("avat").submit();
		}
		renderimg();
		render();

	}

	function render() {

		camera.lookAt(scene.position);
		renderer.render(scene, camera);
		//controls = new THREE.OrbitControls( camera, renderer.domElement );
		//controls.target.set( 0, 0, 0 );
		//controls.update();
	}

	function checkLoaded(renderer) {
		if (1 == 1) {
			//var Photo = renderer.domElement.toDataURL("image/png");
			//var win=window.open();
			// win.document.write("<img src='"+document.getElementById("myCanvas").toDataURL("image/png")+"'/>");

			$.ajax({
				type: "POST",
				//	  url: "notworkingyet",
				data: {
					//	 base: Photo
				}

			}).done(function (o) {
				console.log("Saved.");
			});
		} else {
			setTimeout(checkLoaded, 500);
		}
	}
	checkLoaded(renderer);
		</script>
	</body>
</html>