<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

array_push($srkEnv->javascripts, '/javascripts/indicator.js');
array_push($srkEnv->stylesheets, '/stylesheets/indicator.css');
