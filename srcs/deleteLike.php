<?php

session_start();
$id_pic = $_GET['id_pic'];
$login = $_SESSION['loggedInUser'];

require '../class/like.class.php';

$db = new Likes($id_pic, $login);
$db->deleteLike();
print_r($db);

?>