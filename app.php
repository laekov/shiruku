<?php

// decipher uri by / into an array
function decipherURI($uri) {
	$path = array();
	while (strlen($uri)) {
		$pos = strpos($uri, '/');
		if ($pos === false) {
			$pos = strlen($uri);
		}
		$curlev = substr($uri, 0, $pos);
		array_push($path, $curlev);
		$uri = substr($uri, $pos + 1);
	}
	return $path;
}

require_once('./env.php');

$_SERVER['REDIRECT_STATUS'] = 0;
$srkEnv->reqURL = decipherURI($_SERVER['REQUEST_URI']);

// decide which route to use
if (count($srkEnv->reqURL) == 1 || 
	(count($srkEnv->reqURL) == 2 && $srkEnv->reqURL[1] == 'home')) {
	require_once($srkEnv->appPath.'/routes/home.php');
}
 
