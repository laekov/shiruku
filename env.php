<?php

require_once('./modules/toolkit.php');

class AppEnv {
	// basic envrionment variables for Shiruku
	public $appPath;

	// env vars for views and pages
	public $uiType;
	public $viewsPath;
	public $pageTitle;
	public $pageTitleAppend;
	public $stylesheets;
	public $javascripts;

	// env vars for mysql database
	public $sqlURI;
	public $sqlUser;
	public $sqlPasswd;
};

$srkEnv = new AppEnv();
$srkEnv->appPath = '.';
$srkEnv->uiType = (isMobile() ? '/mobile' : '/desktop');
$srkEnv->viewsPath = $srkEnv->appPath.'/views'.$srkEnv->uiType;
$srkEnv->pageTitle = 'Shiruku';
$srkEnv->pageTitleAppend = ' - laekov';
$srkEnv->stylesheets = Array();	
$srkEnv->javascripts = Array();
$srkEnv->sqlURI = 'localhost';
$srkEnv->sqlUser = '2333';
$srkEnv->sqlPasswd = 'orzmhy';
$srkEnv->sqlDatabase = 'shiruku_db';
