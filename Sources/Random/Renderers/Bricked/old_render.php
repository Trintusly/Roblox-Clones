<?php

die(); // Just remove this to revert

$serverRoot = $_SERVER['DOCUMENT_ROOT'];
$render = "enabled";

//echo $serverRoot;
include($serverRoot. '/html/header.php');

if(!$loggedIn){
        die("Not logged in!");
}

    // rate limit

// end rate limit

echo '<h4>'.$serverRoot.'/storage/avatars/'.$user->id.'.png</h4>';

if($_GET['BP'] && $_GET['C']){
    $Part = $_GET['BP'];
    $Color = $_GET['C'];
    function h2r($Color) {
        if(strlen($Color) == 3) {
            $r = hexdec(substr($Color,0,1).substr($Color,0,1));
            $g = hexdec(substr($Color,1,1).substr($Color,1,1));
            $b = hexdec(substr($Color,2,1).substr($Color,2,1));
        } else {
            $r = hexdec(substr($Color,0,2));
            $g = hexdec(substr($Color,2,2));
            $b = hexdec(substr($Color,4,2));
        }
        $rgb = $r.",".$g.",".$b;
        return $rgb;
    }
    $Color = h2r($Color);
    if($Part == "head"){
        $Part = $Part."Color";
        $UAdstmt = $db->prepare("UPDATE `avatar` SET " . $Part . " = '" . $Color . "' WHERE `userID` = :uid");
        $UAdstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
        $UAdstmt->execute();
    }
    if($Part == "torso"){
        $Part = $Part."Color";
        $UAdstmt = $db->prepare("UPDATE `avatar` SET " . $Part . " = '" . $Color . "' WHERE `userID` = :uid");
        $UAdstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
        $UAdstmt->execute();
    }
    if($Part == "rightArm"){
        $Part = $Part."Color";
        $UAdstmt = $db->prepare("UPDATE `avatar` SET " . $Part . " = '" . $Color . "' WHERE `userID` = :uid");
        $UAdstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
        $UAdstmt->execute();
    }
    if($Part == "rightLeg"){
        $Part = $Part."Color";
        $UAdstmt = $db->prepare("UPDATE `avatar` SET " . $Part . " = '" . $Color . "' WHERE `userID` = :uid");
        $UAdstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
        $UAdstmt->execute();
    }
    if($Part == "leftLeg"){
        $Part = $Part."Color";
        $UAdstmt = $db->prepare("UPDATE `avatar` SET " . $Part . " = '" . $Color . "' WHERE `userID` = :uid");
        $UAdstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
        $UAdstmt->execute();
    }
    if($Part == "leftArm"){
        $Part = $Part."Color";
        $UAdstmt = $db->prepare("UPDATE `avatar` SET " . $Part . " = '" . $Color . "' WHERE `userID` = :uid");
        $UAdstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
        $UAdstmt->execute();
    }
}

$GUAstmt = $db->prepare("SELECT * FROM `avatar` WHERE `userID` = :uid LIMIT 1");
$GUAstmt->bindParam(":uid", $_SESSION['id'], PDO::PARAM_STR);
$GUAstmt->execute();
if($GUAstmt->rowCount() > 0){
    $UA = $GUAstmt->fetch();
}

$HeadColors = explode(',', $UA['headColor']);
$HeadColor = $HeadColors[0] . '/255, ' . $HeadColors[1] . '/255, ' . $HeadColors[2] . '/255';

$TorsoColors = explode(',', $UA['torsoColor']);
$TorsoColor = $TorsoColors[0] . '/255, ' . $TorsoColors[1] . '/255, ' . $TorsoColors[2] . '/255';

$RAColors = explode(',', $UA['rightArmColor']);
$RightArmColor = $RAColors[0] . '/255, ' . $RAColors[1] . '/255, ' . $RAColors[2] . '/255';

$LAColors = explode(',', $UA['leftArmColor']);
$LeftArmColor = $LAColors[0] . '/255, ' . $LAColors[1] . '/255, ' . $LAColors[2] . '/255';

$RLColors = explode(',', $UA['rightLegColor']);
$RightLegColor = $RLColors[0] . '/255, ' . $RLColors[1] . '/255, ' . $RLColors[2] . '/255';

$LLColors = explode(',', $UA['leftLegColor']);
$LeftLegColor = $LLColors[0] . '/255, ' . $LLColors[1] . '/255, ' . $LLColors[2] . '/255';


$importAvatar = '
import bpy
bpy.ops.wm.open_mainfile(filepath="'.$serverRoot.'/render/BPRAvatar.blend")
';
//BPRAvatar.blend - bricky avatar
//avatar.blend - blocky avatar


if($UA['hat1ID'] != NULL) {

$importHat = '
hatpath = "'.$serverRoot.'/render/models/hats/'.$UA['hat1ID'].'.obj"
import_hat = bpy.ops.import_scene.obj(filepath=hatpath)
hat = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat"
hatImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/hats/'.$UA['hat1ID'].'.png")
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

if($UA['gearID'] != NULL) {
$importGear = '
LeftArm = bpy.data.objects["LeftArm"]
LeftArm.rotation_euler = (-12.5,0,0)
LeftArm.location = (0,-0.7,4)
gearpath = "'.$serverRoot.'/render/models/gears/'.$UA['gearID'].'.obj"
import_gear = bpy.ops.import_scene.obj(filepath=gearpath)
gear = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "gear"
gearImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/gears/'.$UA['gearID'].'.png")
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

if($UA['hat3ID'] != NULL) {
$importThirdHat = '
hat3path = "'.$serverRoot.'/render/models/hats/'.$UA['hat3ID'].'.obj"
import_hat3 = bpy.ops.import_scene.obj(filepath=hat3path)
hat3 = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat3"
hat3Img = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/hats/'.$UA['hat3ID'].'.png")
hat3Tex = bpy.data.textures.new("ColorTex", type = "IMAGE")
hat3Tex.image = hat3Img
hat3Mat = bpy.data.materials.new("MaterialName")
hat3Mat.diffuse_shader = "LAMBERT"
hat3Slot = hat3Mat.texture_slots.add()
hat3Slot.texture = hat3Tex
hat3.active_material = hat3Mat
';
}else{
$importThirdHat = '';
}

if($UA['hat2ID'] != NULL) {
$importSecondHat = '
hat2path = "'.$serverRoot.'/render/models/hats/'.$UA['hat2ID'].'.obj"
import_hat2 = bpy.ops.import_scene.obj(filepath=hat2path)
hat2 = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = "hat2"
hat2Img = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/hats/'.$UA['hat2ID'].'.png")
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

if($UA['faceID'] != NULL) {
$face = $UA['faceID'];
}else{
$face = "1";
}

$addFace = '
HeadImg = bpy.data.images.load(filepath="'.$serverRoot.'/render/textures/faces/'.$face.'.png")
HeadTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
HeadTex.image = HeadImg
Headslot = bpy.data.objects["Head"].active_material.texture_slots.add()
Headslot.texture = HeadTex
';

if($UA['shirtID'] != NULL) {
$addMiddle = '
LeftArmImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/shirts/'.$UA['shirtID'].'.png")
LeftArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
LeftArmTex.image = LeftArmImg
LeftArmslot = bpy.data.objects["LeftArm"].active_material.texture_slots.add()
LeftArmslot.texture = LeftArmTex

RightArmImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/shirts/'.$UA['shirtID'].'.png")
RightArmTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
RightArmTex.image = RightArmImg
RightArmslot = bpy.data.objects["RightArm"].active_material.texture_slots.add()
RightArmslot.texture = RightArmTex


TorsoImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/shirts/'.$UA['shirtID'].'.png")
TorsoTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
TorsoTex.image = TorsoImg
Torsolot = bpy.data.objects["Torso"].active_material.texture_slots.add()
Torsolot.texture = TorsoTex
';
}else{
        $addMiddle = '';
}

//$addMiddle = '';


if($UA['pantsID'] != NULL) {


$addPants = '
LeftLegImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/pants/'.$UA['pantsID'].'.png")
LeftLegTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
LeftLegTex.image = LeftLegImg
LeftLegslot = bpy.data.objects["LeftLeg"].active_material.texture_slots.add()
LeftLegslot.texture = LeftLegTex

RightLegImg = bpy.data.images.load(filepath="'.$serverRoot.'/storage/pants/'.$UA['pantsID'].'.png")
RightLegTex = bpy.data.textures.new("ColorTex", type = "IMAGE")
RightLegTex.image = RightLegImg
RightLegslot = bpy.data.objects["RightLeg"].active_material.texture_slots.add()
RightLegslot.texture = RightLegTex
';
}else{
        $addPants = '';
}

/*
if($user->headID == "0"){
$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = ('.$HeadColor.')';
}else{
$headC = '';
}
*/

$headC ='
bpy.data.objects["Head"].select = True
bpy.data.objects["Head"].active_material.diffuse_color = ('.$HeadColor.')';

$Colors = '
bpy.data.objects["Torso"].select = True
bpy.data.objects["Torso"].active_material.diffuse_color = ('.$TorsoColor.')

'.$headC.'

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
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/avatars/'.$user->id.'.png"
bpy.ops.render.render( write_still=True )
';

$savethumb = '
for ob in bpy.context.scene.objects:
    if ob.type == "MESH":
        ob.select = True
        bpy.context.scene.objects.active = ob
    else:
        ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

obj = bpy.data.objects["Camera"]
obj.location.x = -1.1
obj.location.y = -4.2
obj.location.z = 6.0

origAlphaMode = bpy.data.scenes["Scene"].render.alpha_mode
bpy.data.scenes["Scene"].render.alpha_mode = "TRANSPARENT"
bpy.data.scenes["Scene"].render.alpha_mode = origAlphaMode
bpy.data.scenes["Scene"].render.filepath = "'.$serverRoot.'/storage/avatars/thumb/'.$user->id.'.png"
bpy.ops.render.render( write_still=True )
';


$python = "
$importAvatar
$importHat
$importSecondHat
$importGear
$importThirdHat
$addFace
$addMiddle
$addPants
$Colors
$save
";

$pythonthumb = "
$importAvatar
$importHat
$importSecondHat
$importGear
$importThirdHat
$addFace
$addMiddle
$addPants
$Colors
$savethumb
";

echo"<h2>Rendered avatar!</h2>";
if($user->power >=4){
?>
<h2>Displaying admin render code(Normal)</h2>
<?php
echo "$python";
echo "<h2>Displaying admin render code(Thumbnail)</h2>";
echo "$pythonthumb";
}
//echo "successfully rendered";

    //Basic render
        $pyFileName = "".$serverRoot."/render/python/1.py";
        file_put_contents($pyFileName, $python);
        exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/1.py -noaudio"));
    //Thumbnail render
        $pyFileNamet = "".$serverRoot."/render/python/1_thumb.py";
        file_put_contents($pyFileNamet, $pythonthumb);
        exec(escapeshellcmd("blender --background --python ".$_SERVER['DOCUMENT_ROOT']."/render/python/1_thumb.py -noaudio"));

include('../html/footer.php');
?>