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
		<div id='pencontentloading'>
			<p>Loading content</p>
		</div>
		<div id='peninfo' style='display: none;'>
			<div>Posted at: <span id='posttime'></span></div>
			<div>Visit: <span id='visitcount'></span></div>
		</div>
		<div id='commentdiv'>
			<div id='samplecomment' style='display: none'>
				<div id='author'></div>
				<div id='content'></div>
				<div id='postdate'></div>
			</div>
	</div>
</div>

