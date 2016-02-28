<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');

class Like {
	static public $actionMap = Array(
		'for'=>1,
		'against'=>-1
	);
	static public $defaultData = Array(
		'like'=>0,
		'dislike'=>0,
		'list'=>Array()
	);
	public $status = 'empty';
	private $data;
	private $fileName;
	public function load($pathName) {
		$this->fileName = $pathName.'/like.json';
		if (is_file($this->fileName)) {
			$this->data = json_decode(getFileContent($this->fileName));
			if ($this->data !== null) {
				if (is_object($this->data->list)) {
					$this->data->list = (Array)$this->data->list;
				}
				$this->status = 'normal';
			}
		}
		else {
			$this->data = (Object)self::$defaultData;
			$this->status = 'normal';
		}
		return $this->status !== 'normal';
	}
	private function write() {
		if ($this->status == 'normal') {
			return takeDownJSON($this->fileName, $this->data);
		}
		else {
			return 'Like writing error';
		}
	}

	public function update() {
		if ($this->status == 'normal') {
			$this->data->like = 0;
			$this->data->dislike = 0;
			foreach ($this->data->list as $vote) {
				if ($vote > 0) {
					$this->data->like += $vote;
				}
				else {
					$this->data->dislike -= $vote;
				}
			}
		}
	}

	public function query() {
		if ($this->status == 'normal') {
			return (Object)Array(
				'like'=>$this->data->like,
				'dislike'=>$this->data->dislike
			);
		}
		else {
			return false;
		}
	}
	public function click($userId, $value) {
		global $srkEnv;
		if (!is_int($value) || abs($value) != 1) {
			return 'Illegal value';
		}
		elseif ($this->status == 'normal') {
			if (!isset($this->data->list[$userId])) {
				$this->data->list[$userId] = $value;
			}
			elseif (abs($this->data->list[$userId] + $value) > $srkEnv->maxLike) {
				return 'You click too much';
			}
			else {
				$this->data->list[$userId] += $value;
			}
			$this->update();
			return $this->write();
		}
		else {
			return 'What do you like?';
		}
	}
};

