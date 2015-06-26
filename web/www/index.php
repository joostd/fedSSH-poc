<?php

function getUserData($db, $username) {
	$stmt = $db->prepare("SELECT * FROM pubkey WHERE username=?");
	$stmt->execute(array($username));
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

###

if (array_key_exists('logout', $_REQUEST)) {
	$return = $_SERVER['PHP_SELF'];
	header("Location: saml/logout.php?return=$return");
	exit();
}
if (array_key_exists('login', $_REQUEST)) {
	$return = $_SERVER['PHP_SELF'];
	header("Location: saml/login.php?return=$return");
	exit();
}
if (array_key_exists('create', $_REQUEST)) {
	$return = $_SERVER['PHP_SELF'];
	header("Location: db/create.php?return=$return");
	exit();
}
if (array_key_exists('delete', $_REQUEST)) {
	$return = $_SERVER['PHP_SELF'];
	header("Location: db/delete.php?return=$return");
	exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="/shibboleth-sp/main.css" />
	<title>My Credentials</title>
</head>
<body>

<h1>My Credentials</h1>

<?php
session_start();

if (!isset($_SESSION['username']) ) {
	echo '<p><a href="?login">Log in</a></p>';
	exit();
} else {
	echo "<p><a href='?logout'>Log out</a> " . $_SESSION['username'] . "</p>";
}
$username = $_SESSION['username'];


require("../config.php");
$host = $config['db']['host'];
$dbname = $config['db']['dbname'];
$user = $config['db']['username'];
$pass = $config['db']['password'];
$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

try {
	$data = getUserData($db, $username);
	if( count($data) < 1 ) {
		echo "<p>For SSH access to servers, you will need additional credentials. You have no such credentials configured.</p> ";
		echo "<a href='?create'>create SSH credential</a>";
	} else {
		$user = $data[0];
		$email = $user['email'];
		#echo "$email";
        foreach( $data as $user ) {
            #if( $user['enabled'] == 1 ) {
            echo( substr($user['pubkey'], 0, 32) . "...  " );
            echo "(<a href='?delete'>delete</a>)";
            #}
        }
    }
} catch(PDOException $ex) {
	echo('oops');
}

?>
</body>
</html>
