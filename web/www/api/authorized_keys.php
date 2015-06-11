<?php

function getUserData($db, $username) {
	$stmt = $db->prepare("SELECT * FROM pubkey WHERE enabled=1 AND username=?");
	$stmt->execute(array($username));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

###

header('Content-type: text/plain');

require("../config.php");

$username = $_GET['username'];
$username = preg_replace("/[^a-zA-Z0-9]/", "", $username);

$host = $config['db']['host'];
$dbname = $config['db']['dbname'];
$user = $config['db']['username'];
$pass = $config['db']['password'];
$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

try {
	$data = getUserData($db, $username);
	foreach( $data as $user ) {
		#if( $user['enabled'] == 1 ) {
			echo( $user['pubkey'] );
		#}
	}
} catch(PDOException $ex) {
	echo('oops');
}
