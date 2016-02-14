<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='hidden formnav' id='sampleformnavitem'>
	<a id='content'></a>
</div>

<div class='hidden' id='samplelistitem'>
	<p>
		<a class='monobig' id='title'></a>
		<a class='monosmall' id='remove'>Remove</a>
	</p>
</div>

<div class='divleft' id='formnavdiv'>
</div>
<div class='divleft' id='contentdiv'> 
	<div class='hidden' id='ui_penlist'>
		<div class='formtitle'>
			<p id='title'>Pen list</p>
		</div>
	</div>
	<div id='statusdiv'>
		<p class='red hidden' id='perror'></p>
		<p class='blue hidden' id='ppending'>Pending</p>
		<p class='green hidden' id='psuccess'>Succeeded</p>
	</div>
</div>
