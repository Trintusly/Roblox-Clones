<!DOCTYPE html>
<?php 
  session_start();
  include('../SiT_3/config.php');
  include('../SiT_3/PHP/helper.php');
  
  $id = $_GET['id'];
  
  $updateAvatarSQL = "SELECT * FROM `beta_users` WHERE `id`='$id'";
  $updateAvatar = $conn->query($updateAvatarSQL);
  $avatarNumRow = $updateAvatar->fetch_assoc();
  $newID = ($avatarNumRow['avatar_id']+1);
  $newAvatarSQL = "UPDATE `beta_users` SET `avatar_id`='$newID' WHERE `id`='$id';";
  $conn->query($newAvatarSQL);
  
  $findAvatarSQL ="SELECT * FROM `avatar` WHERE `user_id` = '".$id."' ";
  $findAvatar = $conn->query($findAvatarSQL);
  if ($findAvatar->num_rows > 0) {
  $avatar = (object) $findAvatar->fetch_assoc();
  
  if (isset($_POST['img'])) {echo "bonjourno";}
  
  	//Hat Camera Scaling (so it won't clip) 
  	//hat 1
  	
    $hat1ID = $avatar->{"hat1"};
    $shopSQL1 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat1ID."' ";
    $result1 = $conn->query($shopSQL1);
  	$shopRow1 = (object) $result1->fetch_assoc();
  	
  	//Hat 2
  	
    $hat2ID = $avatar->{"hat2"};
    $shopSQL2 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat2ID."' ";
    $result2 = $conn->query($shopSQL2);
  	$shopRow2 = (object) $result2->fetch_assoc();
  	
  	//hat 3
  
    $hat3ID = $avatar->{"hat3"};
    $shopSQL3 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat3ID."' ";
    $result3 = $conn->query($shopSQL3);
  	$shopRow3 = (object) $result3->fetch_assoc();
  	
	//hat 4

    $hat4ID = $avatar->{"hat4"};
    $shopSQL4 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat4ID."' ";
    $result4 = $conn->query($shopSQL4);
  	$shopRow4 = (object) $result4->fetch_assoc();
  	
  	//hat 5

    $hat5ID = $avatar->{"hat5"};
    $shopSQL5 = "SELECT * FROM `shop_items` WHERE  `id` = '".$hat5ID."' ";
    $result5 = $conn->query($shopSQL5);
  	$shopRow5 = (object) $result5->fetch_assoc();
  	
  	//tool
	
	$toolID = $avatar->{"tool"};
    $shopSQL6 = "SELECT * FROM `shop_items` WHERE  `id` = '".$toolID."' ";
    $result6 = $conn->query($shopSQL6);
  	$shopRow6 = (object) $result6->fetch_assoc();
   
   $zoom = 2.3 - $shopRow1->{'zoom'} - $shopRow2->{'zoom'} - $shopRow3->{'zoom'} - $shopRow4->{'zoom'} - $shopRow5->{'zoom'} - $shopRow6->{'zoom'};
   if($shopRow6->{'zoom'} > 0) {
		$cameraAngleTool = '2.5 , 4.2 , 4.8';
   } else {
   		$cameraAngleTool = '2.5 , 3.8 , 5.3';
   }
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
    <img src="http://alpha.brick-hill.com/assets/GeneratingAvatar.gif" style="height: 285px;padding-top: 15px;margin-left: -25px;">
    <canvas id="avatarCanvas" width="235px" height="280px" style="display:none;"></canvas>
    <script src="http://threejs.org/build/three.min.js"></script>
    <script src="http://threejs.org/examples/js/libs/tween.min.js"></script>
    <script src="http://threejs.org/examples/js/libs/stats.min.js"></script>
    <script src="https://threejs.org/examples/js/loaders/OBJLoader.js"></script>
	<form action="isaiahSave.php" method="POST">
		<textarea type="hidden" id="img" name="img" style="display:none;"></textarea>
	</form>
    <script>
      var container;
      var camera, scene, renderer;
      var mouseX = 0, mouseY = 0;
      var renderer = new THREE.WebGLRenderer()
      init();
      animate();
      renderer.setClearColor( 0x000000 , 0 );
      var techLight = new THREE.AmbientLight(0xf4f4f4, 1);
      scene.add(techLight);
      function init() {
        container = document.createElement( 'div' );
        document.body.appendChild( container );
        camera = new THREE.PerspectiveCamera( 100, 225 / 270, 0.1, 1000 );
        //camera.position.set( 5 , 6 , 12.5 );
        camera.position.set( <?php echo $cameraAngleTool ?> );
        //camera.rotation.set( -13.36 , 15.81 , 8.48 );
        camera.zoom = <?php echo $zoom ?>;
        

        camera.updateProjectionMatrix();

        //camera.up = new THREE.Vector3(0,1,0);
        // scene
        scene = new THREE.Scene();

    var directionalLight = new THREE.DirectionalLight( 0x666666 );
    directionalLight.position.set( 0, 2, 1 );
    scene.add( directionalLight );
        // texture
        var manager = new THREE.LoadingManager();
        manager.onProgress = function ( item, loaded, total ) {
         // console.log( item, loaded, total );
        };


        var onProgress = function ( xhr ) {
          if ( xhr.lengthComputable ) {
            var percentComplete = xhr.loaded / xhr.total * 100;
           // console.log( Math.round(percentComplete, 2) + '% downloaded' );
          }
        };
        var onError = function ( xhr ) {
        };
        //Define textures here
        var facetex = new THREE.Texture();
        var tshirttex = new THREE.Texture();
        var shirttex = new THREE.Texture();
        var pantstex = new THREE.Texture();
        var hat1tex = new THREE.Texture();
        var hat2tex = new THREE.Texture();
        var hat3tex = new THREE.Texture();
        var hat4tex = new THREE.Texture();
        var hat5tex = new THREE.Texture();
        var tooltex = new THREE.Texture();
        // Load textures 
        var loader = new THREE.ImageLoader( manager );
        loader.load( '/shop_storage/assests/faces/<?php if ($avatar->{"face"} > 0) { echo shopItemHash($avatar->{"face"}); } else { echo "face"; }; ?>.png' , function ( faceimg ) {
          facetex.image = faceimg;
          facetex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/tshirts/<?php if ($avatar->{"tshirt"} > 0) { echo shopItemHash($avatar->{"tshirt"});}; ?>.png' , function ( tshirtimg ) {
          tshirttex.image = tshirtimg;
          tshirttex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/shirts/<?php if ($avatar->{"shirt"} > 0) { echo shopItemHash($avatar->{"shirt"}); } else { echo "studs"; }; ?>.png' , function ( shirtimg ) {
          shirttex.image = shirtimg;
          shirttex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/pants/<?php if ($avatar->{"pants"} > 0) { echo shopItemHash($avatar->{"pants"}); } else { echo "studs"; }; ?>.png' , function ( pantsimg ) {
          pantstex.image = pantsimg;
          pantstex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat1"}); ?>.png' , function ( hat1img ) {
          hat1tex.image = hat1img;
          hat1tex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat2"}); ?>.png' , function ( hat2img ) {
          hat2tex.image = hat2img;
          hat2tex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat3"}); ?>.png' , function ( hat3img ) {
          hat3tex.image = hat3img;
          hat3tex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat4"}); ?>.png' , function ( hat4img ) {
          hat4tex.image = hat4img;
          hat4tex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat5"}); ?>.png' , function ( hat5img ) {
          hat5tex.image = hat5img;
          hat5tex.needsUpdate = true;
        } );
        loader.load( '/shop_storage/assests/tools/<?php echo shopItemHash($avatar->{"tool"}); ?>.png' , function ( toolimg ) {
          tooltex.image = toolimg;
          tooltex.needsUpdate = true;
        } );
        // model
        var loader = new THREE.OBJLoader( manager );
        loader.load( '<?php if($avatar->{"head"} > 0) { echo "/shop_storage/assests/heads/"; ?><?php echo $avatar->{"head"}; ?><?php echo ".obj" ;} else { echo "Head.obj"; } ?>', function ( head ) {
          head.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'head_color'}; ?> );
            }
          } );
          head.position.y = -1.5;
          head.position.x = 0;
          head.scale = 2;
          scene.add( head );
        }, onProgress, onError );
//uv map of it
        var loader = new THREE.OBJLoader( manager );
        loader.load( '<?php if($avatar->{"head"} > 0) { echo "/shop_storage/assests/heads/"; ?><?php echo $avatar->{"head"}; ?><?php echo ".obj" ;} else { echo "Head.obj"; } ?>', function ( head ) {
          head.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = facetex;
              child.material.transparent = true;
            }
          } );
          head.position.y = -1.5;
          head.position.x = 0;
          scene.add( head );
        }, onProgress, onError );
        /*
        loader.load( 'LeftArm.obj', function ( leftArm ) {
          leftArm.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'left_arm_color'}; ?> );
              //child.material.map = shirttex;

            }
          } );
          leftArm.position.y = -1.5;
          leftArm.position.x = 0;
          scene.add( leftArm );
        }, onProgress, onError );
        
        loader.load( 'LeftArmUp.obj', function ( leftArmUp ) {
          leftArmUp.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'left_arm_color'}; ?> );
              //child.material.map = shirt;
            }
          } );
          leftArmUp.position.y = -1.5;
          leftArmUp.position.x = 0;
          scene.add( leftArmUp );
        }, onProgress, onError );
        */

        loader.load( 'RightArm.obj', function ( rightArm ) {
          rightArm.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'right_arm_color'}; ?> );
              //child.material.map = shirttex;
            }
          } );
          rightArm.position.y = -1.5;
          rightArm.position.x = 0;
          scene.add( rightArm );
        }, onProgress, onError );
        
        loader.load( 'Torso.obj', function ( torso ) {
          torso.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'torso_color'}; ?> );
              //child.material.map = shirttex;
            }
          } );
          torso.position.y = -1.5;
          torso.position.x = 0;
          scene.add( torso );
        }, onProgress, onError );
        
        loader.load( 'LeftLeg.obj', function ( leftLeg ) {
          leftLeg.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'left_leg_color'}; ?> );
              //child.material.map = pantstex;
            }
          } );
          leftLeg.position.y = -1.5;
          leftLeg.position.x = 0;
          scene.add( leftLeg );
        }, onProgress, onError );
        
        loader.load( 'RightLeg.obj', function ( rightLeg ) {
          rightLeg.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.color.setHex( 0x<?php echo $avatar->{'right_leg_color'}; ?> );
              //child.material.map = pantstex;
            }
          } );
          rightLeg.position.y = -1.5;
          rightLeg.position.x = 0;
          scene.add( rightLeg );
        }, onProgress, onError );
        
        /* now in dup
        loader.load( 'TShirt.obj', function ( tShirt ) {
          tShirt.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              //child.material.color.setHex( 0xFFFFFF );
              child.material.map = face;
              //child.material.transparent = true;
            }
          } );
          tShirt.position.y = -1.5;
          tShirt.position.x = 0;
          scene.add( tShirt );
        }, onProgress, onError );*/
        
        
        
        
        //////DELETE THIS HORRIBLE DUP ASAP
        //left arm
        /*
        loader.load( 'LeftArm.obj', function ( leftArm ) {
          leftArm.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = shirttex;
              child.material.transparent = true;

            }
          } );
          leftArm.position.y = -1.5;
          leftArm.position.x = 0;
          scene.add( leftArm );
        }, onProgress, onError );
        */
        loader.load( 'RightArm.obj', function ( rightArm ) {
          rightArm.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = shirttex;
              child.material.transparent = true;
            }
          } );
          rightArm.position.y = -1.5;
          rightArm.position.x = 0;
          scene.add( rightArm );
        }, onProgress, onError );
        
                // Top Torso of the Pants template

        loader.load( 'Torso.obj', function ( torso ) {
          torso.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = pantstex;
              child.material.transparent = true;
            }
          } );
          torso.position.y = -1.5;
          torso.position.x = 0;
          scene.add( torso );
        }, onProgress, onError ); 
    
        
        loader.load( 'Torso.obj', function ( torso ) {
          torso.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = shirttex;
              child.material.transparent = true;
            }
          } );
          torso.position.y = -1.5;
          torso.position.x = 0;
          scene.add( torso );
        }, onProgress, onError );
        
        loader.load( 'LeftLeg.obj', function ( leftLeg ) {
          leftLeg.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = pantstex;
              child.material.transparent = true;
            }
          } );
          leftLeg.position.y = -1.5;
          leftLeg.position.x = 0;
          scene.add( leftLeg );
        }, onProgress, onError );
        
        loader.load( 'RightLeg.obj', function ( rightLeg ) {
          rightLeg.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = pantstex;
              child.material.transparent = true;
            }
          } );
          rightLeg.position.y = -1.5;
          rightLeg.position.x = 0;
          scene.add( rightLeg );
        }, onProgress, onError );
        
        loader.load( 'TShirt.obj', function ( tShirt ) {
          tShirt.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = tshirttex;
              child.material.transparent = true;
              child.material.opacity = 0.8999999
            }
          } );
          tShirt.position.y = -1.5;
          tShirt.position.z = 0.02;
          scene.add( tShirt );
        }, onProgress, onError );
        /////DODODODODDO
        
		        
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat1"}); ?>.obj', function ( hat1 ) {
          hat1.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat1tex;
            }
          } );
          hat1.position.y = -1.5;
          hat1.position.x = 0;
          scene.add( hat1 );
        }, onProgress, onError );
        
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat2"}); ?>.obj', function ( hat2 ) {
          hat2.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat2tex;
            }
          } );
          hat2.position.y = -1.5;
          hat2.position.x = 0;
          scene.add( hat2 );
        }, onProgress, onError );
      
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat3"}); ?>.obj', function ( hat3 ) {
          hat3.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat3tex;
            }
          } );
          hat3.position.y = -1.5;
          hat3.position.x = 0;
          scene.add( hat3 );
        }, onProgress, onError );
      
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat4"}); ?>.obj', function ( hat4 ) {
          hat4.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat4tex;
            }
          } );
          hat4.position.y = -1.5;
          hat4.position.x = 0;
          scene.add( hat4 );
        }, onProgress, onError );
        
        loader.load( '/shop_storage/assests/hats/<?php echo shopItemHash($avatar->{"hat5"}); ?>.obj', function ( hat5 ) {
          hat5.traverse( function ( child ) {
            if ( child instanceof THREE.Mesh ) {
              child.material.map = hat5tex;
            }
          } );
          hat5.position.y = -1.5;
          hat5.position.x = 0;
          scene.add( hat5 );
        }, onProgress, onError );
        //TOOL
		<?php 
        if ($avatar->{"tool"} > 0) {
        // echo tool
			echo "loader.load( '/shop_storage/assests/tools/"?><?php echo shopItemHash($avatar->{'tool'});?><?php echo ".obj', function ( tool ) {";
			echo "tool.traverse( function ( child ) {";
			echo "if ( child instanceof THREE.Mesh ) {";
			echo "child.material.map = tooltex;";
			echo "}";
			echo "} );";
			echo "tool.position.y = -1.5;";
			echo "tool.position.x = 0;";
			echo "scene.add( tool );";
			echo "}, onProgress, onError );";
			//done
			//load arm color
			echo "loader.load( 'LeftArmUp.obj', function ( leftArmUpColor ) {";
			echo "leftArmUpColor.traverse( function ( child ) {";
			echo "if ( child instanceof THREE.Mesh ) {";
			echo "child.material.color.setHex( 0x"?><?php echo $avatar->{'left_arm_color'};?><?php echo " );";
			echo "}";
			echo "} );";
			echo "leftArmUpColor.position.y = -1.5;";
			echo "leftArmUpColor.position.x = 0;";
			echo "scene.add( leftArmUpColor );";
			echo "}, onProgress, onError );";			
			//load arm and 'fake uv map'
			echo "loader.load( 'LeftArmUp.obj', function ( leftArmUp ) {";
			echo "leftArmUp.traverse( function ( child ) {";
			echo "if ( child instanceof THREE.Mesh ) {";
			echo "child.material.map = shirttex;";
			echo "child.material.transparent = true;";
			echo "}";
			echo "} );";
			echo "leftArmUp.position.y = -1.5;";
			echo "leftArmUp.position.x = 0;";
			echo "scene.add( leftArmUp );";
			echo "}, onProgress, onError );";
        } else {
        	//load arm color
			echo "loader.load( 'LeftArm.obj', function ( leftArm ) {";
			echo "leftArm.traverse( function ( child ) {";
			echo "if ( child instanceof THREE.Mesh ) {";
			echo "child.material.color.setHex( 0x"?><?php echo $avatar->{'left_arm_color'};?><?php echo " );";
			echo "}";
			echo "} );";
			echo "leftArm.position.y = -1.5;";
			echo "leftArm.position.x = 0;";
			echo "scene.add( leftArm );";
			echo "}, onProgress, onError );";			
			//load arm and 'fake uv map'
			echo "loader.load( 'LeftArm.obj', function ( leftArm ) {";
			echo "leftArm.traverse( function ( child ) {";
			echo "if ( child instanceof THREE.Mesh ) {";
			echo "child.material.map = shirttex;";
			echo "child.material.transparent = true;";
			echo "}";
			echo "} );";
			echo "leftArm.position.y = -1.5;";
			echo "leftArm.position.x = 0;";
			echo "scene.add( leftArm );";
			echo "}, onProgress, onError );";
        } 
        ?>
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
        camera.lookAt( new THREE.Vector3(0,1.6,0) );
        renderer.render( scene, camera);
      }
      function animate() {
        requestAnimationFrame( animate );
        render();
      }     

      //luke added this - loads image as png
	  // modified by isaiah - 1/8/2017 6:30PM-7:00PM EST
      setTimeout(function(){
		  var canvas = document.getElementById("avatarCanvas")
		  potatoeDataImg = canvas.toDataURL("image/png");
			dataImg = potatoeDataImg.substr(22);
		  document.getElementById('img').value = dataImg; 
			document.forms[0].submit();
		//$("#main").ajaxSubmit({url: 'savei.php', type: 'post'})
          },3000);
			
    </script>
	<script>
		if(XMLHttpRequest)
{
  var request = new XMLHttpRequest();
  if("withCredentials" in request)
  {
   // Firefox 3.5 and Safari 4
   request.open('GET', url, true);
   request.onreadystatechange = handler;
   request.send();
  }
  else if (XDomainRequest)
  {
   // IE8
   var xdr = new XDomainRequest();
   xdr.open("get", url);
   xdr.send();
 
   // handle XDR responses -- not shown here :-)
  }
 
 // This version of XHR does not support CORS
 // Handle accordingly
}
	</script>
  </body>
  
</html>
<?php 

  } else {
	  header("Location: /login/");
	  die();
  }

?>