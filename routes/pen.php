<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

// create a list of a directory
// used to response pen list request
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

// read the whole file into a string
function getFileContent($fileName) {
	global $srkEnv;
	if (is_file($fileName)) {
		$file = fopen($fileName, 'r');
		$ret = fread($file, $srkEnv->maxFileSize);
		fclose($file);
		return $ret;
	}
	else {
		return -1;
	}
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
			$penId = $srkEnv->reqURL[4];
			if (!is_dir($srkEnv->penPath.'/'.$penId)) {
				echo(json_encode(Array('error'=>'No such pen')));
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'content') {
				$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.html');
				if ($content === -1) {
					$content = 'No pen content';
				}
				echo(json_encode(Array('content'=>$content)));
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'config') {
				$content = getFileContent($srkEnv->penPath.'/'.$penId.'/config.json');
				if ($content === -1) {
					echo(json_encode(Array('error'=>'No pen config file')));
				}
				else {
					echo($content);
				}
				$srkEnv->correctURL = true;
			}
		}
	}
}

