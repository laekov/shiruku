<?php
if (!defined('srkVersion')) {
	exit(403);
}

function srkDBConnect() {
	global $srkEnv;
	$srkEnv->sqlCon = new mysqli($srkEnv->sqlURI, $srkEnv->sqlUser, $srkEnv->sqlPasswd);
	if ($srkEnv->sqlCon->errno) {
		return false;
	}
	else {
		$srkEnv->sqlCon->select_db($srkEnv->sqlDatabase);
		if ($srkEnv->sqlCon->errno) {
			return false;
		}
		return $srkEnv->sqlCon;
	}
}

function srkDBClose() {
	if ($srkEnv->sqlCon) {
		$srkEnv->sqlCon->close();
		unset($srkEnv->sqlCon);
	}
}

function srkDBGetData($tableName, $keyName, $keyValue) {
	$db = srkDBConnect();
	if ($db) {
		$queryStr = 'SELECT * FROM '.$tableName.' WHERE '.$keyName.' = \''.$keyValue.'\'';
		$arr = $db->query($queryStr)->fetch_array();
		srkDBClose();
		return $arr;
	}
	else {
		return false;
	}
}

function srkVisitCountGet($penId) {
	$data = srkDBGetData('penVisitCount', 'penId', $penId);
	if ($data != false) {
		return $data['value'];
	}
	else {
		return false;
	}
}

// increase visit count for a certain pen (or index) by one
function srkVisitCountUpdate($penId) {
	$prevVal = srkVisitCountGet($penId);
	$queryStr = '';
	if ($prevVal === false) {
		$queryStr = 'INSERT INTO penVisitCount VALUES ( \''.$penId.'\', 1 )';
	}
	else {
		$queryStr = 'UPDATE penVisitCount SET value = '.($prevVal + 1).' WHERE penId = \''.$penId.'\'';
	}
	$db = srkDBConnect();
	if ($db) {
		$res = $db->query($queryStr);
		srkDBClose();
	}
	return $res;
}

