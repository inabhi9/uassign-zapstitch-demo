<?php 
include_once 'session.php';
include 'connectors/DropboxConnector.php';
include 'connectors/GdriveConnector.php';
?>

<?php 

$service = $_GET['service'];

if ($service == "dropbox"){
	DropboxConnector::disconnect();
} else if ($service == "gdrive"){
	GdriveConnector::disconnect();
}
header("location: index.php");
?>