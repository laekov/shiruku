<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

$renderArgs = Array();

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

	if (is_file($srkEnv->viewsPath.'/'.$targetFile.'_config.php')) {
		require_once($srkEnv->viewsPath.'/'.$targetFile.'_config.php');
	}
	require_once($srkEnv->viewsPath.'/htmlhead.php');
	if (!$renderArgs['noPageHead']) {
		require_once($srkEnv->viewsPath.'/pagehead.php');
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

