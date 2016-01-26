<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div class='maindiv' id='maindiv'>
	<div id='contentdiv'>
		<h2 id='pentitle'></h2>
		<div id='pencontent'></div>
		<div id='commentdiv'>
			<div id='samplecomment' style='display: none'>
				<div id='author'></div>
				<div id='content'></div>
				<div id='postdate'></div>
			</div>
	</div>
</div>

