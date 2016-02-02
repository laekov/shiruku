<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div class='maindiv' id='maindiv'>
	<div id='pageindicator' class='fulldiv'></div>
	<div id='list' class='fulldiv'></div>
	<div id='error' class='fulldiv hidden error'></div>
</div>

