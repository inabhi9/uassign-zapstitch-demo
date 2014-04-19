<?php
include_once 'session.php';
include_once 'connectors/DropboxConnector.php';
include_once 'connectors/GdriveConnector.php';
include_once 'config.php';

$service = $_GET['service'];

if ($service == "dropbox"){
	$appKey = $config['dropbox']['appKey'];
	$appSecret = $config['dropbox']['appSecret'];
	$rU = $config['dropbox']['redirectUri'];
	
	$dropboxConnector = new DropboxConnector($appKey, $appSecret, $rU, 'zapstitch-demo/1.0');
	
	try{
		$dropboxConnector->connectFinish();
		header("location: index.php");
	} catch (DropboxException $ex){
		$dropboxConnector->connect();
	}
} else if ($service == "gdrive"){
	$clientId = $config['gdrive']['clientId'];
	$clientSecret = $config['gdrive']['clientSecret'];
	$rU = $config['gdrive']['redirectUri'];
	
	$gdriveConnector = new GdriveConnector($clientId, $clientSecret, $rU);
	try{
		$gdriveConnector->connectFinish();
		header("location: index.php");
	} catch (GdriveException $ex){
		$gdriveConnector->connect();
	}
}