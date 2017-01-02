<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='panel panel-default hidden' id='samplecomment'>
	<div id='info' class='panel-heading'>
		<div class='row'>
			<div id='ownerinfo'>
				<div class='pull-left'><img id='avatar' class='avatarsmall'/></div>
				<div class='pull-left'>
					<div> 
						<span id='nickname'></span>
						<a id='viewref'>&gt;</a>
					</div>
					<small>
						Posted&nbsp;at&nbsp;<span id='modifytime'></span>
					</small>
		</div>
			</div>
		</div>
	</div>
	<div class='panel-body'>
		<div id='content' class=''></div>
	</div>
	<div class='panel-footer'>
		<div class='row'>
			<div class='pull-right' id='likediv'></div>
		</div>
	</div>
</div>

<div class='commentitem hidden' id='samplecommentedit'>
	<p>Make a comment</p>
	<textarea id='content' rows='3'></textarea>
	<button class='buttonnormal buttongreen' id='commentpost'>Post</button>
	<p id='perror' class='red hidden'></p>
	<p id='ppending' class='blue hidden'>Sending</p>
	<p id='psuccess' class='green hidden'>Succeeded</p>
</div>

<div class='commentitem hidden' id='samplecommentlogin'>
	<p>To&nbsp;make&nbsp;a&nbsp;comment,&nbsp;you&nbsp;need&nbsp;to&nbsp;<a href='/login'>log&nbsp;in</a>&nbsp;first</p>
</div>

