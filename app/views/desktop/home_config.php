<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->stylesheets, '/stylesheets/home.css');
array_push($srkEnv->javascripts, '/javascripts/comment.js');
array_push($srkEnv->javascripts, '/javascripts/viewer.js');
array_push($srkEnv->javascripts, '/javascripts/home.js');
array_push($srkEnv->javascripts, '/javascripts/listfunc.js');

array_push($srkEnv->dependViews, 'comment');
array_push($srkEnv->dependViews, 'infodiv');
