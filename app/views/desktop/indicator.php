<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div class='hidden'>
	<a class='indicatoritem hidden' id='sampleindicatorref'><span id='content'></span></a>
	<div class='indicator hidden' id='sampleindicator'> </div>
</div>
