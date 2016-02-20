<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/cache.php');

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
	$contentFileName = $srkEnv->penPath.'/'.$penId.'/comment/'.$commentId.'/content.html';
	return getFileContent($contentFileName);
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
		$cata = getDirCatalog($pathName);
		foreach ($cata as $commentId) {
			$item = commentLoadConfig($penId, $commentId);
			if ($item !== false) {
				array_push($list, $item);
			}
		}
		return $list;
	}
}

// generate cache list
function commentListGenerate() {
	global $srkEnv;
	$res = Array();
	$fileList = getDirCatalog($srkEnv->penPath);
	foreach ($fileList as $penId) {
		$penCom = commentLoadAll($penId);
		foreach ($penCom as $com) {
			array_push($res, $com);
		}
	}
	$cacheFile = new FileCache;
	$cacheFile->load('commentlist.json');
	$cacheFile->write(json_encode($res));
	return $res;
}

// get comment list
function commentListGet() {
	$cacheFile = new FileCache;
	$cacheFile->load('commentlist.json');
	if ($cacheFile->needUpdate()) {
		return commentListGenerate();
	}
	else {
		return json_decode($cacheFile->read());
	}
}

// compare two objects by time
function cmpByTime($a, $b) {
	return $a->modifyTime < $b->modifyTime ? 1 : -1;
}

// load recent comments of a pen 
function commentLoadRecent($limit) {
	global $srkEnv;
	$list = commentListGet();
	$res = Array();
	foreach ($list as $comment) {
		array_push($res, $comment);
		if (count($res) > $limit) {
			usort($res, "cmpByTime");
			while (count($res) > $limit) {
				array_pop($res);
			}
		}
	}
	usort($res, "cmpByTime");
	return $res;
}

// post a comment
function commentPost($user) {
	global $srkEnv;
	$penCommentPath = $srkEnv->penPath.'/'.$_POST['penId'].'/comment';
	if (!is_dir($penCommentPath)) {
		mkdir($penCommentPath);
	}
	$commentId = '';
	do {
		$commentId = randId(8);
	} while (is_dir($penCommentPath.'/'.$commentId));
	$commentPath = $penCommentPath.'/'.$commentId;
	mkdir($commentPath);
	takeDownString($commentPath.'/content.html', $_POST['content']);
	$config = (Object)Array(
		'commentId'=>$commentId,
		'owner'=>$user->getField('userId'),
		'modifyTime'=>time()
	);
	takeDownJSON($commentPath.'/config.json', $config);
	commentListGenerate();
	return false;
}

