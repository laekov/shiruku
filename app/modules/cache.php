<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');

// cache data in file

class FileCache {
	public $fileName = false;
	public function load($fileName) {
		global $srkEnv;
		$this->fileName = $srkEnv->cachePath.'/'.$fileName;
	}

	public function needUpdate() {
		global $srkEnv;
		if (!$this->fileName) {
			return true;
		}
		elseif (!is_file($this->fileName)) {
			return true;
		}
		else {
			return time() - filectime($this->fileName) > $srkEnv->cacheTime;
		}
	}
	public function read() {
		if (!is_file($this->fileName)) {
			return false;
		}
		else {
			return getFileContent($this->fileName);
		}
	}
	public function write($data) {
		global $srkEnv;
		if (!is_dir($srkEnv->cachePath)) {
			mkdir($srkEnv->cachePath);
		}
		return takeDownString($this->fileName, $data);
	}
};

