<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='hidden commentitem' id='samplecomment'>
	<div id='info' class='commentinfodiv'>
		<div id='ownerinfo' class='divleft divsimple'>
			<div class='divleft'><img id='avatar' class='avatarsmall'/></div>
			<div class='divleft'>
				<div> 
					<span id='nickname'></span>
				</div>
				<div>
					Posted&nbsp;at&nbsp;<span id='modifytime'></span>
				</div>
			</div>
			<div class='divclear'></div>
		</div>
		<div class='divright divsimple'>
			<div id='likediv'></div>
		</div>
		<div class='divclear'></div>
	</div>
	<div id='content' class='commentcontentdiv'></div>
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

