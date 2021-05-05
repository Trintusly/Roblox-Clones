<?php 
$file_result = "";
if ($_FILES["file"]["error"] > 0) {
$file_result .= "No File Uploaded or Invalid File";
$file_result .= "Error Code: " . $_FILES["file"]["error"] . "<br>";
} else {

$file_result .=
"Upload: " . $_FILES["file"]["name"] . "<br>" .
"Type: " . $_FILES["file"]["type"] . "<br>" .
"Size " . ($_FILES["file"]["size"] / 1024) . " KB<br>" .
"Temp file " . $_FILES["file"]["tmp_name"] . "<br>";

move_uploaded_file($_FILES["file"]["tmp_name"],
"/alpha_subdomain/assets/shop/models" . $_FILES["file"]["name"]);

$file_result .= "File uploaded successfully!";
}

?>