<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

array_push($srkEnv->javascripts, '/javascripts/infodiv.js');
