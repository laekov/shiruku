<?php
require_once('./modules/toolkit.php');

$srkEnv = (Object)Array();

// basic envrionment variables for Shiruku
$srkEnv->appPath = '.';

// env vars for storage path of site data in normal file format
$srkEnv->penPath = $srkEnv->appPath.'/../myfolder/pen';

// limitations
$srkEnv->maxFileSize = 1 << 24; // max file size allowed to be stored

// env vars for views and pages
$srkEnv->uiType = (isMobile() ? '/mobile' : '/desktop');
$srkEnv->viewsPath = $srkEnv->appPath.'/views'.$srkEnv->uiType;
$srkEnv->pageTitle = 'Shiruku';
$srkEnv->pageTitleAppend = ' - laekov';
$srkEnv->stylesheets = Array();	
$srkEnv->javascripts = Array();
$srkEnv->dependViews = Array();

// env vars for resources 
$srkEnv->resPath = $srkEnv->appPath.'/../myfolder/resources';

// env vars for mysql database
$srkEnv->sqlURI = 'localhost';
$srkEnv->sqlUser = 'orzmhy';
$srkEnv->sqlPasswd = '2333';
$srkEnv->sqlDatabase = 'shiruku_db';

