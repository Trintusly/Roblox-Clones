<?php
include 'func/avatarconnect.php';

$HeadColor = "$user->HeadColor";
$TorsoColor = "$user->TorsoColor";
$RightArmColor = "$user->RightArmColor";
$LeftArmColor = "$user->LeftArmColor";
$RightLegColor = "$user->RightLegColor";
$LeftLegColor = "$user->LeftLegColor";


if($user->Gear == "none") {
$importModel = '
import bpy
bpy.ops.wm.open_mainfile(filepath="/var/render/avatar.blend")
';
}else{
$importModel = '
import bpy
bpy.ops.wm.open_mainfile(filepath="/var/render/gearavatarright.blend")
';
}

if($user->Hat != "none") {
$importHat = '
hatpath = "/var/blender/models/hats/'.$user->Hat.'.obj"
import_hat = bpy.ops.import_scene.obj(filepath=hatpath)
hat = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat"
hatImg = bpy.data.images.load(filepath="/var/render/textures/hats/'.$user->Hat.'.png")
hatTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
hatTex.image = hatImg
hatMat = bpy.data.materials.new("MaterialName")
hatMat.diffuse_shader = "LAMBERT"
hatSlot = hatMat.texture_slots.add()
hatSlot.texture = hatTex
hat.active_material = hatMat
';
}else{
$importHat = '';
}

if($user->Gear != "none") {
$importGear = '
gearpath = "/var/blender/models/gear/'.$user->Gear.'.obj"
import_gear = bpy.ops.import_scene.obj(filepath=gearpath)
gear = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "gear"
gearImg = bpy.data.images.load(filepath="/var/render/textures/gear/'.$user->Gear.'.png")
gearTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
gearTex.image = gearImg
gearMat = bpy.data.materials.new("MaterialName")
gearMat.diffuse_shader = "LAMBERT"
gearSlot = gearMat.texture_slots.add()
gearSlot.texture = gearTex
gear.active_material = gearMat
';
}else{
$importGear = '';
}

if($user->Hat2 != "none") {
$importSecondHat = '
hat2path = "/var/render/models/hats/'.$user->Hat2.'.obj"
import_hat2 = bpy.ops.import_scene.obj(filepath=hat2path)
hat2 = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat2"
hat2Img = bpy.data.images.load(filepath="/var/render/textures/hats/'.$user->Hat2.'.png")
hat2Tex = bpy.data.textures.new("ColorTex", type = "IMAGE")
hat2Tex.image = hat2Img
hat2Mat = bpy.data.materials.new("MaterialName")
hat2Mat.diffuse_shader = "LAMBERT"
hat2Slot = hat2Mat.texture_slots.add()
hat2Slot.texture = hat2Tex
hat2.active_material = hat2Mat
';
}else{
$importSecondHat = '';
}

$addFace = '
HeadImg = bpy.data.images.load(filepath="/var/render/textures/faces/'.$user->Face.'.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

if($user->shirt != "none.png") {
$addMiddle = '
LeftArmImg = bpy.data.images.load(filepath="/var/www/html/storage/store_storage/shirts/'.$user->shirt.'")
LeftArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
LeftArmTex.image = LeftArmImg
LeftArmslot = bpy.data.objects["LeftArm"].active_material.texture_slots.add()
LeftArmslot.texture = LeftArmTex

RightArmImg = bpy.data.images.load(filepath="/var/www/html/storage/store_storage/shirts/'.$user->shirt.'")
RightArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
RightArmTex.image = RightArmImg
RightArmslot = bpy.data.objects["RightArm"].active_material.texture_slots.add()
RightArmslot.texture = RightArmTex


TorsoImg = bpy.data.images.load(filepath="/var/www/html/storage/store_storage/shirts/'.$user->shirt.'")
TorsoTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
TorsoTex.image = TorsoImg
Torsolot = bpy.data.objects["Torso"].active_material.texture_slots.add()
Torsolot.texture = TorsoTex
';
}else{
$addMiddle = '';
}


$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = ('.$TorsoColor.')

bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = ('.$HeadColor.')

bpy.data.objects["RightArm"].select = True
bpy.data.objects["RightArm"].active_material.diffuse_color = ('.$RightArmColor.')

bpy.data.objects["LeftArm"].select = True
bpy.data.objects["LeftArm"].active_material.diffuse_color = ('.$LeftArmColor.')

bpy.data.objects["LeftLeg"].select = True
bpy.data.objects["LeftLeg"].active_material.diffuse_color = ('.$LeftLegColor.')

bpy.data.objects["RightLeg"].select = True
bpy.data.objects["RightLeg"].active_material.diffuse_color = ('.$RightLegColor.')
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
bpy.data.scenes["Scene"].render.filepath = "/var/www/html/images/'.$user->id.'.png"
bpy.ops.render.render( write_still=True )
';


$python = "
$importModel
$importHat
$importGear
$importSecondHat
$addFace
$addMiddle
$Colors
$save
";

//echo "$python";

        $pyFileName = "/var/render/python/".$user->rand.".py";
        file_put_contents($pyFileName, $python);
        exec("blender --background --python /var/render/python/$user->rand.py");
$bigRand = rand(200000,20000000);
$smallRand = rand(1,10);
$conn->query("UPDATE `users` SET `rand`='".$smallRand."' WHERE `id`='".$user->id."'");
echo "".$user->id.".png?r=".$bigRand."";
?>