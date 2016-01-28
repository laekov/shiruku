<?php
// to solve the terrible problem about _POST form data after redirecting all my urls
// PHP must be the ugliest language in the world
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	chdir('..');
	$_SERVER['REQUEST_URI'] = $_POST['requestURI'];
	unset($_POST['requestURI']);
	$_SERVER['REDIRECT_REQUEST_METHOD'] = 'POST';
	require_once("./app.php");
}
else {
	header("Location: /");
}

