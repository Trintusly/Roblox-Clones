<script src="/js/three.js"></script>
<script src="/js/objloader.js"></script>
<script src="/js/MTLLoader.js"></script>
<script src="/js/DDSLoader.js"></script>
<script src="/js/jquery.js"></script>
<style>
body { margin: 0; }
canvas { width: 100%; height: 100%; }
</style>
<body>
<script>
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
						var objLoader = new THREE.OBJLoader();
						objLoader.setMaterials( materials );
						objLoader.setPath( '/' );
						objLoader.load( 'noynac.obj', function ( object ) {
							var material = new THREE.MeshLambertMaterial({map:textureHead});
							object.traverse(function(child) {
								if (child instanceof THREE.Mesh) {
									child.material = material;
								}
							});
							object.position.y = 0;
							object.rotation.y = y;
							object.position.z = z;
							object.position.x = x;
							scene.add( object );
						};
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
</script>