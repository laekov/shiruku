<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>
<body>
	<div id='navbardiv'>
		<div id='navbar' class='navbar fixdiv'>
			<div id='icondiv' class='navbarelement'>
				<p>Shiruku - test</p>
			</div>
		</div>
		<div id='topspace' class='navbar navnotop hidden'> </div>
		<div id='toppic' class='navbar hidden'>
			<img src='<?php echo($srkEnv->staticResPath.'/images/nav-background.jpg'); ?>' class='navpic'/>
		</div>
	</div>
