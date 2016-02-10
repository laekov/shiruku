<?php
if (!defined('srkVersion')) {
	exit(403);
}

$srkContent = (Object)Array();

// category list 
$srkContent->category = Array(
	'developing'=>(Object)Array(
		'title'=>'码农的开发手记'
	),
	'brainhole'=>(Object)Array(
		'title'=>'奇奇怪怪的脑洞'
	),
	'oi'=>(Object)Array(
		'title'=>'很久以前的信竞题'
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

// record info
$srkContent->PRCRecordInfo = (Object)Array(
	'text'=>'蜀ICP备23333333333号',
	'href'=>'http://http://www.miitbeian.gov.cn/'
);

// owner info
$srkContent->ownerInfo = (Object)Array(
	'owner'=>'laekov',
	'email'=>'laekov@mailserver',
	'age'=>'2015-2016'
);

