
(function() {
	var width = 320;
	var height = 0;
	var streaming = false;
	var imgselected = 0;
	var video = document.getElementById("video");
	var canvas = document.getElementById("canvas");
	var photo = document.getElementById("photo");
	var file = document.getElementById("uploadimg");
	var startbutton = document.getElementById("startbutton");
	var savebutton = document.getElementById("savebutton");
	var uploadbutton = document.getElementById("uploadbutton");
	var img1 = document.getElementById("img1");
	var img2 = document.getElementById("img2");
	var img3 = document.getElementById("img3");
	var img4 = document.getElementById("img4");
	var upload = 0;
	var imgdata = 0;

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
		takepicture(1);
		ev.preventDefault();
	}, false);
	
	clearpicture();

	file.addEventListener("change", function(){
		var file = this.files[0];
		if (file.type.match(/image.*/) && file.size < 2000000) {
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.addEventListener("load", function(){
				upload = reader.result;
			}, false)
		}
	});

	uploadbutton.addEventListener("click", function(){
		if (upload != 0){
			takepicture(0);
		}
	})
	
	function clearpicture(){
		var context = canvas.getContext('2d');
		// context.fillStyle = "#F7C1C1";
		context.font = "5px Arial";
		context.fillText("Your artwork is shown here 💚",canvas.width, canvas.height);
		// context.fillRect(0, 0, canvas.width, canvas.height);

		var data = canvas.toDataURL("image/png");
		photo.setAttribute('src', data);
	}

	function takepicture(nb){
		if (imgselected != 0){
			var newcanvas = document.createElement("canvas");
			newcanvas.width = width;
			newcanvas.height = height;
			canvas.width = width;
			canvas.height = height;
			if (nb == 1){
				if (width && height) {
					photo.width = width;
					photo.height = height;
					newcanvas.getContext("2d").drawImage(video, 0, 0, width, height);
					var pic = newcanvas.toDataURL("image/png");
					mergeImg(pic);
				}else{
					clearpicture();
				}
			}else{
				var image = new Image();
				image.src = upload;
				image.onload = function(){
					var wid=this.width;
					var hegt=this.height;
					if (wid > 1000 || hegt >1000){
						wid = wid / 9;
						hegt = hegt / 9;
					}
					newcanvas.width = wid;
					newcanvas.height = hegt;
					photo.width = wid;
					photo.height = hegt;
					newcanvas.getContext("2d").drawImage(image, 0, 0, wid, hegt);
					var pic = newcanvas.toDataURL("image/png");
					mergeImg(pic);
				}
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
				imgdata = response;
				image.src = response;
				image.onload = function(){
					canvas.getContext('2d').drawImage(image, 0, 0, width, height);
					var data = canvas.toDataURL('image/png');
					photo.setAttribute("src", data);
				}
			}
		}
	}

	savebutton.addEventListener("click", function(ev){
		if (imgdata != 0){
			var picdata = imgdata.replace("data:image/png;base64,", "");
			var xhr = new XMLHttpRequest();
			xhr.open("POST", "../srcs/saveImg.php", true);
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("pic="+encodeURIComponent(picdata));
			xhr.onreadystatechange = function(){
				
			}

			ev.preventDefault();
		}
	}, false);

	img1.addEventListener("click", function(ev){
		imgselected = 1;
		img1.setAttribute("style", "background-color:#F7C1C1");
		img2.setAttribute("style", "background-color:#ffffff");
		img3.setAttribute("style", "background-color:#ffffff");
		img4.setAttribute("style", "background-color:#ffffff");
		ev.preventDefault;
	}, false);

	img2.addEventListener("click", function(ev){
		imgselected = 2;
		img1.setAttribute("style", "background-color:#ffffff");
		img2.setAttribute("style", "background-color:#F7C1C1");
		img3.setAttribute("style", "background-color:#ffffff");
		img4.setAttribute("style", "background-color:#ffffff");
		ev.preventDefault;
	}, false);

	img3.addEventListener("click", function(ev){
		imgselected = 3;
		img1.setAttribute("style", "background-color:#ffffff");
		img2.setAttribute("style", "background-color:#ffffff");
		img3.setAttribute("style", "background-color:#F7C1C1");
		img4.setAttribute("style", "background-color:#ffffff");
		ev.preventDefault;
	}, false);

	img4.addEventListener("click", function(ev){
		imgselected = 4;
		img1.setAttribute("style", "background-color:#ffffff");
		img2.setAttribute("style", "background-color:#ffffff");
		img3.setAttribute("style", "background-color:#ffffff");
		img4.setAttribute("style", "background-color:#F7C1C1");
		ev.preventDefault;
	}, false);

	

})();