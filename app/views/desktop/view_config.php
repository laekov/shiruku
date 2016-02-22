<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/share/qzone.php');

array_push($srkEnv->javascripts, '/javascripts/viewer.js');
array_push($srkEnv->javascripts, '/javascripts/view.js');
array_push($srkEnv->stylesheets, '/stylesheets/viewer.css');
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/code.css');

array_push($srkEnv->dependViews, 'infodiv');
array_push($srkEnv->dependViews, 'comment');

