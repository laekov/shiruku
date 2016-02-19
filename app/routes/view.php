<?php
if (!defined('srkVersion')) {
	exit(403);
}

if ($srkEnv->reqURLLength == 2) {
	$penId = $srkEnv->reqURL[2];
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('view', Array('penid'=>$penId));
	$srkEnv->pageTitle .= '.view '.$penId;
	if (is_file($srkEnv->penPath.'/'.$penId.'/content.html')) {
		require_once($srkEnv->appPath.'/modules/db.php');
		srkVisitCountUpdate($penId);
	}
}

