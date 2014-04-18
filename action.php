<?php
include 'session.php';
include 'connectors/DropboxConnector.php';
include 'connectors/GdriveConnector.php';


$gdriveConnector = new GdriveConnector(null, null, null);

//$gdriveConnector->uploadFile('/tmp/a.json', '/');
$gdriveConnector->createBlankFile('nofile.cpp', '');