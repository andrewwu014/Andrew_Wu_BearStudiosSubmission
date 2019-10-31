<?php
ini_set("session.cookie_httponly", 1);
//https://classes.engineering.wustl.edu/cse330/index.php?title=PHP_and_MySQL
$mysqli = new mysqli('localhost', 'wustl_inst', 'wustl_pass', 'calendar');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
//End of citation
?>