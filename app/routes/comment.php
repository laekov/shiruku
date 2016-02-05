<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/comment.php');

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
		require_once($srkEnv->appPath.'/modules/render.php');
		if ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] = 'recent') {
			srkSend((Object)Array('list'=>commentLoadRecent(16)));
		}
		elseif ($srkEnv->reqURLLength == 4 && $srkEnv->reqURL[3] = 'pen') {
			$penId = $srkEnv->reqURL[4];
			$retList = commentLoadAll($penId);
			srkSend((Object)Array('list'=>$retList));
		}
	}
}

