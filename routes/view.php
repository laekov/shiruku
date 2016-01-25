<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

if ($srkEnv->reqURLLength == 3) {
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('view', Array('penid'=>$srkEnv->reqURL[2]));
	$srkEnv->correctURL = true;
}

