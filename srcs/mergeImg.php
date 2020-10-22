<?php 

$pic = $_POST['pic'];
$dest = imagecreatefromstring(base64_decode($pic));
$imgs = explode(",", $_POST['img']);

foreach ($imgs as $img){
	$src = imagecreatefrompng("../static/img/img" . $img .".png");
	imagealphablending($src, false);
	imagesavealpha($src, true);
	if ($img == 1)
		imagecopy($dest, $src, 10, 10, 0, 0, 100, 100);
	else if ($img == 2)
		imagecopy($dest, $src, 10, 210, 0, 0, 100, 100);
	else if ($img == 3){
		imagecopy($dest, $src, 215, 210, 0, 0, 100, 100);
	}else if ($img == 4){
		imagecopy($dest, $src,  215, 5, 0, 0, 100, 100);
	}
	ob_start();
	imagejpeg($dest, null, "100%");
	$content = ob_get_contents();
	ob_end_clean();
}

echo json_encode(base64_encode($content));
imagedestroy($dest);
imagedestroy($src);

?>