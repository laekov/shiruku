<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/pen.php');

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
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
				echo(json_encode(Array('catalog'=>$catalog)));
				$srkEnv->correctURL = true;
			}
		}
		elseif ($srkEnv->reqURLLength == 4) {
			$penId = $srkEnv->reqURL[4];
			if (!is_dir($srkEnv->penPath.'/'.$penId)) {
				echo(json_encode(Array('error'=>'No such pen')));
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'content') {
				$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.html');
				if ($content === -1) {
					$content = 'No pen content';
				}
				echo(json_encode(Array('content'=>$content)));
				$srkEnv->correctURL = true;
			}
			elseif ($srkEnv->reqURL[3] == 'config') {
				$content = getFileContent($srkEnv->penPath.'/'.$penId.'/config.json');
				if ($content === -1) {
					echo(json_encode(Array('error'=>'No pen config file')));
				}
				else {
					echo($content);
				}
				$srkEnv->correctURL = true;
			}
		}
	}
}

