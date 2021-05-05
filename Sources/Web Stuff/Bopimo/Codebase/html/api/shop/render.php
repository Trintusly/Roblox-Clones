<?php 
error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE);
$session = false;
require("shop.php");

if (isset($_FILES["texture"]) && isset($_POST["category"])) {
	if(!empty($_FILES["texture"]["tmp_name"])) {
		if ($shop->isImage($_FILES["texture"]["tmp_name"]) && $_FILES["texture"]["size"] < 1000000) {
			$model = false;
			$num = rand(1,10000);
			if ($_POST["category"] == 1 || $_POST["category"] == 2 && $_FILES["model"] && $shop->isAdmin()) {
				$model = true;
				move_uploaded_file($_FILES["model"]["tmp_name"],"/var/www/storage/preview/PREVIEW". $num . "TEXTURE.obj");
			}

			move_uploaded_file($_FILES["texture"]["tmp_name"],"/var/www/storage/preview/PREVIEW". $num . "TEXTURE.png");
			$shopRender->renderItem("",$_POST["category"],"/var/www/storage/preview/PREVIEW". $num . "TEXTURE");

			$shopRender->exportI("/var/www/storage/preview/PREVIEW". $num,"",512);
			//if (file_exists("/var/www/storage/preview/PREVIEW". $num . ".png")) {
			$render = file_get_contents("/var/www/storage/preview/PREVIEW". $num . ".png");

			$image64 = "data:image/png;base64,".base64_encode($render);

			echo json_encode(["status" => "ok", "image" => $image64]);

			unlink("/var/www/storage/preview/PREVIEW". $num . ".png");
			unlink("/var/www/storage/preview/PREVIEW". $num . "TEXTURE.png");
			if ($model) {
				unlink("/var/www/storage/preview/PREVIEW". $num . "TEXTURE.obj");
			};


		} else {
			echo json_encode(["status" => "error", "error" => "The uploaded file is not an image"]);
		}
	} else {
		echo json_encode(["status" => "error", "error" => "The uploaded image is too large"]);
	}
} else {
	echo json_encode(["status" => "error", "error" => ""]);
}
?>