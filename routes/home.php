<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/render.php');

srkRender($srkEnv, 'home.php');

