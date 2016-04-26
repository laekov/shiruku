<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/comment.php');
require_once($srkEnv->appPath.'/modules/user.php');
require_once($srkEnv->appPath.'/modules/render.php');

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
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
			srkSend((Object)Array(
				'content'=>commentLoadContent($penId, $commentId),
				'commentId'=>$commentId
			));
		}
	}
	elseif ($srkEnv->reqURLLength == 2 && $srkEnv->reqURL[2] == 'post' && $srkEnv->reqMethod == 'POST') {
		$user = new UserData;
		$user->readUser($_SESSION['userId']);
		if ($user->status != 'normal') {
			srkSend((Object)Array('error'=>'Please log in first'));
		}
		else {
			if (($err = commentPost($user))) {
				if (is_string($err)) {
					srkSend((Object)Array('error'=>$err));
				}
				else {
					srkSend((Object)Array('error'=>"System error"));
				}
			}
			else {
				srkSend((Object)Array('error'=>false));
			}
		}
	}
}

