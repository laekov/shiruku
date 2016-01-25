<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div class='maindiv' id='maindiv'>
	<h1>Error&nbsp;<?php echo($renderArgs['error']['status']); ?></h1>
	<p><?php echo($renderArgs['error']['stack']); ?></p>
</div>

