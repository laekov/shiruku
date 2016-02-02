<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/pen.php');

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
		require_once($srkEnv->appPath.'/modules/render.php');
		if ($srkEnv->reqURLLength == 3) {
			if ($srkEnv->reqURL[3] == 'catalog') {
				$fileList = getDirCatlog($srkEnv->penPath);
				$catalog = Array();
				foreach ($fileList as $penId) {
					$content = penConfigLoad($penId);
					if (matchFilter(json_decode($_POST['filter']), $content)) {
						array_push($catalog, $content);
					}
				}
				srkSend(Array('catalog'=>$catalog));
				$srkEnv->correctURL = true;
			}
		}
		elseif ($srkEnv->reqURLLength == 4) {
			$penId = $srkEnv->reqURL[4];
			if (!is_dir($srkEnv->penPath.'/'.$penId)) {
				srkSend(Array('error'=>'No such pen'));
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'content') {
				$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.html');
				if ($content === -1) {
					$content = 'No pen content';
				}
				srkSend(Array('content'=>$content));
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'config') {
				$config = penConfigLoad($penId);
				srkSend($config);
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'neighbor') {
				$config = penConfigLoad($penId);
				$prev = (Object)Array('priority'=>-0x7fffffff);
				$succ = (Object)Array('priority'=>0x7ffffffe);
				$fileList = getDirCatlog($srkEnv->penPath);
				foreach ($fileList as $penId) {
					$content = penConfigLoad($penId);
					if ($content->priority < $config->priority && $content->priority > $prev->priority) {
						$prev = $content;
					}
					if ($content->priority > $config->priority && $content->priority < $succ->priority) {
						$succ = $content;
					}
				}
				srkSend((Object)Array('prev'=>$prev->penId, 'succ'=>$succ->penId));
				$srkEnv->correctURL = true;
			}
		}
	}
}

