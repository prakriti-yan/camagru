<?php 

// print_r("hello!!!!");
print_r($_POST);
$pic = $_POST['pic'];
$pic = imagecreatefromstring(base64_decode($pic));
$img = imagecreatefrompng("static/img/img" . $_POST['img'] .".png");

imagealphablending($img, false);
imagesavealpha($img, true);
if ($_POST['img'] % 2 == 0)
  imagecopy($pic, $img, 160, 160, 0, 0, 100, 100);
else
  imagecopy($pic, $img, 10, 10, 0, 0, 100, 100);
ob_start();
imagejpeg($pic, null, 100);
$contents = ob_get_contents();
ob_end_clean();

echo json_encode(base64_encode($contents));
imagedestroy($pic);
imagedestroy($img);
?>