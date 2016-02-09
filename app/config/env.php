<?php
require_once('./modules/toolkit.php');

$srkEnv = (Object)Array();

// basic envrionment variables for Shiruku
$srkEnv->appPath = '.';

// env vars for storage path of site data in normal file format
$srkEnv->penPath = $srkEnv->appPath.'/../myfolder_local/pen';

// limitations
$srkEnv->maxFileSize = 1 << 24; // max file size allowed to be stored

// env vars for views and pages
$srkEnv->uiType = (isMobile() ? '/mobile' : '/desktop');
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
$srkEnv->sqlUser = 'qdm125056326';
$srkEnv->sqlPasswd = 'hjanaive';
$srkEnv->sqlDatabase = 'qdm125056326_db';

