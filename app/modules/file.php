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
