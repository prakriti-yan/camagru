<?php 

require '../class/image.class.php';
session_start();
$rawimg = $_POST['pic'];
$img = base64_decode($rawimg);
$login = $_SESSION['loggedInUser'];

$db = new Images("", $img, $login);
$id_pic = $db->addImg();
echo json_encode($id_pic);

?>