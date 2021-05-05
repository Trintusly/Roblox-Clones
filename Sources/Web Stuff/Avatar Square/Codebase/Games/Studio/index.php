<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>Babylon.js sample code</title>
        <!-- Babylon.js -->
        <script src="https://www.babylonjs.com/hand.minified-1.2.js"></script>
        <script src="https://preview.babylonjs.com/babylon.js"></script>
        <script src="https://preview.babylonjs.com/gui/babylon.gui.min.js"></script>
        <script src="https://preview.babylonjs.com/cannon.js"></script>
        <script src="https://preview.babylonjs.com/oimo.js"></script>
        
        <style>
            html, body {
                overflow: hidden;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            }

            #renderCanvas {
                width: 100%;
                height: 100%;
                touch-action: none;
            }
        </style>
    </head>
<body>
    <canvas id="renderCanvas"></canvas>
    <script>
        var canvas = document.getElementById("renderCanvas");
        var engine = new BABYLON.Engine(canvas, true);

        var createScene = function () {
            var scene = new BABYLON.Scene(engine);
        
            // Lights
            var light0 = new BABYLON.DirectionalLight("Omni", new BABYLON.Vector3(-2, -5, 2), scene);
            var light1 = new BABYLON.PointLight("Omni", new BABYLON.Vector3(2, -5, -2), scene);
        
            // Need a free camera for collisions
            var camera = new BABYLON.FreeCamera("FreeCamera", new BABYLON.Vector3(0, -8, -20), scene);
            camera.attachControl(canvas, true);
        
            //Ground
            var ground = BABYLON.Mesh.CreatePlane("ground", 2500.0, scene);
            ground.material = new BABYLON.StandardMaterial("groundMat", scene);
            ground.material.diffuseColor = new BABYLON.Color3(1, 1, 1);
            ground.material.backFaceCulling = false;
            ground.position = new BABYLON.Vector3(5, -10, -15);
            ground.rotation = new BABYLON.Vector3(Math.PI / 2, 0, 0);
        
            //Simple crate
            var box = new BABYLON.Mesh.CreateBox("crate", 2, scene);
            box.material = new BABYLON.StandardMaterial("Mat", scene);
            box.material.diffuseTexture = new BABYLON.Texture("textures/crate.png", scene);
            box.material.diffuseTexture.hasAlpha = true;
            box.position = new BABYLON.Vector3(5, -9, -10);
        
            var box2 = new BABYLON.Mesh.CreateBox("crate", 2, scene);
            box2.material = new BABYLON.StandardMaterial("Mat", scene);
            box2.material.diffuseTexture = new BABYLON.Texture("textures/crate.png", scene);
            box2.material.diffuseTexture.hasAlpha = true;
            box2.position = new BABYLON.Vector3(5, -7, -10);
        
            //Set gravity for the scene (G force like, on Y-axis)
            scene.gravity = new BABYLON.Vector3(0, -0.9, 0);
        
            // Enable Collisions
            scene.collisionsEnabled = true;
        
            //Then apply collisions and gravity to the active camera
            camera.checkCollisions = true;
            camera.applyGravity = true;
        
            //Set the ellipsoid around the camera (e.g. your player's size)
            camera.ellipsoid = new BABYLON.Vector3(1, 1, 1);
        
            //finally, say which mesh will be collisionable
            ground.checkCollisions = true;
            box.checkCollisions = true;
            box2.checkCollisions = true;
        
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
</body>
</html>
