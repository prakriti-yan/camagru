<?php
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../static/css/gallery.css">
	<link rel="stylesheet" href="../static/css/header.css">
	<title>Camagru - gallery</title>
</head>
<body>
	<div id = "container">
	<?php include "header.php"?>
	<!-- <h2>Gallery</h2> -->
	<div id="contentheader">✨ Gallery 💎</div><br/>
	<?php
		require '../class/image.class.php';
		$db = new Images("", "", "");
		$nb = 3;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$nbOfImg = $db->countNB();
		$nbOfPage = ceil($nbOfImg / $nb);
		if ($nbOfImg == 0):?>
			<p>There are no images in gallery, please create in Web-camera page!</p>
		<?elseif($page > $nbOfPage || !preg_match('/^[0-9]*$/', $page)):
			echo '<script>header("Location: gallery.php?page=1")</script>';
		else:
			$imgs = $db->getImgByNB(($page - 1) * $nb, $nb);
			require '../class/like.class.php';
			require '../class/comment.class.php';

			foreach ($imgs as $img):
				$id_pic = $img['id_pic'];
				$user = $img['login'];
				$like = new Likes($id_pic, $_SESSION['loggedInUser']);
				$nbOfLike = $like->getNB();
				$recordOfLike = $like->getLike();
				$comment = new Comments($id_pic, "", "");
				$comments = $comment->getCmt();
				?>
				
			<div class = "displaypic">
				<img src="data:image/jpeg;base64,<?=base64_encode($img['image'])?>" >
			
			<div class="likeComment">
				<?if ($recordOfLike == null):?>
					<button class="like" onclick="addLike(<?=$id_pic?>)"><img id="like_<?=$id_pic?>" src="../static/img/heart.png"></button>
				<?else:?>
					<button class="like" onclick="addLike(<?=$id_pic?>)"><img id="like_<?=$id_pic?>" src="../static/img/heart_red.png"></button>
				<?endif;?>
				<label for="new_cmt+<?=$id_pic?>" class="comment"><img id="cmt_<?=$id_pic?>" src="../static/img/comment.png"></label>
				<span class="nblike" id="nblike_<?=$id_pic?>"><?=$nbOfLike?> Likes</span>
			</div>
			<div id="comments_<?=$id_pic?>">
				<?foreach ($comments as $cmt):?>
					<div class="comment"><b><?=$cmt['login']?></b> <?=$cmt['comment']?></div>
				<?endforeach;?>
			</div>
			<form method="post">
				<input class="text" class="input" id="new_cmt_<?=$id_pic?>" name ="new_cmt_<?=$id_pic?>" onkeypress="{if (event.keyCode === 13) {event.preventDefault(); addCmt(<?=$id_pic?>, this, '<?=$_SESSION['loggedInUser']?>')}}"
					placeholder="Write a comment here...">
			</form>
			</div>
			<?endforeach;?>
		<div class="page">
		<? if ($page != 1):?>
			<a href="gallery.php?page=<?=($page - 1)?>">☜</a>
		<?endif;?>
			<span><b><?=$page?> </b> </span>
		<? if ($page < $nbOfPage):?>
			<a href="gallery.php?page=<?=($page + 1)?>">☞</a>
		<?endif;?>
	</div>
			<?endif;?>
	</div>
	<script type="application/javascript" src="../static/js/gallery.js"></script>
</body>
</html>