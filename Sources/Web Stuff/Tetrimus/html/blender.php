<?php 
class blender {
	
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
	
	private function imageMat ( &$python, $name, $texturePath ) {
		$filePath = $this->paran($texturePath);
		$python .= "
{$name}Img = bpy.data.images.load(filepath='{$texturePath}')
{$name}Tex = bpy.data.textures.new('ColorTex', type = 'IMAGE')
{$name}Tex.image = {$name}Img
{$name}Mat = bpy.data.materials.new('MaterialName')
{$name}Mat.diffuse_shader = 'LAMBERT'
{$name}Slot = {$name}Mat.texture_slots.add()
{$name}Slot.texture = {$name}Tex
{$name}.active_material = {$name}Mat";
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
	
	private function run ($python, $fileName) {
		file_put_contents($fileName, $python);
		exec("blender --background --python " . $fileName);
	}
	
	private function changeTexture(&$python, $textureName, $path) {
		$python .= "
".$textureName."TextureChange = bpy.data.images.load(filepath = '$path')
bpy.data.textures['$textureName'].image = ".$textureName."TextureChange";
	}
	
	public function renderAvatar( array $colors = [], array $objNames = [], array $misc = [], array $clothing = [], array $face = []) {
		
		if (isset($misc["filename"])) {
			$fileName = $misc["filename"];
		} else {
			$hecc = rand(0,100);
			$fileName = "/assets/avatar/" . "image_" . $hecc;
		}
		$python = "import bpy";
		$this->loadMainBlend($python, "var/www/html/blender/vertineer_test2.blend");
		//Clothing
		
		if($clothing['pants'] == false){
			$this->changeTexture($python, "LeftLegTexture", "/blender/middle.png");
			$this->changeTexture($python, "RightLegTexture", "var/www/html/blender/middle.png");
		} else {
			$this->changeTexture($python, "LeftLegTexture", "/assets/hats/storage/".$clothing["LeftLegTexture"].".png");
			$this->changeTexture($python, "RightLegTexture", "/assets/hats/storage/".$clothing["RightLegTexture"].".png");
		}
		if($clothing['shirts'] == false){
			$this->changeTexture($python, "LeftArmTexture", "var/www/html/blender/middle.png");
			$this->changeTexture($python, "RightArmTexture", "var/www/html/blender/middle.png");
			$this->changeTexture($python, "TorsoTexture", "var/www/html/blender/middle.png");
		} else {
			$this->changeTexture($python, "LeftArmTexture", "/assets/hats/storage/".$clothing["LeftArmTexture"].".png");
			$this->changeTexture($python, "RightArmTexture", "/assets/hats/storage/".$clothing["RightArmTexture"].".png");
			$this->changeTexture($python, "TorsoTexture", "/assets/hats/storage/".$clothing["TorsoTexture"].".png");
		}
		if($face['id'] == "0"){
			$this->changeTexture($python, "Face", "/assets/hats/storage/default_face.png");
		} else {
			$this->changeTexture($python, "Face", "/assets/hats/storage/".$face['id'].".png");
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
			
			foreach ($color as &$potatoColor) {
				$potatoColor = (int)$potatoColor / 255;
			}

			$this->colorMat($python, $objectName, $color, false);
		}
		
		$this->save($python, $fileName);
		
		$run = $this->run($python, $fileName.".py");
		if ($run) {}
		echo $fileName.".py \n";

		return $python;
		
	}
	
	public function renderAvatarID( $userId , $connection = null) {
		if (!$connection) {
			include("../site/connection.php");
			$connection = $con;
		}
		
		$query = $connection->prepare("SELECT * FROM avatar WHERE user_id = ?");
		$query->bind_param("s", $userId);
		$query->execute();
		$result = $query->get_result();
		
		if ($result) {
			if ($result->num_rows > 0) {
				
				$avatar = $result->fetch_assoc();
				$id = $avatar['user_id'];
				
				$colors = [
					"headColor",
					"torsoColor",
					"rightArmColor",
					"leftArmColor",
					"rightLegColor",
					"leftLegColor"
				];
				
				foreach ($colors as $color) {
					$avatar[$color] = explode('.', $avatar[$color]);
				}
				
				$hatArray = [];
				$hats = ["hat1", "hat2", "hat3", "hat4"];
				foreach ($hats as $hat) {
					if ($avatar[$hat] > 0) {
						$hatValue = $avatar[$hat];
						$hatArray[$hat] = ["/assets/hats/storage/" . $hatValue . ".obj" =>  "/assets/hats/storage/" . $hatValue . ".png"];
					}
				}
				if($avatar['pant'] != "0"){
					$check_pant = true;
				} else {
					$check_pant = false;
				}
				if($avatar['shirt'] != "0"){
					$check_shirt = true;
				} else {
					$check_shirt = false;
				}
				$render = $this->renderAvatar(["Head" => $avatar["headColor"], "Torso" => $avatar["torsoColor"], "RightArm" => $avatar["rightArmColor"], "LeftArm" => $avatar["leftArmColor"], "LeftLeg" => $avatar["leftLegColor"], "RightLeg" => $avatar["rightLegColor"]],
										$hatArray,["filename" => "/assets/users/" . $id], ["LeftArmTexture" => $avatar['shirt'], "RightArmTexture" => $avatar['shirt'], "TorsoTexture" => $avatar['shirt'], "LeftLegTexture" => $avatar['pant'], "RightLegTexture" => $avatar['pant'], "pants" => $check_pant, "shirts" => $check_shirt], ["id" => $avatar['face']]);
				
			}
		} else {
			return false;
		}
	}
	
	public function renderHat ($objPath, $texturePath, $saveImagePath)
	{
		
		$python = "import bpy
";
		$this->loadMainBlend($python, "var/www/html/blender/hat.blend");
		$this->loadObj($python, preg_replace('/[0-9]+/', '', md5($objPath)), $objPath);
		$this->changeTexture($python, "Face", "/assets/coolface.png");
		$this->imageMat($python, preg_replace('/[0-9]+/', '', md5($objPath)), $texturePath);
		$this->save($python, $saveImagePath);
		$this->run($python, $saveImagePath . ".py");
		
		return $python;
		return "op";
		
	}
	public function renderShirt ($id)
	{
		include '../site/connection.php';
		$getShop = $con->prepare("SELECT * FROM shop WHERE id=?");
		$getShop->bind_param("i", $id);
		$getShop->execute();
		$shop = $getShop->get_result()->fetch_assoc();
		if($shop['type'] != "shirt"){
			die("???");
		}
		$python = "import bpy
";
		$this->loadMainBlend($python, "var/www/html/blender/shirt_preview.blend");
		$this->changeTexture($python, "LeftArmTexture", "/assets/hats/storage/".$id.".png");
		$this->changeTexture($python, "RightArmTexture", "/assets/hats/storage/".$id.".png");
		$this->changeTexture($python, "TorsoTexture", "/assets/hats/storage/".$id.".png");
		$this->save($python, "../shop/images/".$id);
		$this->run($python, "../shop/images/" . $id . ".py");
	}
	public function renderPants ($id)
	{
		include '../site/connection.php';
		$getShop = $con->prepare("SELECT * FROM shop WHERE id=?");
		$getShop->bind_param("i", $id);
		$getShop->execute();
		$shop = $getShop->get_result()->fetch_assoc();
		if($shop['type'] != "pant"){
			die("???");
		}
		$python = "import bpy
";
		$this->loadMainBlend($python, "var/www/html/blender/pant_preview.blend");
		$this->changeTexture($python, "LeftLegTexture", "/assets/hats/storage/".$id.".png");
		$this->changeTexture($python, "RightLegTexture", "/assets/hats/storage/".$id.".png");
		$this->save($python, "../shop/images/".$id);
		$this->run($python, "../shop/images/" . $id . ".py");
	}
	public function renderFace ($id)
	{
		include '../site/connection.php';
		$getShop = $con->prepare("SELECT * FROM shop WHERE id=?");
		$getShop->bind_param("i", $id);
		$getShop->execute();
		$shop = $getShop->get_result()->fetch_assoc();
		if($shop['type'] != "face"){
			die("???");
		}
		$python = "import bpy
";
		$this->loadMainBlend($python, "var/www/html/blender/face_preview.blend");
		$this->changeTexture($python, "Face", "/assets/hats/storage/".$id.".png");
		$this->save($python, "../shop/images/".$id);
		$this->run($python, "../shop/images/" . $id . ".py");
	}
}