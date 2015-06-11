<?php
session_start();
unset ($_SESSION['username']);

$logout_url = "/Shibboleth.sso/Logout?return=$return";

if( isset($_SERVER['return']) ) {
	$return = $_SERVER['return'];
} else {
	$return = "/";
}
header("Location: $logout_url");
