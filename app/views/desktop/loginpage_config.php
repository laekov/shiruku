<?php
if (!defined('srkVersion')) {
	exit(403);
}

array_push($srkEnv->javascripts, '/javascripts/loginpage.js');

array_push($srkEnv->dependViews, 'form');

