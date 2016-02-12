<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>
<body>
	<div id='navbardiv'>
		<div id='navbar' class='navbar fixdiv navontop'>
			<div class='navbarfloat'>
				<ul class='navul navull'>
					<li id='icondiv' class='navitem navtitle'>
						Shiruku - test
					</li>
					<li class='navitem'>
						<input class='searchinput' id='searchinput' type='text' value=''/>
					</li>
				</ul>
				<ul class='navul navulr'>
					<?php foreach ($srkContent->navbar as $navId=>$navItem) { ?>
					<a href='<?php echo($navItem->href); ?>'>
						<li id='navitem_<?php echo($navId); ?>' class='navitem'>
							<?php echo($navItem->title); ?>
						</li>
					</a>
					<?php } ?>
					<a href='/login' id='navitem_login'>
						<li class='navitem'>Log in</li>
					</a>
					<li class='navitem hidden' id='navitem_userinfo'>
						<div class='simplediv divuserid' id='face'> <span id='username'></span> </div>
					</li>
				</ul>
			</div>
		</div>
		<div id='topspace' class='navbar navnotop hidden'> </div>
		<div id='toppic' class='navbar hidden'>
			<img src='<?php echo($srkEnv->staticResPath.'/images/nav-background.jpg'); ?>' class='navpic'/>
		</div>
	</div>
	<div class='simplediv hidden floatingdiv' id='loginactions'>
		<ul class='actionul'>
			<a href='/login/manage'><li>Profile</li></a>
			<a id='logout'><li>Log out</li></a>
		</ul>
	</div>
	<div class='maindiv' id='pagecontentdiv'>

