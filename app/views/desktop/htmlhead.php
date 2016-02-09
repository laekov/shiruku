<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}

array_push($srkEnv->javascripts, '/javascripts/navbar.js');
array_push($srkEnv->stylesheets, '/stylesheets/navbar.css');
?>
<html>
	<head>
		<title><?php echo($srkEnv->pageTitle); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php
	foreach ($srkEnv->stylesheets as $styfile) { ?>
		<link rel='stylesheet' type='text/css' href='/entrances<?php echo($styfile); ?>'/>
	<?php }
	foreach ($srkEnv->javascripts as $jsfile) { ?>
		<script src='/entrances<?php echo($jsfile); ?>'></script>
	<?php } ?>
	</head>


