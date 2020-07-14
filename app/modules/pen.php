<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/cache.php');

// pen config file loader
function penConfigLoad($penId) {
	global $srkEnv;
	$fileName = $srkEnv->penPath.'/'.$penId.'/config.json';
	$cfgContent = getFileContent($fileName);
	if ($cfgContent === -1) {
		$ret = (Object)Array('error'=>'No config file');
	} else {
		$ret = json_decode($cfgContent);
	}
	if (!isset($ret->error)) {
		if (!isset($ret->penId)) {
			$ret->penId = $penId;
		}
		if (!isset($ret->title)) {
			$ret->title = $penId;
		}
		if (!isset($ret->modifyTime)) {
			$ret->modifyTime = filectime($fileName);
		}
		if (!isset($ret->priority)) {
			$ret->priority = $ret->modifyTime;
		}
		if (isset($ret->access) && $ret->access === 'login' && !isset($_SESSION['userId'])) {
			$ret->visible = false;
		} elseif ($ret->catalog === 'diary' && 
			(!isset($_SESSION['userId']) || $_SESSION['userId'] != $ret->author)) {
			$ret->visible = '日记是给自己看的.';
		} else {
			$ret->visible = true;
		}
		require_once($srkEnv->appPath.'/modules/db.php');
		$ret->visitCount = srkVisitCountGet($ret->penId);
	}
	return $ret;
}

function matchFilter($filter, $content) {
	if (isset($filter->gt)) {
		foreach ($filter->gt as $key=>$val) {
			if (!isset($content->$key) || $content->$key <= $val) {
				return false;
			}
		}
	}
	if (isset($filter->lt)) {
		foreach ($filter->lt as $key=>$val) {
			if (!isset($content->$key) || $content->$key >= $val) {
				return false;
			}
		}
	}
	if (isset($filter->equal)) {
		foreach ($filter->equal as $key=>$val) {
			if (!isset($content->$key) || $content->$key != $val) {
				return false;
			}
		}
	}
	if (isset($filter->inArray)) {
		foreach ($filter->inArray as $key=>$val) {
			if (!isset($content->$key) || !in_array($val, $content->$key)) {
				return false;
			}
		}
	}
    if (isset($filter->vague)) {
        foreach ($filter->vague as $val) {
            if (is_array($content->tag) && in_array($val, $content->tag)) {
                return true;
            }
            if (strpos($content->title, $val) !== false) {
                return true;
            }
            $text = getFileContent($srkEnv->penPath.$content->penId.'/content.md');
            if (strpos($text, $val) !== false) {
                return true;
            }
        }
        return false;
    }
	return true;
}

function penListGenerate() {
	global $srkEnv;
	$res = Array();
	$list = getDirCatalog($srkEnv->penPath);
	foreach ($list as $penId) {
		if (is_file($srkEnv->penPath.'/'.$penId.'/config.json')) {
			$penConf = penConfigLoad($penId);
			array_push($res, $penConf);
		}
	}
	$listCache = new FileCache;
	$listCache->load('penlist.json');
	$listCache->write(json_encode($res));
	return $res;
}

function penListGet() {
	global $srkEnv;
	$listCache = new FileCache;
	$listCache->load('penlist.json');
	if ($listCache->needUpdate()) {
		return penListGenerate();
	} else {
		return json_decode($listCache->read());
	}
}

function penUpdate($penId, $penConfig, $penContent) {
	global $srkEnv;
	$penPath = $srkEnv->penPath.'/'.$penId;
	$err = false;
	$res = '';
	if (!is_dir($penPath)) {
		mkdir($penPath);
	}
	if ($penConfig) {
		$penConfig->penId = $penId;
		if (!isset($penConfig->title)) {
			$penConfig->title = $penId;
		}
		if (!isset($penConfig->modifyTime)) {
			$penConfig->modifyTime = time();
		}
		if (takeDownJSON($penPath.'/config.json', $penConfig)) {
			$err = true;
			$res .= 'Failed to write config file<br/>';
		} else {
			$res .= 'Config file updated<br/>';
		}
	} else {
		$penConfig = penConfigLoad($penId);
	}
	if ($penContent) {
		$contentPath = $penPath.'/content.md';
		if (takeDownString($contentPath, $penContent)) {
			$err = true;
			$res .= 'Failed to write content file ';
		} else {
			$res .= 'Content file updated<br/>';
			if ($penConfig->catalog == 'slides') {
				require_once($srkEnv->appPath.'/modules/slides.php');
				$slidesPath = $penPath.'/slides.html';
				generateSlides($contentPath, $slidesPath);
				$res .= 'Slides generated<br/>';
			}
		}
	}
	penListGenerate();
	if ($err) {
		return (Object)Array('error'=>$res, 'res'=>'error');
	} else {
		return (Object)Array('error'=>$err, 'res'=>$res);
	}
}

// check if it is a valid pen
function isPen($penId) {
	global $srkEnv;
	if (is_string($penId)) {
		return is_dir($srkEnv->penPath.'/'.$penId);
	} else {
		return false;
	}
}
