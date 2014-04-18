<?php
include 'session.php';
include 'connectors/DropboxConnector.php';
include 'connectors/GdriveConnector.php';

$appKey = '2zy6r4a4ycfpfrv';
$appSecret = '39x02dv0vhzpqc5';
$rU = 'http://localhost/playground/zapstitch-demo/connect.php?service=dropbox';

$service = $_GET['service'];

if ($service == "dropbox"){
	$dropboxConnector = new DropboxConnector($appKey, $appSecret, $rU, 'zapstitch-demo/1.0');
	
	try{
		$dropboxConnector->connectFinish();
		header("location: index.php");
	} catch (DropboxException $ex){
		$dropboxConnector->connect();
	}
} else if ($service == "gdrive"){
	$clientId = "164477918055.apps.googleusercontent.com";
	$clientSecret = "xv4GumtfKL5eZ9yDKAG11042";
	$rU = 'http://localhost/playground/zapstitch-demo/connect.php?service=gdrive';
	$gdriveConnector = new GdriveConnector($clientId, $clientSecret, $rU);
	try{
		$gdriveConnector->connectFinish();
		header("location: index.php");
	} catch (GdriveException $ex){
		$gdriveConnector->connect();
	}
}