<?php
if (!defined('srkVersion')) {
	exit(403);
}
// common javascripts and stylesheets
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/global.css');
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/div.css');
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/text.css');
array_unshift($srkEnv->javascripts, '/javascripts/cdn/jquery.cookie.js');
array_unshift($srkEnv->javascripts, '/javascripts/cdn/jquery_min.js');
array_unshift($srkEnv->javascripts, '/javascripts/cdn/showdown.min.js');

array_push($srkEnv->stylesheets, '/stylesheets/navbar.css');
array_push($srkEnv->javascripts, '/javascripts/navbar.js');

$srkEnv->stylesheets = array_unique($srkEnv->stylesheets);
$srkEnv->javascripts = array_unique($srkEnv->javascripts);
?>
<html>
	<head>
		<title><?php echo($srkEnv->pageTitle.$srkEnv->pageTitleAppend); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php
	foreach ($srkEnv->stylesheets as $styfile) { ?>
		<link rel='stylesheet' type='text/css' href='/entrances<?php echo($styfile); ?>'/>
	<?php }
	foreach ($srkEnv->javascripts as $jsfile) { ?>
		<script src='/entrances<?php echo($jsfile); ?>'></script>
	<?php } ?>
	</head>


