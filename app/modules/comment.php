<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/file.php');

// comment config file loader
function commentLoad($penId, $commentId) {
	global $srkEnv;
	$pathName = $srkEnv->penPath.'/'.$penId.'/comment/'.$commentId;
	$cfgContent = getFileContent($pathName.'/config.json');
	$res = Array();
	if ($res === -1) {
		return -1;
	}
	else {
		$res = json_decode($cfgContent);
		if (!isset($res->modifyTime)) {
			$res->modifyTime = filectime($pathName.'/config.json');
		}
		if (!isset($res->priority)) {
			$res->priority = $res->modifyTime;
		}
		unset($res->sendIP);
		$res->content = getFileContent($pathName.'/content.html');
		return $res;
	}
}

// Load all comments of a pen
function commentLoadAll($penId) {
	global $srkEnv;
	$pathName = $srkEnv->penPath.'/'.$penId.'/comment';
	if (!is_dir($pathName)) {
		return Array();
	}
	else {
		$list = Array();
		$cata = getDirCatlog($pathName);
		foreach ($cata as $commentId) {
			$item = commentLoad($penId, $commentId);
			if ($item !== false) {
				array_push($list, $item);
			}
		}
		return $list;
	}
}

