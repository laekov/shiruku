<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->javascripts, '/javascripts/listfunc.js');
array_push($srkEnv->javascripts, '/javascripts/list.js');
array_push($srkEnv->stylesheets, '/stylesheets/list.css');

array_push($srkEnv->dependViews, 'indicator');
array_push($srkEnv->dependViews, 'infodiv');
array_push($srkEnv->dependViews, 'listitem');
