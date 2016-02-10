<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>
<body>
	<div id='navbardiv'>
		<div id='navbar' class='navbar fixdiv navontop'>
			<ul class='navul'>
				<li id='icondiv' class='navitem navtitle'>
					Shiruku - test
				</li>
				<?php foreach ($srkContent->navbar as $navId=>$navItem) { ?>
				<a href='<?php echo($navItem->href); ?>'>
				    <li id='navitem_<?php echo($navId); ?>' class='navitem'>
						<?php echo($navItem->title); ?>
				    </li>
				</a>
				<?php } ?>
			</ul>
		</div>
		<div id='topspace' class='navbar navnotop hidden'> </div>
		<div id='toppic' class='navbar hidden'>
			<img src='<?php echo($srkEnv->staticResPath.'/images/nav-background.jpg'); ?>' class='navpic'/>
		</div>
	</div>

