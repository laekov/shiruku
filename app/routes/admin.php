<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/user.php');
require_once($srkEnv->appPath.'/modules/pen.php');
require_once($srkEnv->appPath.'/modules/render.php');
require_once($srkEnv->appPath.'/modules/cache.php');

$srkEnv->pageTitle .= '.admin';

$user = new UserData;
if (isset($_POST['userId']) && isset($_POST['passwd'])) {
	$user->readUser($_POST['userId']);
	$authRes = $user->authenticate($_POST['passwd']);
	if ($authRes) {
		srkSend((Object)Array('error'=>$authRes));
		return;
	}
} else {
	$user->readUser($_SESSION['userId']);
}

if ($user->status != 'normal') {
	if ($srkEnv->reqMethod == 'GET') {
		srkRender('error', Array('error'=>Array('status'=>'403', 'stack'=>'Access denied')));
	} else {
		srkSend((Object)Array('error'=>'Access denied'));
	}
	return;
} elseif ($srkEnv->reqMethod == 'GET') {
	srkRender('admin', Array());
} elseif ($srkEnv->reqURL[2] == 'query') {
	if ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'access') {
		$access = $user->getField('accessList');
		if (isset($access)) {
			$res = Array();
			if (in_array('pen', $access)) {
				array_push($res, 'penlist');
				array_push($res, 'penedit');
			}
			if (in_array('invite', $access)) {
				array_push($res, 'invite');
			}
			srkSend((Object)Array('error'=>false, 'accessList'=>$res));
		} else {
			srkSend((Object)Array('error'=>'Access denied'));
		}
	}
} elseif ($srkEnv->reqURL[2] == 'pen') {
	if (!in_array('pen', $user->getField("accessList"))) {
		srkSend((Object)Array('error'=>'Access denied'));
	} elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'update') {
		$penId = $_POST['penId'];
		$penPath = $srkEnv->penPath.'/pen/'.$penId;
		$reqFileName = false;
		$reqText = false;
		$content = $_POST['content'];
		$configStr = fixJSONString($_POST['config']);
		$config = json_decode($configStr);
		if (!isset($_POST['config'])) {
			$config = false;
		} elseif ($config === null) {
			srkSend((Object)Array('error'=>'Illegal config file '));
		}
		if ($config) {
			$config->author = $_SESSION['userId'];
		}
		$updRes = penUpdate($penId, $config, $content);
		srkSend($updRes);
	} elseif ($srkEnv->reqURL[3] == 'remove') {
		$penId = $_POST['penId'];
		$penPath = $srkEnv->penPath."/".$penId;
		if (is_dir($penPath)) {
			srkLog($penPath);
			rmdirDFS($penPath);
			penListGenerate();
			srkSend((Object)Array('error'=>false));
		} else {
			srkSend((Object)Array('error'=>'No such pen'));
		}
	} elseif ($srkEnv->reqURLLength == 4 && $srkEnv->reqURL[3] == 'content') {
		$penId = $srkEnv->reqURL[4];
		$penPath = $srkEnv->penPath.'/'.$penId;
		$res = (Object)Array();
		$res->content = getFileContent($penPath.'/content.md');
		if ($res->content == -1) {
			$res->content = '';
		}
		$res->config = getFileContent($penPath.'/config.json');
		if ($res->config == -1) {
			$res->config = json_encode($srkContent->defaultPenConfig);
		}
		srkSend($res);
	} elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'genid') {
		$penId = '';
		do {
			$penId = randId(6);
		} while (is_dir($srkEnv->penPath.'/'.$penId));
		srkSend((Object)Array('id'=>$penId));
	}
} elseif ($srkEnv->reqURL[2] == 'invite') {
	if (!in_array('invite', $user->getField("accessList"))) {
		srkSend((Object)Array('error'=>'Access denied'));
	} elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'query') {
		$res = Array();
		$fileList = getDirCatalog($srkEnv->userPath);
		foreach ($fileList as $item) {
			if (substr($item, 0, 7) == 'invite_') {
				$inviteCode = substr($item, 7, -5);
				$inviteObj = json_decode(getFileContent($srkEnv->userPath.'/'.$item));
				$inviteObj->value = $inviteCode;
				array_push($res, $inviteObj);
			}
		}
		srkSend((Object)Array('list'=>$res));
	} elseif ($srkEnv->reqURLLength == 4 && $srkEnv->reqURL[3] == 'generate') {
		$count = (int)$srkEnv->reqURL[4];
		$defInfo = (Object)Array('used'=>false);
		if ($count > 0 && $count < 16) {
			for ($i = 0; $i < $count; ++ $i) {
				$code = '';
				do {
					$code = randId(16);
				} while (is_file($srkEnv->userPath.'/invite_'.$code.'.json'));
				$codeFileName = $srkEnv->userPath.'/invite_'.$code.'.json';
				takeDownJSON($codeFileName, $defInfo);
			}
		}
		srkSend((Object)Array('res'=>'Done'));
	}
} elseif ($srkEnv->reqURL[2] == 'file') {
	if (!in_array('file', $user->getField("accessList"))) {
		srkSend((Object)Array('error'=>'Access denied'));
	} elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'upload') {
		$fileName = $_POST['fileName'];
		$fileContent = uploadFileContentDecipher();
		if ($fileName && $fileContent) {
			$writeRes = takeDownString($fileName, $fileContent);
			srkSend((Object)Array('error'=>$writeRes));
		} else {
			srkSend((Object)Array('error'=>'Content error'));
		}
	} elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'hash') {
		$fileName = $_POST['fileName'];
		if ($fileName && is_file($fileName)) {
			srkSend((Object)Array('md5'=>md5_file($fileName)));
		} elseif ($fileName && !is_file($fileName)) {
			srkSend((Object)Array('md5'=>''));
		} else {
			srkSend((Object)Array('error'=>'File error'));
		}
	} elseif ($srkEnv->reqURLLength == 3 && $srkEnv->reqURL[3] == 'log') {
		srkStream($srkEnv->logFileName);
	}
}

