<?php

if (!class_exists("ZipArchive")) {
	echo "No zip archieve class";
	exit(1);
}
else {
	echo "Has class";
}

$rootPath = "../../myfolder";
$targetPath = "pack.zip";

$zipFile = new ZipArchive();
if (!$zipFile->open($targetPath, ZipArchive::CREATE)) {
	echo "File failed";
	exit(1);
}

function enumDir($path) {
	global $rootPath;
	global $zipFile;
	$truePath = substr($path, strlen($rootPath) - 1);
	if (is_file($path)) {
		if ($zipFile->addFile($path, $truePath)) {
			echo "Add ".$path." successful<br/>\n";
		}
		else {
			echo "Add ".$path." failed<br/>\n";
		}
	}
	elseif (is_dir($path)) {
		$zipFile->addEmptyDir($truePath);
		$dir = opendir($path);
		while (($item = readdir($dir))) {
			if ($item != '.' && $item != '..') {
				enumDir($path.'/'.$item);
			}
		}
		closedir($dir);
	}
}

enumDir($rootPath);

echo "Finished";

$zipFile->close();

