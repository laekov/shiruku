<?php
if (!defined('srkVersion')) {
	exit(403);
}
?>
<body>
	<div id='navbardiv'>
		<div id='navbar' class='navbar navbar-default navbar-fixed-top'>
			<div class='navbar-header'>
                <a class='navbar-brand'>Shiruku - laekov </a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class='collapse navbar-collapse' id='collapse-1'>
                <div class='navbar-form navbar-left'>
                    <input class='form-control' id='searchinput' type='text' placeholder='Search'/>
                </div>
				<ul class='nav navbar-nav'>
					<?php foreach ($srkContent->navbar as $navId=>$navItem) { ?>
					<li id='navitem_<?php echo($navId); ?>' class=''>
					    <a href='<?php echo($navItem->href); ?>'>
							<?php echo($navItem->title); ?>
					    </a>
					</li>
					<?php } ?>
					<li class=''>
					    <a href='/login' id='navitem_login'>Log in</a>
                    </li>
					<li class='' id='navitem_userinfo' id='username'>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class='maindiv' id='pagecontentdiv'>

