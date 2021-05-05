<?php
/*
DO NOT LISTEN TO ISAIAH THIS IS SIMPLES'S RENDERER 100% MADE BY HIM PLEASE NO LEAK

isaiah's trademarked method!!!!!!!!!!!!!
*/
$session = false;
require("/var/www/html/site/bopimo.php");
class blender extends bopimo {

	public function rndStr ( int $length ) { //i got this online do not make fun of me
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public $py = "import bpy
import struct
from bpy import context
from mathutils import Euler
import math
def hex_to_rgb(value):
    gamma = 2.05
    value = value.lstrip('#')
    lv = len(value)
    fin = list(int(value[i:i + lv // 3], 16) for i in range(0, lv, lv // 3))
    r = pow(fin[0] / 255, gamma)
    g = pow(fin[1] / 255, gamma)
    b = pow(fin[2] / 255, gamma)
    fin.clear()
    fin.append(r)
    fin.append(g)
    fin.append(b)
    return tuple(fin)
";

	public function newLine ( string $code ) // Creates new line
	{

		$this->py .= "\r\n" . $code;

		return true;
	}

	public function curPY () // Returns Python Code
	{
		return $this->py;
	}

	public function paran ( string $string ) //idk just makes thing look cooler
	{
		return str_replace("\\", "\\\\", $string);
	}


	public function mainBlend ( string $file_path ) //import blender file
	{
		$this->newLine( "bpy.ops.wm.open_mainfile(filepath='{$file_path}')" );

		return true;
	}

	public function obj (string $model, string $texture, string $name)
	{
		$this->newLine("bpy.ops.import_scene.obj(filepath='{$model}')");
		$this->newLine("{$name} = bpy.context.selected_objects[0]");
		$this->newLine("bpy.context.selected_objects[0].name = '{$name}'");
		$this->createMatTex($texture, $name);
	}

	public function focus( $object = "all" ) {
		$this->newLine("for obj in bpy.data.objects:
    obj.select = False");
		if ($object == "all") {
			$this->newLine( "bpy.ops.object.select_all(action='SELECT')" );
		} else if (is_array($object)) {
			foreach ($object as $objName) {
				$this->newLine("bpy.data.objects['".$objName."'].select = True");
			}
		} else {
			$this->newLine("bpy.data.objects['".$object."'].select = True");
		}
		$this->newLine( "bpy.ops.view3d.camera_to_view_selected()" );
	}

	public function export ( string $file_name, int $size = 0, string $file_path, string $full_file_path ) //finish do stuff like imagee
	{

		$full_path = $full_file_path . $file_name . ".png";

		if ($size > 0) {
			$this->newLine("scene = bpy.data.scenes['Scene']");
			$this->newLine("scene.render.resolution_x = {$size}");
			$this->newLine("scene.render.resolution_y = {$size}");
			$this->newLine("scene.render.resolution_percentage = 100");
		}

		$this->newLine( '#Render Section' );
		$this->newLine( "bpy.data.scenes['Scene'].render.filepath = '{$full_path}'" ); // Create image, size.
		$this->newLine( "bpy.ops.render.render( write_still=True )" ); //render
		$this->newLine( "#file rendered: {$file_name}.png" );
		$this->newLine( "#CREATED: {$full_file_path}{$file_name}.py" );

		file_put_contents( $full_file_path . $file_name . ".py", $this->curPY() );
		exec( "blender --background --python " . $full_file_path . $file_name . ".py" );
		//unlink( "{$full_file_path}{$file_name}.py" );

		return $file_name;

	}

	public function changeMat ( string $obj_name, string $color ) // change material of object
	{
		$this->newLine( "bpy.data.objects['{$obj_name}'].select = True" );
		$this->newLine( "bpy.data.objects['{$obj_name}'].active_material.diffuse_color = hex_to_rgb('{$color}')" );
	}

	// object name
	public function createMatTex ( string $image, string $name )
	{
		$this->newLine("{$name}.data.materials.clear()");
		$this->newLine( "{$name}_Mat = bpy.data.materials.new(name='{$name}_Mat')" );
		$this->newLine( "{$name}_Tex = bpy.data.textures.new(name='{$name}_Tex',type='IMAGE')" );
		$this->applyTexture( $name . "_Tex", $image );
		$this->newLine( "{$name}_Slot = {$name}_Mat.texture_slots.add()" );
		$this->newLine( "{$name}_Slot.texture = {$name}_Tex" );
		$this->newLine("{$name}.data.materials.append({$name}_Mat)");
	}

	public function applyTexture ( string $name, string $file) //change texture by texture name
	{
		$this->newLine( "{$name}_Image = bpy.data.images.load(filepath = '{$file}')" ); //Face_Image is set
		$this->newLine( "bpy.data.textures['{$name}'].image = {$name}_Image" );

		return true;
	}

	public function comment ( string $comment ) // just lil simple thing adds comments to code
	{
		$this->newLine( "#{$comment}" );
		return true;
	}

	public function remove ($objectName) {
		$this->newLine("bpy.ops.object.select_all(action='DESELECT')");
		$this->newLine("bpy.data.objects['".$objectName."'].select = True");
		$this->newLine("bpy.ops.object.delete()");
	}

	public function position ($objectName, array $points) {
		$axis = ['x', 'y', 'z'];
		foreach ($points as $point => $location) {
			if (in_array($point, $axis)) {
				$this->newLine("bpy.data.objects['".$objectName."'].location." . $point . " = ". $location);
			}

		}
		return true;
	}

	public function rotate ($objectName, array $rotation) {
		if (count($rotation) == 3) {
			$this->newLine($objectName ."CONTEXT = bpy.data.objects['".$objectName."']");
			$this->newLine($objectName."CONTEXT.rotation_euler = Euler((math.radians(".$rotation[0]."),math.radians(".$rotation[1]."),math.radians(".$rotation[2].")), 'XYZ')");
			return true;
		}
		return false;
	}

	public function renderAvatar ( int $id ) // renders avatar dynamically with $id as user id
	{
		$uniq = $this->rndStr(25); //randomize very much

		/*
		HEADER
		*/
		$this->comment( "BOPIMO PYTHON RENDERER 2018" ); //main comment
		$this->mainBlend( "/var/www/html/render-testing/avatar.blend" ); // load main .blend

		/*
		AVATAR COLORS
		*/
		$avatar = $this->look_for ("avatar", ["user_id" => $id]);
		//var_dump($avatar);
		$this->comment( "MATERIALS" ); //label material section
		$this->changeMat( "Head", $avatar->head_color );
		$this->changeMat( "Torso", $avatar->torso_color );
		$this->changeMat( "LeftArm", $avatar->left_arm_color );
		$this->changeMat( "RightArm", $avatar->right_arm_color );
		$this->changeMat( "LeftLeg", $avatar->left_leg_color );
		$this->changeMat( "RightLeg", $avatar->right_leg_color );



		$this->comment("test");

		if( $avatar->hat1 !== "0" )
		{
			$item = (object) $this->getItem($avatar->hat1);
			$location = "/var/www/storage/assets/" . $this->cat2dir($item->category) . "/{$avatar->hat1}";
			$this->obj($location . ".obj", $location . ".png", "hat1");
		}

		if( $avatar->hat2 !== "0" )
		{
			$item = (object) $this->getItem($avatar->hat2);
			$location = "/var/www/storage/assets/" . $this->cat2dir($item->category) . "/{$avatar->hat2}";
			$this->obj($location . ".obj", $location . ".png", "hat2");
		}

		if( $avatar->hat3 !== "0" )
		{
			$item = (object) $this->getItem($avatar->hat3);
			$location = "/var/www/storage/assets/" . $this->cat2dir($item->category) . "/{$avatar->hat3}";
			$this->obj($location . ".obj", $location . ".png", "hat3");
		}

		if ($avatar->tool !== "0") {
			$item = (object) $this->getItem($avatar->tool);
			$location = "/var/www/storage/assets/" . $this->cat2dir($item->category) . "/{$avatar->tool}";
			$this->obj($location . ".obj", $location . ".png", "tool");
			$this->position("LeftArm", ['x' => -3.46774, 'y' => -0.9958, 'z' => 5.00153]);
			$this->rotate("LeftArm", [-90, -90, 0]);
		}

		/*
		SHIRTS, PANTS, FACES AND OTHERS
		*/
		$this->comment( "TEXTURES (shirts faces etc)" );
		if ($avatar->face !== "0") {
			$this->applyTexture( "Face", "/var/www/storage/assets/faces/".$avatar->face.".png" );
		} else {
			$this->applyTexture( "Face", "/var/www/html/render-testing/coolface.png" );
		}
		if ($avatar->shirt !== "0") {
			$this->applyTexture( "Shirt", "/var/www/storage/assets/shirts/".$avatar->shirt.".png" );
		}

		if ($avatar->pants !== "0") {
			$this->applyTexture( "Pants", "/var/www/storage/assets/pants/".$avatar->pants.".png" );
		}

		if ($avatar->tshirt !== "0") {
			$this->applyTexture( "Texture", "/var/www/storage/assets/tshirts/".$avatar->tshirt.".png" );
		}

		if ($avatar->tshirt == "0" && $avatar->shirt == "0") {
			$this->applyTexture( "Texture", "/var/www/storage/assets/tshirts/1.png" );
		}

		$this->focus();
	 	$this->export( $uniq, 384, "/render-testing/", "/var/www/storage/avatars/" );
		$increment = 1;
		$this->newLine("camera = bpy.data.objects['Camera']");
		$this->newLine("scene.camera.rotation_mode = 'XYZ'");
		$this->newLine("pi = 3.14159265");
		$this->newLine("scene.camera.rotation_euler[0] = 90*(pi/180.0)");
		$this->newLine("scene.camera.rotation_euler[1] = 0");
		$this->newLine("scene.camera.rotation_euler[2] = 0");
		$this->focus("Head");
		$this->newLine("camera.location.y -= {$increment}");
		$this->newLine("camera.location.z += 0.5");
		$this->export( $uniq, 100, "/render-testing/", "/var/www/storage/heads/" );
		return $this->update_("avatar", ["cache" => $uniq, "rendered" => "true", "headshot" => $uniq], ["user_id" => $id]);
	}
}
?>
