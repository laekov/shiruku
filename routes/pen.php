<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

function getDirCatlog($dirPath) {
	$ret = Array();
	$dir = opendir($dirPath);
	while (($content = readdir($dir)) != false) {
		if ($content != '.' && $content != '..') {
			array_push($ret, $content);
		}
	}
	closedir($dir);
	return $ret;
}

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
		if ($srkEnv->reqURLLength == 3) {
			if ($srkEnv->reqURL[3] == 'catlog') {
				$catlog = getDirCatlog($srkEnv->penPath);
				echo(json_encode(Array('catlog'=>$catlog)));
				$srkEnv->correctURL = true;
			}
		}
		elseif ($srkEnv->reqURLLength == 4) {
		}
	}
}
