<?php

$http_origin = $_SERVER['HTTP_ORIGIN'];

//if ($http_origin == "http://www.bricked.nl" || $http_origin == "https://www.bricked.nl" || $http_origin == "http://bricked.nl")
//{
//    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
//}

$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$render = "enabled";

//echo $serverRoot;
include($serverRoot. '/db.php');

if($_GET['type'] == 'hat' && $_GET['id']){
echo '<h4>'.$serverRoot.'/storage/thumb/hats/'.$_GET['id'].'.png</h4>';

$importAvatar = '
import bpy
bpy.ops.wm.open_mainfile(filepath="'.$serverRoot.'/render/BPRAvatar.blend")
';

$importHat = '
hatpath = "'.$serverRoot.'/render/models/hats/'.$_GET['id'].'.obj"
import_hat = bpy.ops.import_scene.obj(filepath=hatpath)
hat = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat"
hatImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/hats/'.$_GET['id'].'.png")
hatTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
hatTex.image = hatImg
hatMat = bpy.data.materials.new("MaterialName")
hatMat.diffuse_shader = "LAMBERT"
hatSlot = hatMat.texture_slots.add()
hatSlot.texture = hatTex
hat.active_material = hatMat
';

$addFace = '
HeadImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/faces/1.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (134/255, 134/255, 134/255)';

$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 0/255, 0/255)

'.$headC.'

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)
';

$save = '
for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

obj = bpy.data.objects["Camera"]

pi = 3.14159

obj.location.x = -1.0
obj.location.y = -3.3
obj.location.z = 5.5
obj.rotation_mode = "XYZ"
obj.rotation_euler[0] = 90.0 * (pi / 180.0)

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/thumb/hats/'.$_GET['id'].'.png"
bpy.ops.render.render( write_still=True )
';

$removeParts = '
objs = bpy.data.objects
objs.remove(objs["LeftLeg"], True)
objs.remove(objs["RightLeg"], True)
';

$python = "
$importAvatar
$importHat
$addFace
$Colors
$removeParts
$save
";
echo $python;
$pyFileName = "".$serverRoot."/render/python/item.py";
file_put_contents($pyFileName, $python);
exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/item.py"));
}elseif($_GET['type'] == "face" && $_GET['id']){
    echo '<h4>'.$serverRoot.'/storage/thumb/faces/'.$_GET['id'].'.png</h4>';

$importAvatar = '
import bpy
bpy.ops.wm.open_mainfile(filepath="'.$serverRoot.'/render/BPRAvatar.blend")
';

$importHat = '';

$addFace = '
HeadImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/faces/'.$_GET["id"].'.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (134/255, 134/255, 134/255)';

$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 0/255, 0/255)

'.$headC.'

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)
';

$save = '
for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

obj = bpy.data.objects["Camera"]

pi = 3.14159

obj.location.x = -1.0
obj.location.y = -3.3
obj.location.z = 5.5
obj.rotation_mode = "XYZ"
obj.rotation_euler[0] = 90.0 * (pi / 180.0)

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/thumb/faces/'.$_GET['id'].'.png"
bpy.ops.render.render( write_still=True )
';

$removeParts = '
objs = bpy.data.objects
objs.remove(objs["LeftLeg"], True)
objs.remove(objs["RightLeg"], True)
';

$python = "
$importAvatar
$importHat
$addFace
$Colors
$removeParts
$save
";
echo $python;
$pyFileName = "".$serverRoot."/render/python/item.py";
file_put_contents($pyFileName, $python);
exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/item.py"));
}elseif($_GET['type'] == "shirt" && $_GET['id']){
        echo '<h4>'.$serverRoot.'/storage/thumb/shirts/'.$_GET['id'].'.png</h4>';

$importAvatar = '
import bpy
bpy.ops.wm.open_mainfile(filepath="'.$serverRoot.'/render/BPRAvatar.blend")
';

$importHat = '';

$addFace = '
HeadImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/faces/1.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (134/255, 134/255, 134/255)';

$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 0/255, 0/255)

'.$headC.'

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)
';

$addMiddle = '
LeftArmImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/shirts/'.$_GET['id'].'.png")
LeftArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
LeftArmTex.image = LeftArmImg
LeftArmslot = bpy.data.objects["LeftArm"].active_material.texture_slots.add()
LeftArmslot.texture = LeftArmTex

RightArmImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/shirts/'.$_GET['id'].'.png")
RightArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
RightArmTex.image = RightArmImg
RightArmslot = bpy.data.objects["RightArm"].active_material.texture_slots.add()
RightArmslot.texture = RightArmTex


TorsoImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/shirts/'.$_GET['id'].'.png")
TorsoTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
TorsoTex.image = TorsoImg
Torsolot = bpy.data.objects["Torso"].active_material.texture_slots.add()
Torsolot.texture = TorsoTex
';

$removeParts = '
objs = bpy.data.objects
objs.remove(objs["LeftLeg"], True)
objs.remove(objs["RightLeg"], True)
objs.remove(objs["Head"], True)
';

$save = '
for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

obj = bpy.data.objects["Camera"]

pi = 3.14159

obj.location.x = -1.0
obj.location.y = -3.7
obj.location.z = 4.1
obj.rotation_mode = "XYZ"
obj.rotation_euler[0] = 80.0 * (pi / 180.0)

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/thumb/shirts/'.$_GET['id'].'.png"
bpy.ops.render.render( write_still=True )
';

$python = "
$importAvatar
$importHat
$addFace
$Colors
$addMiddle
$removeParts
$save
";
echo $python;
$pyFileName = "".$serverRoot."/render/python/item.py";
file_put_contents($pyFileName, $python);
exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/item.py"));
}elseif($_GET['type'] == "pants" && $_GET['id']){
            echo '<h4>'.$serverRoot.'/storage/thumb/pants/'.$_GET['id'].'.png</h4>';

$importAvatar = '
import bpy
bpy.ops.wm.open_mainfile(filepath="'.$serverRoot.'/render/BPRAvatar.blend")
';

$importHat = '';

$addFace = '
HeadImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/faces/1.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (134/255, 134/255, 134/255)';

$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 0/255, 0/255)

'.$headC.'

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)
';

$addPants = '
LeftLegImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/pants/'.$_GET['id'].'.png")
LeftLegTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
LeftLegTex.image = LeftLegImg
LeftLegslot = bpy.data.objects["LeftLeg"].active_material.texture_slots.add()
LeftLegslot.texture = LeftLegTex

RightLegImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/pants/'.$_GET['id'].'.png")
RightLegTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
RightLegTex.image = RightLegImg
RightLegslot = bpy.data.objects["RightLeg"].active_material.texture_slots.add()
RightLegslot.texture = RightLegTex
';

$removeParts = '
objs = bpy.data.objects
objs.remove(objs["LeftArm"], True)
objs.remove(objs["RightArm"], True)
objs.remove(objs["Torso"], True)
objs.remove(objs["Head"], True)
';

$save = '
for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

obj = bpy.data.objects["Camera"]

pi = 3.14159

obj.location.x = -1.0
obj.location.y = -3.7
obj.location.z = 2.0
obj.rotation_mode = "XYZ"
obj.rotation_euler[0] = 80.0 * (pi / 180.0)

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/thumb/pants/'.$_GET['id'].'.png"
bpy.ops.render.render( write_still=True )
';

$python = "
$importAvatar
$importHat
$addFace
$Colors
$addPants
$removeParts
$save
";
echo $python;
$pyFileName = "".$serverRoot."/render/python/item.py";
file_put_contents($pyFileName, $python);
exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/item.py"));
}elseif($_GET['type'] == "gear" && $_GET['id']){
echo '<h4>'.$serverRoot.'/storage/thumb/gears/'.$_GET['id'].'.png</h4>';

$importAvatar = '
import bpy
bpy.ops.wm.open_mainfile(filepath="'.$serverRoot.'/render/BPRAvatar.blend")
';

$importHat = '';

$addFace = '
HeadImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/faces/1.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = (134/255, 134/255, 134/255)';

$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = (0/255, 0/255, 0/255)

'.$headC.'

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = (134/255, 134/255, 134/255)
';

$importGear = '
LeftArm = bpy.data.objects["LeftArm"]
LeftArm.rotation_euler = (-12.5,0,0)
LeftArm.location = (0,-0.7,4)
gearpath = "'.$serverRoot.'/render/models/gears/'.$_GET['id'].'.obj"
import_gear = bpy.ops.import_scene.obj(filepath=gearpath)
gear = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "gear"
gearImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/gears/'.$_GET['id'].'.png")
gearTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
gearTex.image = gearImg
gearMat = bpy.data.materials.new("MaterialName")
gearMat.diffuse_shader = "LAMBERT"
gearSlot = gearMat.texture_slots.add()
gearSlot.texture = gearTex
gear.active_material = gearMat
';

$removeParts = '
objs = bpy.data.objects
objs.remove(objs["LeftLeg"], True)
objs.remove(objs["RightLeg"], True)
objs.remove(objs["Head"], True)
objs.remove(objs["Torso"], True)
objs.remove(objs["RightArm"], True)
objs.remove(objs["LeftArm"], True)
';

$save = '
for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/thumb/gears/'.$_GET['id'].'.png"
bpy.ops.render.render( write_still=True )
';

$python = "
$importAvatar
$importHat
$addFace
$Colors
$importGear
$removeParts
$save
";
echo $python;
$pyFileName = "".$serverRoot."/render/python/item.py";
file_put_contents($pyFileName, $python);
exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/item.py"));
}
