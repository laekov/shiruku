<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

array_push($srkEnv->stylesheets, '/stylesheets/comment.css');
array_push($srkEnv->javascripts, '/javascripts/comment.js');

