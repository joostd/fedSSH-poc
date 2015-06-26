<?php
session_start();
if( !isset($_SESSION['username']) ) {
	echo "Please log in first";
	exit();
}
$username = $_SESSION['username'];

if( isset($_GET['return']) ) {
	$return = $_GET['return'];
} else {
	$return = "/";
}

require("../../config.php");
$host = $config['db']['host'];
$dbname = $config['db']['dbname'];
$user = $config['db']['username'];
$pass = $config['db']['password'];
$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
#$affected_rows = $db->exec("UPDATE table SET field='value'");
$affected_rows = $db->exec("DELETE FROM pubkey WHERE username='$username'");

header("Location: $return");
