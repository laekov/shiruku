<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->javascripts, '/javascripts/admin.js');
array_push($srkEnv->stylesheets, '/stylesheets/admin.css');

array_push($srkEnv->dependViews, 'form');

