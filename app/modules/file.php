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

