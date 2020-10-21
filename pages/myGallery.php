<?php
 session_start();
if (!isset($_SESSION['loggedInUser']))
	header("Location: ../index.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../static/img/android-chrome-192x192.png" type="image/png" sizes="64x64">
	<link rel="stylesheet" href="../static/css/gallery.css">
	<link rel="stylesheet" href="../static/css/header.css">
	<title>Camagru - my gallery</title>
</head>
<body>
	<div id = "container">
		<?php include "header.php"?>
		<div id="main">
			<div id="contentheader">✨ My gallery 💎</div>
			<div id="content">
		<?php
		require '../class/image.class.php';
		$db = new Images("", "", $_SESSION['loggedInUser']);
		$nb = 3;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$nbOfImg = $db->countNBByLogin();
		$nbOfPage = ceil($nbOfImg / $nb);
		if ($nbOfImg == 0):?>
			<p>You do not have posts saved in the gallery, please create one here <a href="main.php">Web-camera page</a> 🥰</p>
		<?elseif($page > $nbOfPage || !preg_match('/^[0-9]*$/', $page)):
			echo '<script>location.replace("mygallery.php?page=1")</script>';
		else:
			$imgs = $db->getImgByNBByLogin(($page - 1) * $nb, $nb);

			require '../class/comment.class.php';
			require '../class/like.class.php';
			
			foreach ($imgs as $img):
				$id_pic = $img['id_pic'];
				$like = new Likes($id_pic, $_SESSION['loggedInUser']);
				$nbOfLike = $like->getNB();
				$recordOfLike = $like->getLike();
				$comment = new Comments($id_pic, "", "");
				$comments = $comment->getCmt();
				?>
			
			<div class="displaypic">
				<div class=name> <b><?=htmlentities($img['login'])?></b> </div>
				<img class="img" src="data:image/jpeg;base64,<?=base64_encode($img['image'])?>" >
				<img class = "delpic" id="del_<?=$img['id_pic']?>" onclick="deleteImg(<?=$img['id_pic']?>)" src="../static/img/del.png">
				<div class="likeComment">
					<? if ($recordOfLike == null) :?>
						<button onclick ="addLike(<?=$id_pic?>)" class="like"><img id="like_<?=$id_pic?>" src="../static/img/heart.png"></button>
					<?else:?>
						<button onclick ="addLike(<?=$id_pic?>)" class="like"><img id="like_<?=$id_pic?>" src="../static/img/heart_red.png"></button>
					<?endif;?>
					<label for="new_cmt+<?=$id_pic?>" class="comment"><img id="cmt_<?=$id_pic?>" src="../static/img/comment.png"></label>
					<span class="nblike" id="nblike_<?=$id_pic?>"><?=$nbOfLike?> likes</span>
				</div>
				<div id="comments_<?=$id_pic?>">
					<? foreach ($comments as $cmt): ?>
						<div class="comment"><b><?=htmlentities($cmt['login'])?> </b><?=htmlentities($cmt['comment'])?></div>
					<?endforeach;?>
				</div>
				<form method="post">
						<input class="text" class="input" style="width:98%;" id="new_cmt_<?=$id_pic?>" name ="new_cmt_<?=$id_pic?>" onkeypress="{if (event.keyCode === 13) {event.preventDefault(); addCmt(<?=$id_pic?>, this, '<?=$_SESSION['loggedInUser']?>')}}"
						placeholder="Write a comment here...">
				</form>
			</div>
		<?endforeach; ?>
		<br/><br/>
		<div class="page">
			<? if ($page != 1):?>
				<a href="myGallery.php?page=<?=($page - 1)?>">☜</a>
			<?endif;?>
				<span><b><?=$page?> </b> </span>
			<? if ($page < $nbOfPage):?>
				<a href="myGallery.php?page=<?=($page + 1)?>">☞</a>
			<?endif;?>
		</div>
		</div>
		<?endif;?>
		</div>
		<div id="footer">
			<hr>
			<a href='https://github.com/prakriti-yan' class="left bottom"  target="_blank"><strong>Yan Yan 2020</strong></a>
		</div>
	</div>
	<script type="application/javascript" src="../static/js/gallery.js"></script>
</body>
	
</html>