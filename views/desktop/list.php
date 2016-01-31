<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div id='samplelistitem' class='hidden'>
	<a class='pentitle' id='title'></a>
	<div class='penpreview' id='preview'></div>
</div>

<?php
require_once($srkEnv->viewsPath.'/indicator.php');
?>

<div class='maindiv' id='maindiv'>
	<div id='pageindicator' class='pageindicatordiv fulldiv'></div>
	<div id='list' class='fulldiv'></div>
	<div id='error' class='fulldiv hidden error'></div>
</div>

