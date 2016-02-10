<?php
if (!defined('srkVersion')) {
	exit(403);
}
array_push($srkEnv->javascripts, '/javascripts/viewer.js');
array_push($srkEnv->javascripts, '/javascripts/penconfig.js');
array_push($srkEnv->stylesheets, '/stylesheets/viewer.css');

array_push($srkEnv->dependViews, 'infodiv');
array_push($srkEnv->dependViews, 'comment');

