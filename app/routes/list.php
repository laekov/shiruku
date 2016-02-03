<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

if ($srkEnv->reqMethod == 'GET') {
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('list', Array());
}

