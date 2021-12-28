<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/render.php');
require_once($srkEnv->appPath.'/modules/file.php');
require_once($srkEnv->appPath.'/modules/pen.php');
require_once($srkEnv->appPath.'/modules/like.php');

if ($srkEnv->reqURLLength >= 2) {
	if ($srkEnv->reqURL[2] == 'query' && $srkEnv->reqMethod == 'POST') {
		if ($srkEnv->reqURLLength == 3) {
			if ($srkEnv->reqURL[3] == 'catalog') {
				$penList = penListGet();
				$catalog = Array();
				foreach ($penList as $content) {
					if (matchFilter(json_decode(fixJSONString($_POST['filter'])), $content)) {
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
			} elseif ($srkEnv->reqURL[3] == 'content') {
				$config = penConfigLoad($penId);
				if ($config->visible === false) {
					$content = 'Invisible before log in';
				} elseif (gettype($config->visible) === 'string') {
					$content = $config->visible;
				} else {
					$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.md');
				}
				if ($content === -1) {
					$content = 'No pen content';
				}
				srkSend(Array('content'=>$content));
			}
			elseif ($srkEnv->reqURL[3] == 'preview') {
				$config = penConfigLoad($penId);
				if ($config->catalog == 'code') {
					$content = 'Code';
				} elseif (!$config->visible) {
					$content = 'Invisible before sign in';
				} elseif (gettype($config->visible) === 'string') {
					$content = $config->visible;
				} else {
					$content = getFileContent($srkEnv->penPath.'/'.$penId.'/content.md');
				}
				if ($content === -1) {
					$content = 'No pen preview';
				}
				else {
					$pos = strpos($content, "\n");
					if (!$pos) {
						$pos = strpos($content, "\r\n");
					}
					if ($pos > 64 || $pos === false) {
						$pos = 64;
					}
					if ($pos !== false) {
						$content = htmlspecialchars(substr($content, 0, $pos));
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
				$penList = penListGet();
				foreach ($penList as $content) {
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
	} elseif ($srkEnv->reqURL[2] == 'like' && $srkEnv->reqMethod == 'POST') {
		$like = new Like();
		if ($srkEnv->reqURLLength == 4) {
			$penId = $srkEnv->reqURL[4];
			$like->load($srkEnv->penPath.'/'.$penId);
		}
		elseif ($srkEnv->reqURLLength == 5) {
			$penId = $srkEnv->reqURL[4];
			$commentId = $srkEnv->reqURL[5];
			$like->load($srkEnv->penPath.'/'.$penId.'/comment/'.$commentId);
		}
		if ($srkEnv->reqURL[3] == 'query') {
			srkSend($like->query());
		}
		elseif (isset(Like::$actionMap[$srkEnv->reqURL[3]])) {
			$userId = $_SESSION['userId'];
			if (!$userId) {
				srkSend((Object)Array('error'=>'login'));
			}
			else {
				srkSend((Object)Array('error'=>$like->click($userId, Like::$actionMap[$srkEnv->reqURL[3]])));
			}
		}
	} elseif ($srkEnv->reqURL[2] == 'slides' && $srkEnv->reqURLLength == 3 && $srkEnv->reqMethod == 'GET') {
		$penId = $srkEnv->reqURL[3];
		$config = penConfigLoad($penId);
		if ($config->visible === false) {
			$errorstr = 'Invisible before log in';
		} elseif (gettype($config->visible) === 'string') {
			$errorstr = 'Access denied';
		} else {
			srkStream($srkEnv->penPath.'/'.$penId.'/slides.html');
			$errorstr = -1;
		}
		if ($errorstr !== -1) {
			srkRender('error', Array('error'=>Array('status'=>-1, 'stack'=>$errorstr)));
		}
	}
}

