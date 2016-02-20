<?php
if (!defined('srkVersion')) {
	exit(403);
}

if ($srkEnv->reqURLLength == 2) {
	$penId = $srkEnv->reqURL[2];
	$srkEnv->pageTitle .= '.view '.$penId;
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('view', Array('penid'=>$penId));
	if (is_file($srkEnv->penPath.'/'.$penId.'/content.md')) {
		require_once($srkEnv->appPath.'/modules/db.php');
		srkVisitCountUpdate($penId);
	}
}

