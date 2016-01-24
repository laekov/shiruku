<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

// render main
// target file is based on directory '/views/'
function srkRender($srkEnv, $targetFile) {
	array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/global.css');
	array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/div.css');
	array_push($srkEnv->javascripts, '/javascripts/jquery_min.js');
	require_once($srkEnv->viewsPath.'/htmlhead.php');
	require_once($srkEnv->viewsPath.'/pagehead.php');
	require_once($srkEnv->viewsPath.'/'.$targetFile);
	require_once($srkEnv->viewsPath.'/pagefoot.php');
}
