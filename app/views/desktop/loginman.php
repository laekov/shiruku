<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='divform hidden' id='localedit'>
	<div class='formitem'>
		<label class='labelmonomed' for='userId'>User id</label>
		<span id='userId'></span>
	</div>
	<div class='formitem'>
		<label class='labelmonomed' for='password'>Old password (necessary)</label>
		<input class='textnormal' type='password' id='prevPasswd'/>
	</div>
	<div class='formitem'>
		<label class='labelmonomed' for='password'>New password (leave blank if no change)</label>
		<input class='textnormal' type='password' id='passwd'/>
	</div>
	<div class='formitem'>
		<label class='labelmonomed' for='password'>Repeat password</label>
		<input class='textnormal' type='password' id='repeatPasswd'/>
	</div>
	<div class='formitem'>
		<label class='labelmonomed' for='email'>Email<a onclick="$('#emailexplain').slideDown()">?</a></label>
		<input class='textnormal' type='text' id='email'/>
		<label class='hidden' id='emailexplain'>This&nbsp;is&nbsp;to&nbsp;be&nbsp;used&nbsp;to&nbsp;grab&nbsp;your&nbsp;avatar&nbsp;from&nbsp;<a href='https://gravatar.com'>Gravatar</a></label>
	</div>
	<div class='formitem'>
		<label class='labelmonomed' for='nickname'>Nickname</label>
		<input class='textnormal' type='text' id='nickname'/>
	</div>
	<div class='formitem'>
		<button class='buttonnormal buttongreen' id='actupdate'>Update my profile</button>
	</div>
</div>

<div class='formitem'>
	<p class='red hidden' id='perror'></p>
	<p class='blue hidden' id='ppending'>Pending</p>
	<p class='green hidden' id='psuccess'>Succeeded</p>
</div>
