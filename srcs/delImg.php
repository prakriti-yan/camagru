<?php

session_start();
require "../class/image.class.php";
$db = new Images($_GET['id_pic'], "", $_SESSION['loggedInUser']);
$db->deleteImg();

require '../class/like.class.php';
$like = new likes($_GET['id_pic'], "");
$like->deleteLikes();

require '../class/comment.class.php';
$cmt = new Comments($_GET['id_pic'], "", "");
$cmt->deleteCmt();

?>