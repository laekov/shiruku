<?php
if (!defined('srkVersion')) {
	exit(403);
}

if ($srkEnv->reqMethod == 'GET') {
	$srkEnv->pageTitle .= '.list';
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('list', Array());
}

