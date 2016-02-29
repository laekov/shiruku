<?php
if (!defined('srkVersion')) {
	exit(403);
}

require_once('./modules/toolkit.php');

$srkEnv = (Object)Array();

// basic envrionment variables for Shiruku
$srkEnv->appPath = dirname(dirname(__file__));

// env vars for storage path of site data in normal file format
$srkEnv->penPath = $srkEnv->appPath.'/../myfolder_local/pen';

// limitations
$srkEnv->maxFileSize = 1 << 24; // max file size allowed to be stored

// env vars for views and pages
$srkEnv->uiType = isBrowserBaned() ? '/ban' : (isMobile() ? '/mobile' : '/desktop');
$srkEnv->viewsPath = $srkEnv->appPath.'/views'.$srkEnv->uiType;
$srkEnv->staticResPath = '/entrances/template/default';
$srkEnv->pageTitle = 'Shiruku';
$srkEnv->pageTitleAppend = ' - laekov';
$srkEnv->stylesheets = Array();	
$srkEnv->javascripts = Array();
$srkEnv->dependViews = Array();

// env vars for resources 
$srkEnv->resPath = $srkEnv->appPath.'/../myfolder/resources';

// env vars for users
$srkEnv->userPath = $srkEnv->appPath.'/../myfolder/users';

// env vars for mysql database
$srkEnv->sqlURI = 'localhost';
$srkEnv->sqlUser = '2333';
$srkEnv->sqlPasswd = 'mhy';
$srkEnv->sqlDatabase = 'db';

// env vars for log file
$srkEnv->logFileName = $srkEnv->appPath.'/../myfolder_local/srk.log';

// env vars for cache
$srkEnv->cachePath = $srkEnv->appPath.'/../myfolder/fcache';
$srkEnv->cacheTime = 10 * 60; // 10 minutes

// env vars for third-party login
$srkEnv->thirdPartyLogin = Array(
	'github'=>(Object)Array(
		'title'=>'Github',
		'img'=>'https://assets-cdn.github.com/images/modules/logos_page/GitHub-Mark.png',
		'href'=>'https://github.com/login/oauth/authorize?scope=user:email&client_id=233333',
		'clientId'=>'233333',
		'clientSecret'=>'orzzhx'
	)
);

// env vars for like
$srkEnv->maxLike = 0xf;
