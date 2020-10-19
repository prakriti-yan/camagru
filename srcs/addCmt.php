<?php

session_start();
$login = $_SESSION['loggedInUser'];

$id_pic = $_POST['id_pic'];
$comment = $_POST['cmt'];

require "../class/comment.class.php";

$db = new Comments($id_pic,  $login, $comment);
$db->addCmt();
// $db->sendEmailToLogin();

?>