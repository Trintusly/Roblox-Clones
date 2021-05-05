<?php 

// Isaiah was here (and created this).

$maxSizePost = "500M";
$maxSizeUpload = "500M";

$newPostMaxSize = ini_set('post_max_size', $maxSizePost);
$newUploadMaxSize = ini_set('upload_max_filesize', $maxSizeUpload);

if ($newPostMaxSize) {
	echo "Max file size changed to" . ini_get("post_max_size") . "<br>";
} else {
	echo "Max file size did not change and is " . ini_get("post_max_size") . "<br>";
}

if (ini_set($newUploadMaxSize)) {
	echo "Max upload size changed to" . ini_get("upload_max_filesize");
} else {
	echo "Max upload size did not change and is " . ini_get("upload_max_filesize");
}

echo '<br><b>Requested Vars</b><br> Requested new post max size: ' . $maxSizePost . '<br>' . 'Requested new upload max size: ' . $maxSizeUpload;

?>