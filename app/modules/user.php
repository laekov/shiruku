<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/db.php');
require_once($srkEnv->appPath.'/modules/file.php');

class userMod { 
	public $id = false;
	private $data = false;
	public $status = 'empty';
	public function readUser($userId) {
		global $srkEnv;
		$this->id = $userId;
		$info = getFileContent($srkEnv->userPath.'/'.$userId.'/info.json');
		if ($info !== false) {
			$this->data = json_encode($info);
			$this->status = 'normal';
		}
		else {
			$this->status = 'no data';
		}
	}
	public function writeUser() {
		global $srkEnv;
		if ($this->status != 'normal' && $this->status != 'registered') {
			$userPath = $srkEnv->userPath.'/'.$this->id;
			if ($this->status == 'register') {
				if (is_dir($userPath)) {
					return 'User exists';
				}
				else {
					mkdir($userPath);
				}
			}
		}
		$configFile = fopen($userPath.'/config.json', 'w');
		if ($configFile === false) {
			return 'Config file error';
		}
		else {
			fwrite($configFile, json_encode($this->data);
			fclose($configFile);
			return false;
		}
	}

	public function register($id, $data) {
		$this->id = $id;
		$this->data = $data;
		$this->data->userId = $id;
		$this->status = 'registered';
	}
	public function getField($field) {
		if ($this->status != 'normal') {
			return false;
		}
		elseif ($field == 'passwd') {
			return 'Access denied';
		}
		else {
			return $this->data->$field;
		}
	}
	public function authenticate($pwd) {
		if ($this->status != 'normal') {
			return false;
		}
		else {
			return $pwd == $this->data->passwd;
		}
	}
};

