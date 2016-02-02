<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div class='infodiv hidden' id='sampleinfodiv'>
	<p>Post time <span id='modifyTime'></span></p>
	<p>Visit <span id='visit'></span></p>
	<p id='ptags'>Tags <span id='tags'></span></p>
</div>

<a id='sampletag'></a>
