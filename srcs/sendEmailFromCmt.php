<?php

$subject = "Camagru - new comments";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
$headers .= "From: camagru-noreply@student.hive.fi\n";

$msg = "<html><body>";
$msg .= "<p>Hello " . htmlentities($user['login']) . ":</p>";
$msg .= "<p>You get the following comment from user \"" . htmlentities($this->login) . "\" for your picture: \"" . htmlentities($this->comment) . "\". </p>";
$msg .= "Hope to hear from you soon!";
$msg .= "<p>Camagru</p>";
$msg .= "</body></html>";

mail($user['email'], $subject, $msg, $headers);

?>