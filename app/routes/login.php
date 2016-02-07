<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/user.php');

if ($srkEnv->reqURLLength == 1) {
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('loginpage');
}
else if ($srkEnv->reqURLLength == 2 && $srkEnv->reqURL[2] == 'auth') {
	require_once($srkEnv->appPath.'/modules/render.php');
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

