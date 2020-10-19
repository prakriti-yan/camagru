<?php
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/static/css/main.css">
	<link rel="stylesheet" href="/static/css/header.css">
	<title>Camagru - gallery</title>
</head>
<body>
	<div id = "container">
	<?php include "header.php"?>
	<h2>Gallery</h2>
	<?php
			require 'class/image.class.php';
			$db = new Images("", "", $_SESSION['loggedInUser']);
			$imgs = $db->getImgByLogin();
			foreach ($imgs as $img): ?>
				<div class="gallerysection">
					<img class="mediumpic" src="data:image/png;base64,<?=base64_encode($img['image'])?>">
					<!-- <img class = "delpic" id="del_<?=$img['id_pic']?>" onclick="deleteImg(<?=$img['id_pic']?>)" src="static/img/del.png" > -->
				</div>
			<? endforeach; ?>
	</div>
</body>
</html>