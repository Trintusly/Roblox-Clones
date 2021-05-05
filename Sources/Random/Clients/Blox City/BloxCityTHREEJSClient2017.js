Physijs.scripts.worker = 'https://gdpublic.bloxcity.com/js/physijs_worker.js';
Physijs.scripts.ammo = 'https://gdpublic.bloxcity.com/js/ammo.js';
var gui = require('nw.gui');
var path = require("path");
var os = require("os");
var commands = gui.App.argv;
var fs = require('fs');
var http = require('http');
gui.App.clearCache();
//gui.Window.get().showDevTools();
var CurrentDIR = path.dirname(process.execPath);
var win = gui.Window.get();
win.maximize();
commands[0] = commands[0].replace("bloxcity://", "");
var content = {
key: commands[0]
};
$.ajax({
url: "https://game-router.bloxcity.com/authenticate",
type: "POST",
success: function(data) {
authInfo = data;
authInfo = authInfo.split("breaker");
},
data: JSON.stringify(content),
async: false
});
var version = 0.10000;
function getLatestVersion() {
var request = http.get("http://game-router.bloxcity.com/version", function(response) {
response.setEncoding('utf8');
response.on("data", function(chunk) {
chunk = chunk.replace(/\r?\n|\r/, '');
if (chunk != version) {
fs.rename(CurrentDIR + "\\app.exe", os.tmpdir() + "\\bloxcity.exe");
var writeStream = fs.createWriteStream(CurrentDIR + "\\bloxcity.exe");
var request = http.get("http://gamedata.bloxcity.com/auto-update/" + chunk + "/bloxcity.exe", function(response) {
response.on("data", function(data) {
writeStream.write(data);
}).on("end", function() {
writeStream.end();
App.restart();
});
});
}
});
});
}
getLatestVersion();
// GLOBAL VARIABLES
var socket = io.connect('https://' + authInfo[1]);
var CharacterTags = {};
var scene;
var player;
var camera;
var swap;
var chatOpen = 0;
var animation;
var action = {};
var mixer = {};
var clipWalk = {};
var clipJump = {};
var characters = {};
var players = {};
var parts = [];
var physicsParts = [];
var clock = new THREE.Clock();
var gameLoaded = 0;
var movePlayerPositionW = 0;
var movePlayerPositionA = 0;
var movePlayerPositionS = 0;
var movePlayerPositionD = 0;
var movePlayerJump = 0;
var freezePlayerPositionW = 0;
var freezePlayerPositionA = 0;
var freezePlayerPositionS = 0;
var freezePlayerPositionD = 0;
var GlobalUnixTime = 0;
var CollisionTime = 0;
var cameraControls;
var flag;
var oldmouseX;
var oldmouseY;
var mouseX;
var mouseY;
var parentObject;
var jumpI;
var water;
var sky, sunSphere;
var TestBox;
var listener;
if (!commands[0]) {
window.location.assign("http://gamedata.bloxcity.com/authentication-failed.html");
}
socket.on('failed authentication', function(data) {
window.location.assign("http://gamedata.bloxcity.com/authentication-failed.html");
});
function checkIfGameLoaded() {
if (gameLoaded == 1) {
$("#game-loading").fadeOut(300, function() {});
}
else {
setTimeout(checkIfGameLoaded, 100);
}
}
checkIfGameLoaded();
// TELL SERVER CLIENT HAS JOINED
socket.on('connect', function() {
LocalSocket = "/#" + socket.id;
socket.emit('new player', [commands[0], commands[1]]);
});
socket.on('load game', function(data) {
var keyState = {};
SCREEN_WIDTH = window.innerWidth;
SCREEN_HEIGHT = window.innerHeight;
init();
animate();
function initSky() {
sky = new THREE.Sky();
scene.add(sky.mesh);
sunSphere = new THREE.Mesh(
new THREE.SphereBufferGeometry( 20000, 16, 8 ),
new THREE.MeshBasicMaterial( { color: 0xffffff } )
);
sunSphere.position.y = - 700000;
sunSphere.visible = false;
scene.add( sunSphere );
var uniforms = sky.uniforms;
uniforms.turbidity.value = 20;
uniforms.reileigh.value = 0.729;
uniforms.luminance.value = 1;
uniforms.mieCoefficient.value = 0.005;
uniforms.mieDirectionalG.value = 0.8;
var theta = Math.PI * ( 0 - 0.5 );
var phi = 2 * Math.PI * ( 0.25 - 0.5 );
sunSphere.position.x = 400000 * Math.cos( phi );
sunSphere.position.y = 400000 * Math.sin( phi ) * Math.sin( theta );
sunSphere.position.z = 400000 * Math.sin( phi ) * Math.cos( theta );
uniforms.sunPosition.value.copy( sunSphere.position );
renderer.render(scene, camera);
}
function init() {
// INITIATE HTML
container = document.createElement('div');
container.id = "container";
document.body.appendChild(container);
// RENDERER
renderer = Detector.webgl? new THREE.WebGLRenderer({antialias: true, alpha: true}): new THREE.CanvasRenderer();
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(SCREEN_WIDTH, SCREEN_HEIGHT);
container.appendChild(renderer.domElement);
renderer.gammaInput = true;
renderer.gammaOutput = true;
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.BasicShadowMap;
// SCENE
scene = new Physijs.Scene();
scene.setGravity(new THREE.Vector3( 0, -400, 0 ));
THREE.ImageUtils.crossOrigin = '*';
// CAMERA
camera = new THREE.PerspectiveCamera(45, SCREEN_WIDTH / SCREEN_HEIGHT, 0.1, 1000000);
scene.add(camera);
listener = new THREE.AudioListener();
camera.add(listener);
controls = new THREE.OrbitControls( camera );
controls.enablePan = false;
controls.maxDistance = 2000;
controls.minPolarAngle = 0;
controls.maxPolarAngle = Math.PI/2;
controls.zoomSpeed = 3;
initSky();
// LIGHTS
var light = new THREE.AmbientLight(0xFFFFFF);
scene.add( light );
var light = new THREE.DirectionalLight(0xFFFFFF, 0.3);
light.position.x = 15;
light.position.y = 75;
light.position.z = 15;
scene.add(light);
// ocean
var waterNormals = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/waternormals.jpg");
waterNormals.wrapS = waterNormals.wrapT = THREE.RepeatWrapping;
water = new THREE.Water(renderer, camera, scene, {
textureWidth: 512,
textureHeight: 512,
waterNormals: waterNormals,
alpha: 1.0,
sunDirection: light.position.normalize(),
sunColor: 0xffffff,
waterColor: 0x001e0f,
distortionScale: 50.0
});
var mirror = new THREE.Mesh(
new THREE.PlaneBufferGeometry(SCREEN_WIDTH * 500, SCREEN_HEIGHT * 500, 10, 10),
water.material
);
mirror.add(water);
water.position.y = -35;
mirror.rotation.x = - Math.PI * 0.5;
scene.add(mirror);
// ocean
// https://i.imgur.com/RyxLhvR.png
var baseplateTexture = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/ILp1A10.jpg");
baseplateTexture.wrapS = baseplateTexture.wrapT = THREE.RepeatWrapping;
//baseplateTexture.repeat.set(5, 5);
baseplate = new Physijs.BoxMesh(
new THREE.CubeGeometry( 2048, 50, 2048 ),
Physijs.createMaterial(new THREE.MeshLambertMaterial({ map: baseplateTexture, side: THREE.DoubleSide}), 1, 0),
0
);
baseplate.position.y = 0;
baseplate.receiveShadow = true;
scene.add(baseplate);
// silly little box
/*TestBox = new Physijs.BoxMesh(
new THREE.CubeGeometry(50, 50, 50),
Physijs.createMaterial(new THREE.MeshLambertMaterial({color:0x298eff}), 0, 0),
1
);
scene.add(TestBox);
TestBox.__dirtyPosition = true;
TestBox.setAngularVelocity(new THREE.Vector3(0, 0, 0));
TestBox.position.y += 85;
TestBox.position.x += 70;
parts.push(TestBox);
// Test Box -- trying invisible BoxMesh and THREE.JS...
TestBoxParent = new Physijs.BoxMesh(
new THREE.CubeGeometry(60, 50, 60),
Physijs.createMaterial(new THREE.MeshLambertMaterial({wireframe: true}), 1, 1),
0
);
scene.add(TestBoxParent);
TestBoxParent.__dirtyPosition = true;
TestBoxParent.position.y += 40;
TestBoxParent.position.x += 70;
TestBoxParent.setCcdMotionThreshold(55);
TestBoxParent.receiveShadow = true;
TestBoxParent.castShadow = true;
physicsParts.push(TestBoxParent);
TestBox = new THREE.Mesh(
new THREE.CubeGeometry(50, 50, 50),
new THREE.MeshLambertMaterial({color: 0x298eff})
);
scene.add(TestBox);
parts.push(TestBox);*/
// ADD LISTENERS
window.addEventListener('resize', onWindowResize, false );
document.addEventListener('keydown', onKeyDown, false );
document.addEventListener('keyup', onKeyUp, false );
}
function onWindowResize() {
camera.aspect = window.innerWidth / window.innerHeight;
camera.updateProjectionMatrix();
renderer.setSize(window.innerWidth, window.innerHeight);
}
function onKeyDown(event) {
keyState[event.keyCode || event.which] = true;
}
function onKeyUp(event) {
keyState[event.keyCode || event.which] = false;
if (players[LocalSocket].walking == 1) {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
movePlayerPositionW = 0;
movePlayerPositionA = 0;
movePlayerPositionS = 0;
movePlayerPositionD = 0;
}
function respawnPlayer() {
socket.emit('respawn player', {});
}
function checkKeyStates() {
if (keyState[38] || keyState[87]) {
if (chatOpen == 0 && freezePlayerPositionW == 0 && !keyState[40] && !keyState[83]) {
player.__dirtyPosition = true;
player.__dirtyRotation = true;
player.position.x -= players[LocalSocket].speed * Math.sin(camera.rotation.y);
player.position.z -= players[LocalSocket].speed * Math.cos(camera.rotation.y);
childPlayer.rotation.y = (camera.rotation.y - Math.PI);
camera.position.x -= players[LocalSocket].speed * Math.sin(camera.rotation.y);
camera.position.z -= players[LocalSocket].speed * Math.cos(camera.rotation.y);
socket.emit('player position', [{action: "forward", x: player.position.x, y: player.position.y, z: player.position.z, camera: childPlayer.rotation.y}]);
movePlayerPositionW = 1;
if (movePlayerJump == 0 && !keyState[32]) {
if (players[LocalSocket].walking == 0) {
players[LocalSocket].walking = 1;
players[LocalSocket].audiowalk.play();
players[LocalSocket].audiowalk.setLoop(true);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).play();
socket.emit('send audio and animation', 'walking');
}
}
else {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
}
else {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
}
else if (keyState[40] || keyState[83]) {
if (chatOpen == 0 && freezePlayerPositionS == 0 && !keyState[38] && !keyState[87]) {
player.__dirtyPosition = true;
player.__dirtyRotation = true;
player.position.x += players[LocalSocket].speed * Math.sin(camera.rotation.y);
player.position.z += players[LocalSocket].speed * Math.cos(camera.rotation.y);
childPlayer.rotation.y = (camera.rotation.y);
camera.position.x += players[LocalSocket].speed * Math.sin(camera.rotation.y);camera.position.z += players[LocalSocket].speed * Math.cos(camera.rotation.y);
socket.emit('player position', [{action: "backwards", x: player.position.x, y: player.position.y, z: player.position.z, camera: camera.rotation.y}]);
movePlayerPositionW = 1;
if (movePlayerJump == 0 && !keyState[32]) {
if (players[LocalSocket].walking == 0) {
players[LocalSocket].walking = 1;
players[LocalSocket].audiowalk.play();
players[LocalSocket].audiowalk.setLoop(true);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).play();
socket.emit('send audio and animation', 'walking');
}
}
else {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
}
else {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
}
else if (keyState[37] || keyState[65]) {
if (chatOpen == 0 && freezePlayerPositionA == 0) {
player.__dirtyPosition = true;
player.__dirtyRotation = true;
childPlayer.rotation.y = camera.rotation.y + -90 * Math.PI / 180;
player.position.x += players[LocalSocket].speed * Math.sin(childPlayer.rotation.y);
player.position.z += players[LocalSocket].speed * Math.cos(childPlayer.rotation.y);
camera.position.x += players[LocalSocket].speed * Math.sin(childPlayer.rotation.y);
camera.position.z += players[LocalSocket].speed * Math.cos(childPlayer.rotation.y);
socket.emit('player position', [{action: "left", x: player.position.x, y: player.position.y, z: player.position.z, camera: childPlayer.rotation.y}]);
movePlayerPositionA = 1;
if (movePlayerJump == 0 && !keyState[32]) {
if (players[LocalSocket].walking == 0) {
players[LocalSocket].walking = 1;
players[LocalSocket].audiowalk.play();
players[LocalSocket].audiowalk.setLoop(true);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).play();
socket.emit('send audio and animation', 'walking');
}
}
else {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
}
}
else if (keyState[39] || keyState[68]) {
if (chatOpen == 0 && freezePlayerPositionD == 0) {
player.__dirtyPosition = true;
player.__dirtyRotation = true;
childPlayer.rotation.y = camera.rotation.y + 90 * Math.PI / 180;
player.position.x += players[LocalSocket].speed * Math.sin(childPlayer.rotation.y);
player.position.z += players[LocalSocket].speed * Math.cos(childPlayer.rotation.y);
camera.position.x += players[LocalSocket].speed * Math.sin(childPlayer.rotation.y);
camera.position.z += players[LocalSocket].speed * Math.cos(childPlayer.rotation.y);
socket.emit('player position', [{action: "right", x: player.position.x, y: player.position.y, z: player.position.z, camera: childPlayer.rotation.y}]);
movePlayerPositionD = 1;
if (movePlayerJump == 0 && !keyState[32]) {
if (players[LocalSocket].walking == 0) {
players[LocalSocket].walking = 1;
players[LocalSocket].audiowalk.play();
players[LocalSocket].audiowalk.setLoop(true);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).play();
socket.emit('send audio and animation', 'walking');
}
}
else {
players[LocalSocket].walking = 0;
players[LocalSocket].audiowalk.setLoop(false);
mixer[LocalSocket].clipAction(clipWalk[LocalSocket]).stop();
socket.emit('stop audio and animation', 'walking');
}
}
}
if (keyState[84]) {
if (chatOpen == 0) {
document.getElementById("chatbox").style.display = "block";
chatOpen = 1;
document.getElementById("chatbox").focus();
}
}
else if (keyState[13]) {
if (chatOpen == 1) {
var chatData = document.getElementById("chatbox").value;
document.getElementById("chatbox").style.display = "none";
chatOpen = 0;
if (chatData) {
socket.emit('send chat', chatData);
}
document.getElementById("chatbox").value = '';
}
}
else if (keyState[32]) {
if (chatOpen == 0 && players[LocalSocket].jumping == 0) {
players[LocalSocket].jumping = 1;
characters[LocalSocket].parent.applyCentralImpulse(new THREE.Vector3(0, 225, 0));
mixer[LocalSocket].clipAction(clipJump[LocalSocket]).setDuration(1).play();
socket.emit('player position', [{action: "jump"}]);
}
}
}
function animate(time) {
var delta = clock.getDelta();
if (player) {
checkKeyStates();
controls.target.copy(characters[LocalSocket].parent.position);
controls.update();
var camOffset = camera.position.clone().sub(controls.target);
camOffset.normalize().multiplyScalar( 1000 );
camera.position = controls.target.clone().add(camOffset);
}
for (var key in characters) {
characters[key].parent.setAngularVelocity(new THREE.Vector3(0, 0, 0));
characters[key].child.position.copy(characters[key].parent.position);
characters[key].parent.rotation.copy(characters[key].child.rotation);
mixer[key].update(delta);
}
for (var i = 0; i < parts.length; i++) {
physicsParts[i].setAngularVelocity(new THREE.Vector3(0, 0, 0));
parts[i].position.copy(physicsParts[i].position);
}
water.material.uniforms.time.value += 1.0 / 60.0;
water.render();
scene.simulate();
renderer.render(scene, camera);
requestAnimationFrame(animate);
}
});
socket.on('spawn player', function(data) {
players[data[0]] = data[1];
if (players[data[0]].admin > 0) {
document.getElementById("playerlist").innerHTML = document.getElementById("playerlist").innerHTML + "<div class=\"chat-username\" id=\"" + data[1].username + "\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td><img src=\"https://storage.googleapis.com/bloxcity-file-storage/assets/images/profile/Administrator.png\" height=\"15\" style=\"padding-right:5px;\"></td><td>" + data[1].usern
}
else {
document.getElementById("playerlist").innerHTML = document.getElementById("playerlist").innerHTML + "<div class=\"chat-username\" id=\"" + data[1].username + "\">" + data[1].username + "</div>";
}
// https://storage.googleapis.com/bloxcity-file-storage/TempGameAnim1.json
var loader = new THREE.JSONLoader();
loader.load('https://gdpublic.bloxcity.com/Main.json', function(geometry, materials) {
var parentMaterial = new Physijs.createMaterial(new THREE.MeshBasicMaterial({visible: false}), 1, 1);
parentObject = new Physijs.BoxMesh(
new THREE.CubeGeometry(35, 60, 10),
parentMaterial,
1
);
scene.add(parentObject);
parentObject.name = data[0]+'parent';
parentObject.__dirtyPosition = true;
parentObject.position.x = data[1].positionx;
parentObject.position.y = data[1].positiony;
parentObject.position.z = data[1].positionz;
parentObject.addEventListener('collision', function(other_object) {
if (players[data[0]].jumping == 1) {
mixer[data[0]].clipAction(clipJump[data[0]]).stop();
players[data[0]].jumping = 0;
}
this.__dirtyPosition = true;
this.__dirtyRotation = true;
this.setLinearVelocity(new THREE.Vector3(0, 0, 0));
this.setAngularVelocity(new THREE.Vector3(0, 0, 0));
// Freeze other object
other_object.__dirtyPosition = true;
other_object.__dirtyRotation = true;
other_object.setLinearVelocity(new THREE.Vector3(0, 0, 0));
other_object.setAngularVelocity(new THREE.Vector3(0, 0, 0));
console.log("collision");
});
materials.forEach(function(mat) {
mat.skinning = true;
});
if (!data[1].face) {
data[1].face = "56d51311be5d0.png";
}
// Set head & face color
//materials[0].color.setHex("0x" + data[1].hexhead);
//materials[1].color.setHex("0x" + data[1].hexhead);
// Set face texture
//materials[0].map = new THREE.ImageUtils.loadTexture("https://storage.googleapis.com/bloxcity-file-storage/" + data[1].face);
materials[0].map = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/face-tan.png");
materials[1].map = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/small.png");
// Set shirt texture
//if (data[1].shirt) {
//materials[2].map = new THREE.ImageUtils.loadTexture("https://storage.googleapis.com/bloxcity-file-storage/" + data[1].shirt);
//materials[3].map = new THREE.ImageUtils.loadTexture("https://storage.googleapis.com/bloxcity-file-storage/" + data[1].shirt);
//materials[5].map = new THREE.ImageUtils.loadTexture("https://storage.googleapis.com/bloxcity-file-storage/" + data[1].shirt);
//materials[2].map = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/temp-shirt.png");
//materials[3].map = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/temp-shirt.png");
//materials[5].map = new THREE.TextureLoader().load("https://gdpublic.bloxcity.com/temp-shirt.png");
//}
//else {
materials[2].color.setHex("0x" + data[1].hexleftarm);
materials[3].color.setHex("0x" + data[1].hextorso);
materials[5].color.setHex("0x" + data[1].hexrightarm);
//}
//if (data[1].pants) {
//materials[6].map = new THREE.TextureLoader().load("https://storage.googleapis.com/bloxcity-file-storage/" + data[1].pants);
// materials[4].map = new THREE.TextureLoader().load("https://storage.googleapis.com/bloxcity-file-storage/" + data[1].pants);
//}
//else {
materials[6].color.setHex("0x" + data[1].hexleftleg);
materials[4].color.setHex("0x" + data[1].hexrightleg);
//}
var mesh = new THREE.SkinnedMesh(geometry, new THREE.MeshFaceMaterial(materials));
mesh.name = data[0];
mesh.position.x = data[1].positionx;
mesh.position.y = data[1].positiony;
mesh.position.z = data[1].positionz;
mesh.rotation.x = data[1].rotationx;
mesh.rotation.y = data[1].rotationy;
mesh.rotation.z = data[1].rotationz;
mesh.scale.x = data[1].scalex;
mesh.scale.y = data[1].scaley;
mesh.scale.z = data[1].scalez;
mesh.castShadow = true;
scene.add(mesh);
// player tag
var spriteMap = new THREE.TextureLoader().load( "https://www.bloxcity.com/GeneratePlayerTag.php?username=" + data[1].username );
var spriteMaterial = new THREE.SpriteMaterial( { map: spriteMap, color: 0xffffff } );
var sprite = new THREE.Sprite( spriteMaterial );
mesh.add( sprite );
sprite.scale.set(0.30, 0.150, 1);
sprite.position.y += 0.6;
// walking sound
var sound = new THREE.PositionalAudio(listener);
var audioLoader = new THREE.AudioLoader();
audioLoader.load( 'https://gdpublic.bloxcity.com/walk.ogg', function( buffer ) {
sound.setBuffer(buffer);
sound.setRefDistance(5);
sound.setVolume(0.15);
players[data[0]].audiowalk = sound;
});
mesh.add(sound);
clipJump[data[0]] = geometry.animations[2];
clipWalk[data[0]] = geometry.animations[3];
mixer[data[0]] = new THREE.AnimationMixer(mesh);
if (data[0] == LocalSocket) {
camera.position.set(0, 125, 100);
camera.rotation.order = 'YXZ';
camera.rotation.y = 0;
camera.rotation.x = -1;
camera.rotation.z = 0;
player = parentObject;
childPlayer = mesh;
document.getElementById("myusername").innerHTML = data[1].username;
gameLoaded = 1;
}
characters[data[0]] = {parent: parentObject, child: mesh};
if (data[1].hatone) {
var mtlLoader = new THREE.MTLLoader();
mtlLoader.setPath('https://storage.googleapis.com/bloxcity-file-storage/sdfj90324j/');
mtlLoader.load(data[1].hatone + '.mtl', function(materials) {
materials.preload();
var objLoader = new THREE.OBJLoader();
objLoader.setMaterials(materials);
objLoader.load('https://storage.googleapis.com/bloxcity-file-storage/sdfj90324j/' + data[1].hatone + '.obj', function(object) {
mesh.add(object);
});
});
}
if (data[1].hattwo) {
var mtlLoader = new THREE.MTLLoader();
mtlLoader.setPath('https://storage.googleapis.com/bloxcity-file-storage/sdfj90324j/');
mtlLoader.load(data[1].hattwo + '.mtl', function(materials) {
materials.preload();
var objLoader = new THREE.OBJLoader();
objLoader.setMaterials(materials);
objLoader.load('https://storage.googleapis.com/bloxcity-file-storage/sdfj90324j/' + data[1].hattwo + '.obj', function(object) {
mesh.add(object);
});
});
}
if (data[1].hatthree) {
var mtlLoader = new THREE.MTLLoader();
mtlLoader.setPath('https://storage.googleapis.com/bloxcity-file-storage/sdfj90324j/');
mtlLoader.load(data[1].hatthree + '.mtl', function(materials) {
materials.preload();
var objLoader = new THREE.OBJLoader();
objLoader.setMaterials(materials);
objLoader.load('https://storage.googleapis.com/bloxcity-file-storage/sdfj90324j/' + data[1].hatthree + '.obj', function(object) {
mesh.add(object);
});
});
}
});
});
socket.on('remove player', function(data) {
delete characters[data[0]];
delete players[data[0]];
var object = scene.getObjectByName(data[0]+'parent');
scene.remove(object);
var object = scene.getObjectByName(data[0]);
scene.remove(object);
document.getElementById(data[1]).remove();
});
socket.on('player position', function(data) {
if (characters[data[0]]) {
characters[data[0]].parent.__dirtyPosition = true;
characters[data[0]].parent.position.x = data[1];
characters[data[0]].parent.position.y = data[2];
characters[data[0]].parent.position.z = data[3];
characters[data[0]].child.rotation.y = data[4];
}
});
socket.on('player jump', function(data) {
if (characters[data[0]]) {
players[data[0]].jumping = 1;
characters[data[0]].parent.applyCentralImpulse(new THREE.Vector3(0, 225, 0));
mixer[data[0]].clipAction(clipJump[data[0]]).setDuration(1).play();
}
});socket.on('send audio and animation', function(data) {
players[data].audiowalk.play();
players[data].audiowalk.setLoop(true);
mixer[data].clipAction(clipWalk[data]).play();
});
socket.on('stop audio and animation', function(data) {
players[data].audiowalk.setLoop(false);
mixer[data].clipAction(clipWalk[data]).stop();
});
socket.on('send chat to client', function(data) {
document.getElementById("chat").innerHTML = document.getElementById("chat").innerHTML + "<div style=\"padding:3px 0;font-size:18px;\">" + data + "</div>";
var chat = document.getElementById("chat");
chat.scrollTop = chat.scrollHeight;
});
socket.on('get stop walking animation', function(data) {
if (typeof mixer[data] != "undefined") {
mixer[data].clipAction(clipWalk[data]).stop();
mixer[data].clipAction(clipJump[data]).stop();
}
});
socket.on('get jump', function(data) {
if (typeof mixer[data] != "undefined") {
mixer[data].clipAction(clipJump[data]).play();
var delta = clock.getDelta();
var theta = clock.getElapsedTime();
mixer[data].update(delta);
}
});