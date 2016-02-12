<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/db.php');
require_once($srkEnv->appPath.'/modules/file.php');

class userData { 
	static public$matchExp = Array(
		'userId'=>'/^\w{4,15}$/',
		'passwd'=>'/^\w{4,15}$/', 
		'email'=>'/^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/',
		'nickname'=>'/^\w{4,15}$/',
		'invitecode'=>'/^\w{32,32}$/'
	);
	public $id = false;
	private $data = false;
	public $status = 'empty';
	public function readUser($userId) {
		global $srkEnv;
		$this->id = $userId;
		$confFileName = $srkEnv->userPath.'/'.$userId.'/info.json';
		if (is_file($confFileName)) {
			$info = getFileContent($confFileName);
			$this->data = json_decode($info);
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
			fwrite($configFile, json_encode($this->data));
			fclose($configFile);
			return false;
		}
	}

	public function register($id, $data) {
		global $srkEnv;
		$this->id = $id;
		if ($data['passwd'] != $data['repeatPasswd']) {
			return (Object)Array('res'=>'Passwords do not match', 'field'=>'passwd');
		}
		foreach (UserData::$matchExp as $key=>$exp) {
			if (preg_match($exp, $data[$key]) == 0) {
				$errText = 'Invalid '.$key.'(regular exp: '.$exp.')';
				return (Object)Array('res'=>$errText, 'field'=>$key);
			}
			else {
				$this->data->$key = $data[$key];
			}
		}
		if (is_dir($srkEnv->userPath.'/'.$id)) {
			return (Object)Array('res'=>'User exists', 'field'=>'userId');
		}
		$invitecodeFileName = $srkEnv->userPath.'/invite_'.$data['invitecode'].'.json';
		if (!is_file($invitecodeFileName)) {
			return (Object)Array('res'=>'Invalid invite code'.$invitecodeFileName, 'field'=>'invitecode');
		}
		$inviteCode = json_decode(getFileContent($invitecodeFileName));
		if ($inviteCode->used !== false) {
			return (Object)Array('res'=>'Illegal invite code', 'field'=>'invitecode');
		}
		$this->data->registerTime = time();
		$this->status = 'registered';
		return (Object)Array('res'=>false);
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
			return 'user does not exists';
		}
		else if ($pwd != $this->data->passwd) {
			return 'username and password does not match';
		}
		else {
			return false;
		}
	}
};

