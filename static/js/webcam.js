
(function() {
	var width = 320;
	var height = 0;
	var streaming = false;
	var imgselected = 0;
	var video = document.getElementById("video");
	var canvas = document.getElementById("canvas");
	var photo = document.getElementById("photo");
	var startbutton = document.getElementById("startbutton");
	var uploadbutton = document.getElementById("uploadbutton");
	var img1 = document.getElementById("img1");
	var img2 = document.getElementById("img2");
	var img3 = document.getElementById("img3");
	var img4 = document.getElementById("img4");

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
			if (width && height) {
			// 	context.drawImage(video, 0, 0, canvas.width, canvas.height);
			// 	var data = canvas.toDataURL("image/png");
			// 	photo.setAttribute("src", data);
			
			var newcanvas = document.createElement("canvas");
			newcanvas.width = width;
      		newcanvas.height = height;
			canvas.width = width;
      		canvas.height = height;
			// context = canvas.getContext('2d');
			// if (width && height) {
				newcanvas.getContext("2d").drawImage(video, 0, 0, width, height);
				var pic = newcanvas.toDataURL("image/png");
				mergeImg(pic);
				}else{
				clearpicture();
			}
		}
	}

	function mergeImg(pic){
		var picdata = pic.replace("data:image/png;base64,", "");
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "../srcs/mergeImg.php", true);
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("pic="+encodeURIComponent(picdata)+"&img="+imgselected);
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
				var response = JSON.parse(xhr.responseText);
				response = "data:image/png;base64,"+response;
				image = new Image();
				image.src = response;
				console.log(image);
				image.onload = function(){
					console.log(canvas);
					canvas.getContext('2d').drawImage(image, 0, 0, width, height);
					var data = canvas.toDataURL('image/png');
					photo.setAttribute("src", data);
				}
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

	uploadbutto.addEventListener("click", function(){
		alert("Hello world");
	})

})();