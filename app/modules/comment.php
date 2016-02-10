<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');

// comment config file loader
function commentLoadConfig($penId, $commentId) {
	global $srkEnv;
	$pathName = $srkEnv->penPath.'/'.$penId.'/comment/'.$commentId;
	$cfgContent = getFileContent($pathName.'/config.json');
	$res = Array();
	if ($res === -1) {
		return -1;
	}
	else {
		$res = json_decode($cfgContent);
		$res->penId = $penId;
		$res->commentId = $commentId;
		if (!isset($res->modifyTime)) {
			$res->modifyTime = filectime($pathName.'/config.json');
		}
		if (!isset($res->priority)) {
			$res->priority = $res->modifyTime;
		}
		unset($res->sendIP);
		return $res;
	}
}

// load both config and content
function commentLoadContent($penId, $commentId) {
	global $srkEnv;
	$res = commentLoadConfig($penId, $commentId);
	$contentFileName = $srkEnv->penPath.'/'.$penId.'/comment/'.$commentId.'/content.html';
	$res->content = getFileContent($contentFileName);
	return $res;
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
			$item = commentLoadConfig($penId, $commentId);
			if ($item !== false) {
				array_push($list, $item);
			}
		}
		return $list;
	}
}

// compare two objects by time
function cmpByTime($a, $b) {
	return $a->modifyTime < $b->modifyTime ? 1 : -1;
}

// load recent comments of a pen 
function commentLoadRecent($limit) {
	global $srkEnv;
	$res = Array();
	$fileList = getDirCatlog($srkEnv->penPath);
	foreach ($fileList as $penId) {
		$penCom = commentLoadAll($penId);
		foreach ($penCom as $com) {
			array_push($res, $com);
			if (count($res) > $limit) {
				usort($res, "cmpByTime");
				while (count($res) > $limit) {
					array_pop($res);
				}
			}
		}
	}
	usort($res, "cmpByTime");
	return $res;
}

