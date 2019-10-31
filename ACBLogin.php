<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';
header("Content-Type: application/json");

$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);

$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_pass FROM users WHERE id=?");
$stmt->bind_param('s', $user);
$user = $mysqli->real_escape_string($json_obj['username']); //SQL Injection Protection
if( !preg_match('/^[\w_\-]+$/', $user) ){ //Sanitize Non-HTML Output
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Username"
	));	
    exit;
}
$stmt->execute();
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();
$pass = htmlentities($json_obj['password']); //Reflected XSS
if( !preg_match('/^[\w_\-]+$/', $pass) ){
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Password"
	));
    exit;
}
//If username doesn't exist
if($cnt == 0){
    echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
    exit;
}
if($cnt == 1 && !password_verify($pass, $pwd_hash)){
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username and Password"
	));
    exit;
}
if($cnt == 1 && password_verify($pass, $pwd_hash)){ ///if one result 
    $_SESSION['user_id'] = $user;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); //CSRF Token
    echo json_encode(array(
		"success" => true,
		"user" => $user_id 
	));
	exit;
}
$stmt->close();
//End Citation
?>