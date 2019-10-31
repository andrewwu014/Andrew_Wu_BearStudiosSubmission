<?php
ini_set("session.cookie_httponly", 1);
session_start();
require 'database2.php';
//https://classes.engineering.wustl.edu/cse330/index.php?title=AJAX_and_JSON
header("Content-Type: application/json");
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str, true);
//End Citation

$user = htmlentities($json_obj['user']); //Reflected XSS
$safe_user = $mysqli->real_escape_string($user); //SQL Injection Protection
if( !preg_match('/^[\w_\-]+$/', $safe_user) ){ ///check validity of username 
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Username"
	));
    exit;
}
$pass = htmlentities($json_obj['pass']); //Reflected XSS
if( !preg_match('/^[\w_\-]+$/', $pass) ){ ///check validity of password
    echo json_encode(array(
		"success" => false,
		"message" => "Invalid Password"
	));
    exit;
}

//https://classes.engineering.wustl.edu/cse330/index.php?title=PHP_and_MySQL
$stmt = $mysqli->prepare("select id from users");
if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Query Prep Failed"
	));
    exit;
}

$stmt->execute();
$result = $stmt->get_result();
//Check to see if username is available
while($row = $result->fetch_assoc()){
	if (trim($safe_user) == trim(htmlentities($row['id']))){ ///if username is already in database
        echo json_encode(array(
            "success" => false,
            "message" => "Username Already Exists"
        ));
        exit;
    }
    
       
}
$hash_pass = password_hash($pass, PASSWORD_BCRYPT); ///create a password hash
$stmt = $mysqli->prepare("insert into users (id, hashed_pass) values (?, ?)");
if(!$stmt){
    echo json_encode(array(
        "success" => false,
        "message" => "Query Prep Failed"
    ));
    exit;
}
$stmt->bind_param('ss', $safe_user, $hash_pass);
$stmt->execute();
$stmt->close();
//End of Citation

$_SESSION['user_id'] = $safe_user;
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); //CSRF Protection
echo json_encode(array(
    "success" => true,
    "user" => $safe_user
));
exit;

?>