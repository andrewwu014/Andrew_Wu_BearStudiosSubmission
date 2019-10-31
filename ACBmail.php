<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';

$name = $_POST['feedbackName'];
$subject = "Feedback from $name";
$message = $_POST['feedbackContent'];

$messageWrap = wordwrap($message, 70);

mail("acapellatest0@gmail.com", $subject, $messageWrap);
echo "Sending...";
header("refresh:2; url = http://ec2-18-218-144-7.us-east-2.compute.amazonaws.com/~andrew.wu/ACBHomepage.php");
?>