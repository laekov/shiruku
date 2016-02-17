<?php
if (!defined('srkVersion')) {
	exit(403);
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
			}
		}
		elseif ($srkEnv->reqURLLength == 4) {
			$penId = $srkEnv->reqURL[4];
			if (!is_dir($srkEnv->penPath.'/'.$penId)) {
				srkSend(Array('error'=>'No such pen'));
			}
			elseif ($srkEnv->reqURL[3] == 'content') {
				$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.md');
				if ($content === -1) {
					$content = 'No pen content';
				}
				srkSend(Array('content'=>$content));
			}
			elseif ($srkEnv->reqURL[3] == 'preview') {
				$config = penConfigLoad($penId);
				if ($config->catalog == 'code') {
					$content = 'Code';
				}
				else {
					$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.md');
				}
				if ($content === -1) {
					$content = 'No pen preview';
				}
				else {
					$pos = strpos($content, "\n\n");
					if (!$pos) {
						$pos = strpos($content, "\n\r\n");
					}
					if ($pos != false) {
						$content = substr($content, 0, $pos);
						$content .= "<br/>...";
					}
				}
				srkSend(Array('content'=>$content, 'penId'=>$penId));
			}
			elseif ($srkEnv->reqURL[3] == 'config') {
				$config = penConfigLoad($penId);
				srkSend($config);
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
			}
		}
	}
}

