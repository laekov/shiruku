<?php
require_once('./modules/toolkit.php');

class EmptyClass {};

$srkEnv = new EmptyClass();

// basic envrionment variables for Shiruku
$srkEnv->appPath = '.';

// env vars for storage path of site data in normal file format
$srkEnv->penPath = $srkEnv->appPath.'/../myfolder/pen';
$srkEnv->commentPath = $srkEnv->appPath.'/../myfolder/comment';

// env vars for views and pages
$srkEnv->uiType = (isMobile() ? '/mobile' : '/desktop');
$srkEnv->viewsPath = $srkEnv->appPath.'/views'.$srkEnv->uiType;
$srkEnv->pageTitle = 'Shiruku';
$srkEnv->pageTitleAppend = ' - laekov';
$srkEnv->stylesheets = Array();	
$srkEnv->javascripts = Array();

// env vars for mysql database
$srkEnv->sqlURI = 'localhost';
$srkEnv->sqlUser = '2333';
$srkEnv->sqlPasswd = 'orzmhy';
$srkEnv->sqlDatabase = 'shiruku_db';
