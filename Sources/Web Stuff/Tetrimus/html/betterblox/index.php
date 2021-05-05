BETTERBLOX GAMES
<html><head><script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.6.2.min.js"></script>
<script src="http://www.html5canvastutorials.com/libraries/Three.js"></script>
<style>body{cursor:url(/ArrowFarCursor.cur),url(/ArrowFarCursor.cur),auto;margin:0;padding:0;}canvas{background-image:url(/sky.png);background-size:100% 100%;height:100%;width:100%;}#chat_boxbg{height:10%;width:100%;background-color:#191919;bottom:0px;position:absolute;}</style>
</head><body oncontextmenu="return false;">
<input type="hidden" id="rand" value="\btes[a-z]+\b">
<input type="hidden" id="grid" value="">
<div id="ui"><div style="height:419.90000000000003px; width:383.99999999999994px; background-image:url(/newplayerlistsqu.png); background-size:383.99999999999994px 419.90000000000003px; margin-left:1536px; position:absolute;"><br><br><b style="color:white; font-size:15px;"><pre></pre></b></div></div>
<script>
setTimeout(function(){draw_ui();},3000);
setInterval(function(){show_pos();},3000);
function draw_ui()
{
var playerlist_width = window.innerWidth/7*1.4;
var playerlist_height = window.innerHeight/3*1.3;
$('#ui').html("<div style='height:"+playerlist_height+"px; width:"+playerlist_width+"px; background-image:url(/newplayerlistsqu.png); background-size:"+playerlist_width+"px "+playerlist_height+"px; margin-left:"+(parseFloat($('canvas').width())-(playerlist_width))+"px; position:absolute;'><br /><br /><b style='color:white; font-size:15px;'><pre></pre></b></div>");
$('canvas').html('<div id="chat_boxbg"></div>');
}
//global vars
var cam_x = 0;
var cam_y = 150;
var cam_z = 0;
var cam_rotate_x = 0;
var cam_rotate_y = 0;
var cam_rotate_z = 0;
var cam_rotate = 0;
var last_rotate_x = 0;
var last_rotate_y = 0;
var last_rotate_x2 = 0;
var last_rotate_y2 = 0;
var renderdist = 15000;
var speed = 5;
var is_turned = 0;
var leg1_rotate_x = 0;
var leg1_anim = 0;
var char_rotate = 0;
var char_x = 3;
var char_y = 110;
var char_z = 40;
var char_face = 'happy';
var leg_1_rotate = 0;
var leg1order = 1;
var leg2_rotate_x = 0;
var leg2_anim = 0;
var leg_2_rotate = 0;
var leg2order = 1;
var arm1_rotate_x = 0;
var arm1_anim = 0;
var arm_1_rotate = 0;
var arm1order = 1;
var arm2_rotate_x = 0;
var arm2_anim = 0;
var arm_2_rotate = 0;
var arm2order = 1;
var falling = 0;
var facing = 'forward';
var baseplate_x = 2000;
var baseplate_y = 100;
var baseplate_z = 2000;
var key1 = '';
var key2 = '';
var has_gear = 0;
var rand_test = new RegExp(document.getElementById('rand').value);
var grid = document.getElementById('grid').value;
var forward = '0';
var backward = '0';
var left = '0';
var right = '0';
var jumping = '0';
var jumping_dist = 0;
var jumping_fall = '0';
var some_loop = 0;
var blocked_pos_x = [];
var blocked_pos_z = [];
var blocked_pos_y = [];
var testthingylol = 0;
var create_block = 0;
var create_block_tick = 50;
var mymouse_x;
var mymouse_y;
var testblock_pos_x = 50;
var testblock_pos_y = 100;
var testblock_pos_z = 50;
var has_set = 0;
//end of global vars
function gear_equip(num)
{
has_gear = 1;
}
function show_pos()
{
console.log('x '+Math.round(char_x)+' y '+Math.round(char_y)+' z '+Math.round(char_z));
}
//movement stuff
window.onmousedown = mousedowncheck;
window.onmousemove = mousemove;
window.onmouseup = mouseup;
window.onkeydown = keydown;
window.onkeyup = keyup;
window.onblur = blur;
function blur()
{
forward = '0';
backward = '0';
left = '0';
right = '0';
jumping = '0';
leg1_anim = 0;
leg2_anim = 0;
arm1_anim = 0;
arm2_anim = 0;
leg_1_rotate = 0;
leg_2_rotate = 0;
arm_1_rotate = 0;
arm_2_rotate = 0;
}
function stop_leg1rotate()
{
leg1_anim = 0;
}
function stop_leg2rotate()
{
leg2_anim = 0;
}
function stop_arm1rotate()
{
arm1_anim = 0;
}
function stop_arm2rotate()
{
arm2_anim = 0;
}
function keyup(e)
{
var keyz = e.keyCode;
if(keyz == 87)
{
forward = '0';
}
if(keyz == 83)
{
backward = '0';
}
if(keyz == 68)
{
right = '0';
}
if(keyz == 65)
{
left = '0';
}
if(keyz == 87 || keyz == 83 || keyz == 68 || keyz == 65)
{
leg_1_rotate = 0;
leg_2_rotate = 0;
arm_1_rotate = 0;
arm_2_rotate = 0;
}
}
function keydown(e)
{
var key = e.keyCode;
if(key == 49)
{
if(has_gear == 1)
{
has_gear = 0;
}
else
{
gear_equip();
}
}
if(1 == 2)
{
}
else
{
if(key1.length < 1)
{
key1 = key;
}
else
{
if(key2.length < 1)
{
key2 = key;
}
}
if(key == 87)
{
if(facing != 'forward')
{
facing = 'forward';
}
forward = '1';
}
if(key == 83)
{
if(facing != 'backward')
{
facing = 'backward';
}
backward = '1';
}
if(key == 68)
{
if(facing != 'right')
{
facing = 'right';
}
right = '1';
}
if(key == 65)
{
if(facing != 'left')
{
facing = 'left';
}
left = '1';
}
if(key == 32)
{
if(jumping != '1' && jumping_fall != '1')
{
jumping = '1';
}
}
}
}

function mouseup(e)
{
if ('which' in event)
  {
  switch (event.which)
    {
    case 1:
      mousebutton = 'left';
      break;
    case 2:
      mousebutton = 'middle';
      break;
    case 3:
      mousebutton = 'right';
      break;
    }
  }
if(mousebutton == 'left')
{
}
if(mousebutton == 'right')
{
cam_rotate = 0;
}
}
function mousemove(e)
{
mymouse_x = e.clientX - $('canvas').offset().left;
mymouse_y = e.clientY - $('canvas').offset().top;
if(cam_rotate == 1)
{
var mousex = e.clientX - $('canvas').offset().left;
var mousey = e.clientY - $('canvas').offset().top;
if(mousex < last_rotate_x)
{
cam_rotate_y +=0.015;
}
if(mousex > last_rotate_x)
{
cam_rotate_y -=0.015;
}
last_rotate_x = mousex;
last_rotate_y = mousey;
}
else
{
/*
var mousex = e.clientX - $('canvas').offset().left;
var mousey = e.clientY - $('canvas').offset().top;
if(mousex < last_rotate_x2)
{
testblock_pos_x-=(last_rotate_x2-mousex);
}
if(mousex > last_rotate_x2)
{
testblock_pos_x+=(mousex-last_rotate_x2);
}
if(mousey < last_rotate_y2)
{
testblock_pos_z+=(last_rotate_y2-mousey);
}
if(mousey > last_rotate_y2)
{
testblock_pos_z-=(mousey-last_rotate_y2);
}
last_rotate_x2 = mousex;
last_rotate_y2 = mousey;
*/
}
}
function mousedowncheck(e)
{
if ('which' in event)
  {
  switch (event.which)
    {
    case 1:
      mousebutton = 'left';
      break;
    case 2:
      mousebutton = 'middle';
      break;
    case 3:
      mousebutton = 'right';
      break;
    }
  }
create_block_tick = 0;
if(mousebutton == 'left')
{
}
if(mousebutton == 'right')
{
cam_rotate = 1;
}
}
//end of movement stuff

    window.requestAnimFrame = (function(callback){
        return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        function(callback){
            window.setTimeout(callback, 1000 / 60);
        };
    })();
 
    function animate(lastTime, angularSpeed, three){
        // update
        var date = new Date();
        var time = date.getTime();
        var timeDiff = time - lastTime;
        var angleChange = 0;
		speed = 5;
        three.cube.rotation.y += angleChange;
        lastTime = time;
        // render
        three.renderer.render(three.scene, three.camera);
		
		//camera
		three.camera = new THREE.PerspectiveCamera(450, window.innerWidth / window.innerHeight, 1, (renderdist+5000));
		three.camera.position.x = char_x + (Math.sin(cam_rotate_y)*speed)*24;
		three.camera.position.y = char_y+150;
		three.camera.position.z = char_z + (Math.cos(cam_rotate_y)*speed)*24;
		three.camera.rotation.x = cam_rotate_x;
		three.camera.rotation.y = cam_rotate_y;
		three.camera.rotation.z = cam_rotate_z;
		
		//scene
		three.character.rotation.y = char_rotate;
		three.character.position.x = char_x;
		three.character.position.y = char_y;
		three.character.position.z = char_z;
		three.character_leg_1.rotation.x = leg_1_rotate;
		three.character_leg_2.rotation.x = leg_2_rotate;
		three.character_arm_1.rotation.x = arm_1_rotate;
		three.character_arm_2.rotation.x = arm_2_rotate;
		
		three.cube.position.y = 0;
		if(create_block_tick == 100)
		{
		var leg2 = new THREE.MeshBasicMaterial({map:THREE.ImageUtils.loadTexture('http://www.social-avatar.net/world/leg.png')});
		create_block = new THREE.Mesh(new THREE.CubeGeometry(20, 20, 20, 1, 1, 1, leg2), new THREE.MeshFaceMaterial());
		create_block.overdraw = true;
		create_block.position.x = char_x + -(Math.cos(cam_rotate_y)*20);
		create_block.position.y = three.character.position.y+80;
		create_block.position.z = char_z + -(Math.cos(cam_rotate_y)*20);
		three.scene.add(create_block);
		create_block = '';
		create_block_tick = 1;
		}
		
		if(jumping != '1' && jumping_fall != '1')
		{
		if(Math.round(three.character.position.z) == 0)
		{
		new_z = 1;
		}
		else
		{
		new_z = Math.round(three.character.position.z);
		}
		if(Math.round(three.character.position.x) == 0)
		{
		new_x = 1;
		}
		else
		{
		new_x = Math.round(three.character.position.x);
		}
		if(jQuery.inArray(Math.round(three.character.position.y-1), blocked_pos_y) > 0 && jQuery.inArray(Math.round(new_x), blocked_pos_x) > 0 && jQuery.inArray(Math.round(new_z), blocked_pos_z) > 0)
		{
		}
		else
		{
		if(testthingylol < 5 && three.character.position.y < -18)
		{
		if(jQuery.inArray(Math.round(new_x), blocked_pos_x) > 0)
		{
		console.log('x is true');
		}
		else
		{
		console.log('x '+Math.round(new_x));
		}
		if(jQuery.inArray(Math.round(three.character.position.y-1), blocked_pos_y) > 0)
		{
		console.log('y is true');
		}
		else
		{
		console.log('y '+three.character.position.y);
		}
		if(jQuery.inArray(Math.round(new_z), blocked_pos_z) > 0 || Math.round(new_z) == 0)
		{
		console.log('z is true');
		}
		else
		{
		console.log('z '+Math.round(new_z));
		}
		testthingylol++;
		}
		if(jQuery.inArray(Math.round(three.character.position.y-3), blocked_pos_y) > 0)
		{
		char_y-=2;
		}
		else
		{
		if(jQuery.inArray(Math.round(three.character.position.y-2), blocked_pos_y) > 0)
		{
		char_y--;
		}
		else
		{
		char_y-=3;
		}
		}
		}
		}
		if(has_gear == 1)
		{
		three.character_arm_1.rotation.x = 1.58;
		three.character_arm_1.position.y = 113;
		three.character_arm_1.position.z = -5;
		}
		else
		{
		three.character_arm_1.position.z = 0;
		}
		if(falling == 0)
		{
		if(has_gear == 0)
		{
		three.character_arm_1.position.y = cam_y-42.5;
		three.character_arm_2.position.y = cam_y-42.5;
		}
		}
		if(char_y < -600)
		{
		char_x = 15;
		char_y = 110;
		char_z = 15;
		falling = 0;
		testthingylol = 0;
		}
		var speed_calc = 1;
		if(forward == '1')
		{
		speed_calc++;
		}
		if(backward == '1')
		{
		speed_calc++;
		}
		if(left == '1')
		{
		speed_calc++;
		}
		if(right == '1')
		{
		speed_calc++;
		}
		speed = 5/speed_calc;
		if(forward == '1')
		{
		if(jQuery.inArray(Math.round(three.character.position.y-1), blocked_pos_y) < 1 && jQuery.inArray(Math.round(three.character.position.x+-(Math.cos(cam_rotate_y)*speed)), blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+-(Math.cos(cam_rotate_y)*speed)), blocked_pos_z) > 0 || jQuery.inArray(Math.round(three.character.position.x+-(Math.cos(cam_rotate_y)*speed))+'a', blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+-(Math.cos(cam_rotate_y)*speed))+'a', blocked_pos_z) > 0)
		{
		}
		else
		{
		char_z += -(Math.cos(cam_rotate_y)*speed);
		char_x += -(Math.sin(cam_rotate_y)*speed);
		char_rotate = cam_rotate_y;
		}
		}
		if(backward == '1')
		{
		if(jQuery.inArray(Math.round(three.character.position.y-1), blocked_pos_y) < 1 && jQuery.inArray(Math.round(three.character.position.x+(Math.cos(cam_rotate_y)*speed)), blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+(Math.cos(cam_rotate_y)*speed)), blocked_pos_z) > 0 || jQuery.inArray(Math.round(three.character.position.x+(Math.cos(cam_rotate_y)*speed))+'a', blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+(Math.cos(cam_rotate_y)*speed))+'a', blocked_pos_z) > 0)
		{
		}
		else
		{
		char_z += (Math.cos(cam_rotate_y)*speed);
		char_x += (Math.sin(cam_rotate_y)*speed);
		char_rotate = cam_rotate_y;
		}
		}
		if(right == '1')
		{
		if(jQuery.inArray(Math.round(three.character.position.y-1), blocked_pos_y) < 1 && jQuery.inArray(Math.round(three.character.position.x+-(Math.cos(cam_rotate_y-1.6)*speed)), blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+-(Math.cos(cam_rotate_y-1.6)*speed)), blocked_pos_z) > 0 || jQuery.inArray(Math.round(three.character.position.x+-(Math.cos(cam_rotate_y-1.6)*speed))+'a', blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+-(Math.cos(cam_rotate_y-1.6)*speed))+'a', blocked_pos_z) > 0)
		{
		}
		else
		{
		char_rotate = cam_rotate_y;
		char_z += -(Math.cos(char_rotate-1.6)*speed);
		char_x += -(Math.sin(char_rotate-1.6)*speed);
		}
		}
		if(left == '1')
		{
		if(jQuery.inArray(Math.round(three.character.position.y-1), blocked_pos_y) < 1 && jQuery.inArray(Math.round(three.character.position.x+(Math.cos(cam_rotate_y-1.6)*speed)), blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+(Math.cos(cam_rotate_y-1.6)*speed)), blocked_pos_z) > 0 || jQuery.inArray(Math.round(three.character.position.x+(Math.cos(cam_rotate_y-1.6)*speed))+'a', blocked_pos_x) > 0 && jQuery.inArray(Math.round(three.character.position.z+(Math.cos(cam_rotate_y-1.6)*speed))+'a', blocked_pos_z) > 0)
		{
		}
		else
		{
		char_rotate = cam_rotate_y;
		char_z += -(Math.cos(char_rotate+1.6)*speed);
		char_x += -(Math.sin(char_rotate+1.6)*speed);
		}
		}
		if(jumping == '1')
		{
		if(jumping_dist != 50)
		{
		char_y+=2;
		jumping_dist+=2;
		}
		}
		if(jumping_dist == 50)
		{
		jumping = '0';
		jumping_fall = '1';
		}
		if(jumping_dist != 0)
		{
		if(jumping_fall == '1')
		{
		char_y-=2;
		jumping_dist-=2;
		}
		}
		if(jumping_dist == 0 && jumping_fall == '1')
		{
		jumping_fall = '0';
		}
		if(forward == '1' || backward == '1' || left == '1' || right == '1')
		{
		if(leg1_anim == 0)
		{
		if(leg1order == 1)
		{
		leg_1_rotate += .1;
		}
		if(leg1order == 2)
		{
		leg_1_rotate -= .1;
		}
		if(leg1order == 1 && leg_1_rotate > .4)
		{
		leg1order = 2;
		}
		if(leg1order == 2 && leg_1_rotate < -.4)
		{
		leg1order = 1;
		}
		}
		if(leg2_anim == 0)
		{
		if(leg2order == 1)
		{
		leg_2_rotate += .1;
		}
		if(leg2order == 2)
		{
		leg_2_rotate -= .1;
		}
		if(leg2order == 1 && leg_2_rotate > .4)
		{
		leg2order = 2;
		}
		if(leg2order == 2 && leg_2_rotate < -.4)
		{
		leg2order = 1;
		}
		}
		if(arm1_anim == 0)
		{
		if(arm1order == 1)
		{
		arm_1_rotate += .1;
		}
		if(arm1order == 2)
		{
		arm_1_rotate -= .1;
		}
		if(arm1order == 1 && arm_1_rotate > .4)
		{
		arm1order = 2;
		}
		if(arm1order == 2 && arm_1_rotate < -.4)
		{
		arm1order = 1;
		}
		}
		if(arm2_anim == 0)
		{
		if(arm2order == 1)
		{
		arm_2_rotate += .1;
		}
		if(arm2order == 2)
		{
		arm_2_rotate -= .1;
		}
		if(arm2order == 1 && arm_2_rotate > .4)
		{
		arm2order = 2;
		}
		if(arm2order == 2 && arm_2_rotate < -.4)
		{
		arm2order = 1;
		}
		}
		leg1_anim = 1;
		leg2_anim = 1;
		arm1_anim = 1;
		arm2_anim = 1;
		setTimeout(function(){stop_leg1rotate();},800);
		setTimeout(function(){stop_leg2rotate();},1200);
		setTimeout(function(){stop_arm1rotate();},1600);
		setTimeout(function(){stop_arm2rotate();},1000);
		}
		if(jumping == '1' || jumping_fall == '1')
		{
		if(has_gear == 0)
		{
		three.character_arm_1.position.y = 123;
		three.character_arm_2.position.y = 123;
		}
		}
        // request new frame
        requestAnimFrame(function(){
            animate(lastTime, angularSpeed, three);
        });
    }
 
    window.onload = function(){
        var angularSpeed = 0.2; // revolutions per second
        var lastTime = 0;
 
        var renderer = new THREE.WebGLRenderer();
        renderer.setSize((window.innerWidth-10), (window.innerHeight-20));
        document.body.appendChild(renderer.domElement);
 
        // camera
        var camera = new THREE.PerspectiveCamera(450, window.innerWidth / window.innerHeight, 1, (renderdist+5000));
		camera.position.x = cam_x;
		camera.position.y = cam_y;
		camera.position.z = cam_z;
		camera.rotation.x = cam_rotate_x;
		camera.rotation.y = cam_rotate_y;
		camera.rotation.z = cam_rotate_z;
		
        // scene
        var scene = new THREE.Scene();
 
        // cube
        var sky = [];
        for (var n = 0; n < 6; n++) {
            sky.push([new THREE.MeshBasicMaterial({
				map:THREE.ImageUtils.loadTexture('/sky3.png')
            })]);
        }
        var baseplate = [];
        for (var n = 0; n < 6; n++) {
            baseplate.push([new THREE.MeshBasicMaterial({
				map:THREE.ImageUtils.loadTexture('/brick.png')
            })]);
        }
		var testblock_texture = [];
        for (var n = 0; n < 6; n++) {
            testblock_texture.push([new THREE.MeshBasicMaterial({
				map:THREE.ImageUtils.loadTexture('/testblock.png')
            })]);
        }
		var torso = new THREE.MeshBasicMaterial({map:THREE.ImageUtils.loadTexture('/torso.png')});
		
		var leg = new THREE.MeshBasicMaterial({map:THREE.ImageUtils.loadTexture('/leg.png')});
		
		var face = new THREE.MeshBasicMaterial({map:THREE.ImageUtils.loadTexture('/happy.png')});
		
		var head_geom = new THREE.CubeGeometry(15, 15, 15, 1, 1, 1);
		
		head_geom.faces[ 0 ].materials.push( leg );
		head_geom.faces[ 1 ].materials.push( leg );
		head_geom.faces[ 2 ].materials.push( leg );
		head_geom.faces[ 3 ].materials.push( leg );
		head_geom.faces[ 4 ].materials.push( leg );
		head_geom.faces[ 5 ].materials.push( leg );
		head_geom.faces[ 5 ].materials.push( face );
 
        var cube = new THREE.Mesh(new THREE.CubeGeometry(2000, 100, 2000, 1, 1, 1, baseplate), new THREE.MeshFaceMaterial());
        cube.overdraw = true;
		cube.position.x = 0;
		cube.position.z = 0;
		cube.position.y = 0;
        scene.add(cube);
		var baseplate_blocked_x = cube.position.x;
		while(baseplate_blocked_x < (cube.position.x+1000))
		{
		blocked_pos_x.push(baseplate_blocked_x);
		baseplate_blocked_x++;
		}
		var baseplate_blocked_z = cube.position.z;
		while(baseplate_blocked_z < (cube.position.z+1000))
		{
		blocked_pos_z.push(baseplate_blocked_z);
		baseplate_blocked_z++;
		}
		var baseplate_blocked_x2 = cube.position.x;
		while(baseplate_blocked_x2 > (-1000))
		{
		blocked_pos_x.push(baseplate_blocked_x2);
		baseplate_blocked_x2--;
		}
		var baseplate_blocked_z2 = cube.position.z;
		blocked_pos_z.push(0);
		while(baseplate_blocked_z2 > (-1000))
		{
		blocked_pos_z.push(baseplate_blocked_z2);
		baseplate_blocked_z2--;
		}
		var baseplate_blocked_y = -19;
		while(baseplate_blocked_y >= (-20))
		{
		blocked_pos_y.push(baseplate_blocked_y);
		baseplate_blocked_y--;
		}
        var cube2 = new THREE.Mesh(new THREE.CubeGeometry(30000, 12000, 100, 1, 1, 1, sky), new THREE.MeshFaceMaterial());
        cube2.overdraw = true;
		cube2.position.z = -(renderdist-6500);
        scene.add(cube2);
        var cube3 = new THREE.Mesh(new THREE.CubeGeometry(100, 10500, 15000, 1, 1, 1, sky), new THREE.MeshFaceMaterial());
        cube3.overdraw = true;
		cube3.position.x = (renderdist-5000);
        scene.add(cube3);
        var cube4 = new THREE.Mesh(new THREE.CubeGeometry(100, 10500, 15000, 1, 1, 1, sky), new THREE.MeshFaceMaterial());
        cube4.overdraw = true;
		cube4.position.x = -(renderdist-5000);
        scene.add(cube4);
        var cube5 = new THREE.Mesh(new THREE.CubeGeometry(30000, 10500, 100, 1, 1, 1, sky), new THREE.MeshFaceMaterial());
        cube5.overdraw = true;
		cube5.position.z = (7500);
        scene.add(cube5);
        var cube6 = new THREE.Mesh(new THREE.CubeGeometry(30000, 100, 30000, 1, 1, 1, sky), new THREE.MeshFaceMaterial());
        cube6.overdraw = true;
		cube6.position.y = (-7500);
        scene.add(cube6);
        var cube7 = new THREE.Mesh(new THREE.CubeGeometry(30000, 100, 30000, 1, 1, 1, sky), new THREE.MeshFaceMaterial());
        cube7.overdraw = true;
		cube7.position.y = (7500);
        scene.add(cube7);
		
		var testblock = new THREE.Mesh(new THREE.CubeGeometry(100, 100, 100, 1, 1, 1, testblock_texture), new THREE.MeshFaceMaterial());
        testblock.overdraw = true;
		testblock.position.x = 50;
		testblock.position.z = -200;
		testblock.position.y = 100;
		scene.add(testblock);
		var testblock_blocked_x = testblock.position.x;
		while(testblock_blocked_x < (0+100))
		{
		if(jQuery.inArray(testblock_blocked_x, blocked_pos_x) > 0)
		{
		blocked_pos_x.push(testblock_blocked_x+'a');
		}
		else
		{
		blocked_pos_x.push(testblock_blocked_x);
		}
		testblock_blocked_x++;
		}
		var testblock_blocked_z = testblock.position.z;
		while(testblock_blocked_z < (testblock.position.z+50))
		{
		if(jQuery.inArray(testblock_blocked_z, blocked_pos_z) > 0)
		{
		blocked_pos_z.push(testblock_blocked_z+'a');
		}
		else
		{
		blocked_pos_z.push(testblock_blocked_z);
		}
		testblock_blocked_z++;
		}
		var testblock_blocked_x2 = testblock.position.x;
		while(testblock_blocked_x2 > (0-10))
		{
		if(jQuery.inArray(testblock_blocked_x2, blocked_pos_x) > 0)
		{
		blocked_pos_x.push(testblock_blocked_x2+'a');
		}
		else
		{
		blocked_pos_x.push(testblock_blocked_x2);
		}
		testblock_blocked_x2--;
		}
		var testblock_blocked_z2 = testblock.position.z;
		while(testblock_blocked_z2 > (testblock.position.z-50))
		{
		if(jQuery.inArray(testblock_blocked_z2, blocked_pos_z) > 0)
		{
		blocked_pos_z.push(testblock_blocked_z2+'a');
		}
		else
		{
		blocked_pos_z.push(testblock_blocked_z2);
		}
		testblock_blocked_z2--;
		}
		var testblock_blocked_y = testblock.position.y;
		while(testblock_blocked_y > (testblock.position.y+50))
		{
		blocked_pos_y.push(testblock_blocked_y);
		testblock_blocked_y++;
		}
		
		//character
		
        var character_torso = new THREE.Mesh(new THREE.CubeGeometry(30, 30, 15, 1, 1, 1, torso), new THREE.MeshFaceMaterial());
        character_torso.overdraw = true;
		character_torso.position.y = (cam_y-45);
        var character_leg_1 = new THREE.Mesh(new THREE.CubeGeometry(14, 20, 15, 1, 1, 1, leg), new THREE.MeshFaceMaterial());
        character_leg_1.overdraw = true;
		character_leg_1.position.y = (cam_y-70);
		character_leg_1.position.x = (cam_x-7.5);
        var character_leg_2 = new THREE.Mesh(new THREE.CubeGeometry(14, 20, 15, 1, 1, 1, leg), new THREE.MeshFaceMaterial());
        character_leg_2.overdraw = true;
		character_leg_2.position.y = (cam_y-70);
		character_leg_2.position.x = (cam_x+7.5);
        var character_arm_1 = new THREE.Mesh(new THREE.CubeGeometry(14, 25, 15, 1, 1, 1, leg), new THREE.MeshFaceMaterial());
        character_arm_1.overdraw = true;
		character_arm_1.position.y = (cam_y-42.5);
		character_arm_1.position.x = (cam_x+21.8);
        var character_arm_2 = new THREE.Mesh(new THREE.CubeGeometry(14, 25, 15, 1, 1, 1, leg), new THREE.MeshFaceMaterial());
        character_arm_2.overdraw = true;
		character_arm_2.position.y = (cam_y-42.5);
		character_arm_2.position.x = (cam_x-21.8);
        var character_head = new THREE.Mesh(head_geom, new THREE.MeshFaceMaterial());
        character_head.overdraw = true;
		character_head.position.y = (cam_y-22);
		
		characterzz = new THREE.Object3D();//create an empty container
		characterzz.add( character_torso );//add a mesh with geometry to it
		characterzz.add( character_leg_1 );
		characterzz.add( character_leg_2 );
		characterzz.add( character_arm_1 );
		characterzz.add( character_arm_2 );
		characterzz.add( character_head );
		characterzz.position.y = 80;
		scene.add( characterzz );//when done, add the group to the scene
		
		//end of character
		
		// create a point light
		var pointLight = new THREE.PointLight( 0xFFFFFF );

		// set its position
		pointLight.position.x = char_x;
		pointLight.position.y = char_x+20;
		pointLight.position.z = char_z;

		// add to the scene
		scene.add(pointLight);
		
		
        var three = {
            renderer: renderer,
            camera: camera,
            scene: scene,
            cube: cube,
			cube2: cube2,
			cube3: cube3,
			cube4: cube4,
			cube5: cube5,
			cube6: cube6,
			cube7: cube7,
			character_leg_1: character_leg_1,
			character_leg_2: character_leg_2,
			character_arm_1: character_arm_1,
			character_arm_2: character_arm_2,
			character: characterzz,
			testblock: testblock
        };
 
        animate(lastTime, angularSpeed, three);
    };
</script><canvas width="1910" height="949"><div id="chat_boxbg"></div></canvas></body></html>