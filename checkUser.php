<?php
ini_set("session.cookie_httponly", 1);
session_start();
if (isset($_SESSION['user_id'])){
    echo json_encode(array(
		"success" => true,
		"message" => htmlentities($_SESSION['user_id'])
	));
    exit;
}
else{
    echo json_encode(array(
		"success" => false,
	));
    exit;
}
?>