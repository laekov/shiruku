<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/user.php');
require_once($srkEnv->appPath.'/modules/pen.php');
require_once($srkEnv->appPath.'/modules/render.php');

$user = new UserData;
$user->readUser($_SESSION['userId']);
if ($user->status != 'normal') {
	header('Location: /login');
	return;
}
elseif ($srkEnv->reqMethod == 'GET') {
	srkRender('admin');
}
elseif ($srkEnv->reqURL[2] == 'pen') {
	if (!in_array('pen', $user->data->access)) {
		srkSend((Object)Array('error'=>'Access denied'));
	}
	elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'update') {
		$penId = $_POST['penId'];
		$penPath = $srkEnv->penPath.'/pen/'.$penId;
		$reqFileName = false;
		$reqText = false;
		$content = $_POST['content'];
		$config = json_decode($_POST['config']);
		if (!isset($_POST['config'])) {
			$config = false;
		}
		elseif ($config === null) {
			srkSend((Object)Array('error'=>'Illegal config file');
		}
		$updRes = penUpdate($penId, $config, $content);
		srkSend($updRes);
	}
	elseif ($srkEnv->reqURL[3] == 'remove') {
		$penId = $_POST['penId'];
		$penPath = $srkEnv->penPath.'/pen/'.$penId;
	}
}

