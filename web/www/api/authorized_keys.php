<?php

function getUserData($db, $username) {
	$stmt = $db->prepare("SELECT * FROM pubkey WHERE enabled=1 AND username=?");
	$stmt->execute(array($username));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

###

require("../config.php");

$username = $_GET['username'];
if (!preg_match("/^[a-zA-Z0-9._-]+$/", $username)) {
    http_response_code(404);
    exit;
}

$host = $config['db']['host'];
$dbname = $config['db']['dbname'];
$user = $config['db']['username'];
$pass = $config['db']['password'];
$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

header('Content-type: text/plain');

try {
	$data = getUserData($db, $username);
	foreach( $data as $user ) {
		if( $user['enabled'] == 1 ) {
			echo( $user['pubkey'] );
		}
	}
} catch(PDOException $ex) {
	echo('oops');
}
