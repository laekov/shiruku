<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>

<div class='maindiv' id='maindiv'>
	<div id='contentdiv'>
		<h2 id='pentitle' class='pentitle'></h2>
		<div id='pencontent'></div>
		<div id='pencontentloading'>
			<p>Loading content</p>
		</div>
		<div id='peninfo' class='hidden'> </div>
		<div id='quickjump' class='hidden'> 
			<p>Previous pen:&nbsp;<a id='prev'></a></p>
			<p>Succeeding pen:&nbsp;<a id='succ'></a></p>
		</div>
		<div id='commentdiv'>
		</div>
	</div>
</div>

