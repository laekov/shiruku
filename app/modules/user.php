<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/db.php');
require_once($srkEnv->appPath.'/modules/file.php');

class UserData { 
	static public $matchExp = Array(
		'userId'=>'/^\w{4,15}$/',
		'passwd'=>'/^\w{4,15}$/', 
		'email'=>'/^[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+$/',
		'nickname'=>'/^\w{1,16}$/',
		'invitecode'=>'/^\w{8,32}$/'
	);
	public $id = false;
	private $data = false;
	public $status = 'empty';

	public function getEmailFileName($email) {
		global $srkEnv;
		return $srkEnv->userPath.'/email_'.md5($email).'.json';
	}
	private function getMyEmailFileName() {
		if (!isset($this->data->email) || !(strlen($this->data->email) > 0)) {
			return false;
		}
		else {
			return self::getEmailFileName($this->data->email);
		}
	}

	public function readUser($userId) {
		global $srkEnv;
		if (!is_string($userId)) {
			return;
		}
		elseif (preg_match(self::$matchExp['userId'], $userId)) {
			$this->id = $userId;
		}
		elseif (preg_match(self::$matchExp['email'], $userId)) {
			$emailFileName = self::getEmailFileName($userId);
			if (is_file($emailFileName)) {
				$idInfo = json_decode(getFileContent($emailFileName));
				$this->id = $idInfo->owner;
			}
			else {
				$this->status = 'no email';
				return;
			}
		}
		else {
			$this->status = 'not id';
			return;
		}
		$confFileName = $srkEnv->userPath.'/'.$this->id.'/config.json';
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
		if (!in_array($this->status, Array('normal', 'registered'))) {
			return 'Invalid data';
		}
		$userPath = $srkEnv->userPath.'/'.$this->id;
		if ($this->status == 'registered') {
			$emailFileName = $this->getMyEmailFileName();
			if ($emailFileName !== false) {
				takeDownJSON($emailFileName, (Object)Array('owner'=>$this->id));
			}
			if (isset($this->data->invitecode)) {
				$invitecodeFileName = $srkEnv->userPath.'/invite_'.$this->data->invitecode.'.json';
				$invitecode = json_decode(getFileContent($invitecodeFileName));
				$invitecode->used = true;
				$invitecode->owner = $this->id;
				takeDownJSON($invitecodeFileName, $invitecode);
				unset($this->data->invitecode);
			}
			mkdir($userPath);
			$this->status = 'normal';
		}
		return takeDownJSON($userPath.'/config.json', $this->data);
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
		if (is_file(self::getEmailFileName($data['email']))) {
			return (Object)Array('res'=>'Email exists', 'field'=>'email');
		}
		$invitecodeFileName = $srkEnv->userPath.'/invite_'.$data['invitecode'].'.json';
		if (!is_file($invitecodeFileName)) {
			return (Object)Array('res'=>'Invalid invite code', 'field'=>'invitecode');
		}
		$inviteCode = json_decode(getFileContent($invitecodeFileName));
		if ($inviteCode->used !== false) {
			return (Object)Array('res'=>'Illegal invite code', 'field'=>'invitecode');
		}
		$this->data->registerTime = time();
		$this->data->source = 'local';
		$this->status = 'registered';
		return (Object)Array('res'=>false);
	}
	public function registerThirdParty($data) {
		global $srkEnv;
		$this->data = $data;
		$this->id = $data->userId;
		if (is_dir($srkEnv->userPath.'/'.$this->id)) {
			$this->status = 'normal';
		}
		else {
			$this->data->registerTime = time();
			$this->status = 'registered';
		}
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

