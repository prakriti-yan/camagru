function deleteImg(id_pic){
	document.getElementById("del_"+id_pic).parentNode.remove();
	console.log(id_pic);
	var xhr = new XMLHttpRequest();
	xhr.open("GET", "../srcs/delImg.php?id_pic="+id_pic, true);
	xhr.send();
}

function addLike(id_pic){
	var img = document.getElementById('like_'+id_pic).attributes.getNamedItem("src").value;
	if (img == "../static/img/heart.png"){
		document.getElementById('like_'+id_pic).src="../static/img/heart_red.png";
		var nblike = document.getElementById("nblike_"+id_pic);
		var nb = nblike.innerHTML;
		nb = parseInt(nb);
		nb++;
		nblike.innerHTML = nb+ " likes";
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "../srcs/saveLike.php?id_pic="+id_pic, true);
		xhr.send();
	}
	else if(img == "../static/img/heart_red.png"){
		document.getElementById('like_'+id_pic).src="../static/img/heart.png";
		var nblike = document.getElementById("nblike_"+id_pic);
		var nb = nblike.innerHTML;
		nb = parseInt(nb);
		nb--;
		nblike.innerHTML = nb+ " likes";
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "../srcs/deleteLike.php?id_pic="+id_pic, true);
		xhr.send();
	}

}

function addCmt(id_pic, comment, login){
	cmt = comment.value;
	if (cmt.trim() === "")
		return;
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "../srcs/addCmt.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("id_pic="+id_pic+"&cmt="+cmt);
	xhr.onreadystatechange = function (){
		if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
			var div = document.createElement("DIV");
			div.setAttribute("class", "comment");
			div.innerHTML = "<b>"+login + "</b> "+cmt;
			document.getElementById("comments_"+id_pic).appendChild(div);
			comment.value="";
		}
	}
}