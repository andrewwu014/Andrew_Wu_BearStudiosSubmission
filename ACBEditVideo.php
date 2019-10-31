<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';

$link = $_POST['newLink'];

$stmt = $mysqli->prepare("update video set link=? where id=1");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}
$stmt->bind_param('s', $link);
$stmt->execute();
$stmt->close();

echo "Editing...";
header("refresh:2; url = http://ec2-18-218-144-7.us-east-2.compute.amazonaws.com/~andrew.wu/ACBEdit.php");
exit;
?>