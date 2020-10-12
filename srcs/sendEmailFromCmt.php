<?php

$subject = "Confirm your account in Camagru";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
$headers .= "From: camagru-noreply@student.hive.fi\n";

$msg = "<html><body>";
$msg .= "<p>Hello " . $user['login'] . ":</p>";
$msg .= "<p>You get a comment from " . $this->login . "for your picture: \"" . $this->comment . "\". </p>";
$msg .= "<a href=http://" . $url . ">Click me</a></p>";
$msg .= "Hope to hear from you soon!";
$msg .= "<p>Camagru</p>";
$msg .= "</body></html>";

if (mail($this->email, $subject, $msg, $headers))
    return $this->msg = "Confirmation email has been sent to you.";
else
    return $this->msg = "Confirmation email cannot been sent!";
?>