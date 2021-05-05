<?
		@mysql_connect("localhost","buildcit_user","2M6a2gqeF6");
		mysql_select_db("buildcit_main");
$ID = mysql_real_escape_string(strip_tags(stripslashes($_GET['ID'])));
$Username = mysql_real_escape_string(strip_tags(stripslashes($_GET['Username'])));
if (!$Username) {
$getUser = mysql_query("SELECT * FROM Users WHERE ID='".$ID."'");
}
else {
$getUser = mysql_query("SELECT * FROM Users WHERE Username='".$Username."'");
}
$gU = mysql_fetch_object($getUser);

$Hat = $gU->Hat;
$Bottom = $gU->Bottom;
$Top = $gU->Top;
$TShirt = $gU->TShirt;
$Face = $gU->Face;
?>
<head>
<script src="/js/three.js"></script>
<script src="/js/objloader.js"></script>
<script src="/js/MTLLoader.js"></script>
<script src="/js/DDSLoader.js"></script>
<script src="/js/jquery.js"></script>
<style>
body { margin: 0; }
canvas { width: 100%; height: 100%; }
</style>
</head>
<body>
<script>
                                        headDone = 0;
					hatDone = 0;
					// Create the scene
					var scene = new THREE.Scene();
					var camera = new THREE.PerspectiveCamera(75, 512 / 512, 0.1, 1000);
					
					// Position camera
					camera.position.y = 0.25;
					
					var renderer = new THREE.WebGLRenderer({alpha: true, antialias: true, preserveDrawingBuffer: true});
					renderer.setSize(512, 512);
					document.body.appendChild(renderer.domElement);
					renderer.shadowMap.enabled = true;
					renderer.shadowMap.cullFace = THREE.CullFaceBack;
					renderer.gammaInput = true;
					renderer.gammaOutput = true;
					
						THREE.ImageUtils.crossOrigin = "";
						camera.position.z = 5;
						var onProgress = function ( xhr ) {
							if ( xhr.lengthComputable ) {
								percentComplete = xhr.loaded / xhr.total * 100;
								console.log( Math.round(percentComplete, 2) + '% downloaded' );
							}
						};
						var onError = function ( xhr ) { };
						THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );
						var mtlLoader = new THREE.MTLLoader();
						mtlLoader.setBaseUrl( '' );
						mtlLoader.setPath( 'https://www.mine2build.eu/Store/Dir/' );
						mtlLoader.load( 'thingTransparent.mtl', function( materials ) {
							materials.preload();
							var objLoader = new THREE.OBJLoader();
							objLoader.setMaterials( materials );
							objLoader.setPath( 'https://www.mine2build.eu/Store/Dir/' );
							objLoader.load( '<?if (empty($Hat)) {
$Hat = "thingTransparent";
}; echo"$Hat";?>.obj', function ( object ) {
								object.scale.set(3.66, 3.65622723, 3.66);
								object.position.x = 0;
								object.position.y = -0.8958485069191511;
								object.rotation.y = 0.5;
								
								scene.add( object );
								hatDone = 1;
							}, onProgress, onError );
						});
						camera.position.z = 5;
					// HEAD
					THREE.ImageUtils.crossOrigin = "";
					var texture =  THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/<?if (empty($Face)) {
$Face = "defaultface";
}; echo"$Face";?>.png");
					var texturetwo =  THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					
					var textureHead = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					var textureLeftArm = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					var textureTorso = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					var textureRightArm = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					var textureLeftLeg = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					var textureRightLeg = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/ffe0bd.png");
					
					var onProgress = function ( xhr ) {
						if ( xhr.lengthComputable ) {
							var percentComplete = xhr.loaded / xhr.total * 100;
							console.log( Math.round(percentComplete, 2) + '% downloaded' );
						}
					};
					var onError = function ( xhr ) { };
					THREE.Loader.Handlers.add( /\.dds$/i, new THREE.DDSLoader() );
					var mtlLoader = new THREE.MTLLoader();
					mtlLoader.setBaseUrl( '' );
					mtlLoader.setPath( '/' );
					mtlLoader.load( 'Astronaut-mtl.mtl', function( materials ) {
						materials.preload();
						var objLoader = new THREE.OBJLoader();
						objLoader.setMaterials( materials );
						objLoader.setPath( '/' );
						objLoader.load( 'roundedhead1.obj', function ( object ) {
							var material = new THREE.MeshLambertMaterial({map:textureHead});
							object.traverse(function(child) {
								if (child instanceof THREE.Mesh) {
									child.material = material;
								}
							});
							object.scale.set(3.5, 3.5, 3.5);
							object.position.y = 0;
							object.rotation.y = 0.55;
							object.position.z = 0;
							object.position.x = 0.05;
							scene.add( object );
							headDone = 1;
						}, onProgress, onError );
					});

					// FACE
					var geometryFace = new THREE.BoxGeometry(0.80, 0.80, 0.80);
					//var material = new THREE.MeshBasicMaterial({map: texture});
					var materials = [];
					materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, opacity: 0, side: THREE.DoubleSide})); // right face
					materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, opacity: 0, side: THREE.DoubleSide})); // left face
					materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, opacity: 0, side: THREE.DoubleSide})); // top face
					materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, opacity: 0, side: THREE.DoubleSide})); // bottom face
					materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, side: THREE.DoubleSide})); // front face
					materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, opacity: 0, side: THREE.DoubleSide})); // back face
					var material = new THREE.MeshFaceMaterial(materials);
					material.transparent = true;
					var face = new THREE.Mesh(geometryFace, material);
					scene.add(face);
					face.position.y = 0.05;
					face.rotation.y = 0.60;
					face.position.x = 0;
					face.position.z = 0.22;
					
							// T SHIRT
							var texture =  THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/<?if (empty($TShirt)) {
$TShirt = "thingTransparent";
}; echo"$TShirt";?>.png");
							var geometryTShirt = new THREE.BoxGeometry(2, 2, 1);
							var materials = [];
							materials.push(new THREE.MeshLambertMaterial({ map: texturetwo, transparent: true, opacity: 0, side: THREE.DoubleSide})); // right face
							materials.push(new THREE.MeshLambertMaterial({ map: texturetwo, transparent: true, opacity: 0, side: THREE.DoubleSide})); // left face
							materials.push(new THREE.MeshLambertMaterial({ map: texturetwo, transparent: true, opacity: 0, side: THREE.DoubleSide})); // top face
							materials.push(new THREE.MeshLambertMaterial({ map: texturetwo, transparent: true, opacity: 0, side: THREE.DoubleSide})); // bottom face
							materials.push(new THREE.MeshLambertMaterial({ map: texture, transparent: true, side: THREE.DoubleSide})); // front face
							materials.push(new THREE.MeshLambertMaterial({ map: texturetwo, transparent: true, opacity: 0, side: THREE.DoubleSide})); // back face
							var material = new THREE.MeshFaceMaterial(materials);
							material.transparent = true;
							var tshirt = new THREE.Mesh(geometryTShirt, material);
							scene.add(tshirt);
							tshirt.position.y = -1.5;
							tshirt.rotation.y = 0.50;
							tshirt.position.z = 0.001;
							
							// TORSO BLOCK
							var geometryTorsoBlock = new THREE.BoxGeometry(2, 2, 1);
							var material = new THREE.MeshLambertMaterial({map:textureTorso});
							var TorsoBlock = new THREE.Mesh(geometryTorsoBlock, material);
							scene.add(TorsoBlock);
							TorsoBlock.position.y = -1.5;
							TorsoBlock.rotation.y = 0.50;
							
							// TORSO
							var geometryTorso = new THREE.BoxGeometry(2, 2, 1);
							var texture = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/<?if (empty($Top)) {
$Top = "thingTransparent";
}; echo"$Top";?>.png");
							texture.flipY = false;
							texture.flipX = false;
							var material = new THREE.MeshLambertMaterial({map: texture, color: 0xffe0bd, transparent: true, opacity:1});
							
							var RightTorso = [new THREE.Vector2(.371, .205), new THREE.Vector2(.371, .395), new THREE.Vector2(.460, .395), new THREE.Vector2(.460, .205)];
							var LeftTorso = [new THREE.Vector2(.69, .205), new THREE.Vector2(.69, .404), new THREE.Vector2(.168, .404), new THREE.Vector2(.168, .205)];
							var TopTorso = [new THREE.Vector2(.174, .116), new THREE.Vector2(.174, .198), new THREE.Vector2(.353, .198), new THREE.Vector2(.353, .116)];
							var BottomTorso = [new THREE.Vector2(.157, .492), new THREE.Vector2(.356, .492), new THREE.Vector2(.356, .393), new THREE.Vector2(.157, .393)];
							var FrontTorso = [new THREE.Vector2(.170, .205), new THREE.Vector2(.170, .395), new THREE.Vector2(.360, .395), new THREE.Vector2(.360, .205)];
							var BackTorso = [new THREE.Vector2(.472, .205), new THREE.Vector2(.472, .395), new THREE.Vector2(.656, .395), new THREE.Vector2(.656, .205)];
							
							geometryTorso.faceVertexUvs[0] = [];
							geometryTorso.faceVertexUvs[0][0] = [ RightTorso[0], RightTorso[1], RightTorso[3] ];
							geometryTorso.faceVertexUvs[0][1] = [ RightTorso[1], RightTorso[2], RightTorso[3] ];
							geometryTorso.faceVertexUvs[0][2] = [ LeftTorso[0], LeftTorso[1], LeftTorso[3] ];
							geometryTorso.faceVertexUvs[0][3] = [ LeftTorso[1], LeftTorso[2], LeftTorso[3] ];
							geometryTorso.faceVertexUvs[0][4] = [ TopTorso[0], TopTorso[1], TopTorso[3] ];
							geometryTorso.faceVertexUvs[0][5] = [ TopTorso[1], TopTorso[2], TopTorso[3] ];
							geometryTorso.faceVertexUvs[0][6] = [ BottomTorso[0], BottomTorso[1], BottomTorso[3] ];
							geometryTorso.faceVertexUvs[0][7] = [ BottomTorso[1], BottomTorso[2], BottomTorso[3] ];
							geometryTorso.faceVertexUvs[0][8] = [ FrontTorso[0], FrontTorso[1], FrontTorso[3] ];
							geometryTorso.faceVertexUvs[0][9] = [ FrontTorso[1], FrontTorso[2], FrontTorso[3] ];
							geometryTorso.faceVertexUvs[0][10] = [ BackTorso[0], BackTorso[1], BackTorso[3] ]; 
							geometryTorso.faceVertexUvs[0][11] = [ BackTorso[1], BackTorso[2], BackTorso[3] ];	
							
							var torso = new THREE.Mesh(geometryTorso, material);
							scene.add(torso);
							torso.position.y = -1.5;
							torso.rotation.y = 0.50;
							
							// LEFT ARM BLOCK
							var geometryLeftArmBlock = new THREE.BoxGeometry(1, 2, 1);
							var material = new THREE.MeshLambertMaterial({map:textureLeftArm});
							var LeftArmBlock = new THREE.Mesh(geometryLeftArmBlock, material);
							scene.add(LeftArmBlock);
							LeftArmBlock.position.y = -1.5;
							LeftArmBlock.position.x = 1.30;
							LeftArmBlock.rotation.y = 0.50;
							LeftArmBlock.position.z = -0.70;
							
							// LEFT ARM
							var geometryLeftArm = new THREE.BoxGeometry(1, 2, 1);
							texture.flipY = false;
							texture.flipX = false;
							var material = new THREE.MeshPhongMaterial({map: texture, color: 0xffe0bd, transparent: true, opacity:1});
							
							var RightLeftArm = [new THREE.Vector2(.69, .645), new THREE.Vector2(.69, .844), new THREE.Vector2(.168, .844), new THREE.Vector2(.168, .645)];
							var LeftLeftArm = [new THREE.Vector2(.271, .645), new THREE.Vector2(.271, .825), new THREE.Vector2(.356, .825), new THREE.Vector2(.356, .645)];
							var TopLeftArm = [new THREE.Vector2(.372, .544), new THREE.Vector2(.372, .628), new THREE.Vector2(.447, .628), new THREE.Vector2(.447, .544)];
							var BottomLeftArm = [new THREE.Vector2(.372, .846), new THREE.Vector2(.372, .923), new THREE.Vector2(.461, .923), new THREE.Vector2(.461, .846)];
							var FrontLeftArm = [new THREE.Vector2(.371, .645), new THREE.Vector2(.371, .820), new THREE.Vector2(.459, .820), new THREE.Vector2(.459, .645)];
							var BackLeftArm = [new THREE.Vector2(.170, .645), new THREE.Vector2(.170, .825), new THREE.Vector2(.263, .825), new THREE.Vector2(.263, .645)];
							geometryLeftArm.faceVertexUvs[0] = [];
							geometryLeftArm.faceVertexUvs[0][0] = [ RightLeftArm[0], RightLeftArm[1], RightLeftArm[3] ]; // RIGHT ARM
							geometryLeftArm.faceVertexUvs[0][1] = [ RightLeftArm[1], RightLeftArm[2], RightLeftArm[3] ]; // RIGHT ARM
							geometryLeftArm.faceVertexUvs[0][2] = [ LeftLeftArm[0], LeftLeftArm[1], LeftLeftArm[3] ]; // LEFT ARM
							geometryLeftArm.faceVertexUvs[0][3] = [ LeftLeftArm[1], LeftLeftArm[2], LeftLeftArm[3] ]; // LEFT ARM
							geometryLeftArm.faceVertexUvs[0][4] = [ TopLeftArm[0], TopLeftArm[1], TopLeftArm[3] ]; // HEAD
							geometryLeftArm.faceVertexUvs[0][5] = [ TopLeftArm[1], TopLeftArm[2], TopLeftArm[3] ]; // HEAD
							geometryLeftArm.faceVertexUvs[0][6] = [ BottomLeftArm[0], BottomLeftArm[1], BottomLeftArm[3] ]; // BOTTOM
							geometryLeftArm.faceVertexUvs[0][7] = [ BottomLeftArm[1], BottomLeftArm[2], BottomLeftArm[3] ]; // BOTTOM
							geometryLeftArm.faceVertexUvs[0][8] = [ FrontLeftArm[0], FrontLeftArm[1], FrontLeftArm[3] ]; // FRONT
							geometryLeftArm.faceVertexUvs[0][9] = [ FrontLeftArm[1], FrontLeftArm[2], FrontLeftArm[3] ]; // FRONT
							geometryLeftArm.faceVertexUvs[0][10] = [ BackLeftArm[0], BackLeftArm[1], BackLeftArm[3] ]; // BACK 
							geometryLeftArm.faceVertexUvs[0][11] = [ BackLeftArm[1], BackLeftArm[2], BackLeftArm[3] ]; // BACK
							var LeftArm = new THREE.Mesh(geometryLeftArm, material);
							scene.add(LeftArm);
							LeftArm.position.y = -1.5;
							LeftArm.position.x = 1.30;
							LeftArm.rotation.y = 0.50;
							LeftArm.position.z = -0.70;
							
								// RIGHT ARM BLOCK
								var geometryRightArmBlock = new THREE.BoxGeometry(1, 2, 1);
								var material = new THREE.MeshLambertMaterial({map:textureRightArm});
								var RightArmBlock = new THREE.Mesh(geometryRightArmBlock, material);
								scene.add(RightArmBlock);
								RightArmBlock.position.y = -1.5;
								RightArmBlock.position.x = -1.30;
								RightArmBlock.rotation.y = 0.50;
								RightArmBlock.position.z = 0.70;
								
								// RIGHT ARM
								var geometryRightArm = new THREE.BoxGeometry(1, 2, 1);
								texture.flipY = false;
								texture.flipX = false;
								var material = new THREE.MeshPhongMaterial({map: texture, color: 0xffe0bd, transparent: true, opacity:1});
								
								var RightRightArm = [new THREE.Vector2(.69, .645), new THREE.Vector2(.69, .844), new THREE.Vector2(.168, .844), new THREE.Vector2(.168, .645)];
								var LeftRightArm = [new THREE.Vector2(.831, .645), new THREE.Vector2(.831, .810), new THREE.Vector2(.904, .810), new THREE.Vector2(.904, .645)];
								var TopRightArm = [new THREE.Vector2(.528, .544), new THREE.Vector2(.528, .625), new THREE.Vector2(.606, .625), new THREE.Vector2(.606, .544)];
								var BottomRightArm = [new THREE.Vector2(.372, .846), new THREE.Vector2(.372, .923), new THREE.Vector2(.460, .923), new THREE.Vector2(.460, .846)];
								var FrontRightArm = [new THREE.Vector2(.531 , .645), new THREE.Vector2(.531, .820), new THREE.Vector2(.612, .820), new THREE.Vector2(.612, .645)];
								var BackRightArm = [new THREE.Vector2(.170, .645), new THREE.Vector2(.170, .825), new THREE.Vector2(.263, .825), new THREE.Vector2(.263, .645)];
								
								geometryRightArm.faceVertexUvs[0] = [];
								
								geometryRightArm.faceVertexUvs[0][0] = [ RightRightArm[0], RightRightArm[1], RightRightArm[3] ]; // RIGHT ARM
								geometryRightArm.faceVertexUvs[0][1] = [ RightRightArm[1], RightRightArm[2], RightRightArm[3] ]; // RIGHT ARM
								  
								geometryRightArm.faceVertexUvs[0][2] = [ LeftRightArm[0], LeftRightArm[1], LeftRightArm[3] ]; // LEFT ARM
								geometryRightArm.faceVertexUvs[0][3] = [ LeftRightArm[1], LeftRightArm[2], LeftRightArm[3] ]; // LEFT ARM
								  
								geometryRightArm.faceVertexUvs[0][4] = [ TopRightArm[0], TopRightArm[1], TopRightArm[3] ]; // HEAD
								geometryRightArm.faceVertexUvs[0][5] = [ TopRightArm[1], TopRightArm[2], TopRightArm[3] ]; // HEAD
								  
								geometryRightArm.faceVertexUvs[0][6] = [ BottomRightArm[0], BottomRightArm[1], BottomRightArm[3] ]; // BOTTOM
								geometryRightArm.faceVertexUvs[0][7] = [ BottomRightArm[1], BottomRightArm[2], BottomRightArm[3] ]; // BOTTOM
								  
								geometryRightArm.faceVertexUvs[0][8] = [ FrontRightArm[0], FrontRightArm[1], FrontRightArm[3] ]; // FRONT
								geometryRightArm.faceVertexUvs[0][9] = [ FrontRightArm[1], FrontRightArm[2], FrontRightArm[3] ]; // FRONT
								  
								geometryRightArm.faceVertexUvs[0][10] = [ BackRightArm[0], BackRightArm[1], BackRightArm[3] ]; // BACK 
								geometryRightArm.faceVertexUvs[0][11] = [ BackRightArm[1], BackRightArm[2], BackRightArm[3] ]; // BACK
								var RightArm = new THREE.Mesh(geometryRightArm, material);
								scene.add(RightArm);
								RightArm.position.y = -1.5;
								RightArm.position.x = -1.30;
								RightArm.rotation.y = 0.50;
								RightArm.position.z = 0.70;
								
							// LEFT LEG BLOCK
							var geometryLeftLegBlock = new THREE.BoxGeometry(1, 2, 1);
							var material = new THREE.MeshLambertMaterial({map:textureLeftLeg});
							var LeftLegBlock = new THREE.Mesh(geometryLeftLegBlock, material);
							scene.add(LeftLegBlock);
							LeftLegBlock.position.y = -3.51;
							LeftLegBlock.position.x = 0.45;
							LeftLegBlock.rotation.y = 0.50;
							LeftLegBlock.position.z = -0.25;

							// LEFT LEG
							var geometryLeftLeg = new THREE.BoxGeometry(1, 2, 1);
							var texture = THREE.ImageUtils.loadTexture("https://www.mine2build.eu/Store/Dir/<?if (empty($Bottom)) {
$Bottom = "thingTransparent";
}; echo"$Bottom";?>.png");
							texture.flipY = false;
							texture.flipX = false;
							var material = new THREE.MeshPhongMaterial({map: texture, color: 0xffe0bd, transparent: true, opacity:1});
							
							var RightLeftLeg = [new THREE.Vector2(.69, .645), new THREE.Vector2(.69, .844), new THREE.Vector2(.168, .844), new THREE.Vector2(.168, .645)];
							var LeftLeftLeg = [new THREE.Vector2(.271, .645), new THREE.Vector2(.271, .825), new THREE.Vector2(.356, .825), new THREE.Vector2(.356, .645)];
							var TopLeftLeg = [new THREE.Vector2(.372, .544), new THREE.Vector2(.372, .628), new THREE.Vector2(.447, .628), new THREE.Vector2(.447, .544)];
							var BottomLeftLeg = [new THREE.Vector2(.372, .846), new THREE.Vector2(.372, .923), new THREE.Vector2(.461, .923), new THREE.Vector2(.461, .846)];
							var FrontLeftLeg = [new THREE.Vector2(.371, .645), new THREE.Vector2(.371, .820), new THREE.Vector2(.459, .820), new THREE.Vector2(.459, .645)];
							var BackLeftLeg = [new THREE.Vector2(.170, .645), new THREE.Vector2(.170, .825), new THREE.Vector2(.263, .825), new THREE.Vector2(.263, .645)];
							geometryLeftLeg.faceVertexUvs[0] = [];
							geometryLeftLeg.faceVertexUvs[0][0] = [ RightLeftLeg[0], RightLeftLeg[1], RightLeftLeg[3] ]; // RIGHT Leg
							geometryLeftLeg.faceVertexUvs[0][1] = [ RightLeftLeg[1], RightLeftLeg[2], RightLeftLeg[3] ]; // RIGHT Leg
							geometryLeftLeg.faceVertexUvs[0][2] = [ LeftLeftLeg[0], LeftLeftLeg[1], LeftLeftLeg[3] ]; // LEFT Leg
							geometryLeftLeg.faceVertexUvs[0][3] = [ LeftLeftLeg[1], LeftLeftLeg[2], LeftLeftLeg[3] ]; // LEFT Leg
							geometryLeftLeg.faceVertexUvs[0][4] = [ TopLeftLeg[0], TopLeftLeg[1], TopLeftLeg[3] ]; // HEAD
							geometryLeftLeg.faceVertexUvs[0][5] = [ TopLeftLeg[1], TopLeftLeg[2], TopLeftLeg[3] ]; // HEAD
							geometryLeftLeg.faceVertexUvs[0][6] = [ BottomLeftLeg[0], BottomLeftLeg[1], BottomLeftLeg[3] ]; // BOTTOM
							geometryLeftLeg.faceVertexUvs[0][7] = [ BottomLeftLeg[1], BottomLeftLeg[2], BottomLeftLeg[3] ]; // BOTTOM
							geometryLeftLeg.faceVertexUvs[0][8] = [ FrontLeftLeg[0], FrontLeftLeg[1], FrontLeftLeg[3] ]; // FRONT
							geometryLeftLeg.faceVertexUvs[0][9] = [ FrontLeftLeg[1], FrontLeftLeg[2], FrontLeftLeg[3] ]; // FRONT
							geometryLeftLeg.faceVertexUvs[0][10] = [ BackLeftLeg[0], BackLeftLeg[1], BackLeftLeg[3] ]; // BACK 
							geometryLeftLeg.faceVertexUvs[0][11] = [ BackLeftLeg[1], BackLeftLeg[2], BackLeftLeg[3] ]; // BACK
							var LeftLeg = new THREE.Mesh(geometryLeftLeg, material);
							scene.add(LeftLeg);
							LeftLeg.position.y = -3.51;
							LeftLeg.position.x = 0.45;
							LeftLeg.rotation.y = 0.50;
							LeftLeg.position.z = -0.25;
							
							// RIGHT LEG BLOCK
							var geometryRightLegBlock = new THREE.BoxGeometry(1, 2, 1);
							var material = new THREE.MeshLambertMaterial({map:textureRightLeg});
							var RightLegBlock = new THREE.Mesh(geometryRightLegBlock, material);
							scene.add(RightLegBlock);
							RightLegBlock.position.y = -3.5;
							RightLegBlock.position.x = -0.45;
							RightLegBlock.rotation.y = 0.50;
							RightLegBlock.position.z = 0.25;

							// RIGHT Leg
							var geometryRightLeg = new THREE.BoxGeometry(1, 2, 1);
							texture.flipY = false;
							texture.flipX = false;
							var material = new THREE.MeshPhongMaterial({map: texture, color: 0xffe0bd, transparent: true, opacity:1});
							
							var RightRightLeg = [new THREE.Vector2(.69, .645), new THREE.Vector2(.69, .844), new THREE.Vector2(.168, .844), new THREE.Vector2(.168, .645)];
							var LeftRightLeg = [new THREE.Vector2(.831, .645), new THREE.Vector2(.831, .810), new THREE.Vector2(.904, .810), new THREE.Vector2(.904, .645)];
							var TopRightLeg = [new THREE.Vector2(.528, .544), new THREE.Vector2(.528, .625), new THREE.Vector2(.606, .625), new THREE.Vector2(.606, .544)];
							var BottomRightLeg = [new THREE.Vector2(.372, .846), new THREE.Vector2(.372, .923), new THREE.Vector2(.460, .923), new THREE.Vector2(.460, .846)];
							var FrontRightLeg = [new THREE.Vector2(.531 , .645), new THREE.Vector2(.531, .820), new THREE.Vector2(.612, .820), new THREE.Vector2(.612, .645)];
							var BackRightLeg = [new THREE.Vector2(.170, .645), new THREE.Vector2(.170, .825), new THREE.Vector2(.263, .825), new THREE.Vector2(.263, .645)];
							
							geometryRightLeg.faceVertexUvs[0] = [];
							
							geometryRightLeg.faceVertexUvs[0][0] = [ RightRightLeg[0], RightRightLeg[1], RightRightLeg[3] ]; // RIGHT Leg
							geometryRightLeg.faceVertexUvs[0][1] = [ RightRightLeg[1], RightRightLeg[2], RightRightLeg[3] ]; // RIGHT Leg
							  
							geometryRightLeg.faceVertexUvs[0][2] = [ LeftRightLeg[0], LeftRightLeg[1], LeftRightLeg[3] ]; // LEFT Leg
							geometryRightLeg.faceVertexUvs[0][3] = [ LeftRightLeg[1], LeftRightLeg[2], LeftRightLeg[3] ]; // LEFT Leg
							  
							geometryRightLeg.faceVertexUvs[0][4] = [ TopRightLeg[0], TopRightLeg[1], TopRightLeg[3] ]; // HEAD
							geometryRightLeg.faceVertexUvs[0][5] = [ TopRightLeg[1], TopRightLeg[2], TopRightLeg[3] ]; // HEAD
							  
							geometryRightLeg.faceVertexUvs[0][6] = [ BottomRightLeg[0], BottomRightLeg[1], BottomRightLeg[3] ]; // BOTTOM
							geometryRightLeg.faceVertexUvs[0][7] = [ BottomRightLeg[1], BottomRightLeg[2], BottomRightLeg[3] ]; // BOTTOM
							  
							geometryRightLeg.faceVertexUvs[0][8] = [ FrontRightLeg[0], FrontRightLeg[1], FrontRightLeg[3] ]; // FRONT
							geometryRightLeg.faceVertexUvs[0][9] = [ FrontRightLeg[1], FrontRightLeg[2], FrontRightLeg[3] ]; // FRONT
							  
							geometryRightLeg.faceVertexUvs[0][10] = [ BackRightLeg[0], BackRightLeg[1], BackRightLeg[3] ]; // BACK 
							geometryRightLeg.faceVertexUvs[0][11] = [ BackRightLeg[1], BackRightLeg[2], BackRightLeg[3] ]; // BACK
							var RightLeg = new THREE.Mesh(geometryRightLeg, material);
							scene.add(RightLeg);
							RightLeg.position.y = -3.5;
							RightLeg.position.x = -0.45;
							RightLeg.rotation.y = 0.50;
							RightLeg.position.z = 0.25;
							
					// Lighting
					hemiLight = new THREE.HemisphereLight( 0xffffff, 0xffffff, 0.7 );
					hemiLight.color.setHSL( 0.6, 1, 0.6 );
					hemiLight.groundColor.setHSL( 0.095, 1, 0.75 );
					hemiLight.position.set( 0, 400, 0 );
					scene.add( hemiLight );

					dirLight = new THREE.DirectionalLight( 0xffffff, 1 );
					dirLight.color.setHSL( 0.1, 1, 0.95 );
					dirLight.position.set( 0, 1.75, 1 );
					dirLight.position.multiplyScalar( 50 );
					scene.add( dirLight );

					dirLight.castShadow = true;

					dirLight.shadow.mapSize.width = 2048;
					dirLight.shadow.mapSize.height = 2048;

					var d = 50;

					dirLight.shadow.camera.left = -d;
					dirLight.shadow.camera.right = d;
					dirLight.shadow.camera.top = d;
					dirLight.shadow.camera.bottom = -d;

					dirLight.shadow.camera.far = 3500;
					dirLight.shadow.bias = -0.0001;
					
					var render = function() {
						requestAnimationFrame(render);
						camera.lookAt(new THREE.Vector3(0,-2,0));
						renderer.render(scene, camera);
					};
					
					render();

						function checkLoaded() {
							if (headDone == 1 && hatDone == 1) {
								 var Photo = renderer.domElement.toDataURL("image/png");
								$.ajax({
								  type: "POST",
								  url: "https://www.mine2build.eu/saveavatar.php?ID=<?echo"$ID";?>",
								  data: { 
									 base: Photo
								  }
								}).done(function(o) {
								  console.log("Saved."); 
								});
							}
							else {
								setTimeout(checkLoaded, 1500);
							}
						}	
						checkLoaded();
				</script>
</body>