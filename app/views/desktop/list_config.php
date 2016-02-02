<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

array_push($srkEnv->javascripts, '/javascripts/listfunc.js');
array_push($srkEnv->javascripts, '/javascripts/list.js');
array_push($srkEnv->stylesheets, '/stylesheets/list.css');

array_push($srkEnv->dependViews, 'indicator');
array_push($srkEnv->dependViews, 'infodiv');
array_push($srkEnv->dependViews, 'listitem');
