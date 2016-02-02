<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div id='samplelistitem' class='hidden'>
	<a class='pentitle' id='title'></a>
	<div class='penpreview' id='preview'></div>
	<div class='infodiv' id='infodiv'></div>
</div>
