<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once($srkEnv->appPath.'/modules/db.php');

if ($srkEnv->reqMethod == 'GET') {
	require_once($srkEnv->appPath.'/modules/render.php');
	srkRender('home', Array('visitCount'=>srkVisitCountGet('shiruku_site_total')));
}

