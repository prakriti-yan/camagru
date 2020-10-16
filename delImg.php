<?php

session_start();
print_r($_GET);
require "class/image.class.php";
$db = new Images($_GET['id_pic'], "", $_SESSION['loggedInUser']);
print_r($db);
$db->deleteImg();


?>