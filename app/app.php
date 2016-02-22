<?php
define('srkVersion', '0.0.1');

// decipher uri by / into an array
function decipherURI($uri) {
	$path = array('');
	$urlArr = explode('?', $uri);
	$urlParts = explode('/', $urlArr[0]);
	foreach ($urlParts as $item) {
		if (strlen($item) > 0) {
			array_push($path, $item);
		}
	}
	return $path;
}

$_SERVER['REDIRECT_STATUS'] = 0;
header('HTTP/1.1 200 OK');
header('Status: 200 OK');

// chdir to root directory
chdir(dirname(__file__));

// load environment vars
require_once('./config/env.php');
$srkEnv->reqURL = decipherURI($_SERVER['REQUEST_URI']);
$srkEnv->reqURLLength = count($srkEnv->reqURL) - 1;
$srkEnv->reqMethod = $_SERVER['REDIRECT_REQUEST_METHOD'];

// load content profiles
require_once('./config/content.php');

// start session
session_start();

// decide which route to use
if ($srkEnv->reqURLLength == 0 || 
	($srkEnv->reqURLLength == 1 && $srkEnv->reqURL[1] == 'home')) { // render homepage
	require_once($srkEnv->appPath.'/routes/home.php');
}
else {
	$routeList = Array('list', 'view', 'pen', 'comment', 'resources', 'login', 'admin');
	foreach ($routeList as $route) {
		if ($srkEnv->reqURL[1] == $route) {
			require_once($srkEnv->appPath.'/routes/'.$route.'.php');
			break;
		}
	}
}
if (!isset($srkEnv->sent)) {
	if ($srkEnv->reqMethod == 'GET') {
		require_once($srkEnv->appPath.'/modules/render.php');
		srkRender('error', Array('error'=>Array('status'=>'404', 'stack'=>'Unused url')));
	}
	else {
		srkSend((Object)Array('error'=>'Unused url'));
	}
}

