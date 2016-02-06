<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
array_push($srkEnv->javascripts, '/javascripts/viewer.js');
array_push($srkEnv->javascripts, '/javascripts/penconfig.js');
array_push($srkEnv->stylesheets, '/stylesheets/viewer.css');

array_push($srkEnv->dependViews, 'infodiv');
array_push($srkEnv->dependViews, 'comment');

