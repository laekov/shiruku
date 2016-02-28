<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->javascripts, '/javascripts/like.js');
array_push($srkEnv->stylesheets, '/stylesheets/like.css');
array_push($srkEnv->stylesheets, '/stylesheets/form.css');

