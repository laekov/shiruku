<?php
if (!defined('srkVersion')) {
	exit(403);
}

$srkContent = (Object)Array();

// category list 
$srkContent->category = Array(
	'tool'=>(Object)Array(
		'title'=>'工具'
	),
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
		'href'=>'/view/download'
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
	'text'=>'ICP备23333333333333号',
	'href'=>'http://http://www.miitbeian.gov.cn/'
);

// owner info
$srkContent->ownerInfo = (Object)Array(
	'owner'=>'laekov',
	'email'=>'laekov.h@gmail.com',
	'age'=>'2015-2016'
);

// friend link
$srkContent->friendLink = Array(
	(Object)Array(
		'text'=>'zhonghaoxi',
		'href'=>'http://www.cnblogs.com/zhonghaoxi/'
	),
	(Object)Array(
		'text'=>'jason_yu',
		'href'=>'http://blog.jason-yu.net/'
	),
	(Object)Array(
		'text'=>'mhy12345',
		'href'=>'http://mhy12345.laekov.com.cn/'
	),
	(Object)Array(
		'text'=>'idy002',
		'href'=>'http://idy002.laekov.com.cn/'
	),
	(Object)Array(
		'text'=>'rausen',
		'href'=>'http://www.cnblogs.com/rausen/'
	),
	(Object)Array(
		'text'=>'jcpwfloi',
		'href'=>'http://blog.codebursts.com/'
	),
	(Object)Array(
		'text'=>'iwtwiioi',
		'href'=>'http://www.cnblogs.com/iwtwiioi'
	),
	(Object)Array(
		'text'=>'zyf-zyf',
		'href'=>'http://zyfzyf.is-programmer.com/'
	),
	(Object)Array(
		'text'=>'dx',
		'href'=>'http://notdr.logdown.com/'
	)
);

// default pen config data
$srkContent->defaultPenConfig = (Object)Array(
	'title'=>'Untitled',
	'tag'=>Array(),
	'catalog'=>'Undefined'
);

