<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div id='contentdiv'>
	<div class='container-fluid'>
		<div class='page-header'>
			<h1 id='pentitle' class=''></h1>
		</div>
		<div id='pencontent' class=''></div>
		<div id='pencontentloading'>
			<p>Loading content</p>
		</div>
		<div style='height: 32px'></div>
		<div id='peninfo' class='hidden'> </div>
	</div>
	<div class='container-fluid'>
		<div id='commenteditdiv'></div>
		<div id='commentdiv'></div>
		<div id='quickjump' class='hidden'> 
			<p>Previous pen:&nbsp;<a id='prev'></a></p>
			<p>Succeeding pen:&nbsp;<a id='succ'></a></p>
		</div>
	</div>
</div>

