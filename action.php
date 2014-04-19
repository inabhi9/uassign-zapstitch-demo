<?php
include 'session.php';
include 'connectors/DropboxConnector.php';
include 'connectors/GdriveConnector.php';


$gdriveConnector = new GdriveConnector(null, null, null);
$dropboxConnector = new DropboxConnector(null, null, null, 'zapstitch-demo/1.0');



function copyFirstFile(){
	global $gdriveConnector, $dropboxConnector;
	$isFileFound = false;
	$dirToLookup = '/Public'; // browse this directory to get a file
	// Download file if found in user's home directory
	foreach ($dropboxConnector->listFolders($dirToLookup) as $item){
		if ($item['is_dir'] != 1){
			$out = $dropboxConnector->downloadFile($item['path'], '/tmp');
			$isFileFound = true;
			break;
		}
	}
	
	// uploading file if found else create noname blank file
	$fname = 'noname.cpp';
	if ($isFileFound == true){
		$uploadName = explode('.n3w.', $out);
		$fname = basename($uploadName[0]);
		$gdriveConnector->uploadFile($out, $fname);
	} else {
		$gdriveConnector->createBlankFile($fname, '');
	}
	
	$resp = array("msg"=>"$fname copied successfully", "type"=>"success");
	die(json_encode($resp));
}

$action = $_GET['action'];
call_user_func($action);