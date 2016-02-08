<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/user.php');
require_once($srkEnv->appPath.'/modules/render.php');

if ($srkEnv->reqURLLength == 1) {
	srkRender('loginpage');
}
elseif ($srkEnv->reqURLLength >= 2 && $srkEnv->reqURL[2] == 'auth') {
	if ($srkEnv->reqURLLength == 2) {
		$userId = $_POST['userId'];
		$passwd = $_POST['passwd'];
		$user = new userData;
		$user->readUser($userId);
		$authRes = $user->authenticate($passwd);
		if ($authRes === false) {
			$_SESSION['userId'] = $userId;
			srkSend((Object)Array('res'=>'successful'));
		}
		else {
			srkSend((Object)Array('res'=>$authRes));
		}
	}
	elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'logout') {
		unset($_SESSION['userId']);
		srkSend((Object)Array('res'=>'successful'));
	}
}
elseif ($srkEnv->reqURLLength >= 2 && $srkEnv->reqURL[2] == 'query') {
	if ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'whoami') {
		$userId = $_SESSION['userId'];
		if (!isset($userId)) {
			srkSend((Object)Array('Error'=>'not logged in'));
		}
		else {
			srkSend((Object)Array('userId'=>$userId));
		}
	}
}
