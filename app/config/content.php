<?php
if (!isset($srkEnv)) {
	header('Location: /');
	return;
}

$srkContent = (Object)Array();

// category list 
$srkContent->category = Array(
	'developing'=>(Object)Array(
		'title'=>'码农开发手记'
	),
	'brainhole'=>(Object)Array(
		'title'=>'奇奇怪怪的脑洞'
	),
	'oi'=>(Object)Array(
		'title'=>'原来的信竞题'
	),
	'code'=>(Object)Array(
		'title'=>'乱七八糟的代码'
	),
	'diary'=>(Object)Array(
		'title'=>'日记'
	)
);

// navagate bar
$srkContent->navbar = Array(
	'home'=>(Object)Array(
		'title'=>'首页',
		'href'=>'/'
	),
	'list'=>(Object)Array(
		'title'=>'列表',
		'href'=>'/list'
	),
	'download'=>(Object)Array(
		'title'=>'下载',
		'href'=>'/download'
	),
	'webboard'=>(Object)Array(
		'title'=>'留言',
		'href'=>'/view/webboard'
	),
	'about'=>(Object)Array(
		'title'=>'关于',
		'href'=>'/view/about'
	)
);

