<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

if ($srkEnv->reqURLLength == 3) {
	require_once($srkEnv->appPath.'/modules/render.php');
	if ($srkEnv->reqURL[2] == 'query') {
		require_once($srkEnv->appPath.'/modules/file.php');
		$resId = $srkEnv->reqURL[3];
		if (is_dir($srkEnv->resPath.'/'.$resId)) {
			$conf = json_decode(getFileContent($srkEnv->resPath.'/'.$resId.'/config.json'));
			$contentFileName = $srkEnv->resPath.'/'.$resId.'/content';
			if ($conf !== -1 && is_file($contentFileName)) {
				if (isset($conf->contentType)) {
					header("Content-Type: ".$conf->contentType);
				}
				else {
					header("Content-Type: application/octet-stream");
				}
				if ($conf->noOnline) {
					if ($conf->fileName) {
						header('Content-Disposition: attachment; filename='.basename($conf->fileName));
					}
					else {
						header('Content-Disposition: attachment; filename=unknownFileName');
					}
				}
				srkStream($contentFileName);
			}
			else {
				srkRender('error', Array('error'=>Array(
					'status'=>-2, 
					'stack'=>'Resource error'
				)));
			}
		}
		else {
			srkRender('error', Array('error'=>Array(
				'status'=>404, 
				'stack'=>'Resource not found'
			)));
		}
	}
}

