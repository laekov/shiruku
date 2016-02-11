<?php
if (!defined('srkVersion')) {
	exit(403);
}

$renderArgs = Array();

// stream main
// send a file
function srkStream($fileName) {
	global $srkEnv;
	ob_clean();
	if (!isset($srkEnv->sent)) {
		ob_clean();
		readfile($fileName);
		$srkEnv->sent = true;
	}
}

// send main
// return a json file to the query
// usually used to respond to a POST query
function srkSend($data) {
	global $srkEnv;
	if (!isset($srkEnv->sent)) {
		ob_clean();
		header("Content-Type: text/json");
		echo(json_encode($data));
		$srkEnv->sent = true;
	}
}

// render main
// target file is based on directory '/views/'
function srkRender($targetFile, $cusRenderArgs) {
	global $srkEnv, $srkContent, $renderArgs;
	if (isset($srkEnv->sent)) {
		return;
	}
	elseif ($targetFile != 'error') {
		require_once($srkEnv->appPath.'/modules/db.php');
		srkVisitCountUpdate("shiruku_site_total");
	}
	$renderArgs = $cusRenderArgs;
	if (is_file($srkEnv->viewsPath.'/'.$targetFile.'_config.php')) {
		require_once($srkEnv->viewsPath.'/'.$targetFile.'_config.php');
	}
	foreach ($srkEnv->dependViews as $req) {
		if (is_file($srkEnv->viewsPath.'/'.$req.'_config.php')) {
			require_once($srkEnv->viewsPath.'/'.$req.'_config.php');
		}
	}
	require_once($srkEnv->viewsPath.'/htmlhead.php');
	if (!$renderArgs['noPageHead']) {
		require_once($srkEnv->viewsPath.'/pagehead.php');
	}
	foreach ($srkEnv->dependViews as $req) {
		if (is_file($srkEnv->viewsPath.'/'.$req.'.php')) {
			require_once($srkEnv->viewsPath.'/'.$req.'.php');
		}
	}
	if (is_file($srkEnv->viewsPath.'/'.$targetFile.'.php')) {
		require_once($srkEnv->viewsPath.'/'.$targetFile.'.php');
	}
	else {
		$renderArgs['error'] = Array('error'=>Array('status'=>'404', 'stack'=>'Render error: no ui file avaliable'));
		require_once($srkEnv->viewsPath.'/error.php');
	}
	require_once($srkEnv->viewsPath.'/pagefoot.php');
	$srkEnv->sent = true;
}

