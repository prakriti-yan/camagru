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
		<div id = "sidebar">
			<div id="sideheader">✨ Your creation 💎</div>
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
		<div id="footer">
			<!-- <br/> -->
			<hr>
			<a href='https://github.com/prakriti-yan' target="_blank"><strong>Yan Yan 2020</strong></a>
		</div>
	</div>
	<script src="static/js/webcam.js"></script>
</body>

</html>