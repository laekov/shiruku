<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->stylesheets, '/stylesheets/comment.css');
array_push($srkEnv->stylesheets, '/stylesheets/form.css');
array_push($srkEnv->javascripts, '/javascripts/comment.js');
array_push($srkEnv->javascripts, '/javascripts/form.js');

