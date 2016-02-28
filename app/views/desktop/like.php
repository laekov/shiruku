<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='hidden' id='samplelikediv'>
	<div class='hidden' id='valuediv'>
		<button class='buttonsmall buttonlightgreen' id='actlike'>
			<span class='monotiny'>Like</span>
			<span id='valuelike'></span>
		</button>
		<button class='buttonsmall buttonlightred' id='actdislike'>
			<span class='monotiny'>Dislike</span>
			<span id='valuedislike'></span>
		</button>
	</div>
	<div><p class='red hidden' id='perror'></p></div>
</div>

<span class='hidden' id='sampleloginnotify'>
Please&nbsp;<a href='/login'>log&nbsp;in</a>&nbsp;first
</span>
