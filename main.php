<?php

$body_onload = "initialiseWebcam();";
session_start();
if (!isset($_SESSION['loggedInUser'])){
	header("Location: home.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="static/img/android-chrome-192x192.png" type="image/png" sizes="64x64">
	<link rel="stylesheet" href="/static/css/main.css">
	<link rel="stylesheet" href="/static/css/header.css">
	<title>Camagru - web camera</title>
</head>
<body>
	<div id = "container">
	<?php include 'header.php'; ?>
		<!-- <div id="main"> -->
		<div id = "sidebar">
			<div id="sideheader">✨ Your creation 💎</div><br/>
			<div id="sidecontent">
			<?php
			require 'class/image.class.php';
			$db = new Images("", "", $_SESSION['loggedInUser']);
			$imgs = $db->getImgByLogin();
			foreach ($imgs as $img): ?>
				<div class="displaypic">
					<img class="minipic left" src="data:image/png;base64,<?=base64_encode($img['image'])?>">
					<img class = "delpic" id="del_<?=$img['id_pic']?>" onclick="deleteImg(<?=$img['id_pic']?>)" src="static/img/del.png" >
				</div>
			<? endforeach; ?>
			</div>
		</div>
		<div id="content">
			<div id="contentheader"> ✨ Create an artwork in Camagru 💎 </div>
			<p class="left"> 1️⃣ First, pick a sticker from below 😌 </p>
			<button id="img1" class="left" style=background-color:#ffffff><img src="static/img/img1.png" width=120></button>
			<button id="img2" class="left" style=background-color:#ffffff><img src="static/img/img2.png" width=120></button>
			<button id="img3" class="left" style=background-color:#ffffff><img src="static/img/img3.png" width=120></button>
			<button id="img4" class="left" style=background-color:#ffffff><img src="static/img/img4.png" width=120></button><br /><br />
			<span class="left"> 2️⃣ Then, take a picture using the camera 📸 </span>
			<button id="startbutton" class="left">Capture</button><br /><br />
			<video id="video" class="left">Your brower does not support Video element.</video><br />	
			<p class="left"> 3️⃣ Or, upload a photo from your computer 💻</p>
			<input type="file" accept="image/*" name="uploadimg" id="uploadimg" class="left">
			<button id="uploadbutton" >upload</button><br /><br/>
			<span class="left"> 4️⃣ Finally, save your work below in the gallery 😌 </span>
			<button id="savebutton">Save</button><br /><br />
			<canvas id="canvas" style="display: none"></canvas> 
			<img id="photo" class="left">
		</div>
		<!-- </div> -->
		<div id="footer">
			<hr>
			<a href='https://github.com/prakriti-yan' class="left bottom"  target="_blank"><strong>Yan Yan 2020</strong></a>
		</div>
	</div>	
	<script type="application/javascript" src="static/js/webcam.js">	</script>	
</body>

</html>