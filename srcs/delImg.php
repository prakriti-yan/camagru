<?php

session_start();
print_r($_GET);
require "../class/image.class.php";
$db = new Images($_GET['id_pic'], "", $_SESSION['loggedInUser']);
print_r($db);
$db->deleteImg();

require '../class/like.class.php';
$like = new likes($_GET['id_pic'], "");
$like->deleteLikes();

require '../class/comment.class.php';
$cmt = new Comments($_GET['id_pic'], "", "");
$cmt->deleteCmt();

?>