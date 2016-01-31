<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

array_push($srkEnv->javascripts, '/javascripts/list.js');
array_push($srkEnv->stylesheets, '/stylesheets/list.css');
require_once($srkEnv->viewsPath.'/indicator_config.php');
