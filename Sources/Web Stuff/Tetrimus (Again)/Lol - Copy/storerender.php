<?php
include 'func/connect.php';
if(!$loggedIn) {
	header("Location: /login");
}
?>

<?php 
$wear = trim($conn->real_escape_string($_POST['wear']));
$remove = trim($conn->real_escape_string($_POST['remove']));
$L = trim($conn->real_escape_string($_GET['l']));
//fix your vulns lose

//find the user to render
$id = $_GET['r'];

if(!id) {
	header("Location: storerender.php?r=1");
	die();
}


//fetch the json data of the character from the get request
$json_url = "http://159.89.87.156/api/item.php?id=$id&auth_key=71c184bbabb76b7e8b3719346b347f7d";
$json = file_get_contents($json_url);
$data = json_decode($json, TRUE);


//check to see if a gear is equipped 
$gearequipped = $data['data']['attributes']['Items']['GearEquip'];

//find all the colors
$HeadColor = explode(',',$data['data']['attributes']['HeadColor']);
$TorsoColor = explode(',',$data['data']['attributes']['TorsoColor']);
$LeftArmColor = explode(',',$data['data']['attributes']['LeftArmColor']);
$RightArmColor = explode(',',$data['data']['attributes']['RightArmColor']);
$LeftLegColor = explode(',',$data['data']['attributes']['LeftLegColor']);
$RightLegColor = explode(',',$data['data']['attributes']['RightLegColor']);

//find all the models
$Item = $data['data']['attributes']['Items']['Item'];
$Face = $data['data']['attributes']['Items']['Face'];
$Face = $data['data']['attributes']['Items']['Face'];
$Hat = $data['data']['attributes']['Items']['Hat'];
$Hat2 = $data['data']['attributes']['Items']['Hat2'];
//$Hat3 = $data['data']['attributes']['Items']['Hat3']; Noynac dad do this.
$tshirt = $data['data']['attributes']['Items']['tshirt'];
$shirt = $data['data']['attributes']['Items']['shirt'];
$Gear = $data['data']['attributes']['Items']['Gear'];
$Gear2 = $data['data']['attributes']['Items']['Gear2'];

//time to start rendering stuff ill just skip over this for now
class noynac {
	
	private function paran ($string) {
		return str_replace("\\", "\\\\", $string);
	}
	
	private function loadMainBlend( &$python, $filePath ) {
		$filePath = $this->paran($filePath);
		$python .= "
bpy.ops.wm.open_mainfile(filepath=\"{$filePath}\")";
	}
	
	private function loadObj( &$python, $name, $filePath ) {
		$filePath = $this->paran($filePath);
		$python .= "
{$name}path = '{$filePath}'
import_{$name} = bpy.ops.import_scene.obj(filepath={$name}path)
{$name} = bpy.context.selected_objects[0]
bpy.context.selected_objects[0].data.name = '{$name}'";
	}
	
	private function imageMat ( &$python, $name, $texturePath, $makeMat = true ) {
		$filePath = $this->paran($texturePath);
		if ($makeMat) {
		$python .= "
{$name}Img = bpy.data.images.load(filepath='{$texturePath}')
{$name}Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
{$name}Tex.image = {$name}Img
{$name}Mat = bpy.data.materials.new('MaterialName')
{$name}Mat.diffuse_shader = 'LAMBERT'
{$name}Slot = {$name}Mat.texture_slots.add()
{$name}Slot.texture = {$name}Tex
{$name}.active_material = {$name}Mat";
		} else {
		$python .= "
{$name}Img = bpy.data.images.load(filepath='{$texturePath}')
{$name}Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
{$name}Tex.image = {$name}Img
{$name}slot = bpy.data.objects['{$name}'].active_material.texture_slots.add()
{$name}slot.texture = {$name}Tex
";
		}
	}
	
	private function colorMat ( &$python, $name, array $rgb, $makeMat = true ) {
		
		$color = "(";
		$arrayCount = count($rgb);
		
		if ($arrayCount !== 3) {
			return false;
		}
		
		$counter = 0;
		 
		foreach ($rgb as $val) {
			$counter++;
			if ($counter == 3) {
				$color .= $val . ")";
			} else {
				$color .= $val . ",";
			}
		}
		
		if ($makeMat) {
			$python .= "
{$name}Mat = bpy.data.materials.new(name='MaterialName')
{$name}Mat.diffuse_shader = 'LAMBERT'
{$name}.data.materials.append({$name}Mat)
{$name}.active_material.diffuse_color = {$color}";
		} else {
			$python .= "
bpy.data.objects['{$name}'].select = True
bpy.data.objects['{$name}'].active_material.diffuse_color = {$color}";
		}
		
		

	}
	
	private function save( &$python, $fileName ) {
		$python .= "

for ob in bpy.context.scene.objects:
	if ob.type == 'MESH':
		ob.select = True
		bpy.context.scene.objects.active = ob
	else:
		ob.select = False
bpy.ops.object.join()

bpy.ops.view3d.camera_to_view_selected()

origAlphaMode = bpy.data.scenes['Scene'].render.alpha_mode
bpy.data.scenes['Scene'].render.alpha_mode = 'TRANSPARENT'
bpy.data.scenes['Scene'].render.alpha_mode = origAlphaMode
bpy.data.scenes['Scene'].render.filepath = '".$fileName.".png'
bpy.ops.render.render( write_still=True )";
		
	}
	
	private function run ($python, $fileName, $pyFileName) {
		file_put_contents($pyFileName, $python);
		exec("blender --background --python /var/render/renderitem.py");
	}
	
	private function changeColor($python, $name, $color) {
		
	}
	
	public function renderAvatar( array $colors = [], array $objNames = []) { //UNDEFINED INDEX.
		$id = $_GET['r'];
		$fileNameo = "$id";
		$fileName = "/var/www/html/images/s" . $id;
		$pyFileName = "/var/render/renderitem.py";
		
		$python = "import bpy";


$jsonn_url = "http://159.89.87.156/api/item.php?id=$id&auth_key=71c184bbabb76b7e8b3719346b347f7d";
$jsonn = file_get_contents($jsonn_url);
$dataa = json_decode($jsonn, TRUE);

$itemType = $dataa['data']['attributes']['Items']['Type'];

		if($itemType == "Gear"){
			$this->loadMainBlend($python, "/var/render/gearavatarright.blend");
		}else{
			$this->loadMainBlend($python, "/var/render/avatar.blend");
		}

		//Hats
		
		foreach ($objNames as $objName => $obj) {
			foreach ($obj as $objPath => $tex) {
				
				if (is_array($tex)) {
					$this->loadObj($python, $objName, $objPath);
					$this->colorMat($python, $objName, $tex);
				} else {
					$this->loadObj($python, $objName, $objPath);
					$this->imageMat($python, $objName, $tex);
				}
				
			}
		}
		
		foreach ($colors as $objectName => $color) {
				if (is_array($color)) {
					$this->colorMat($python, $objectName, $color, false);
				} else {
					$this->imageMat($python, $objectName, $color, false);
				}
		}
		
		$this->save($python, $fileName);
		$this->run($python, $fileName, $pyFileName);
		
		return $fileNameo;
		
	}
	
}


$noynac = new noynac;


//now we define the stuff to put on the avatar or whatever

$rand= rand(0,10000);

/*
if (is_file("images/{$id}.png")) {
unlink("images/{$id}.png");
}
*/
if($tshirt == "none.png"){
	$tShirtModel = "none";
}else{
	$tShirtModel = "tshirt";
}

if($shirt == "none.png"){
$avatar = $noynac->renderAvatar([
    "Head" => $HeadColor,
    "LeftArm" => $LeftArmColor,
    "RightArm" => $RightArmColor,
    "LeftLeg" => $LeftLegColor,
    "RightLeg" => $RightLegColor,
    "Torso" => $TorsoColor,
    ],[
    "gear" => ["/var/render/models/".$Gear.".obj" => "/var/render/textures/".$Gear.".png"],
    "gear2" => ["/var/render/models/second".$Gear2.".obj" => "/var/render/textures/".$Gear2.".png"],
    "hat" => ["/var/render/models/".$Hat.".obj" => "/var/render/textures/".$Hat.".png"],
    "hat2" => ["/var/render/models/".$Hat2.".obj" => "/var/render/textures/".$Hat2.".png"],
    "tshirt" => ["/var/render/models/".$tShirtModel.".obj" => "/var/render/textures/".$tshirt.""],
    "face" => ["/var/render/models/".$Face.".obj" => "/var/render/textures/".$Face.".png"],
    "face" => ["/var/render/models/".$Item.".obj" => "/var/render/textures/".$Item.".png"]

]);
}else{
$avatar = $noynac->renderAvatar([
    "Head" => $HeadColor,
    "LeftArm" => $LeftArmColor,
    "RightArm" => $RightArmColor,
    "LeftLeg" => $LeftLegColor,
    "RightLeg" => $RightLegColor,
    "Torso" => "/var/render/textures/".$shirt."",
    ],[
    "gear" => ["/var/render/models/".$Gear.".obj" => "/var/render/textures/".$Gear.".png"],
    "gear2" => ["/var/render/models/second".$Gear2.".obj" => "/var/render/textures/".$Gear2.".png"],
    "hat" => ["/var/render/models/".$Hat.".obj" => "/var/render/textures/".$Hat.".png"],
    "hat2" => ["/var/render/models/".$Hat2.".obj" => "/var/render/textures/".$Hat2.".png"],
	//"hat3" => ["/var/render/models/".$Hat3.".obj" => "/var/render/textures/".$Hat3.".png"], Noynac dad do this
    "tshirt" => ["/var/render/models/".$tShirtModel.".obj" => "/var/render/textures/".$tshirt.""],
    "face" => ["/var/render/models/".$Face.".obj" => "/var/render/textures/".$Face.".png"]

]);
}
$rand = rand(0,10000);
echo "<img src='../images/s".$id.".png?r=".$rand."'>";
?>