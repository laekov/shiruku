<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/comment.php');

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
		require_once($srkEnv->appPath.'/modules/render.php');
		if ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] = 'recent') {
			srkSend((Object)Array('list'=>commentLoadRecent(8)));
		}
		elseif ($srkEnv->reqURLLength == 4 && $srkEnv->reqURL[3] = 'pen') {
			$penId = $srkEnv->reqURL[4];
			$retList = commentLoadAll($penId);
			srkSend((Object)Array('list'=>$retList));
		}
		elseif ($srkEnv->reqURLLength == 5 && $srkEnv->reqURL[3] == 'content') {
			$penId = $srkEnv->reqURL[4];
			$commentId = $srkEnv->reqURL[5];
			$contentFileName = $srkEnv->penPath.'/'.$penId.'/comment/'.$commentId.'/content.html';
			srkSend((Object)Array('content'=>commentLoadContent($penId, $commentId)));
		}
	}
}

