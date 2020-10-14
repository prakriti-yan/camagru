
(function() {
	var width = 320;
	var height = 0;
	var streaming = false;
	var video = null;
	var canvas = null;
	var photo = null;
	var startbutton = null;
	var imgselected = 0;
	var img1 = document.getElementById("img1");
	var img2 = document.getElementById("img2");
	var img3 = document.getElementById("img3");
	var img4 = document.getElementById("img4");


	function start(){
		video = document.getElementById("video");
		canvas = document.getElementById("canvas");
		photo = document.getElementById("photo");
		startbutton = document.getElementById("startbutton");

		navigator.mediaDevices.getUserMedia({video: true, audio: false})
		.then(function(stream) {
			video.srcObject = stream;
			video.play();
		})
		.catch(function(er){
			console.log("Error: " + er);
		});
		

		video.addEventListener("canplay", function(ev){
			if (!streaming){
				height = video.videoHeight / (video.videoWidth/width);
				 
				if (isNaN(height)){
					height = width / (4/3);
				}
	
				video.setAttribute('width', width);
				video.setAttribute('height', height);
				canvas.setAttribute('width', width);
				canvas.setAttribute('height', height);
				streaming = true;
			}
		}, false);
	
		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);
	
		clearpicture();
	}
	
	function clearpicture(){
		var context = canvas.getContext('2d');
		context.fillStyle = "#e6c747";
		context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL("image/png");
		photo.setAttribute('src', data);
	}

	function takepicture(){
		if (imgselected != 0){
			// var context = canvas.getContext('2d');
			// if (width && height) {
			// 	context.drawImage(video, 0, 0, canvas.width, canvas.height);
			// 	var data = canvas.toDataURL("image/png");
			// 	photo.setAttribute("src", data);
			// }else{
			// 	clearpicture();
			// }
			context = canvas.getContext('2d');
			if (width && height) {
				context.drawImage(video, 0, 0, canvas.width, canvas.height);
				var data = canvas.toDataURL("image/png");
				mergeImg(data);
			}
			else{
					clearpicture();
				}
		}
	}

	function mergeImg(pic){
		var picdata = pic.replace("data:image/png;base64,", "");
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "../srcs/mergeImg.php", true);
		xhr.send("pic="+encodeURIComponent(picdata)+"&img="+imgselected);
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
				alert(xhr.responseText);
				// console.log("hello@#$!");
				// var response = JSON.parse(xhr.responseText);
				// console.log(response);
				// response = "data:image/png;base64,"+response;
				// image = new Image();
				// image.src = response;
				// image.onload = function(){
				// 	convas.getContext('2d').drawImage(image, 0, 0, width, height);
				// 	canvas.toDataURL('image/png');
				// }
			}
		}
	}

	img1.addEventListener("click", function(ev){
		imgselected = 1;
		img1.setAttribute("style", "background-color:#e6c747");
		img2.setAttribute("style", "background-color:#ffffff");
		img3.setAttribute("style", "background-color:#ffffff");
		img4.setAttribute("style", "background-color:#ffffff");
		ev.preventDefault;
	}, false);

	img2.addEventListener("click", function(ev){
		imgselected = 2;
		img1.setAttribute("style", "background-color:#ffffff");
		img2.setAttribute("style", "background-color:#e6c747");
		img3.setAttribute("style", "background-color:#ffffff");
		img4.setAttribute("style", "background-color:#ffffff");
		ev.preventDefault;
	}, false);

	img3.addEventListener("click", function(ev){
		imgselected = 3;
		img1.setAttribute("style", "background-color:#ffffff");
		img2.setAttribute("style", "background-color:#ffffff");
		img3.setAttribute("style", "background-color:#e6c747");
		img4.setAttribute("style", "background-color:#ffffff");
		ev.preventDefault;
	}, false);

	img4.addEventListener("click", function(ev){
		imgselected = 4;
		img1.setAttribute("style", "background-color:#ffffff");
		img2.setAttribute("style", "background-color:#ffffff");
		img3.setAttribute("style", "background-color:#ffffff");
		img4.setAttribute("style", "background-color:#e6c747");
		ev.preventDefault;
	}, false);


	window.addEventListener('load', start, false);

})();