<?php 

$pic = $_POST['pic'];
$dest = imagecreatefromstring(base64_decode($pic));
$src = imagecreatefrompng("../static/img/img" . $_POST['img'] .".png");

imagealphablending($src, false);
imagesavealpha($src, true);

// if ($_POST['img'] == 1 || $_POST['img'] == 3)
  imagecopy($dest, $src, 10, 10, 0, 0, 100, 100);
// else
  // imagecopy($dest, $src, 160, 160, 0, 0, 100, 100);

ob_start();
imagejpeg($dest, null, 100);
$content = ob_get_contents();
ob_end_clean();

echo json_encode(base64_encode($content));
imagedestroy($dest);
imagedestroy($src);

?>