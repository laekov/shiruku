<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/file.php');

// pen config file loader
function penConfigLoad($penId) {
	global $srkEnv;
	$fileName = $srkEnv->penPath.'/'.$penId.'/config.json';
	$cfgContent = getFileContent($fileName);
	if ($cfgContent === -1) {
		$ret = (Object)Array('error'=>'No config file');
	}
	else {
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
	if (isset($filter->in)) {
		foreach ($filter->in as $key=>$val) {
			if (!isset($content->$key) || in_array($val, $content->$key)) {
				return false;
			}
		}
	}
	return true;
}

