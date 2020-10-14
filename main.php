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
			<video id="video">Your brower does not support Video element.</video><br />
			<button id="startbutton">Take a photo</button><br />
		</div>
		<canvas id="canvas"></canvas> <br/>
		</div class="output">
			<img id="photo" alt="The screen capture will appear here!">
		</div><br/>
		<button id="img1" style=background-color:#ffffff><img src="static/img/img1.png" width=120></button>
		<button id="img2" style=background-color:#ffffff><img src="static/img/img2.png" width=120></button>
		<button id="img3" style=background-color:#ffffff><img src="static/img/img3.png" width=120></button>
		<button id="img4" style=background-color:#ffffff><img src="static/img/img4.png" width=120></button>
		<!-- <button id="img5" style=background-color:#ffffff><img src="static/img/img5.png" width=120></button>
		<button id="img6" style=background-color:#ffffff><img src="static/img/img6.png" width=120></button><br /> -->
		<p>
		Otherwise,<br/>
		Upload a photo:
		</p>
		
	</div>
	<script src="static/js/webcam.js"></script>
</body>

</html>