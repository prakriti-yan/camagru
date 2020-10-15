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
	<title>Camagru - web camera</title>
</head>
<body>
	<?php include 'header.php'; ?>
	<div>
		<div class="camera">
			<p>To create an image in your gallery, first pick a sticker from below 😌 </p>
			<button id="img1" style=background-color:#ffffff><img src="static/img/img1.png" width=120></button>
			<button id="img2" style=background-color:#ffffff><img src="static/img/img2.png" width=120></button>
			<button id="img3" style=background-color:#ffffff><img src="static/img/img3.png" width=120></button>
			<button id="img4" style=background-color:#ffffff><img src="static/img/img4.png" width=120></button><br /><br />
			<span>Then take a picture using the camera 📸 </span>
			<button id="startbutton">Capture</button><br /><br />
			<video id="video">Your brower does not support Video element.</video><br />	
		</div>
		<p>
		Or, you can upload a photo here 💻
		</p>
		<input><br/><br/>
		<canvas id="canvas" style="display: none"></canvas> 
		</div class="output">
			<img id="photo" >
		</div><br/>
		<span>Finally, upload your work into your gallery 🤳 👯‍♀️</span>
		<button id="uploadbutton">Upload</button><br /><br />
	</div>
	<script src="static/js/webcam.js"></script>
</body>

</html>