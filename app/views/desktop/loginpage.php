<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='divform'>
	<div class='formitem'>
		<label class='labelmonomed' for='userId' id='loginid'>User&nbsp;id / Email</label>
		<label class='labelmonomed' for='userId' id='regid'>User&nbsp;id</label>
		<input class='textnormal' type='text' id='userId'/>
	</div>
	<div class='formitem'>
		<label class='labelmonomed' for='password'>Password</label>
		<input class='textnormal' type='password' id='passwd'/>
	</div>
	<div id='registerinfo' class='hidden'>
		<div class='formitem'>
			<label class='labelmonomed' for='password'>Repeat password</label>
			<input class='textnormal' type='password' id='repeatPasswd'/>
		</div>
		<div class='formitem'>
			<label class='labelmonomed' for='email'>Email<a onclick="$('#emailexplain').slideDown()">*</a></label>
			<input class='textnormal' type='text' id='email'/>
			<label class='hidden' id='emailexplain'>This&nbsp;is&nbsp;to&nbsp;be&nbsp;used&nbsp;to&nbsp;grab&nbsp;your&nbsp;avatar&nbsp;from&nbsp;<a href='https://gravatar.com'>Gravatar</a></label>
		</div>
		<div class='formitem'>
			<label class='labelmonomed' for='nickname'>Nickname</label>
			<input class='textnormal' type='text' id='nickname'/>
		</div>
		<div class='formitem'>
			<label class='labelmonomed' for='invitecode'>Invite&nbsp;Code</label>
			<input class='textnormal' type='text' id='invitecode'/>
		</div>
	</div>
	<div class='formitem'>
		<p class='red hidden' id='perror'></p>
		<p class='blue hidden' id='ppending'>Pending</p>
		<p class='green hidden' id='psuccess'>Succeeded</p>
	</div>
	<div class='formitem'>
		<button class='buttonnormal buttongreen' id='login'>Log in</button>
		<button class='buttonnormal buttonblue' id='register'>Register</button>
	</div>
</div>

