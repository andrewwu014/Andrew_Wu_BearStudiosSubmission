<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';

$email = $_POST['email'];
$subject = "A Capella Boys";
$message = "Tickets purchased.";

$messageWrap = wordwrap($message, 70);

mail($email, $subject, $messageWrap);
echo "Payment Pending...";
header("refresh:2; url = http://ec2-18-218-144-7.us-east-2.compute.amazonaws.com/~andrew.wu/ACBHomepage.php");
?>