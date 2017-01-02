<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='row'>
	<div class='col-sm-12 col-md-offset-2 col-md-4'>
		<div class='form-group'>
			<label class='' for='userId' id='loginid'>User&nbsp;id / Email</label>
			<label class='' for='userId' id='regid'>User&nbsp;id</label>
			<input class='form-control' type='text' id='userId'/>
		</div>
		<div class='form-group'>
			<label class='' for='password'>Password</label>
			<input class='form-control' type='password' id='passwd'/>
		</div>
		<div id='registerinfo' class='hidden'>
			<div class='form-group'>
				<label class='' for='password'>Repeat password</label>
				<input class='form-control' type='password' id='repeatPasswd'/>
			</div>
			<div class='form-group'>
				<label class='' for='email'>Email<a onclick="$('#emailexplain').slideDown()">?</a></label>
				<input class='form-control' type='text' id='email'/>
				<label class='hidden' id='emailexplain'>This&nbsp;is&nbsp;to&nbsp;be&nbsp;used&nbsp;to&nbsp;grab&nbsp;your&nbsp;avatar&nbsp;from&nbsp;<a href='https://gravatar.com'>Gravatar</a></label>
			</div>
			<div class='form-group'>
				<label class='' for='nickname'>Nickname</label>
				<input class='form-control' type='text' id='nickname'/>
			</div>
			<div class='form-group'>
				<label class='' for='invitecode'>Invite&nbsp;Code</label>
				<input class='form-control' type='text' id='invitecode'/>
			</div>
		</div>
		<div class='form-group'>
			<p class='red hidden' id='perror'></p>
			<p class='blue hidden' id='ppending'>Pending</p>
			<p class='green hidden' id='psuccess'>Succeeded</p>
		</div>
		<div class='form-group'>
			<button class='btn btn-success' id='login'>Log in</button>
			<button class='btn btn-info' id='register'>Register</button>
		</div>
	</div>

	<div class='col-xs-12 col-md-4'>
		<div class='list-group'>
			<a class='list-group-item list-group-item-info'>
				<h4> Third-party Login </h4>
			</a>
		<?php foreach ($srkEnv->thirdPartyLogin as $loginSite) { ?>
			<a class='list-group-item' href='<?php echo($loginSite->href); ?>'>
				<img class='iconimg' src='<?php echo($loginSite->img); ?>'/>
				<?php echo($loginSite->title); ?>
			</a>
		<?php } ?>
	</div>
</div>

<div class='divclear'></div>
