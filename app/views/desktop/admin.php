<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>

<div class='hidden' id='sampleformnavitem'>
	<a class='actformnavitem' id='content'>
		<span id='divid' class='hidden'></span>
		<div class='formnavitem navitemoff' id='title'></div>
	</a>
</div>

<div class='hidden' id='samplelistitem'>
	<p>
		<a class='hidden' id='penId'></a>
		<a class='monobig actviewpen' id='title'></a>
		<a class='monosmall actremovepen' id='remove'>Remove</a>
	</p>
</div>

<div class='divleft divadminnav' id='formnavdiv'>
</div>
<div class='divleft' id='contentdiv'> 
	<div class='hidden' id='ui_penlist'>
		<div class='formtitle'>
			<p id='title'>Pen list</p>
		</div>
		<p id='error' class='hidden red'></p>
		<div id='list'></div>
	</div>
	
	<div class='hidden' id='ui_penedit'>
		<div class='formtitle'>
			<p id='title'>Edit pen</p>
		</div>
		<div class='formitem'>
			<label for='editpenid' class='monosmall'>Pen ID</label>
			<input type='text' class='textnormal' id='editpenid'/>
			<button class='buttonnormal buttonblue' id='actgenerateid'>Generate new ID</button>
			<button class='buttonnormal buttonred' id='actreloadpen'>Reload pen</button>
		</div>
		<div class='formitem'>
			<p>Content</p>
			<div class='divleft divmarginright'>
				<textarea id='editcontenttext' rows='32'></textarea>
			</div>
			<div class='divleft divborder' id='previewdiv'></div>
			<div class='divclear'></div>
			<button class='buttonnormal buttongreen' id='actgeneratepreview'>Generate preview</button>
			<button class='buttonnormal buttonblue' id='actsubmitcontent'>Upload content</button>
		</div>
		<div class='formitem'>
			<p>Config</p>
			<div>
				<textarea id='editconfigtext' rows='16'></textarea>
			</div>
			<button class='buttonnormal buttonblue' id='actsubmitconfig'>Upload config</button>
			<button class='buttonnormal buttongreen' id='actsubmitboth'>Upload both</button>
		</div>
	</div>

	<div id='ui_invite' class='hidden'>
		<div class='formtitle'>
			<p id='title'>Invatation manage</p>
		</div>
		<div class='formitem'>
			<label for='generatecount'>Count</label>
			<input class='textnormal' type='text' id='invitecodegeneratecount'/>
			<button class='buttonnormal buttongreen' id='actgenerateinvitecode'>Generate</button>
		</div>
		<div class='hidden' id='sampleinvitecode'>
			<span class='monobig' id='value'></span>
			<span class='monosmall' id='used'></span>
		</div>
		<div class='formitem' id='invitelist'>
		</div>
	</div>

	<div id='statusdiv'>
		<p class='red hidden' id='perror'></p>
		<p class='blue hidden' id='ppending'>Pending</p>
		<p class='green hidden' id='psuccess'>Succeeded</p>
		<p class='green hidden' id='pres'></p>
	</div>
</div>

<div class='divclear'></div>

