<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->javascripts, '/javascripts/indicator.js');
array_push($srkEnv->stylesheets, '/stylesheets/indicator.css');
