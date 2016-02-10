<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div id='contentdiv'>
	<div class='penwrapper'>
		<div class='pentitlediv'>
			<h2 id='pentitle' class='pentitle'></h2>
		</div>
		<div id='pencontent'></div>
		<div id='pencontentloading'>
			<p>Loading content</p>
		</div>
		<div id='peninfo' class='hidden peninfodiv'> </div>
	</div>
	<div id='commentdiv'>
	</div>
	<div id='quickjump' class='hidden'> 
		<p>Previous pen:&nbsp;<a id='prev'></a></p>
		<p>Succeeding pen:&nbsp;<a id='succ'></a></p>
	</div>
</div>

