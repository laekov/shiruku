<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

$renderArgs = Array();

// send main
// return a json file to the query
// usually used to respond to a POST query
function srkSend($data) {
	ob_clean();
	echo(json_encode($data));
}

// render main
// target file is based on directory '/views/'
function srkRender($targetFile, $cusRenderArgs) {
	global $srkEnv, $renderArgs;
	$renderArgs = $cusRenderArgs;
	// common javascripts and stylesheets
	array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/global.css');
	array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/div.css');
	array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/text.css');
	array_push($srkEnv->javascripts, '/javascripts/cdn/jquery_min.js');
	array_push($srkEnv->javascripts, '/javascripts/cdn/jquery.cookie.js');

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
}

