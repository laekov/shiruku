<?php
if (!defined('srkVersion')) {
	exit(403);
}
// common javascripts and stylesheets
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/global.css');
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/div.css');
array_push($srkEnv->stylesheets, '/stylesheets/'.$srkEnv->uiType.'/text.css');
array_unshift($srkEnv->stylesheets, '/wheels/bootstrap/dist/css/bootstrap.min.css');
array_unshift($srkEnv->javascripts, '/wheels/MathJax/MathJax.js?config=default');
array_unshift($srkEnv->javascripts, '/wheels/bootstrap/dist/js/bootstrap.min.js');
array_unshift($srkEnv->javascripts, '/wheels/showdown/dist/showdown.min.js');
array_unshift($srkEnv->javascripts, '/wheels/jquery.cookie/jquery.cookie.js');
array_unshift($srkEnv->javascripts, '/wheels/jquery/dist/jquery.min.js');

array_push($srkEnv->stylesheets, '/stylesheets/navbar.css');
array_push($srkEnv->javascripts, '/javascripts/navbar.js');

$srkEnv->stylesheets = array_unique($srkEnv->stylesheets);
$srkEnv->javascripts = array_unique($srkEnv->javascripts);

function genRef($ref) {
	if (strpos($ref, "http") !== false) {
		return $ref;
	} else if (strpos($ref, "/wheels") !== false) {
		return $ref;
	} else {
		return '/entrances/'.$ref;
	}
}
?>
<html>
	<head>
		<title><?php echo($srkEnv->pageTitle.$srkEnv->pageTitleAppend); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
		<meta property="og:title" content="<?php echo($srkEnv->pageTitle.$srkEnv->pageTitleAppend); ?>"/>
	<?php
	foreach ($srkEnv->stylesheets as $styfile) {  ?>
		<link rel='stylesheet' type='text/css' href='<?php echo(genRef($styfile)); ?>'/>
	<?php }
	foreach ($srkEnv->javascripts as $jsfile) { ?>
		<script src='<?php echo(genRef($jsfile)); ?>'></script>
	<?php } ?>
	</head>


