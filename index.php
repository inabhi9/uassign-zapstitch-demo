<?php 
include_once 'session.php'; 
include_once 'connectors/DropboxConnector.php';
include_once 'connectors/GdriveConnector.php';
?>

<?php $connectBaseUrl = "http://localhost/playground/zapstitch-demo/connect.php" ?>
<?php $DisconnectBaseUrl = "http://localhost/playground/zapstitch-demo/disconnect.php" ?>
<?php $ddConnectUrl = "$connectBaseUrl?service=dropbox" ?>
<?php $ddDisconnectUrl = "$DisconnectBaseUrl?service=dropbox" ?>
<?php $gdConnectUrl = "$connectBaseUrl?service=gdrive" ?>
<?php $gdDisconnectUrl = "$DisconnectBaseUrl?service=gdrive" ?>

<?php include 'view.php'?>
