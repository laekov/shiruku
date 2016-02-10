<?php
if (!defined('srkVersion')) {
	exit(403);
}

if ($srkEnv->reqMethod == 'GET') {
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('list', Array());
}

