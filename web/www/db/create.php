<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="/shibboleth-sp/main.css" />
  <title>Upload SSH public key</title>
 </head>
 <body>
  <h1>Upload SSH public key</h1>
<?php

session_start();
if( !isset($_SESSION['username']) ) {
	echo "Please log in first";
	exit();
}
$username = $_SESSION['username'];

$mail = '';
if( isset($_SESSION['mail']) ) {
	$mail = $_SESSION['mail'];
}

$return = "/";
if( isset($_GET['return']) ) {
	$return = $_GET['return'];
}



$target_file = basename($_FILES["fileToUpload"]["name"]);
//echo "[$target_file]";
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
//echo "[$fileType]";

if(isset($_POST["submit"])) {
    $pubkey = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
    if($pubkey !== false) {
        # "File is an SSH pubkey";
        $uploadOk = 1;
    } else {
        echo "File is not an SSH pubkey.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 1000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if($fileType != "pub" ) {
        echo "Sorry, only SSH public key files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        #echo "<code>$pubkey</code>";
    }


    require("../../config.php");
    $host = $config['db']['host'];
    $dbname = $config['db']['dbname'];
    $user = $config['db']['username'];
    $pass = $config['db']['password'];
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $result = $db->exec("INSERT INTO pubkey(username, pubkey, email, enabled) VALUES('$username', '$pubkey', '$mail', TRUE) ON DUPLICATE KEY UPDATE pubkey='$pubkey'");

    echo "Your SSH credentials are:";
    echo "<li><b>username</b>:<code>$username</code></li>";
    echo "<li><b>pubkey</b>:<code>$pubkey</code></li>";
    echo "<p><a href='$return'>continue</a></p>";

} else {
    ?>
    <form method="post" enctype="multipart/form-data">
        Select SSH public key file to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload SSH pubkey" name="submit">
    </form>
<?php
}
?>
    </body>
    </html>
