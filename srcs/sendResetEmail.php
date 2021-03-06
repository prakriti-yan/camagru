<?php

$subject = "Reset the password for your account in Camagru";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
$headers .= "From: camagru-noreply@student.hive.fi\n";

$msg = "<html><body>";
$msg .= "<p>Hello " . htmlentities($this->login) . ":</p>";
$msg .= "<p>To reset the password for your account in Camagru, click on the following link within 72 hours: ";
$msg .= "<a href=http://" . htmlentities($url) . ">Click me</a></p>";
$msg .= "Hope to hear from you soon!";
$msg .= "<p>Camagru</p>";
$msg .= "</body></html>";
if (mail($email, $subject, $msg, $headers))
    return $this->msg = "Password reset email has been sent to you.";
else
    return $this->msg = "Password reset email cannot been sent!";
?>