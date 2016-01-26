<?php
// decipher uri by / into an array
function decipherURI($uri) {
	$path = array('');
	while (strlen($uri)) {
		$pos = strpos($uri, '/');
		if ($pos === false) {
			$pos = strlen($uri);
		}
		$curlev = substr($uri, 0, $pos);
		if (strlen($curlev)) {
			array_push($path, $curlev);
		}
		$uri = substr($uri, $pos + 1);
	}
	return $path;
}

$_SERVER['REDIRECT_STATUS'] = 0;
header('HTTP/1.1 200 OK');

require_once('./env.php');

$srkEnv->reqURL = decipherURI($_SERVER['REQUEST_URI']);
$srkEnv->reqURLLength = count($srkEnv->reqURL) - 1;
$srkEnv->reqMethod = $_SERVER['REDIRECT_REQUEST_METHOD'];

// if request method is post, the respond should be a json object
if ($srkEnv->reqMethod == 'POST') {
	header("Content-Type: text/json");
}

// decide which route to use
if ($srkEnv->reqURLLength == 0 || 
	($srkEnv->reqURLLength == 1 && $srkEnv->reqURL[1] == 'home')) { // render homepage
	require_once($srkEnv->appPath.'/routes/home.php');
}
else {
	$routeList = Array('view', 'pen');
	foreach ($routeList as $route) {
		if ($srkEnv->reqURL[1] == $route) {
			require_once($srkEnv->appPath.'/routes/'.$route.'.php');
			break;
		}
	}
}
if (!isset($srkEnv->correctURL)) {
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('error', Array('error'=>Array('status'=>'404', 'stack'=>'Unused url')));
}

