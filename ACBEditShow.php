<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';

$sid = $_POST['showID'];
$name = $_POST['name'];
$datetime = $_POST['datetime'];
$ticketPrice = $_POST['ticketPrice'];
if (!empty($name)){
    $stmt = $mysqli->prepare("update shows set name=? where sid=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $name, $sid);
    $stmt->execute();
    $stmt->close();
}

if (!empty($datetime)){
    $stmt = $mysqli->prepare("update shows set datetime=? where sid=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('si', $datetime, $sid);
    $stmt->execute();
    $stmt->close();
}

if (!empty($ticketPrice)){
    $stmt = $mysqli->prepare("update shows set ticketprice=? where sid=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->bind_param('ii', $ticketPrice, $sid);
    $stmt->execute();
    $stmt->close();
}
echo "Editing...";
header("refresh:2; url = http://ec2-18-218-144-7.us-east-2.compute.amazonaws.com/~andrew.wu/ACBEdit.php");
exit;
?>