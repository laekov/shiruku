<?php
if (!isset($srkEnv)) {
	header("Location: /");
	return;
}
?>
<body>
	<div id='navbardiv'>
		<div id='navbar' class='navbar navontop fixdiv'>
			<div id='icondiv' class='navbarelement'>
				<p>Shiruku - test</p>
			</div>
		</div>
		<div id='toppic' class='navbar'>
			<img src='<?php echo($srkEnv->staticResPath.'/images/nav-background.jpg'); ?>' class='navpic'/>
		</div>
	</div>
