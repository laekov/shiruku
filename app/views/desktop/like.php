<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='hidden' id='samplelikediv'>
	<div class='hidden' id='valuediv'>
		<button class='btn btn-default' id='actlike'>
			<i class='glyphicon glyphicon-thumbs-up text-info'></i>
			<small id='valuelike'></small>
		</button>
		<button class='btn btn-default' id='actdislike'>
			<i class='glyphicon glyphicon-thumbs-down text-info'></i>
			<small id='valuedislike'></small>
		</button>
	</div>
	<div><p class='red hidden' id='perror'></p></div>
</div>

<span class='hidden' id='sampleloginnotify'>
Please&nbsp;<a href='/login'>log&nbsp;in</a>&nbsp;first
</span>
