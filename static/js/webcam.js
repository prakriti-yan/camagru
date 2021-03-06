
(function() {
	var width = document.getElementById("video").clientWidth;
	var height = 0;
	var streaming = false;
	var imgselected = [];
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
		if (imgselected.length !=  0){
			takepicture(1);
			ev.preventDefault();
		}else{
			alert("Please select one or more stickers first :)");
			ev.preventDefault();
		}
	}, false);
	

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
		}else{
			alert("Choose a picture to upload :)");
		}
	})
	
	function takepicture(nb){
		if (imgselected.length != 0){
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
		}else{
			takepictureNoSticker(nb);
		}
	}
	
	function takepictureNoSticker(nb){
		var newcanvas = document.createElement("canvas");
			newcanvas.width = width;
			newcanvas.height = height;
			canvas.width = width;
			canvas.height = height;
			if (nb == 0){
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
					photo.setAttribute("src", pic);
					imgdata = pic;
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
				if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
					var res = JSON.parse(xhr.responseText);
					addMini(res['id_pic'], imgdata);
					photo.setAttribute('src', "../static/img/clear.png");
					imgdata = 0;
				}
			}
			ev.preventDefault();
		}else{
			alert("Please take a picture or upload a picture first :)");
		}
	}, false);

	function addMini(id_pic, imgdata){
		var div = document.createElement("DIV");
    	div.setAttribute("class", "displaypic");
		var img = document.createElement("IMG");
		img.setAttribute("src", imgdata);
		img.setAttribute("class", "minipic");
		var del = document.createElement("IMG");
		del.setAttribute("src", "../static/img/del.png");
		del.setAttribute("class", "delpic");
		del.setAttribute("id", "del_"+id_pic);
		del.setAttribute("onclick", "deleteImg("+id_pic+")");
		var side = document.getElementById("sidecontent");
		side.insertBefore(div, side.childNodes[0]);
		div.insertBefore(del, div.childNodes[0]);
		div.insertBefore(img, div.childNodes[0]);	
	}	

	img1.addEventListener("click", function(ev){
		if (imgselected.includes(1)){
			var index = imgselected.indexOf(1);
			if (index > -1) {
				imgselected.splice(index, 1);
			}
			console.log(imgselected);
			img1.setAttribute("style", "background-color:#ffffff");
			ev.preventDefault;
		}else{
			imgselected.push(1);
			img1.setAttribute("style", "background-color:#F7C1C1");
			ev.preventDefault;
		}
	}, false);

	img2.addEventListener("click", function(ev){
		if (imgselected.includes(2)){
			var index = imgselected.indexOf(2);
			if (index > -1) {
				imgselected.splice(index, 1);
			}
			console.log(imgselected);
			img2.setAttribute("style", "background-color:#ffffff");
			ev.preventDefault;
		}else{
			imgselected.push(2);
			img2.setAttribute("style", "background-color:#F7C1C1");
			ev.preventDefault;
		}
	}, false);

	img3.addEventListener("click", function(ev){
		if (imgselected.includes(3)){
			var index = imgselected.indexOf(3);
			if (index > -1) {
				imgselected.splice(index, 1);
			}
			console.log(imgselected);
			img3.setAttribute("style", "background-color:#ffffff");
			ev.preventDefault;
		}else{
			imgselected.push(3);
			img3.setAttribute("style", "background-color:#F7C1C1");
			ev.preventDefault;
		}
	}, false);

	img4.addEventListener("click", function(ev){
		if (imgselected.includes(4)){
			var index = imgselected.indexOf(4);
			if (index > -1) {
				imgselected.splice(index, 1);
			}
			console.log(imgselected);
			img4.setAttribute("style", "background-color:#ffffff");
			ev.preventDefault;
		}else{
			imgselected.push(4);
			img4.setAttribute("style", "background-color:#F7C1C1");
			ev.preventDefault;
		}
	}, false);

	

})();

// this function has to be outside of the onload function!!
function deleteImg(id_pic){
	document.getElementById("del_"+id_pic).parentNode.remove();
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "../srcs/delImg.php?id_pic="+id_pic, true);
	xhr.send();
}