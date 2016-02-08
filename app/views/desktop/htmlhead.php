<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>
<html>
	<head>
		<title><?php echo($srkEnv->pageTitle); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<?php
	foreach ($srkEnv->stylesheets as $styfile) { ?>
		<link rel='stylesheet' type='text/css' href='<?php echo($styfile); ?>'/>
	<?php }
	foreach ($srkEnv->javascripts as $jsfile) { ?>
		<script src='<?php echo($jsfile); ?>'></script>
	<?php } ?>
		<script src='/javascripts/navbar.js'></script>
		<link rel='stylesheet' type='text/css' href='/stylesheets/navbar.css'/>
	</head>


