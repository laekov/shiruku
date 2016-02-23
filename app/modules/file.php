<?php
if (!defined('srkVersion')) {
	exit(403);
}

// create a list of a directory
// used to response pen list request
function getDirCatalog($dirPath) {
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

// write an object to a json file
function takeDownJSON($fileName, $content) {
	$outFile = fopen($fileName, 'w');
	if ($outFile) {
		fputs($outFile, json_encode($content));
		fclose($outFile);
		return false;
	}
	else {
		return true;
	}
}

// write a string to a file 
function takeDownString($fileName, $content) {
	$outFile = fopen($fileName, 'w');
	if ($outFile) {
		fputs($outFile, $content);
		fclose($outFile);
		return false;
	}
	else {
		return true;
	}
}

function chr2hex($c) {
	$d = ord($c);
	if ($d >= 48 && $d <= 57) {
		return $d - 48;
	}
	elseif ($d >= 65 && $d <= 70) {
		return $d - 55;
	}
	else {
		return -1;
	}
}

// get a uploaded file content from _POST
function uploadFileContentDecipher() {
	$inputStr = $_POST['fileString'];
	if (!is_string($inputStr)) {
		return false;
	}
	$res = '';
	if ($_POST['encipherType'] == 'srk0x') {
		$inputLen = strlen($inputStr);
		if ($inputLen & 1) {
			return false;
		}
		for ($i = 0; $i < $inputLen; $i += 2) {
			$res .= chr((chr2hex($inputStr[$i]) << 4) | chr2hex($inputStr[$i + 1]));
		}
	}
	return $res;
}

